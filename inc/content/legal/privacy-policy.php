<?php
if ( ! defined('ABSPATH') ) exit;

/**
 * プライバシーポリシー（テンプレHTML）
 * - 文面の編集はこのファイルだけでOK
 */
function mytheme_legal_privacy_policy_template_html(array $args): string {
    $site_name = (string) ($args['site_name'] ?? '');
    $contact_url = (string) ($args['contact_url'] ?? '');

    $html  = "<!-- mytheme:privacy-policy:template:v1 -->\n";
    $html .= '<div class="legal-policy">' . "\n";
    $html .= '<p>当サイト（「' . esc_html($site_name) . '」、以下「当サイト」）は、個人情報の保護に最大限配慮し、以下のとおりプライバシーポリシーを定めます。</p>' . "\n";
    $html .= '<hr>' . "\n";

    $html .= '<h2>1. 取得する情報</h2>' . "\n";
    $html .= '<p>当サイトでは、お問い合わせ等の際に、お名前（ハンドルネーム）・メールアドレス・お問い合わせ内容等の情報をご提供いただく場合があります。</p>' . "\n";
    $html .= '<p>当サイトのお問い合わせフォームは、Google LLC が提供する「Googleフォーム」を利用しています。フォームに入力された情報は、当サイト運営者に送信されるほか、Google LLC によって収集・保存される場合があります。Google による情報の取り扱いについては、以下をご確認ください。<br><a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">https://policies.google.com/privacy</a></p>' . "\n";
    $html .= '<p>また、当サイトは広告配信やアクセス解析に関連して、Cookie等により利用状況に関する情報を取得する場合があります。</p>' . "\n";

    $html .= '<h2>2. 利用目的</h2>' . "\n";
    $html .= '<ul>' . "\n";
    $html .= '  <li>お問い合わせへの対応、必要なご連絡のため</li>' . "\n";
    $html .= '  <li>当サイトの利便性向上、品質改善のため</li>' . "\n";
    $html .= '  <li>アクセス状況の分析・把握のため</li>' . "\n";
    $html .= '</ul>' . "\n";

    $html .= '<h2>3. 広告配信について（Google AdSense）</h2>' . "\n";
    $html .= '<p>当サイトは第三者配信の広告サービス（Google AdSense）を利用します（または利用する予定があります）。</p>' . "\n";
    $html .= '<p>第三者配信事業者は、ユーザーの興味に応じた広告を表示するためにCookie等を使用することがあります。</p>' . "\n";
    $html .= '<p>Googleによる広告におけるCookieの取り扱いについては、以下をご確認ください。<br><a href="https://policies.google.com/technologies/ads" target="_blank" rel="noopener noreferrer">https://policies.google.com/technologies/ads</a></p>' . "\n";

    $html .= '<h2>4. アクセス解析について（Google Analytics）</h2>' . "\n";
    $html .= '<p>当サイトでは、アクセス解析ツール「Google Analytics」を利用しています。</p>' . "\n";
    $html .= '<p>Google Analyticsは、トラフィックデータの収集のためにCookie等を使用します。これらのデータは匿名で収集されており、個人を特定するものではありません。</p>' . "\n";
    $html .= '<p><strong>収集される情報の例</strong></p>' . "\n";
    $html .= '<ul>' . "\n";
    $html .= '  <li>閲覧したページ、滞在時間、参照元（検索/他サイト/SNS等）</li>' . "\n";
    $html .= '  <li>ブラウザ/OS/端末情報</li>' . "\n";
    $html .= '  <li>おおよその地域情報（国/都道府県等）</li>' . "\n";
    $html .= '</ul>' . "\n";
    $html .= '<p>Google Analyticsのデータ利用については、以下をご確認ください。<br><a href="https://policies.google.com/technologies/partner-sites" target="_blank" rel="noopener noreferrer">https://policies.google.com/technologies/partner-sites</a></p>' . "\n";
    $html .= '<p>ユーザーは、ブラウザ設定によりCookieを無効にすることで収集を拒否できます。また、Googleが提供するオプトアウトアドオンにより無効化することも可能です。<br><a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener noreferrer">https://tools.google.com/dlpage/gaoptout</a></p>' . "\n";

    $html .= '<h2>5. Cookieの利用について</h2>' . "\n";
    $html .= '<p>当サイトでは、利便性向上のためCookieを使用する場合があります（例：電子書籍ページの表示言語の保持など）。</p>' . "\n";
    $html .= '<p>ブラウザ設定によりCookieを無効化することも可能ですが、サイトの一部機能が利用できなくなる場合があります。</p>' . "\n";

    $html .= '<h2>6. 個人情報の第三者提供</h2>' . "\n";
    $html .= '<p>当サイトは、法令に基づく場合を除き、本人の同意なく個人情報を第三者に提供しません。</p>' . "\n";

    $html .= '<h2>7. 安全管理措置</h2>' . "\n";
    $html .= '<p>当サイトは、取得した情報の漏えい・改ざん・不正アクセス等を防止するために、適切な安全管理措置を講じるよう努めます。</p>' . "\n";

    $html .= '<h2>8. 保管期間</h2>' . "\n";
    $html .= '<p>お問い合わせ内容は、対応のために必要な期間保管し、一定期間経過後に削除します。</p>' . "\n";

    $html .= '<h2>9. お問い合わせ窓口</h2>' . "\n";
    $html .= '<p>当サイトへのお問い合わせは、「<a href="' . esc_url($contact_url) . '">お問い合わせ</a>」ページよりご連絡ください。</p>' . "\n";

    $html .= '<h2>10. ポリシーの変更</h2>' . "\n";
    $html .= '<p>本ポリシーは、法令の改正や運営方針の変更等により、予告なく変更する場合があります。</p>' . "\n";
    $html .= '<p>制定日：2026-01-16<br>最終更新日：2026-01-16</p>' . "\n";
    $html .= '</div>' . "\n";

    return $html;
}

