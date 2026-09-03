<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function mytheme_seo_default_image_url(): string {
    return 'https://info-study.com/wp-content/uploads/2026/06/og-default.png';
}

function mytheme_seo_person_id(): string {
    return home_url('/about/#person');
}

function mytheme_seo_clean_text($text, int $max_length = 155): string {
    $text = strip_shortcodes((string) $text);
    $text = wp_strip_all_tags($text, true);
    $text = html_entity_decode($text, ENT_QUOTES, get_bloginfo('charset'));
    $text = preg_replace('/\s+/u', ' ', $text);
    $text = trim((string) $text);

    if ( $text !== '' && mb_strlen($text) > $max_length ) {
        $text = rtrim(mb_substr($text, 0, $max_length - 1)) . '…';
    }
    return $text;
}

function mytheme_seo_request_url(): string {
    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '/';
    return home_url($request_uri);
}

function mytheme_seo_is_learning_filter_url(): bool {
    if ( is_post_type_archive('dictionary') && isset($_GET['dic_cat']) ) {
        return true;
    }
    if ( ! ( is_page('learning-column') || is_home() ) ) {
        return false;
    }
    return isset($_GET['theme']) || isset($_GET['cat']) || isset($_GET['cats']);
}

function mytheme_seo_get_canonical_url(): string {
    if ( is_404() ) {
        return '';
    }

    if ( is_search() || mytheme_seo_is_learning_filter_url() ) {
        return mytheme_seo_request_url();
    }

    $paged_number = max((int) get_query_var('paged'), (int) get_query_var('page'));
    if ( $paged_number > 1 ) {
        return mytheme_seo_request_url();
    }

    if ( is_front_page() ) {
        return home_url('/');
    }

    if ( is_singular() ) {
        return (string) get_permalink(get_queried_object_id());
    }

    if ( is_home() ) {
        $posts_page_id = (int) get_option('page_for_posts');
        return $posts_page_id > 0 ? (string) get_permalink($posts_page_id) : home_url('/');
    }

    if ( is_post_type_archive() ) {
        $post_type = get_query_var('post_type');
        if ( is_array($post_type) ) {
            $post_type = reset($post_type);
        }
        $archive_url = is_string($post_type) ? get_post_type_archive_link($post_type) : '';
        return $archive_url ? (string) $archive_url : mytheme_seo_request_url();
    }

    if ( is_category() || is_tag() || is_tax() ) {
        $term_link = get_term_link(get_queried_object());
        return is_wp_error($term_link) ? mytheme_seo_request_url() : (string) $term_link;
    }

    if ( is_author() ) {
        $author_id = (int) get_query_var('author');
        return $author_id > 0 ? get_author_posts_url($author_id) : mytheme_seo_request_url();
    }

    return mytheme_seo_request_url();
}

function mytheme_seo_get_title(): string {
    $site_name = get_bloginfo('name');
    if ( is_front_page() ) {
        return $site_name . ' | 教育・AI・情報Ⅰ・資格学習を整理する個人サイト';
    }
    if ( is_singular() ) {
        return get_the_title(get_queried_object_id()) . ' | ' . $site_name;
    }
    if ( is_search() ) {
        return '検索結果: ' . get_search_query(false) . ' | ' . $site_name;
    }
    if ( is_archive() ) {
        return wp_strip_all_tags(get_the_archive_title()) . ' | ' . $site_name;
    }
    return $site_name;
}

function mytheme_seo_get_description(): string {
    $site_desc = get_bloginfo('description');

    if ( is_front_page() ) {
        return '教育現場での実践、AI・プログラミング、情報Ⅰ、資格・継続学習、個人開発の記録を整理する藤原圭吾の個人Webサイトです。';
    }

    if ( is_singular() ) {
        $post_id = get_queried_object_id();
        $post_slug = get_post_field('post_name', $post_id);
        $custom_descriptions = [
            'about' => '藤原圭吾のプロフィール。教育、AI・プログラミング、情報Ⅰ、資格学習、個人開発などの実践と発信内容を紹介します。',
            'works' => '藤原圭吾が制作した学習支援、情報Ⅰ、AI活用、業務効率化などの開発作品を、目的や使い方とあわせて紹介します。',
            'ebooks' => '情報Ⅰ、プログラミング、AI活用、学習法などをテーマにした電子書籍をまとめています。',
            'science-quiz' => '中学理科の4択クイズ。学年と分野からランダムに出題します。',
        ];
        if ( isset($custom_descriptions[$post_slug]) ) {
            return mytheme_seo_clean_text($custom_descriptions[$post_slug]);
        }

        $manual_desc = get_post_meta($post_id, '_mytheme_seo_description', true);
        if ( is_string($manual_desc) && trim($manual_desc) !== '' ) {
            return mytheme_seo_clean_text($manual_desc);
        }

        $excerpt = get_the_excerpt($post_id);
        if ( is_string($excerpt) && trim($excerpt) !== '' ) {
            return mytheme_seo_clean_text($excerpt);
        }

        $content = get_post_field('post_content', $post_id);
        return mytheme_seo_clean_text(wp_trim_words(wp_strip_all_tags($content), 40, '…'));
    }

    if ( is_search() ) {
        return mytheme_seo_clean_text('サイト内検索「' . get_search_query(false) . '」の結果一覧です。');
    }

    if ( is_archive() ) {
        $archive_desc = get_the_archive_description();
        if ( is_string($archive_desc) && trim($archive_desc) !== '' ) {
            return mytheme_seo_clean_text($archive_desc);
        }
        return mytheme_seo_clean_text(wp_strip_all_tags(get_the_archive_title()) . 'の記事一覧です。');
    }

    return mytheme_seo_clean_text($site_desc);
}

function mytheme_seo_is_youtube_learning(): bool {
    return is_post_type_archive('youtube_learning')
        || is_singular('youtube_learning')
        || is_tax(['yt_topic', 'yt_channel']);
}

function mytheme_seo_get_robots_content(): string {
    $index = true;
    $follow = true;

    if ( is_404() || is_search() || is_feed() || is_attachment() || mytheme_seo_is_learning_filter_url() || is_author() || is_date() || is_tag() || mytheme_seo_is_youtube_learning() ) {
        $index = false;
    }

    $paged_number = max((int) get_query_var('paged'), (int) get_query_var('page'));
    if ( $paged_number > 1 && ! is_singular() ) {
        $index = false;
    }

    if ( is_search() || mytheme_seo_is_learning_filter_url() ) {
        $follow = false;
    }

    $prefix = ($index ? 'index' : 'noindex') . ', ' . ($follow ? 'follow' : 'nofollow');
    return $prefix . ', max-snippet:-1, max-image-preview:large, max-video-preview:-1';
}

function mytheme_seo_get_image_url($post_id = 0): string {
    $post_id = (int) $post_id;
    if ( $post_id > 0 && has_post_thumbnail($post_id) ) {
        $image = get_the_post_thumbnail_url($post_id, 'large');
        if ( $image ) {
            return (string) $image;
        }
    }
    return mytheme_seo_default_image_url();
}

/**
 * 全ページ共通のメタディスクリプションとOGPタグ
 */
function mytheme_seo_meta_tags() {
    $site_name = get_bloginfo('name');
    $post_id = is_singular() ? get_queried_object_id() : 0;
    $url = mytheme_seo_get_canonical_url();
    $title = mytheme_seo_get_title();
    $desc = mytheme_seo_get_description();
    $image = mytheme_seo_get_image_url($post_id);
    $type = is_singular(['post', 'news', 'beengineer-news']) ? 'article' : 'website';
    ?>
    <!-- SEO基本タグ -->
    <meta name="description" content="<?php echo esc_attr($desc); ?>">
    <meta name="author" content="藤原圭吾">
    <meta name="robots" content="<?php echo esc_attr(mytheme_seo_get_robots_content()); ?>">
    <?php if ( $url !== '' ) : ?>
    <link rel="canonical" href="<?php echo esc_url($url); ?>">
    <?php endif; ?>

    <!-- 言語設定 -->
    <meta name="language" content="Japanese">

    <!-- Open Graph タグ（Facebook、LinkedIn等） -->
    <meta property="og:locale" content="ja_JP">
    <meta property="og:type" content="<?php echo esc_attr($type); ?>">
    <meta property="og:title" content="<?php echo esc_attr($title); ?>">
    <meta property="og:description" content="<?php echo esc_attr($desc); ?>">
    <?php if ( $url !== '' ) : ?>
    <meta property="og:url" content="<?php echo esc_url($url); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
    <meta property="og:image" content="<?php echo esc_url($image); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo esc_attr($title); ?>">

    <!-- Twitter Card タグ -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@KoshiK5">
    <meta name="twitter:creator" content="@KoshiK5">
    <meta name="twitter:title" content="<?php echo esc_attr($title); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr($desc); ?>">
    <meta name="twitter:image" content="<?php echo esc_url($image); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr($title); ?>">

    <?php
}
add_action('wp_head', 'mytheme_seo_meta_tags', 5);

/**
 * WordPressのデフォルトcanonicalタグを削除（カスタムcanonicalと重複するため）
 */
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_robots', 1);

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
    $graph = [];
    $site_name = get_bloginfo('name');
    $site_url = home_url('/');
    $canonical = mytheme_seo_get_canonical_url();
    $description = mytheme_seo_get_description();
    $person = [
        '@type' => 'Person',
        '@id' => mytheme_seo_person_id(),
        'name' => '藤原圭吾',
        'url' => home_url('/about/'),
        'description' => '教育、AI・プログラミング、情報Ⅰ、資格学習、個人開発などの実践を発信しています。',
        'sameAs' => [
            'https://note.com/k5fujiwara',
            'https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw',
            'https://x.com/K5_jukukoshi',
            'https://www.instagram.com/k5_jukukoshi/',
            'https://www.threads.com/@k5_jukukoshi',
            'https://www.facebook.com/profile.php?id=100067108881612',
        ],
        'knowsAbout' => [
            '教育',
            'AI活用',
            'プログラミング',
            '情報Ⅰ',
            'データ分析',
            '資格学習',
        ],
    ];

    if ( is_front_page() ) {
        $graph[] = [
            '@type' => 'WebSite',
            '@id' => home_url('/#website'),
            'name' => $site_name,
            'url' => $site_url,
            'description' => $description,
            'publisher' => [
                '@id' => mytheme_seo_person_id(),
            ],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => home_url('/?s={search_term_string}'),
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
        $graph[] = $person;
    }

    if ( is_page('about') ) {
        $graph[] = [
            '@type' => 'ProfilePage',
            '@id' => get_permalink(get_queried_object_id()) . '#profile',
            'url' => get_permalink(get_queried_object_id()),
            'name' => get_the_title(get_queried_object_id()),
            'description' => $description,
            'mainEntity' => [
                '@id' => mytheme_seo_person_id(),
            ],
        ];
        $graph[] = $person;
    }

    if ( is_singular(['post', 'news', 'beengineer-news']) ) {
        $post_id = get_queried_object_id();
        $type = is_singular('post') ? 'BlogPosting' : 'Article';
        $article_data = [
            '@type' => $type,
            '@id' => get_permalink($post_id) . '#article',
            'headline' => get_the_title($post_id),
            'description' => $description,
            'url' => get_permalink($post_id),
            'datePublished' => get_the_date('c', $post_id),
            'author' => [
                '@id' => mytheme_seo_person_id(),
            ],
            'publisher' => [
                '@id' => mytheme_seo_person_id(),
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => get_permalink($post_id),
            ],
            'image' => [
                '@type' => 'ImageObject',
                'url' => mytheme_seo_get_image_url($post_id),
            ],
        ];

        if ( function_exists('mytheme_learning_column_modified_datetime') ) {
            $modified = mytheme_learning_column_modified_datetime($post_id);
            if ( $modified !== '' ) {
                $article_data['dateModified'] = $modified;
            }
        }

        $graph[] = $article_data;
        $graph[] = $person;
    }

    if ( ! is_front_page() && ! is_404() ) {
        $breadcrumb_data = mytheme_get_breadcrumb_schema_data();
        if ( ! empty($breadcrumb_data['itemListElement']) ) {
            $graph[] = $breadcrumb_data;
        }
    }

    if ( empty($graph) ) {
        return;
    }

    $data = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
add_action('wp_head', 'mytheme_structured_data', 10);

/**
 * パンくずリスト用の構造化データ
 */
function mytheme_get_breadcrumb_schema_data(): array {
    $breadcrumbs = [
        '@id' => mytheme_seo_get_canonical_url() . '#breadcrumb',
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
    } elseif ( is_singular('youtube_learning') ) {
        $youtube_learning_archive_url = get_post_type_archive_link('youtube_learning');
        if ( $youtube_learning_archive_url ) {
            $breadcrumbs['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => '学習おすすめ動画',
                'item'     => $youtube_learning_archive_url,
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
    
    return $breadcrumbs;
}

function mytheme_breadcrumb_schema() {
    $breadcrumbs = mytheme_get_breadcrumb_schema_data();
    if ( empty($breadcrumbs['itemListElement']) ) {
        return;
    }
    $data = [
        '@context' => 'https://schema.org',
    ] + $breadcrumbs;
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}

/**
 * クロール対象を絞る robots.txt
 * 物理ファイル ABSPATH/robots.txt がある環境では Web サーバーがそちらを返すため、
 * 本番では同じ内容へ差し替えるか、物理ファイルを削除して WordPress 生成に任せる。
 */
function mytheme_get_robots_txt_body(): string {
    $sitemap = home_url('/wp-sitemap.xml');
    return implode("\n", [
        'User-agent: *',
        'Disallow: /wp-admin/',
        'Allow: /wp-admin/admin-ajax.php',
        'Disallow: /wp-includes/',
        'Disallow: /wp-json/',
        'Disallow: /feed/',
        'Disallow: */feed/',
        'Disallow: */attachment/',
        'Disallow: /wp-login.php',
        'Disallow: /wp-signup.php',
        'Disallow: /trackback/',
        'Disallow: /xmlrpc.php',
        'Disallow: /?s=',
        'Disallow: /*?s=',
        'Disallow: /*?*s=',
        'Disallow: /*?*theme=',
        'Disallow: /*?*cat=',
        'Disallow: /*?*cats=',
        'Disallow: /*?*dic_cat=',
        'Disallow: /wp-content/themes/*/data/',
        '',
        '# サイトマップ（WordPress標準）',
        'Sitemap: ' . esc_url_raw($sitemap),
        '',
    ]);
}

function mytheme_custom_robots_txt($output, $public) {
    if ( ! $public ) {
        return $output;
    }
    return mytheme_get_robots_txt_body();
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
 * WordPress標準サイトマップの投稿タイプを整理
 */
function mytheme_filter_sitemap_post_types($post_types) {
    if ( isset($post_types['attachment']) ) {
        unset($post_types['attachment']);
    }
    if ( isset($post_types['youtube_learning']) ) {
        unset($post_types['youtube_learning']);
    }

    foreach ( ['dictionary', 'news', 'beengineer-news', 'work'] as $post_type ) {
        $object = get_post_type_object($post_type);
        if ( $object && ! empty($object->public) && ! empty($object->publicly_queryable) ) {
            $post_types[$post_type] = $object;
        }
    }

    return $post_types;
}
add_filter('wp_sitemaps_post_types', 'mytheme_filter_sitemap_post_types');

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

/**
 * タグアーカイブはサイトマップから外す（検出済み未登録の主因になりやすい）
 */
function mytheme_filter_sitemap_taxonomies($taxonomies) {
    unset($taxonomies['post_tag'], $taxonomies['yt_topic'], $taxonomies['yt_channel']);
    return $taxonomies;
}
add_filter('wp_sitemaps_taxonomies', 'mytheme_filter_sitemap_taxonomies');

/**
 * 著者・日付・タグ・添付ファイルは学習コラムへ集約
 */
function mytheme_redirect_thin_archives() {
    if ( is_admin() || wp_doing_ajax() || ( defined('REST_REQUEST') && REST_REQUEST ) ) {
        return;
    }

    $learning_url = function_exists('mytheme_get_page_url_by_path')
        ? mytheme_get_page_url_by_path('learning-column', home_url('/learning-column/'))
        : home_url('/learning-column/');

    if ( is_author() || is_date() || is_tag() ) {
        wp_safe_redirect($learning_url, 301);
        exit;
    }

    if ( is_attachment() ) {
        $parent_id = (int) wp_get_post_parent_id(get_queried_object_id());
        $target = $parent_id > 0 ? get_permalink($parent_id) : $learning_url;
        wp_safe_redirect($target, 301);
        exit;
    }
}
add_action('template_redirect', 'mytheme_redirect_thin_archives', 1);
