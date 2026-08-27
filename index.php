<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$cat_meta = function_exists('mytheme_get_column_category_meta') ? mytheme_get_column_category_meta() : [];
?>

<?php if ( have_posts() ) : ?>

    <?php if ( is_singular() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php
            // 法務系ページのみ、本文を「1文字分」右に寄せて読みやすくする
            // is_page は「ID/スラッグ/タイトル」でも判定できるため、取りこぼし防止で両方を指定
            $is_legal_page = is_page([
                'privacy-policy',
                'プライバシーポリシー',
                'disclaimer',
                '免責事項 / 広告表記',
                '免責事項',
                'contact',
                'お問い合わせ',
            ]);
            $article_classes = ['page-content'];
            if ( $is_legal_page ) $article_classes[] = 'legal-page';
            if ( is_singular('post') ) $article_classes[] = 'single-post-content';
            $single_theme = is_singular('post') && function_exists('mytheme_get_learning_column_theme_meta')
                ? mytheme_get_learning_column_theme_meta(get_the_ID())
                : null;
            $single_updated_ts = is_singular('post') && function_exists('mytheme_learning_column_modified_timestamp')
                ? mytheme_learning_column_modified_timestamp(get_the_ID())
                : 0;
            ?>
            <article <?php post_class($article_classes); ?>>
                <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
                    <?php mytheme_breadcrumb(); ?>
                <?php endif; ?>

                <header class="page-header">
                    <h1 class="page-title"><?php the_title(); ?></h1>
                    <?php if ( is_singular('post') ) : ?>
                        <div class="single-post-meta" aria-label="記事情報">
                            <?php if ( $single_theme ) : ?>
                                <span class="single-post-meta__theme <?php echo esc_attr((string) $single_theme['class']); ?>"><?php echo esc_html((string) $single_theme['label']); ?></span>
                            <?php endif; ?>
                            <time class="single-post-meta__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">公開：<?php echo esc_html(get_the_date()); ?></time>
                            <?php if ( $single_updated_ts > 0 ) : ?>
                                <time class="single-post-meta__date" datetime="<?php echo esc_attr(mytheme_learning_column_modified_datetime(get_the_ID())); ?>">更新：<?php echo esc_html(mytheme_learning_column_modified_date(get_the_ID())); ?></time>
                            <?php endif; ?>
                            <span class="single-post-meta__author"><?php echo esc_html(function_exists('mytheme_get_learning_column_author_name') ? mytheme_get_learning_column_author_name(get_the_ID()) : get_the_author()); ?></span>
                        </div>
                    <?php endif; ?>
                </header>

                <div class="page-body">
                    <?php the_content(); ?>

                    <?php if ( is_singular('post') ) : ?>
                        <?php if ( function_exists('mytheme_render_post_references') ) : ?>
                            <?php mytheme_render_post_references((int) get_the_ID()); ?>
                        <?php endif; ?>

                        <?php if ( function_exists('mytheme_render_related_posts') ) : ?>
                            <?php mytheme_render_related_posts((int) get_the_ID(), 3); ?>
                        <?php endif; ?>

                        <?php if ( function_exists('mytheme_render_learning_column_author_box') ) : ?>
                            <?php mytheme_render_learning_column_author_box(); ?>
                        <?php endif; ?>

                        <?php if ( function_exists('mytheme_render_learning_column_toolbox') ) : ?>
                            <?php mytheme_render_learning_column_toolbox('single'); ?>
                        <?php endif; ?>

                        <?php
                        $post_tags = get_the_tags();
                        if ( is_array($post_tags) && ! empty($post_tags) ) :
                        ?>
                            <section class="post-tags" aria-label="この記事のタグ">
                                <h2 class="post-tags__title">この記事のタグ</h2>
                                <div class="post-tags__list">
                                    <?php foreach ( $post_tags as $tag ) : ?>
                                        <span class="post-tags__link">
                                            #<?php echo esc_html( (string) $tag->name ); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </section>
                        <?php endif; ?>

                        <?php
                        $prev = get_previous_post();
                        $next = get_next_post();
                        if ( $prev || $next ) :
                        ?>
                            <nav class="post-nav" aria-label="前後の記事">
                                <?php if ( $prev ) : ?>
                                    <a class="post-nav__item post-nav__item--prev" rel="prev" href="<?php echo esc_url(get_permalink($prev)); ?>">
                                        <span class="post-nav__kicker">前の記事</span>
                                        <span class="post-nav__title"><?php echo esc_html(get_the_title($prev)); ?></span>
                                    </a>
                                <?php else : ?>
                                    <span class="post-nav__item post-nav__item--prev is-empty" aria-hidden="true"></span>
                                <?php endif; ?>

                                <?php if ( $next ) : ?>
                                    <a class="post-nav__item post-nav__item--next" rel="next" href="<?php echo esc_url(get_permalink($next)); ?>">
                                        <span class="post-nav__kicker">次の記事</span>
                                        <span class="post-nav__title"><?php echo esc_html(get_the_title($next)); ?></span>
                                    </a>
                                <?php else : ?>
                                    <span class="post-nav__item post-nav__item--next is-empty" aria-hidden="true"></span>
                                <?php endif; ?>
                            </nav>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </article>
        <?php endwhile; ?>

    <?php else : ?>
        <?php
        $archive_heading = '';
        if ( is_home() ) {
            $archive_heading = '学習コラム一覧';
        } elseif ( is_category() || is_tag() || is_tax() ) {
            $archive_heading = single_term_title('', false);
        } elseif ( is_search() ) {
            $archive_heading = '検索結果';
        } elseif ( is_post_type_archive() ) {
            $archive_heading = post_type_archive_title('', false);
        }
        ?>
        <article class="page-content learning-column-page archive-posts-page">
            <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
                <?php mytheme_breadcrumb(); ?>
            <?php endif; ?>

            <?php if ( $archive_heading !== '' ) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php echo esc_html($archive_heading); ?></h1>
                </header>
            <?php endif; ?>

            <div class="page-body">
                <div class="learning-column-results">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php mytheme_render_learning_column_card($cat_meta, true); ?>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php the_posts_pagination(); ?>
                </div>
            </div>
        </article>
    <?php endif; ?>

<?php else : ?>
    <p>投稿がありません。</p>
<?php endif; ?>

<?php get_footer(); ?>
