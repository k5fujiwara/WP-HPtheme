/* =========================================================
   sim-queue.js — 待ち行列シミュレーション
   到着時刻・開始時刻・終了時刻・待ち時間を1人ずつ求めていく様子を
   帯グラフと表で見せる。
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  const MIN_PEOPLE = 3;
  const MAX_PEOPLE = 8;

  /* ---------- 到着時刻の見本 ---------- */

  /**
   * 混み具合ごとの到着時刻。
   * service（1人あたりの対応時間）との関係で待ちが出るかどうかが決まる。
   */
  function buildArrivals(people, scenario, service) {
    const arrivals = [];

    if (scenario === 'same') {
      for (let k = 0; k < people; k += 1) arrivals.push(0);
      return arrivals;
    }

    if (scenario === 'easy') {
      // 対応時間より長い間隔で来るので、待ちは出ない。
      const gap = service + 2;
      for (let k = 0; k < people; k += 1) arrivals.push(k * gap);
      return arrivals;
    }

    if (scenario === 'busy') {
      // 1分おきに来るので、待ちがどんどん積み上がる。
      for (let k = 0; k < people; k += 1) arrivals.push(k);
      return arrivals;
    }

    // ふつう：待つ人と待たない人が混ざる並び。
    const base = [0, 3, 6, 7, 11, 12, 16, 19];
    for (let k = 0; k < people; k += 1) arrivals.push(base[k]);
    return arrivals;
  }

  /* ---------- 擬似コード ---------- */

  function buildCode(arrivals, service) {
    const zeros = arrivals.map(() => 0).join(', ');
    return {
      lines: [
        `Arrive = [${arrivals.join(', ')}]`,
        `service = ${service}`,
        `Start = [${zeros}]`,
        `Finish = [${zeros}]`,
        '',
        'Start[0] = Arrive[0]',
        'Finish[0] = Start[0] + service',
        '',
        'i を 1 から 要素数(Arrive) - 1 まで 1 ずつ増やしながら繰り返す:',
        '｜Start[i] = 最大値(Arrive[i], Finish[i - 1])',
        '⎿ Finish[i] = Start[i] + service',
        '',
        '表示する(Start, Finish)',
      ],
      L: { init: 2, first: 5, firstFinish: 6, loop: 8, start: 9, finish: 10, print: 12 },
    };
  }

  /* ---------- ステップ生成 ---------- */

  function buildSteps(arrivals, service) {
    const code = buildCode(arrivals, service);
    const L = code.L;
    const steps = [];
    const size = arrivals.length;
    const start = arrivals.map(() => null);
    const finish = arrivals.map(() => null);

    let current = null;

    function waits() {
      return start.map((value, index) => (value === null ? null : value - arrivals[index]));
    }

    function snap(patch) {
      steps.push(
        Object.assign(
          {
            start: start.slice(),
            finish: finish.slice(),
            waits: waits(),
            current: current,
            changed: [],
            result: null,
          },
          patch
        )
      );
    }

    snap({
      line: L.init,
      message:
        `お客さんの到着時刻が Arrive、1人あたりの対応時間が service = ${service} 分です。` +
        '開始時刻 Start と終了時刻 Finish を1人ずつ求めていきます。',
    });

    current = 0;
    start[0] = arrivals[0];
    snap({
      line: L.first,
      changed: ['start'],
      message:
        `最初のお客さんは待つ相手がいないので、到着した ${arrivals[0]} 分にそのまま開始できます。Start[0] = ${arrivals[0]} です。`,
    });

    finish[0] = start[0] + service;
    snap({
      line: L.firstFinish,
      changed: ['finish'],
      message: `終了時刻は開始 + 対応時間なので、Finish[0] = ${start[0]} + ${service} = ${finish[0]} です。`,
    });

    for (let i = 1; i < size; i += 1) {
      current = i;
      snap({
        line: L.loop,
        changed: ['current'],
        message: `${i + 1} 人目（i = ${i}）を考えます。到着時刻は ${arrivals[i]} 分です。`,
      });

      const previousFinish = finish[i - 1];
      const arrival = arrivals[i];
      const waited = previousFinish > arrival;
      start[i] = Math.max(arrival, previousFinish);

      snap({
        line: L.start,
        changed: ['start'],
        message: waited
          ? `到着 ${arrival} 分より、前の人の終了 ${previousFinish} 分のほうが遅いです。` +
            `まだ空いていないので ${previousFinish} 分まで待ちます。Start[${i}] = ${start[i]}（待ち ${start[i] - arrival} 分）。`
          : `到着 ${arrival} 分のほうが、前の人の終了 ${previousFinish} 分より遅い（または同じ）です。` +
            `すでに空いているので待たずに始められます。Start[${i}] = ${start[i]}（待ち 0 分）。`,
      });

      finish[i] = start[i] + service;
      snap({
        line: L.finish,
        changed: ['finish'],
        message: `Finish[${i}] = ${start[i]} + ${service} = ${finish[i]} です。`,
      });
    }

    current = null;
    const waitList = waits();
    const totalWait = waitList.reduce((sum, value) => sum + value, 0);
    const maxWait = waitList.reduce((best, value) => Math.max(best, value), 0);
    const average = totalWait / size;

    snap({
      line: L.print,
      result:
        `Start = [${start.join(', ')}] ／ 待ち時間 = [${waitList.join(', ')}] ／ ` +
        `最大 ${maxWait} 分・平均 ${average.toFixed(1)} 分`,
      message:
        `全員分が決まりました。待ち時間の合計は ${totalWait} 分、最大は ${maxWait} 分、平均は ${average.toFixed(1)} 分です。` +
        (maxWait === 0
          ? '誰も待たずに済んでいます。到着の間隔が対応時間より長いためです。'
          : '前の人の終了を待つ場面があると、待ち時間が後ろの人へ積み上がっていきます。'),
    });

    return { steps: steps, code: code.lines };
  }

  /* ---------- 画面 ---------- */

  const state = { people: 4, scenario: 'normal', service: 4 };
  const refs = {};
  let arrivals = [];

  function collectRefs() {
    refs.timeline = document.getElementById('sim-timeline');
    refs.axis = document.getElementById('sim-timeline-axis');
    refs.tableBody = document.getElementById('sim-table-body');
    refs.code = document.getElementById('sim-code');
    refs.message = document.getElementById('sim-message-text');
    refs.stepLabel = document.getElementById('sim-message-step');
    refs.result = document.getElementById('sim-result');
    refs.log = document.getElementById('sim-log');
    refs.estimate = document.getElementById('sim-estimate-value');
    refs.estimateSub = document.getElementById('sim-estimate-sub');
    refs.serviceSelect = document.getElementById('sim-input-service');
    refs.peopleChips = Array.from(document.querySelectorAll('[data-sim-people]'));
    refs.scenarioChips = Array.from(document.querySelectorAll('[data-sim-scenario]'));
    refs.vars = {
      current: document.getElementById('sim-var-current'),
      arrive: document.getElementById('sim-var-arrive'),
      start: document.getElementById('sim-var-start'),
      finish: document.getElementById('sim-var-finish'),
      wait: document.getElementById('sim-var-wait'),
    };
    refs.playBtn = document.querySelector('[data-sim-action="play"]');
    refs.prevBtn = document.querySelector('[data-sim-action="prev"]');
    refs.nextBtn = document.querySelector('[data-sim-action="next"]');
    refs.fillEl = document.getElementById('sim-progress-fill');
  }

  /** 帯グラフと表の枠を作り直す（人数が変わったときだけ）。 */
  function buildViews() {
    const total = Math.max(1, arrivals[arrivals.length - 1] + state.service * arrivals.length);

    refs.timeline.innerHTML = '';
    arrivals.forEach((arrival, index) => {
      const row = document.createElement('div');
      row.className = 'sim-timeline-row';
      row.setAttribute('data-state', 'pending');
      row.innerHTML =
        `<span class="sim-timeline-label">${index + 1}人目</span>` +
        '<span class="sim-timeline-track">' +
        '<span class="sim-timeline-arrive"></span>' +
        '<span class="sim-timeline-bar" data-kind="wait" hidden></span>' +
        '<span class="sim-timeline-bar" data-kind="service" hidden></span>' +
        '</span>';
      refs.timeline.appendChild(row);
    });

    refs.tableBody.innerHTML = '';
    arrivals.forEach((arrival, index) => {
      const tr = document.createElement('tr');
      tr.setAttribute('data-state', 'pending');
      tr.innerHTML =
        `<th scope="row">${index + 1}</th>` +
        `<td>${arrival}</td>` +
        '<td data-cell="start">–</td>' +
        '<td data-cell="finish">–</td>' +
        '<td data-cell="wait">–</td>';
      refs.tableBody.appendChild(tr);
    });

    // 時間の目盛り
    refs.axis.innerHTML = '';
    const stepSize = total <= 20 ? 5 : total <= 50 ? 10 : 20;
    for (let t = 0; t <= total; t += stepSize) {
      const tick = document.createElement('span');
      tick.className = 'sim-timeline-tick';
      tick.style.left = `${(t / total) * 100}%`;
      tick.textContent = String(t);
      refs.axis.appendChild(tick);
    }
    refs.axis.setAttribute('data-total', String(total));
  }

  function renderStep(step, index, total) {
    if (!step) return;

    const span = Number(refs.axis.getAttribute('data-total')) || 1;
    const rows = refs.timeline.children;
    const tableRows = refs.tableBody.children;

    arrivals.forEach((arrival, k) => {
      const row = rows[k];
      const tableRow = tableRows[k];
      if (!row || !tableRow) return;

      const startValue = step.start[k];
      const finishValue = step.finish[k];
      const waitValue = step.waits[k];
      const decided = startValue !== null;

      row.setAttribute(
        'data-state',
        step.current === k ? 'active' : decided ? 'done' : 'pending'
      );
      tableRow.setAttribute(
        'data-state',
        step.current === k ? 'active' : decided ? 'done' : 'pending'
      );

      const arriveMark = row.querySelector('.sim-timeline-arrive');
      arriveMark.style.left = `${(arrival / span) * 100}%`;

      const waitBar = row.querySelector('[data-kind="wait"]');
      const serviceBar = row.querySelector('[data-kind="service"]');

      if (decided && waitValue > 0) {
        waitBar.hidden = false;
        waitBar.style.left = `${(arrival / span) * 100}%`;
        waitBar.style.width = `${(waitValue / span) * 100}%`;
      } else {
        waitBar.hidden = true;
      }

      if (decided && finishValue !== null) {
        serviceBar.hidden = false;
        serviceBar.style.left = `${(startValue / span) * 100}%`;
        serviceBar.style.width = `${((finishValue - startValue) / span) * 100}%`;
        serviceBar.textContent = `${startValue}〜${finishValue}`;
      } else {
        serviceBar.hidden = true;
      }

      tableRow.querySelector('[data-cell="start"]').textContent =
        startValue === null ? '–' : String(startValue);
      tableRow.querySelector('[data-cell="finish"]').textContent =
        finishValue === null ? '–' : String(finishValue);
      tableRow.querySelector('[data-cell="wait"]').textContent =
        waitValue === null ? '–' : String(waitValue);
    });

    window.SimUI.setActiveLine(refs.code, step.line);

    const i = step.current;
    refs.vars.current.textContent = i === null ? '–' : String(i);
    refs.vars.arrive.textContent = i === null ? '–' : String(arrivals[i]);
    refs.vars.start.textContent =
      i === null || step.start[i] === null ? '–' : String(step.start[i]);
    refs.vars.finish.textContent =
      i === null || step.finish[i] === null ? '–' : String(step.finish[i]);
    refs.vars.wait.textContent =
      i === null || step.waits[i] === null ? '–' : String(step.waits[i]);

    Object.keys(refs.vars).forEach((name) => {
      const box = refs.vars[name].closest('.sim-var');
      if (!box) return;
      if (step.changed.indexOf(name) !== -1) {
        box.setAttribute('data-changed', 'true');
      } else {
        box.removeAttribute('data-changed');
      }
    });

    const decidedWaits = step.waits.filter((value) => value !== null);
    if (decidedWaits.length) {
      const maxWait = decidedWaits.reduce((best, value) => Math.max(best, value), 0);
      const sum = decidedWaits.reduce((total2, value) => total2 + value, 0);
      refs.estimate.textContent = `${maxWait} 分`;
      refs.estimateSub.textContent = `ここまで ${decidedWaits.length} 人 ／ 合計 ${sum} 分`;
    } else {
      refs.estimate.textContent = '–';
      refs.estimateSub.textContent = 'まだ決まっていません';
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
    state.service = Number(refs.serviceSelect.value) || 4;
    arrivals = buildArrivals(state.people, state.scenario, state.service);
    syncChips();
    buildViews();

    const built = buildSteps(arrivals, state.service);
    window.SimUI.renderCode(refs.code, built.code);
    player.load(built.steps);
  }

  function syncChips() {
    refs.peopleChips.forEach((chip) => {
      const selected = Number(chip.getAttribute('data-sim-people')) === state.people;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
    refs.scenarioChips.forEach((chip) => {
      const selected = chip.getAttribute('data-sim-scenario') === state.scenario;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
  }

  function init() {
    collectRefs();
    if (!refs.timeline || !refs.code) return;

    window.SimUI.bindDefaultStateView(player, refs);
    window.SimUI.bindControls(player, document);
    window.SimUI.bindViewTabs(document);
    window.SimUI.bindTabs(document);

    refs.peopleChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.people = Math.min(
          MAX_PEOPLE,
          Math.max(MIN_PEOPLE, Number(chip.getAttribute('data-sim-people')))
        );
        rebuild();
      });
    });

    refs.scenarioChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.scenario = chip.getAttribute('data-sim-scenario');
        rebuild();
      });
    });

    refs.serviceSelect.addEventListener('change', rebuild);

    rebuild();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
