<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 法務系ページの「■ 見出し」段落にクラスを付与
 * - ぶら下げインデント（■だけ左に残し、2行目以降は1文字分右）をCSSで実現するため
 */
function mytheme_is_legal_page_context() {
    return is_page(['privacy-policy', 'disclaimer', 'contact']);
}

function mytheme_add_legal_bullet_class_to_content($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular() ) return $content;
    if ( ! mytheme_is_legal_page_context() ) return $content;
    if ( strpos($content, '<p') === false ) return $content;
    // テーマ側テンプレ表示している場合は加工しない
    if ( strpos($content, '<!-- mytheme:privacy-policy:template:v1' ) !== false ) return $content;
    if ( strpos($content, '<!-- mytheme:disclaimer:template:v1' ) !== false ) return $content;
    if ( strpos($content, '<!-- mytheme:contact:template:v1' ) !== false ) return $content;

    // エンコード変換を挟まずに、安全に<p>へ class を付与（先頭が「■」の段落）
    $content = preg_replace_callback('~<p([^>]*)>(\s*■)~u', function($m) {
        $attrs = (string) $m[1];
        $bullet = (string) $m[2];

        if ( preg_match('~\bclass\s*=\s*([\"\'])(.*?)\1~u', $attrs, $cm) ) {
            $quote = $cm[1];
            $class_value = $cm[2];
            $classes = preg_split('~\s+~u', trim($class_value)) ?: [];
            if ( ! in_array('legal-bullet', $classes, true) ) {
                $classes[] = 'legal-bullet';
            }
            $new_class = 'class=' . $quote . trim(implode(' ', array_filter($classes))) . $quote;
            $attrs = preg_replace('~\bclass\s*=\s*([\"\'])(.*?)\1~u', $new_class, $attrs, 1);
        } else {
            $attrs .= ' class="legal-bullet"';
        }

        return '<p' . $attrs . '>' . $bullet;
    }, $content);

    // 見出し部分（■〜<br>の手前）だけ太字にする
    // すでに <strong class="legal-bullet__title"> が付いている場合は重複させない
    $content = preg_replace_callback(
        '~(<p\b[^>]*\blegal-bullet\b[^>]*>)(\s*■[\s\S]*?)(<br\s*/?>)~u',
        function($m) {
            $open = $m[1];
            $title = $m[2];
            $br = $m[3];
            if ( strpos($title, 'legal-bullet__title') !== false ) return $m[0];
            return $open . '<strong class="legal-bullet__title">' . $title . '</strong>' . $br;
        },
        $content
    );

    return $content;
}
add_filter('the_content', 'mytheme_add_legal_bullet_class_to_content', 25);

/**
 * お問い合わせを統一フォーマットで表示（テーマ側テンプレ）
 * - Contact Form 7 があれば自動でフォームを埋め込む（未作成なら案内）
 */
function mytheme_render_contact_template($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('page') ) return $content;
    if ( ! is_page(['contact', 'お問い合わせ']) ) return $content;
    require_once get_template_directory() . '/inc/legal/contact.php';

    $privacy_url = mytheme_get_page_url_by_path('privacy-policy', home_url('/privacy-policy/'));

    return mytheme_legal_contact_template_html([
        'site_name'   => get_bloginfo('name'),
        'privacy_url' => $privacy_url,
        'original'    => (string) $content,
    ]);
}
add_filter('the_content', 'mytheme_render_contact_template', 12);

/**
 * プライバシーポリシーを統一フォーマットで表示（テーマ側テンプレ）
 * - ページ本文の編集内容に依存せず、一貫した体裁で表示する
 * - 変更したい場合は、この関数内の文面を編集してください
 */
function mytheme_render_privacy_policy_template($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('page') ) return $content;
    if ( ! is_page(['privacy-policy', 'プライバシーポリシー']) ) return $content;

    $contact_url = mytheme_get_page_url_by_path('contact', home_url('/contact/'));
    require_once get_template_directory() . '/inc/legal/privacy-policy.php';

    return mytheme_legal_privacy_policy_template_html([
        'site_name'   => get_bloginfo('name'),
        'contact_url' => $contact_url,
    ]);
}
add_filter('the_content', 'mytheme_render_privacy_policy_template', 12);

/**
 * 免責事項 / 広告表記を統一フォーマットで表示（テーマ側テンプレ）
 * - ページ本文の編集内容に依存せず、一貫した体裁で表示する
 */
function mytheme_render_disclaimer_template($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('page') ) return $content;
    if ( ! is_page(['disclaimer', '免責事項 / 広告表記', '免責事項']) ) return $content;

    $contact_url = mytheme_get_page_url_by_path('contact', home_url('/contact/'));
    require_once get_template_directory() . '/inc/legal/disclaimer.php';

    return mytheme_legal_disclaimer_template_html([
        'site_name'   => get_bloginfo('name'),
        'contact_url' => $contact_url,
    ]);
}
add_filter('the_content', 'mytheme_render_disclaimer_template', 12);
