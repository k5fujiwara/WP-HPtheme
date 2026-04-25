<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $news_archive_url = get_post_type_archive_link('news');
    $display_title = function_exists('mytheme_get_news_display_title')
        ? mytheme_get_news_display_title(get_the_ID())
        : get_the_title();
    $prev_news = get_previous_post();
    $next_news = get_next_post();
    ?>

    <article <?php post_class('page-content single-news-content'); ?>>
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <div class="news-single__card">
            <header class="page-header">
                <h1 class="page-title"><?php echo esc_html((string) $display_title); ?></h1>
            </header>

            <div class="page-body">
                <?php if ( has_post_thumbnail() ) : ?>
                    <figure class="news-single__thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </figure>
                <?php endif; ?>

                <?php the_content(); ?>

                <p class="news-single__published-at">
                    <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php echo esc_html(get_the_date('Y.m.d H:i')); ?>
                    </time>
                </p>

                <?php if ( $prev_news || $next_news ) : ?>
                    <nav class="post-nav news-post-nav" aria-label="前後のお知らせ">
                        <?php if ( $prev_news ) : ?>
                            <a class="post-nav__item post-nav__item--prev" rel="prev" href="<?php echo esc_url(get_permalink($prev_news)); ?>">
                                <span class="post-nav__kicker">前のお知らせ</span>
                                <span class="post-nav__title"><?php echo esc_html(get_the_title($prev_news)); ?></span>
                            </a>
                        <?php else : ?>
                            <span class="post-nav__item post-nav__item--prev is-empty" aria-hidden="true"></span>
                        <?php endif; ?>

                        <?php if ( $next_news ) : ?>
                            <a class="post-nav__item post-nav__item--next" rel="next" href="<?php echo esc_url(get_permalink($next_news)); ?>">
                                <span class="post-nav__kicker">次のお知らせ</span>
                                <span class="post-nav__title"><?php echo esc_html(get_the_title($next_news)); ?></span>
                            </a>
                        <?php else : ?>
                            <span class="post-nav__item post-nav__item--next is-empty" aria-hidden="true"></span>
                        <?php endif; ?>
                    </nav>
                <?php endif; ?>

            </div>
        </div>

        <?php if ( $news_archive_url ) : ?>
            <p class="news-single__back">
                <a class="work-link" href="<?php echo esc_url($news_archive_url); ?>">お知らせ一覧を見る</a>
            </p>
        <?php endif; ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
