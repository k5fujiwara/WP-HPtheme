<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<article class="page-content beengineer-news-archive-page">
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>
    <?php
    $featured_post = null;
    $paged = max(1, (int) get_query_var('paged'));
    $student_works_url = 'https://beengineer-organization.github.io/vibecoding-gallery/';
    if ( $paged === 1 && function_exists('mytheme_get_beengineer_news_featured_post_id') ) {
        $featured_post_id = mytheme_get_beengineer_news_featured_post_id();
        if ( $featured_post_id > 0 ) {
            $featured_post = get_post($featured_post_id);
        }
    }
    ?>

    <header class="page-header beengineer-news-archive__header">
        <p class="beengineer-news-archive__eyebrow">BeEngineer Journal</p>
        <h1 class="page-title">BeEngineer通信</h1>
        <p class="beengineer-news-archive__lead">教室の取り組み、教育の考え方、イベントの記録をまとめて発信します。</p>
    </header>

    <div class="page-body">
        <?php if ( $featured_post instanceof WP_Post ) : ?>
            <?php
            $featured_category = function_exists('mytheme_get_beengineer_news_primary_category_label')
                ? mytheme_get_beengineer_news_primary_category_label($featured_post->ID)
                : '';
            ?>
            <section class="beengineer-news-featured" aria-label="BeEngineerとは">
                <div class="beengineer-news-featured__header">
                    <p class="beengineer-news-featured__label">BeEngineerとは</p>
                    <a class="beengineer-news-featured__works-link" href="<?php echo esc_url($student_works_url); ?>" target="_blank" rel="noopener noreferrer external">
                        体験生の作品を見る
                    </a>
                </div>
                <article class="beengineer-news-list-item beengineer-news-list-item--featured">
                    <a class="beengineer-news-list-item__link" href="<?php echo esc_url(get_permalink($featured_post)); ?>">
                        <div class="beengineer-news-list-item__thumb">
                            <?php if ( has_post_thumbnail($featured_post) ) : ?>
                                <?php echo get_the_post_thumbnail($featured_post, 'medium_large', ['class' => 'beengineer-news-list-item__image']); ?>
                            <?php else : ?>
                                <div class="beengineer-news-list-item__placeholder" aria-hidden="true">
                                    <span>BeEngineer</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="beengineer-news-list-item__meta">
                            <?php if ( $featured_category !== '' ) : ?>
                                <span class="beengineer-news-list-item__category"><?php echo esc_html($featured_category); ?></span>
                            <?php endif; ?>
                            <time class="beengineer-news-list-item__date" datetime="<?php echo esc_attr(get_the_date('c', $featured_post)); ?>">
                                <?php echo esc_html(get_the_date('Y.m.d', $featured_post)); ?>
                            </time>
                        </div>

                        <h2 class="beengineer-news-list-item__title"><?php echo esc_html(get_the_title($featured_post)); ?></h2>
                    </a>
                </article>
            </section>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <div class="beengineer-news-archive__list">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    $post_id = (int) get_the_ID();
                    $category = function_exists('mytheme_get_beengineer_news_primary_category_label')
                        ? mytheme_get_beengineer_news_primary_category_label($post_id)
                        : '';
                    ?>
                    <article <?php post_class('beengineer-news-list-item'); ?>>
                        <a class="beengineer-news-list-item__link" href="<?php the_permalink(); ?>">
                            <div class="beengineer-news-list-item__thumb">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('medium_large', ['class' => 'beengineer-news-list-item__image']); ?>
                                <?php else : ?>
                                    <div class="beengineer-news-list-item__placeholder" aria-hidden="true">
                                        <span>BeEngineer</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="beengineer-news-list-item__meta">
                                    <?php if ( $category !== '' ) : ?>
                                        <span class="beengineer-news-list-item__category"><?php echo esc_html($category); ?></span>
                                    <?php endif; ?>
                                    <time class="beengineer-news-list-item__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                    </time>
                            </div>

                            <h2 class="beengineer-news-list-item__title"><?php the_title(); ?></h2>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>

            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
        <?php elseif ( ! ( $featured_post instanceof WP_Post ) ) : ?>
            <p>BeEngineer通信はまだありません。</p>
        <?php endif; ?>
    </div>
</article>

<?php get_footer(); ?>
