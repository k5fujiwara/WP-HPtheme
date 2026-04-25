<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// テンプレートファイルの検索パスにサブディレクトリを追加
function mytheme_add_template_paths($template) {
    // テンプレートが見つからない場合、templatesフォルダ内を検索
    if (!file_exists($template)) {
        $template_name = basename($template);
        $new_template = get_template_directory() . '/templates/projects/' . $template_name;
        if (file_exists($new_template)) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'mytheme_add_template_paths', 99);

// ページテンプレートの読み込みパスを修正
function mytheme_locate_template($template) {
    // templates/ サブディレクトリのテンプレートを読み込み可能にする
    if (is_page()) {
        $page_template = get_post_meta(get_queried_object_id(), '_wp_page_template', true);
        if ($page_template && $page_template != 'default') {
            $template_file = get_template_directory() . '/' . $page_template;
            if (file_exists($template_file)) {
                return $template_file;
            }
        }
    }
    return $template;
}
add_filter('page_template', 'mytheme_locate_template', 99);

// CSS/JS 読み込み
function mytheme_get_theme_asset_rel_path($base_rel, $extension) {
    $theme_dir = get_template_directory();
    $base_rel  = '/' . ltrim($base_rel, '/');
    $normal_rel = $base_rel . $extension;
    $min_rel    = $base_rel . '.min' . $extension;
    $normal_path = $theme_dir . $normal_rel;
    $min_path    = $theme_dir . $min_rel;

    // min が最新なら優先配信。古い min を誤配信しない。
    if ( file_exists($min_path) && ( ! file_exists($normal_path) || filemtime($min_path) >= filemtime($normal_path) ) ) {
        return $min_rel;
    }

    return $normal_rel;
}

function mytheme_assets() {
    $theme_version = wp_get_theme()->get('Version');
    $theme_dir = get_template_directory();
    
    // ===== メインCSS読み込み =====
    $main_css_rel  = mytheme_get_theme_asset_rel_path('/assets/css/main', '.css');
    $main_css_path = $theme_dir . $main_css_rel;
    $main_css_ver  = file_exists($main_css_path) ? (string) filemtime($main_css_path) : $theme_version;
    wp_enqueue_style('mytheme-main', get_template_directory_uri() . $main_css_rel, [], $main_css_ver);

    // 学習コラム（一覧）だけに必要なCSS（未使用CSS削減）
    if ( is_page('learning-column') || is_home() || is_search() || is_category() || is_tag() || is_tax() || is_singular('post') || is_post_type_archive('dictionary') ) {
        $lc_css_rel  = mytheme_get_theme_asset_rel_path('/assets/css/pages/learning-column', '.css');
        $lc_css_path = $theme_dir . $lc_css_rel;
        if ( file_exists($lc_css_path) ) {
            $lc_css_ver = (string) filemtime($lc_css_path);
            wp_enqueue_style('mytheme-learning-column', get_template_directory_uri() . $lc_css_rel, ['mytheme-main'], $lc_css_ver);
        }
    }

    // 辞書アーカイブ専用CSS
    if ( is_post_type_archive('dictionary') ) {
        $dic_css_rel  = mytheme_get_theme_asset_rel_path('/assets/css/pages/dictionary', '.css');
        $dic_css_path = $theme_dir . $dic_css_rel;
        if ( file_exists($dic_css_path) ) {
            $dic_css_ver = (string) filemtime($dic_css_path);
            wp_enqueue_style('mytheme-dictionary', get_template_directory_uri() . $dic_css_rel, ['mytheme-main'], $dic_css_ver);
        }
    }

    if ( is_post_type_archive('beengineer-news') || is_singular('beengineer-news') ) {
        $be_news_css_rel  = mytheme_get_theme_asset_rel_path('/assets/css/pages/beengineer-news', '.css');
        $be_news_css_path = $theme_dir . $be_news_css_rel;
        if ( file_exists($be_news_css_path) ) {
            $be_news_css_ver = (string) filemtime($be_news_css_path);
            wp_enqueue_style('mytheme-beengineer-news', get_template_directory_uri() . $be_news_css_rel, ['mytheme-main'], $be_news_css_ver);
        }
    }

    // NOTE: footer.css は main.css に統合済みのため、追加読み込みしない（重複CSS削減）
    
    $main_js_rel  = mytheme_get_theme_asset_rel_path('/assets/js/main', '.js');
    $main_js_path = $theme_dir . $main_js_rel;
    $main_js_ver  = file_exists($main_js_path) ? (string) filemtime($main_js_path) : $theme_version;
    wp_enqueue_script('mytheme-main-js', get_template_directory_uri() . $main_js_rel, [], $main_js_ver, true);

    // 学習コラム（一覧）だけに必要なJS（未使用JS削減）
    if ( is_page('learning-column') || is_home() ) {
        $lc_js_rel  = mytheme_get_theme_asset_rel_path('/assets/js/learning-column', '.js');
        $lc_js_path = $theme_dir . $lc_js_rel;
        if ( file_exists($lc_js_path) ) {
            $lc_js_ver = (string) filemtime($lc_js_path);
            wp_enqueue_script('mytheme-learning-column', get_template_directory_uri() . $lc_js_rel, [], $lc_js_ver, true);
        }
    }

    // 辞書アーカイブ専用JS（モーダル）
    if ( is_post_type_archive('dictionary') ) {
        $dic_js_rel  = mytheme_get_theme_asset_rel_path('/assets/js/dictionary', '.js');
        $dic_js_path = $theme_dir . $dic_js_rel;
        if ( file_exists($dic_js_path) ) {
            $dic_js_ver = (string) filemtime($dic_js_path);
            wp_enqueue_script('mytheme-dictionary', get_template_directory_uri() . $dic_js_rel, [], $dic_js_ver, true);
        }
    }
}
add_action('wp_enqueue_scripts', 'mytheme_assets');

/**
 * 学習コラム/辞書の追加CSSだけを非同期読み込み
 *
 * main.css は初期描画に必要なので通常読込のまま維持し、
 * ページ個別CSSだけ render-blocking を外す。
 */
function mytheme_async_page_styles($html, $handle, $href, $media) {
    if ( is_admin() ) {
        return $html;
    }

    if ( ! in_array($handle, ['mytheme-learning-column', 'mytheme-dictionary', 'mytheme-beengineer-news'], true) ) {
        return $html;
    }

    $stylesheet_id = esc_attr($handle . '-css');
    $href_attr = esc_url($href);
    $media_attr = esc_attr($media ? $media : 'all');

    return '<link rel="preload" as="style" id="' . $stylesheet_id . '-preload" href="' . $href_attr . '" onload="this.onload=null;this.rel=\'stylesheet\'" media="' . $media_attr . '">' . "\n"
        . '<noscript><link rel="stylesheet" id="' . $stylesheet_id . '" href="' . $href_attr . '" media="' . $media_attr . '"></noscript>' . "\n";
}
add_filter('style_loader_tag', 'mytheme_async_page_styles', 10, 4);

/**
 * ナビゲーションメニューにBEMクラスを追加
 */
function mytheme_add_bem_classes_to_nav_menu($classes, $item, $args, $depth) {
    // メインメニューにのみ適用
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        // BEMクラスを追加（既存のWordPressクラスは保持）
        $classes[] = 'site-nav__item';
        
        // 現在のページの場合、Modifierクラスも追加
        if (in_array('current-menu-item', $classes) || 
            in_array('current_page_item', $classes) || 
            in_array('current-menu-ancestor', $classes)) {
            $classes[] = 'site-nav__item--current';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'mytheme_add_bem_classes_to_nav_menu', 10, 4);

/**
 * ナビゲーションメニューのリンクにBEMクラスを追加
 */
function mytheme_add_bem_classes_to_nav_menu_link($atts, $item, $args, $depth) {
    // メインメニューにのみ適用
    if (isset($args->theme_location) && $args->theme_location === 'primary') {
        // 既存のクラスを保持しながらBEMクラスを追加
        $classes = isset($atts['class']) ? $atts['class'] . ' ' : '';
        $atts['class'] = $classes . 'site-nav__link';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'mytheme_add_bem_classes_to_nav_menu_link', 10, 4);

// 重要なCSSファイルにpreloadを追加（パフォーマンス最適化）
function mytheme_preload_critical_css() {
    $theme_version = wp_get_theme()->get('Version');
    $theme_dir = get_template_directory();
    
    // main.css は常に最新の配信用ファイルをプリロード
    $main_css_rel  = mytheme_get_theme_asset_rel_path('/assets/css/main', '.css');
    $main_css_path = $theme_dir . $main_css_rel;
    $ver = file_exists($main_css_path) ? (string) filemtime($main_css_path) : $theme_version;
    echo '<link rel="preload" href="' . get_template_directory_uri() . $main_css_rel . '?ver=' . $ver . '" as="style">' . "\n";
}
add_action('wp_head', 'mytheme_preload_critical_css', 5);
