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
    // 表の列幅など、編集画面の中身にテーマの見た目を合わせる
    add_theme_support('editor-styles');
    add_editor_style('assets/css/editor-table.css');
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
// 役割ごとに `inc/<役割>/` へ分割。詳細は `inc/README.md` を参照。
// 読み込み順は旧構成と同じ（関数の定義順に依存する処理があるため変更しない）。
$mytheme_modules = [
    // core: 基盤（初期化・アセット読み込み）
    'core/bootstrap-init',
    'core/assets-and-templates',

    // content: 学習コラム・記事まわりの運用
    'content/column-support',
    'content/post-engagement',
    'content/post-card-renderer',
    'content/search-support',
    'content/internal-links',
    'content/navigation-maintenance',

    // post-types: カスタム投稿タイプ
    'post-types/dictionary',
    'post-types/news',
    'post-types/beengineer-news',
    'post-types/works',
    'post-types/youtube-learning',

    // apps: サイト内アプリ（クイズ・情報Ⅰコードポケット）
    'apps/science-quiz',
    'apps/japanese-quiz',
    'apps/it1-code-pocket',

    // content: 法務ページ
    'content/legal-content',

    // core: SEO / パフォーマンス / 画像
    'core/seo',
    'core/performance-optimizations',
    'core/image-optimizations',
    'core/media-helpers',

    // ui / 外部連携
    'ui/sns-menus',
    'core/accessibility-analytics',
];
foreach ( $mytheme_modules as $mytheme_module ) {
    require_once get_template_directory() . '/inc/' . $mytheme_module . '.php';
}
unset($mytheme_modules, $mytheme_module);