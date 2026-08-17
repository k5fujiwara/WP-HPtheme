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
    <article class="page-content about-page">
        <?php mytheme_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header>

        <div class="page-body">
            <?php the_content(); ?>
        </div>

        <section class="about-profile-summary" aria-labelledby="about-profile-overview-title">
            <p class="about-profile-summary__eyebrow">Profile Overview</p>
            <h2 id="about-profile-overview-title" class="about-profile-summary__name">藤原圭吾</h2>
            <p class="about-profile-summary__tagline">教育 × プログラミング × AI × 個人開発</p>
            <p>
                教育現場での指導・教室運営と並行して、情報Ⅰ教材、学習アプリ、AIを活用した業務効率化ツールなどを制作しています。学び続けながら得た知識や経験を、このサイトに整理しています。
            </p>
            <div class="about-overview-grid" aria-label="活動領域の概要">
                <div class="about-overview-card">
                    <h3 class="about-overview-card__title">教育</h3>
                    <p>指導・教室運営・情報Ⅰ・プログラミング教育を実践しています。</p>
                </div>
                <div class="about-overview-card">
                    <h3 class="about-overview-card__title">開発</h3>
                    <p>学習アプリ、Web、AI自動化など、使える形の制作に取り組んでいます。</p>
                </div>
                <div class="about-overview-card">
                    <h3 class="about-overview-card__title">研究</h3>
                    <p>情報科学と大学院での研究経験を、学びの整理に活かしています。</p>
                </div>
                <div class="about-overview-card">
                    <h3 class="about-overview-card__title">学習</h3>
                    <p>資格・統計・継続学習を通して、実践知を更新し続けています。</p>
                </div>
            </div>
        </section>

        <div class="about-sections">
            <section class="about-section">
                <h2 class="about-section__title">名前</h2>
                <div class="profile-content">
                    <p>藤原圭吾</p>
                </div>
            </section>

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
                        <li class="history-content__list-item">個別指導歴：6年間（小3〜高3・浪人生まで）</li>
                        <li class="history-content__list-item">指導科目：英語・数学・理科 ほか</li>
                        <li class="history-content__list-item">集団授業歴：6年間（最大50人規模）</li>
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
                        <li class="history-content__list-item">校舎責任者（2年間／100名以上の生徒を担当）</li>
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
                    <p>サイト内では「体系化した学習コラム」を中心に、外部では用途に合わせて補足的に発信しています。必要な方が参照できるよう、ここにまとめています。</p>
                    <ul class="history-content__list">
                        <li class="history-content__list-item">
                            <strong>YouTube</strong>：学習のアウトプット（主に英語）や、取り組みの記録を動画で発信しています。<br>
                            <a class="history-content__nested-link" href="https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw" target="_blank" rel="noopener noreferrer external">YouTubeチャンネルを見る</a>
                        </li>
                        <li class="history-content__list-item">
                            <strong>note</strong>：日々の学びや実践記録を発信しています。<br>
                            <a class="history-content__nested-link" href="https://note.com/k5fujiwara" target="_blank" rel="noopener noreferrer external">noteを見る</a>
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

        <?php
        // Person構造化データとBreadcrumbList構造化データはfunctions.phpで出力されます
        ?>
        
    </article>
<?php endwhile; ?>

<?php get_footer(); ?>

