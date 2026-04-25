<?php
/**
 * Template Name: プロジェクト詳細 - プロジェクト1
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
            <h1 class="page-title">ロト６予測ツール</h1>
        </header>

        <!-- プロジェクト画像 -->
        <div class="project-hero">
            <?php echo mytheme_picture_tag('assets/images/loto6_3.png', 'ロト６予測ツール - メイン画面', 'project-hero__image', 'eager'); ?>
        </div>

        <!-- 画像ギャラリー -->
        <div class="project-gallery">
            <div class="gallery-item">
                <?php echo mytheme_picture_tag('assets/images/loto6_1.png', 'ロト６予測ツール - 予測開始画面', 'gallery-item__image', 'lazy'); ?>
                <p class="gallery-caption">予測開始画面</p>
            </div>
            <div class="gallery-item">
                <?php echo mytheme_picture_tag('assets/images/loto6_2.png', 'ロト６予測ツール - データ分析中', 'gallery-item__image', 'lazy'); ?>
                <p class="gallery-caption">データ分析中</p>
            </div>
        </div>

        <div class="project-content">
            <!-- プロジェクト概要 -->
            <section class="project-section">
                <h2 class="project-section__title">プロジェクト概要</h2>
                <p class="project-section__text">過去のロト6抽選データを分析し、機械学習アルゴリズムを用いて次回の当選番号を予測するWebアプリケーションです。<strong>2つの異なる予測モデル</strong>を実装し、結果を比較表示することで、多角的な予測を提供します。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">機械学習を活用した実践的なデータ分析スキルの習得</li>
                    <li class="feature-list__item">複数の予測モデルの実装と比較検証</li>
                    <li class="feature-list__item">モダンなWebアプリケーション開発</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Python 3.x</span>
                    <span class="tech-tag">HTML5</span>
                    <span class="tech-tag">CSS3</span>
                    <span class="tech-tag">JavaScript</span>
                </div>

                <h3 class="tech-category">バックエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Flask 3.0.3</span>
                    <span class="tech-tag">scikit-learn 1.7.1</span>
                    <span class="tech-tag">pandas 2.3.1</span>
                    <span class="tech-tag">NumPy 2.3.2</span>
                    <span class="tech-tag">Selenium 4.34.2</span>
                    <span class="tech-tag">webdriver-manager 4.0.2</span>
                </div>
                <p class="project-section__text" style="margin-top: 12px; color: var(--text-secondary); font-size: 0.9rem;"><strong>Selenium</strong>: WebブラウザでのXPath要素取得によるデータ自動収集<br>
                <strong>webdriver-manager</strong>: ChromeDriverの自動管理</p>

                <h3 class="tech-category">フロントエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Vanilla JavaScript</span>
                    <span class="tech-tag">CSS Grid/Flexbox</span>
                    <span class="tech-tag">CSS Animations</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>
                
                <h3 class="feature-heading">1. 2つの予測モデルによる比較分析</h3>
                <div class="model-comparison">
                    <div class="model-box">
                        <h4 class="model-box__title">モデルA: 確率モデル（ロジスティック回帰）</h4>
                        <ul class="feature-list">
                            <li class="feature-list__item">過去の出現パターンを統計的に分析</li>
                            <li class="feature-list__item">特徴量: 直近出現回数、累計出現数、経過回数など10種類</li>
                            <li class="feature-list__item">クラス不均衡対策として class_weight="balanced" を適用</li>
                        </ul>
                    </div>
                    <div class="model-box">
                        <h4 class="model-box__title">モデルB: RandomForestモデル</h4>
                        <ul class="feature-list">
                            <li class="feature-list__item">アンサンブル学習による高精度予測</li>
                            <li class="feature-list__item">複雑なパターン・非線形関係の学習</li>
                            <li class="feature-list__item">特徴量重要度の可視化が可能</li>
                        </ul>
                    </div>
                </div>

                <h3 class="feature-heading">2. 自動データ収集機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">SeleniumによるWebブラウザ自動操作</li>
                    <li class="feature-list__item">XPathを使った要素取得による過去の抽選結果の自動収集</li>
                    <li class="feature-list__item">みずほ銀行公式サイトから複数URLを巡回してデータ取得</li>
                    <li class="feature-list__item">取得データのCSV形式での保存</li>
                </ul>

                <h3 class="feature-heading">3. モダンなUI/UX</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">グラデーション背景による視覚的に魅力的なデザイン</li>
                    <li class="feature-list__item">ボールのバウンスアニメーション効果</li>
                    <li class="feature-list__item">予測計算中のローディング表示</li>
                    <li class="feature-list__item">レスポンシブデザイン（PC・タブレット・スマートフォン対応）</li>
                </ul>

                <h3 class="feature-heading">4. 予測結果の視覚化</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">本数字6個とボーナス数字を直感的に表示</li>
                    <li class="feature-list__item">2つのモデルの予測結果を並列比較</li>
                    <li class="feature-list__item">ボール形式での見やすい表示</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">データフロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">公式サイト</div>
                        <div class="flow-arrow">↓ Selenium XPath取得</div>
                        <div class="flow-item">collect_loto6.py（データ収集）</div>
                        <div class="flow-arrow">↓ CSV出力</div>
                        <div class="flow-item">loto6_results.csv</div>
                        <div class="flow-arrow">↓ データ読込</div>
                        <div class="flow-item">予測モデルA・B（学習・推論）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">Flask（結果表示）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">index.html（ブラウザ表示）</div>
                    </div>
                </div>
            </section>

            <!-- 工夫した点 -->
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>
                
                <h3 class="feature-heading">1. 機械学習モデルの工夫</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>クラス不均衡対策</strong>: 出現しない数字が圧倒的に多いため、class_weightで調整</li>
                    <li class="feature-list__item"><strong>特徴量エンジニアリング</strong>: 10種類の独自特徴量を設計
                        <ul class="nested-list">
                            <li class="nested-list__item">直近5回/10回の出現回数</li>
                            <li class="nested-list__item">累計出現回数</li>
                            <li class="nested-list__item">最終出現からの経過回数</li>
                            <li class="nested-list__item">ボーナス数字としての出現傾向</li>
                            <li class="nested-list__item">時間トレンド</li>
                        </ul>
                    </li>
                </ul>

                <h3 class="feature-heading">2. フォールバック機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">scikit-learnが利用できない環境でもヒューリスティック手法で動作</li>
                    <li class="feature-list__item">データ不足時の自動切り替え</li>
                </ul>

                <h3 class="feature-heading">3. UX/UIデザイン</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>非同期処理</strong>: 予測計算中もUIが固まらない設計</li>
                    <li class="feature-list__item"><strong>視覚フィードバック</strong>: ローディングアニメーションで待機時間を退屈させない</li>
                    <li class="feature-list__item"><strong>色分け</strong>: 本数字（金色）とボーナス数字（青色）を明確に区別</li>
                </ul>

                <h3 class="feature-heading">4. 保守性・拡張性</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">型ヒント（Type Hints）による可読性向上</li>
                    <li class="feature-list__item">関数の単一責任原則（SRP）に基づいた設計</li>
                    <li class="feature-list__item">CSV形式の柔軟な対応（複数ヘッダー形式に対応）</li>
                </ul>
            </section>

            <!-- 特徴量設計の詳細 -->
            <section class="project-section">
                <h2 class="project-section__title">特徴量設計の詳細</h2>
                <p class="project-section__text">各数字（1～43）について以下の特徴量を抽出：</p>
                <div class="feature-table-wrapper">
                    <table class="feature-table">
                        <thead class="feature-table__head">
                            <tr>
                                <th class="feature-table__header-cell">特徴量</th>
                                <th class="feature-table__header-cell">説明</th>
                                <th class="feature-table__header-cell">目的</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent5_cnt</code></td>
                                <td class="feature-table__cell">直近5回での出現回数</td>
                                <td class="feature-table__cell">短期トレンド</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent10_cnt</code></td>
                                <td class="feature-table__cell">直近10回での出現回数</td>
                                <td class="feature-table__cell">中期トレンド</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">cumulative_cnt</code></td>
                                <td class="feature-table__cell">累計出現回数</td>
                                <td class="feature-table__cell">長期的な出現頻度</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">last_draw_flag</code></td>
                                <td class="feature-table__cell">前回出現したか</td>
                                <td class="feature-table__cell">連続出現傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent5_bonus_cnt</code></td>
                                <td class="feature-table__cell">直近5回でボーナス出現</td>
                                <td class="feature-table__cell">ボーナス短期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent10_bonus_cnt</code></td>
                                <td class="feature-table__cell">直近10回でボーナス出現</td>
                                <td class="feature-table__cell">ボーナス中期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">cumulative_bonus_cnt</code></td>
                                <td class="feature-table__cell">ボーナス累計出現</td>
                                <td class="feature-table__cell">ボーナス長期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">gap_main</code></td>
                                <td class="feature-table__cell">最終出現からの経過回数</td>
                                <td class="feature-table__cell">Recency効果</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">gap_bonus</code></td>
                                <td class="feature-table__cell">ボーナス最終出現からの経過</td>
                                <td class="feature-table__cell">ボーナスRecency</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">time_trend</code></td>
                                <td class="feature-table__cell">時間的トレンド（正規化）</td>
                                <td class="feature-table__cell">経年変化</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>
                
                <h3 class="feature-heading">1. 複数モデルの並列実行</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 2つのモデルを同時に実行し結果を比較
prob_main, prob_bonus = predict_probabilities(draws_main, draws_bonus)
a_main_numbers, a_bonus_number = pick_numbers(prob_main, prob_bonus)

b_main_numbers, b_bonus_number = run_been_model("loto6_results.csv", time_to_predict=next_time)</code></pre>
                </div>

                <h3 class="feature-heading">2. 柔軟なCSV読み込み</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 複数の異なるヘッダー形式に対応
# 例: "数字1", "num_1", "当選番号1" など</code></pre>
                </div>

                <h3 class="feature-heading">3. エラーハンドリング</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">try:
    # メインロジック
except Exception as e:
    # フォールバック処理
    context["error"] = f"エラー: {e}"</code></pre>
                </div>
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
                    <p class="disclaimer-box__text"><strong>本プロジェクトは教育・学習目的で開発しました。開発および使用にあたり、以下の点に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>データ収集における配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">公開データのみを使用し、みずほ銀行公式サイトの利用規約を遵守</li>
                        <li class="feature-list__item">適切な待機時間（sleep）を設定し、サーバーへの負荷を最小限に抑制</li>
                        <li class="feature-list__item">過度なアクセスを避け、必要最小限のデータ取得に留める</li>
                        <li class="feature-list__item">取得したデータは個人的な学習目的にのみ使用</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>予測システムの位置づけ</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">機械学習技術の学習・検証を目的とした実験的プロジェクト</li>
                        <li class="feature-list__item">予測結果は統計的な分析に基づくものであり、確実性を保証するものではない</li>
                        <li class="feature-list__item">本システムを商用利用や実際の購入判断には使用していない</li>
                        <li class="feature-list__item">ギャンブル依存症への配慮から、あくまで技術研究の範囲内で運用</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>倫理的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">本ツールはポートフォリオとしての技術紹介を目的としている</li>
                        <li class="feature-list__item">オープンソースとして公開せず、悪用防止に配慮</li>
                        <li class="feature-list__item">教育目的の範囲を超えた利用を推奨しない立場を明示</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <h2 class="project-section__title">デモ動画</h2>
                <p class="project-section__text">実際の動作をご覧いただけます。予測モデルの動作や画面の使い方をわかりやすく紹介しています。</p>
                <div class="video-container">
                    <iframe 
                        class="video-container__iframe"
                        src="https://www.youtube.com/embed/7Cmkga044EA" 
                        title="ロト6予測ツール デモ動画"
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
                    <li class="feature-list__item"><strong>データ提供</strong>: みずほ銀行ロト6公式サイト</li>
                    <li class="feature-list__item"><strong>機械学習ライブラリ</strong>: scikit-learn開発チーム</li>
                    <li class="feature-list__item"><strong>Webフレームワーク</strong>: Flask開発チーム</li>
                    <li class="feature-list__item"><strong>ブラウザ自動操作</strong>: Seleniumプロジェクト</li>
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
        "name": "ロト６予測ツール",
        "applicationCategory": "DeveloperApplication",
        "operatingSystem": "Windows, macOS, Linux",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "JPY"
        },
        "description": "複数の機械学習モデル（ロジスティック回帰・RandomForest）を活用したロト6の次回当選番号予測システム。2つのモデルの結果を比較表示。",
        "image": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/loto6_3.png' ); ?>",
        "screenshot": [
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/loto6_1.png' ); ?>",
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/loto6_2.png' ); ?>",
            "<?php echo esc_url( get_template_directory_uri() . '/assets/images/loto6_3.png' ); ?>"
        ],
        "softwareVersion": "1.0",
        "programmingLanguage": ["Python", "JavaScript", "HTML", "CSS"],
        "keywords": "ロト6, 機械学習, 予測ツール, Python, Flask, scikit-learn, データ分析",
        "video": {
            "@type": "VideoObject",
            "name": "ロト6予測ツール デモ動画",
            "description": "実際の動作をご覧いただけます。予測モデルの動作や画面の使い方をわかりやすく紹介しています。",
            "thumbnailUrl": "https://i.ytimg.com/vi/7Cmkga044EA/maxresdefault.jpg",
            "uploadDate": "2025-10-16T00:00:00+09:00",
            "contentUrl": "https://www.youtube.com/watch?v=7Cmkga044EA",
            "embedUrl": "https://www.youtube.com/embed/7Cmkga044EA"
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
    $next_suggestion = mytheme_next_read_suggestion('project-1');
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
