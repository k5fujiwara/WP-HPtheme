/**
 * トップ・自己紹介ページの小さな動き
 * - スクロールで要素が順に現れる / 見出しの下線を引く
 * - 「4つの軸」と板書（FVのコード）の連動ハイライト
 * - 自己紹介の数字をカウントアップ
 * 板書のタイピングと蛍光ペンは CSS だけで動く（このファイルが無くても成立する）。
 * 動きを減らす設定（prefers-reduced-motion）のときは何もしない。
 */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ---- 4つの軸 ⇔ 板書の連動（動きではなく強調なので常に有効） ----
  function initAxisLink() {
    var axes = document.querySelectorAll('.home-axes__item[data-axis]');
    if (!axes.length) return;

    var setLinked = function (key, on) {
      document.querySelectorAll('[data-axis="' + key + '"]').forEach(function (el) {
        el.classList.toggle('is-linked', on);
      });
    };

    axes.forEach(function (item) {
      var key = item.getAttribute('data-axis');
      ['mouseenter', 'focusin'].forEach(function (type) {
        item.addEventListener(type, function () { setLinked(key, true); });
      });
      ['mouseleave', 'focusout'].forEach(function (type) {
        item.addEventListener(type, function () { setLinked(key, false); });
      });
    });

    // 板書の書き込み（赤ペン）にマウスを乗せたときも、対応する軸を強調
    document.querySelectorAll('.home-board__note[data-axis]').forEach(function (note) {
      var key = note.getAttribute('data-axis');
      note.addEventListener('mouseenter', function () { setLinked(key, true); });
      note.addEventListener('mouseleave', function () { setLinked(key, false); });
    });
  }

  // ---- スクロールで順に現れる ----
  var REVEAL_SELECTORS = [
    '.home-axes__item',
    '.home-rank__item',
    '.home-latest__lead',
    '.home-latest__list li',
    '.work-tile',
    '.home-classroom__list li',
    '.home-classroom__news',
    '.home-author',
    '.ab-facts__item',
    '.ab-services__item',
    '.about-portfolio__case',
    '.about-sections .about-section',
    '.ab-cta'
  ];

  function initReveal() {
    if (reduceMotion || !('IntersectionObserver' in window)) return;

    var viewH = window.innerHeight || document.documentElement.clientHeight;
    var targets = [];

    document.querySelectorAll(REVEAL_SELECTORS.join(',')).forEach(function (el) {
      // 最初から画面内にあるものは動かさない（ちらつき防止）
      if (el.getBoundingClientRect().top < viewH * 0.92) return;
      // 同じ親の中で少しずつ遅らせる
      var index = Array.prototype.indexOf.call(el.parentNode.children, el) % 6;
      el.style.setProperty('--reveal-delay', (index * 70) + 'ms');
      el.classList.add('reveal');
      targets.push(el);
    });

    // 見出しの下線は「引く」
    document.querySelectorAll('.home-head, .about-section--portfolio > .about-section__title').forEach(function (el) {
      if (el.getBoundingClientRect().top < viewH * 0.92) return;
      el.classList.add('reveal-line');
      targets.push(el);
    });

    if (!targets.length) return;

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-inview');
        io.unobserve(entry.target);
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

    targets.forEach(function (el) { io.observe(el); });
  }

  // ---- 数字のカウントアップ ----
  function initCountUp() {
    var nums = document.querySelectorAll('[data-count]');
    if (!nums.length || reduceMotion || !('IntersectionObserver' in window)) return;

    var run = function (el) {
      var target = parseInt(el.getAttribute('data-count'), 10);
      if (!(target > 0)) return;
      var start = null;
      var duration = Math.min(1400, 500 + target * 8);
      var step = function (ts) {
        if (start === null) start = ts;
        var t = Math.min(1, (ts - start) / duration);
        var eased = 1 - Math.pow(1 - t, 3);
        el.textContent = String(Math.round(target * eased));
        if (t < 1) window.requestAnimationFrame(step);
      };
      window.requestAnimationFrame(step);
      // 描画が止まる環境（裏タブ等）でも、必ず最終値を表示する
      window.setTimeout(function () { el.textContent = String(target); }, duration + 300);
    };

    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        run(entry.target);
        io.unobserve(entry.target);
      });
    }, { threshold: 0.6 });

    nums.forEach(function (el) { io.observe(el); });
  }

  var init = function () {
    initAxisLink();
    initReveal();
    initCountUp();
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
