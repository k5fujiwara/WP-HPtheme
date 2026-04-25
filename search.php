<?php
/**
 * 検索結果ページテンプレート
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$cat_meta = function_exists('mytheme_get_column_category_meta') ? mytheme_get_column_category_meta() : [];
?>

<article class="page-content learning-column-page search-results-page">
    <header class="page-header">
        <h1 class="page-title">検索結果</h1>
        <p class="post-subtitle">
            「<?php echo esc_html( get_search_query() ); ?>」の検索結果
            <?php global $wp_query; ?>
            <?php if ( ! empty( $wp_query->found_posts ) ) : ?>
                <?php echo '（' . esc_html( (string) $wp_query->found_posts ) . '件）'; ?>
            <?php endif; ?>
        </p>
    </header>

    <div class="page-body">
        <div class="search-results-page__search">
            <?php get_search_form(); ?>
        </div>

        <?php if ( have_posts() ) : ?>
            <div class="learning-column-results">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php mytheme_render_learning_column_card($cat_meta, true); ?>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination([
                    'mid_size'  => 2,
                    'prev_text' => '&laquo; 前へ',
                    'next_text' => '次へ &raquo;',
                ]);
                ?>
            </div>
        <?php else : ?>
            <div class="search-results-page__empty">
                <p class="search-results-page__empty-text">検索結果が見つかりませんでした。別のキーワードで試してみてください。</p>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php get_footer(); ?>

