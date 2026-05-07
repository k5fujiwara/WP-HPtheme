<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$archive_url = get_post_type_archive_link('youtube_learning');
$selected = [
    'yt_topic'   => isset($_GET['yt_topic']) ? sanitize_text_field(wp_unslash((string) $_GET['yt_topic'])) : '',
    'yt_channel' => isset($_GET['yt_channel']) ? sanitize_text_field(wp_unslash((string) $_GET['yt_channel'])) : '',
];
?>

<article class="page-content youtube-learning-archive-page">
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>

    <header class="page-header youtube-learning-hero">
        <p class="youtube-learning-hero__label">Learning YouTube Selection</p>
        <h1 class="page-title">学習におすすめのYouTube動画</h1>
        <p class="post-subtitle">学びに役立つ動画を、リスペクトを込めて紹介します。</p>
    </header>

    <div class="page-body">
        <section class="youtube-learning-policy" aria-label="掲載方針">
            <h2 class="youtube-learning-policy__title">掲載方針</h2>
            <p>各動画はYouTube公式の埋め込み機能を利用しています。動画の権利は各投稿者・チャンネルに帰属します。</p>
        </section>

        <details class="youtube-learning-search-panel" <?php echo ! empty(array_filter($selected)) ? 'open' : ''; ?>>
            <summary class="youtube-learning-search-panel__summary">ジャンル・YouTuberで絞り込む</summary>
            <form class="youtube-learning-search" action="<?php echo esc_url($archive_url); ?>" method="get" role="search">
                <div class="youtube-learning-search__filters">
                <?php
                $filter_taxonomies = [
                    'yt_topic'   => '学習ジャンル',
                    'yt_channel' => 'YouTuber',
                ];
                foreach ( $filter_taxonomies as $taxonomy => $label ) :
                    $terms = get_terms([
                        'taxonomy'   => $taxonomy,
                        'hide_empty' => false,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ]);
                    if ( ! is_array($terms) || empty($terms) ) continue;
                    if ( $taxonomy === 'yt_topic' && function_exists('mytheme_youtube_learning_sort_terms_by_topic_order') ) {
                        $terms = mytheme_youtube_learning_sort_terms_by_topic_order($terms);
                    }
                    ?>
                    <label>
                        <span><?php echo esc_html($label); ?></span>
                        <select name="<?php echo esc_attr($taxonomy); ?>">
                            <option value="">すべて</option>
                            <?php foreach ( $terms as $term ) : ?>
                                <?php if ( ! isset($term->slug, $term->name) ) continue; ?>
                                <option value="<?php echo esc_attr((string) $term->slug); ?>" <?php selected($selected[$taxonomy], (string) $term->slug); ?>>
                                    <?php echo esc_html((string) $term->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                <?php endforeach; ?>
                </div>
                <div class="youtube-learning-search__actions">
                    <button type="submit"><span>絞り込む</span></button>
                </div>
            </form>
        </details>

        <?php if ( have_posts() ) : ?>
            <div class="youtube-learning-grid">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php if ( function_exists('mytheme_youtube_learning_render_card') ) : ?>
                        <?php mytheme_youtube_learning_render_card((int) get_the_ID()); ?>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php
                the_posts_pagination([
                    'add_args' => array_filter([
                        'yt_topic'   => $selected['yt_topic'],
                        'yt_channel' => $selected['yt_channel'],
                    ]),
                ]);
                ?>
            </div>
        <?php else : ?>
            <div class="youtube-learning-empty">
                <p>条件に合う学習動画はまだありません。ジャンルやYouTuberを変えて探してみてください。</p>
            </div>
        <?php endif; ?>
    </div>
</article>

<?php get_footer(); ?>
