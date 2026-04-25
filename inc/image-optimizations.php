<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 画像のalt属性を自動設定＆Lazy Loading追加＆BEMクラス追加
 */
function mytheme_auto_image_alt($attr, $attachment) {
    if (empty($attr['alt'])) {
        $attr['alt'] = get_the_title($attachment->ID);
    }
    
    // BEMクラスを追加
    $bem_class = 'image';
    
    // Lazy Loading属性を追加（ファーストビュー以外の画像）
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
        $bem_class .= ' image--lazy';
    } else if ($attr['loading'] === 'eager') {
        $bem_class .= ' image--eager';
    }
    
    // 既存のクラスに追加
    if (isset($attr['class'])) {
        $attr['class'] .= ' ' . $bem_class;
    } else {
        $attr['class'] = $bem_class;
    }
    
    // デコード属性を追加（レンダリング最適化）
    if (!isset($attr['decoding'])) {
        $attr['decoding'] = 'async';
    }
    
    // fetchpriority属性を追加（LCP画像の場合）
    if (isset($attr['loading']) && $attr['loading'] === 'eager') {
        $attr['fetchpriority'] = 'high';
    }
    
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'mytheme_auto_image_alt', 10, 2);

/**
 * 次世代画像フォーマットのサポート（WebP + AVIF）
 */
function mytheme_add_modern_image_support($mimes) {
    $mimes['webp'] = 'image/webp';
    $mimes['avif'] = 'image/avif';
    return $mimes;
}
add_filter('upload_mimes', 'mytheme_add_modern_image_support');

/**
 * 次世代画像フォーマットのプレビューを有効化（WebP + AVIF）
 */
function mytheme_modern_image_display($result, $path) {
    if ($result === false) {
        $displayable_image_types = array(IMAGETYPE_WEBP);
        
        // PHP 8.1+でAVIFサポート
        if (defined('IMAGETYPE_AVIF')) {
            $displayable_image_types[] = IMAGETYPE_AVIF;
        }
        
        $info = @getimagesize($path);
        
        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }
    
    return $result;
}
add_filter('file_is_displayable_image', 'mytheme_modern_image_display', 10, 2);

/**
 * 画像サイズの最適化設定（レスポンシブ対応）
 */
function mytheme_custom_image_sizes() {
    // Hero画像（トップページ）
    add_image_size('hero-image', 1920, 1080, true);      // デスクトップ
    add_image_size('hero-tablet', 1024, 576, true);      // タブレット
    add_image_size('hero-mobile', 768, 432, true);       // モバイル
    
    // プロジェクト・作品サムネイル
    add_image_size('project-thumbnail', 800, 450, true);  // 16:9
    add_image_size('project-small', 400, 225, true);      // モバイル用
    
    // カード画像
    add_image_size('card-image', 600, 400, true);
    add_image_size('card-small', 400, 267, true);         // モバイル用
    
    // アイキャッチ画像
    add_image_size('featured-large', 1200, 675, true);
    add_image_size('featured-medium', 800, 450, true);
}
add_action('after_setup_theme', 'mytheme_custom_image_sizes');

/**
 * レスポンシブ画像のsrcset/sizes属性を最適化
 */
function mytheme_responsive_image_sizes($sizes, $size) {
    $width = $size[0];
    
    // ページタイプに応じて最適なサイズを指定
    if (is_singular() && !is_front_page()) {
        // 記事・固定ページ（コンテンツ幅）
        $sizes = '(max-width: 640px) 100vw, (max-width: 768px) 90vw, (max-width: 1024px) 80vw, 900px';
    } elseif (is_front_page()) {
        // トップページ（ヒーロー画像）
        $sizes = '(max-width: 640px) 100vw, (max-width: 1024px) 95vw, 1200px';
    } else {
        // アーカイブ・カード画像
        $sizes = '(max-width: 640px) 100vw, (max-width: 768px) 50vw, (max-width: 1024px) 33vw, 600px';
    }
    
    return $sizes;
}
add_filter('wp_calculate_image_sizes', 'mytheme_responsive_image_sizes', 10, 2);

/**
 * 画像品質の最適化（WordPress 6.0+）
 */
function mytheme_optimize_image_quality($quality, $mime_type) {
    // JPEG画像の品質を82%に設定（デフォルト82%）
    if ($mime_type === 'image/jpeg') {
        return 82;
    }
    
    // WebP画像の品質を85%に設定
    if ($mime_type === 'image/webp') {
        return 85;
    }
    
    // AVIF画像の品質を80%に設定（より高圧縮）
    if ($mime_type === 'image/avif') {
        return 80;
    }
    
    return $quality;
}
add_filter('wp_editor_set_quality', 'mytheme_optimize_image_quality', 10, 2);

/**
 * 大きすぎる画像のアップロードを制限（パフォーマンス向上）
 */
function mytheme_limit_image_dimensions($file) {
    $max_width = 2560;  // 最大幅
    $max_height = 1440; // 最大高さ
    
    $image_info = @getimagesize($file['tmp_name']);
    
    if ($image_info) {
        $width = $image_info[0];
        $height = $image_info[1];
        
        if ($width > $max_width || $height > $max_height) {
            $file['error'] = sprintf(
                '画像サイズが大きすぎます。最大サイズは %dx%dpx です。アップロードされた画像: %dx%dpx',
                $max_width,
                $max_height,
                $width,
                $height
            );
        }
    }
    
    return $file;
}
add_filter('wp_handle_upload_prefilter', 'mytheme_limit_image_dimensions');
