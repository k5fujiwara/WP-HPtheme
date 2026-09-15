/* =========================================================
   sim-selection-sort.js — 選択法（選択ソート）シミュレーション
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  /** 要素数ごとの見本配列（ばらばらの並び）。 */
  const SAMPLE_BASE = {
    4: [5, 2, 4, 1],
    5: [5, 2, 4, 1, 3],
    6: [5, 2, 6, 1, 4, 3],
    7: [5, 2, 6, 1, 7, 4, 3],
    8: [5, 2, 6, 1, 8, 4, 7, 3],
    9: [5, 2, 6, 1, 8, 4, 9, 7, 3],
    10: [5, 2, 6, 1, 8, 4, 10, 7, 9, 3],
  };

  const MIN_LENGTH = 4;
  const MAX_LENGTH = 10;

  /* ---------- 擬似コード ---------- */

  function buildCode(nums, mode) {
    const head = [`Nums = [${nums.join(', ')}]`, 'swap = 0', ''];
    const scan = [
      'i を 0 から 要素数(Nums) - 2 まで 1 ずつ増やしながら繰り返す:',
      '｜min_pos = i',
      '｜j を i + 1 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:',
      '｜｜もし Nums[j] < Nums[min_pos] ならば:',
      '｜⎿⎿ min_pos = j',
    ];

    if (mode === 'skipSame') {
      return {
        lines: head.concat(scan, [
          '｜もし min_pos != i ならば:',
          '｜｜temp = Nums[i]',
          '｜｜Nums[i] = Nums[min_pos]',
          '｜｜Nums[min_pos] = temp',
          '⎿⎿ swap = swap + 1',
          '',
          '表示する(Nums, swap)',
        ]),
        L: {
          outer: 3,
          setMin: 4,
          inner: 5,
          cond: 6,
          updateMin: 7,
          check: 8,
          swapExec: 10,
          count: 11,
          print: 13,
        },
      };
    }

    return {
      lines: head.concat(scan, [
        '｜temp = Nums[i]',
        '｜Nums[i] = Nums[min_pos]',
        '｜Nums[min_pos] = temp',
        '⎿ swap = swap + 1',
        '',
        '表示する(Nums, swap)',
      ]),
      L: {
        outer: 3,
        setMin: 4,
        inner: 5,
        cond: 6,
        updateMin: 7,
        swapExec: 9,
        count: 10,
        print: 12,
      },
    };
  }

  /* ---------- ステップ生成 ---------- */

  function buildSteps(nums, mode) {
    const code = buildCode(nums, mode);
    const L = code.L;
    const steps = [];
    const values = nums.slice();
    const size = values.length;

    let compares = 0;
    let swaps = 0;
    let fixedCount = 0; // 左から何個が確定したか
    let current = null; // i
    let minPos = null;
    let scanning = null; // j

    function statesFor(swapPair) {
      const states = [];
      for (let k = 0; k < size; k += 1) {
        if (swapPair && (k === swapPair[0] || k === swapPair[1])) states.push('swap');
        else if (k < fixedCount) states.push('fixed');
        else if (scanning !== null && k === scanning) states.push('active');
        else if (minPos !== null && k === minPos) states.push('dup');
        else states.push('idle');
      }
      return states;
    }

    /** i・min_pos・j の目印。同じマスに重なるときは並べて書く。 */
    function markersFor() {
      const map = {};
      const put = (index, text) => {
        if (index === null || index < 0 || index >= size) return;
        map[index] = map[index] ? `${map[index]}${text}` : text;
      };
      put(current, 'i');
      put(minPos, 'm');
      put(scanning, 'j');
      Object.keys(map).forEach((key) => {
        map[key] = `${map[key]}▼`;
      });
      return map;
    }

    function snap(patch) {
      const swapPair = patch.swapPair || null;
      const base = {
        values: values.slice(),
        cells: statesFor(swapPair),
        markers: markersFor(),
        current: current,
        minPos: minPos,
        scanning: scanning,
        compares: compares,
        swaps: swaps,
        changed: [],
        result: null,
        swapAnim: null,
      };
      delete patch.swapPair;
      steps.push(Object.assign(base, patch));
    }

    snap({
      line: L.outer,
      message:
        '未整列の部分から最小値を探し、その値を先頭に持ってくる整列です。' +
        '「次へ」で1ステップずつ進めてください。',
    });

    for (let i = 0; i < size - 1; i += 1) {
      current = i;
      minPos = null;
      scanning = null;
      snap({
        line: L.outer,
        changed: ['current'],
        message:
          `i = ${i} にします。ここから右側（添字 ${i} 〜 ${size - 1}）の中で` +
          'いちばん小さい値を探し、添字 ' + i + ' に入れます。',
      });

      minPos = i;
      snap({
        line: L.setMin,
        changed: ['minPos'],
        message:
          `まず Nums[${i}] = ${values[i]} を最小値の候補とし、その位置を min_pos = ${i} に覚えます。` +
          '覚えるのは「値」ではなく「位置」です。',
      });

      for (let j = i + 1; j < size; j += 1) {
        scanning = j;
        snap({
          line: L.inner,
          changed: ['scanning'],
          message: `j = ${j} にして、Nums[${j}] = ${values[j]} を候補と比べます。`,
        });

        compares += 1;
        if (values[j] < values[minPos]) {
          snap({
            line: L.cond,
            changed: ['compares'],
            message:
              `${values[j]} < ${values[minPos]} なので、こちらのほうが小さいです。（比較 ${compares} 回目）`,
          });
          minPos = j;
          snap({
            line: L.updateMin,
            changed: ['minPos'],
            message: `最小値の位置を更新します。min_pos = ${j} になりました。`,
          });
        } else {
          snap({
            line: L.cond,
            changed: ['compares'],
            message:
              `${values[j]} < ${values[minPos]} は成り立たないので、min_pos は ${minPos} のままです。（比較 ${compares} 回目）`,
          });
        }
      }

      scanning = null;
      const sameSpot = minPos === i;

      if (mode === 'skipSame') {
        snap({
          line: L.check,
          message: sameSpot
            ? `min_pos は i（${i}）と同じでした。すでに最小値がその位置にあるので、交換は行いません。`
            : `min_pos（${minPos}）は i（${i}）と違うので、交換を行います。`,
        });
      }

      if (!(mode === 'skipSame' && sameSpot)) {
        const beforeSwap = values.slice();
        const keep = values[i];
        values[i] = values[minPos];
        values[minPos] = keep;
        swaps += 1;

        snap({
          line: L.swapExec,
          swapPair: [i, minPos],
          swapAnim: sameSpot ? null : { a: i, b: minPos, before: beforeSwap },
          changed: ['swaps'],
          message: sameSpot
            ? `min_pos が i と同じなので、同じ位置どうしの交換になります。値は変わりませんが、交換回数は ${swaps} 回と数えます。`
            : `最小値 ${values[i]}（元の添字 ${minPos}）と Nums[${i}] を temp を使って交換します。交換は ${swaps} 回目です。`,
        });
      }

      fixedCount = i + 1;
      minPos = null;
      snap({
        line: L.count,
        // 「1つ確定」ごとにここまで一気に送れるようにする印
        passEnd: true,
        message:
          `添字 ${i} に ${values[i]} が確定しました。` +
          (i + 1 < size - 1
            ? `残りは添字 ${i + 1} 〜 ${size - 1} です。`
            : '残りは1個だけなので、そこが最大値の位置として自動的に決まります。'),
      });
    }

    fixedCount = size;
    current = null;
    minPos = null;
    scanning = null;
    snap({
      line: L.print,
      passEnd: true,
      result: `[${values.join(', ')}]  /  交換 ${swaps} 回  /  比較 ${compares} 回`,
      message:
        `整列が終わりました。[${values.join(', ')}] になり、交換は ${swaps} 回、比較は ${compares} 回でした。` +
        '最後の1個は、それより小さい値がすべて前に確定しているため、比べなくても位置が決まります。',
    });

    return { steps: steps, code: code.lines };
  }

  /* ---------- 見本の組み立て ---------- */

  function buildSample(length, scenario) {
    if (scenario === 'reversed') {
      const values = [];
      for (let k = length; k >= 1; k -= 1) values.push(k);
      return values;
    }
    if (scenario === 'sorted') {
      const values = [];
      for (let k = 1; k <= length; k += 1) values.push(k);
      return values;
    }
    if (scenario === 'nearly') {
      const values = [];
      for (let k = 1; k <= length; k += 1) values.push(k);
      const last = values[length - 1];
      values[length - 1] = values[length - 2];
      values[length - 2] = last;
      return values;
    }
    return (SAMPLE_BASE[length] || SAMPLE_BASE[5]).slice();
  }

  const state = { length: 5, scenario: 'shuffled' };
  const refs = {};

  function collectRefs() {
    refs.array = document.getElementById('sim-array');
    refs.code = document.getElementById('sim-code');
    refs.message = document.getElementById('sim-message-text');
    refs.stepLabel = document.getElementById('sim-message-step');
    refs.result = document.getElementById('sim-result');
    refs.log = document.getElementById('sim-log');
    refs.error = document.getElementById('sim-error');
    refs.numsInput = document.getElementById('sim-input-nums');
    refs.modeSelect = document.getElementById('sim-input-mode');
    refs.lengthChips = Array.from(document.querySelectorAll('[data-sim-length]'));
    refs.scenarioChips = Array.from(document.querySelectorAll('[data-sim-scenario]'));
    refs.vars = {
      current: document.getElementById('sim-var-current'),
      minPos: document.getElementById('sim-var-minpos'),
      scanning: document.getElementById('sim-var-scanning'),
      compares: document.getElementById('sim-var-compares'),
      swaps: document.getElementById('sim-var-swaps'),
    };
    refs.playBtn = document.querySelector('[data-sim-action="play"]');
    refs.prevBtn = document.querySelector('[data-sim-action="prev"]');
    refs.nextBtn = document.querySelector('[data-sim-action="next"]');
    refs.fillEl = document.getElementById('sim-progress-fill');
  }

  function cellOptions() {
    return { maxSize: window.innerWidth < 900 ? 40 : 48 };
  }

  function renderArray(nums) {
    window.SimUI.fitArray(refs.array, nums.length, cellOptions());
    window.SimUI.buildCells(refs.array, nums);
  }

  let lastIndex = -1;

  function renderStep(step, index, total) {
    if (!step) return;

    window.SimUI.paintCells(refs.array, step);

    if (step.swapAnim && index === lastIndex + 1) {
      const duration = player.playing
        ? Math.max(160, Math.min(380, player.interval - 80))
        : 380;
      window.SimUI.animateSwap(
        refs.array,
        step.swapAnim.a,
        step.swapAnim.b,
        step.swapAnim.before,
        { duration: duration }
      );
    }
    lastIndex = index;

    window.SimUI.setActiveLine(refs.code, step.line);

    refs.vars.current.textContent = step.current === null ? '–' : String(step.current);
    refs.vars.minPos.textContent = step.minPos === null ? '–' : String(step.minPos);
    refs.vars.scanning.textContent = step.scanning === null ? '–' : String(step.scanning);
    refs.vars.compares.textContent = String(step.compares);
    refs.vars.swaps.textContent = String(step.swaps);

    Object.keys(refs.vars).forEach((name) => {
      const box = refs.vars[name].closest('.sim-var');
      if (!box) return;
      if (step.changed.indexOf(name) !== -1) {
        box.setAttribute('data-changed', 'true');
      } else {
        box.removeAttribute('data-changed');
      }
    });

    refs.stepLabel.textContent = `STEP ${index + 1} / ${total}`;
    refs.message.textContent = step.message;

    if (step.result) {
      refs.result.textContent = `実行結果： ${step.result}`;
      refs.result.hidden = false;
    } else {
      refs.result.hidden = true;
    }

    window.SimUI.renderLog(refs.log, player.steps, index);
  }

  const player = new window.SimPlayer({ onRender: renderStep });

  function showError(message) {
    if (!message) {
      refs.error.hidden = true;
      refs.error.textContent = '';
      return;
    }
    refs.error.textContent = message;
    refs.error.hidden = false;
  }

  function rebuild() {
    const parsed = window.SimUI.parseNumberList(refs.numsInput.value, {
      min: 0,
      max: 99,
      minLength: MIN_LENGTH,
      maxLength: MAX_LENGTH,
    });
    if (!parsed.ok) {
      showError(parsed.message);
      return;
    }
    showError(null);

    const nums = parsed.values;
    state.length = nums.length;
    syncChips();

    renderArray(nums);
    lastIndex = -1;
    const built = buildSteps(nums, refs.modeSelect.value);
    window.SimUI.renderCode(refs.code, built.code);
    player.load(built.steps);
  }

  function syncChips() {
    refs.lengthChips.forEach((chip) => {
      const selected = Number(chip.getAttribute('data-sim-length')) === state.length;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
    refs.scenarioChips.forEach((chip) => {
      const selected = chip.getAttribute('data-sim-scenario') === state.scenario;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
  }

  function applySample() {
    refs.numsInput.value = buildSample(state.length, state.scenario).join(', ');
    rebuild();
  }

  function randomize() {
    const values = [];
    for (let k = 1; k <= state.length; k += 1) values.push(k);
    for (let k = values.length - 1; k > 0; k -= 1) {
      const pick = Math.floor(Math.random() * (k + 1));
      const keep = values[k];
      values[k] = values[pick];
      values[pick] = keep;
    }
    state.scenario = null;
    refs.numsInput.value = values.join(', ');
    rebuild();
  }

  function init() {
    collectRefs();
    if (!refs.array || !refs.code) return;

    window.SimUI.bindDefaultStateView(player, refs);
    window.SimUI.bindControls(player, document);
    window.SimUI.bindViewTabs(document);
    window.SimUI.bindTabs(document);

    refs.numsInput.addEventListener('change', () => {
      state.scenario = null;
      rebuild();
    });
    refs.modeSelect.addEventListener('change', rebuild);

    refs.lengthChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.length = Number(chip.getAttribute('data-sim-length'));
        if (!state.scenario) state.scenario = 'shuffled';
        applySample();
      });
    });

    refs.scenarioChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.scenario = chip.getAttribute('data-sim-scenario');
        applySample();
      });
    });

    const randomBtn = document.querySelector('[data-sim-random]');
    if (randomBtn) randomBtn.addEventListener('click', randomize);

    const refit = () => {
      const count = refs.array.querySelectorAll('.sim-cell').length;
      window.SimUI.fitArray(refs.array, count, cellOptions());
    };
    window.SimUI.bindResize(refit);
    window.SimUI.observeWidth(refs.array.parentElement, refit);

    applySample();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
