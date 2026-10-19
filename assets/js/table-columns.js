(function () {
    if (!window.wp || !wp.hooks || !wp.blocks || !wp.element || !wp.compose || !wp.blockEditor || !wp.components) {
        return;
    }

    var MIN_COL = 10;
    var MAX_COLS = 6;
    var addFilter = wp.hooks.addFilter;
    var createHigherOrderComponent = wp.compose.createHigherOrderComponent;
    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var RangeControl = wp.components.RangeControl;
    var Button = wp.components.Button;

    function addColumnWidthAttribute(settings) {
        settings.attributes = Object.assign({}, settings.attributes, {
            columnWidths: {
                type: 'array',
                default: [],
            },
        });
        return settings;
    }

    addFilter('blocks.registerBlockType', 'mytheme/table-column-widths', function (settings, name) {
        if (name !== 'core/table') {
            return settings;
        }
        return addColumnWidthAttribute(settings);
    });

    var registered = wp.blocks.getBlockType('core/table');
    if (registered && !registered.attributes.columnWidths) {
        addColumnWidthAttribute(registered);
    }

    addFilter('blocks.getBlockAttributes', 'mytheme/table-column-widths', function (blockAttributes, blockType, innerHTML, attributes) {
        if (!blockType || blockType.name !== 'core/table' || !attributes || !Array.isArray(attributes.columnWidths)) {
            return blockAttributes;
        }
        blockAttributes.columnWidths = attributes.columnWidths;
        return blockAttributes;
    });

    function sectionRows(attributes, name) {
        return Array.isArray(attributes[name]) ? attributes[name] : [];
    }

    function cellSpan(cell, key) {
        var span = parseInt(cell && cell[key], 10);
        return span > 1 ? span : 1;
    }

    function hasMergedCells(attributes) {
        var sections = ['head', 'body', 'foot'];
        for (var s = 0; s < sections.length; s++) {
            var rows = sectionRows(attributes, sections[s]);
            for (var r = 0; r < rows.length; r++) {
                var cells = rows[r].cells || [];
                for (var c = 0; c < cells.length; c++) {
                    if (cellSpan(cells[c], 'colspan') > 1 || cellSpan(cells[c], 'rowspan') > 1) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    function columnCount(attributes) {
        var head = sectionRows(attributes, 'head');
        var body = sectionRows(attributes, 'body');
        var cells = (head[0] && head[0].cells) || (body[0] && body[0].cells) || [];
        var count = 0;
        cells.forEach(function (cell) {
            count += cellSpan(cell, 'colspan');
        });
        return count;
    }

    function columnLabels(attributes, count) {
        var head = sectionRows(attributes, 'head');
        var cells = (head[0] && head[0].cells) || [];
        var labels = [];
        cells.forEach(function (cell) {
            var text = String(cell.content || '').replace(/<[^>]*>/g, '').replace(/\s+/g, ' ').trim();
            var span = cellSpan(cell, 'colspan');
            for (var i = 0; i < span; i++) {
                labels.push(text);
            }
        });
        while (labels.length < count) {
            labels.push('');
        }
        return labels.slice(0, count).map(function (label, index) {
            var name = label || ('列 ' + (index + 1));
            return name.length > 18 ? name.slice(0, 18) + '…' : name;
        });
    }

    function equalWidths(count) {
        var widths = [];
        var used = 0;
        var base = Math.floor(100 / count);
        for (var i = 0; i < count; i++) {
            var width = i === count - 1 ? 100 - used : base;
            widths.push(width);
            used += width;
        }
        return widths;
    }

    function sumWidths(values) {
        return values.reduce(function (total, value) {
            return total + value;
        }, 0);
    }

    function normalizeWidths(values) {
        var count = values.length;
        var scaled = values.map(function (value) {
            return Math.max(MIN_COL, Number(value) || MIN_COL);
        });
        var sum = sumWidths(scaled);
        if (Math.abs(sum - 100) > 0.01) {
            var flexible = [];
            scaled.forEach(function (value, index) {
                if (value > MIN_COL + 0.01) {
                    flexible.push({ index: index, extra: value - MIN_COL });
                }
            });
            var remain = 100 - MIN_COL * count;
            var flexSum = flexible.reduce(function (total, item) {
                return total + item.extra;
            }, 0);
            var used = 0;
            scaled = scaled.map(function () {
                return MIN_COL;
            });
            flexible.forEach(function (item, flexIndex) {
                var extra = flexIndex === flexible.length - 1
                    ? remain - used
                    : (flexSum > 0 ? item.extra / flexSum * remain : 0);
                if (flexIndex !== flexible.length - 1) {
                    used += extra;
                }
                scaled[item.index] += extra;
            });
        }
        scaled = scaled.map(function (value) {
            return Math.round(value);
        });
        var drift = 100 - sumWidths(scaled);
        var guard = 0;
        while (drift !== 0 && guard < count * 2) {
            guard++;
            var target = 0;
            scaled.forEach(function (value, index) {
                if (drift > 0 && value > scaled[target]) {
                    target = index;
                }
                if (drift < 0 && value > MIN_COL && (scaled[target] <= MIN_COL || value > scaled[target])) {
                    target = index;
                }
            });
            if (drift < 0 && scaled[target] <= MIN_COL) {
                break;
            }
            var step = drift > 0 ? 1 : -1;
            scaled[target] += step;
            drift -= step;
        }
        return scaled;
    }

    function setColumnWidth(widths, index, next) {
        var count = widths.length;
        var max = 100 - MIN_COL * (count - 1);
        next = Math.round(Number(next));
        if (next < MIN_COL) {
            next = MIN_COL;
        }
        if (next > max) {
            next = max;
        }
        var othersSum = 0;
        widths.forEach(function (width, widthIndex) {
            if (widthIndex !== index) {
                othersSum += width;
            }
        });
        var remain = 100 - next;
        var raw = widths.map(function (width, widthIndex) {
            if (widthIndex === index) {
                return next;
            }
            return othersSum > 0 ? remain * (width / othersSum) : remain / (count - 1);
        });
        return normalizeWidths(raw);
    }

    function validWidths(widths, count) {
        if (!Array.isArray(widths) || widths.length !== count) {
            return null;
        }
        var clean = [];
        for (var i = 0; i < widths.length; i++) {
            var width = Math.round(Number(widths[i]));
            if (!width || width < 1 || width > 100) {
                return null;
            }
            clean.push(width);
        }
        return clean;
    }

    function widthStyle(widths) {
        var style = {};
        widths.forEach(function (width, index) {
            style['--mytheme-col-' + (index + 1)] = width + '%';
        });
        return style;
    }

    var withColumnWidthControls = createHigherOrderComponent(function (BlockEdit) {
        return function (props) {
            if (props.name !== 'core/table') {
                return el(BlockEdit, props);
            }

            var count = columnCount(props.attributes);
            var stored = Array.isArray(props.attributes.columnWidths) ? props.attributes.columnWidths : [];
            var active = validWidths(stored, count);
            var shown = active || equalWidths(Math.max(count, 1));
            var labels = columnLabels(props.attributes, count);
            var controls = null;

            if (count > 1 && count <= MAX_COLS && !hasMergedCells(props.attributes)) {
                controls = el(
                    InspectorControls,
                    null,
                    el(
                        PanelBody,
                        { title: '列の幅', initialOpen: false },
                        el(
                            'p',
                            { style: { marginTop: 0, color: '#50575e', fontSize: '12px', lineHeight: 1.6 } },
                            '合計が100%になるように動きます。狭い画面では、これまでどおり1行ずつカードで表示します。'
                        ),
                        labels.map(function (label, index) {
                            return el(RangeControl, {
                                key: 'col-' + index,
                                label: (index + 1) + '. ' + label,
                                value: shown[index],
                                min: MIN_COL,
                                max: 100 - MIN_COL * (count - 1),
                                step: 1,
                                __nextHasNoMarginBottom: true,
                                __next40pxDefaultSize: true,
                                onChange: function (value) {
                                    if (value === undefined || value === null) {
                                        return;
                                    }
                                    var base = active ? active.slice() : equalWidths(count);
                                    props.setAttributes({ columnWidths: setColumnWidth(base, index, value) });
                                },
                            });
                        }),
                        stored.length ? el(
                            'div',
                            { style: { marginTop: '12px' } },
                            el(Button, {
                                variant: 'secondary',
                                onClick: function () {
                                    props.setAttributes({ columnWidths: [] });
                                },
                            }, '幅を自動に戻す')
                        ) : null
                    )
                );
            }

            return el(Fragment, null, el(BlockEdit, props), controls);
        };
    }, 'mythemeTableColumnWidths');

    addFilter('editor.BlockEdit', 'mytheme/table-column-widths', withColumnWidthControls);

    var withColumnWidthStyle = createHigherOrderComponent(function (BlockListBlock) {
        return function (props) {
            if (props.name !== 'core/table') {
                return el(BlockListBlock, props);
            }
            var count = columnCount(props.attributes);
            var active = validWidths(props.attributes.columnWidths, count);
            if (!active || hasMergedCells(props.attributes)) {
                return el(BlockListBlock, props);
            }
            var previous = props.wrapperProps || {};
            var wrapperProps = Object.assign({}, previous, {
                className: ((previous.className || '') + ' mytheme-has-column-widths').trim(),
                style: Object.assign({}, previous.style || {}, widthStyle(active)),
            });
            return el(BlockListBlock, Object.assign({}, props, { wrapperProps: wrapperProps }));
        };
    }, 'mythemeTableColumnWidthStyle');

    addFilter('editor.BlockListBlock', 'mytheme/table-column-widths', withColumnWidthStyle);
})();
