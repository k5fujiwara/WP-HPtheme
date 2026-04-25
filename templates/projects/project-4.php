<?php
/**
 * Template Name: プロジェクト詳細 - プロジェクト4
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// 開発作品一覧ページのURLを取得
$works_page = get_page_by_path('works');
$works_url = $works_page ? get_permalink($works_page->ID) : home_url('/works/');
?>

<?php while ( have_posts() ) : the_post(); ?>
    <article class="page-content project-detail">
        <?php mytheme_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title">BeEngineer Programming Camp<br>合宿案内サイト</h1>
        </header>

        <!-- プロジェクト画像 -->
        <div class="project-hero">
            <?php echo mytheme_picture_tag('assets/images/beengineer_camp_1.png', 'BeEngineer合宿案内サイト - トップページ', 'project-hero__image', 'eager'); ?>
        </div>

        <div class="project-gallery">
            <div class="gallery-item">
                <?php echo mytheme_picture_tag('assets/images/beengineer_camp_2.png', 'BeEngineer合宿案内サイト - 持ち物リスト', 'gallery-item__image gallery-item__image--16x9', 'lazy'); ?>
                <p class="gallery-caption" style="min-height: 2.4em;">持ち物リスト</p>
            </div>
            <div class="gallery-item">
                <?php echo mytheme_picture_tag('assets/images/beengineer_camp_3.png', 'BeEngineer合宿案内サイト - お問い合わせ', 'gallery-item__image gallery-item__image--16x9', 'lazy'); ?>
                <p class="gallery-caption" style="min-height: 2.4em;">お問い合わせ</p>
            </div>
        </div>

        <div class="project-content">
            <!-- プロジェクト概要 -->
            <section class="project-section">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin: 0 0 16px;">
                    <h2 class="project-section__title" style="margin: 0;">プロジェクト概要</h2>
                    <a class="back-link__anchor" href="https://keigo-fujiwara.github.io/public_beengineer_camp25/" target="_blank" rel="noopener noreferrer" style="text-wrap: nowrap; margin-bottom: 16px;">
                        合宿案内サイトはこちら
                    </a>
                </div>
                <p class="project-section__text">BeEngineerプログラミング合宿（2025年11月22日〜24日）向けの情報提供サイト。ロゴスランド京都での2泊3日に必要な情報をまとめ、<strong>HTML5/CSS3/Vanilla JavaScriptのみで構成した軽量・静的サイト</strong>です。レスポンシブデザインでPC/タブレット/スマホに対応し、合宿中のスケジュール・持ち物・アクセス・フロア案内を一元化します。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">参加者への情報提供を効率化（スケジュール・持ち物・アクセス）</li>
                    <li class="feature-list__item">フレームワーク不使用で軽量なレスポンシブサイトを構築</li>
                    <li class="feature-list__item">タブ/アコーディオンなどインタラクティブUIの実装</li>
                    <li class="feature-list__item">チェックリストの状態をlocalStorageで保持し、再訪問時に復元</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">HTML5</span>
                    <span class="tech-tag">CSS3</span>
                    <span class="tech-tag">JavaScript (ES6+)</span>
                </div>

                <h3 class="tech-category">フロントエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Vanilla JavaScript</span>
                    <span class="tech-tag">CSS Custom Properties</span>
                    <span class="tech-tag">CSS Grid / Flexbox</span>
                    <span class="tech-tag">Intersection Observer</span>
                </div>

                <h3 class="tech-category">データ管理・API</h3>
                <div class="tech-stack">
                    <span class="tech-tag">localStorage</span>
                    <span class="tech-tag">Google Maps埋め込み</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>

                <h3 class="feature-heading">1. レスポンシブナビゲーション</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">PC: 固定サイドバー + セクション内リンク</li>
                    <li class="feature-list__item">SP: ハンバーガーメニュー + スライドメニュー</li>
                    <li class="feature-list__item">スクロールスパイで現在セクションをハイライト</li>
                </ul>

                <h3 class="feature-heading">2. インタラクティブUI</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">スケジュール：1日目/2日目/3日目のタブ切り替え</li>
                    <li class="feature-list__item">アクセス：車・電車/バス・京都駅タブ切り替え</li>
                    <li class="feature-list__item">フロアマップ：1F/2F/3F切り替え</li>
                    <li class="feature-list__item">SPではアコーディオンで情報を整理</li>
                </ul>

                <h3 class="feature-heading">3. 持ち物チェックリスト</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">チェック状態をlocalStorageに保存・復元</li>
                    <li class="feature-list__item">チェック済みを視覚的にフィードバック</li>
                </ul>

                <h3 class="feature-heading">4. ブログ（day1/day2/day3）</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">日別の写真ギャラリー</li>
                    <li class="feature-list__item">前後日のナビゲーション</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">ページ構成</h3>
                    <div class="dataflow">
                        <div class="flow-item">index.html（トップ）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">セクション（案内/日程/プログラム/フロア/持ち物/アクセス）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">blog/day1.html / day2.html / day3.html</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">assets（fav, logos, blog images）</div>
                    </div>

                    <h3 class="system-architecture__title" style="margin-top: 32px;">データフロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">ユーザー操作（チェックリスト）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">localStorageへ保存</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">再訪時に復元しUIへ反映</div>
                    </div>
                </div>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>

                <h3 class="feature-heading">1. Intersection Observerでスクロールスパイ</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">const observer = new IntersectionObserver(observerCallback, {
  root: null,
  rootMargin: '-20% 0px -70% 0px',
  threshold: 0
});
sections.forEach(section => observer.observe(section));</code></pre>
                </div>

                <h3 class="feature-heading">2. localStorageでチェックリスト状態を永続化</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">checklistItems.forEach(item => {
  const key = item.dataset.item;
  if (localStorage.getItem(key) === 'true') {
    item.checked = true;
    item.parentElement.classList.add('checked');
  }
});</code></pre>
                </div>

                <h3 class="feature-heading">3. CSS変数でテーマ管理</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">:root {
  --color-primary: #0E8B62;
  --color-secondary: #F47F2E;
  --color-accent: #FF6B6B;
  --color-bg: #FAFAF8;
}</code></pre>
                </div>
            </section>

            <!-- ファイル構成 -->
            <section class="project-section">
                <h2 class="project-section__title">ファイル構成</h2>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">BeEnCamp/
├── index.html
├── styles.css
├── script.js
├── blog/
│   ├── day1.html
│   ├── day2.html
│   └── day3.html
└── assets/
    ├── fav/
    ├── logos/
    └── blog/images/</code></pre>
                </div>
            </section>

            <!-- デザインシステム -->
            <section class="project-section">
                <h2 class="project-section__title">デザインシステム</h2>
                <div class="feature-table-wrapper">
                    <table class="feature-table">
                        <thead class="feature-table__head">
                            <tr>
                                <th class="feature-table__header-cell">カテゴリ</th>
                                <th class="feature-table__header-cell">カラー名</th>
                                <th class="feature-table__header-cell">カラーコード</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">メイン</td>
                                <td class="feature-table__cell">Primary</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#0E8B62</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">メイン</td>
                                <td class="feature-table__cell">Secondary</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#F47F2E</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">アクセント</td>
                                <td class="feature-table__cell">Accent</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#FF6B6B</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">背景</td>
                                <td class="feature-table__cell">Background</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#FAFAF8</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="feature-list" style="margin-top:16px;">
                    <li class="feature-list__item">フォント: 'Segoe UI', 'Yu Gothic UI', 'Meiryo', sans-serif</li>
                    <li class="feature-list__item">タイトル: 2.5rem / 本文: 1rem</li>
                    <li class="feature-list__item">行間: 1.7</li>
                </ul>
            </section>

            <!-- 活用シーン -->
            <section class="project-section">
                <h2 class="project-section__title">活用シーン</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">イベント・合宿の案内サイト</li>
                    <li class="feature-list__item">教育機関のイベント告知・レポート</li>
                    <li class="feature-list__item">シンプルなLPテンプレートとして再利用</li>
                </ul>
            </section>

            <!-- 開発情報 -->
            <section class="project-section">
                <h2 class="project-section__title">開発情報</h2>
                <div class="project-info-grid">
                    <div class="info-item">
                        <h3 class="info-item__title">開発形態</h3>
                        <p class="info-item__text">個人開発</p>
                    </div>
                    <div class="info-item">
                        <h3 class="info-item__title">役割</h3>
                        <p class="info-item__text">フロントエンド / UI/UX / デザイン</p>
                    </div>
                    <div class="info-item">
                        <h3 class="info-item__title">期間</h3>
                        <p class="info-item__text">2025年11月（約1ヶ月）</p>
                    </div>
                </div>
            </section>

            <!-- パフォーマンス・セキュリティ -->
            <section class="project-section">
                <h2 class="project-section__title">パフォーマンス・セキュリティ</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">静的サイトで高速表示・脆弱性が少ない</li>
                    <li class="feature-list__item">XSS対策: innerHTMLを避けtextContentを使用</li>
                    <li class="feature-list__item">外部リソースはGoogle Mapsのみ</li>
                    <li class="feature-list__item">localStorageのみを利用し個人情報を扱わない</li>
                </ul>
            </section>

            <!-- 開発時の注意事項 -->
            <section class="project-section">
                <h2 class="project-section__title">開発時の注意事項</h2>
                <div class="disclaimer-box">
                    <p class="disclaimer-box__text"><strong>本サイトは合宿参加者向けの情報提供を目的としており、以下に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>デザイン・著作権</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">画像・ロゴは適切な権利範囲で使用（許諾確認済み）</li>
                        <li class="feature-list__item">カラーパレットやアイコンも許諾確認済み</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>技術的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">モダンブラウザ向け（IE非対応）</li>
                        <li class="feature-list__item">静的サイト構成でサーバーサイド依存を最小化</li>
                        <li class="feature-list__item">JavaScript無効時も基本情報は閲覧可能</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>アクセシビリティ</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">セマンティックHTMLで構造化し、キーボード操作に配慮</li>
                        <li class="feature-list__item">コントラスト比を確保、スクリーンリーダー対応は継続改善予定</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>プライバシー</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">個人情報を収集しない（localStorageはチェックリスト状態のみ）</li>
                        <li class="feature-list__item">外部リソースは信頼できるもの（Google Maps）に限定</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin: 0 0 12px;">
                    <h2 class="project-section__title" style="margin: 0;">デモ動画</h2>
                    <a class="back-link__anchor" href="https://keigo-fujiwara.github.io/public_beengineer_camp25/" target="_blank" rel="noopener noreferrer" style="text-wrap: nowrap;">
                        合宿案内サイトはこちら
                    </a>
                </div>
                <p class="project-section__text" style="margin-top: 0;">実際の合宿案内サイトの動作を動画でご覧いただけます。</p>
                <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000;">
                    <iframe src="https://www.youtube.com/embed/p38oM7Z5viM?si=iX_xIrVRePTAp5oU" title="YouTube video player" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0; border-radius:12px;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>ロゴスランド京都</strong>: 会場の提供</li>
                    <li class="feature-list__item"><strong>BeEngineer</strong>: 合宿の企画・運営</li>
                    <li class="feature-list__item"><strong>MDN Web Docs</strong>: Web技術ドキュメント</li>
                </ul>
            </section>
        </div>

        <div class="back-link" style="margin: 16px 0; text-align: center;">
            <a class="back-link__anchor" href="https://keigo-fujiwara.github.io/public_beengineer_camp25/" target="_blank" rel="noopener noreferrer">
                合宿案内サイトはこちら
            </a>
        </div>

        <div class="back-link">
            <a class="back-link__anchor" href="<?php echo esc_url( $works_url ); ?>">← 開発作品一覧に戻る</a>
        </div>
    </article>

    <!-- 構造化データ: SoftwareApplication -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "BeEngineer Programming Camp - 合宿案内サイト",
        "description": "BeEngineerプログラミング合宿向けの情報提供サイト。HTML/CSS/JSのみで構築した軽量・レスポンシブな静的サイト。",
        "applicationCategory": "WebApplication",
        "operatingSystem": "Any (Web Browser)",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "JPY"
        },
        "author": {
            "@type": "Person",
            "name": "<?php echo esc_js( get_the_author_meta('display_name') ); ?>",
            "url": "<?php echo esc_url( home_url('/about/') ); ?>"
        },
        "datePublished": "2025-11-01T00:00:00+09:00",
        "image": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/beengineer_1.png' ); ?>",
        "screenshot": [
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/beengineer_1.png' ); ?>",
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/beengineer_2.png' ); ?>",
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/beengineer_3.png' ); ?>"
        ],
        "softwareVersion": "1.0",
        "programmingLanguage": ["HTML5", "CSS3", "JavaScript"],
        "keywords": "BeEngineer, プログラミング合宿, 案内サイト, レスポンシブ, Vanilla JS, CSS Grid, localStorage"
    }
    </script>
    
    <!-- 関連ページセクション -->
    <?php 
    $related_pages = mytheme_get_related_pages(get_the_ID(), 3);
    if (!empty($related_pages)): 
    ?>
    <section class="related-pages">
        <h2 class="related-pages-title">関連ページ</h2>
        <div class="related-pages-grid">
            <?php foreach ($related_pages as $page): ?>
            <div class="related-page-card">
                <h3 class="related-page-card__title"><?php echo esc_html($page['title']); ?></h3>
                <p class="related-page-card__description"><?php echo esc_html($page['excerpt']); ?></p>
                <a class="related-page-card__link" href="<?php echo esc_url($page['url']); ?>">
                    詳しく見る
                    <svg class="related-page-card__link-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- 次に読むべきページ提案 -->
    <?php 
    $next_suggestion = mytheme_next_read_suggestion('project-4');
    if ($next_suggestion): 
        $next_page = get_page_by_path($next_suggestion['slug']);
        if ($next_page):
            $icon_html = $next_suggestion['icon'];
            $icon_html = str_replace('<svg', '<svg class="next-read-btn__icon"', $icon_html);
    ?>
    <section class="next-read-section">
        <h2 class="next-read-title"><?php echo esc_html($next_suggestion['title']); ?></h2>
        <p class="next-read-description"><?php echo esc_html($next_suggestion['description']); ?></p>
        <a href="<?php echo esc_url(get_permalink($next_page->ID)); ?>" class="next-read-btn">
            <?php echo $icon_html; ?>
            今すぐ見る
        </a>
    </section>
    <?php 
        endif;
    endif; 
    ?>
<?php endwhile; ?>

<?php get_footer(); ?>