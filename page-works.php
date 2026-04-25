<?php
/**
 * Template Name: 開発作品紹介ページ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

    // プロジェクトページのURLを取得（階層構造対応）
    $project_1 = get_page_by_path('works/loto6');
    $project_1_url = $project_1 ? get_permalink($project_1->ID) : home_url('/works/loto6/');
    
    $project_2 = get_page_by_path('works/auto-typing');
    $project_2_url = $project_2 ? get_permalink($project_2->ID) : home_url('/works/auto-typing/');
    
    $quest4 = get_page_by_path('works/quest4');
    $quest4_url = $quest4 ? get_permalink($quest4->ID) : home_url('/works/quest4/');
    
    $project_4 = get_page_by_path('works/beengineer-camp');
    $project_4_url = $project_4 ? get_permalink($project_4->ID) : home_url('/works/beengineer-camp/');
?>

<?php while ( have_posts() ) : the_post(); ?>
    <article class="page-content works-page">
        <?php mytheme_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="page-body">
            <?php the_content(); ?>
        </div>

        <div class="works-grid">
            <!-- 作品1 -->
            <div class="work-item">
                <div class="work-thumbnail">
                    <a class="work-thumbnail__link" href="<?php echo esc_url( $project_1_url ); ?>">
                        <?php echo mytheme_picture_tag('assets/images/loto6_3.png', 'ロト６予測ツール - 機械学習を活用した数字予測システム', 'work-thumbnail__image', 'eager'); ?>
                    </a>
                </div>
                <div class="work-info">
                    <h2 class="work-title">ロト６予測ツール</h2>
                    <p class="work-description">複数の機械学習モデル（ロジスティック回帰・RandomForest）を活用したロト6の次回当選番号予測システム。2つのモデルの結果を比較表示。</p>
                    <div class="work-tech">
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">Flask</span>
                        <span class="tech-tag">scikit-learn</span>
                        <span class="tech-tag">Selenium</span>
                    </div>
                    <div class="work-links">
                        <a href="<?php echo esc_url( $project_1_url ); ?>" class="work-link">詳細を見る</a>
                        <a href="<?php echo esc_url( $project_1_url . '#demo-video' ); ?>" class="work-link work-link-demo">
                            <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                            デモを見る
                        </a>
                    </div>
                </div>
            </div>

            <!-- 作品2 -->
            <div class="work-item">
                <div class="work-thumbnail">
                    <a class="work-thumbnail__link" href="<?php echo esc_url( $project_2_url ); ?>">
                        <?php echo mytheme_picture_tag('assets/images/auto_typing1.png', 'e-typing自動タイピング - Selenium WebDriverによるブラウザ自動化', 'work-thumbnail__image', 'lazy'); ?>
                    </a>
                </div>
                <div class="work-info">
                    <h2 class="work-title">e-typing自動タイピング</h2>
                    <p class="work-description">Selenium WebDriverを活用したe-typing練習サイトの自動入力システム。XPathによる動的要素取得とiframe操作を実装。</p>
                    <div class="work-tech">
                        <span class="tech-tag">Python</span>
                        <span class="tech-tag">Selenium</span>
                        <span class="tech-tag">webdriver-manager</span>
                        <span class="tech-tag">XPath</span>
                    </div>
                    <div class="work-links">
                        <a href="<?php echo esc_url( $project_2_url ); ?>" class="work-link">詳細を見る</a>
                        <a href="<?php echo esc_url( $project_2_url . '#demo-video' ); ?>" class="work-link work-link-demo">
                            <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                            デモを見る
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quest4 -->
            <div class="work-item">
                <div class="work-thumbnail">
                    <a class="work-thumbnail__link" href="<?php echo esc_url( $quest4_url ); ?>">
                        <?php echo mytheme_picture_tag('assets/images/quest4_1.png', 'Quest4 - LINE学習クイズBot', 'work-thumbnail__image', 'lazy'); ?>
                    </a>
                </div>
                <div class="work-info">
                    <h2 class="work-title">Quest4 - LINE学習クイズBot</h2>
                    <p class="work-description">Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システム。4科目24カテゴリから選択でき、リアルタイムで正誤判定と解説を提供します。</p>
                    <div class="work-tech">
                        <span class="tech-tag">JavaScript</span>
                        <span class="tech-tag">Google Apps Script</span>
                        <span class="tech-tag">LINE Messaging API</span>
                    </div>
                    <div class="work-links">
                        <a href="<?php echo esc_url( $quest4_url ); ?>" class="work-link">詳細を見る</a>
                        <a href="<?php echo esc_url( $quest4_url . '#demo-video' ); ?>" class="work-link work-link-demo">
                            <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                            デモを見る
                        </a>
                    </div>
                </div>
            </div>

            <!-- BeEngineer合宿案内サイト -->
            <div class="work-item">
                <div class="work-thumbnail">
                    <a class="work-thumbnail__link" href="<?php echo esc_url( $project_4_url ); ?>">
                        <?php echo mytheme_picture_tag('assets/images/beengineer_camp_1.png', 'BeEngineer Programming Camp - 合宿案内サイト', 'work-thumbnail__image', 'lazy'); ?>
                    </a>
                </div>
                <div class="work-info">
                    <h2 class="work-title">BeEngineer合宿案内サイト</h2>
                    <p class="work-description">BeEngineerプログラミング合宿の案内用Webサイト。HTML5、CSS3、Vanilla JavaScriptを使用した静的サイトで、レスポンシブデザインに完全対応。</p>
                    <div class="work-tech">
                        <span class="tech-tag">HTML5</span>
                        <span class="tech-tag">CSS3</span>
                        <span class="tech-tag">JavaScript</span>
                        <span class="tech-tag">localStorage</span>
                    </div>
                    <div class="work-links">
                        <a href="<?php echo esc_url( $project_4_url ); ?>" class="work-link">詳細を見る</a>
                        <a href="<?php echo esc_url( $project_4_url . '#demo-video' ); ?>" class="work-link work-link-demo">
                            <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                            デモを見る
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="back-link">
            <a class="back-link__anchor" href="<?php echo esc_url( home_url( '/' ) ); ?>">← トップページに戻る</a>
        </div>
        
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
        $next_suggestion = mytheme_next_read_suggestion('works');
        if ($next_suggestion): 
            $next_page = get_page_by_path($next_suggestion['slug']);
            if ($next_page):
        ?>
        <section class="next-read-section">
            <h2 class="next-read-title"><?php echo esc_html($next_suggestion['title']); ?></h2>
            <p class="next-read-description"><?php echo esc_html($next_suggestion['description']); ?></p>
            <a href="<?php echo esc_url(get_permalink($next_page->ID)); ?>" class="next-read-btn">
                <?php 
                // SVGにBEMクラスを追加
                $icon_html = $next_suggestion['icon'];
                $icon_html = str_replace('<svg', '<svg class="next-read-btn__icon"', $icon_html);
                echo $icon_html;
                ?>
                今すぐ見る
            </a>
        </section>
        <?php 
            endif;
        endif; 
        ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>

