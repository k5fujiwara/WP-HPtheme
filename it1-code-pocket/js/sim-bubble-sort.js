/* =========================================================
   sim-bubble-sort.js — 交換法（バブルソート）シミュレーション
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

    if (mode === 'earlyExit') {
      return {
        lines: head.concat([
          'i を 0 から 要素数(Nums) - 2 まで 1 ずつ増やしながら繰り返す:',
          '｜changed = 0',
          '｜j を 0 から 要素数(Nums) - 2 - i まで 1 ずつ増やしながら繰り返す:',
          '｜｜もし Nums[j] > Nums[j + 1] ならば:',
          '｜｜｜temp = Nums[j]',
          '｜｜｜Nums[j] = Nums[j + 1]',
          '｜｜｜Nums[j + 1] = temp',
          '｜｜｜swap = swap + 1',
          '｜⎿⎿ changed = 1',
          '｜もし changed == 0 ならば:',
          '⎿⎿ 繰り返しを抜ける',
          '',
          '表示する(Nums, swap)',
        ]),
        L: {
          init: 1,
          outer: 3,
          reset: 4,
          inner: 5,
          cond: 6,
          swapExec: 8,
          count: 11,
          check: 12,
          brk: 13,
          print: 15,
        },
      };
    }

    return {
      lines: head.concat([
        'i を 0 から 要素数(Nums) - 2 まで 1 ずつ増やしながら繰り返す:',
        '｜j を 0 から 要素数(Nums) - 2 - i まで 1 ずつ増やしながら繰り返す:',
        '｜｜もし Nums[j] > Nums[j + 1] ならば:',
        '｜｜｜temp = Nums[j]',
        '｜｜｜Nums[j] = Nums[j + 1]',
        '｜｜｜Nums[j + 1] = temp',
        '⎿⎿⎿ swap = swap + 1',
        '',
        '表示する(Nums, swap)',
      ]),
      L: { init: 1, outer: 3, inner: 4, cond: 5, swapExec: 6, count: 9, print: 11 },
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
    let fixedFrom = size; // この添字より後ろは位置が確定している
    let pass = null;
    let inner = null;

    /** マスの状態。確定 → 入れ替え中 → 比較中 → それ以外の順で決める。 */
    function cellStates(pair, swapping) {
      const states = [];
      for (let k = 0; k < size; k += 1) {
        if (k >= fixedFrom) states.push('fixed');
        // pair が 0 のときも成り立つように、null かどうかで判定する。
        else if (pair !== null && (k === pair || k === pair + 1))
          states.push(swapping ? 'swap' : 'active');
        else states.push('idle');
      }
      return states;
    }

    function snap(patch) {
      const pair = typeof patch.pair === 'number' ? patch.pair : null;
      const base = {
        values: values.slice(),
        cells: cellStates(pair, patch.swapping === true),
        markers: pair === null ? {} : { [pair]: 'j▼' },
        pass: pass,
        inner: inner,
        compares: compares,
        swaps: swaps,
        changed: [],
        result: null,
        // 入れ替えを動かして見せるための情報（入れ替え前の値と位置）
        swapAnim: null,
      };
      delete patch.pair;
      delete patch.swapping;
      steps.push(Object.assign(base, patch));
    }

    snap({
      line: L.init,
      changed: ['swaps'],
      message:
        '交換した回数を数える変数 swap を 0 にしておきます。' +
        '隣どうしを比べて、大きい方を後ろへ送っていきます。',
    });

    let broke = false;

    for (let i = 0; i < size - 1 && !broke; i += 1) {
      pass = i;
      snap({
        line: L.outer,
        changed: ['pass'],
        message:
          `${i + 1} 回目のパスを始めます（i = ${i}）。` +
          `このパスでは添字 0 から ${size - 2 - i} までの隣どうしを比べます。`,
      });

      let changedInPass = false;

      if (mode === 'earlyExit') {
        snap({
          line: L.reset,
          message:
            'このパスで交換が起きたかどうかを覚えるため、changed を 0 に戻します。',
        });
      }

      for (let j = 0; j <= size - 2 - i; j += 1) {
        inner = j;
        snap({
          line: L.inner,
          pair: j,
          changed: ['inner'],
          message: `j = ${j} にして、Nums[${j}] と Nums[${j + 1}] を比べます。`,
        });

        compares += 1;
        const left = values[j];
        const right = values[j + 1];

        if (left > right) {
          snap({
            line: L.cond,
            pair: j,
            changed: ['compares'],
            message:
              `${left} > ${right} なので順序が逆です。入れ替えが必要です。（比較 ${compares} 回目）`,
          });

          const beforeSwap = values.slice();
          values[j] = right;
          values[j + 1] = left;
          snap({
            line: L.swapExec,
            pair: j,
            swapping: true,
            swapAnim: { a: j, b: j + 1, before: beforeSwap },
            message:
              `temp に ${left} を退避してから入れ替えます。` +
              `Nums[${j}] = ${right}、Nums[${j + 1}] = ${left} になりました。`,
          });

          swaps += 1;
          changedInPass = true;
          snap({
            line: L.count,
            pair: j,
            changed: ['swaps'],
            message:
              mode === 'earlyExit'
                ? `交換回数を1増やして ${swaps} 回。このパスで交換があったので changed = 1 にします。`
                : `交換回数を1増やして ${swaps} 回になりました。`,
          });
        } else {
          snap({
            line: L.cond,
            pair: j,
            changed: ['compares'],
            message:
              `${left} > ${right} は成り立たないので、入れ替えは不要です。次の組へ進みます。（比較 ${compares} 回目）`,
          });
        }
      }

      // このパスで、いちばん大きい値が未確定部分の右端に届く。
      fixedFrom = size - 1 - i;
      inner = null;
      snap({
        line: L.inner,
        // 「1パス進む」でここまで一気に送れるようにする印
        passEnd: true,
        message:
          `${i + 1} 回目のパスが終わりました。` +
          `未確定部分でいちばん大きい ${values[fixedFrom]} が添字 ${fixedFrom} に確定しました。` +
          `次のパスでは、ここより前だけを比べます。`,
      });

      if (mode === 'earlyExit') {
        if (!changedInPass) {
          snap({
            line: L.check,
            message:
              'このパスでは交換が1回も起きませんでした。' +
              'つまり、すでに小さい順に並んでいるということです。',
          });
          fixedFrom = 0;
          snap({
            line: L.brk,
            passEnd: true,
            message: `残りを調べる必要がないので、繰り返しを抜けます。比較は ${compares} 回で終わりました。`,
          });
          broke = true;
        } else {
          snap({
            line: L.check,
            message: 'このパスでは交換があったので（changed が 1）、次のパスへ進みます。',
          });
        }
      }
    }

    fixedFrom = 0;
    pass = null;
    inner = null;
    snap({
      line: L.print,
      passEnd: true,
      result: `[${values.join(', ')}]  /  交換 ${swaps} 回  /  比較 ${compares} 回`,
      message:
        `整列が終わりました。[${values.join(', ')}] になり、交換は ${swaps} 回、比較は ${compares} 回でした。`,
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
      // 末尾の2つだけ入れ替えて「あと1回で終わる」状態にする。
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
      pass: document.getElementById('sim-var-pass'),
      inner: document.getElementById('sim-var-inner'),
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

  /** 直前に描いたステップ番号。1つ進んだときだけ入れ替えを動かして見せる。 */
  let lastIndex = -1;

  function renderStep(step, index, total) {
    if (!step) return;

    window.SimUI.paintCells(refs.array, step);

    if (step.swapAnim && index === lastIndex + 1) {
      // 自動再生中は、次のステップに切り替わる前に動き終わる長さにする。
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

    refs.vars.pass.textContent = step.pass === null ? '–' : String(step.pass);
    refs.vars.inner.textContent = step.inner === null ? '–' : String(step.inner);
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
    // 1〜要素数 の数字を並べ替えて作る（同じ値が混ざらないので追いやすい）。
    const values = [];
    for (let k = 1; k <= state.length; k += 1) values.push(k);
    for (let k = values.length - 1; k > 0; k -= 1) {
      const swapIndex = Math.floor(Math.random() * (k + 1));
      const keep = values[k];
      values[k] = values[swapIndex];
      values[swapIndex] = keep;
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
