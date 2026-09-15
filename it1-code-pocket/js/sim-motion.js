/* =========================================================
   sim-motion.js — 運動シミュレーション
   位置 x と速度 v を決められた順番で更新していく様子を、
   数直線と推移表で見せる。更新の順序を変えると結果が変わることが要点。
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  /** 終わらない書き方のときに、何回で打ち切るか。 */
  const LOOP_LIMIT = 12;

  const CONDITIONS = {
    x10: { label: 'x < 10 の間', goal: 10, kind: 'position' },
    x20: { label: 'x < 20 の間', goal: 20, kind: 'position' },
    vPositive: { label: 'v > 0 の間', goal: null, kind: 'velocity' },
  };

  /* ---------- 擬似コード ---------- */

  function buildCode(speed, order, conditionKey) {
    const condition = CONDITIONS[conditionKey];
    const updates =
      order === 'vFirst'
        ? ['｜v = v - 1', '｜x = x + v']
        : ['｜x = x + v', '｜v = v - 1'];

    return {
      lines: [
        'x = 0',
        `v = ${speed}`,
        't = 0',
        '',
        `${condition.label}繰り返す:`,
        updates[0],
        updates[1],
        '⎿ t = t + 1',
        '',
        '表示する(x, v, t)',
      ],
      L: { init: 2, loop: 4, first: 5, second: 6, tick: 7, print: 9 },
    };
  }

  /* ---------- ステップ生成 ---------- */

  function buildSteps(speed, order, conditionKey) {
    const condition = CONDITIONS[conditionKey];
    const code = buildCode(speed, order, conditionKey);
    const L = code.L;
    const steps = [];

    let x = 0;
    let v = speed;
    let t = 0;
    const history = [{ t: 0, x: 0, v: speed }];

    function keepGoing() {
      return condition.kind === 'velocity' ? v > 0 : x < condition.goal;
    }

    function conditionText() {
      return condition.kind === 'velocity'
        ? `v（${v}）> 0`
        : `x（${x}）< ${condition.goal}`;
    }

    function snap(patch) {
      steps.push(
        Object.assign(
          {
            x: x,
            v: v,
            t: t,
            history: history.map((row) => Object.assign({}, row)),
            changed: [],
            result: null,
            moved: null,
          },
          patch
        )
      );
    }

    snap({
      line: L.init,
      changed: ['x', 'v', 't'],
      message:
        `位置 x = 0、速度 v = ${speed}、時間 t = 0 から始めます。` +
        `「${condition.label}」の間、決まった順番で x と v を更新していきます。`,
    });

    let rounds = 0;
    let stuck = false;

    while (true) {
      if (!keepGoing()) {
        snap({
          line: L.loop,
          message:
            `${conditionText()} が成り立たなくなりました。繰り返しを終わります。`,
        });
        break;
      }

      rounds += 1;
      if (rounds > LOOP_LIMIT) {
        stuck = true;
        break;
      }

      snap({
        line: L.loop,
        message: `${conditionText()} が成り立つので、${rounds} 回目の更新を行います。`,
      });

      // 更新の順序で結果が変わる部分
      if (order === 'vFirst') {
        const beforeV = v;
        v = v - 1;
        snap({
          line: L.first,
          changed: ['v'],
          message:
            `先に速度を更新します。v = ${beforeV} - 1 = ${v} になりました。` +
            'この後の x の更新には、更新後の v が使われます。',
        });

        const beforeX = x;
        x = x + v;
        snap({
          line: L.second,
          changed: ['x'],
          moved: { from: beforeX, to: x },
          message:
            `位置を更新します。x = ${beforeX} + ${v} = ${x} です。` +
            (v < 0 ? '速度が負なので、x は後ろに戻ってしまいます。' : ''),
        });
      } else {
        const beforeX = x;
        x = x + v;
        snap({
          line: L.first,
          changed: ['x'],
          moved: { from: beforeX, to: x },
          message: `先に位置を更新します。x = ${beforeX} + ${v} = ${x} です。`,
        });

        const beforeV = v;
        v = v - 1;
        snap({
          line: L.second,
          changed: ['v'],
          message: `次に速度を更新します。v = ${beforeV} - 1 = ${v} になりました。`,
        });
      }

      t = t + 1;
      history.push({ t: t, x: x, v: v });
      snap({
        line: L.tick,
        changed: ['t'],
        message: `時間を1進めて t = ${t} です。ここまでで x = ${x}、v = ${v} です。`,
      });
    }

    if (stuck) {
      snap({
        line: L.loop,
        result: `${LOOP_LIMIT} 回まで進めても終わりません（このままでは止まりません）`,
        message:
          `${LOOP_LIMIT} 回繰り返しても条件が成り立ち続けています。` +
          (condition.kind === 'position'
            ? `速度が 0 以下になったため x が増えず、${condition.goal} に届きません。この書き方では処理が終わりません。`
            : '条件が成り立ち続けるため、処理が終わりません。'),
      });
      return { steps: steps, code: code.lines, stuck: true };
    }

    snap({
      line: L.print,
      result: `x = ${x} ／ v = ${v} ／ t = ${t}`,
      message:
        `結果は x = ${x}、v = ${v}、t = ${t} です。` +
        '同じ初期値でも、x と v の更新順を入れ替えると結果が変わります。順序を切り替えて比べてみてください。',
    });

    return { steps: steps, code: code.lines, stuck: false };
  }

  /* ---------- 画面 ---------- */

  const state = { speed: 4, order: 'xFirst', condition: 'x10' };
  const refs = {};

  function collectRefs() {
    refs.line = document.getElementById('sim-line');
    refs.ticks = document.getElementById('sim-line-ticks');
    refs.legendGoal = document.getElementById('sim-legend-goal');
    refs.tableBody = document.getElementById('sim-table-body');
    refs.code = document.getElementById('sim-code');
    refs.message = document.getElementById('sim-message-text');
    refs.stepLabel = document.getElementById('sim-message-step');
    refs.result = document.getElementById('sim-result');
    refs.log = document.getElementById('sim-log');
    refs.estimate = document.getElementById('sim-estimate-value');
    refs.estimateSub = document.getElementById('sim-estimate-sub');
    refs.conditionSelect = document.getElementById('sim-input-condition');
    refs.speedChips = Array.from(document.querySelectorAll('[data-sim-speed-value]'));
    refs.orderChips = Array.from(document.querySelectorAll('[data-sim-order]'));
    refs.vars = {
      t: document.getElementById('sim-var-t'),
      x: document.getElementById('sim-var-x'),
      v: document.getElementById('sim-var-v'),
    };
    refs.playBtn = document.querySelector('[data-sim-action="play"]');
    refs.prevBtn = document.querySelector('[data-sim-action="prev"]');
    refs.nextBtn = document.querySelector('[data-sim-action="next"]');
    refs.fillEl = document.getElementById('sim-progress-fill');
  }

  /** 数直線の表示範囲。負の位置も出るので下限も持つ。 */
  function lineRange() {
    const condition = CONDITIONS[state.condition];
    const upper = condition.goal !== null ? condition.goal + 4 : state.speed * 3;
    return { min: -4, max: Math.max(upper, state.speed + 4) };
  }

  function positionPercent(value, range) {
    const ratio = (value - range.min) / (range.max - range.min);
    return Math.max(0, Math.min(100, ratio * 100));
  }

  function buildViews() {
    const range = lineRange();
    const condition = CONDITIONS[state.condition];

    refs.line.innerHTML = '<span class="sim-line-rail"></span>';

    // ゴール線が無い条件（v > 0）のときは、凡例からも消す。
    if (refs.legendGoal) refs.legendGoal.hidden = condition.goal === null;

    if (condition.goal !== null) {
      const goal = document.createElement('span');
      goal.className = 'sim-line-goal';
      goal.style.left = `${positionPercent(condition.goal, range)}%`;
      refs.line.appendChild(goal);

      const label = document.createElement('span');
      label.className = 'sim-line-goal-label';
      label.style.left = `${positionPercent(condition.goal, range)}%`;
      label.textContent = `x = ${condition.goal}`;
      refs.line.appendChild(label);
    }

    const arrow = document.createElement('span');
    arrow.className = 'sim-line-arrow';
    arrow.id = 'sim-line-arrow';
    arrow.hidden = true;
    refs.line.appendChild(arrow);

    const point = document.createElement('span');
    point.className = 'sim-line-point';
    point.id = 'sim-line-point';
    point.textContent = '0';
    point.style.left = `${positionPercent(0, range)}%`;
    refs.line.appendChild(point);

    refs.ticks.innerHTML = '';
    const stepSize = range.max - range.min > 20 ? 5 : 2;
    for (let value = Math.ceil(range.min / stepSize) * stepSize; value <= range.max; value += stepSize) {
      const tick = document.createElement('span');
      tick.className = 'sim-line-tick';
      tick.style.left = `${positionPercent(value, range)}%`;
      tick.textContent = String(value);
      refs.ticks.appendChild(tick);
    }
  }

  function renderStep(step, index, total) {
    if (!step) return;

    const range = lineRange();
    const condition = CONDITIONS[state.condition];

    // 通ってきた位置を打ち直す
    Array.from(refs.line.querySelectorAll('.sim-line-trail')).forEach((dot) =>
      refs.line.removeChild(dot)
    );
    const point = document.getElementById('sim-line-point');
    step.history.forEach((row) => {
      if (row.x === step.x) return;
      const dot = document.createElement('span');
      dot.className = 'sim-line-trail';
      dot.style.left = `${positionPercent(row.x, range)}%`;
      refs.line.insertBefore(dot, point);
    });

    point.style.left = `${positionPercent(step.x, range)}%`;
    point.textContent = String(step.x);
    const reached = condition.goal !== null && step.x >= condition.goal;
    point.setAttribute('data-reached', reached ? 'true' : 'false');

    // 速度を矢印で示す
    const arrow = document.getElementById('sim-line-arrow');
    if (step.v === 0) {
      arrow.hidden = true;
    } else {
      const from = step.v > 0 ? step.x : step.x + step.v;
      const width = Math.abs(step.v);
      arrow.hidden = false;
      arrow.style.left = `${positionPercent(from, range)}%`;
      arrow.style.width = `${(width / (range.max - range.min)) * 100}%`;
      arrow.setAttribute('data-dir', step.v > 0 ? 'forward' : 'back');
    }

    // 推移表
    refs.tableBody.innerHTML = '';
    step.history.forEach((row, k) => {
      const tr = document.createElement('tr');
      if (k === step.history.length - 1) tr.setAttribute('data-state', 'active');
      tr.innerHTML =
        `<th scope="row">${row.t}</th><td>${row.x}</td><td>${row.v}</td>`;
      refs.tableBody.appendChild(tr);
    });

    window.SimUI.setActiveLine(refs.code, step.line);

    refs.vars.t.textContent = String(step.t);
    refs.vars.x.textContent = String(step.x);
    refs.vars.v.textContent = String(step.v);

    Object.keys(refs.vars).forEach((name) => {
      const box = refs.vars[name].closest('.sim-var');
      if (!box) return;
      if (step.changed.indexOf(name) !== -1) {
        box.setAttribute('data-changed', 'true');
      } else {
        box.removeAttribute('data-changed');
      }
    });

    if (step.moved) {
      const delta = step.moved.to - step.moved.from;
      refs.estimate.textContent = `${step.moved.from} → ${step.moved.to}`;
      refs.estimateSub.textContent = `${delta >= 0 ? '+' : ''}${delta} だけ動いた`;
    } else {
      refs.estimate.textContent = `x = ${step.x}`;
      refs.estimateSub.textContent = `v = ${step.v} ／ t = ${step.t}`;
    }

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

  function rebuild() {
    state.condition = refs.conditionSelect.value;
    syncChips();
    buildViews();

    const built = buildSteps(state.speed, state.order, state.condition);
    window.SimUI.renderCode(refs.code, built.code);
    player.load(built.steps);
  }

  function syncChips() {
    refs.speedChips.forEach((chip) => {
      const selected = Number(chip.getAttribute('data-sim-speed-value')) === state.speed;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
    refs.orderChips.forEach((chip) => {
      const selected = chip.getAttribute('data-sim-order') === state.order;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
  }

  function init() {
    collectRefs();
    if (!refs.line || !refs.code) return;

    window.SimUI.bindDefaultStateView(player, refs);
    window.SimUI.bindControls(player, document);
    window.SimUI.bindViewTabs(document);
    window.SimUI.bindTabs(document);

    refs.speedChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.speed = Number(chip.getAttribute('data-sim-speed-value'));
        rebuild();
      });
    });

    refs.orderChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.order = chip.getAttribute('data-sim-order');
        rebuild();
      });
    });

    refs.conditionSelect.addEventListener('change', rebuild);

    rebuild();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
