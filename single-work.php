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
    $show_hero_image = ! function_exists('mytheme_get_work_meta') || mytheme_get_work_meta($post_id, '_mytheme_work_show_hero_image', '1') !== '0';
    ?>
    <article class="page-content project-detail">
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <?php if ( $show_hero_image && ( $image_id > 0 || has_post_thumbnail($post_id) || $image_path !== '' ) ) : ?>
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
            <?php if ( trim((string) get_the_content()) !== '' ) : ?>
                <?php the_content(); ?>
            <?php endif; ?>
        <?php else : ?>
            <?php the_content(); ?>
        <?php endif; ?>

        <nav class="project-detail__back-link" aria-label="開発作品ナビゲーション" style="border:0;box-sizing:border-box;margin:0;padding:64px 0 96px;text-align:center;width:100%;">
            <a class="back-link__anchor" href="<?php echo esc_url($works_url); ?>" style="display:inline-block;margin:0 auto;">← 開発作品一覧に戻る</a>
        </nav>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
