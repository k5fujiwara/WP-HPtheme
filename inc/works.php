<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$mytheme_work_seed_content_path = get_template_directory() . '/inc/work-seed-content.php';
if ( file_exists($mytheme_work_seed_content_path) ) {
    require_once $mytheme_work_seed_content_path;
}

/**
 * 開発作品（work）投稿タイプ
 */
function mytheme_register_work_cpt() {
    $html_template = <<<'HTML'
<div class="project-content">
<section class="project-section">
    <h2 class="project-section__title">プロジェクト概要</h2>
    <p class="project-section__text"></p>
</section>

<section class="project-section">
    <h2 class="project-section__title">開発目的</h2>
    <ul class="feature-list">
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
    </ul>
</section>

<section class="project-section">
    <h2 class="project-section__title">使用技術</h2>
    <h3 class="tech-category">フロントエンド</h3>
    <div class="tech-stack">
        <span class="tech-tag"></span>
        <span class="tech-tag"></span>
        <span class="tech-tag"></span>
    </div>
    <h3 class="tech-category">バックエンド / 外部サービス</h3>
    <div class="tech-stack">
        <span class="tech-tag"></span>
        <span class="tech-tag"></span>
        <span class="tech-tag"></span>
    </div>
</section>

<section class="project-section">
    <h2 class="project-section__title">主な機能</h2>
    <ul class="feature-list">
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
    </ul>
</section>

<section class="project-section">
    <h2 class="project-section__title">システム構成 / 処理の流れ</h2>
    <p class="project-section__text"></p>
</section>

<section class="project-section">
    <h2 class="project-section__title">工夫した点</h2>
    <ul class="feature-list">
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
    </ul>
</section>

<section class="project-section">
    <h2 class="project-section__title">苦労した点 / 改善した点</h2>
    <p class="project-section__text"></p>
</section>

<section class="project-section" id="demo-video">
    <h2 class="project-section__title">デモ動画</h2>
    <p class="project-section__text"></p>
    <div class="video-container">
        <iframe class="video-container__iframe" src="" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
    </div>
</section>

<section class="project-section">
    <h2 class="project-section__title">今後の改善</h2>
    <ul class="feature-list">
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
    </ul>
</section>

<section class="project-section">
    <h2 class="project-section__title">開発情報</h2>
    <div class="project-info-grid">
        <div class="info-item">
            <h3 class="info-item__title">開発形態</h3>
            <p class="info-item__text"></p>
        </div>
        <div class="info-item">
            <h3 class="info-item__title">担当範囲</h3>
            <p class="info-item__text"></p>
        </div>
        <div class="info-item">
            <h3 class="info-item__title">制作期間</h3>
            <p class="info-item__text"></p>
        </div>
    </div>
</section>

<section class="project-section">
    <h2 class="project-section__title">謝辞</h2>
    <ul class="feature-list">
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
        <li class="feature-list__item"></li>
    </ul>
</section>
</div>
HTML;

    $editor_template = [
        [
            'core/html',
            ['content' => $html_template],
        ],
    ];

    register_post_type('work', [
        'labels' => [
            'name'               => '開発作品',
            'singular_name'      => '開発作品',
            'add_new'            => '新規追加',
            'add_new_item'       => '開発作品を追加',
            'edit_item'          => '開発作品を編集',
            'new_item'           => '新しい開発作品',
            'view_item'          => '開発作品を表示',
            'search_items'       => '開発作品を検索',
            'not_found'          => '開発作品が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に開発作品はありません',
            'menu_name'          => '開発作品',
        ],
        'public'              => true,
        'has_archive'         => false,
        'rewrite'             => ['slug' => 'works', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 24,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'template'            => $editor_template,
        'template_lock'       => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);
}
add_action('init', 'mytheme_register_work_cpt', 9);

function mytheme_work_add_rewrite_rules() {
    add_rewrite_rule('^works/([^/]+)/?$', 'index.php?post_type=work&name=$matches[1]', 'top');
}
add_action('init', 'mytheme_work_add_rewrite_rules', 10);

function mytheme_get_legacy_work_child_page_paths() {
    return [
        'works/loto6',
        'works/auto-typing',
        'works/quest4',
        'works/beengineer-camp',
    ];
}

function mytheme_work_meta_fields() {
    $fields = [
        '_mytheme_work_card_image_id',
        '_mytheme_work_card_image_path',
        '_mytheme_work_card_image_alt',
        '_mytheme_work_card_description',
        '_mytheme_work_show_hero_image',
        '_mytheme_work_tech_tags',
        '_mytheme_work_demo_url',
        '_mytheme_work_external_url',
    ];

    for ( $i = 1; $i <= 3; $i++ ) {
        $fields[] = '_mytheme_work_gallery_' . $i . '_image_id';
        $fields[] = '_mytheme_work_gallery_' . $i . '_image_path';
        $fields[] = '_mytheme_work_gallery_' . $i . '_image_alt';
        $fields[] = '_mytheme_work_gallery_' . $i . '_caption';
    }

    return $fields;
}

function mytheme_get_work_meta($post_id, $key, $default = '') {
    $value = get_post_meta((int) $post_id, (string) $key, true);
    return $value !== '' ? $value : $default;
}

function mytheme_get_work_tech_tags($post_id) {
    $raw = (string) mytheme_get_work_meta($post_id, '_mytheme_work_tech_tags');
    if ( $raw === '' ) return [];

    $items = preg_split('/[\r\n,、]+/u', $raw);
    $items = array_map('trim', is_array($items) ? $items : []);
    $items = array_filter($items, function($item) {
        return $item !== '';
    });

    return array_values(array_unique($items));
}

function mytheme_work_sanitize_url_or_anchor($value) {
    $value = trim((string) $value);
    if ( $value === '' ) return '';

    if ( strpos($value, '#') === 0 ) {
        return sanitize_text_field($value);
    }

    return esc_url_raw($value);
}

function mytheme_get_work_detail_url($post_id) {
    return get_permalink((int) $post_id);
}

function mytheme_work_is_safe_asset_path($path) {
    $path = ltrim(trim((string) $path), '/');
    return $path !== '' && strpos($path, '..') === false;
}

function mytheme_work_get_attachment_image_html($attachment_id, $class, $alt = '', $size = 'large') {
    $attachment_id = (int) $attachment_id;
    if ( $attachment_id <= 0 ) return '';

    return wp_get_attachment_image($attachment_id, $size, false, [
        'class' => (string) $class,
        'alt'   => (string) $alt,
    ]);
}

function mytheme_get_work_gallery_items($post_id) {
    $post_id = (int) $post_id;
    $items = [];

    for ( $i = 1; $i <= 3; $i++ ) {
        $attachment_id = (int) mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_image_id', 0);
        $path = mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_image_path');
        if ( $attachment_id <= 0 && ! mytheme_work_is_safe_asset_path($path) ) {
            continue;
        }

        $caption = mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_caption');
        $alt = mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_image_alt');
        if ( $alt === '' ) {
            $alt = $caption !== '' ? $caption : get_the_title($post_id);
        }

        $items[] = [
            'attachment_id' => $attachment_id,
            'path'    => ltrim((string) $path, '/'),
            'alt'     => (string) $alt,
            'caption' => (string) $caption,
        ];
    }

    return $items;
}

function mytheme_render_work_gallery($post_id) {
    $items = mytheme_get_work_gallery_items($post_id);
    if ( empty($items) ) return;

    $classes = ['project-gallery'];
    if ( count($items) === 1 ) {
        $classes[] = 'project-gallery--single';
    }
    ?>
    <div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
        <?php foreach ( $items as $item ) : ?>
            <div class="gallery-item">
                <?php if ( ! empty($item['attachment_id']) ) : ?>
                    <?php echo mytheme_work_get_attachment_image_html((int) $item['attachment_id'], 'gallery-item__image', $item['alt']); ?>
                <?php elseif ( function_exists('mytheme_picture_tag') ) : ?>
                    <?php echo mytheme_picture_tag($item['path'], $item['alt'], 'gallery-item__image', 'lazy'); ?>
                <?php else : ?>
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/' . $item['path']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" class="gallery-item__image" loading="lazy">
                <?php endif; ?>
                <?php if ( $item['caption'] !== '' ) : ?>
                    <p class="gallery-caption"><?php echo esc_html($item['caption']); ?></p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

function mytheme_work_image_shortcode($atts) {
    $atts = shortcode_atts([
        'path'    => '',
        'alt'     => '',
        'class'   => '',
        'loading' => 'lazy',
    ], $atts, 'theme_image');

    $path = ltrim((string) $atts['path'], '/');
    if ( ! mytheme_work_is_safe_asset_path($path) ) {
        return '';
    }

    $alt = (string) $atts['alt'];
    $class = (string) $atts['class'];
    $loading = (string) $atts['loading'];

    if ( function_exists('mytheme_picture_tag') ) {
        return mytheme_picture_tag($path, $alt, $class, $loading);
    }

    return '<img src="' . esc_url(get_template_directory_uri() . '/' . $path) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($class) . '" loading="' . esc_attr($loading) . '">';
}
add_shortcode('theme_image', 'mytheme_work_image_shortcode');

function mytheme_work_split_lines($value) {
    $lines = preg_split('/\R/u', (string) $value);
    $lines = is_array($lines) ? array_map('trim', $lines) : [];
    return array_values(array_filter($lines, function($line) {
        return $line !== '';
    }));
}

function mytheme_work_split_terms($value) {
    $items = preg_split('/[\r\n,、]+/u', (string) $value);
    $items = is_array($items) ? array_map('trim', $items) : [];
    $items = array_values(array_filter($items, function($item) {
        return $item !== '';
    }));

    return array_values(array_unique($items));
}

function mytheme_work_get_detail_field($post_id, $key) {
    return (string) get_post_meta((int) $post_id, '_mytheme_work_detail_' . (string) $key, true);
}

function mytheme_work_has_structured_detail($post_id) {
    $keys = [
        'overview',
        'purpose',
        'tech_language',
        'tech_frontend',
        'tech_backend',
        'features',
        'system_text',
        'system_flow',
        'efforts',
        'highlights',
        'highlight_1_title',
        'highlight_1_code',
        'highlight_2_title',
        'highlight_2_code',
        'highlight_3_title',
        'highlight_3_code',
        'dev_type',
        'dev_role',
        'dev_period',
        'cautions',
        'caution_intro',
        'caution_1_title',
        'caution_1_items',
        'caution_2_title',
        'caution_2_items',
        'caution_3_title',
        'caution_3_items',
        'demo_description',
        'demo_embed_url',
        'thanks',
    ];

    foreach ( $keys as $key ) {
        if ( trim(mytheme_work_get_detail_field($post_id, $key)) !== '' ) {
            return true;
        }
    }

    return false;
}

function mytheme_work_render_feature_list($items) {
    $items = array_values(array_filter((array) $items, function($item) {
        return trim((string) $item) !== '';
    }));
    if ( empty($items) ) return;
    ?>
    <ul class="feature-list">
        <?php foreach ( $items as $item ) : ?>
            <li class="feature-list__item"><?php echo wp_kses_post((string) $item); ?></li>
        <?php endforeach; ?>
    </ul>
    <?php
}

function mytheme_work_render_tech_stack($title, $items) {
    $items = mytheme_work_split_terms($items);
    if ( empty($items) ) return;
    ?>
    <h3 class="tech-category"><?php echo esc_html((string) $title); ?></h3>
    <div class="tech-stack">
        <?php foreach ( $items as $item ) : ?>
            <span class="tech-tag"><?php echo esc_html($item); ?></span>
        <?php endforeach; ?>
    </div>
    <?php
}

function mytheme_work_get_code_highlights($post_id) {
    $post_id = (int) $post_id;
    $items = [];

    for ( $i = 1; $i <= 3; $i++ ) {
        $title = mytheme_work_get_detail_field($post_id, 'highlight_' . $i . '_title');
        $code = mytheme_work_get_detail_field($post_id, 'highlight_' . $i . '_code');

        if ( trim($title) === '' && trim($code) === '' ) {
            continue;
        }

        $items[] = [
            'title' => trim($title) !== '' ? trim($title) : '技術的ハイライト ' . $i,
            'code'  => (string) $code,
        ];
    }

    return $items;
}

function mytheme_work_render_code_highlights($items) {
    foreach ( (array) $items as $item ) :
        $title = isset($item['title']) ? (string) $item['title'] : '';
        $code = isset($item['code']) ? (string) $item['code'] : '';
        if ( trim($title) === '' && trim($code) === '' ) continue;
        ?>
        <?php if ( trim($title) !== '' ) : ?>
            <h3 class="feature-heading"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>
        <?php if ( trim($code) !== '' ) : ?>
            <div class="code-block">
                <pre class="code-block__pre"><code class="code-block__code"><?php echo esc_html($code); ?></code></pre>
            </div>
        <?php endif; ?>
    <?php
    endforeach;
}

function mytheme_work_get_caution_groups($post_id) {
    $post_id = (int) $post_id;
    $groups = [];

    for ( $i = 1; $i <= 3; $i++ ) {
        $title = mytheme_work_get_detail_field($post_id, 'caution_' . $i . '_title');
        $items = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'caution_' . $i . '_items'));

        if ( trim($title) === '' && empty($items) ) {
            continue;
        }

        $groups[] = [
            'title' => trim((string) $title),
            'items' => $items,
        ];
    }

    return $groups;
}

function mytheme_work_render_caution_groups($groups) {
    foreach ( (array) $groups as $group ) :
        $title = isset($group['title']) ? trim((string) $group['title']) : '';
        $items = isset($group['items']) ? (array) $group['items'] : [];
        if ( $title === '' && empty($items) ) continue;
        ?>
        <?php if ( $title !== '' ) : ?>
            <p class="disclaimer-box__text" style="margin-top: 16px;"><strong><?php echo esc_html($title); ?></strong></p>
        <?php endif; ?>
        <?php mytheme_work_render_feature_list($items); ?>
    <?php
    endforeach;
}

function mytheme_work_is_flow_arrow_line($line) {
    $line = trim((string) $line);
    return $line === '↓' || strpos($line, '↓') === 0 || strpos($line, '->') === 0 || strpos($line, '→') === 0;
}

function mytheme_work_normalize_flow_arrow_label($line) {
    $line = trim((string) $line);
    $line = preg_replace('/^(↓|->|→)\s*/u', '', $line);
    $line = trim((string) $line);
    return $line !== '' ? '↓ ' . $line : '↓';
}

function mytheme_work_to_youtube_embed_url($url) {
    $url = trim((string) $url);
    if ( $url === '' ) return '';
    if ( strpos($url, 'youtube.com/embed/') !== false ) return esc_url($url);

    $id = '';
    $parts = wp_parse_url($url);
    if ( is_array($parts) ) {
        $host = isset($parts['host']) ? (string) $parts['host'] : '';
        $path = isset($parts['path']) ? trim((string) $parts['path'], '/') : '';
        if ( strpos($host, 'youtu.be') !== false ) {
            $id = $path;
        } elseif ( strpos($host, 'youtube.com') !== false ) {
            if ( strpos($path, 'shorts/') === 0 ) {
                $id = substr($path, 7);
            } elseif ( ! empty($parts['query']) ) {
                parse_str((string) $parts['query'], $query);
                $id = isset($query['v']) ? (string) $query['v'] : '';
            }
        }
    }

    $id = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $id);
    return $id !== '' ? 'https://www.youtube.com/embed/' . $id : esc_url($url);
}

function mytheme_render_work_structured_detail($post_id) {
    $post_id = (int) $post_id;

    $overview = mytheme_work_get_detail_field($post_id, 'overview');
    $purpose = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'purpose'));
    $features = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'features'));
    $system_text = mytheme_work_get_detail_field($post_id, 'system_text');
    $system_flow = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'system_flow'));
    $efforts = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'efforts'));
    $highlights = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'highlights'));
    $code_highlights = mytheme_work_get_code_highlights($post_id);
    $cautions = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'cautions'));
    $caution_intro = mytheme_work_get_detail_field($post_id, 'caution_intro');
    $caution_groups = mytheme_work_get_caution_groups($post_id);
    $thanks = mytheme_work_split_lines(mytheme_work_get_detail_field($post_id, 'thanks'));
    $demo_description = mytheme_work_get_detail_field($post_id, 'demo_description');
    $demo_embed_url = mytheme_work_to_youtube_embed_url(mytheme_work_get_detail_field($post_id, 'demo_embed_url'));
    $dev_type = mytheme_work_get_detail_field($post_id, 'dev_type');
    $dev_role = mytheme_work_get_detail_field($post_id, 'dev_role');
    $dev_period = mytheme_work_get_detail_field($post_id, 'dev_period');
    ?>
    <div class="project-content">
        <?php if ( trim($overview) !== '' ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">プロジェクト概要</h2>
                <p class="project-section__text"><?php echo wp_kses_post($overview); ?></p>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($purpose) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <?php mytheme_work_render_feature_list($purpose); ?>
            </section>
        <?php endif; ?>

        <?php
        $has_tech = trim(mytheme_work_get_detail_field($post_id, 'tech_language')) !== ''
            || trim(mytheme_work_get_detail_field($post_id, 'tech_frontend')) !== ''
            || trim(mytheme_work_get_detail_field($post_id, 'tech_backend')) !== '';
        ?>
        <?php if ( $has_tech ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                <?php mytheme_work_render_tech_stack('プログラミング言語', mytheme_work_get_detail_field($post_id, 'tech_language')); ?>
                <?php mytheme_work_render_tech_stack('フロントエンド', mytheme_work_get_detail_field($post_id, 'tech_frontend')); ?>
                <?php mytheme_work_render_tech_stack('バックエンド / 外部サービス', mytheme_work_get_detail_field($post_id, 'tech_backend')); ?>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($features) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>
                <?php mytheme_work_render_feature_list($features); ?>
            </section>
        <?php endif; ?>

        <?php if ( trim($system_text) !== '' || ! empty($system_flow) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <?php if ( trim($system_text) !== '' ) : ?>
                    <p class="project-section__text"><?php echo wp_kses_post($system_text); ?></p>
                <?php endif; ?>
                <?php if ( ! empty($system_flow) ) : ?>
                    <div class="system-architecture">
                        <h3 class="system-architecture__title">データフロー</h3>
                        <div class="dataflow">
                            <?php foreach ( $system_flow as $index => $item ) : ?>
                                <?php if ( mytheme_work_is_flow_arrow_line($item) ) : ?>
                                    <div class="flow-arrow"><?php echo esc_html(mytheme_work_normalize_flow_arrow_label($item)); ?></div>
                                <?php else : ?>
                                    <?php if ( $index > 0 ) : ?>
                                        <?php
                                        $previous = isset($system_flow[$index - 1]) ? (string) $system_flow[$index - 1] : '';
                                        ?>
                                        <?php if ( ! mytheme_work_is_flow_arrow_line($previous) ) : ?>
                                            <div class="flow-arrow">↓</div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <div class="flow-item"><?php echo esc_html($item); ?></div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($efforts) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>
                <?php mytheme_work_render_feature_list($efforts); ?>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($code_highlights) || ! empty($highlights) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>
                <?php if ( ! empty($code_highlights) ) : ?>
                    <?php mytheme_work_render_code_highlights($code_highlights); ?>
                <?php else : ?>
                    <?php mytheme_work_render_feature_list($highlights); ?>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ( trim($dev_type) !== '' || trim($dev_role) !== '' || trim($dev_period) !== '' ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">開発情報</h2>
                <div class="project-info-grid">
                    <?php if ( trim($dev_type) !== '' ) : ?>
                        <div class="info-item">
                            <h3 class="info-item__title">開発形態</h3>
                            <p class="info-item__text"><?php echo esc_html($dev_type); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ( trim($dev_role) !== '' ) : ?>
                        <div class="info-item">
                            <h3 class="info-item__title">役割</h3>
                            <p class="info-item__text"><?php echo esc_html($dev_role); ?></p>
                        </div>
                    <?php endif; ?>
                    <?php if ( trim($dev_period) !== '' ) : ?>
                        <div class="info-item">
                            <h3 class="info-item__title">制作期間</h3>
                            <p class="info-item__text"><?php echo esc_html($dev_period); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($cautions) || trim($caution_intro) !== '' || ! empty($caution_groups) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">開発時の注意事項</h2>
                <div class="disclaimer-box">
                    <?php if ( trim($caution_intro) !== '' ) : ?>
                        <p class="disclaimer-box__text"><strong><?php echo wp_kses_post($caution_intro); ?></strong></p>
                    <?php endif; ?>
                    <?php if ( ! empty($caution_groups) ) : ?>
                        <?php mytheme_work_render_caution_groups($caution_groups); ?>
                    <?php else : ?>
                        <?php mytheme_work_render_feature_list($cautions); ?>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( trim($demo_description) !== '' || $demo_embed_url !== '' ) : ?>
            <section class="project-section" id="demo-video">
                <h2 class="project-section__title">デモ動画</h2>
                <?php if ( trim($demo_description) !== '' ) : ?>
                    <p class="project-section__text"><?php echo wp_kses_post($demo_description); ?></p>
                <?php endif; ?>
                <?php if ( $demo_embed_url !== '' ) : ?>
                    <div class="video-container">
                        <iframe class="video-container__iframe" src="<?php echo esc_url($demo_embed_url); ?>" title="<?php echo esc_attr(get_the_title($post_id) . ' デモ動画'); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
                    </div>
                <?php endif; ?>
            </section>
        <?php endif; ?>

        <?php if ( ! empty($thanks) ) : ?>
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <?php mytheme_work_render_feature_list($thanks); ?>
            </section>
        <?php endif; ?>
    </div>
    <?php
}

function mytheme_work_dom_inner_html($node) {
    $html = '';
    foreach ( $node->childNodes as $child ) {
        $html .= $node->ownerDocument->saveHTML($child);
    }
    return $html;
}

function mytheme_work_section_has_meaningful_content($section) {
    if ( ! ( $section instanceof DOMElement ) ) {
        return true;
    }

    $clone = $section->cloneNode(true);
    $xpath = new DOMXPath($clone->ownerDocument);

    foreach ( $xpath->query('.//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6]', $clone) as $heading ) {
        if ( $heading->parentNode ) {
            $heading->parentNode->removeChild($heading);
        }
    }

    $text = trim(preg_replace('/\s+/u', ' ', (string) $clone->textContent));
    if ( $text !== '' ) {
        return true;
    }

    $content_nodes = $xpath->query('.//*[self::table or self::pre or self::code or self::blockquote]', $clone);
    if ( $content_nodes instanceof DOMNodeList && $content_nodes->length > 0 ) {
        return true;
    }

    $media_nodes = $xpath->query('.//*[self::img or self::iframe or self::video or self::audio or self::source]', $clone);
    if ( $media_nodes instanceof DOMNodeList ) {
        foreach ( $media_nodes as $media ) {
            if ( $media instanceof DOMElement && trim((string) $media->getAttribute('src')) !== '' ) {
                return true;
            }
        }
    }

    $picture_nodes = $xpath->query('.//picture[.//*[self::img or self::source][normalize-space(@src)!="" or normalize-space(@srcset)!=""]]', $clone);
    return $picture_nodes instanceof DOMNodeList && $picture_nodes->length > 0;
}

/**
 * 入力されていないテンプレート項目は、見出しだけ残さず非表示にする。
 */
function mytheme_work_remove_empty_project_sections($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('work') || ! in_the_loop() || ! is_main_query() ) return $content;
    if ( trim((string) $content) === '' ) return $content;
    if ( ! class_exists('DOMDocument') || ! class_exists('DOMXPath') ) return $content;

    $previous = libxml_use_internal_errors(true);
    $dom = new DOMDocument('1.0', 'UTF-8');
    $loaded = $dom->loadHTML('<?xml encoding="utf-8" ?><div id="mytheme-work-content-filter">' . $content . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    libxml_use_internal_errors($previous);

    if ( ! $loaded ) {
        return $content;
    }

    $xpath = new DOMXPath($dom);
    $sections = $xpath->query('//*[contains(concat(" ", normalize-space(@class), " "), " project-section ")]');
    if ( ! ( $sections instanceof DOMNodeList ) || $sections->length === 0 ) {
        return $content;
    }

    $remove = [];
    foreach ( $sections as $section ) {
        if ( $section instanceof DOMElement && ! mytheme_work_section_has_meaningful_content($section) ) {
            $remove[] = $section;
        }
    }

    foreach ( $remove as $section ) {
        if ( $section->parentNode ) {
            $section->parentNode->removeChild($section);
        }
    }

    $wrapper = $dom->getElementById('mytheme-work-content-filter');
    return $wrapper ? mytheme_work_dom_inner_html($wrapper) : $content;
}
add_filter('the_content', 'mytheme_work_remove_empty_project_sections', 30);

function mytheme_work_add_meta_box() {
    add_meta_box(
        'mytheme-work-details',
        '作品カード・画像設定',
        'mytheme_work_render_meta_box',
        'work',
        'normal',
        'high'
    );

    add_meta_box(
        'mytheme-work-detail-content',
        '開発詳細ページ入力',
        'mytheme_work_render_detail_meta_box',
        'work',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes_work', 'mytheme_work_add_meta_box');

function mytheme_work_enqueue_admin_media($hook) {
    if ( ! in_array($hook, ['post.php', 'post-new.php'], true) ) return;

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ( ! $screen || $screen->post_type !== 'work' ) return;

    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'mytheme_work_enqueue_admin_media');

function mytheme_work_render_media_picker_field($name, $attachment_id, $label, $description = '') {
    $attachment_id = (int) $attachment_id;
    $preview = $attachment_id > 0 ? wp_get_attachment_image($attachment_id, 'medium', false, ['style' => 'max-width:160px;height:auto;display:block;margin:8px 0;']) : '';
    ?>
    <div class="mytheme-work-media-field" style="margin:0 0 16px;">
        <strong><?php echo esc_html($label); ?></strong>
        <div class="mytheme-work-media-preview"><?php echo $preview; ?></div>
        <input type="hidden" class="mytheme-work-media-id" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr((string) $attachment_id); ?>">
        <button type="button" class="button mytheme-work-media-select">画像を選択</button>
        <button type="button" class="button mytheme-work-media-clear" <?php disabled($attachment_id <= 0); ?>>画像を解除</button>
        <?php if ( $description !== '' ) : ?>
            <p class="description"><?php echo esc_html($description); ?></p>
        <?php endif; ?>
    </div>
    <?php
}

function mytheme_work_print_media_picker_script() {
    ?>
    <script>
    (function($) {
        $(document).on('click', '.mytheme-work-media-select', function(e) {
            e.preventDefault();
            var $field = $(this).closest('.mytheme-work-media-field');
            var frame = wp.media({
                title: '画像を選択',
                button: { text: 'この画像を使用' },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var previewUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                $field.find('.mytheme-work-media-id').val(attachment.id);
                $field.find('.mytheme-work-media-preview').html('<img src="' + previewUrl + '" style="max-width:160px;height:auto;display:block;margin:8px 0;" alt="">');
                $field.find('.mytheme-work-media-clear').prop('disabled', false);
            });

            frame.open();
        });

        $(document).on('click', '.mytheme-work-media-clear', function(e) {
            e.preventDefault();
            var $field = $(this).closest('.mytheme-work-media-field');
            $field.find('.mytheme-work-media-id').val('');
            $field.find('.mytheme-work-media-preview').empty();
            $(this).prop('disabled', true);
        });
    })(jQuery);
    </script>
    <?php
}

function mytheme_work_render_meta_box($post) {
    $post_id = (int) $post->ID;
    wp_nonce_field('mytheme_work_meta_action', 'mytheme_work_meta_nonce');
    ?>
    <?php mytheme_work_render_media_picker_field('mytheme_work_card_image_id', (int) mytheme_get_work_meta($post_id, '_mytheme_work_card_image_id', 0), 'カード / メイン画像', '一覧カードと詳細ページ上部に使用します。'); ?>
    <?php $show_hero_image = mytheme_get_work_meta($post_id, '_mytheme_work_show_hero_image', '1') !== '0'; ?>
    <p>
        <label>
            <input type="checkbox" name="mytheme_work_show_hero_image" value="1" <?php checked($show_hero_image); ?>>
            詳細ページ上部にもこの画像を表示する
        </label><br>
        <span class="description">一覧カードには常に使用します。画像が大きすぎる・詳細本文内で別途見せたい場合は外してください。</span>
    </p>
    <p>
        <label for="mytheme_work_card_description"><strong>一覧カード説明</strong></label><br>
        <textarea id="mytheme_work_card_description" name="mytheme_work_card_description" rows="3" class="widefat" placeholder="一覧カードに表示する短い説明文を入力します。"><?php echo esc_textarea(mytheme_get_work_meta($post_id, '_mytheme_work_card_description')); ?></textarea>
        <span class="description">未入力の場合は、プロジェクト概要から自動で短く表示します。</span>
    </p>
    <p>
        <label for="mytheme_work_card_image_alt"><strong>画像alt</strong></label><br>
        <input type="text" id="mytheme_work_card_image_alt" name="mytheme_work_card_image_alt" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_card_image_alt')); ?>" class="widefat">
    </p>
    <table class="widefat striped" style="margin:16px 0;">
        <thead>
            <tr>
                <th colspan="4">ギャラリー画像</th>
            </tr>
            <tr>
                <th style="width:70px;">番号</th>
                <th>画像</th>
                <th>alt</th>
                <th>キャプション</th>
            </tr>
        </thead>
        <tbody>
            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                <tr>
                    <td><?php echo esc_html((string) $i); ?></td>
                    <td>
                        <?php mytheme_work_render_media_picker_field('mytheme_work_gallery_' . $i . '_image_id', (int) mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_image_id', 0), 'ギャラリー画像 ' . $i); ?>
                    </td>
                    <td>
                        <input type="text" name="mytheme_work_gallery_<?php echo esc_attr((string) $i); ?>_image_alt" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_image_alt')); ?>" class="widefat">
                    </td>
                    <td>
                        <input type="text" name="mytheme_work_gallery_<?php echo esc_attr((string) $i); ?>_caption" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_gallery_' . $i . '_caption')); ?>" class="widefat">
                    </td>
                </tr>
            <?php endfor; ?>
        </tbody>
    </table>
    <p class="description">画像未選択の行は表示されません。1枚だけ選択した場合は単独表示、2枚以上は通常のギャラリー表示になります。</p>
    <p>
        <label for="mytheme_work_tech_tags"><strong>使用技術</strong></label><br>
        <textarea id="mytheme_work_tech_tags" name="mytheme_work_tech_tags" rows="4" class="widefat" placeholder="Python, Flask, JavaScript"><?php echo esc_textarea(mytheme_get_work_meta($post_id, '_mytheme_work_tech_tags')); ?></textarea>
        <span class="description">カンマ区切り、または改行区切りで入力できます。</span>
    </p>
    <p>
        <label for="mytheme_work_demo_url"><strong>デモURL / アンカー</strong></label><br>
        <input type="text" id="mytheme_work_demo_url" name="mytheme_work_demo_url" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_demo_url')); ?>" class="widefat" placeholder="#demo-video">
    </p>
    <p>
        <label for="mytheme_work_external_url"><strong>外部リンクURL</strong></label><br>
        <input type="url" id="mytheme_work_external_url" name="mytheme_work_external_url" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_external_url')); ?>" class="widefat" placeholder="https://example.com/">
    </p>
    <?php mytheme_work_print_media_picker_script(); ?>
    <?php
}

function mytheme_work_render_textarea_field($post_id, $key, $label, $description = '', $rows = 4) {
    ?>
    <p>
        <label for="mytheme_work_detail_<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($label); ?></strong></label><br>
        <textarea id="mytheme_work_detail_<?php echo esc_attr($key); ?>" name="mytheme_work_detail_<?php echo esc_attr($key); ?>" rows="<?php echo esc_attr((string) $rows); ?>" class="widefat"><?php echo esc_textarea(mytheme_work_get_detail_field($post_id, $key)); ?></textarea>
        <?php if ( $description !== '' ) : ?>
            <span class="description"><?php echo esc_html($description); ?></span>
        <?php endif; ?>
    </p>
    <?php
}

function mytheme_work_render_input_field($post_id, $key, $label, $description = '') {
    ?>
    <p>
        <label for="mytheme_work_detail_<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($label); ?></strong></label><br>
        <input type="text" id="mytheme_work_detail_<?php echo esc_attr($key); ?>" name="mytheme_work_detail_<?php echo esc_attr($key); ?>" value="<?php echo esc_attr(mytheme_work_get_detail_field($post_id, $key)); ?>" class="widefat">
        <?php if ( $description !== '' ) : ?>
            <span class="description"><?php echo esc_html($description); ?></span>
        <?php endif; ?>
    </p>
    <?php
}

function mytheme_work_render_detail_meta_box($post) {
    $post_id = (int) $post->ID;
    ?>
    <p class="description">既存の開発詳細ページと同じデザインになるよう、入力内容をテーマ側で固定レイアウトに変換します。リスト系は1行1項目で入力してください。</p>
    <?php
    mytheme_work_render_textarea_field($post_id, 'overview', 'プロジェクト概要', '本文として表示します。太字など簡単なHTMLは使用できます。', 5);
    mytheme_work_render_textarea_field($post_id, 'purpose', '開発目的', '1行1項目で入力します。', 4);
    mytheme_work_render_textarea_field($post_id, 'tech_language', '使用技術: プログラミング言語', '改行、カンマ、読点（、）のいずれでも個別タグとして表示します。例: Python、Dart', 3);
    mytheme_work_render_textarea_field($post_id, 'tech_frontend', '使用技術: フロントエンド', '改行、カンマ、読点（、）のいずれでも個別タグとして表示します。', 3);
    mytheme_work_render_textarea_field($post_id, 'tech_backend', '使用技術: バックエンド / 外部サービス', '改行、カンマ、読点（、）のいずれでも個別タグとして表示します。', 4);
    mytheme_work_render_textarea_field($post_id, 'features', '主な機能', '1行1項目で入力します。', 5);
    mytheme_work_render_textarea_field($post_id, 'system_text', 'システム構成: 説明文', '必要な場合のみ入力します。', 3);
    mytheme_work_render_textarea_field($post_id, 'system_flow', 'システム構成: 処理の流れ', '1行1ステップで入力します。「↓ CSV出力」のように矢印から始める行は、矢印ラベルとして表示します。', 7);
    mytheme_work_render_textarea_field($post_id, 'efforts', '工夫した点', '1行1項目で入力します。', 5);
    ?>
    <hr>
    <h3>技術的ハイライト</h3>
    <p class="description">見出しとコードを入力すると、既存ページと同じコードブロック表示になります。不要な行は空のままで問題ありません。</p>
    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
        <p>
            <label for="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_title"><strong>技術的ハイライト <?php echo esc_html((string) $i); ?>: 見出し</strong></label><br>
            <input type="text" id="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_title" name="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_title" value="<?php echo esc_attr(mytheme_work_get_detail_field($post_id, 'highlight_' . $i . '_title')); ?>" class="widefat" placeholder="<?php echo esc_attr($i . '. 複数モデルの並列実行'); ?>">
        </p>
        <p>
            <label for="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_code"><strong>技術的ハイライト <?php echo esc_html((string) $i); ?>: コード</strong></label><br>
            <textarea id="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_code" name="mytheme_work_detail_highlight_<?php echo esc_attr((string) $i); ?>_code" rows="5" class="widefat code"><?php echo esc_textarea(mytheme_work_get_detail_field($post_id, 'highlight_' . $i . '_code')); ?></textarea>
        </p>
    <?php endfor; ?>
    <?php
    mytheme_work_render_textarea_field($post_id, 'highlights', '技術的ハイライト: 補足リスト', 'コードブロックを使わず箇条書きで表示したい場合のみ、1行1項目で入力します。', 4);
    mytheme_work_render_input_field($post_id, 'dev_type', '開発情報: 開発形態');
    mytheme_work_render_input_field($post_id, 'dev_role', '開発情報: 役割');
    mytheme_work_render_input_field($post_id, 'dev_period', '開発情報: 制作期間');
    ?>
    <hr>
    <h3>開発時の注意事項</h3>
    <?php
    mytheme_work_render_textarea_field($post_id, 'caution_intro', '開発時の注意事項: 導入文', '黄色の注意ボックス先頭に太字で表示します。', 3);
    for ( $i = 1; $i <= 3; $i++ ) :
        mytheme_work_render_input_field($post_id, 'caution_' . $i . '_title', '注意事項グループ ' . $i . ': 小見出し');
        mytheme_work_render_textarea_field($post_id, 'caution_' . $i . '_items', '注意事項グループ ' . $i . ': 項目', '1行1項目で入力します。', 4);
    endfor;
    mytheme_work_render_textarea_field($post_id, 'cautions', '開発時の注意事項: 補足リスト', 'グループ分けしない場合のみ、1行1項目で入力します。', 4);
    mytheme_work_render_textarea_field($post_id, 'demo_description', 'デモ動画: 説明文', '', 3);
    mytheme_work_render_input_field($post_id, 'demo_embed_url', 'デモ動画: YouTube URL', '通常URL、短縮URL、embed URLのいずれでも入力できます。');
    mytheme_work_render_textarea_field($post_id, 'thanks', '謝辞', '1行1項目で入力します。', 4);
}

function mytheme_work_save_meta($post_id, $post, $update) {
    if ( ! $post || $post->post_type !== 'work' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $nonce = isset($_POST['mytheme_work_meta_nonce']) ? (string) $_POST['mytheme_work_meta_nonce'] : '';
    if ( $nonce === '' || ! wp_verify_nonce($nonce, 'mytheme_work_meta_action') ) {
        return;
    }

    $values = [
        '_mytheme_work_card_image_id'   => isset($_POST['mytheme_work_card_image_id']) ? (string) absint($_POST['mytheme_work_card_image_id']) : '',
        '_mytheme_work_card_description'=> isset($_POST['mytheme_work_card_description']) ? sanitize_textarea_field(wp_unslash((string) $_POST['mytheme_work_card_description'])) : '',
        '_mytheme_work_show_hero_image' => ! empty($_POST['mytheme_work_show_hero_image']) ? '1' : '0',
        '_mytheme_work_card_image_alt'  => isset($_POST['mytheme_work_card_image_alt']) ? sanitize_text_field(wp_unslash((string) $_POST['mytheme_work_card_image_alt'])) : '',
        '_mytheme_work_tech_tags'       => isset($_POST['mytheme_work_tech_tags']) ? sanitize_textarea_field(wp_unslash((string) $_POST['mytheme_work_tech_tags'])) : '',
        '_mytheme_work_demo_url'        => isset($_POST['mytheme_work_demo_url']) ? mytheme_work_sanitize_url_or_anchor(wp_unslash((string) $_POST['mytheme_work_demo_url'])) : '',
        '_mytheme_work_external_url'    => isset($_POST['mytheme_work_external_url']) ? esc_url_raw(wp_unslash((string) $_POST['mytheme_work_external_url'])) : '',
    ];

    for ( $i = 1; $i <= 3; $i++ ) {
        $id_key = 'mytheme_work_gallery_' . $i . '_image_id';
        $alt_key = 'mytheme_work_gallery_' . $i . '_image_alt';
        $caption_key = 'mytheme_work_gallery_' . $i . '_caption';

        $values['_mytheme_work_gallery_' . $i . '_image_id'] = isset($_POST[$id_key]) ? (string) absint($_POST[$id_key]) : '';
        $values['_mytheme_work_gallery_' . $i . '_image_alt'] = isset($_POST[$alt_key]) ? sanitize_text_field(wp_unslash((string) $_POST[$alt_key])) : '';
        $values['_mytheme_work_gallery_' . $i . '_caption'] = isset($_POST[$caption_key]) ? sanitize_text_field(wp_unslash((string) $_POST[$caption_key])) : '';
    }

    $detail_textarea_fields = [
        'overview',
        'purpose',
        'tech_language',
        'tech_frontend',
        'tech_backend',
        'features',
        'system_text',
        'system_flow',
        'efforts',
        'highlights',
        'highlight_1_code',
        'highlight_2_code',
        'highlight_3_code',
        'cautions',
        'caution_intro',
        'caution_1_items',
        'caution_2_items',
        'caution_3_items',
        'demo_description',
        'thanks',
    ];

    foreach ( $detail_textarea_fields as $field ) {
        $post_key = 'mytheme_work_detail_' . $field;
        $values['_mytheme_work_detail_' . $field] = isset($_POST[$post_key]) ? wp_kses_post(wp_unslash((string) $_POST[$post_key])) : '';
    }

    $detail_input_fields = [
        'dev_type',
        'dev_role',
        'dev_period',
        'demo_embed_url',
        'highlight_1_title',
        'highlight_2_title',
        'highlight_3_title',
        'caution_1_title',
        'caution_2_title',
        'caution_3_title',
    ];

    foreach ( $detail_input_fields as $field ) {
        $post_key = 'mytheme_work_detail_' . $field;
        $values['_mytheme_work_detail_' . $field] = isset($_POST[$post_key]) ? sanitize_text_field(wp_unslash((string) $_POST[$post_key])) : '';
    }

    foreach ( $values as $key => $value ) {
        if ( $value === '' ) {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }
}
add_action('save_post_work', 'mytheme_work_save_meta', 10, 3);

function mytheme_get_seed_work_items() {
    return [
        [
            'seed_key'    => 'loto6',
            'title'       => 'ロト６予測ツール',
            'slug'        => 'loto6',
            'excerpt'     => '複数の機械学習モデル（ロジスティック回帰・RandomForest）を活用したロト6の次回当選番号予測システム。2つのモデルの結果を比較表示。',
            'content'     => "過去のロト6抽選データを分析し、機械学習アルゴリズムを用いて次回の当選番号を予測するWebアプリケーションです。",
            'image_path'  => 'assets/images/loto6_3.png',
            'image_alt'   => 'ロト６予測ツール - 機械学習を活用した数字予測システム',
            'demo_url'    => '#demo-video',
            'tech_tags'   => "Python\nFlask\nscikit-learn\nSelenium",
            'intro_media' => '<div class="project-gallery"><div class="gallery-item">[theme_image path="assets/images/loto6_1.png" alt="ロト６予測ツール - 予測開始画面" class="gallery-item__image" loading="lazy"]<p class="gallery-caption">予測開始画面</p></div><div class="gallery-item">[theme_image path="assets/images/loto6_2.png" alt="ロト６予測ツール - データ分析中" class="gallery-item__image" loading="lazy"]<p class="gallery-caption">データ分析中</p></div></div>',
            'menu_order'  => 10,
        ],
        [
            'seed_key'    => 'auto-typing',
            'title'       => 'e-typing自動タイピング',
            'slug'        => 'auto-typing',
            'excerpt'     => 'Selenium WebDriverを活用したe-typing練習サイトの自動入力システム。XPathによる動的要素取得とiframe操作を実装。',
            'content'     => "日本最大級のタイピング練習サイト「e-typing」に対応した自動入力プログラムです。",
            'image_path'  => 'assets/images/auto_typing1.png',
            'image_alt'   => 'e-typing自動タイピング - Selenium WebDriverによるブラウザ自動化',
            'demo_url'    => '#demo-video',
            'tech_tags'   => "Python\nSelenium\nwebdriver-manager\nXPath",
            'menu_order'  => 20,
        ],
        [
            'seed_key'    => 'quest4',
            'title'       => 'Quest4 - LINE学習クイズBot',
            'slug'        => 'quest4',
            'excerpt'     => 'Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システム。4科目24カテゴリから選択でき、リアルタイムで正誤判定と解説を提供します。',
            'content'     => "Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システムです。",
            'image_path'  => 'assets/images/quest4_1.png',
            'image_alt'   => 'Quest4 - LINE学習クイズBot',
            'demo_url'    => '#demo-video',
            'external_url'=> 'https://lin.ee/cyB8XEGb',
            'tech_tags'   => "JavaScript\nGoogle Apps Script\nLINE Messaging API",
            'intro_media' => '<div class="phone-gallery"><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_1.png" alt="Quest4 - 科目選択画面" class="phone-screen__image" loading="lazy"]</div></div><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_2.png" alt="Quest4 - クイズ画面" class="phone-screen__image" loading="lazy"]</div></div><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_3.png" alt="Quest4 - 結果画面" class="phone-screen__image" loading="lazy"]</div></div></div>',
            'menu_order'  => 30,
        ],
        [
            'seed_key'    => 'beengineer-camp',
            'title'       => 'BeEngineer合宿案内サイト',
            'slug'        => 'beengineer-camp',
            'excerpt'     => 'BeEngineerプログラミング合宿の案内用Webサイト。HTML5、CSS3、Vanilla JavaScriptを使用した静的サイトで、レスポンシブデザインに完全対応。',
            'content'     => "BeEngineerプログラミング合宿向けの情報提供サイトです。",
            'image_path'  => 'assets/images/beengineer_camp_1.png',
            'image_alt'   => 'BeEngineer Programming Camp - 合宿案内サイト',
            'demo_url'    => '#demo-video',
            'external_url'=> 'https://keigo-fujiwara.github.io/public_beengineer_camp25/',
            'tech_tags'   => "HTML5\nCSS3\nJavaScript\nlocalStorage",
            'intro_media' => '<div class="project-gallery"><div class="gallery-item">[theme_image path="assets/images/beengineer_camp_2.png" alt="BeEngineer合宿案内サイト - 持ち物リスト" class="gallery-item__image gallery-item__image--16x9" loading="lazy"]<p class="gallery-caption" style="min-height: 2.4em;">持ち物リスト</p></div><div class="gallery-item">[theme_image path="assets/images/beengineer_camp_3.png" alt="BeEngineer合宿案内サイト - お問い合わせ" class="gallery-item__image gallery-item__image--16x9" loading="lazy"]<p class="gallery-caption" style="min-height: 2.4em;">お問い合わせ</p></div></div>',
            'menu_order'  => 40,
        ],
    ];
}

function mytheme_work_build_seed_content($item) {
    $content = '';
    if ( ! empty($item['intro_media']) ) {
        $content .= (string) $item['intro_media'] . "\n\n";
    }

    if ( function_exists('mytheme_get_legacy_work_seed_contents') && ! empty($item['seed_key']) ) {
        $legacy_contents = mytheme_get_legacy_work_seed_contents();
        $seed_key = (string) $item['seed_key'];
        if ( is_array($legacy_contents) && ! empty($legacy_contents[$seed_key]) ) {
            return $content . (string) $legacy_contents[$seed_key];
        }
    }

    return $content . '<section class="project-section"><h2 class="project-section__title">プロジェクト概要</h2><p class="project-section__text">' . esc_html((string) $item['content']) . '</p></section>';
}

function mytheme_seed_work_entries_once() {
    if ( get_option('mytheme_work_seeded_v2') ) return;

    foreach ( mytheme_get_seed_work_items() as $item ) {
        $existing = get_posts([
            'post_type'              => 'work',
            'post_status'            => ['publish', 'draft', 'pending', 'private'],
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'meta_key'               => '_mytheme_work_seed_key',
            'meta_value'             => (string) $item['seed_key'],
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        $content = mytheme_work_build_seed_content($item);
        $post_data = [
            'post_type'    => 'work',
            'post_status'  => 'publish',
            'post_title'   => (string) $item['title'],
            'post_name'    => (string) $item['slug'],
            'post_excerpt' => (string) $item['excerpt'],
            'post_content' => $content,
            'menu_order'   => (int) $item['menu_order'],
        ];

        if ( ! empty($existing) ) {
            $post_data['ID'] = (int) $existing[0];
            $post_id = wp_update_post($post_data, true);
        } else {
            $post_id = wp_insert_post($post_data, true);
        }

        if ( is_wp_error($post_id) || (int) $post_id <= 0 ) {
            continue;
        }

        update_post_meta((int) $post_id, '_mytheme_work_seed_key', (string) $item['seed_key']);
        update_post_meta((int) $post_id, '_mytheme_work_card_image_path', (string) $item['image_path']);
        update_post_meta((int) $post_id, '_mytheme_work_card_image_alt', (string) $item['image_alt']);
        update_post_meta((int) $post_id, '_mytheme_work_demo_url', (string) $item['demo_url']);
        update_post_meta((int) $post_id, '_mytheme_work_tech_tags', (string) $item['tech_tags']);
        delete_post_meta((int) $post_id, '_mytheme_work_detail_url');

        if ( ! empty($item['external_url']) ) {
            update_post_meta((int) $post_id, '_mytheme_work_external_url', esc_url_raw((string) $item['external_url']));
        }
    }

    update_option('mytheme_work_seeded_v2', 1, false);
}
add_action('init', 'mytheme_seed_work_entries_once', 30);

function mytheme_work_should_update_seeded_detail_content($post_id) {
    $post_id = (int) $post_id;
    if ( $post_id <= 0 ) return false;

    if ( function_exists('mytheme_work_has_structured_detail') && mytheme_work_has_structured_detail($post_id) ) {
        return false;
    }

    $content = (string) get_post_field('post_content', $post_id);
    if ( trim($content) === '' ) return true;

    // Production may have seeded after the template files were deleted, leaving only a minimal overview.
    return substr_count($content, 'project-section__title') <= 1;
}

function mytheme_seed_work_detail_content_once() {
    $version = 'work-detail-content-v1';
    if ( get_option('mytheme_work_detail_content_seeded_version') === $version ) return;
    if ( ! function_exists('mytheme_get_legacy_work_seed_contents') ) return;

    foreach ( mytheme_get_seed_work_items() as $item ) {
        if ( empty($item['seed_key']) ) {
            continue;
        }

        $existing = get_posts([
            'post_type'              => 'work',
            'post_status'            => ['publish', 'draft', 'pending', 'private'],
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'meta_key'               => '_mytheme_work_seed_key',
            'meta_value'             => (string) $item['seed_key'],
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        if ( empty($existing) && ! empty($item['slug']) ) {
            $fallback = get_page_by_path((string) $item['slug'], OBJECT, 'work');
            if ( $fallback && ! is_wp_error($fallback) ) {
                $existing = [(int) $fallback->ID];
            }
        }

        if ( empty($existing) || ! mytheme_work_should_update_seeded_detail_content((int) $existing[0]) ) {
            continue;
        }

        wp_update_post([
            'ID'           => (int) $existing[0],
            'post_content' => mytheme_work_build_seed_content($item),
        ]);
    }

    update_option('mytheme_work_detail_content_seeded_version', $version, false);
}
add_action('init', 'mytheme_seed_work_detail_content_once', 35);

function mytheme_deactivate_legacy_work_child_pages_once() {
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( ! is_admin() ) return;
    if ( ! current_user_can('edit_pages') ) return;

    $version = 'legacy-work-pages-disabled-v1';
    if ( get_option('mytheme_legacy_work_pages_disabled_version') === $version ) return;

    foreach ( mytheme_get_legacy_work_child_page_paths() as $path ) {
        $page = get_page_by_path($path, OBJECT, 'page');
        if ( ! $page || is_wp_error($page) ) {
            continue;
        }

        if ( get_post_status($page->ID) !== 'publish' ) {
            continue;
        }

        wp_update_post([
            'ID'          => (int) $page->ID,
            'post_status' => 'draft',
            'post_name'   => 'legacy-' . sanitize_title((string) $page->post_name),
        ]);
        update_post_meta((int) $page->ID, '_wp_page_template', 'default');
    }

    update_option('mytheme_legacy_work_pages_disabled_version', $version, false);
}
add_action('admin_init', 'mytheme_deactivate_legacy_work_child_pages_once', 20);

function mytheme_get_work_archive_query($args = []) {
    $defaults = [
        'post_type'      => 'work',
        'post_status'    => 'publish',
        'posts_per_page' => 50,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
    ];

    return new WP_Query(wp_parse_args($args, $defaults));
}

function mytheme_render_work_card($post_id) {
    $post_id = (int) $post_id;
    $url = mytheme_get_work_detail_url($post_id);
    $title = get_the_title($post_id);
    $image_alt = mytheme_get_work_meta($post_id, '_mytheme_work_card_image_alt', $title);
    $image_id = (int) mytheme_get_work_meta($post_id, '_mytheme_work_card_image_id', 0);
    $image_path = mytheme_get_work_meta($post_id, '_mytheme_work_card_image_path');
    $tech_tags = mytheme_get_work_tech_tags($post_id);
    $demo_url = mytheme_get_work_meta($post_id, '_mytheme_work_demo_url');
    $description = trim((string) mytheme_get_work_meta($post_id, '_mytheme_work_card_description'));
    if ( $description === '' ) {
        $description = has_excerpt($post_id) ? trim((string) get_the_excerpt($post_id)) : '';
    }
    if ( $description === '' && function_exists('mytheme_work_get_detail_field') ) {
        $overview = wp_strip_all_tags(mytheme_work_get_detail_field($post_id, 'overview'));
        $description = wp_trim_words($overview, 80, '...');
    }

    if ( $demo_url === '' && function_exists('mytheme_work_get_detail_field') && trim(mytheme_work_get_detail_field($post_id, 'demo_embed_url')) !== '' ) {
        $demo_url = '#demo-video';
    }

    if ( strpos($demo_url, '#') === 0 ) {
        $demo_url = $url . $demo_url;
    }
    ?>
    <div class="work-item">
        <div class="work-thumbnail">
            <a class="work-thumbnail__link" href="<?php echo esc_url($url); ?>">
                <?php if ( $image_id > 0 ) : ?>
                    <?php echo mytheme_work_get_attachment_image_html($image_id, 'work-thumbnail__image', $image_alt); ?>
                <?php elseif ( $image_path !== '' && function_exists('mytheme_picture_tag') ) : ?>
                    <?php echo mytheme_picture_tag($image_path, $image_alt, 'work-thumbnail__image', 'lazy'); ?>
                <?php elseif ( has_post_thumbnail($post_id) ) : ?>
                    <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'work-thumbnail__image', 'alt' => $image_alt]); ?>
                <?php endif; ?>
            </a>
        </div>
        <div class="work-info">
            <h2 class="work-title"><?php echo esc_html($title); ?></h2>
            <?php if ( $description !== '' ) : ?>
                <p class="work-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            <?php if ( ! empty($tech_tags) ) : ?>
                <div class="work-tech">
                    <?php foreach ( $tech_tags as $tag ) : ?>
                        <span class="tech-tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="work-links">
                <a href="<?php echo esc_url($url); ?>" class="work-link">詳細を見る</a>
                <?php if ( $demo_url !== '' ) : ?>
                    <a href="<?php echo esc_url($demo_url); ?>" class="work-link work-link-demo">
                        <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                        デモを見る
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

function mytheme_work_flush_rewrite_on_switch() {
    mytheme_register_work_cpt();
    mytheme_work_add_rewrite_rules();
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'mytheme_work_flush_rewrite_on_switch');

function mytheme_work_flush_rewrite_once_after_register() {
    $version = 'work-rewrite-v4';
    if ( get_option('mytheme_work_rewrite_version') === $version ) return;

    flush_rewrite_rules(false);
    update_option('mytheme_work_rewrite_version', $version, false);
}
add_action('init', 'mytheme_work_flush_rewrite_once_after_register', 99);
