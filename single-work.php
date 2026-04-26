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
    $image_id = function_exists('mytheme_get_work_meta') ? (int) mytheme_get_work_meta($post_id, '_mytheme_work_card_image_id', 0) : 0;
    $image_path = function_exists('mytheme_get_work_meta') ? mytheme_get_work_meta($post_id, '_mytheme_work_card_image_path') : '';
    ?>
    <article class="page-content project-detail">
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <?php if ( $image_id > 0 || has_post_thumbnail($post_id) || $image_path !== '' ) : ?>
            <div class="project-hero">
                <?php if ( $image_id > 0 && function_exists('mytheme_work_get_attachment_image_html') ) : ?>
                    <?php echo mytheme_work_get_attachment_image_html($image_id, 'project-hero__image', $image_alt); ?>
                <?php elseif ( $image_path !== '' && function_exists('mytheme_picture_tag') ) : ?>
                    <?php echo mytheme_picture_tag($image_path, $image_alt, 'project-hero__image', 'eager'); ?>
                <?php elseif ( has_post_thumbnail($post_id) ) : ?>
                    <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'project-hero__image', 'alt' => $image_alt]); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( function_exists('mytheme_render_work_gallery') ) : ?>
            <?php mytheme_render_work_gallery($post_id); ?>
        <?php endif; ?>

        <?php if ( function_exists('mytheme_work_has_structured_detail') && mytheme_work_has_structured_detail($post_id) && function_exists('mytheme_render_work_structured_detail') ) : ?>
            <?php mytheme_render_work_structured_detail($post_id); ?>
        <?php else : ?>
            <?php the_content(); ?>
        <?php endif; ?>

        <div class="back-link">
            <a class="back-link__anchor" href="<?php echo esc_url($works_url); ?>">← 開発作品一覧に戻る</a>
        </div>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
