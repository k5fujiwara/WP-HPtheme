<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// ページURLを取得（1リクエスト内キャッシュ付きヘルパーを優先）
$about_url = function_exists('mytheme_get_page_url_by_path')
    ? mytheme_get_page_url_by_path('about', home_url('/about/'))
    : home_url('/about/');
$works_url = function_exists('mytheme_get_page_url_by_path')
    ? mytheme_get_page_url_by_path('works', home_url('/works/'))
    : home_url('/works/');
$learning_column_url = function_exists('mytheme_get_page_url_by_path')
    ? mytheme_get_page_url_by_path('learning-column', home_url('/learning-column/'))
    : home_url('/learning-column/');
$learning_tools_url = function_exists('get_post_type_archive_link')
    ? get_post_type_archive_link('youtube_learning')
    : home_url('/youtube-learning/');
if ( ! $learning_tools_url ) {
    $learning_tools_url = home_url('/youtube-learning/');
}
$news_url = function_exists('get_post_type_archive_link')
    ? get_post_type_archive_link('news')
    : home_url('/news/');
$beengineer_news_url = function_exists('get_post_type_archive_link')
    ? get_post_type_archive_link('beengineer-news')
    : home_url('/beengineer-news/');
$ebooks_url = function_exists('mytheme_get_page_url_by_path')
    ? mytheme_get_page_url_by_path('ebooks', home_url('/ebooks/'))
    : home_url('/ebooks/');

// 最新の学習コラム（トップで最優先表示）
$latest_posts = new WP_Query([
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'no_found_rows'  => true,
]);

$latest_news = new WP_Query([
    'post_type'              => 'news',
    'post_status'            => 'publish',
    'posts_per_page'         => 3,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
]);

$latest_beengineer_news = new WP_Query([
    'post_type'              => 'beengineer-news',
    'post_status'            => 'publish',
    'posts_per_page'         => 2,
    'no_found_rows'          => true,
    'ignore_sticky_posts'    => true,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
]);

$featured_work_ids = function_exists('mytheme_get_front_featured_work_ids')
    ? mytheme_get_front_featured_work_ids(3)
    : [];
?>

<div class="front-page">
    <div class="hero-section">
        <div class="hero-section__inner">
            <p class="hero-eyebrow">Learning, Growth, and Creation</p>
            <h1 class="hero-title">学び続ける、成長し続ける</h1>
            <p class="hero-lead">教育現場での実践、AI・プログラミング、資格学習、個人開発など、自分自身が学び・試したことを体系的に整理しています。</p>
        </div>
    </div>

    <section class="front-finder" aria-labelledby="front-finder-title">
        <div class="front-section-heading">
            <p class="front-section-kicker">Start Here</p>
            <h2 id="front-finder-title" class="front-section-title">何を探していますか？</h2>
            <p class="front-section-lead">目的に合わせて、記事・ツール・プロフィールへ進めます。</p>
        </div>

        <div class="front-choice-grid">
            <a class="front-choice-card" href="<?php echo esc_url($learning_column_url); ?>">
                <span class="front-choice-card__label">学びたい</span>
                <span class="front-choice-card__title">学習コラム</span>
                <span class="front-choice-card__text">教育・AI・プログラミング・資格・学習法などを体系的に整理。</span>
            </a>
            <a class="front-choice-card" href="<?php echo esc_url($works_url); ?>">
                <span class="front-choice-card__label">使ってみたい</span>
                <span class="front-choice-card__title">学習ツール / 開発作品</span>
                <span class="front-choice-card__text">情報Ⅰ対策や学習支援など、実際に制作したツールやプロジェクト。</span>
            </a>
            <a class="front-choice-card" href="<?php echo esc_url($about_url); ?>">
                <span class="front-choice-card__label">運営者を知りたい</span>
                <span class="front-choice-card__title">自己紹介</span>
                <span class="front-choice-card__text">教育・研究・開発・教室運営など、これまでの経験と活動。</span>
            </a>
        </div>
    </section>

    <section class="front-featured" aria-labelledby="front-featured-title">
        <div class="front-section-heading">
            <p class="front-section-kicker">Featured</p>
            <h2 id="front-featured-title" class="front-section-title">代表的なコンテンツ</h2>
            <p class="front-section-lead">このサイトらしさが伝わる、実践・開発・教育現場の入口です。</p>
        </div>

        <div class="front-featured-grid">
            <a class="front-featured-card front-featured-card--primary" href="<?php echo esc_url($works_url); ?>">
                <span class="front-featured-card__eyebrow">Learning Product</span>
                <h3 class="front-featured-card__title">教育・学習プロダクト</h3>
                <p class="front-featured-card__text">情報Ⅰ対策アプリやLINE学習Botなど、学習者の課題解決を目的に制作したものをまとめています。</p>
                <span class="front-featured-card__link">開発作品を見る</span>
            </a>
            <a class="front-featured-card" href="<?php echo esc_url($learning_column_url); ?>">
                <span class="front-featured-card__eyebrow">Column</span>
                <h3 class="front-featured-card__title">教育・AI・継続学習の整理</h3>
                <p class="front-featured-card__text">一般論だけでなく、実際に学び、試し、教育現場で考えたことを記事として蓄積しています。</p>
                <span class="front-featured-card__link">記事を読む</span>
            </a>
            <a class="front-featured-card" href="<?php echo esc_url($beengineer_news_url); ?>">
                <span class="front-featured-card__eyebrow">BeEngineer通信</span>
                <h3 class="front-featured-card__title">教育現場からの一次情報</h3>
                <p class="front-featured-card__text">教室運営、イベント、生徒の学び、指導者としての振り返りをBeEngineer通信として発信します。</p>
                <span class="front-featured-card__link">BeEngineer通信へ</span>
            </a>
        </div>
    </section>

    <!-- 最新の学習コラム -->
    <section class="front-latest-posts" aria-label="最新の学習コラム">
        <div class="front-latest-posts__inner">
            <h2 class="front-latest-posts__title">最新の学習コラム</h2>
            <p class="front-latest-posts__lead">教育・AI・プログラミング・資格学習など、学びを実践につなげるための記事を更新しています。</p>

            <div class="front-latest-posts__list">
                <?php if ( $latest_posts->have_posts() ) : ?>
                    <?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
                        <?php
                        $post_url = get_permalink(get_the_ID());
                        $primary_meta = function_exists('mytheme_get_learning_column_theme_meta')
                            ? mytheme_get_learning_column_theme_meta(get_the_ID())
                            : [
                                'slug'  => 'default',
                                'label' => '学習コラム',
                                'class' => 'is-default',
                            ];

                        $raw_excerpt = get_the_excerpt();
                        $excerpt_text = wp_strip_all_tags((string) $raw_excerpt);
                        $excerpt = function_exists('wp_html_excerpt')
                            ? wp_html_excerpt($excerpt_text, 120, '…')
                            : $excerpt_text;
                        ?>

                        <article <?php post_class('front-latest-card front-latest-card--' . esc_attr((string) $primary_meta['slug'])); ?>>
                            <a class="front-latest-card__link" href="<?php echo esc_url($post_url); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                                <div class="front-latest-card__meta">
                                    <span class="front-latest-card__badge <?php echo esc_attr((string) $primary_meta['class']); ?>">
                                        <span class="front-latest-card__badge-text"><?php echo esc_html((string) $primary_meta['label']); ?></span>
                                    </span>
                                    <time class="front-latest-card__date" datetime="<?php echo esc_attr( get_the_date('c') ); ?>">
                                        <?php echo esc_html( get_the_date() ); ?>
                                    </time>
                                </div>

                                <h3 class="front-latest-card__title">
                                    <span class="front-latest-card__title-text"><?php the_title(); ?></span>
                                </h3>

                                <p class="front-latest-card__excerpt"><?php echo esc_html((string) $excerpt); ?></p>

                                <p class="front-latest-card__cta">
                                    <span class="front-latest-card__cta-link">この記事を読む</span>
                                </p>
                            </a>
                        </article>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>まだ投稿がありません。学習コラムを投稿してみましょう。</p>
                <?php endif; ?>
            </div>

            <p class="front-latest-posts__more">
                <a class="work-link" href="<?php echo esc_url( $learning_column_url ); ?>">学習コラム一覧を見る</a>
            </p>
        </div>
    </section>

    <?php wp_reset_postdata(); ?>

    <section class="front-tools" aria-labelledby="front-tools-title">
        <div class="front-section-heading">
            <p class="front-section-kicker">Works</p>
            <h2 id="front-tools-title" class="front-section-title">開発・学習ツール</h2>
            <p class="front-section-lead">技術スタックよりも、「誰の何を解決するか」が先に伝わるように整理しています。</p>
        </div>

        <div class="front-tools__actions">
            <a class="work-link" href="<?php echo esc_url($learning_tools_url); ?>">学習ツールを見る</a>
            <a class="work-link work-link-demo" href="<?php echo esc_url($works_url); ?>">開発作品を見る</a>
        </div>

        <?php if ( ! empty($featured_work_ids) ) : ?>
            <div class="front-tools__list">
                <?php foreach ( $featured_work_ids as $work_id ) : ?>
                    <?php if ( function_exists('mytheme_render_work_card') ) mytheme_render_work_card((int) $work_id); ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section class="front-beengineer" aria-label="BeEngineer通信">
        <div class="front-beengineer__inner">
            <div class="front-beengineer__content">
                <div class="front-beengineer__headline">
                    <div class="front-beengineer__heading">
                        <h2 class="front-beengineer__title">BeEngineer通信</h2>
                    </div>
                    <p class="front-beengineer__cta">
                        <a class="work-link" href="<?php echo esc_url($beengineer_news_url); ?>">
                            <span class="label-desktop">BeEngineer通信を見る</span>
                            <span class="label-mobile">BeEngineer<br>通信を見る</span>
                        </a>
                    </p>
                </div>
                <p class="front-beengineer__lead">BeEngineerは、中高生のための実践的なプログラミング教室です。</p>
                <p class="front-beengineer__sublead">教室の取り組み、教育の考え方、イベントの記録をまとめて発信します。</p>
            </div>

            <div class="front-beengineer__latest">
                <p class="front-beengineer__latest-title">最新記事</p>
                <?php if ( $latest_beengineer_news->have_posts() ) : ?>
                    <ul class="front-beengineer__list">
                        <?php while ( $latest_beengineer_news->have_posts() ) : $latest_beengineer_news->the_post(); ?>
                            <li class="front-beengineer__item">
                                <a class="front-beengineer__link" href="<?php the_permalink(); ?>">
                                    <time class="front-beengineer__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                        <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                    </time>
                                    <span class="front-beengineer__item-title"><?php the_title(); ?></span>
                                    <span class="front-beengineer__marker" aria-hidden="true">＞</span>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else : ?>
                    <p class="front-beengineer__empty">記事は準備中です。公開次第こちらから確認できます。</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php wp_reset_postdata(); ?>

    <section class="front-about" aria-labelledby="front-about-title">
        <div class="front-about__inner">
            <div>
                <h2 id="front-about-title" class="front-section-title">教育・開発・学びをつなげる個人Web資産</h2>
                <p class="front-about__text">教育現場での指導や教室運営と並行して、情報Ⅰ教材、学習アプリ、AIを活用した業務効率化ツールなどを制作しています。日々の学びを、あとから使える形に整理して蓄積します。</p>
            </div>
            <p class="front-about__action">
                <a class="work-link" href="<?php echo esc_url($about_url); ?>">運営者を知る</a>
            </p>
        </div>
    </section>

    <section class="front-ebooks" aria-labelledby="front-ebooks-title">
        <div class="front-ebooks__inner">
            <div>
                <h2 id="front-ebooks-title" class="front-section-title">電子書籍</h2>
                <p class="front-section-lead">学習法・仕事術・アウトプットなど、サイト内の実践知を別の形でも整理しています。</p>
            </div>
            <a class="work-link" href="<?php echo esc_url($ebooks_url); ?>">電子書籍を見る</a>
        </div>
    </section>

    <?php if ( $latest_news->have_posts() ) : ?>
    <section class="front-news" aria-label="お知らせ">
        <div class="front-news__inner">
            <div class="front-news__header">
                <div>
                    <h2 class="front-news__title">お知らせ</h2>
                </div>
                <a class="front-news__archive-link" href="<?php echo esc_url($news_url); ?>">一覧を見る</a>
            </div>

            <ul class="front-news__list">
                <?php
                if ( function_exists('mytheme_render_news_list_items') ) {
                    mytheme_render_news_list_items($latest_news, [
                        'item_class'    => 'front-news__item',
                        'link_class'    => 'front-news__link',
                        'date_class'    => 'front-news__date',
                        'title_class'   => 'front-news__item-title',
                        'date_format'   => 'Y.m.d',
                        'date_position' => 'left',
                    ]);
                }
                ?>
            </ul>
        </div>
    </section>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>

    <!-- サイト紹介セクション -->
    <section class="site-intro">
        <details class="site-intro__details" open>
            <summary class="site-intro__summary">
                <span class="site-intro__summary-copy">
                    <span class="site-intro__summary-title">このサイトについて</span>
                    <span class="site-intro__summary-text">運営方針や発信内容を見る</span>
                </span>
                <span class="site-intro__summary-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m6 9 6 6 6-6"></path>
                    </svg>
                </span>
            </summary>

            <div class="intro-container site-intro__panel">
                <p class="intro-lead">
                    教育現場での実践、AI・プログラミング、継続学習を整理するサイト
                </p>
                <div class="intro-content">
                    <p class="intro-content__text">
                        当サイトは、<strong>教育現場での実践、AI・プログラミング、情報Ⅰ、資格学習、個人開発</strong>に関する情報を整理しています。
                        一般的な解説だけでなく、実際に学び、試し、使った経験をあとから参照できる形で蓄積します。
                    </p>
                </div>

                <div class="intro-features">
                    <div class="intro-feature">
                        <div class="feature-icon-wrapper">
                            <svg class="feature-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" role="img" aria-label="学習支援アイコン">
                                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                                <line x1="10" y1="8" x2="16" y2="8"></line>
                                <line x1="10" y1="12" x2="16" y2="12"></line>
                                <line x1="10" y1="16" x2="16" y2="16"></line>
                            </svg>
                            <div class="feature-icon-bg" aria-hidden="true"></div>
                        </div>
                        <h3 class="intro-feature__title">学習支援</h3>
                        <p class="intro-feature__description">実践的な学習方法や資格取得の経験を共有します</p>
                    </div>
                    <div class="intro-feature">
                        <div class="feature-icon-wrapper">
                            <svg class="feature-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" role="img" aria-label="技術開発アイコン">
                                <polyline points="16 18 22 12 16 6"></polyline>
                                <polyline points="8 6 2 12 8 18"></polyline>
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            </svg>
                            <div class="feature-icon-bg" aria-hidden="true"></div>
                        </div>
                        <h3 class="intro-feature__title">技術開発</h3>
                        <p class="intro-feature__description">Pythonを中心とした開発プロジェクトを紹介します</p>
                    </div>
                    <div class="intro-feature">
                        <div class="feature-icon-wrapper">
                            <svg class="feature-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" role="img" aria-label="継続学習アイコン">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                            </svg>
                            <div class="feature-icon-bg" aria-hidden="true"></div>
                        </div>
                        <h3 class="intro-feature__title">継続学習</h3>
                        <p class="intro-feature__description">資格学習や実践の記録を、次の学びにつながる形で整理します</p>
                    </div>
                </div>
            </div>
        </details>
    </section>

</div>

<?php get_footer(); ?>

