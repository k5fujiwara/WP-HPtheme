<?php
/**
 * Template Name: 開発作品紹介ページ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
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

        <?php
        $works_query = function_exists('mytheme_get_work_archive_query') ? mytheme_get_work_archive_query() : null;
        ?>
        <?php if ( $works_query instanceof WP_Query && $works_query->have_posts() ) : ?>
            <div class="works-grid">
                <?php while ( $works_query->have_posts() ) : $works_query->the_post(); ?>
                    <?php mytheme_render_work_card(get_the_ID()); ?>
                <?php endwhile; ?>
            </div>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p>まだ開発作品がありません。管理画面の「開発作品」から投稿を追加してください。</p>
        <?php
        if ( $works_query instanceof WP_Query ) {
            wp_reset_postdata();
        }
        ?>
        <?php endif; ?>

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

