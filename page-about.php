<?php
/**
 * Template Name: 自己紹介ページ
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    $beengineer_news_url = function_exists('get_post_type_archive_link')
        ? get_post_type_archive_link('beengineer-news')
        : home_url('/beengineer-news/');
    $about_beengineer_posts = new WP_Query([
        'post_type'              => 'beengineer-news',
        'post_status'            => 'publish',
        'posts_per_page'         => 3,
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);
    ?>
    <?php
    $about_page_url = static function (string $path): string {
        return function_exists('mytheme_get_page_url_by_path')
            ? (string) mytheme_get_page_url_by_path($path, home_url('/' . $path . '/'))
            : home_url('/' . $path . '/');
    };
    $contact_url  = $about_page_url('contact');
    $works_url    = $about_page_url('works');
    $theme_uri    = get_template_directory_uri();
    $has_portrait = file_exists(get_template_directory() . '/assets/images/fujiwara-portrait-480.webp');

    // 経歴から抜き出した「ひと目で分かる」数字
    $about_facts = [
        ['num' => '14', 'unit' => '年', 'label' => '指導歴（個別指導5年・集団授業6年・プログラミング3年）'],
        ['num' => '130', 'unit' => '名超', 'label' => 'の生徒が在籍する校舎を、責任者として運営'],
        ['num' => '2', 'unit' => '本', 'label' => '査読付き英語論文'],
    ];
    // 電子書籍は日本語版・英語版をそれぞれ1冊として数える
    $about_ebook_count = 0;
    foreach ( (function_exists('mytheme_get_ebooks') ? (array) mytheme_get_ebooks() : []) as $about_book ) {
        $about_ebook_count += ! empty($about_book['editions']) ? count((array) $about_book['editions']) : 1;
    }
    if ( $about_ebook_count > 0 ) {
        $about_facts[] = ['num' => (string) $about_ebook_count, 'unit' => '冊', 'label' => 'Kindleで出版した電子書籍（日本語版・英語版）'];
    }
    $about_facts[] = ['num' => '40', 'unit' => '万円', 'label' => '2026年の投資収益額'];

    // お手伝いできること（実績に基づく）
    $about_services = [
        [
            'no'    => '01',
            'title' => '募集LP・案内ページの制作',
            'text'  => '塾の入塾募集・講習会・合宿のLPを、時期や読む人の目的に合わせて作り分けてきました。',
            'link'  => ['label' => '制作実績', 'url' => '#about-portfolio'],
        ],
        [
            'no'    => '02',
            'title' => '学習アプリ・教材の開発',
            'text'  => '情報Ⅰ対策アプリや模試など、教える現場で「ここでつまずく」を解決する道具をつくります。',
            'link'  => ['label' => '開発作品', 'url' => $works_url],
        ],
        [
            'no'    => '03',
            'title' => 'AIを使った業務効率化',
            'text'  => '生成AIとプログラミングで、手作業の多い事務や資料づくりを自動化するツールを開発しています。',
            'link'  => ['label' => '開発作品', 'url' => $works_url],
        ],
        [
            'no'    => '04',
            'title' => '授業・講座・研修',
            'text'  => '中高生へのプログラミング・情報Ⅰ指導、映像授業への出演。最大50人規模の集団授業にも対応します。',
            'link'  => null,
        ],
    ];
    ?>
    <article class="page-content about-page">
        <?php mytheme_breadcrumb(); ?>

        <!-- プロフィール -->
        <header class="ab-hero">
            <?php if ( $has_portrait ) : ?>
                <figure class="ab-hero__photo">
                    <img
                        src="<?php echo esc_url($theme_uri . '/assets/images/fujiwara-portrait-480.webp'); ?>"
                        srcset="<?php echo esc_url($theme_uri . '/assets/images/fujiwara-portrait-480.webp'); ?> 480w, <?php echo esc_url($theme_uri . '/assets/images/fujiwara-portrait-800.webp'); ?> 800w"
                        sizes="(max-width: 640px) 120px, 300px"
                        width="480" height="600"
                        alt="藤原圭吾（プログラミングの授業にて）"
                        fetchpriority="high" decoding="async">
                </figure>
            <?php endif; ?>
            <div class="ab-hero__body">
                <p class="ab-hero__label"><?php the_title(); ?></p>
                <h1 class="ab-hero__name">藤原圭吾<span>Keigo Fujiwara</span></h1>
                <p class="ab-hero__role">プログラミング塾「BeEngineer」梅田校責任者／個人開発</p>
                <p class="ab-hero__axes"><span>教育</span><i aria-hidden="true">×</i><span>プログラミング</span><i aria-hidden="true">×</i><span>AI</span><i aria-hidden="true">×</i><span>個人開発</span></p>
                <p class="ab-hero__bio">塾講師として小学生から浪人生まで指導し、校舎責任者も経験。現在はプログラミング塾で中高生に教えながら、情報Ⅰ教材や学習アプリ、AIを活用した業務効率化ツールを自分で開発しています。<br>「教える現場で見えた課題を、自分の手で道具にする」ことを大切にしています。</p>
                <div class="ab-hero__actions">
                    <a class="home-btn" href="<?php echo esc_url($contact_url); ?>">お仕事のご相談</a>
                    <a class="home-textlink" href="#about-portfolio">制作実績を見る</a>
                </div>
            </div>
        </header>

        <ul class="ab-facts" aria-label="数字で見る経歴">
            <?php foreach ( $about_facts as $fact ) : ?>
                <li class="ab-facts__item">
                    <span class="ab-facts__num"><b data-count="<?php echo esc_attr($fact['num']); ?>" style="--digits:<?php echo (int) strlen($fact['num']); ?>"><?php echo esc_html($fact['num']); ?></b><small><?php echo esc_html($fact['unit']); ?></small></span>
                    <span class="ab-facts__label"><?php echo esc_html($fact['label']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if ( trim((string) get_the_content()) !== '' ) : ?>
            <div class="page-body ab-content">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

        <!-- お手伝いできること -->
        <section class="ab-block" aria-labelledby="about-services-title">
            <header class="home-head">
                <h2 id="about-services-title" class="home-head__title">お手伝いできること</h2>
                <p class="home-head__note">教育の現場を知っている開発者として。</p>
            </header>
            <ol class="ab-services">
                <?php foreach ( $about_services as $service ) : ?>
                    <li class="ab-services__item">
                        <span class="ab-services__no"><?php echo esc_html($service['no']); ?></span>
                        <h3 class="ab-services__title"><?php echo esc_html($service['title']); ?></h3>
                        <p class="ab-services__text"><?php echo esc_html($service['text']); ?></p>
                        <?php if ( ! empty($service['link']) ) : ?>
                            <a class="home-head__more ab-services__link" href="<?php echo esc_url($service['link']['url']); ?>"><?php echo esc_html($service['link']['label']); ?></a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>

        <?php
        $about_portfolio_cases = [
            [
                'title'   => '2026春の入塾募集',
                'summary' => '同じ春募集でも、2月と3月以降では案内する内容が変わります。時期ごとにページを分け、その時点の募集をそのまま届けられるようにしました。',
                'role'    => '募集LPの制作',
                'links'   => [
                    ['label' => '2月募集', 'url' => 'https://lp.be-engineer.tech/pages/new_year_2026.html', 'external' => true],
                    ['label' => '3月以降募集', 'url' => 'https://lp.be-engineer.tech/pages/new_year_2026_march.html', 'external' => true],
                ],
            ],
            [
                'title'   => '2026夏の講習会',
                'summary' => '夏の講習会に興味を持った人へ、内容と参加の流れが短時間で分かる案内ページを作りました。',
                'role'    => '講習会LPの制作',
                'links'   => [
                    ['label' => '夏の講習会ページ', 'url' => 'https://lp.be-engineer.tech/pages/summer_2026.html', 'external' => true],
                ],
            ],
            [
                'title'   => '2026夏の合宿',
                'summary' => '合宿は、まず雰囲気を伝える広報ページと、申し込みにつなげる募集ページに分けました。見る目的が違う人に、別の入口を用意しています。',
                'role'    => '広報ページと募集ページの制作',
                'links'   => [
                    ['label' => '広報ページ', 'url' => 'https://keigo-fujiwara.github.io/public_beengineer_camp26_summer/', 'external' => true],
                    ['label' => '募集ページ', 'url' => 'https://beengineer-organization.github.io/been_camp_2026_LP/', 'external' => true],
                ],
            ],
            [
                'title'   => '2026冬の講習会',
                'summary' => '冬の講習会ページは、通常の案内とハロウィン仕様を同じ構成のまま切り替えられるようにしました。季節の企画に合わせて見た目だけを変えられます。',
                'role'    => '講習会LPと表示テーマの制作',
                'links'   => [
                    ['label' => '冬の講習会ページ', 'url' => 'https://beengineer-organization.github.io/winter_courses_2026_kansai/', 'external' => true],
                    ['label' => 'ハロウィン仕様', 'url' => 'https://beengineer-organization.github.io/winter_courses_2026_kansai/?theme=halloween', 'external' => true],
                ],
            ],
        ];
        $about_portfolio_groups = [
            'LP・サイト' => $about_portfolio_cases,
        ];
        if ( function_exists('mytheme_get_about_portfolio_work_cases') ) {
            foreach ( mytheme_get_about_portfolio_work_cases() as $work_case ) {
                $group_label = (string) $work_case['label'];
                if ( ! isset($about_portfolio_groups[$group_label]) ) {
                    $about_portfolio_groups[$group_label] = [];
                }
                $about_portfolio_groups[$group_label][] = $work_case;
            }
        }
        // 開発作品（投稿）に未登録の実例を追加。同名の作品が投稿で登録されたら、そちらを優先して重複表示しない。
        $about_extra_work_cases = [
            'Webアプリ・学習ツール' => [
                [
                    'match'   => 'クイズ体験版',
                    'title'   => 'BeEngineerクイズ体験版',
                    'summary' => 'プログラミング塾BeEngineer「チャットアプリ開発コース」の内容を、入会前に体験できる4択Webクイズアプリ。60問から10問を出題する確認テスト形式（制限時間5分・8割で合格）で、解説表示とカリキュラム紹介を備えています。',
                    'role'    => '学習アプリの開発',
                    'links'   => [
                        ['label' => '体験版を開く', 'url' => 'https://beengineer-organization.github.io/Ex-BeEn_Quiz/', 'external' => true],
                    ],
                ],
            ],
        ];
        foreach ( $about_extra_work_cases as $group_label => $extra_cases ) {
            if ( ! isset($about_portfolio_groups[$group_label]) ) {
                $about_portfolio_groups[$group_label] = [];
            }
            foreach ( $extra_cases as $extra_case ) {
                $already = false;
                foreach ( $about_portfolio_groups[$group_label] as $existing_case ) {
                    if ( strpos((string) $existing_case['title'], $extra_case['match']) !== false ) {
                        $already = true;
                        break;
                    }
                }
                if ( ! $already ) {
                    $about_portfolio_groups[$group_label][] = $extra_case;
                }
            }
        }

        $works_archive_url = function_exists('mytheme_get_page_url_by_path')
            ? mytheme_get_page_url_by_path('works', home_url('/works/'))
            : home_url('/works/');
        ?>
        <section class="about-section about-section--portfolio" id="about-portfolio" aria-labelledby="about-portfolio-title">
            <h2 id="about-portfolio-title" class="about-section__title">制作実績</h2>
            <div class="history-content about-portfolio">
                <p class="about-portfolio__lead">プログラミング塾 BeEngineer の募集・広報LPと、学習アプリや業務自動化などの開発作品です。ページ制作から、動くプロダクトの開発まで扱っています。</p>
                <?php foreach ( $about_portfolio_groups as $group_label => $group_cases ) : ?>
                    <section class="about-portfolio__group" aria-labelledby="about-portfolio-<?php echo esc_attr(sanitize_title($group_label)); ?>">
                        <h3 id="about-portfolio-<?php echo esc_attr(sanitize_title($group_label)); ?>" class="about-portfolio__group-title"><?php echo esc_html($group_label); ?></h3>
                        <div class="about-portfolio__grid">
                            <?php foreach ( $group_cases as $case ) : ?>
                                <article class="about-portfolio__case">
                                    <h4 class="about-portfolio__title"><?php echo esc_html($case['title']); ?></h4>
                                    <p class="about-portfolio__summary"><?php echo esc_html($case['summary']); ?></p>
                                    <p class="about-portfolio__role">担当：<?php echo esc_html($case['role']); ?></p>
                                    <ul class="about-portfolio__links">
                                        <?php foreach ( $case['links'] as $link ) : ?>
                                            <li>
                                                <a class="about-portfolio__link" href="<?php echo esc_url($link['url']); ?>"<?php echo ! empty($link['external']) ? ' target="_blank" rel="noopener noreferrer external"' : ''; ?>><?php echo esc_html($link['label']); ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
                <p class="about-portfolio__more">
                    <a class="history-content__nested-link" href="<?php echo esc_url($works_archive_url); ?>">開発作品の一覧を見る</a>
                </p>
            </div>
        </section>

        <section class="ab-block ab-career" aria-labelledby="about-career-title">
            <header class="home-head">
                <h2 id="about-career-title" class="home-head__title">経歴・活動</h2>
            </header>
        <div class="about-sections">
            <section class="about-section">
                <h2 class="about-section__title">学歴</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">明治大学　理工学部　情報科学系　卒業</li>
                        <li class="history-content__list-item">明治大学大学院　理工学研究科　基礎理工学専攻　情報科学系　修了</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">大学での実績</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">
                            レフェリー付き原著論文（英語研究論文）2本投稿
                            <ul class="nested-list">
                                <li class="nested-list__item"><a class="history-content__nested-link" href="http://yokohamapublishers.jp/online2/oplna/vol3/p189.html" target="_blank" rel="noopener noreferrer external">横浜図書オンライン（Vol.3 p.189）</a></li>
                                <li class="nested-list__item"><a class="history-content__nested-link" href="http://yokohamapublishers.jp/online2/oplna/vol4/p29.html" target="_blank" rel="noopener noreferrer external">横浜図書オンライン（Vol.4 p.29）</a></li>
                            </ul>
                        </li>
                        <li class="history-content__list-item">第九回 明治大学大学院長賞 受賞</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">社会人での経験・受賞歴</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">2020年 社長賞：新人賞 受賞</li>
                        <li class="history-content__list-item">2023年 社長賞：優秀賞 受賞</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">資格</h2>
                <div class="skills-content">
                    <ul class="skills-list">
                        <li class="skills-list__item">基本情報技術者</li>
                        <li class="skills-list__item">情報セキュリティマネジメント</li>
                        <li class="skills-list__item">ファイナンシャル・プランニング技能検定3級</li>
                        <li class="skills-list__item">ビジネス実務マナー検定3級</li>
                        <li class="skills-list__item">統計検定2級</li>
                        <li class="skills-list__item">日商簿記3級</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">教育・指導経験</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">個別指導歴：5年間（小3〜高3・浪人生まで）</li>
                        <li class="history-content__list-item">指導科目：英語・数学・理科 ほか</li>
                        <li class="history-content__list-item">集団授業歴：6年間（最大50人規模）</li>
                        <li class="history-content__list-item">プログラミング授業歴：3年間</li>
                        <li class="history-content__list-item">トップ校受験対策も担当</li>
                        <li class="history-content__list-item">オンライン授業：3年間配信経験あり</li>
                        <li class="history-content__list-item">高校生対象「情報Ⅰ」映像授業にも出演中</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">職務経験</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">個別指導塾：主任として運営参画</li>
                        <li class="history-content__list-item">集団授業塾：理系科目リーダー（数学・理科）</li>
                        <li class="history-content__list-item">校舎責任者（2年間／在籍生徒130名超の校舎を運営）</li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">現在の活動</h2>
                <div class="history-content">
                    <ul class="history-content__list">
                        <li class="history-content__list-item">プログラミング塾「BeEngineer」梅田校責任者</li>
                        <li class="history-content__list-item">中高生向けにプログラミング教育・共通テスト情報Ⅰ対策を指導</li>
                        <li class="history-content__list-item">アプリ開発、模試制作、イベント企画に取り組む</li>
                        <li class="history-content__list-item">バイブコーディング（Vibe Coding）で業務効率化ツールを開発中</li>
                        <li class="history-content__list-item">電子書籍（Kindle本）を出版（日本語版・英語版）</li>
                    </ul>
                </div>
            </section>

            <section class="about-section about-section--beengineer">
                <h2 class="about-section__title">BeEngineer通信</h2>
                <div class="history-content about-beengineer">
                    <p class="about-beengineer__lead">
                        BeEngineerでの実践や、教室として大切にしている考え方は、
                        専用の発信ページ <strong>BeEngineer通信</strong> にまとめています。
                    </p>
                    <p>
                        学習サイト本体では体系化した学びを中心に扱い、
                        こちらでは教室運営、教育方針、イベント・活動報告などを発信していきます。
                    </p>

                    <?php if ( $about_beengineer_posts->have_posts() ) : ?>
                        <ul class="about-beengineer__list">
                            <?php while ( $about_beengineer_posts->have_posts() ) : $about_beengineer_posts->the_post(); ?>
                                <li class="about-beengineer__item">
                                    <a class="about-beengineer__link" href="<?php the_permalink(); ?>">
                                        <time class="about-beengineer__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                            <?php echo esc_html(get_the_date('Y.m.d')); ?>
                                        </time>
                                        <span class="about-beengineer__title"><?php the_title(); ?></span>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <?php wp_reset_postdata(); ?>
                    <?php else : ?>
                        <p>記事は準備中です。公開後はここから最新の発信を確認できます。</p>
                    <?php endif; ?>

                    <p class="about-beengineer__action">
                        <a class="work-link" href="<?php echo esc_url($beengineer_news_url); ?>">BeEngineer通信一覧を見る</a>
                    </p>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">運営者の実績・活動（外部発信を含む）</h2>
                <div class="history-content">
                    <h3>執筆活動：電子書籍（Kindle）</h3>
                    <p>学習法・アウトプット・仕事術など「学び続ける人の課題解決」にフォーカスして執筆しています。</p>

                    <?php
                    $ebooks_url = function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('ebooks', home_url('/ebooks/'))
                        : home_url('/ebooks/');
                    $ebooks = function_exists('mytheme_get_ebooks') ? mytheme_get_ebooks() : [];
                    ?>

                    <?php if ( ! empty($ebooks) && is_array($ebooks) ) : ?>
                        <ul class="about-ebooks-grid">
                            <?php foreach ( $ebooks as $book ) : ?>
                                <?php
                                $ja = function_exists('mytheme_get_ebook_edition') ? mytheme_get_ebook_edition($book, 'ja') : null;
                                $ja_title = $ja && ! empty($ja['title']) ? (string) $ja['title'] : '';
                                $ja_desc  = $ja && ! empty($ja['description']) ? (string) $ja['description'] : '';
                                $ja_cover = $ja && ! empty($ja['cover']) ? (string) $ja['cover'] : '';
                                $ja_summary = '';
                                if ( $ja_desc !== '' ) {
                                    if ( preg_match('/^(.+?。)/u', wp_strip_all_tags($ja_desc), $ja_sentence) ) {
                                        $ja_summary = (string) $ja_sentence[1];
                                    } else {
                                        $ja_summary = function_exists('wp_html_excerpt')
                                            ? wp_html_excerpt(wp_strip_all_tags($ja_desc), 48, '…')
                                            : wp_strip_all_tags($ja_desc);
                                    }
                                }
                                ?>
                                <?php if ( $ja_title ) : ?>
                                    <li class="about-ebook-card">
                                        <?php if ( $ja_cover !== '' && function_exists('mytheme_picture_tag') ) : ?>
                                            <div class="about-ebook-card__media">
                                                <?php echo mytheme_picture_tag($ja_cover, $ja_title, 'about-ebook-card__image', 'lazy'); ?>
                                            </div>
                                        <?php endif; ?>
                                        <p class="about-ebook-card__title"><?php echo esc_html($ja_title); ?></p>
                                        <?php if ( $ja_summary !== '' ) : ?>
                                            <p class="about-ebook-card__summary"><?php echo esc_html($ja_summary); ?></p>
                                        <?php endif; ?>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                        <p class="about-ebooks-cta">
                            <a class="history-content__nested-link" href="<?php echo esc_url($ebooks_url); ?>">電子書籍一覧を見る</a>
                        </p>
                    <?php else : ?>
                        <p>電子書籍の情報は準備中です。</p>
                    <?php endif; ?>

                    <h3>外部発信：YouTube / note</h3>
                    <p>サイト内では整理した学習コラムを中心にしています。note では、同じテーマを日々の言葉で書いています。</p>
                    <ul class="history-content__list">
                        <li class="history-content__list-item">
                            <strong>YouTube</strong>：学習のアウトプット（主に英語）や、取り組みの記録を動画で発信しています。<br>
                            <a class="history-content__nested-link" href="https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw" target="_blank" rel="noopener noreferrer external">YouTubeチャンネルを見る</a>
                        </li>
                        <li class="history-content__list-item">
                            <strong>note</strong>：考えている途中や、現場で感じたことを自分の言葉で書いています。<br>
                            <a class="note-cta" href="https://note.com/k5fujiwara?utm_source=info-study&amp;utm_medium=referral&amp;utm_campaign=about" target="_blank" rel="noopener noreferrer external">note を読む</a>
                        </li>
                    </ul>

                    <h3>SNS</h3>
                    <p>更新通知や日々の学びのメモを発信しています。サイト内の学習コラムが主軸で、SNSは補助的な位置づけです。</p>
                    <ul class="history-content__list">
                        <li class="history-content__list-item"><a class="history-content__nested-link" href="https://x.com/K5_jukukoshi" target="_blank" rel="noopener noreferrer external">X（旧Twitter）</a></li>
                        <li class="history-content__list-item"><a class="history-content__nested-link" href="https://www.instagram.com/k5_jukukoshi/" target="_blank" rel="noopener noreferrer external">Instagram</a></li>
                        <li class="history-content__list-item"><a class="history-content__nested-link" href="https://www.threads.com/@k5_jukukoshi" target="_blank" rel="noopener noreferrer external">Threads</a></li>
                        <li class="history-content__list-item"><a class="history-content__nested-link" href="https://www.facebook.com/profile.php?id=100067108881612" target="_blank" rel="noopener noreferrer external">Facebook</a></li>
                    </ul>
                </div>
            </section>

            <section class="about-section">
                <h2 class="about-section__title">運営方針（記事作成・修正方針）</h2>
                <div class="history-content">
                    <p>当サイトでは、教育、AI・プログラミング、情報Ⅰ、資格・継続学習、個人開発などについて、実体験と一次情報を重視して整理しています。記事内容は公開後も定期的に見直し、内容の更新や改善を行います。</p>
                    <p>記載内容に誤りや不明点がある場合は、確認のうえ修正いたします。ご連絡は<a class="history-content__nested-link" href="<?php echo esc_url( function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('contact', home_url('/contact/')) : home_url('/contact/') ); ?>">お問い合わせページ</a>よりお願いいたします。個人情報の取り扱いは<a class="history-content__nested-link" href="<?php echo esc_url( function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('privacy-policy', home_url('/privacy-policy/')) : home_url('/privacy-policy/') ); ?>">プライバシーポリシー</a>をご確認ください。</p>
                </div>
            </section>
        </div>
        </section>

        <!-- お仕事のご相談 -->
        <section class="ab-cta" aria-labelledby="about-cta-title">
            <div class="ab-cta__body">
                <p class="ab-cta__label">お仕事のご相談</p>
                <h2 id="about-cta-title" class="ab-cta__title">教育まわりの「作りたい」を、<br>一緒に形にします。</h2>
                <p class="ab-cta__text">募集LPや案内ページの制作、学習アプリ・教材の開発、AIを使った業務効率化、授業や講座のご依頼など。まだ内容が固まっていない段階のご相談も歓迎です。</p>
            </div>
            <div class="ab-cta__actions">
                <a class="ab-cta__btn" href="<?php echo esc_url($contact_url); ?>">お問い合わせフォームへ</a>
            </div>
        </section>

        <?php
        // Person構造化データとBreadcrumbList構造化データはfunctions.phpで出力されます
        ?>
        
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>

