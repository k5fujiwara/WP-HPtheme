/**
 * 学習コラム：カテゴリ/ページネーションをAJAXで切替（ページ全体リロードなし）
 * - JSが無効な環境では通常遷移（aタグのhref）でフォールバック
 */
(function () {
  'use strict';

  function initLearningColumnFiltersAjax() {
    const page = document.querySelector('.learning-column-page');
    if (!page) return;

    const filters = page.querySelector('.learning-column-filters');
    const results = page.querySelector('[data-learning-column-results]');
    if (!filters || !results) return;

    let inflight = null;

    const isSameOrigin = (url) => {
      try {
        return new URL(url, window.location.href).origin === window.location.origin;
      } catch (_) {
        return false;
      }
    };

    const setActiveFromURL = (urlString) => {
      let url;
      try {
        url = new URL(urlString, window.location.href);
      } catch (_) {
        return;
      }
      const catsParam = url.searchParams.get('cats') || '';
      const legacyCat = url.searchParams.get('cat') || '';
      const selected =
        (catsParam ? catsParam.split(',')[0] : legacyCat || '').trim() || '';
      const items = filters.querySelectorAll('.learning-column-filters__item');
      items.forEach((a) => {
        if (a.classList.contains('is-all')) {
          a.classList.toggle('is-active', selected === '');
          return;
        }
        const aCat = (a.dataset && a.dataset.cat) || '';
        a.classList.toggle('is-active', aCat ? aCat === selected : false);
      });
    };

    const swapFromHTML = (htmlText, nextURL) => {
      const doc = new DOMParser().parseFromString(htmlText, 'text/html');
      const nextResults = doc.querySelector('[data-learning-column-results]');
      const nextFilters = doc.querySelector('.learning-column-filters');
      if (!nextResults) return false;

      results.innerHTML = nextResults.innerHTML;

      // フィルター側はDOMごと差し替え（active状態含む）
      if (nextFilters) {
        filters.innerHTML = nextFilters.innerHTML;
      }

      setActiveFromURL(nextURL || window.location.href);
      return true;
    };

    const load = async (url, { push = true } = {}) => {
      if (!isSameOrigin(url)) return;
      if (inflight) inflight.abort();

      const controller = new AbortController();
      inflight = controller;

      page.classList.add('is-loading');

      try {
        const res = await fetch(url, {
          method: 'GET',
          credentials: 'same-origin',
          headers: { 'X-Requested-With': 'fetch' },
          signal: controller.signal,
        });
        if (!res.ok) throw new Error('fetch failed: ' + res.status);
        const html = await res.text();
        const ok = swapFromHTML(html, url);
        if (!ok) return;

        if (push) {
          window.history.pushState({ mythemeLearningColumn: true }, '', url);
        }
        setActiveFromURL(url);
      } catch (e) {
        if (e && e.name === 'AbortError') return;
        window.location.href = url;
      } finally {
        page.classList.remove('is-loading');
        inflight = null;
      }
    };

    const handleClick = (e) => {
      const a = e.target && e.target.closest ? e.target.closest('a') : null;
      if (!a) return;
      if (a.target === '_blank' || a.hasAttribute('download')) return;
      if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
      if (!isSameOrigin(a.href)) return;

      const isFilter = !!a.closest('.learning-column-filters');
      const isPager = !!a.closest('.pagination');
      if (!isFilter && !isPager) return;

      e.preventDefault();
      if (isFilter) {
        const nextURL = a.href;
        setActiveFromURL(nextURL);
        load(nextURL, { push: true });
        return;
      }

      load(a.href, { push: true });
    };

    page.addEventListener('click', handleClick);

    window.addEventListener('popstate', () => {
      load(window.location.href, { push: false });
    });

    setActiveFromURL(window.location.href);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLearningColumnFiltersAjax);
  } else {
    initLearningColumnFiltersAjax();
  }
})();

