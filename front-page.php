<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

$page_url = static function (string $path): string {
    return function_exists('mytheme_get_page_url_by_path')
        ? (string) mytheme_get_page_url_by_path($path, home_url('/' . $path . '/'))
        : home_url('/' . $path . '/');
};
$about_url           = $page_url('about');
$works_url           = $page_url('works');
$learning_column_url = $page_url('learning-column');
$ebooks_url          = $page_url('ebooks');
$news_url            = get_post_type_archive_link('news') ?: home_url('/news/');
$beengineer_news_url = get_post_type_archive_link('beengineer-news') ?: home_url('/beengineer-news/');
$note_url            = 'https://note.com/k5fujiwara?utm_source=info-study&utm_medium=referral&utm_campaign=front';
$theme_url           = static function (string $slug) use ($learning_column_url): string {
    return add_query_arg('theme', $slug, $learning_column_url);
};

$cached_query = static function (string $key, array $args): WP_Query {
    if ( function_exists('mytheme_get_cached_id_query') ) {
        return mytheme_get_cached_id_query($key, $args);
    }
    return new WP_Query(array_merge([
        'post_status'         => 'publish',
        'no_found_rows'       => true,
        'ignore_sticky_posts' => true,
    ], $args));
};
$post_ids = static function (WP_Query $q): array {
    return array_map(static function ($p) {
        return (int) (is_object($p) ? $p->ID : $p);
    }, (array) $q->posts);
};

$popular_ids = $post_ids($cached_query('mytheme_front_popular_posts', [
    'post_type'              => 'post',
    'posts_per_page'         => 5,
    'meta_key'               => '_mytheme_post_views',
    'orderby'                => 'meta_value_num',
    'order'                  => 'DESC',
    'update_post_meta_cache' => true,
    'update_post_term_cache' => true,
]));
$latest_ids = $post_ids($cached_query('mytheme_front_latest_posts_v2', [
    'post_type'              => 'post',
    'posts_per_page'         => 5,
    'update_post_meta_cache' => true,
    'update_post_term_cache' => true,
]));
$beengineer_ids = $post_ids($cached_query('mytheme_front_latest_beengineer_news_v2', [
    'post_type'              => 'beengineer-news',
    'posts_per_page'         => 3,
    'update_post_meta_cache' => true,
    'update_post_term_cache' => false,
]));
$news_ids = $post_ids($cached_query('mytheme_front_latest_news', [
    'post_type'              => 'news',
    'posts_per_page'         => 3,
    'update_post_meta_cache' => false,
    'update_post_term_cache' => false,
]));
$featured_work_ids = function_exists('mytheme_get_front_featured_work_ids')
    ? mytheme_get_front_featured_work_ids(3)
    : [];

$themes = function_exists('mytheme_get_learning_column_themes') ? mytheme_get_learning_column_themes() : [];
unset($themes['review-required']);
$theme_count = static function (string $slug): int {
    return function_exists('mytheme_get_learning_column_theme_post_ids')
        ? count(mytheme_get_learning_column_theme_post_ids($slug))
        : 0;
};
$theme_label_of = static function (int $post_id): string {
    if ( ! function_exists('mytheme_get_learning_column_theme_meta') ) return '学習コラム';
    $meta = mytheme_get_learning_column_theme_meta($post_id);
    return ($meta['slug'] ?? '') === 'review-required' ? '学習コラム' : (string) $meta['label'];
};

$avatar = function_exists('mytheme_get_profile_image_url') ? mytheme_get_profile_image_url() : '';

// 4つの軸（サイトのテーマそのもの）
$axes = [
    [
        'no'    => '01',
        'title' => '教育',
        'axis'  => 'education',
        'text'  => '教室での指導や授業づくり、学び方の違いについて。',
        'url'   => $theme_url('education-learning'),
        'count' => $theme_count('education-learning'),
    ],
    [
        'no'    => '02',
        'title' => 'プログラミング',
        'axis'  => 'programming',
        'text'  => 'Python・Web・アプリ開発を、つまずきやすい所から。',
        'url'   => $theme_url('ai-programming'),
        'count' => $theme_count('ai-programming'),
    ],
    [
        'no'    => '03',
        'title' => 'AI',
        'axis'  => 'ai',
        'text'  => '生成AIを授業や仕事でどう使うか、試した結果を。',
        'url'   => add_query_arg(['s' => 'AI', 'post_type' => 'post'], home_url('/')),
        'count' => 0,
    ],
    [
        'no'    => '04',
        'title' => '個人開発',
        'axis'  => 'dev',
        'text'  => '情報Ⅰ対策アプリや学習ツールなど、作って公開したもの。',
        'url'   => $works_url,
        'count' => 0,
    ],
];
?>

<div class="home">

    <!-- ヒーロー：授業ノート（コード × 板書） -->
    <section class="home-hero" aria-labelledby="home-hero-title">
        <div class="home-hero__text">
            <p class="home-hero__axes" aria-label="このサイトのテーマ">
                <span>教育</span><i aria-hidden="true">×</i><span>プログラミング</span><i aria-hidden="true">×</i><span>AI</span><i aria-hidden="true">×</i><span>個人開発</span>
            </p>
            <h1 id="home-hero-title" class="home-hero__title">教えて、つくって、<br><mark>学んだこと</mark>を書く。</h1>
            <p class="home-hero__lead">プログラミング教室で中高生に教えながら、情報Ⅰ教材や学習アプリを個人で開発しています。AIの使い方も含めて、現場で試して分かったことを、あとから役立つ形で残しているノートです。</p>
            <div class="home-hero__actions">
                <a class="home-btn" href="#home-popular">よく読まれている記事から読む</a>
                <a class="home-textlink" href="<?php echo esc_url($learning_column_url); ?>">記事一覧</a>
            </div>
            <a class="home-byline" href="<?php echo esc_url($about_url); ?>">
                <?php if ( $avatar !== '' ) : ?>
                    <img class="home-byline__photo" src="<?php echo esc_url($avatar); ?>" alt="" width="44" height="44" decoding="async">
                <?php endif; ?>
                <span class="home-byline__text"><small>書いている人</small><strong>藤原圭吾</strong><span>プログラミング教室での指導・教室運営／個人開発</span></span>
            </a>
        </div>

        <figure class="home-board">
            <?php
            // 板書：1行ずつタイピングされ、書き終わった行に赤ペンの書き込みが入る（CSSアニメーション）
            $board_lines = [
                ['code' => '# 毎日の授業ノート', 'note' => '', 'axis' => '', 'class' => 'is-comment'],
                ['code' => 'while learning:', 'note' => '', 'axis' => 'programming', 'class' => ''],
                ['code' => '    teach(students)', 'note' => '教育', 'axis' => 'education', 'class' => ''],
                ['code' => '    build(tools)', 'note' => '個人開発', 'axis' => 'dev', 'class' => ''],
                ['code' => '    try_with(ai)', 'note' => 'AI', 'axis' => 'ai', 'class' => ''],
                ['code' => '    write(notes)', 'note' => 'このノート', 'axis' => 'note', 'class' => 'is-last'],
            ];
            $board_time = 0.4; // 最初の行を打ち始めるまでの秒数
            $board_ms_per_char = 0.035;
            ?>
            <div class="home-board__grid" aria-hidden="true">
                <span class="home-board__bar"><span class="home-board__file">lesson.py</span></span><span></span>
                <?php foreach ( $board_lines as $i => $line ) : ?>
                    <?php
                    $chars = max(1, mb_strlen($line['code']));
                    $duration = $chars * $board_ms_per_char;
                    $html = esc_html($line['code']);
                    $html = preg_replace('/^while\b/', '<b>while</b>', $html);
                    $html = preg_replace('/\(([a-z_]+)\)/', '(<em>$1</em>)', $html);
                    $style = sprintf('--chars:%d;--dur:%.2fs;--delay:%.2fs', $chars, $duration, $board_time);
                    $note_delay = $board_time + $duration;
                    $board_time = $note_delay + 0.12;
                    $axis_attr = $line['axis'] !== '' ? ' data-axis="' . esc_attr($line['axis']) . '"' : '';
                    $is_last = $i === count($board_lines) - 1;
                    ?>
                    <span class="home-board__line <?php echo esc_attr($line['class']); ?>"<?php echo $axis_attr; ?>><i><?php echo (int) $i + 1; ?></i><code style="<?php echo esc_attr($style); ?>"><?php echo $html; ?></code><?php if ( $is_last ) : ?><span class="home-board__caret" style="--delay:<?php echo esc_attr(sprintf('%.2fs', $note_delay)); ?>"></span><?php endif; ?></span><?php if ( $line['note'] !== '' ) : ?><span class="home-board__note"<?php echo $axis_attr; ?> style="--delay:<?php echo esc_attr(sprintf('%.2fs', $note_delay)); ?>"><?php echo esc_html($line['note']); ?></span><?php else : ?><span></span><?php endif; ?>

                <?php endforeach; ?>
            </div>
            <figcaption class="screen-reader-text">教える、つくる、AIで試す、書く。これを繰り返しながら学んだことを、このサイトに書いています。</figcaption>
        </figure>
    </section>

    <!-- 4つの軸 -->
    <section class="home-axes" aria-labelledby="home-axes-title">
        <h2 id="home-axes-title" class="screen-reader-text">このサイトで書いていること</h2>
        <ol class="home-axes__list">
            <?php foreach ( $axes as $axis ) : ?>
                <li class="home-axes__item" data-axis="<?php echo esc_attr($axis['axis']); ?>">
                    <a class="home-axes__link" href="<?php echo esc_url($axis['url']); ?>">
                        <span class="home-axes__no"><?php echo esc_html($axis['no']); ?></span>
                        <span class="home-axes__title"><?php echo esc_html($axis['title']); ?></span>
                        <span class="home-axes__text"><?php echo esc_html($axis['text']); ?></span>
                        <?php if ( $axis['count'] > 0 ) : ?>
                            <span class="home-axes__count"><?php echo esc_html((string) $axis['count']); ?>本の記事</span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </section>

    <?php if ( count($popular_ids) >= 3 ) : ?>
    <!-- よく読まれている記事 -->
    <section class="home-section" id="home-popular" aria-labelledby="home-popular-title">
        <header class="home-head">
            <h2 id="home-popular-title" class="home-head__title">よく読まれている記事</h2>
            <p class="home-head__note">はじめての方は、まずここから。</p>
        </header>
        <ol class="home-rank">
            <?php foreach ( $popular_ids as $i => $pid ) : ?>
                <li class="home-rank__item">
                    <a class="home-rank__link" href="<?php echo esc_url(get_permalink($pid)); ?>">
                        <span class="home-rank__no"><?php echo esc_html((string) ($i + 1)); ?></span>
                        <span class="home-rank__body">
                            <span class="home-rank__theme"><?php echo esc_html($theme_label_of($pid)); ?></span>
                            <span class="home-rank__title"><?php echo esc_html(get_the_title($pid)); ?></span>
                        </span>
                        <?php if ( has_post_thumbnail($pid) ) : ?>
                            <span class="home-rank__thumb"><?php echo get_the_post_thumbnail($pid, 'thumbnail', ['alt' => '', 'loading' => 'lazy', 'decoding' => 'async']); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ol>
    </section>
    <?php endif; ?>

    <!-- 新着の記事 -->
    <section class="home-section"<?php echo count($popular_ids) >= 3 ? '' : ' id="home-popular"'; ?> aria-labelledby="home-latest-title">
        <header class="home-head">
            <h2 id="home-latest-title" class="home-head__title">新しい記事</h2>
            <a class="home-head__more" href="<?php echo esc_url($learning_column_url); ?>">記事一覧へ</a>
        </header>

        <?php if ( ! empty($latest_ids) ) : ?>
            <div class="home-latest">
                <div class="home-latest__lead">
                    <?php mytheme_render_post_tile($latest_ids[0], ['heading' => 'h3', 'variant' => 'feature']); ?>
                </div>
                <?php if ( count($latest_ids) > 1 ) : ?>
                    <ul class="home-latest__list">
                        <?php foreach ( array_slice($latest_ids, 1) as $pid ) : ?>
                            <li>
                                <a class="home-entry" href="<?php echo esc_url(get_permalink($pid)); ?>">
                                    <span class="home-entry__meta">
                                        <time datetime="<?php echo esc_attr(get_the_date('c', $pid)); ?>"><?php echo esc_html(get_the_date('Y.m.d', $pid)); ?></time>
                                        <span><?php echo esc_html($theme_label_of($pid)); ?></span>
                                    </span>
                                    <span class="home-entry__title"><?php echo esc_html(get_the_title($pid)); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <p class="home-empty">記事は準備中です。</p>
        <?php endif; ?>

        <?php if ( ! empty($themes) ) : ?>
            <nav class="home-themes" aria-label="テーマから記事を探す">
                <span class="home-themes__label">テーマから探す：</span>
                <?php foreach ( $themes as $slug => $theme ) : ?>
                    <?php $count = $theme_count($slug); if ( $count === 0 ) continue; ?>
                    <a class="home-themes__link" href="<?php echo esc_url($theme_url($slug)); ?>"><?php echo esc_html((string) $theme['label']); ?><small><?php echo esc_html((string) $count); ?></small></a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>
    </section>

    <?php if ( ! empty($featured_work_ids) && function_exists('mytheme_render_work_tile') ) : ?>
    <!-- 開発作品 -->
    <section class="home-section" aria-labelledby="home-works-title">
        <header class="home-head">
            <h2 id="home-works-title" class="home-head__title">つくったもの</h2>
            <a class="home-head__more" href="<?php echo esc_url($works_url); ?>">開発作品一覧へ</a>
        </header>
        <p class="home-section__lead">教室で生徒と接する中で見えた「ここが不便」「ここでつまずく」を、自分の手で道具にしています。</p>
        <div class="work-tile-grid">
            <?php foreach ( $featured_work_ids as $work_id ) : ?>
                <?php mytheme_render_work_tile((int) $work_id); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 教室から -->
    <section class="home-section home-classroom" aria-labelledby="home-classroom-title">
        <div class="home-classroom__main">
            <header class="home-head">
                <h2 id="home-classroom-title" class="home-head__title">教室から</h2>
                <a class="home-head__more" href="<?php echo esc_url($beengineer_news_url); ?>">BeEngineer通信へ</a>
            </header>
            <p class="home-section__lead">中高生のためのプログラミング教室「BeEngineer」での授業やイベント、生徒たちの様子を記録しています。</p>
            <?php if ( ! empty($beengineer_ids) ) : ?>
                <ul class="home-classroom__list">
                    <?php foreach ( $beengineer_ids as $i => $pid ) : ?>
                        <li>
                            <a class="home-entry<?php echo ($i === 0 && has_post_thumbnail($pid)) ? ' home-entry--photo' : ''; ?>" href="<?php echo esc_url(get_permalink($pid)); ?>">
                                <?php if ( $i === 0 && has_post_thumbnail($pid) ) : ?>
                                    <span class="home-entry__photo"><?php echo get_the_post_thumbnail($pid, 'medium_large', ['alt' => '', 'loading' => 'lazy', 'decoding' => 'async']); ?></span>
                                <?php endif; ?>
                                <span class="home-entry__meta"><time datetime="<?php echo esc_attr(get_the_date('c', $pid)); ?>"><?php echo esc_html(get_the_date('Y.m.d', $pid)); ?></time></span>
                                <span class="home-entry__title"><?php echo esc_html(get_the_title($pid)); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="home-empty">記事は準備中です。</p>
            <?php endif; ?>
        </div>

        <?php if ( ! empty($news_ids) ) : ?>
            <aside class="home-classroom__news" aria-labelledby="home-news-title">
                <h2 id="home-news-title" class="home-news__title">お知らせ</h2>
                <ul class="home-news__list">
                    <?php foreach ( $news_ids as $pid ) : ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($pid)); ?>">
                                <time datetime="<?php echo esc_attr(get_the_date('c', $pid)); ?>"><?php echo esc_html(get_the_date('Y.m.d', $pid)); ?></time>
                                <span><?php echo esc_html(get_the_title($pid)); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a class="home-head__more" href="<?php echo esc_url($news_url); ?>">お知らせ一覧へ</a>
            </aside>
        <?php endif; ?>
    </section>

    <!-- 書いている人 -->
    <section class="home-author" aria-labelledby="home-author-title">
        <?php if ( $avatar !== '' ) : ?>
            <img class="home-author__photo" src="<?php echo esc_url($avatar); ?>" alt="" width="160" height="160" loading="lazy" decoding="async">
        <?php endif; ?>
        <div class="home-author__body">
            <p class="home-author__label">このノートを書いている人</p>
            <h2 id="home-author-title" class="home-author__name">藤原圭吾</h2>
            <p class="home-author__text">プログラミング教室での指導・教室運営と並行して、情報Ⅰ教材、学習アプリ、AIを活用した業務効率化ツールを制作しています。大学院では情報科学を研究していました。一般論だけでなく、自分で学び、試し、教えた経験をもとに書いています。</p>
            <ul class="home-author__links">
                <li><a href="<?php echo esc_url($about_url); ?>">詳しいプロフィール</a></li>
                <li><a href="<?php echo esc_url($page_url('contact')); ?>">お仕事のご相談</a></li>
                <li><a href="<?php echo esc_url($ebooks_url); ?>">電子書籍</a></li>
                <li><a href="<?php echo esc_url($note_url); ?>" target="_blank" rel="noopener noreferrer external">note（考えている途中のこと）</a></li>
            </ul>
        </div>
    </section>

</div>

<?php get_footer(); ?>
