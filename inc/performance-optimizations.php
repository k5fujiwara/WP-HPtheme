<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 不要なWordPress機能を無効化
 */
function mytheme_remove_unnecessary_features() {
    // 絵文字関連のスクリプトを削除
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    
    // WP Embed スクリプトを削除
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
    
    // REST APIリンクを削除（使用しない場合）
    remove_action('wp_head', 'rest_output_link_wp_head');
    
    // Windows Live Writer マニフェストを削除
    remove_action('wp_head', 'wlwmanifest_link');
    
    // 短縮URLを削除
    remove_action('wp_head', 'wp_shortlink_wp_head');
    
    // RSDリンクを削除
    remove_action('wp_head', 'rsd_link');
    
    // WordPressバージョン情報を削除
    remove_action('wp_head', 'wp_generator');
}
add_action('init', 'mytheme_remove_unnecessary_features');

/**
 * Gutenberg ブロックライブラリのCSSを無効化（使用しない場合）
 */
function mytheme_remove_block_library_css() {
    if (!is_admin()) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style'); // WooCommerceを使用していない場合
        wp_dequeue_style('global-styles'); // グローバルスタイルを削除
        wp_dequeue_style('classic-theme-styles');
        wp_dequeue_style('core-block-supports');
        wp_dequeue_style('wp-webfonts');
        if ( ! is_user_logged_in() ) {
            wp_dequeue_style('dashicons');
        }
    }
}
add_action('wp_enqueue_scripts', 'mytheme_remove_block_library_css', 100);

/**
 * フロントでは jquery-migrate を外し、メインの jQuery だけにする。
 */
function mytheme_remove_jquery_migrate($scripts) {
    if ( is_admin() || ! isset($scripts->registered['jquery']) ) {
        return;
    }

    $script = $scripts->registered['jquery'];
    if ( $script instanceof _WP_Dependency && ! empty($script->deps) ) {
        $script->deps = array_values(array_diff($script->deps, ['jquery-migrate']));
    }
}
add_action('wp_default_scripts', 'mytheme_remove_jquery_migrate');

/**
 * DNS Prefetchの追加
 */
function mytheme_add_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' !== $relation_type) {
        return $urls;
    }

    $needs_youtube = is_singular('youtube_learning')
        || is_post_type_archive('youtube_learning')
        || is_singular('work')
        || is_page(['works', 'loto6', 'auto-typing', 'quest4']);

    if ( $needs_youtube ) {
        $urls[] = '//www.youtube.com';
        $urls[] = '//i.ytimg.com';
    }

    return $urls;
}
add_filter('wp_resource_hints', 'mytheme_add_dns_prefetch', 10, 2);

/**
 * JavaScriptにdefer属性を追加
 */
function mytheme_add_defer_to_scripts($tag, $handle, $src) {
    // 管理画面では適用しない
    if (is_admin()) {
        return $tag;
    }

    if ( strpos($tag, ' defer') !== false || strpos($tag, ' async') !== false ) {
        return $tag;
    }

    $should_defer = (strpos((string) $handle, 'mytheme-') === 0);

    // MathJax は本文がないページではレンダリングブロックになりやすいため defer。
    if ( ! $should_defer && is_string($src) && (strpos($src, 'mathjax') !== false || strpos($src, 'tex-mml-chtml') !== false) ) {
        $should_defer = true;
    }

    if ( $should_defer ) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}
add_filter('script_loader_tag', 'mytheme_add_defer_to_scripts', 10, 3);

/**
 * トップページ用の投稿IDクエリを短時間キャッシュして TTFB を下げる。
 */
function mytheme_get_cached_id_query(string $cache_key, array $args, int $ttl = 900): WP_Query {
    $cached_ids = get_transient($cache_key);
    if ( is_array($cached_ids) ) {
        if ( $cached_ids === [] ) {
            return new WP_Query([
                'post_type'      => $args['post_type'] ?? 'post',
                'post__in'       => [0],
                'posts_per_page' => 1,
                'no_found_rows'  => true,
            ]);
        }

        return new WP_Query([
            'post_type'              => $args['post_type'] ?? 'post',
            'post_status'            => 'publish',
            'post__in'               => $cached_ids,
            'orderby'                => 'post__in',
            'posts_per_page'         => count($cached_ids),
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_meta_cache' => ! empty($args['update_post_meta_cache']),
            'update_post_term_cache' => ! empty($args['update_post_term_cache']),
        ]);
    }

    $query = new WP_Query(array_merge([
        'post_status'         => 'publish',
        'no_found_rows'       => true,
        'ignore_sticky_posts' => true,
    ], $args));

    $ids = [];
    if ( ! empty($query->posts) ) {
        foreach ( $query->posts as $post ) {
            $ids[] = (int) ( is_object($post) ? $post->ID : $post );
        }
    }

    set_transient($cache_key, $ids, $ttl);
    return $query;
}

function mytheme_flush_front_query_cache($post_id = 0): void {
    $post_id = (int) $post_id;
    if ( $post_id > 0 && wp_is_post_revision($post_id) ) {
        return;
    }

    if ( $post_id > 0 ) {
        $type = get_post_type($post_id);
        if ( $type && ! in_array($type, ['post', 'news', 'beengineer-news', 'work'], true) ) {
            return;
        }
    }

    delete_transient('mytheme_front_latest_posts');
    delete_transient('mytheme_front_latest_news');
    delete_transient('mytheme_front_latest_beengineer_news');
    for ( $i = 1; $i <= 6; $i++ ) {
        delete_transient('mytheme_front_featured_work_ids_' . $i);
    }
}
add_action('save_post', 'mytheme_flush_front_query_cache');
add_action('deleted_post', 'mytheme_flush_front_query_cache');
add_action('trashed_post', 'mytheme_flush_front_query_cache');

/**
 * お問い合わせページ以外では Contact Form 7 のアセットを読み込まない
 */
function mytheme_optimize_contact_form_assets() {
    if (is_admin()) {
        return;
    }

    // Contact Form 7を使うページは除外（固定ページ + ショートコード/ブロック）
    if (is_page(['contact', 'お問い合わせ'])) {
        return;
    }
    if (is_singular()) {
        $post = get_post();
        if ($post instanceof WP_Post) {
            $content = (string) $post->post_content;
            $has_cf7_shortcode = has_shortcode($content, 'contact-form-7');
            $has_cf7_block = has_block('contact-form-7/contact-form-selector', $post);
            if ($has_cf7_shortcode || $has_cf7_block) {
                return;
            }
        }
    }

    wp_dequeue_style('contact-form-7');
    wp_dequeue_script('contact-form-7');
    wp_dequeue_script('google-recaptcha');
    wp_dequeue_script('wpcf7-recaptcha');
}
add_action('wp_enqueue_scripts', 'mytheme_optimize_contact_form_assets', 99);

/**
 * MathJaxは数式を含む単一ページだけで読み込む。
 */
function mytheme_content_needs_mathjax(): bool {
    if ( ! is_singular() ) {
        return false;
    }

    $post = get_post();
    if ( ! $post instanceof WP_Post ) {
        return false;
    }

    $content = (string) $post->post_content;
    return (bool) preg_match('/(\[latex\]|\[mathjax\]|\\\\\(|\\\\\[|\$\$|<math\b|class=["\'][^"\']*(math|latex)[^"\']*["\'])/i', $content);
}

function mytheme_dequeue_mathjax_when_unused() {
    if ( is_admin() || mytheme_content_needs_mathjax() ) {
        return;
    }

    wp_dequeue_script('mathjax');
    wp_deregister_script('mathjax');
}
add_action('wp_enqueue_scripts', 'mytheme_dequeue_mathjax_when_unused', 101);
add_action('wp_print_scripts', 'mytheme_dequeue_mathjax_when_unused', 1);

function mytheme_block_mathjax_plugin_when_unused() {
    if ( is_admin() || mytheme_content_needs_mathjax() || ! class_exists('MathJax_Latex') ) {
        return;
    }

    MathJax_Latex::$add_script = false;
    MathJax_Latex::$block_script = true;
}
add_action('wp_footer', 'mytheme_block_mathjax_plugin_when_unused', 0);

/**
 * リソースヒントの最適化
 */
function mytheme_optimize_resource_hints() {
    // YouTube動画埋め込みがある場合のみpreconnect（階層構造対応）
    if (is_singular()) {
        $post = get_post();
        $slug = $post ? $post->post_name : '';
        if (in_array($slug, array('loto6', 'auto-typing', 'quest4'))) {
            echo '<link rel="preconnect" href="https://www.youtube.com" crossorigin>' . "\n";
            echo '<link rel="preconnect" href="https://i.ytimg.com" crossorigin>' . "\n";
        }
    }
}
add_action('wp_head', 'mytheme_optimize_resource_hints', 3);

/**
 * HTTPヘッダーでキャッシュ制御（WordPress標準機能の補助）
 */
function mytheme_add_cache_headers() {
    if ( is_admin() || is_user_logged_in() ) return;

    // AJAX/REST は絶対にキャッシュしない（nonce/セッション周りの不整合防止）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) {
        nocache_headers();
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        return;
    }
    if ( defined('REST_REQUEST') && REST_REQUEST ) {
        nocache_headers();
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        return;
    }

    // Contact Form 7 は REST の nonce を使うため、
    // お問い合わせページがページキャッシュされると「送信失敗（403/nonce切れ）」になりやすい。
    if ( is_page(['contact', 'お問い合わせ']) ) {
        if ( ! defined('DONOTCACHEPAGE') ) define('DONOTCACHEPAGE', true);
        if ( ! defined('DONOTCACHEOBJECT') ) define('DONOTCACHEOBJECT', true);
        if ( ! defined('DONOTCACHEDB') ) define('DONOTCACHEDB', true);
        nocache_headers();
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        return;
    }
    // 通常ページのキャッシュ制御はサーバー/CDN/キャッシュプラグインに任せる。
    // テーマで一律に public を付けると、フォーム等の動的機能と衝突することがあるため付与しない。
}
add_action('send_headers', 'mytheme_add_cache_headers');
