<?php
/**
 * Template Name: 電子書籍（本棚）
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$ebooks = function_exists('mytheme_get_ebooks') ? mytheme_get_ebooks() : [];
$lang = function_exists('mytheme_get_ebooks_lang') ? mytheme_get_ebooks_lang() : 'ja';
$switch_to = ($lang === 'ja') ? 'en' : 'ja';
$self_url = get_permalink();
?>

<?php while ( have_posts() ) : the_post(); ?>
<article class="page-content ebooks-page ebooks-lang-scope" data-ebooks-lang="<?php echo esc_attr($lang); ?>">
    <?php if ( function_exists('mytheme_breadcrumb') ) mytheme_breadcrumb(); ?>

    <header class="page-header">
        <h1 class="page-title"><?php the_title(); ?></h1>
    </header>

    <p class="page-description">
        Kindleで出版した電子書籍をまとめています。
    </p>

    <div class="ebooks-lang-switch">
        <button type="button" class="work-link ebooks-lang-switch__btn<?php echo $lang === 'ja' ? ' is-active' : ''; ?>" data-ebooks-lang="ja" aria-pressed="<?php echo $lang === 'ja' ? 'true' : 'false'; ?>">日本語</button>
        <button type="button" class="work-link ebooks-lang-switch__btn<?php echo $lang === 'en' ? ' is-active' : ''; ?>" data-ebooks-lang="en" aria-pressed="<?php echo $lang === 'en' ? 'true' : 'false'; ?>">English</button>
    </div>

    <div class="page-body">
        <?php the_content(); ?>
    </div>

    <?php if ( ! empty($ebooks) && is_array($ebooks) ) : ?>
        <div class="ebooks-grid">
            <?php foreach ( $ebooks as $book ) :
                $store = isset($book['store']) ? (string) $book['store'] : 'Kindle';
                $edition_ja = function_exists('mytheme_get_ebook_edition') ? mytheme_get_ebook_edition($book, 'ja') : null;
                $edition_en = function_exists('mytheme_get_ebook_edition') ? mytheme_get_ebook_edition($book, 'en') : null;
                ?>
                <article class="ebook-card">
                    <div class="ebook-card__media">
                        <?php if ( function_exists('mytheme_picture_tag') ) : ?>
                            <?php if ( $edition_ja && ! empty($edition_ja['cover']) ) : ?>
                                <div class="ebook-edition" data-lang="ja">
                                    <?php echo mytheme_picture_tag((string) $edition_ja['cover'], (string) ($edition_ja['title'] ?? ''), 'ebook-card__image', 'lazy'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( $edition_en && ! empty($edition_en['cover']) ) : ?>
                                <div class="ebook-edition" data-lang="en">
                                    <?php echo mytheme_picture_tag((string) $edition_en['cover'], (string) ($edition_en['title'] ?? ''), 'ebook-card__image', 'lazy'); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="ebook-card__body">
                        <div class="ebook-card__meta">
                            <span class="tech-tag"><?php echo esc_html($store); ?></span>
                        </div>

                        <?php if ( $edition_ja ) : ?>
                            <div class="ebook-edition" data-lang="ja">
                                <h2 class="ebook-card__title"><?php echo esc_html( (string) ($edition_ja['title'] ?? '') ); ?></h2>
                                <?php if ( ! empty($edition_ja['subtitle']) ) : ?>
                                    <p class="ebook-card__subtitle"><?php echo esc_html( (string) $edition_ja['subtitle'] ); ?></p>
                                <?php endif; ?>
                                <?php if ( ! empty($edition_ja['description']) ) : ?>
                                    <p class="ebook-card__description"><?php echo esc_html( (string) $edition_ja['description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $edition_en ) : ?>
                            <div class="ebook-edition" data-lang="en">
                                <h2 class="ebook-card__title"><?php echo esc_html( (string) ($edition_en['title'] ?? '') ); ?></h2>
                                <?php if ( ! empty($edition_en['subtitle']) ) : ?>
                                    <p class="ebook-card__subtitle"><?php echo esc_html( (string) $edition_en['subtitle'] ); ?></p>
                                <?php endif; ?>
                                <?php if ( ! empty($edition_en['description']) ) : ?>
                                    <p class="ebook-card__description"><?php echo esc_html( (string) $edition_en['description'] ); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <div class="ebook-card__actions">
                            <?php
                            $ja_url = $edition_ja && ! empty($edition_ja['url']) ? (string) $edition_ja['url'] : '';
                            $en_url = $edition_en && ! empty($edition_en['url']) ? (string) $edition_en['url'] : '';
                            ?>
                            <?php if ( $ja_url ) : ?>
                                <div class="ebook-edition" data-lang="ja">
                                    <a class="work-link work-link-demo" href="<?php echo esc_url($ja_url); ?>" target="_blank" rel="noopener noreferrer">Amazonで購入（日本語版）</a>
                                </div>
                            <?php endif; ?>
                            <?php if ( $en_url ) : ?>
                                <div class="ebook-edition" data-lang="en">
                                    <a class="work-link work-link-demo" href="<?php echo esc_url($en_url); ?>" target="_blank" rel="noopener noreferrer">Amazonで購入（English）</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>準備中です。</p>
    <?php endif; ?>

</article>
<?php endwhile; ?>

<?php get_footer(); ?>


