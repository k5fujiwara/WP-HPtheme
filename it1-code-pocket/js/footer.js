function applySavedTheme() {
  const savedTheme = localStorage.getItem('quiz-theme');
  if (['simple', 'cool', 'pop'].includes(savedTheme)) {
    document.documentElement.setAttribute('data-theme', savedTheme);
    document.body.setAttribute('data-theme', savedTheme);
  }
}

function it1HomeUrl() {
  if (window.IT1_HP && window.IT1_HP.quizHome) return window.IT1_HP.quizHome;
  const match = window.location.pathname.match(/^(.*?\/it1-code-pocket)(?:\/|$)/);
  return window.location.origin + (match ? match[1] : '/it1-code-pocket') + '/';
}

function renderSiteFooter() {
  const mount = document.getElementById('site-footer');
  if (!mount) return;

  if (mount.children.length > 0) return;

  const path = window.location.pathname.replace(/\/+$/, '');
  const isTopPage = /\/it1-code-pocket$/.test(path);
  const home = it1HomeUrl();
  const hp = window.IT1_HP || {};
  const shareUrl = encodeURIComponent(home);
  const xShareUrl = encodeURIComponent(home + (home.includes('?') ? '&' : '?') + 'share=x');
  const shareText = encodeURIComponent('IT1-CODE-POCKET | 情報Ⅰ 第3問対策');
  const lineShareText = encodeURIComponent('IT1-CODE-POCKET | 情報Ⅰ 第3問対策\n' + home);
  const shareLinks = isTopPage
    ? `
      <div class="site-footer-share" aria-label="SNSで共有">
        <a class="site-footer-share-btn share-x" href="https://twitter.com/intent/tweet?text=${shareText}&url=${xShareUrl}" target="_blank" rel="noopener noreferrer">Xで共有</a>
        <a class="site-footer-share-btn share-line" href="https://line.me/R/share?text=${lineShareText}">LINEで共有</a>
        <a class="site-footer-share-btn share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=${shareUrl}" target="_blank" rel="noopener noreferrer">Facebook</a>
      </div>
    `
    : '';

  const examples = hp.examples || (home + 'question-examples/');
  const guide = hp.guide || (home + 'study-guide/');
  const about = hp.about || '/about/';
  const privacy = hp.privacy || '/privacy-policy/';
  const contact = hp.contact || '/contact/';
  const terms = hp.disclaimer || '/disclaimer/';

  mount.innerHTML = `
    <footer class="site-footer">
      ${shareLinks}
      <nav class="site-footer-links" aria-label="サイト情報">
        <a href="${examples}">問題例と解き方</a>
        <a href="${guide}">学習ガイド</a>
        <a href="${about}">このサイトについて</a>
        <a href="${privacy}">プライバシーポリシー</a>
        <a href="${contact}">お問い合わせ</a>
        <a href="${terms}">利用規約・免責事項</a>
      </nav>
      <p class="site-footer-copy">© IT1-CODE-POCKET</p>
    </footer>
  `;
}

document.addEventListener('DOMContentLoaded', () => {
  applySavedTheme();
  renderSiteFooter();
});
