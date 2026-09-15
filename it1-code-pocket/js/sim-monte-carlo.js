/* =========================================================
   sim-monte-carlo.js — モンテカルロ法シミュレーション
   正方形の中にランダムな点を打ち、円の内側に入った割合から
   円周率を近似する様子を見せる。
   sim-core.js の SimPlayer / SimUI に依存する。
   ========================================================= */

(function () {
  'use strict';

  const TRIAL_CHOICES = [10, 20, 50, 100, 500, 1000];
  /** 1試行ずつ見せるのはこの回数まで。それより多いときはまとめて進める。 */
  const DETAIL_LIMIT = 20;
  /** まとめて進めるときの、おおよそのステップ数。 */
  const BATCH_STEPS = 20;
  /** 描画する点の上限（多すぎると重くなるため間引く）。 */
  const MAX_DOTS = 600;

  /* ---------- 擬似コード ---------- */

  function buildCode(trials) {
    return {
      lines: [
        'inside = 0',
        `trial = ${trials}`,
        '',
        'i を 1 から trial まで 1 ずつ増やしながら繰り返す:',
        '｜x = 0以上1未満の乱数',
        '｜y = 0以上1未満の乱数',
        '｜もし x × x + y × y <= 1 ならば:',
        '⎿⎿ inside = inside + 1',
        '',
        'pi = 4 × inside ÷ trial',
        '表示する(pi)',
      ],
      L: { init: 0, loop: 3, randX: 4, randY: 5, cond: 6, count: 7, calc: 9, print: 10 },
    };
  }

  /* ---------- 点の生成 ---------- */

  /** 試行回数ぶんの点をまとめて作る。ステップを戻しても同じ結果になる。 */
  function makePoints(trials) {
    const points = [];
    for (let k = 0; k < trials; k += 1) {
      const x = Math.random();
      const y = Math.random();
      points.push({ x: x, y: y, inside: x * x + y * y <= 1 });
    }
    return points;
  }

  /* ---------- ステップ生成 ---------- */

  function buildSteps(points, trials) {
    const code = buildCode(trials);
    const L = code.L;
    const steps = [];
    let inside = 0;

    function estimate(done) {
      return done > 0 ? (4 * inside) / done : 0;
    }

    function snap(patch) {
      steps.push(
        Object.assign(
          {
            done: 0,
            inside: inside,
            lastIndex: null,
            pi: null,
            changed: [],
            result: null,
          },
          patch
        )
      );
    }

    snap({
      line: L.init,
      changed: ['inside'],
      message:
        '正方形（1辺 1）の中にランダムな点を打ち、原点からの距離が 1 以下（＝円の内側）に入った数を inside で数えます。' +
        `試行回数は ${trials} 回です。`,
    });

    if (trials <= DETAIL_LIMIT) {
      // 1試行を「乱数を作る」「判定して数える」の2ステップで見せる。
      for (let k = 0; k < trials; k += 1) {
        const point = points[k];
        snap({
          line: L.randX,
          done: k,
          lastIndex: k,
          pending: true,
          changed: ['done'],
          message:
            `${k + 1} 回目の試行です。乱数で x = ${point.x.toFixed(3)}、y = ${point.y.toFixed(3)} の点を作りました。`,
        });

        const distance = point.x * point.x + point.y * point.y;
        if (point.inside) inside += 1;
        snap({
          line: point.inside ? L.count : L.cond,
          done: k + 1,
          lastIndex: k,
          changed: point.inside ? ['inside'] : [],
          message: point.inside
            ? `x × x + y × y = ${distance.toFixed(3)} で 1 以下なので、円の内側です。inside を1増やして ${inside} 個になりました。`
            : `x × x + y × y = ${distance.toFixed(3)} で 1 より大きいので、円の外側です。inside は ${inside} 個のままです。`,
        });
      }
    } else {
      // 回数が多いときは、まとめて進めて全体の傾向を見せる。
      const batch = Math.ceil(trials / BATCH_STEPS);
      let done = 0;
      while (done < trials) {
        const next = Math.min(done + batch, trials);
        let hits = 0;
        for (let k = done; k < next; k += 1) {
          if (points[k].inside) {
            inside += 1;
            hits += 1;
          }
        }
        const from = done + 1;
        done = next;
        snap({
          line: L.loop,
          done: done,
          lastIndex: done - 1,
          changed: ['done', 'inside'],
          message:
            `${from} 〜 ${done} 回目までを進めました。この区間では ${hits} 個が円の内側でした。` +
            `ここまでの合計は ${done} 回中 ${inside} 個で、近似値は ${estimate(done).toFixed(4)} です。`,
        });
      }
    }

    const pi = (4 * inside) / trials;
    snap({
      line: L.calc,
      done: trials,
      pi: pi,
      changed: ['pi'],
      message:
        `すべての試行が終わりました。${trials} 回のうち ${inside} 個が円の内側です。` +
        `4 × ${inside} ÷ ${trials} = ${pi.toFixed(4)} が円周率の近似値になります。`,
    });

    snap({
      line: L.print,
      done: trials,
      pi: pi,
      result: `π ≒ ${pi.toFixed(4)}（真の値 3.14159… との差は ${Math.abs(pi - Math.PI).toFixed(4)}）`,
      message:
        `近似値は ${pi.toFixed(4)} でした。真の円周率 3.14159… との差は ${Math.abs(pi - Math.PI).toFixed(4)} です。` +
        '試行回数を増やすほど、この差は小さくなりやすくなります（ただし毎回同じにはなりません）。',
    });

    return { steps: steps, code: code.lines };
  }

  /* ---------- 画面 ---------- */

  const state = { trials: 20 };
  const refs = {};
  let points = [];
  /** 描画済みの点の数（増減分だけ描き足す・取り除く）。 */
  let drawnCount = 0;
  let dotStep = 1;

  function collectRefs() {
    refs.plot = document.getElementById('sim-plot-dots');
    refs.code = document.getElementById('sim-code');
    refs.message = document.getElementById('sim-message-text');
    refs.stepLabel = document.getElementById('sim-message-step');
    refs.result = document.getElementById('sim-result');
    refs.log = document.getElementById('sim-log');
    refs.estimate = document.getElementById('sim-estimate-value');
    refs.estimateSub = document.getElementById('sim-estimate-sub');
    refs.trialChips = Array.from(document.querySelectorAll('[data-sim-trials]'));
    refs.vars = {
      done: document.getElementById('sim-var-done'),
      inside: document.getElementById('sim-var-inside'),
      ratio: document.getElementById('sim-var-ratio'),
      pi: document.getElementById('sim-var-pi'),
    };
    refs.playBtn = document.querySelector('[data-sim-action="play"]');
    refs.prevBtn = document.querySelector('[data-sim-action="prev"]');
    refs.nextBtn = document.querySelector('[data-sim-action="next"]');
    refs.fillEl = document.getElementById('sim-progress-fill');
  }

  const SVG_NS = 'http://www.w3.org/2000/svg';

  /** 点を1つ作る。座標は 0〜100 の図に合わせ、y は上下を反転する。 */
  function createDot(point) {
    const dot = document.createElementNS(SVG_NS, 'circle');
    dot.setAttribute('class', 'sim-plot-dot');
    dot.setAttribute('cx', (point.x * 100).toFixed(2));
    dot.setAttribute('cy', (100 - point.y * 100).toFixed(2));
    dot.setAttribute('r', '1.6');
    dot.setAttribute('data-hit', point.inside ? 'in' : 'out');
    return dot;
  }

  /** 表示する点の数を count 個に合わせる。 */
  function drawDots(count) {
    if (!refs.plot) return;

    if (count < drawnCount) {
      // 戻ったぶんだけ取り除く
      while (drawnCount > count) {
        const index = drawnCount - 1;
        if (index % dotStep === 0) {
          const last = refs.plot.lastChild;
          if (last) refs.plot.removeChild(last);
        }
        drawnCount -= 1;
      }
      return;
    }

    while (drawnCount < count) {
      if (drawnCount % dotStep === 0) {
        refs.plot.appendChild(createDot(points[drawnCount]));
      }
      drawnCount += 1;
    }
  }

  /** いま打った点を目立たせる（1試行ずつ見せているときだけ）。 */
  function highlightLast(index, pending) {
    if (!refs.plot) return;
    Array.from(refs.plot.querySelectorAll('[data-hit^="new"]')).forEach((dot) => {
      dot.setAttribute('r', '1.6');
      dot.setAttribute('data-hit', dot.getAttribute('data-was') || 'in');
      dot.removeAttribute('data-was');
    });
    if (index === null || index === undefined) return;
    const dots = refs.plot.childNodes;
    const dot = dots[Math.min(index, dots.length - 1)];
    if (!dot || !dot.setAttribute) return;
    const hit = dot.getAttribute('data-hit');
    dot.setAttribute('data-was', hit);
    dot.setAttribute('data-hit', pending ? 'new-out' : `new-${hit}`);
    dot.setAttribute('r', '3.2');
  }

  function renderStep(step, index, total) {
    if (!step) return;

    // 判定前の点も打っておきたいので、pending のときは1つ先まで描く。
    drawDots(step.pending ? step.done + 1 : step.done);
    if (state.trials <= DETAIL_LIMIT) {
      highlightLast(step.lastIndex, step.pending === true);
    }

    window.SimUI.setActiveLine(refs.code, step.line);

    const ratio = step.done > 0 ? step.inside / step.done : 0;
    const estimate = step.done > 0 ? (4 * step.inside) / step.done : 0;

    refs.vars.done.textContent = String(step.done);
    refs.vars.inside.textContent = String(step.inside);
    refs.vars.ratio.textContent = step.done > 0 ? ratio.toFixed(3) : '–';
    refs.vars.pi.textContent = step.pi === null ? '–' : step.pi.toFixed(4);

    refs.estimate.textContent = step.done > 0 ? estimate.toFixed(4) : '–';
    refs.estimateSub.textContent =
      step.done > 0
        ? `4 × ${step.inside} ÷ ${step.done}`
        : 'まだ点を打っていません';

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

  function rebuild() {
    points = makePoints(state.trials);
    dotStep = Math.max(1, Math.ceil(state.trials / MAX_DOTS));

    if (refs.plot) refs.plot.innerHTML = '';
    drawnCount = 0;

    syncChips();

    const built = buildSteps(points, state.trials);
    window.SimUI.renderCode(refs.code, built.code);
    player.load(built.steps);
  }

  function syncChips() {
    refs.trialChips.forEach((chip) => {
      const selected = Number(chip.getAttribute('data-sim-trials')) === state.trials;
      chip.setAttribute('aria-pressed', selected ? 'true' : 'false');
    });
  }

  function init() {
    collectRefs();
    if (!refs.plot || !refs.code) return;

    window.SimUI.bindDefaultStateView(player, refs);
    window.SimUI.bindControls(player, document);
    window.SimUI.bindViewTabs(document);
    window.SimUI.bindTabs(document);

    refs.trialChips.forEach((chip) => {
      chip.addEventListener('click', () => {
        state.trials = Number(chip.getAttribute('data-sim-trials'));
        rebuild();
      });
    });

    const randomBtn = document.querySelector('[data-sim-random]');
    if (randomBtn) randomBtn.addEventListener('click', rebuild);

    rebuild();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // テストから試行回数の選択肢を確認できるようにしておく。
  window.SIM_MONTE_CARLO_TRIALS = TRIAL_CHOICES;
})();
