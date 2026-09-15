/* =========================================================
   sim-core.js — アルゴリズムシミュレーション共通エンジン
   各 sim-*.js は「ステップ配列を作る」「1ステップを描画する」
   だけを担当し、再生・停止・前後移動・速度・ログはここが持つ。
   ========================================================= */

(function () {
  'use strict';

  /** 自動再生の1ステップあたりの待ち時間（ミリ秒）。 */
  const SPEEDS = {
    slow: 1500,
    normal: 850,
    fast: 380,
  };

  /**
   * ステップ配列を順番に再生するプレイヤー。
   * ステップの中身はアルゴリズム側の自由形式で、
   * ここでは「配列の何番目を表示しているか」だけを管理する。
   */
  class SimPlayer {
    constructor(options) {
      const opts = options || {};
      this.steps = [];
      this.index = 0;
      this.playing = false;
      this.interval = SPEEDS.normal;
      this.timer = null;
      this.onRender = opts.onRender || function () {};
      this.onStateChange = opts.onStateChange || function () {};
    }

    get total() {
      return this.steps.length;
    }

    get current() {
      return this.steps[this.index] || null;
    }

    get atStart() {
      return this.index <= 0;
    }

    get atEnd() {
      return this.index >= this.steps.length - 1;
    }

    /** 新しいステップ配列を読み込み、先頭に戻す。 */
    load(steps) {
      this.pause();
      this.steps = Array.isArray(steps) ? steps : [];
      this.index = 0;
      this.render();
    }

    goto(index) {
      if (!this.steps.length) return;
      const clamped = Math.min(Math.max(index, 0), this.steps.length - 1);
      if (clamped === this.index) {
        this.render();
        return;
      }
      this.index = clamped;
      this.render();
    }

    next() {
      if (this.atEnd) {
        this.pause();
        return false;
      }
      this.index += 1;
      this.render();
      return true;
    }

    prev() {
      this.pause();
      if (this.atStart) return false;
      this.index -= 1;
      this.render();
      return true;
    }

    play() {
      if (this.playing || !this.steps.length) return;
      // 末尾で再生を押したら、先頭から見直せるようにする。
      if (this.atEnd) this.goto(0);
      this.playing = true;
      this.timer = window.setInterval(() => {
        if (!this.next()) this.pause();
      }, this.interval);
      this.onStateChange(this);
    }

    pause() {
      if (this.timer !== null) {
        window.clearInterval(this.timer);
        this.timer = null;
      }
      if (this.playing) {
        this.playing = false;
        this.onStateChange(this);
      }
    }

    toggle() {
      if (this.playing) {
        this.pause();
      } else {
        this.play();
      }
    }

    reset() {
      this.pause();
      this.goto(0);
    }

    /**
     * 指定した印が付いた次のステップまで一気に進む。
     * 整列のように1ステップが細かいとき、「1パスぶん」まとめて送るために使う。
     */
    skipTo(flag) {
      this.pause();
      for (let i = this.index + 1; i < this.steps.length; i += 1) {
        if (this.steps[i] && this.steps[i][flag]) {
          this.goto(i);
          return true;
        }
      }
      if (!this.atEnd) this.goto(this.steps.length - 1);
      return false;
    }

    /** 再生中に速度を変えても止まらないように、タイマーを張り直す。 */
    setSpeed(key) {
      this.interval = SPEEDS[key] || SPEEDS.normal;
      if (this.playing) {
        this.pause();
        this.play();
      }
    }

    render() {
      this.onRender(this.current, this.index, this.total);
      this.onStateChange(this);
    }
  }

  /* ---------- 描画ヘルパー ---------- */

  /** 擬似コードを1行ずつ span に分けて描画する（行ハイライト用）。 */
  function renderCode(container, lines) {
    if (!container) return;
    container.innerHTML = '';
    lines.forEach((text) => {
      const line = document.createElement('span');
      line.className = 'sim-code-line';
      const body = document.createElement('span');
      body.className = 'sim-code-text';
      // 空行でも行の高さを保つ。
      body.textContent = text === '' ? ' ' : text;
      line.appendChild(body);
      container.appendChild(line);
    });
  }

  /**
   * 要素数に合わせてマスの大きさを決め、横スクロールなしで収まるようにする。
   * 親要素の実際の幅から1マスの辺を計算し、CSS変数で渡す。
   * 上限を決めてあるので、要素数が少ないときにマスが大きくなりすぎることもない。
   */
  function fitArray(arrayEl, count, options) {
    if (!arrayEl || !count) return;
    const opts = Object.assign(
      { maxSize: 48, minSize: 22, floorSize: 14, gap: 4, tightGap: 2 },
      options || {}
    );
    const wrap = arrayEl.parentElement;
    // clientWidth は自分の padding を含むので、その分を引いて中身の幅を出す。
    let available = 0;
    if (wrap) {
      const style = window.getComputedStyle(wrap);
      const padding =
        (parseFloat(style.paddingLeft) || 0) + (parseFloat(style.paddingRight) || 0);
      available = wrap.clientWidth - padding - 2;
    }

    let gap = opts.gap;
    let size = opts.maxSize;

    if (available > 0) {
      const fitFor = (g) => Math.floor((available - g * (count - 1)) / count);
      size = fitFor(gap);
      // ふつうの間隔で入らなければ、間隔を詰めてマスの大きさを確保する。
      if (size < opts.minSize) {
        gap = opts.tightGap;
        size = fitFor(gap);
      }
      // それでも足りない狭い画面では、はみ出させずに小さく表示する。
      size = Math.min(opts.maxSize, Math.max(opts.floorSize, size));
    }

    arrayEl.style.setProperty('--sim-cell-gap', `${gap}px`);
    arrayEl.style.setProperty('--sim-cell-size', `${size}px`);
    arrayEl.style.setProperty('--sim-cell-font', `${Math.max(10, Math.round(size * 0.42))}px`);
    arrayEl.style.setProperty('--sim-cell-sub', `${Math.max(8, Math.round(size * 0.3))}px`);
  }

  /** 画面幅が変わったときだけ呼び直す（連続発火はまとめる）。 */
  function bindResize(handler) {
    let timer = null;
    window.addEventListener('resize', () => {
      if (timer !== null) window.clearTimeout(timer);
      timer = window.setTimeout(() => {
        timer = null;
        handler();
      }, 120);
    });
    // CDN の CSS が後から効いて幅が変わる場合に備え、読み込み完了後にも一度合わせる。
    window.addEventListener('load', handler);
  }

  /**
   * 要素の幅の変化を見張る。
   * 外側のCSSが後から適用されて幅が変わっても、マスの大きさを合わせ直せる。
   */
  function observeWidth(element, handler) {
    if (!element || typeof window.ResizeObserver !== 'function') return;
    let lastWidth = element.clientWidth;
    const observer = new window.ResizeObserver(() => {
      const width = element.clientWidth;
      if (width === lastWidth) return;
      lastWidth = width;
      handler();
    });
    observer.observe(element);
  }

  /** 配列のマスを組み立てる。値が変わったときだけ呼ぶ。 */
  function buildCells(arrayEl, values) {
    if (!arrayEl) return;
    arrayEl.innerHTML = '';
    values.forEach((value, index) => {
      const cell = document.createElement('li');
      cell.className = 'sim-cell';
      cell.setAttribute('data-state', 'idle');

      const cursor = document.createElement('span');
      cursor.className = 'sim-cell-cursor';

      const box = document.createElement('span');
      box.className = 'sim-cell-box';
      box.textContent = String(value);

      const label = document.createElement('span');
      label.className = 'sim-cell-index';
      label.textContent = `[${index}]`;

      cell.appendChild(cursor);
      cell.appendChild(box);
      cell.appendChild(label);
      arrayEl.appendChild(cell);
    });
  }

  /** 実行中の入れ替えアニメーション（同時に1つだけ動かす）。 */
  let swapAnimation = null;

  /** 動いている途中で次のステップに進んだら、その場で片付ける。 */
  function cancelSwapAnimation() {
    if (swapAnimation) swapAnimation.finish();
  }

  /**
   * 2つのマスが入れ替わる様子を動かして見せる。
   * 値だけが切り替わると分かりにくいので、
   * 左のマスは上を通って右へ、右のマスは下をくぐって左へ動かす。
   *
   * 動きは CSS の @keyframes（animation-fill-mode: forwards）で行い、
   * 移動しきった位置で止める。そのうえで
   * 「マスを元の位置に戻す」と「値を入れ替える」を同じ瞬間に行うため、
   * 見た目は「入れ替わった場所に数字が収まった」状態のまま変わらない。
   *
   * 離れた位置どうしの交換（選択法）にも使えるよう、添字は隣どうしに限らない。
   */
  function animateSwap(arrayEl, indexA, indexB, beforeValues, options) {
    cancelSwapAnimation();
    if (!arrayEl || indexA === indexB) return;

    const opts = Object.assign({ duration: 380 }, options || {});
    const reduceMotion =
      typeof window.matchMedia === 'function' &&
      window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion || opts.duration <= 0) return;

    const cells = arrayEl.querySelectorAll('.sim-cell');
    const leftIndex = Math.min(indexA, indexB);
    const rightIndex = Math.max(indexA, indexB);
    const leftCell = cells[leftIndex];
    const rightCell = cells[rightIndex];
    if (!leftCell || !rightCell) return;

    const leftBox = leftCell.querySelector('.sim-cell-box');
    const rightBox = rightCell.querySelector('.sim-cell-box');
    if (!leftBox || !rightBox) return;

    // 入れ替えたあとの値（paintCells が入れた値）を控えておく。
    const afterLeft = leftBox.textContent;
    const afterRight = rightBox.textContent;

    // いったん入れ替え前の値に戻してから動かす。
    leftBox.textContent = String(beforeValues[leftIndex]);
    rightBox.textContent = String(beforeValues[rightIndex]);

    const style = window.getComputedStyle(arrayEl);
    const size =
      parseFloat(style.getPropertyValue('--sim-cell-size')) || leftBox.offsetWidth || 48;
    const gap = parseFloat(style.getPropertyValue('--sim-cell-gap')) || 6;
    const distance = (rightIndex - leftIndex) * (size + gap);

    leftBox.style.setProperty('--sim-swap-shift', `${distance}px`);
    rightBox.style.setProperty('--sim-swap-shift', `${-distance}px`);
    leftBox.style.animationDuration = `${opts.duration}ms`;
    rightBox.style.animationDuration = `${opts.duration}ms`;
    leftBox.classList.add('is-swap-over');
    rightBox.classList.add('is-swap-under');

    let finished = false;
    let timer = null;

    function finish() {
      if (finished) return;
      finished = true;
      if (timer !== null) window.clearTimeout(timer);
      leftBox.removeEventListener('animationend', finish);

      // 位置を戻す動きが見えないよう、transition を止めてから戻す。
      leftBox.style.transition = 'none';
      rightBox.style.transition = 'none';
      leftBox.classList.remove('is-swap-over');
      rightBox.classList.remove('is-swap-under');
      leftBox.textContent = afterLeft;
      rightBox.textContent = afterRight;
      leftBox.style.removeProperty('--sim-swap-shift');
      rightBox.style.removeProperty('--sim-swap-shift');
      leftBox.style.animationDuration = '';
      rightBox.style.animationDuration = '';

      const restore = () => {
        leftBox.style.transition = '';
        rightBox.style.transition = '';
      };
      if (typeof window.requestAnimationFrame === 'function') {
        window.requestAnimationFrame(restore);
      } else {
        restore();
      }

      swapAnimation = null;
    }

    // 動きが終わった瞬間に確定させる。念のため時間切れでも確定する。
    leftBox.addEventListener('animationend', finish);
    timer = window.setTimeout(finish, opts.duration + 80);

    swapAnimation = { finish: finish };
  }

  /**
   * 1ステップ分の見た目を反映する。
   * step.cells  … マスごとの状態（idle / active / miss / found / dup / skip）
   * step.markers… マスの上に出す目印（{ 添字: "i▼" } など）
   * step.values … 値が入れ替わる場合の表示値
   */
  function paintCells(arrayEl, step) {
    // 前のステップのアニメーションが残っていたら片付けてから描き直す。
    cancelSwapAnimation();
    if (!arrayEl || !step) return;
    const cells = arrayEl.querySelectorAll('.sim-cell');
    cells.forEach((cell, index) => {
      cell.setAttribute('data-state', (step.cells && step.cells[index]) || 'idle');

      const marker = step.markers ? step.markers[index] || '' : '';
      const cursor = cell.querySelector('.sim-cell-cursor');
      if (cursor) cursor.textContent = marker;
      if (marker) {
        cell.setAttribute('data-cursor', 'true');
      } else {
        cell.removeAttribute('data-cursor');
      }

      if (step.values) {
        const box = cell.querySelector('.sim-cell-box');
        if (box) box.textContent = String(step.values[index]);
      }
    });
  }

  /** 実行中の行だけ data-active を立てる。 */
  function setActiveLine(container, lineIndex) {
    if (!container) return;
    const lines = container.querySelectorAll('.sim-code-line');
    lines.forEach((line, i) => {
      if (i === lineIndex) {
        line.setAttribute('data-active', 'true');
      } else {
        line.removeAttribute('data-active');
      }
    });
  }

  /** 先頭から現在ステップまでの説明を実行ログとして並べる。 */
  function renderLog(listEl, steps, index) {
    if (!listEl) return;
    listEl.innerHTML = '';
    for (let i = 0; i <= index && i < steps.length; i += 1) {
      const item = document.createElement('li');
      item.textContent = steps[i].message || '';
      if (i === index) item.setAttribute('data-current', 'true');
      listEl.appendChild(item);
    }
    const last = listEl.lastElementChild;
    if (last) listEl.scrollTop = listEl.scrollHeight;
  }

  /**
   * data-sim-action 付きのボタンとキーボード操作を配線する。
   * action: play / next / prev / reset
   */
  function bindControls(player, root) {
    const scope = root || document;
    scope.querySelectorAll('[data-sim-action]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const action = btn.getAttribute('data-sim-action');
        if (action === 'play') player.toggle();
        else if (action === 'next') player.next();
        else if (action === 'prev') player.prev();
        else if (action === 'reset') player.reset();
      });
    });

    // まとめ送り（例：data-sim-skip="passEnd" で1パスぶん進む）
    scope.querySelectorAll('[data-sim-skip]').forEach((btn) => {
      btn.addEventListener('click', () => {
        player.skipTo(btn.getAttribute('data-sim-skip'));
      });
    });

    // 速さは押しやすいボタンで選ぶ（スマホでプルダウンを開かせない）。
    const speedButtons = Array.from(scope.querySelectorAll('[data-sim-speed-option]'));
    speedButtons.forEach((btn) => {
      btn.addEventListener('click', () => {
        player.setSpeed(btn.getAttribute('data-sim-speed-option'));
        speedButtons.forEach((other) => {
          other.setAttribute('aria-pressed', other === btn ? 'true' : 'false');
        });
      });
    });

    // 押すたびに速さが切り替わるボタン（1つ分の高さで済むので縦を節約できる）。
    const cycleButton = scope.querySelector('[data-sim-speed-cycle]');
    if (cycleButton) {
      const order = ['slow', 'normal', 'fast'];
      const labels = { slow: 'ゆっくり', normal: 'ふつう', fast: 'はやい' };
      let index = order.indexOf(cycleButton.getAttribute('data-sim-speed-cycle'));
      if (index < 0) index = 1;

      const renderLabel = () => {
        cycleButton.textContent = `速さ ${labels[order[index]]}`;
        cycleButton.setAttribute(
          'aria-label',
          `自動再生の速さ：${labels[order[index]]}（押すと切り替わります）`
        );
      };

      cycleButton.addEventListener('click', () => {
        index = (index + 1) % order.length;
        player.setSpeed(order[index]);
        renderLabel();
      });

      renderLabel();
    }

    // 入力欄にいるときは矢印キーを奪わない。
    document.addEventListener('keydown', (event) => {
      const tag = (event.target && event.target.tagName) || '';
      if (tag === 'INPUT' || tag === 'SELECT' || tag === 'TEXTAREA') return;
      if (event.key === 'ArrowRight') {
        event.preventDefault();
        player.pause();
        player.next();
      } else if (event.key === 'ArrowLeft') {
        event.preventDefault();
        player.prev();
      } else if (event.key === ' ' || event.key === 'Spacebar') {
        event.preventDefault();
        player.toggle();
      }
    });
  }

  /** 再生ボタンの文字と、前へ/次への活性状態を現在位置に合わせる。 */
  function bindDefaultStateView(player, refs) {
    player.onStateChange = function (p) {
      if (refs.playBtn) {
        refs.playBtn.textContent = p.playing ? '⏸ 停止' : '▶ 自動再生';
      }
      if (refs.prevBtn) refs.prevBtn.disabled = p.atStart;
      if (refs.nextBtn) refs.nextBtn.disabled = p.atEnd;
      if (refs.countEl) {
        refs.countEl.textContent = p.total ? `${p.index + 1} / ${p.total}` : '0 / 0';
      }
      if (refs.fillEl) {
        const ratio = p.total > 1 ? (p.index / (p.total - 1)) * 100 : 0;
        refs.fillEl.style.width = `${ratio}%`;
      }
    };
  }

  /**
   * カンマ・空白区切りの整数列を読み取る。
   * 失敗したら理由を message に入れて返す（画面にそのまま出す）。
   */
  function parseNumberList(text, options) {
    const opts = Object.assign(
      { min: 0, max: 99, minLength: 2, maxLength: 12 },
      options || {}
    );
    const tokens = String(text)
      .replace(/[，、]/g, ',')
      .split(/[,\s]+/)
      .filter((token) => token !== '');

    if (tokens.length < opts.minLength) {
      return { ok: false, message: `数値を ${opts.minLength} 個以上入力してください。` };
    }
    if (tokens.length > opts.maxLength) {
      return { ok: false, message: `数値は ${opts.maxLength} 個までにしてください。` };
    }

    const values = [];
    for (const token of tokens) {
      if (!/^-?\d+$/.test(token)) {
        return { ok: false, message: `「${token}」は整数として読み取れません。` };
      }
      const value = Number(token);
      if (value < opts.min || value > opts.max) {
        return {
          ok: false,
          message: `${opts.min} 以上 ${opts.max} 以下の整数で入力してください。`,
        };
      }
      values.push(value);
    }
    return { ok: true, values: values };
  }

  /** 整数1個を読み取る。 */
  function parseNumber(text, options) {
    const opts = Object.assign({ min: 0, max: 99 }, options || {});
    const token = String(text).trim();
    if (!/^-?\d+$/.test(token)) {
      return { ok: false, message: '探す値は整数で入力してください。' };
    }
    const value = Number(token);
    if (value < opts.min || value > opts.max) {
      return {
        ok: false,
        message: `探す値は ${opts.min} 以上 ${opts.max} 以下で入力してください。`,
      };
    }
    return { ok: true, value: value };
  }

  /**
   * 表示の切り替えタブ（配列 ⇔ コード）。
   * 画面が広いときはタブを隠して両方並べて表示する。
   * 縦に長くならないようにするための仕組みなので、横に余裕があれば不要になる。
   */
  function bindViewTabs(root, options) {
    const scope = root || document;
    const opts = Object.assign({ showBothWidth: 900 }, options || {});
    const tablist = scope.querySelector('[data-sim-view-tabs]');
    if (!tablist) return;

    const tabs = Array.from(tablist.querySelectorAll('[role="tab"]'));
    if (!tabs.length) return;

    let selected = tabs.findIndex((tab) => tab.getAttribute('aria-selected') === 'true');
    if (selected < 0) selected = 0;

    // matchMedia が無い環境でも動くように、幅の判定手段を用意しておく。
    const media =
      typeof window.matchMedia === 'function'
        ? window.matchMedia(`(min-width: ${opts.showBothWidth}px)`)
        : null;

    function canShowBoth() {
      return media ? media.matches : window.innerWidth >= opts.showBothWidth;
    }

    function apply() {
      const showBoth = canShowBoth();
      tablist.hidden = showBoth;
      tabs.forEach((tab, index) => {
        tab.setAttribute('aria-selected', index === selected ? 'true' : 'false');
        const panel = document.getElementById(tab.getAttribute('aria-controls'));
        if (panel) panel.hidden = !(showBoth || index === selected);
      });
    }

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => {
        selected = index;
        apply();
      });
    });

    if (media && typeof media.addEventListener === 'function') {
      media.addEventListener('change', apply);
    } else if (media && typeof media.addListener === 'function') {
      media.addListener(apply);
    } else {
      window.addEventListener('resize', apply);
    }

    apply();
  }

  /** コードタブ（擬似コード / Python / JavaScript）を切り替える。 */
  function bindTabs(root) {
    const scope = root || document;
    scope.querySelectorAll('[data-sim-tabs]').forEach((group) => {
      const tabs = Array.from(group.querySelectorAll('[role="tab"]'));
      tabs.forEach((tab) => {
        tab.addEventListener('click', () => {
          tabs.forEach((other) => {
            const selected = other === tab;
            other.setAttribute('aria-selected', selected ? 'true' : 'false');
            const panel = document.getElementById(
              other.getAttribute('aria-controls')
            );
            if (panel) panel.hidden = !selected;
          });
        });
      });
    });
  }

  window.SimPlayer = SimPlayer;
  window.SimUI = {
    SPEEDS: SPEEDS,
    renderCode: renderCode,
    setActiveLine: setActiveLine,
    buildCells: buildCells,
    paintCells: paintCells,
    animateSwap: animateSwap,
    cancelSwapAnimation: cancelSwapAnimation,
    fitArray: fitArray,
    bindResize: bindResize,
    observeWidth: observeWidth,
    renderLog: renderLog,
    bindControls: bindControls,
    bindDefaultStateView: bindDefaultStateView,
    bindTabs: bindTabs,
    bindViewTabs: bindViewTabs,
    parseNumberList: parseNumberList,
    parseNumber: parseNumber,
  };
})();
