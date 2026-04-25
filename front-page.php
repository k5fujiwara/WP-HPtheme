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
$news_url = function_exists('get_post_type_archive_link')
    ? get_post_type_archive_link('news')
    : home_url('/news/');
$beengineer_news_url = function_exists('get_post_type_archive_link')
    ? get_post_type_archive_link('beengineer-news')
    : home_url('/beengineer-news/');

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
?>

<div class="front-page">
    <div class="hero-section">
        <div class="hero-section__inner">
            <p class="hero-eyebrow">Learning, Growth, and Creation</p>
            <h1 class="hero-title">学び続ける、成長し続ける</h1>
            <p class="hero-lead">教育・プログラミング・自己成長を軸に、実践から得た学びを発信しています。</p>
        </div>
    </div>

    <!-- 最新の学習コラム（最優先） -->
    <section class="front-latest-posts" aria-label="最新の学習コラム">
        <div class="front-latest-posts__inner">
            <h2 class="front-latest-posts__title">効率的な学びと成長のための「学習準備室」</h2>
            <p class="front-latest-posts__lead">「やる気に頼らない勉強法」や「AI時代のスキルアップ」など、あなたの学びを加速させるヒントを公開中。</p>

            <div class="front-latest-posts__list">
                <?php if ( $latest_posts->have_posts() ) : ?>
                    <?php
                    $front_cat_meta = [
                        'education' => [
                            'key' => 'education',
                            'label' => '教育',
                            'badge_class' => 'is-education',
                            'icon' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="10" y1="8" x2="16" y2="8"></line><line x1="10" y1="12" x2="16" y2="12"></line><line x1="10" y1="16" x2="16" y2="16"></line></svg>',
                        ],
                        'programming' => [
                            'key' => 'programming',
                            'label' => 'プログラミング',
                            'badge_class' => 'is-programming',
                            'icon' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline><line x1="12" y1="2" x2="12" y2="22" opacity=".0"></line></svg>',
                        ],
                        'self-development' => [
                            'key' => 'self-development',
                            'label' => '自己啓発',
                            'badge_class' => 'is-self-development',
                            'icon' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M2 12h4"></path><path d="M18 12h4"></path><path d="M15 9l-3 3"></path></svg>',
                        ],
                    ];
                    ?>
                    <?php while ( $latest_posts->have_posts() ) : $latest_posts->the_post(); ?>
                        <?php
                        $post_url = get_permalink(get_the_ID());
                        $primary_meta = null;
                        $cats = get_the_category();
                        if ( is_array($cats) ) {
                            foreach ( $cats as $c ) {
                                $slug = isset($c->slug) ? (string) $c->slug : '';
                                if ( $slug !== '' && isset($front_cat_meta[$slug]) ) {
                                    $primary_meta = $front_cat_meta[$slug];
                                    break;
                                }
                            }
                        }
                        if ( ! $primary_meta ) {
                            $primary_meta = [
                                'key' => 'default',
                                'label' => '学習コラム',
                                'badge_class' => 'is-default',
                                'icon' => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>',
                            ];
                        }

                        $raw_excerpt = get_the_excerpt();
                        $excerpt_text = wp_strip_all_tags((string) $raw_excerpt);
                        $excerpt = function_exists('wp_html_excerpt')
                            ? wp_html_excerpt($excerpt_text, 120, '…')
                            : $excerpt_text;
                        ?>

                        <article <?php post_class('front-latest-card front-latest-card--' . esc_attr($primary_meta['key'])); ?>>
                            <a class="front-latest-card__link" href="<?php echo esc_url($post_url); ?>" aria-label="<?php echo esc_attr( get_the_title() ); ?>">
                                <div class="front-latest-card__meta">
                                    <span class="front-latest-card__badge <?php echo esc_attr($primary_meta['badge_class']); ?>">
                                        <span class="front-latest-card__badge-icon" aria-hidden="true"><?php echo $primary_meta['icon']; ?></span>
                                        <span class="front-latest-card__badge-text"><?php echo esc_html($primary_meta['label']); ?></span>
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

    <!-- 波型セクション区切り -->
    <div class="wave-divider" aria-hidden="true">
        <svg class="wave-divider__svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" role="presentation">
            <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
            <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
            <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
        </svg>
    </div>

    <div class="nav-cards">
        <!-- 学習コラム（サイト内記事） -->
        <div class="nav-card">
            <div class="nav-card-top">
                <div class="nav-card-head">
                    <div class="nav-card-icon" aria-hidden="true">
                        <svg class="nav-card-icon__svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                        </svg>
                    </div>
                    <h2 class="nav-card-title">学習コラム</h2>
                </div>
                <a href="<?php echo esc_url( $learning_column_url ); ?>" class="nav-card-link" aria-label="学習コラムへ">
                    記事一覧を見る
                    <svg class="nav-card-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <p class="nav-card-description">教育・プログラミング・自己啓発の学びを蓄積</p>
        </div>

        <!-- 自己紹介ページ -->
        <div class="nav-card">
            <div class="nav-card-top">
                <div class="nav-card-head">
                    <div class="nav-card-icon" aria-hidden="true">
                        <svg class="nav-card-icon__svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <h2 class="nav-card-title">自己紹介</h2>
                </div>
                <a href="<?php echo esc_url( $about_url ); ?>" class="nav-card-link" aria-label="自己紹介ページへ">
                    詳しく見る
                    <svg class="nav-card-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <p class="nav-card-description">プロフィールや経歴について</p>
        </div>

        <!-- 開発作品紹介ページ（任意） -->
        <div class="nav-card">
            <div class="nav-card-top">
                <div class="nav-card-head">
                    <div class="nav-card-icon" aria-hidden="true">
                        <svg class="nav-card-icon__svg" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="16 18 22 12 16 6"></polyline>
                            <polyline points="8 6 2 12 8 18"></polyline>
                        </svg>
                    </div>
                    <h2 class="nav-card-title">開発作品</h2>
                </div>
                <a href="<?php echo esc_url( $works_url ); ?>" class="nav-card-link" aria-label="開発作品ページへ">
                    作品を見る
                    <svg class="nav-card-link__icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <p class="nav-card-description">学びの成果として制作したプロジェクト</p>
        </div>
    </div>

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

    <section class="front-beengineer" aria-label="BeEngineer通信">
        <div class="front-beengineer__inner">
            <div class="front-beengineer__content">
                <div class="front-beengineer__headline">
                    <div class="front-beengineer__heading">
                        <p class="front-beengineer__eyebrow">BeEngineer Journal</p>
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

    <!-- サイト紹介セクション -->
    <section class="site-intro">
        <details class="site-intro__details" open>
            <summary class="site-intro__summary">
                <span class="site-intro__summary-copy">
                    <span class="site-intro__summary-label">About This Site</span>
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
                    学びと成長を支援する情報発信プラットフォーム
                </p>
                <div class="intro-content">
                    <p class="intro-content__text">
                        当サイトは、<strong>教育・自己啓発・プログラミング</strong>に関する情報を発信しています。
                        学び続ける全ての方々に、実践的な知識とインスピレーションをお届けすることを目指しています。
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
                            <svg class="feature-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" role="img" aria-label="自己成長アイコン">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                            </svg>
                            <div class="feature-icon-bg" aria-hidden="true"></div>
                        </div>
                        <h3 class="intro-feature__title">自己成長</h3>
                        <p class="intro-feature__description">継続的な学びと挑戦の記録を発信します</p>
                    </div>
                </div>
            </div>
        </details>
    </section>

</div>

<!-- 構造化データ: WebSite -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "<?php echo esc_js( get_bloginfo('name') ); ?>",
    "description": "<?php echo esc_js( get_bloginfo('description') ); ?>",
    "url": "<?php echo esc_url( home_url('/') ); ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": {
            "@type": "EntryPoint",
            "urlTemplate": "<?php echo esc_url( home_url('/') ); ?>?s={search_term_string}"
        },
        "query-input": "required name=search_term_string"
    }
}
</script>

<?php
// EducationalOrganization構造化データはfunctions.phpで出力されます
?>

<?php get_footer(); ?>

