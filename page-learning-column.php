<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$paged = max( 1, (int) get_query_var( 'paged' ) );

$allowed_cats = [
    'education'        => '教育',
    'programming'      => 'プログラミング',
    'self-development' => '自己啓発',
];

$cat_meta = function_exists('mytheme_get_column_category_meta') ? mytheme_get_column_category_meta() : [];
$theme_meta = function_exists('mytheme_get_learning_column_themes') ? mytheme_get_learning_column_themes() : [];
$selected_cat = '';
$selected_theme = '';
if ( isset($_GET['theme']) && function_exists('mytheme_normalize_learning_column_theme') ) {
    $selected_theme = mytheme_normalize_learning_column_theme((string) $_GET['theme']);
    if ( $selected_theme === 'review-required' ) {
        $selected_theme = '';
    }
}
if ( isset($_GET['cats']) ) {
    // 互換: cats=education,programming のような複数指定が来ても「先頭1つだけ」採用
    $raw = (string) $_GET['cats'];
    $parts = array_map('trim', explode(',', $raw));
    foreach ( $parts as $p ) {
        $s = sanitize_key((string) $p);
        if ( $s !== '' && isset($allowed_cats[$s]) ) {
            $selected_cat = $s;
            break;
        }
    }
} elseif ( isset($_GET['cat']) ) {
    $candidate = sanitize_key((string) $_GET['cat']);
    if ( isset($allowed_cats[$candidate]) ) {
        $selected_cat = $candidate;
    }
}

$query_args = [
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'paged'          => $paged,
    'posts_per_page' => 12,
    'no_found_rows'  => false,
];
if ( $selected_cat !== '' ) {
    $query_args['category_name'] = $selected_cat;
} elseif ( $selected_theme !== '' && function_exists('mytheme_get_learning_column_theme_post_ids') ) {
    $theme_post_ids = mytheme_get_learning_column_theme_post_ids($selected_theme);
    $query_args['post__in'] = ! empty($theme_post_ids) ? $theme_post_ids : [0];
    $query_args['orderby'] = 'post__in';
}

$q = new WP_Query([
    ...$query_args,
]);
$legacy_cat_theme_map = function_exists('mytheme_get_learning_column_legacy_category_theme_map')
    ? mytheme_get_learning_column_legacy_category_theme_map()
    : [];
$active_theme = $selected_theme !== ''
    ? $selected_theme
    : (isset($legacy_cat_theme_map[$selected_cat]) ? $legacy_cat_theme_map[$selected_cat] : '');
?>

<article <?php post_class(['page-content', 'learning-column-page']); ?>>
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>

    <header class="page-header">
        <h1 class="page-title">学習コラム</h1>
        <p class="post-subtitle">教育、AI・プログラミング、情報Ⅰ・データ分析、資格、学習法など、学びを実践につなげるための情報を整理しています。</p>
    </header>

    <div class="page-body">
        <div class="lc-search">
            <?php get_search_form(); ?>
            <a class="lc-search__dictionary" href="<?php echo esc_url(function_exists('mytheme_get_dictionary_archive_url') ? mytheme_get_dictionary_archive_url() : home_url('/dictionary/')); ?>">用語辞書から探す</a>
        </div>

        <nav class="learning-column-filters" aria-label="テーマで絞り込み">
            <?php
            $base_url = get_permalink();
            $all_url  = remove_query_arg(['cat', 'cats', 'theme', 'paged'], $base_url);
            $total_posts = (int) wp_count_posts('post')->publish;
            ?>
            <a class="learning-column-filters__item is-all <?php echo ($selected_cat === '' && $selected_theme === '') ? 'is-active' : ''; ?>" href="<?php echo esc_url($all_url); ?>">
                <span class="lc-filter-text">すべて</span>
                <span class="lc-filter-count"><?php echo esc_html((string) $total_posts); ?></span>
            </a>
            <?php foreach ( $theme_meta as $slug => $m ) : ?>
                <?php
                if ( $slug === 'review-required' ) continue;
                $theme_count = function_exists('mytheme_get_learning_column_theme_post_ids')
                    ? count(mytheme_get_learning_column_theme_post_ids($slug))
                    : 0;
                if ( $theme_count === 0 ) continue;
                $is_active = $active_theme === $slug;
                $url = add_query_arg('theme', $slug, remove_query_arg(['cat', 'cats', 'paged'], $base_url));
                ?>
                <a class="learning-column-filters__item <?php echo ! empty($m['class']) ? esc_attr($m['class']) : ''; ?> <?php echo $is_active ? 'is-active' : ''; ?>" href="<?php echo esc_url($url); ?>" rel="nofollow" data-cat="<?php echo esc_attr($slug); ?>">
                    <span class="lc-filter-text"><?php echo esc_html((string) $m['label']); ?></span>
                    <span class="lc-filter-count"><?php echo esc_html((string) $theme_count); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="learning-column-results" data-learning-column-results>
            <?php if ( $active_theme !== '' && ! empty($theme_meta[$active_theme]['description']) ) : ?>
                <p class="lc-theme-description"><?php echo esc_html((string) $theme_meta[$active_theme]['description']); ?></p>
            <?php endif; ?>

            <?php
            // 1ページ目・絞り込みなしのときだけ「よく読まれている記事」を表示
            if ( $paged === 1 && $active_theme === '' && $selected_cat === '' && function_exists('mytheme_get_cached_id_query') ) :
                $popular = mytheme_get_cached_id_query('mytheme_lc_popular_posts', [
                    'post_type'              => 'post',
                    'posts_per_page'         => 3,
                    'meta_key'               => '_mytheme_post_views',
                    'orderby'                => 'meta_value_num',
                    'order'                  => 'DESC',
                    'update_post_meta_cache' => true,
                    'update_post_term_cache' => true,
                ], HOUR_IN_SECONDS);
                if ( $popular->have_posts() ) :
                    $rank = 0;
            ?>
                <section class="lc-popular" aria-labelledby="lc-popular-title">
                    <h2 id="lc-popular-title" class="lc-section-title">よく読まれている記事</h2>
                    <ol class="lc-popular__list">
                        <?php foreach ( $popular->posts as $popular_post ) : $rank++; $pid = (int) (is_object($popular_post) ? $popular_post->ID : $popular_post); ?>
                            <li class="lc-popular__item">
                                <a class="lc-popular__link" href="<?php echo esc_url(get_permalink($pid)); ?>">
                                    <span class="lc-popular__rank" aria-hidden="true"><?php echo esc_html((string) $rank); ?></span>
                                    <span class="lc-popular__title"><?php echo esc_html(get_the_title($pid)); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </section>
                <h2 class="lc-section-title">新着順</h2>
            <?php
                endif;
            endif;
            ?>

            <?php if ( $q->have_posts() ) : ?>
                <div class="post-tile-grid">
                    <?php while ( $q->have_posts() ) : $q->the_post(); ?>
                        <?php mytheme_render_learning_column_card($cat_meta); ?>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    echo paginate_links([
                        'total'   => (int) $q->max_num_pages,
                        'current' => $paged,
                        'base'    => trailingslashit($base_url) . '%_%',
                        'format'  => user_trailingslashit('page/%#%/'),
                        'add_args'=> $selected_cat !== '' ? ['cat' => $selected_cat] : ($selected_theme !== '' ? ['theme' => $selected_theme] : []),
                    ]);
                    ?>
                </div>
            <?php else : ?>
                <p>このテーマの記事はまだありません。</p>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php
wp_reset_postdata();
get_footer();
?>

