<?php
// セキュリティ: 直アクセス防止
if ( ! defined( 'ABSPATH' ) ) exit;

function mytheme_setup() {
    // <title>をWPに任せる
    add_theme_support('title-tag');
    // アイキャッチ
    add_theme_support('post-thumbnails');
    // メニュー登録
    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
}
add_action('after_setup_theme', 'mytheme_setup');

/**
 * 固定ページURLをスラッグから取得（1リクエスト内キャッシュ）
 */
function mytheme_get_page_url_by_path($path, $fallback = '') {
    static $cache = [];
    $path = trim((string) $path, '/');
    if ( $path === '' ) return (string) $fallback;

    $key = $path . '|' . (string) $fallback;
    if ( isset($cache[$key]) ) {
        return $cache[$key];
    }

    $url = '';
    $page = mytheme_get_page_by_path_cached($path);
    if ( $page && get_post_status($page->ID) === 'publish' ) {
        $url = (string) get_permalink($page->ID);
    }
    if ( $url === '' ) {
        $url = $fallback !== '' ? (string) $fallback : home_url('/' . $path . '/');
    }

    $cache[$key] = $url;
    return $url;
}

/**
 * 固定ページ取得を1リクエスト内でキャッシュ
 */
function mytheme_get_page_by_path_cached($path, $output = OBJECT, $post_type = 'page') {
    static $cache = [];
    $key = md5((string) $path . '|' . (string) $output . '|' . (is_array($post_type) ? implode(',', $post_type) : (string) $post_type));
    if ( array_key_exists($key, $cache) ) {
        return $cache[$key];
    }
    $cache[$key] = get_page_by_path($path, $output, $post_type);
    return $cache[$key];
}

// ===== Theme modules =====
// 役割ごとに `inc/` 配下へ分割。詳細は `inc/README.md` を参照。

// 基盤
require_once get_template_directory() . '/inc/bootstrap-init.php';
require_once get_template_directory() . '/inc/assets-and-templates.php';

// コンテンツ運用
require_once get_template_directory() . '/inc/column-support.php';
require_once get_template_directory() . '/inc/post-engagement.php';
require_once get_template_directory() . '/inc/post-card-renderer.php';
require_once get_template_directory() . '/inc/search-support.php';
require_once get_template_directory() . '/inc/internal-links.php';
require_once get_template_directory() . '/inc/navigation-maintenance.php';
require_once get_template_directory() . '/inc/dictionary.php';
require_once get_template_directory() . '/inc/news.php';
require_once get_template_directory() . '/inc/beengineer-news.php';
require_once get_template_directory() . '/inc/legal-content.php';

// SEO / パフォーマンス / 画像
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/performance-optimizations.php';
require_once get_template_directory() . '/inc/image-optimizations.php';
require_once get_template_directory() . '/inc/media-helpers.php';

// UI / 外部連携
require_once get_template_directory() . '/inc/sns-menus.php';
require_once get_template_directory() . '/inc/accessibility-analytics.php';