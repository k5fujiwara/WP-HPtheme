<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 全ページ共通のメタディスクリプションとOGPタグ
 */
function mytheme_seo_meta_tags() {
    // 現在のページ情報を取得
    $url = get_permalink();
    $site_name = get_bloginfo('name');
    $site_desc = get_bloginfo('description');
    
    // ページタイプに応じてタイトルと説明文を設定
    if ( is_front_page() ) {
        $title = $site_name . ' - 教育・自己啓発・プログラミング学習支援プラットフォーム';
        $desc = '教育・自己啓発・プログラミング学習を支援。Python開発、機械学習、資格取得の実践的なノウハウを共有。学び続ける人を応援する情報プラットフォームです。';
        $type = 'website';
    } elseif ( is_singular() ) {
        $post_id = get_queried_object_id();
        $post_slug = get_post_field('post_name', $post_id);
        
        // カスタムタイトルの設定（階層構造対応）
        $custom_titles = array(
            'about' => '自己紹介 - Python・機械学習エンジニア藤原圭吾',
            'works' => '開発作品 - Python機械学習プロジェクト一覧',
            'loto6' => 'ロト6予測ツール - Python機械学習開発事例',
            'auto-typing' => 'e-typing自動タイピング - Python自動化ツール開発',
            'quest4' => 'Quest4 - LINE学習クイズBot | Google Apps Script開発事例',
            'beengineer-camp' => 'BeEngineer合宿案内サイト - レスポンシブWebサイト開発事例'
        );
        
        if ( isset($custom_titles[$post_slug]) ) {
            $title = $custom_titles[$post_slug] . ' | ' . $site_name;
        } else {
            $title = get_the_title($post_id) . ' | ' . $site_name;
        }
        
        // ページスラッグに応じて最適化されたメタディスクリプションを設定（階層構造対応）
        $custom_descriptions = array(
            'about' => '藤原圭吾のプロフィール。Python・機械学習・データ分析のスキルと経歴を紹介。教育・自己啓発分野での学習経験と資格取得の軌跡をご覧ください。',
            'works' => 'Python開発プロジェクト一覧。ロト6予測ツール、自動タイピングシステムなど、機械学習とデータ分析を活用した実践的な開発作品を紹介します。',
            'loto6' => 'Pythonと機械学習でロト6当選番号を予測。LightGBM・XGBoost・ニューラルネットワークを使用したAI予測システムの開発事例を詳しく解説。',
            'auto-typing' => 'Pythonで構築した自動タイピングシステム。文字認識とGUIを組み合わせた実用的なツールの開発過程と技術スタックを紹介します。',
            'quest4' => 'Google Apps ScriptとLINE Messaging APIで開発した対話型学習支援システム。4科目24カテゴリ、Flex MessageによるモダンなUI設計で実用的な学習Botを実現。',
            'beengineer-camp' => 'BeEngineerプログラミング合宿の案内用Webサイト。HTML5、CSS3、Vanilla JavaScriptを使用した静的サイトで、レスポンシブデザインに完全対応。フレームワーク不使用の軽量設計が特徴。'
        );
        
        // カスタムディスクリプションがあれば使用、なければデフォルト処理
        if ( isset($custom_descriptions[$post_slug]) ) {
            $desc = $custom_descriptions[$post_slug];
        } else {
            $desc = wp_strip_all_tags( get_the_excerpt($post_id), true );
            if ( ! $desc ) {
                $content = get_post_field('post_content', $post_id);
                $desc = wp_trim_words( wp_strip_all_tags($content), 30, '...' );
            }
        }
        $type = is_page() ? 'website' : 'article';
    } elseif ( is_archive() ) {
        $title = get_the_archive_title() . ' | ' . $site_name;
        $desc = get_the_archive_description() ?: $site_desc;
        $type = 'website';
    } else {
        $title = $site_name;
        $desc = $site_desc;
        $type = 'website';
    }
    
    // メタディスクリプションを155文字以内に調整
    if ( mb_strlen($desc) > 155 ) {
        $desc = mb_substr($desc, 0, 152) . '...';
    }
    
    // アイキャッチ画像の取得（デフォルトOGP画像のフォールバック付き）
    $image = '';
    if ( is_singular() && has_post_thumbnail() ) {
        $image = get_the_post_thumbnail_url(null, 'large');
    }
    
    // アイキャッチ画像がない場合はデフォルトOGP画像を使用
    if ( ! $image ) {
        $image = 'https://info-study.com/wp-content/uploads/2025/10/og-default.png';
    }
    
    // キーワードの設定
    $keywords = '';
    if ( is_front_page() ) {
        $keywords = '教育,自己啓発,プログラミング学習,Python,機械学習,データ分析,資格取得,学習支援';
    } elseif ( is_singular() && isset($post_slug) ) {
        $custom_keywords = array(
            'about' => 'Python,機械学習,データ分析,プログラミング,自己紹介,経歴,スキル',
            'works' => 'Python開発,機械学習プロジェクト,ロト6予測,自動化ツール,開発事例',
            'loto6' => 'ロト6予測,Python,機械学習,LightGBM,XGBoost,ニューラルネットワーク,AI',
            'auto-typing' => 'Python,自動タイピング,GUI,自動化,文字認識,開発ツール',
            'quest4' => 'LINE Bot,Google Apps Script,学習支援,Flex Message,LINE Messaging API,JavaScript,教育,クイズBot,Quest4',
            'beengineer-camp' => 'HTML5,CSS3,JavaScript,レスポンシブデザイン,静的サイト,Vanilla JavaScript,Webサイト開発,フレームワーク不使用,合宿案内'
        );
        $keywords = isset($custom_keywords[$post_slug]) ? $custom_keywords[$post_slug] : '';
    }
    
    // Robotsメタタグの設定（404、検索結果、フィード、添付ファイル、2ページ目以降はnoindex）
    $robots_content = 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1';
    if ( is_404() || is_search() || is_feed() || is_attachment() || (is_paged() && get_query_var('paged') > 1) ) {
        $robots_content = 'noindex, follow';
    }
    
    // タグ、日付アーカイブ、著者アーカイブはnoindex（カテゴリはindexを許可）
    if ( is_tag() || is_date() || is_author() ) {
        $robots_content = 'noindex, follow';
    }
    ?>
    <!-- SEO基本タグ -->
    <meta name="description" content="<?php echo esc_attr($desc); ?>">
    <?php if ($keywords): ?>
    <meta name="keywords" content="<?php echo esc_attr($keywords); ?>">
    <?php endif; ?>
    <meta name="author" content="藤原圭吾">
    <meta name="robots" content="<?php echo esc_attr($robots_content); ?>">
    <link rel="canonical" href="<?php echo esc_url($url); ?>">
    
    <!-- 言語設定 -->
    <meta name="language" content="Japanese">
    
    <!-- Open Graph タグ（Facebook、LinkedIn等） -->
    <meta property="og:locale" content="ja_JP">
    <meta property="og:type" content="<?php echo esc_attr($type); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($desc); ?>">
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <?php if ($image): ?>
    <meta property="og:image" content="<?php echo esc_url($image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr($title); ?>">
    <?php endif; ?>
    
    <!-- Twitter Card タグ -->
    <meta name="twitter:card" content="<?php echo $image ? 'summary_large_image' : 'summary'; ?>">
    <meta name="twitter:site" content="@KoshiK5">
    <meta name="twitter:creator" content="@KoshiK5">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($desc); ?>">
    <?php if ($image): ?>
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr($title); ?>">
    <?php endif; ?>
    
    <?php
}
add_action('wp_head', 'mytheme_seo_meta_tags', 5);

/**
 * WordPressのデフォルトcanonicalタグを削除（カスタムcanonicalと重複するため）
 */
remove_action('wp_head', 'rel_canonical');

/**
 * 添付ファイルページを親ページにリダイレクト（重複コンテンツ防止）
 */
function mytheme_redirect_attachment_pages() {
    if ( is_attachment() ) {
        global $post;
        if ( $post && $post->post_parent ) {
            // 親ページが存在する場合、親ページにリダイレクト
            wp_redirect( get_permalink( $post->post_parent ), 301 );
            exit;
        } else {
            // 親ページがない場合、ホームページにリダイレクト
            wp_redirect( home_url('/'), 301 );
            exit;
        }
    }
}
add_action('template_redirect', 'mytheme_redirect_attachment_pages');

/**
 * 構造化データ（JSON-LD）の追加
 */
function mytheme_structured_data() {
    $site_name = get_bloginfo('name');
    $site_url = home_url('/');
    $logo_url = get_site_icon_url();
    
    // 基本的な組織情報
    $structured_data = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => $site_name,
        'url' => $site_url,
        'description' => get_bloginfo('description'),
        'sameAs' => [
            'https://note.com/k5fujiwara',
            'https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw',
            'https://x.com/K5_jukukoshi',
            'https://www.instagram.com/k5_jukukoshi/',
            'https://www.threads.com/@k5_jukukoshi',
            'https://www.facebook.com/profile.php?id=100067108881612'
        ]
    ];
    
    if ($logo_url) {
        $structured_data['logo'] = [
            '@type' => 'ImageObject',
            'url' => $logo_url
        ];
    }
    
    // 記事ページの場合は Article を追加
    if ( is_singular('post') ) {
        $post_id = get_queried_object_id();
        $article_data = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title($post_id),
            'datePublished' => get_the_date('c', $post_id),
            'dateModified' => get_the_modified_date('c', $post_id),
            'author' => [
                '@type' => 'Person',
                'name' => get_the_author_meta('display_name', get_post_field('post_author', $post_id))
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $site_name,
                'url' => $site_url
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => get_permalink($post_id)
            ]
        ];
        
        if (has_post_thumbnail($post_id)) {
            $article_data['image'] = [
                '@type' => 'ImageObject',
                'url' => get_the_post_thumbnail_url($post_id, 'large')
            ];
        }
        
        $content = get_post_field('post_content', $post_id);
        $article_data['articleBody'] = wp_strip_all_tags($content);
        
        echo '<script type="application/ld+json">' . wp_json_encode($article_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // パンくずリスト構造化データ
    if ( ! is_front_page() ) {
        mytheme_breadcrumb_schema();
    }
    
    // FAQスキーマ（トップページ用）
    if ( is_front_page() ) {
        $faq_data = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => [
                [
                    '@type' => 'Question',
                    'name' => 'このサイトはどのような情報を提供していますか？',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => '教育・自己啓発・プログラミング学習に関する情報を提供しています。Python開発、機械学習、データ分析の実践的なノウハウや、資格取得の経験を共有し、学び続ける方を支援します。'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => 'どのようなプロジェクトを紹介していますか？',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'ロト6予測ツール（機械学習を使用したAI予測システム）、自動タイピングシステム、データ分析ツールなど、Pythonを活用した実践的な開発プロジェクトを紹介しています。'
                    ]
                ],
                [
                    '@type' => 'Question',
                    'name' => '学習方法について知ることができますか？',
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => 'はい。実際の学習経験や資格取得の過程、効果的な学習方法について情報を共有しています。プログラミング学習から資格試験対策まで、実践的なアドバイスを提供します。'
                    ]
                ]
            ]
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($faq_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // 著者情報のPersonスキーマ（自己紹介ページ用）
    if ( is_page('about') ) {
        $person_data = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => '藤原圭吾',
            'url' => get_permalink(),
            'jobTitle' => 'プログラミング教育・情報I指導',
            'description' => 'Python、機械学習、データ分析を専門とするエンジニア。教育・自己啓発分野での学習経験と開発プロジェクトを共有。',
            'alumniOf' => [
                [
                    '@type' => 'CollegeOrUniversity',
                    'name' => '明治大学 理工学部 情報科学系'
                ],
                [
                    '@type' => 'CollegeOrUniversity',
                    'name' => '明治大学大学院 理工学研究科 基礎理工学専攻 情報科学系'
                ]
            ],
            'award' => [
                '第九回 明治大学大学院長賞 受賞',
                '2020年 社長賞：新人賞 受賞',
                '2023年 社長賞：優秀賞 受賞'
            ],
            'hasCredential' => [
                '基本情報技術者',
                '情報セキュリティマネジメント',
                'ファイナンシャル・プランニング技能検定3級',
                'ビジネス実務マナー検定3級',
                '統計検定3級',
                '日商簿記3級'
            ],
            'worksFor' => [
                [
                    '@type' => 'Organization',
                    'name' => 'BeEngineer 梅田校'
                ]
            ],
            'knowsAbout' => [
                'Python',
                '機械学習',
                'データ分析',
                'プログラミング教育'
            ],
            'sameAs' => [
                'https://note.com/k5fujiwara',
                'https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw',
                'https://x.com/K5_jukukoshi',
                'https://www.instagram.com/k5_jukukoshi/',
                'https://www.threads.com/@k5_jukukoshi',
                'https://www.facebook.com/profile.php?id=100067108881612'
            ]
        ];
        echo '<script type="application/ld+json">' . wp_json_encode($person_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
    }
    
    // 基本情報の出力
    echo '<script type="application/ld+json">' . wp_json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'mytheme_structured_data', 10);

/**
 * パンくずリスト用の構造化データ
 */
function mytheme_breadcrumb_schema() {
    $breadcrumbs = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => []
    ];
    
    // ホーム
    $breadcrumbs['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'ホーム',
        'item' => home_url('/')
    ];
    
    $position = 2;
    
    if ( is_singular('post') ) {
        // 投稿は「学習コラム（投稿一覧）」を親として扱う
        $learning_page = mytheme_get_page_by_path_cached('learning-column');
        if ( ! $learning_page ) {
            $pfp = (int) get_option('page_for_posts');
            if ( $pfp ) $learning_page = get_post($pfp);
        }
        if ( $learning_page ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => get_the_title($learning_page->ID),
                'item'     => get_permalink($learning_page->ID),
            ];
            $position++;
        }

        $post_id = get_queried_object_id();
        $breadcrumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title($post_id),
            'item'     => get_permalink($post_id),
        ];
    } elseif ( is_singular('news') ) {
        $news_archive_url = get_post_type_archive_link('news');
        if ( $news_archive_url ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => 'お知らせ',
                'item'     => $news_archive_url,
            ];
            $position++;
        }

        $post_id = get_queried_object_id();
        $breadcrumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title($post_id),
            'item'     => get_permalink($post_id),
        ];
    } elseif ( is_singular('beengineer-news') ) {
        $beengineer_news_archive_url = get_post_type_archive_link('beengineer-news');
        if ( $beengineer_news_archive_url ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => 'BeEngineer通信',
                'item'     => $beengineer_news_archive_url,
            ];
            $position++;
        }

        $post_id = get_queried_object_id();
        $breadcrumbs['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title($post_id),
            'item'     => get_permalink($post_id),
        ];
    } elseif ( is_singular() ) {
        $post_id = get_queried_object_id();
        $breadcrumbs['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_title($post_id),
            'item' => get_permalink($post_id)
        ];
    } elseif ( is_archive() ) {
        $archive_url = '';
        if ( is_post_type_archive() ) {
            $post_type = get_query_var('post_type');
            if ( is_array($post_type) ) {
                $post_type = reset($post_type);
            }
            if ( is_string($post_type) && $post_type !== '' ) {
                $archive_url = get_post_type_archive_link($post_type);
            }
        } elseif ( function_exists('get_term_link') && ( is_tag() || is_category() || is_tax() ) ) {
            $archive_url = get_term_link(get_queried_object());
            $archive_url = is_wp_error($archive_url) ? '' : (string) $archive_url;
        }

        $breadcrumbs['itemListElement'][] = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => get_the_archive_title(),
            'item' => $archive_url !== '' ? $archive_url : home_url('/')
        ];
    }
    
    echo '<script type="application/ld+json">' . wp_json_encode($breadcrumbs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}

/**
 * robots.txt の最適化
 * 注意: 物理ファイル /public/robots.txt が存在する場合、そちらが優先されます
 * このフィルターは物理ファイルが存在しない場合のフォールバックです
 */
function mytheme_custom_robots_txt($output, $public) {
    // 物理ファイルが存在する場合は何もしない
    $robots_file = ABSPATH . 'robots.txt';
    if (file_exists($robots_file)) {
        // 物理ファイルの内容を読み込んで返す
        return file_get_contents($robots_file);
    }
    
    // 物理ファイルがない場合は仮想robots.txtを生成
    if ($public) {
        $wp_sitemap_url = home_url('/wp-sitemap.xml');
        $output = "User-agent: *\n";
        $output .= "Disallow: /wp-admin/\n";
        $output .= "Allow: /wp-admin/admin-ajax.php\n";
        $output .= "Disallow: /wp-includes/\n";
        $output .= "Allow: /wp-content/uploads/\n";
        $output .= "Disallow: /feed/\n";
        $output .= "Disallow: */feed/\n";
        $output .= "Disallow: */attachment/\n";
        $output .= "\n";
        $output .= "# サイトマップ（WordPress標準）\n";
        $output .= "Sitemap: " . esc_url($wp_sitemap_url) . "\n";
    }
    return $output;
}
add_filter('robots_txt', 'mytheme_custom_robots_txt', 10, 2);

/**
 * WordPressサイトマップ機能を確実に有効化（WordPress 5.5以降）
 */
function mytheme_enable_xml_sitemap() {
    // サイトマップ機能が無効になっている場合は有効化
    add_filter('wp_sitemaps_enabled', '__return_true');
}
add_action('init', 'mytheme_enable_xml_sitemap');

/**
 * WordPress標準サイトマップから添付ファイルを除外
 */
function mytheme_exclude_attachment_post_type_from_sitemap($post_types) {
    if ( isset($post_types['attachment']) ) {
        unset($post_types['attachment']);
    }
    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'mytheme_exclude_attachment_post_type_from_sitemap');

/**
 * users サイトマップ provider を無効化
 * - query args で false を返すのではなく、provider自体を外す方が安全
 */
function mytheme_disable_users_sitemap_provider($provider, $name) {
    if ( $name === 'users' ) {
        return false;
    }
    return $provider;
}
add_filter('wp_sitemaps_add_provider', 'mytheme_disable_users_sitemap_provider', 10, 2);
