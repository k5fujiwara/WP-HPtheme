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
$selected_cat = '';
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
    'posts_per_page' => 10,
    'no_found_rows'  => false,
];
if ( $selected_cat !== '' ) {
    $query_args['category_name'] = $selected_cat;
}

$q = new WP_Query([
    ...$query_args,
]);
?>

<article <?php post_class(['page-content', 'learning-column-page']); ?>>
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>

    <header class="page-header">
        <h1 class="page-title">学習コラム</h1>
        <p class="post-subtitle">教育・プログラミング・自己啓発の学びを、サイト内に蓄積していきます。</p>
    </header>

    <div class="page-body">
        <?php if ( function_exists('mytheme_render_learning_column_toolbox') ) : ?>
            <?php mytheme_render_learning_column_toolbox('archive'); ?>
        <?php endif; ?>

        <nav class="learning-column-filters" aria-label="カテゴリで絞り込み">
            <?php
            $base_url = get_permalink();
            $all_url  = remove_query_arg(['cat', 'cats', 'paged'], $base_url);
            ?>
            <a class="learning-column-filters__item is-all <?php echo $selected_cat === '' ? 'is-active' : ''; ?>" href="<?php echo esc_url($all_url); ?>">
                <span class="lc-filter-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16"></path><path d="M6 12h12"></path><path d="M8 18h8"></path></svg>
                </span>
                <span class="lc-filter-text">すべて</span>
            </a>
            <?php foreach ( $allowed_cats as $slug => $label ) : ?>
                <?php
                // 存在するカテゴリだけ出す（もし消されていた場合の保険）
                $term = get_term_by('slug', $slug, 'category');
                if ( ! $term || is_wp_error($term) ) continue;
                $is_active = $selected_cat === $slug;
                $url = add_query_arg('cat', $slug, remove_query_arg(['cats', 'paged'], $base_url));
                $m = isset($cat_meta[$slug]) ? $cat_meta[$slug] : null;
                ?>
                <a class="learning-column-filters__item <?php echo $m ? esc_attr($m['class']) : ''; ?> <?php echo $is_active ? 'is-active' : ''; ?>" href="<?php echo esc_url($url); ?>" data-cat="<?php echo esc_attr($slug); ?>">
                    <?php if ( $m && ! empty($m['icon']) ) : ?>
                        <span class="lc-filter-icon" aria-hidden="true"><?php echo $m['icon']; ?></span>
                    <?php endif; ?>
                    <span class="lc-filter-text"><?php echo esc_html($label); ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="learning-column-results" data-learning-column-results>
            <?php if ( $q->have_posts() ) : ?>
                <?php while ( $q->have_posts() ) : $q->the_post(); ?>
                    <?php mytheme_render_learning_column_card($cat_meta); ?>
                <?php endwhile; ?>

                <div class="pagination">
                    <?php
                    echo paginate_links([
                        'total'   => (int) $q->max_num_pages,
                        'current' => $paged,
                        'base'    => trailingslashit($base_url) . '%_%',
                        'format'  => user_trailingslashit('page/%#%/'),
                        'add_args'=> $selected_cat !== '' ? ['cat' => $selected_cat] : [],
                    ]);
                    ?>
                </div>
            <?php else : ?>
                <p>まだ投稿がありません。最初の学習コラムを投稿してみましょう。</p>
            <?php endif; ?>
        </div>
    </div>
</article>

<?php
wp_reset_postdata();
get_footer();
?>

