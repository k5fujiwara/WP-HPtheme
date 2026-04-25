<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$works_page = mytheme_get_page_by_path_cached('works');
$works_url = $works_page ? get_permalink($works_page->ID) : home_url('/works/');
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $post_id = (int) get_the_ID();
    $title = get_the_title($post_id);
    $image_alt = function_exists('mytheme_get_work_meta') ? mytheme_get_work_meta($post_id, '_mytheme_work_card_image_alt', $title) : $title;
    $image_path = function_exists('mytheme_get_work_meta') ? mytheme_get_work_meta($post_id, '_mytheme_work_card_image_path') : '';
    $tech_tags = function_exists('mytheme_get_work_tech_tags') ? mytheme_get_work_tech_tags($post_id) : [];
    ?>
    <article class="page-content project-detail">
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <?php if ( has_post_thumbnail($post_id) || $image_path !== '' ) : ?>
            <div class="project-hero">
                <?php if ( has_post_thumbnail($post_id) ) : ?>
                    <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'project-hero__image', 'alt' => $image_alt]); ?>
                <?php elseif ( function_exists('mytheme_picture_tag') ) : ?>
                    <?php echo mytheme_picture_tag($image_path, $image_alt, 'project-hero__image', 'eager'); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="project-content">
            <?php if ( ! empty($tech_tags) ) : ?>
                <section class="project-section">
                    <h2 class="project-section__title">開発情報</h2>
                    <div class="tech-stack">
                        <?php foreach ( $tech_tags as $tag ) : ?>
                            <span class="tech-tag"><?php echo esc_html($tag); ?></span>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php the_content(); ?>
        </div>

        <div class="back-link">
            <a class="back-link__anchor" href="<?php echo esc_url($works_url); ?>">← 開発作品一覧に戻る</a>
        </div>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
