<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * お問い合わせページ（テンプレHTML）
 * - Googleフォーム埋め込みを基本にしつつ、ページ本文に埋め込み（iframe等）があればそれを優先
 *
 * 変更しやすいポイント：
 * - $google_form_src（フォームURL）
 */
function mytheme_legal_contact_template_html(array $args): string {
    $site_name = (string) ($args['site_name'] ?? '');
    $privacy_url = (string) ($args['privacy_url'] ?? '');
    $original = (string) ($args['original'] ?? '');

    // Googleフォーム（埋め込み）URL（必要に応じて差し替え）
    $google_form_src = 'https://docs.google.com/forms/d/e/1FAIpQLScqVHkNI964wHIhNvU4lOIH-X-kfyLXpftRV2kAP4RMbMDAcQ/viewform?embedded=true';

    // 1) ページ本文にiframe等の埋め込みがある場合はそれを優先（運用差し替え用）
    $form_html = '';
    $has_original = trim(wp_strip_all_tags($original)) !== '';
    if ( $has_original && (
        strpos($original, '<iframe') !== false ||
        strpos($original, 'docs.google.com/forms') !== false ||
        strpos($original, '<form') !== false
    ) ) {
        $form_html = $original;
    }

    // 2) それでも無い場合は、Googleフォームを表示（SMTP不要の運用）
    if ( ! $form_html && $google_form_src ) {
        $form_html =
            '<iframe ' .
            'src="' . esc_url($google_form_src) . '" ' .
            'title="お問い合わせフォーム" ' .
            'class="mytheme-google-form-embed" ' .
            'style="width:100%;max-width:100%;border:0;border-radius:14px;" ' .
            'loading="lazy" referrerpolicy="no-referrer-when-downgrade">' .
            '読み込んでいます…' .
            '</iframe>';
    }

    $html  = "<!-- mytheme:contact:template:v1 -->\n";
    $html .= '<div class="legal-policy">' . "\n";
    $html .= '<p>当サイト（「' . esc_html($site_name) . '」）へのお問い合わせは、以下のフォームよりお願いいたします。</p>' . "\n";
    $html .= '<hr>' . "\n";

    $html .= '<h2>1. お問い合わせフォーム</h2>' . "\n";
    if ( $form_html ) {
        $html .= '<div class="contact-form contact-form--embed">' . "\n";
        $html .= $form_html . "\n";
        $html .= '</div>' . "\n";
    } else {
        $html .= '<div class="contact-form contact-form--placeholder">' . "\n";
        $html .= '<p><strong>現在フォーム準備中です。</strong></p>' . "\n";
        $html .= '<p>フォームを設置すると、ここに表示されます。</p>' . "\n";
        $html .= '</div>' . "\n";
    }

    $html .= '<h2>2. 返信について</h2>' . "\n";
    $html .= '<ul>' . "\n";
    $html .= '  <li>内容を確認のうえ、ご入力いただいたメールアドレス宛に返信いたします。</li>' . "\n";
    $html .= '  <li>ご返信まで数日お時間をいただく場合があります。</li>' . "\n";
    $html .= '</ul>' . "\n";

    $html .= '<h2>3. 個人情報の取り扱い</h2>' . "\n";
    $html .= '<p>お問い合わせで取得した情報は、回答および必要な連絡の目的にのみ利用します。詳しくは「<a href="' . esc_url($privacy_url) . '" target="_blank" rel="noopener noreferrer">プライバシーポリシー</a>」をご確認ください。</p>' . "\n";

    $html .= '<p>制定日：2026-01-16<br>最終更新日：2026-01-16</p>' . "\n";
    $html .= '</div>' . "\n";

    return $html;
}

