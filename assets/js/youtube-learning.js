(function() {
  function fitTitle(title) {
    if (!title) return;

    title.style.fontSize = '';
    title.style.letterSpacing = '';

    var computed = window.getComputedStyle(title);
    var maxSize = parseFloat(computed.fontSize);
    var isSmallScreen = window.matchMedia('(max-width: 640px)').matches;
    var minSize = isSmallScreen ? 10 : 16;
    var size = maxSize;

    title.style.whiteSpace = 'nowrap';

    while (title.scrollWidth > title.clientWidth && size > minSize) {
      size -= 0.5;
      title.style.fontSize = size + 'px';
    }

    if (title.scrollWidth > title.clientWidth && isSmallScreen) {
      title.style.letterSpacing = '-0.08em';
    }
  }

  function fitTitles() {
    var titles = document.querySelectorAll(
      '.youtube-learning-archive-page .page-title, .youtube-learning-detail .page-title'
    );
    titles.forEach(fitTitle);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', fitTitles);
  } else {
    fitTitles();
  }

  window.addEventListener('load', fitTitles);

  if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(fitTitles);
  }

  window.addEventListener('resize', function() {
    window.requestAnimationFrame(fitTitles);
  });
})();
