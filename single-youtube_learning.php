<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$archive_url = get_post_type_archive_link('youtube_learning');
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $post_id = (int) get_the_ID();
    $video_title = function_exists('mytheme_youtube_learning_get_card_title') ? mytheme_youtube_learning_get_card_title($post_id) : get_the_title($post_id);
    $embed_url = function_exists('mytheme_get_youtube_learning_meta') ? mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_embed_url') : '';
    $video_url = function_exists('mytheme_get_youtube_learning_meta') ? mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_video_url') : '';
    $channel = function_exists('mytheme_youtube_learning_get_channel_data') ? mytheme_youtube_learning_get_channel_data($post_id) : ['name' => '', 'url' => ''];
    ?>
    <article class="page-content youtube-learning-detail">
        <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
            <?php mytheme_breadcrumb(); ?>
        <?php endif; ?>

        <header class="page-header youtube-learning-detail__header">
            <p class="youtube-learning-hero__label">Recommended Learning Video</p>
            <h1 class="page-title"><?php echo esc_html($video_title); ?></h1>
            <?php if ( $channel['name'] !== '' ) : ?>
                <p class="post-subtitle">by <?php echo esc_html($channel['name']); ?></p>
            <?php endif; ?>
        </header>

        <?php if ( $embed_url !== '' ) : ?>
            <div class="youtube-learning-player">
                <iframe src="<?php echo esc_url($embed_url); ?>" title="<?php echo esc_attr($video_title); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
            </div>
        <?php endif; ?>

        <div class="youtube-learning-detail__content">
            <main class="youtube-learning-detail__main">
                <?php if ( trim((string) get_the_content()) !== '' ) : ?>
                    <section class="youtube-learning-section">
                        <h2>視聴メモ</h2>
                        <div class="youtube-learning-section__body">
                            <?php the_content(); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <section class="youtube-learning-section youtube-learning-respect">
                    <h2>動画投稿者へのリスペクト</h2>
                    <p>このページでは、YouTube公式の埋め込み機能を使って動画を紹介しています。学びになった場合は、ぜひ元動画で高評価・コメント・チャンネル登録をお願いします。</p>
                    <div class="youtube-learning-actions">
                        <?php if ( $video_url !== '' ) : ?>
                            <a class="youtube-learning-button youtube-learning-button--secondary" href="<?php echo esc_url($video_url); ?>" target="_blank" rel="noopener noreferrer">YouTubeで元動画を見る</a>
                        <?php endif; ?>
                    </div>
                </section>
            </main>

            <aside class="youtube-learning-detail__aside" aria-label="動画情報">
                <section class="youtube-learning-author-card youtube-learning-author-card--compact">
                    <?php if ( $channel['name'] !== '' ) : ?>
                        <p class="youtube-learning-author-card__name"><?php echo esc_html($channel['name']); ?></p>
                    <?php endif; ?>
                    <?php if ( $channel['url'] !== '' ) : ?>
                        <a class="youtube-learning-button" href="<?php echo esc_url($channel['url']); ?>" target="_blank" rel="noopener noreferrer">チャンネルを見る</a>
                    <?php endif; ?>
                </section>

                <section class="youtube-learning-tax-box">
                    <h2>学習ジャンル</h2>
                    <div class="youtube-learning-card__tags">
                        <?php if ( function_exists('mytheme_youtube_learning_render_term_links') ) : ?>
                            <?php mytheme_youtube_learning_render_term_links($post_id, 'yt_topic', 'youtube-learning-tag'); ?>
                        <?php endif; ?>
                    </div>
                </section>

            </aside>
        </div>

        <?php if ( $archive_url ) : ?>
            <nav class="project-detail__back-link youtube-learning-detail__back" aria-label="学習動画ナビゲーション">
                <a class="back-link__anchor" href="<?php echo esc_url($archive_url); ?>">← 学習動画一覧に戻る</a>
            </nav>
        <?php endif; ?>
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>
