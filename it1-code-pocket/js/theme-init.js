(function initThemeBeforePaint() {
  try {
    const theme = localStorage.getItem('quiz-theme');
    if (['simple', 'cool', 'pop'].includes(theme)) {
      document.documentElement.setAttribute('data-theme', theme);
    }
  } catch {
    // localStorage が使えない環境では初期テーマのまま表示する。
  }
})();
