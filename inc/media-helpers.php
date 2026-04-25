<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * テーマ画像をWebP対応で出力するヘルパー関数
 * 
 * @param string $image_path 画像のパス（例: 'assets/images/screenshot.png'）
 * @param string $alt 代替テキスト
 * @param string $class CSSクラス（オプション）
 * @param string $loading loading属性（'lazy' または 'eager'）
 * @return string <picture>タグのHTML
 */
function mytheme_picture_tag($image_path, $alt = '', $class = 'image', $loading = 'lazy') {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    
    // ファイル情報を取得
    $path_info = pathinfo($image_path);
    $dirname = $path_info['dirname'];
    $filename = $path_info['filename'];
    
    // 各ファイルのパスを生成
    $webp_path = $dirname . '/' . $filename . '.webp';
    $webp_url = $theme_uri . '/' . $webp_path;
    $webp_file = $theme_dir . '/' . $webp_path;
    
    $original_url = $theme_uri . '/' . $image_path;
    $original_file = $theme_dir . '/' . $image_path;
    
    // ファイルの存在確認
    $webp_exists = file_exists($webp_file);
    $original_exists = file_exists($original_file);
    
    // フォールバック画像URLを決定（元画像 > WebP > 元のパス）
    $fallback_url = $original_exists ? $original_url : ($webp_exists ? $webp_url : $original_url);
    
    // 画像のサイズを取得（CLS対策）
    $width_height = '';
    $size_file = $original_exists ? $original_file : ($webp_exists ? $webp_file : '');
    if ($size_file && file_exists($size_file)) {
        $image_size = @getimagesize($size_file);
        if ($image_size !== false) {
            $width_height = sprintf(' width="%d" height="%d"', $image_size[0], $image_size[1]);
        }
    }
    
    // WebPファイルが存在する場合のみ<source>タグを出力
    $webp_source = '';
    if ( $webp_exists ) {
        $webp_source = sprintf('<source srcset="%s" type="image/webp">', esc_url($webp_url));
    }
    
    // fetchpriority属性（LCP画像の場合）
    $fetchpriority = '';
    if ( $loading === 'eager' ) {
        $fetchpriority = ' fetchpriority="high"';
    }
    
    // <picture>タグを生成（CLS対策：width/height属性追加）
    return sprintf(
        '<picture>%s<img src="%s" alt="%s" class="%s"%s loading="%s"%s decoding="async"></picture>',
        $webp_source,
        esc_url($fallback_url),
        esc_attr($alt),
        esc_attr($class),
        $width_height,
        esc_attr($loading),
        $fetchpriority
    );
}
