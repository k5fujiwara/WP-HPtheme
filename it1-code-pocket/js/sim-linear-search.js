/* =========================================================
   sim-linear-search.js — 線形探索シミュレーション
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  /* ---------- 擬似コード ---------- */

  /**
   * 表示する擬似コードを、いま画面に出ている配列と target で組み立てる。
   * コードとシミュレーションの数値がずれないよう、必ずここから作る。
   */
  function buildCode(nums, target, mode) {
    const head = [
      `Nums = [${nums.join(', ')}]`,
      `target = ${target}`,
      'pos = -1',
      '',
      'i を 0 から 要素数(Nums) - 1 まで 1 ずつ増やしながら繰り返す:',
    ];

    if (mode === 'firstOnly') {
      return {
        lines: head.concat([
          '｜もし Nums[i] == target ならば:',
          '｜｜pos = i',
          '⎿⎿ 繰り返しを抜ける',
          '',
          '表示する(pos)',
        ]),
        L: { init: 2, loop: 4, cond: 5, assign: 6, brk: 7, print: 9 },
      };
    }

    return {
      lines: head.concat([
        '｜もし Nums[i] == target かつ pos == -1 ならば:',
        '⎿⎿ pos = i',
        '',
        '表示する(pos)',
      ]),
      L: { init: 2, loop: 4, cond: 5, assign: 6, print: 8 },
    };
  }

  /* ---------- ステップ生成 ---------- */

  /**
   * 1ステップ = 画面をまるごと描き直すためのスナップショット。
   * 前へ戻る操作を単純にするため、差分ではなく毎回全状態を持たせる。
   */
  function buildSteps(nums, target, mode) {
    const code = buildCode(nums, target, mode);
    const L = code.L;
    const steps = [];
    const cells = nums.map(() => 'idle');

    let pos = -1;
    let compares = 0;

    function snap(patch) {
      steps.push(
        Object.assign(
          {
            cells: cells.slice(),
            i: null,
            cursor: null,
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
      changed: ['pos'],
      message:
        `配列 Nums と探したい値 target（${target}）を用意します。` +
        'pos は「見つかった位置」を入れる変数で、まだ見つかっていない印として -1 にしておきます。',
    });

    let done = false;

    for (let k = 0; k < nums.length && !done; k += 1) {
      // 注目している要素を先に示してから、比較の判定を見せる。
      cells[k] = 'active';
      snap({
        line: L.loop,
        i: k,
        cursor: k,
        changed: ['i'],
        message:
          `i = ${k} にします。配列の先頭から ${k + 1} 番目、Nums[${k}] を調べます。`,
      });

      compares += 1;
      const hit = nums[k] === target;

      if (mode === 'firstOnly') {
        if (hit) {
          cells[k] = 'found';
          snap({
            line: L.cond,
            i: k,
            cursor: k,
            changed: ['compares'],
            message:
              `Nums[${k}] は ${nums[k]} で、target（${target}）と等しいので条件が成り立ちます。` +
              `ここまでの比較回数は ${compares} 回です。`,
          });

          pos = k;
          snap({
            line: L.assign,
            i: k,
            cursor: k,
            changed: ['pos'],
            message: `見つかった位置を pos に記録します。pos = ${k} になりました。`,
          });

          snap({
            line: L.brk,
            i: k,
            cursor: k,
            message:
              '目的の値が見つかったので、繰り返しを抜けます。' +
              'これ以降の要素は一度も調べません。',
          });
          done = true;
        } else {
          cells[k] = 'miss';
          snap({
            line: L.cond,
            i: k,
            cursor: k,
            changed: ['compares'],
            message:
              `Nums[${k}] は ${nums[k]} で、target（${target}）とは違います。` +
              `条件が成り立たないので次の要素へ進みます。（比較 ${compares} 回目）`,
          });
        }
      } else if (hit && pos === -1) {
        cells[k] = 'found';
        snap({
          line: L.cond,
          i: k,
          cursor: k,
          changed: ['compares'],
          message:
            `Nums[${k}] は ${nums[k]} で target と一致し、pos はまだ -1 なので、` +
            `条件「Nums[i] == target かつ pos == -1」が成り立ちます。（比較 ${compares} 回目）`,
        });

        pos = k;
        snap({
          line: L.assign,
          i: k,
          cursor: k,
          changed: ['pos'],
          message:
            `pos = ${k} を記録します。この後 pos は -1 ではなくなるので、` +
            '同じ値が再び現れても上書きされません。',
        });
      } else if (hit) {
        cells[k] = 'dup';
        snap({
          line: L.cond,
          i: k,
          cursor: k,
          changed: ['compares'],
          message:
            `Nums[${k}] は ${nums[k]} で target と一致しますが、pos はすでに ${pos} です。` +
            '「pos == -1」が成り立たないため記録は更新しません。（比較 ' +
            `${compares} 回目）`,
        });
      } else {
        cells[k] = 'miss';
        snap({
          line: L.cond,
          i: k,
          cursor: k,
          changed: ['compares'],
          message:
            `Nums[${k}] は ${nums[k]} で target（${target}）とは違うので、何もせず次へ進みます。` +
            `（比較 ${compares} 回目）`,
        });
      }
    }

    // 打ち切りモードで抜けた場合、残りは一度も見ていないことを示す。
    if (mode === 'firstOnly' && pos !== -1) {
      for (let k = pos + 1; k < nums.length; k += 1) cells[k] = 'skip';
    }

    const found = pos !== -1;
    const resultText = found
      ? `pos = ${pos}（Nums[${pos}] = ${nums[pos]}）／ 比較 ${compares} 回`
      : `pos = -1（${target} は配列にありません）／ 比較 ${compares} 回`;

    snap({
      line: L.print,
      cursor: null,
      result: resultText,
      message: found
        ? `繰り返しが終わりました。pos = ${pos} を表示します。` +
          `${target} は添字 ${pos} にありました。比較した回数は ${compares} 回です。`
        : `最後の要素まで調べても target（${target}）は見つかりませんでした。` +
          `pos は -1 のままで、これが「見つからなかった」ことを表します。比較は ${compares} 回でした。`,
    });

    return { steps: steps, code: code.lines };
  }

  /* ---------- 画面の組み立て ---------- */

  /** 要素数ごとの見本配列。値は固定なので、何度開いても同じ結果を確認できる。 */
  const SAMPLE_BASE = {
    4: [4, 9, 2, 6],
    5: [4, 9, 2, 7, 6],
    6: [4, 9, 2, 7, 5, 6],
    7: [4, 9, 2, 7, 5, 3, 6],
    8: [4, 9, 2, 7, 5, 3, 8, 6],
    9: [4, 9, 2, 7, 5, 3, 8, 1, 6],
    10: [4, 9, 2, 7, 5, 3, 8, 1, 10, 6],
  };

  const MIN_LENGTH = 4;
  const MAX_LENGTH = 10;

  /** 配列に現れていない、いちばん小さい正の整数（「見つからない」用の target）。 */
  function firstMissing(nums) {
    for (let value = 1; value <= 99; value += 1) {
      if (nums.indexOf(value) === -1) return value;
    }
    return 99;
  }

  /**
   * 要素数と場面から見本を組み立てる。
   * 同じ要素数でも「先頭／末尾／見つからない／同じ値が2つ」を切り替えて比べられる。
   */
  function buildSample(length, scenario) {
    const nums = (SAMPLE_BASE[length] || SAMPLE_BASE[5]).slice();

    if (scenario === 'dup') {
      // 後ろ寄りの1つを2番目の値と同じにして、重複がある配列にする。
      nums[nums.length - 2] = nums[1];
      return { nums: nums, target: nums[1] };
    }
    if (scenario === 'head') return { nums: nums, target: nums[0] };
    if (scenario === 'last') return { nums: nums, target: nums[nums.length - 1] };
    return { nums: nums, target: firstMissing(nums) };
  }

  /** いま選ばれている要素数と場面。手入力されたら scenario は null にする。 */
  const state = { length: 5, scenario: 'dup' };

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
    refs.numsInput = document.getElementById('sim-input-nums');
    refs.targetInput = document.getElementById('sim-input-target');
    refs.modeSelect = document.getElementById('sim-input-mode');
    refs.lengthChips = Array.from(document.querySelectorAll('[data-sim-length]'));
    refs.scenarioChips = Array.from(document.querySelectorAll('[data-sim-scenario]'));
    refs.vars = {
      i: document.getElementById('sim-var-i'),
      pos: document.getElementById('sim-var-pos'),
      compares: document.getElementById('sim-var-compares'),
    };
    refs.playBtn = document.querySelector('[data-sim-action="play"]');
    refs.prevBtn = document.querySelector('[data-sim-action="prev"]');
    refs.nextBtn = document.querySelector('[data-sim-action="next"]');
    refs.countEl = document.getElementById('sim-progress-count');
    refs.fillEl = document.getElementById('sim-progress-fill');
  }

  /**
   * マスの大きさの上限。スマホでは縦を節約するため少し小さくする
   * （CSS の .sim-array の min-height と合わせている）。
   */
  function cellOptions() {
    return { maxSize: window.innerWidth < 900 ? 40 : 48 };
  }

  /** 配列のマスを作り直す。値が変わったときだけ呼ぶ。 */
  function renderArray(nums) {
    // 要素数が多くても横スクロールにならないよう、マスの大きさを先に決める。
    window.SimUI.fitArray(refs.array, nums.length, cellOptions());
    window.SimUI.buildCells(refs.array, nums);
  }

  function renderStep(step, index, total) {
    if (!step) return;

    window.SimUI.paintCells(refs.array, {
      cells: step.cells,
      markers: step.cursor === null ? {} : { [step.cursor]: 'i▼' },
    });

    window.SimUI.setActiveLine(refs.code, step.line);

    refs.vars.i.textContent = step.i === null ? '–' : String(step.i);
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

  /** 入力欄の内容でシミュレーションを作り直す。 */
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

    refs.targetView.textContent = String(target);
    renderArray(nums);

    const built = buildSteps(nums, target, mode);
    window.SimUI.renderCode(refs.code, built.code);
    player.load(built.steps);
  }

  function showError(message) {
    if (!message) {
      refs.error.hidden = true;
      refs.error.textContent = '';
      return;
    }
    refs.error.textContent = message;
    refs.error.hidden = false;
  }

  /** 選択中の要素数・場面をチップの見た目に反映する。 */
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

  /** state の要素数・場面から見本を入力欄に入れ、作り直す。 */
  function applySample() {
    const sample = buildSample(state.length, state.scenario);
    refs.numsInput.value = sample.nums.join(', ');
    refs.targetInput.value = String(sample.target);
    rebuild();
  }

  /** ランダム生成。選んだ要素数はそのまま使う。 */
  function randomize() {
    const nums = [];
    for (let k = 0; k < state.length; k += 1) {
      nums.push(1 + Math.floor(Math.random() * 20));
    }
    // 見つかる場合を多めにして、探索が成功する動きを観察しやすくする。
    const target =
      Math.random() < 0.75
        ? nums[Math.floor(Math.random() * nums.length)]
        : 1 + Math.floor(Math.random() * 20);

    state.scenario = null;
    refs.numsInput.value = nums.join(', ');
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

    // 手入力したときは、どの見本にも当てはまらない状態にする。
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
        // 場面を選んでいないときは、要素数だけ変えた配列を見せる。
        if (!state.scenario) state.scenario = 'head';
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

    // 幅が変わったら、マスの大きさだけ合わせ直す（再生位置はそのまま）。
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
