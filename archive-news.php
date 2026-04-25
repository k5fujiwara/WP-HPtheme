<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<article class="page-content news-archive-page">
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>

    <header class="page-header">
        <h1 class="page-title">お知らせ</h1>
    </header>

    <div class="page-body">
        <?php if ( have_posts() ) : ?>
            <ul class="news-archive-list">
                <?php
                global $wp_query;
                if ( function_exists('mytheme_render_news_list_items') ) {
                    mytheme_render_news_list_items($wp_query, [
                        'item_class'    => 'news-archive-item',
                        'link_class'    => 'news-archive-item__link',
                        'date_class'    => 'news-archive-item__date',
                        'title_class'   => 'news-archive-item__title',
                        'date_format'   => 'Y.m.d',
                        'date_position' => 'left',
                    ]);
                }
                ?>
            </ul>

            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p>お知らせはまだありません。</p>
        <?php endif; ?>
    </div>
</article>

<?php get_footer(); ?>
