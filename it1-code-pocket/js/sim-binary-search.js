/* =========================================================
   sim-binary-search.js — 二分探索シミュレーション
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  /** 要素数ごとの見本配列（二分探索なので必ず小さい順）。 */
  const SAMPLE_BASE = {
    4: [2, 5, 8, 11],
    5: [2, 5, 8, 11, 14],
    6: [2, 5, 8, 11, 14, 20],
    7: [2, 5, 8, 11, 14, 20, 25],
    8: [2, 5, 8, 11, 14, 20, 25, 30],
    9: [2, 5, 8, 11, 14, 20, 25, 30, 33],
    10: [2, 5, 8, 11, 14, 20, 25, 30, 33, 38],
  };

  const MIN_LENGTH = 4;
  const MAX_LENGTH = 10;
  /** 範囲を狭められない書き方のとき、何回まで回して打ち切るか。 */
  const LOOP_LIMIT = 12;

  /* ---------- 擬似コード ---------- */

  function buildCode(nums, target, mode) {
    const head = [
      `Nums = [${nums.join(', ')}]`,
      `target = ${target}`,
      'low = 0',
      'high = 要素数(Nums) - 1',
      'pos = -1',
      '',
      'low <= high の間繰り返す:',
      '｜mid = (low + high) ÷ 2',
      '｜もし Nums[mid] == target ならば:',
      '｜｜pos = mid',
      '｜｜繰り返しを抜ける',
    ];

    // 範囲の更新に ±1 を付けない書き方も選べるようにする（無限ループの体験用）。
    const update =
      mode === 'noAdjust'
        ? ['｜そうでなくもし Nums[mid] < target ならば:', '｜｜low = mid', '｜そうでなければ:', '⎿⎿ high = mid']
        : ['｜そうでなくもし Nums[mid] < target ならば:', '｜｜low = mid + 1', '｜そうでなければ:', '⎿⎿ high = mid - 1'];

    return {
      lines: head.concat(update, ['', '表示する(pos)']),
      L: {
        init: 4,
        loop: 6,
        mid: 7,
        cmpEq: 8,
        assign: 9,
        brk: 10,
        cmpLt: 11,
        setLow: 12,
        elseLine: 13,
        setHigh: 14,
        print: 16,
      },
    };
  }

  /* ---------- ステップ生成 ---------- */

  function buildSteps(nums, target, mode) {
    const code = buildCode(nums, target, mode);
    const L = code.L;
    const steps = [];
    const size = nums.length;

    let low = 0;
    let high = size - 1;
    let pos = -1;
    let compares = 0;
    let stuck = false;

    /** 範囲の外は候補から外れたことが分かるように skip にする。 */
    function cellStates(activeIndex, foundIndex) {
      const states = [];
      for (let k = 0; k < size; k += 1) {
        // 見つかった位置は、そのあとのステップでも緑のままにする。
        if (foundIndex === k || pos === k) states.push('found');
        else if (activeIndex === k) states.push('active');
        else if (k < low || k > high) states.push('skip');
        else states.push('idle');
      }
      return states;
    }

    /** low / high / mid の位置に目印を付ける。同じマスなら並べて書く。 */
    function markers(mid) {
      const map = {};
      const push = (index, text) => {
        if (index < 0 || index >= size) return;
        map[index] = map[index] ? `${map[index]}${text}` : text;
      };
      push(low, 'L');
      if (typeof mid === 'number') push(mid, 'M');
      push(high, 'H');
      Object.keys(map).forEach((key) => {
        map[key] = `${map[key]}▼`;
      });
      return map;
    }

    function snap(patch) {
      steps.push(
        Object.assign(
          {
            cells: cellStates(null, null),
            markers: markers(null),
            low: low,
            high: high,
            mid: null,
            pos: pos,
            compares: compares,
            changed: [],
            result: null,
          },
          patch
        )
      );
    }

    snap({
      line: L.init,
      changed: ['low', 'high', 'pos'],
      message:
        `探す範囲を low = 0、high = ${size - 1} で表します。この2つが探索範囲の両端です。` +
        'pos は見つかった位置を入れる変数で、まだ見つかっていない印として -1 にしておきます。',
    });

    let done = false;
    let rounds = 0;

    while (!done) {
      rounds += 1;
      if (rounds > LOOP_LIMIT) {
        stuck = true;
        break;
      }

      // 繰り返しの条件判定
      if (low > high) {
        snap({
          line: L.loop,
          message:
            `low（${low}）が high（${high}）を超えました。調べる範囲が無くなったので繰り返しを終えます。`,
        });
        break;
      }

      const rangeCount = high - low + 1;
      snap({
        line: L.loop,
        message:
          `low（${low}）は high（${high}）以下なので繰り返しを続けます。` +
          `いま候補は ${rangeCount} 個です。`,
      });

      const mid = Math.floor((low + high) / 2);
      snap({
        line: L.mid,
        mid: mid,
        cells: cellStates(mid, null),
        markers: markers(mid),
        changed: ['mid'],
        message:
          `mid = (${low} + ${high}) ÷ 2 = ${mid} です。` +
          ((low + high) % 2 === 1 ? '（÷ は小数を切り捨てます）' : '') +
          `真ん中の Nums[${mid}] = ${nums[mid]} を調べます。`,
      });

      compares += 1;

      if (nums[mid] === target) {
        pos = mid;
        snap({
          line: L.cmpEq,
          mid: mid,
          cells: cellStates(null, mid),
          markers: markers(mid),
          changed: ['compares'],
          message:
            `Nums[${mid}] は ${nums[mid]} で target（${target}）と一致しました。（比較 ${compares} 回目）`,
        });
        snap({
          line: L.assign,
          mid: mid,
          cells: cellStates(null, mid),
          markers: markers(mid),
          changed: ['pos'],
          message: `見つかった位置を記録します。pos = ${mid} です。`,
        });
        snap({
          line: L.brk,
          mid: mid,
          cells: cellStates(null, mid),
          markers: markers(mid),
          message: '見つかったので繰り返しを抜けます。',
        });
        done = true;
        break;
      }

      const goRight = nums[mid] < target;
      const previousLow = low;
      const previousHigh = high;

      if (goRight) {
        snap({
          line: L.cmpLt,
          mid: mid,
          cells: cellStates(mid, null),
          markers: markers(mid),
          changed: ['compares'],
          message:
            `Nums[${mid}] は ${nums[mid]} で target（${target}）より小さいです。` +
            `つまり target は mid より後ろにしかありません。（比較 ${compares} 回目）`,
        });
        low = mode === 'noAdjust' ? mid : mid + 1;
        snap({
          line: L.setLow,
          mid: mid,
          changed: ['low'],
          message:
            `low を ${low} に更新し、前半（添字 ${previousLow} 〜 ${mid}）を候補から外します。` +
            `候補は ${high - low + 1} 個に減りました。`,
        });
      } else {
        snap({
          line: L.elseLine,
          mid: mid,
          cells: cellStates(mid, null),
          markers: markers(mid),
          changed: ['compares'],
          message:
            `Nums[${mid}] は ${nums[mid]} で target（${target}）より大きいです。` +
            `つまり target は mid より前にしかありません。（比較 ${compares} 回目）`,
        });
        high = mode === 'noAdjust' ? mid : mid - 1;
        snap({
          line: L.setHigh,
          mid: mid,
          changed: ['high'],
          message:
            `high を ${high} に更新し、後半（添字 ${mid} 〜 ${previousHigh}）を候補から外します。` +
            `候補は ${high - low + 1} 個に減りました。`,
        });
      }

      // ±1 を付けない書き方だと範囲が縮まず、同じ mid を調べ続けてしまう。
      if (low === previousLow && high === previousHigh) {
        stuck = true;
        break;
      }
    }

    const found = pos !== -1;

    if (stuck) {
      snap({
        line: mode === 'noAdjust' ? L.setLow : L.loop,
        result: '範囲が狭まらず、同じ場所を調べ続けています（無限ループ）',
        message:
          'low と high が変わらないため、次も同じ mid を調べることになります。' +
          'このままでは終わりません。範囲を更新するときに mid + 1 / mid - 1 とするのは、' +
          '調べ終わった mid を範囲から必ず外して先へ進めるためです。',
      });
      return { steps: steps, code: code.lines, stuck: true };
    }

    const resultText = found
      ? `pos = ${pos}（Nums[${pos}] = ${nums[pos]}）／ 比較 ${compares} 回`
      : `pos = -1（${target} は見つかりません）／ 比較 ${compares} 回`;

    snap({
      line: L.print,
      mid: null,
      result: resultText,
      message: found
        ? `pos = ${pos} を表示します。${nums.length} 個の配列を ${compares} 回の比較で調べ終えました。`
        : `pos は -1 のままなので、target（${target}）は配列にありません。比較は ${compares} 回でした。`,
    });

    return { steps: steps, code: code.lines, stuck: false };
  }

  /* ---------- 見本の組み立て ---------- */

  /** 配列に無い値（「見つからない」用）。並びを崩さない値を選ぶ。 */
  function missingValue(nums) {
    for (let value = 1; value <= 99; value += 1) {
      if (nums.indexOf(value) === -1) return value;
    }
    return 99;
  }

  function buildSample(length, scenario) {
    const sorted = (SAMPLE_BASE[length] || SAMPLE_BASE[6]).slice();

    if (scenario === 'left') return { nums: sorted, target: sorted[0] };
    if (scenario === 'right') return { nums: sorted, target: sorted[length - 1] };
    if (scenario === 'notFound') return { nums: sorted, target: missingValue(sorted) };
    if (scenario === 'unsorted') {
      // わざと並びを崩す（値は同じまま）。整列が前提だと確かめるための見本。
      const shuffled = sorted.slice();
      const last = shuffled.pop();
      shuffled.splice(1, 0, last);
      return { nums: shuffled, target: last };
    }
    // 既定は「1回で見つかる」中央の値。
    return { nums: sorted, target: sorted[Math.floor((length - 1) / 2)] };
  }

  const state = { length: 6, scenario: 'middle' };
  const refs = {};

  function collectRefs() {
    refs.array = document.getElementById('sim-array');
    refs.code = document.getElementById('sim-code');
    refs.message = document.getElementById('sim-message-text');
    refs.stepLabel = document.getElementById('sim-message-step');
    refs.result = document.getElementById('sim-result');
    refs.log = document.getElementById('sim-log');
    refs.targetView = document.getElementById('sim-target-view');
    refs.error = document.getElementById('sim-error');
    refs.warn = document.getElementById('sim-warn');
    refs.numsInput = document.getElementById('sim-input-nums');
    refs.targetInput = document.getElementById('sim-input-target');
    refs.modeSelect = document.getElementById('sim-input-mode');
    refs.lengthChips = Array.from(document.querySelectorAll('[data-sim-length]'));
    refs.scenarioChips = Array.from(document.querySelectorAll('[data-sim-scenario]'));
    refs.vars = {
      low: document.getElementById('sim-var-low'),
      mid: document.getElementById('sim-var-mid'),
      high: document.getElementById('sim-var-high'),
      pos: document.getElementById('sim-var-pos'),
      compares: document.getElementById('sim-var-compares'),
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

  function renderStep(step, index, total) {
    if (!step) return;

    window.SimUI.paintCells(refs.array, step);
    window.SimUI.setActiveLine(refs.code, step.line);

    refs.vars.low.textContent = String(step.low);
    refs.vars.mid.textContent = step.mid === null ? '–' : String(step.mid);
    refs.vars.high.textContent = String(step.high);
    refs.vars.pos.textContent = String(step.pos);
    refs.vars.compares.textContent = String(step.compares);

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

  /** 並びが崩れているときは、その場で分かるように注意を出す。 */
  function showSortWarning(nums, target) {
    if (!refs.warn) return;
    const sorted = nums.every((value, index) => index === 0 || nums[index - 1] <= value);
    if (sorted) {
      refs.warn.hidden = true;
      return;
    }
    const exists = nums.indexOf(target) !== -1;
    refs.warn.textContent = exists
      ? `この配列は小さい順に並んでいません。${target} は配列の中にありますが、二分探索では見つけられないことがあります。`
      : 'この配列は小さい順に並んでいません。二分探索は整列済みでないと正しく動きません。';
    refs.warn.hidden = false;
  }

  function rebuild() {
    const parsedNums = window.SimUI.parseNumberList(refs.numsInput.value, {
      min: 0,
      max: 99,
      minLength: MIN_LENGTH,
      maxLength: MAX_LENGTH,
    });
    if (!parsedNums.ok) {
      showError(parsedNums.message);
      return;
    }

    const parsedTarget = window.SimUI.parseNumber(refs.targetInput.value, {
      min: 0,
      max: 99,
    });
    if (!parsedTarget.ok) {
      showError(parsedTarget.message);
      return;
    }

    showError(null);

    const nums = parsedNums.values;
    const target = parsedTarget.value;
    const mode = refs.modeSelect.value;

    state.length = nums.length;
    syncChips();
    showSortWarning(nums, target);

    refs.targetView.textContent = String(target);
    renderArray(nums);

    const built = buildSteps(nums, target, mode);
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
    const sample = buildSample(state.length, state.scenario);
    refs.numsInput.value = sample.nums.join(', ');
    refs.targetInput.value = String(sample.target);
    rebuild();
  }

  /** ランダム生成。二分探索の前提を保つため、必ず小さい順に並べる。 */
  function randomize() {
    const values = [];
    let value = 1 + Math.floor(Math.random() * 4);
    for (let k = 0; k < state.length; k += 1) {
      values.push(value);
      value += 1 + Math.floor(Math.random() * 6);
      if (value > 99) value = 99;
    }
    const target =
      Math.random() < 0.75
        ? values[Math.floor(Math.random() * values.length)]
        : missingValue(values);

    state.scenario = null;
    refs.numsInput.value = values.join(', ');
    refs.targetInput.value = String(target);
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
    refs.targetInput.addEventListener('change', () => {
      state.scenario = null;
      rebuild();
    });
    refs.modeSelect.addEventListener('change', rebuild);

    refs.lengthChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.length = Number(chip.getAttribute('data-sim-length'));
        if (!state.scenario) state.scenario = 'middle';
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
