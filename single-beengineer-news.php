<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $post_id = (int) get_the_ID();
    $archive_url = get_post_type_archive_link('beengineer-news');
    $category = function_exists('mytheme_get_beengineer_news_primary_category_label')
        ? mytheme_get_beengineer_news_primary_category_label($post_id)
        : '';
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    ?>

    <article <?php post_class('page-content single-beengineer-news-content'); ?>>
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <header class="page-header beengineer-news-single__hero">
            <p class="beengineer-news-single__eyebrow">BeEngineer Journal</p>
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="page-body beengineer-news-single__body">
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="beengineer-news-single__thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </figure>
            <?php endif; ?>

            <div class="beengineer-news-single__content">
                <?php the_content(); ?>
            </div>

            <div class="beengineer-news-single__footer-meta">
                <?php if ( $category !== '' ) : ?>
                    <span class="beengineer-news-single__category"><?php echo esc_html($category); ?></span>
                <?php endif; ?>
                <time class="beengineer-news-single__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                    <?php echo esc_html(get_the_date('Y.m.d')); ?>
                </time>
            </div>
        </div>

        <?php if ( $prev_post || $next_post ) : ?>
            <nav class="post-nav beengineer-news-post-nav" aria-label="前後のBeEngineer通信">
                <?php if ( $prev_post ) : ?>
                    <a class="post-nav__item post-nav__item--prev" rel="prev" href="<?php echo esc_url(get_permalink($prev_post)); ?>">
                        <span class="post-nav__kicker">前の記事</span>
                        <span class="post-nav__title"><?php echo esc_html(get_the_title($prev_post)); ?></span>
                    </a>
                <?php else : ?>
                    <span class="post-nav__item post-nav__item--prev is-empty" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ( $next_post ) : ?>
                    <a class="post-nav__item post-nav__item--next" rel="next" href="<?php echo esc_url(get_permalink($next_post)); ?>">
                        <span class="post-nav__kicker">次の記事</span>
                        <span class="post-nav__title"><?php echo esc_html(get_the_title($next_post)); ?></span>
                    </a>
                <?php else : ?>
                    <span class="post-nav__item post-nav__item--next is-empty" aria-hidden="true"></span>
                <?php endif; ?>
            </nav>
        <?php endif; ?>

        <?php if ( $archive_url ) : ?>
            <p class="beengineer-news-single__back">
                <a class="work-link" href="<?php echo esc_url($archive_url); ?>">BeEngineer通信一覧へ戻る</a>
            </p>
        <?php endif; ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
