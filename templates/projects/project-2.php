<?php
/**
 * Template Name: プロジェクト詳細 - プロジェクト2
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
            <h1 class="page-title">e-typing自動タイピング</h1>
        </header>

        <!-- プロジェクト画像 -->
        <div class="project-hero">
            <?php echo mytheme_picture_tag('assets/images/auto_typing1.png', 'e-typing自動タイピング', 'project-hero__image', 'eager'); ?>
        </div>

        <div class="project-content">
            <!-- プロジェクト概要 -->
            <section class="project-section">
                <h2 class="project-section__title">プロジェクト概要</h2>
                <p class="project-section__text">日本最大級のタイピング練習サイト「e-typing」に対応した自動入力プログラムです。<strong>Selenium WebDriver</strong>によるブラウザ自動操作技術を活用し、XPathによる動的要素取得と文字列自動入力を実装しました。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">Web自動化技術（Selenium）の実践的スキル習得</li>
                    <li class="feature-list__item">XPathを用いた動的要素取得の理解</li>
                    <li class="feature-list__item">iframe操作を含む複雑なDOM構造への対応</li>
                    <li class="feature-list__item">ブラウザ操作の自動化プログラミング体験</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Python 3.x</span>
                </div>

                <h3 class="tech-category">ブラウザ自動化</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Selenium 4.34.2</span>
                    <span class="tech-tag">webdriver-manager 4.0.2</span>
                    <span class="tech-tag">requests 2.32.4</span>
                    <span class="tech-tag">python-dotenv 1.1.1</span>
                </div>
                <p class="project-section__text" style="margin-top: 12px; color: var(--text-secondary); font-size: 0.9rem;"><strong>Selenium</strong>: Webブラウザの自動操作・要素取得<br>
                <strong>webdriver-manager</strong>: ChromeDriverの自動インストール・管理</p>

                <h3 class="tech-category">その他依存ライブラリ</h3>
                <div class="tech-stack">
                    <span class="tech-tag">trio / trio-websocket</span>
                    <span class="tech-tag">urllib3</span>
                    <span class="tech-tag">certifi</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>
                
                <h3 class="feature-heading">1. e-typing自動タイピング機能</h3>
                <p class="project-section__text"><strong>対象サイト</strong>: <a href="https://www.e-typing.ne.jp/" target="_blank" rel="noopener noreferrer" style="color: var(--primary-blue);">e-typing（イータイピング）</a> - 日本最大級のタイピング練習サイト</p>
                
                <p class="project-section__text"><strong>実装機能</strong>:</p>
                <ul class="feature-list">
                    <li class="feature-list__item">ローマ字タイピングチェックの自動実行</li>
                    <li class="feature-list__item">XPathによる動的テキスト要素の取得</li>
                    <li class="feature-list__item">15問の自動入力処理</li>
                    <li class="feature-list__item">スコア・レベルの自動取得とコンソール表示</li>
                    <li class="feature-list__item">無限ループモード対応（コメントアウト解除で有効化）</li>
                    <li class="feature-list__item">iframe内要素への正確なアクセス</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">動作フロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">e-typingサイトアクセス</div>
                        <div class="flow-arrow">↓ 1秒待機</div>
                        <div class="flow-item">ローマ字チェックリンククリック</div>
                        <div class="flow-arrow">↓ 1秒待機</div>
                        <div class="flow-item">腕試しレベルチェックボタンクリック</div>
                        <div class="flow-arrow">↓ 2秒待機・iframe切り替え</div>
                        <div class="flow-item">タイピング開始ボタンクリック</div>
                        <div class="flow-arrow">↓ 2秒待機・body要素取得</div>
                        <div class="flow-item">スペースキー送信でタイピング準備</div>
                        <div class="flow-arrow">↓ 3秒待機</div>
                        <div class="flow-item">15問の文字列を1文字ずつ自動入力</div>
                        <div class="flow-arrow">↓ 各問題後1秒待機</div>
                        <div class="flow-item">結果画面からスコア・レベル取得</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">コンソールに結果表示</div>
                    </div>
                </div>
            </section>

            <!-- 工夫した点 -->
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>
                
                <h3 class="feature-heading">1. XPathによる柔軟な要素取得</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 次にタイプする文字列を動的に取得
text = driver.find_element("xpath", 
    "//div[@id='sentenceText']/div/span/following-sibling::span").text</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">following-sibling軸を使用した兄弟要素の取得</li>
                    <li class="feature-list__item">動的に変化するテキストへの対応</li>
                    <li class="feature-list__item">タイピング済み文字ではなく「未タイプ文字」のみを正確に取得</li>
                </ul>

                <h3 class="feature-heading">2. iframeへの切り替え処理</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># タイピング画面はiframe内にあるため切り替えが必要
driver.switch_to.frame("typing_content")</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">e-typingのタイピング画面はtyping_contentというiframe内に実装</li>
                    <li class="feature-list__item">正確な要素操作のためのコンテキスト切り替えが必須</li>
                    <li class="feature-list__item">iframe切り替えなしでは要素が見つからない</li>
                </ul>

                <h3 class="feature-heading">3. ChromeDriverの自動管理</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">from webdriver_manager.chrome import ChromeDriverManager

service = Service(ChromeDriverManager().install())
driver = webdriver.Chrome(service=service, options=options)</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">webdriver-managerにより環境に応じたChromeDriverを自動ダウンロード</li>
                    <li class="feature-list__item">手動でのドライバー管理が不要</li>
                    <li class="feature-list__item">Chromeバージョンアップ時も自動対応</li>
                </ul>

                <h3 class="feature-heading">4. 適切な待機時間の設定</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">各処理の間に適切な待機時間を設定</li>
                    <li class="feature-list__item">ページ読み込みやJavaScript実行の完了を待つ</li>
                    <li class="feature-list__item">エラーを防ぐための安全マージン確保</li>
                </ul>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>
                
                <h3 class="feature-heading">1. 動的要素の監視と文字単位での入力</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># タイピング問題を1文字ずつ自動入力
for _ in range(15):
    text = driver.find_element("xpath", 
        "//div[@id='sentenceText']/div/span/following-sibling::span").text
    for char in text:
        body_element.send_keys(char)
    time.sleep(1)</code></pre>
                </div>

                <h3 class="feature-heading">2. XPath軸を活用した柔軟な要素取得</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">"//div[@id='sentenceText']/div/span/following-sibling::span"</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">sentenceTextという特定IDの要素から出発</li>
                    <li class="feature-list__item">子要素のdiv、さらにその子のspanへ移動</li>
                    <li class="feature-list__item">following-sibling軸で兄弟要素（未タイプ部分）を取得</li>
                    <li class="feature-list__item">複雑なDOM構造を正確にナビゲート</li>
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
                        <p class="info-item__text">企画・設計・実装・テスト</p>
                    </div>
                </div>
            </section>

            <!-- 開発時の注意事項 -->
            <section class="project-section">
                <h2 class="project-section__title">開発時の注意事項</h2>
                <div class="disclaimer-box">
                    <p class="disclaimer-box__text"><strong>本プロジェクトは教育・学習目的で開発しました。開発および検証にあたり、以下の点に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>利用規約の遵守</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">e-typingサイトの利用規約を事前に確認し、個人的な学習範囲内での開発</li>
                        <li class="feature-list__item">自動化技術の学習を目的とし、ランキングや公式記録への影響を避ける</li>
                        <li class="feature-list__item">Webスクレイピング技術の研究として、倫理的配慮を持って実装</li>
                        <li class="feature-list__item">本番環境での継続的な使用は行わず、あくまで技術検証に限定</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>サーバーへの配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">適切な待機時間（time.sleep）を各処理に設定し、過度な負荷を防止</li>
                        <li class="feature-list__item">無限ループモードはコメントアウトし、デフォルトでは実行されない設計</li>
                        <li class="feature-list__item">テスト実行は必要最小限に留め、連続実行を控える運用方針</li>
                        <li class="feature-list__item">ページ読み込み完了を確認してから次の操作を実行する設計</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>技術的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">ブラウザ自動化技術（Selenium）の学習を主目的とした開発</li>
                        <li class="feature-list__item">XPath、iframe操作など、複雑なDOM構造への対応技術の習得</li>
                        <li class="feature-list__item">実用ツールではなく、技術研究・ポートフォリオとしての位置づけ</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>倫理的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">オープンソースとして公開せず、悪用防止に配慮</li>
                        <li class="feature-list__item">自動化技術の学習範囲を超えた使用を推奨しない立場を明示</li>
                        <li class="feature-list__item">e-typingサービスの健全な運営を尊重する姿勢を維持</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <h2 class="project-section__title">デモ動画</h2>
                <p class="project-section__text">実際の動作をご覧いただけます。e-typingサイトでの自動タイピングの様子をわかりやすく紹介しています。</p>
                <div class="video-container">
                    <iframe 
                        class="video-container__iframe"
                        src="https://www.youtube.com/embed/dyzOZBjYJcU" 
                        title="e-typing自動タイピング デモ動画"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>e-typing</strong>: 日本最大級のタイピング練習サイトの提供</li>
                    <li class="feature-list__item"><strong>Seleniumプロジェクト</strong>: 強力なブラウザ自動化フレームワーク</li>
                    <li class="feature-list__item"><strong>webdriver-manager</strong>: ChromeDriver自動管理ツールの開発</li>
                    <li class="feature-list__item"><strong>Pythonコミュニティ</strong>: 豊富なライブラリとドキュメント</li>
                </ul>
            </section>
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
        "name": "e-typing自動タイピング",
        "applicationCategory": "DeveloperApplication",
        "operatingSystem": "Windows, macOS, Linux",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "JPY"
        },
        "description": "Selenium WebDriverを活用したe-typing練習サイトの自動入力システム。XPathによる動的要素取得とiframe操作を実装。",
        "image": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/auto_typing1.png' ); ?>",
        "screenshot": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/auto_typing1.png' ); ?>",
        "softwareVersion": "1.0",
        "programmingLanguage": ["Python"],
        "keywords": "e-typing, 自動タイピング, Selenium, WebDriver, Python, XPath, iframe操作, ブラウザ自動化",
        "video": {
            "@type": "VideoObject",
            "name": "e-typing自動タイピング デモ動画",
            "description": "実際の動作をご覧いただけます。e-typingサイトでの自動タイピングの様子をわかりやすく紹介しています。",
            "thumbnailUrl": "https://i.ytimg.com/vi/dyzOZBjYJcU/maxresdefault.jpg",
            "uploadDate": "2025-10-18T00:00:00+09:00",
            "contentUrl": "https://www.youtube.com/watch?v=dyzOZBjYJcU",
            "embedUrl": "https://www.youtube.com/embed/dyzOZBjYJcU"
        }
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
    $next_suggestion = mytheme_next_read_suggestion('project-2');
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
