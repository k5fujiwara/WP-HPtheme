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
    }
}
add_action('wp_enqueue_scripts', 'mytheme_remove_block_library_css', 100);

/**
 * DNS Prefetchの追加
 */
function mytheme_add_dns_prefetch($urls, $relation_type) {
    if ('dns-prefetch' === $relation_type) {
        $urls[] = '//www.youtube.com';
        $urls[] = '//i.ytimg.com';
        // AdSense（表示速度の下支え）
        $urls[] = '//pagead2.googlesyndication.com';
        $urls[] = '//googleads.g.doubleclick.net';
        $urls[] = '//tpc.googlesyndication.com';
        $urls[] = '//www.googletagmanager.com';
        $urls[] = '//cdn.jsdelivr.net';
    }
    if ('preconnect' === $relation_type) {
        $urls[] = 'https://www.googletagmanager.com';
        $urls[] = 'https://pagead2.googlesyndication.com';
        $urls[] = 'https://ep1.adtrafficquality.google';
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
    
    // 特定のスクリプトにdefer属性を追加
    $defer_scripts = array(
        'mytheme-main-js',
        'mytheme-learning-column',
    );
    
    if (in_array($handle, $defer_scripts, true)) {
        return str_replace(' src', ' defer src', $tag);
    }

    // MathJax は本文がないページではレンダリングブロックになりやすいため defer。
    if (is_string($src) && (strpos($src, 'mathjax') !== false || strpos($src, 'tex-mml-chtml') !== false)) {
        if (strpos($tag, ' defer') === false && strpos($tag, ' async') === false) {
            return str_replace(' src', ' defer src', $tag);
        }
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'mytheme_add_defer_to_scripts', 10, 3);

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
 * ページネーションのprefetch
 */
function mytheme_prefetch_pages() {
    if (is_front_page()) {
        // トップページから主要ページへのprefetch
        $about_url = mytheme_get_page_url_by_path('about', '');
        $works_url = mytheme_get_page_url_by_path('works', '');
        
        if ($about_url !== '') {
            echo '<link rel="prefetch" href="' . esc_url($about_url) . '">' . "\n";
        }
        if ($works_url !== '') {
            echo '<link rel="prefetch" href="' . esc_url($works_url) . '">' . "\n";
        }
    }
}
add_action('wp_head', 'mytheme_prefetch_pages', 4);

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
