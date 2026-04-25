<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// ===== アクセシビリティ向上 =====

/**
 * SVG画像に自動的にアクセシビリティ属性を追加
 */
function mytheme_add_svg_accessibility($content) {
    if (is_admin()) {
        return $content;
    }
    
    // 装飾的なSVG（アイコンなど）にaria-hidden属性を追加
    $content = preg_replace(
        '/<svg([^>]*class="[^"]*(?:nav-card-link__icon|feature-icon-bg|wave-divider__svg|arrow-down)[^"]*"[^>]*)>/i',
        '<svg$1 aria-hidden="true">',
        $content
    );
    
    return $content;
}
add_filter('the_content', 'mytheme_add_svg_accessibility', 20);

// ===== アナリティクス =====

/**
 * Google Analytics 4 (GA4) タグを遅延読み込み（パフォーマンス最適化）
 * 
 * 測定IDを設定するには、以下のいずれかの方法を使用：
 * 1. wp-config.phpに define('GA_MEASUREMENT_ID', 'G-XXXXXXXXXX'); を追加
 * 2. functions.phpの下記行を直接編集
 * 
 * 遅延読み込みにより、初期ページ読み込みをブロックせず、PageSpeed Insights スコアを改善
 * ユーザーインタラクション時または3秒後に自動読み込み
 */
function mytheme_add_ga4_tag() {
    // 測定IDは wp-config.php の define('GA_MEASUREMENT_ID', 'G-XXXXXXXXXX') で明示指定時のみ使用。
    // Site Kit 等で GA を管理しているケースでは、二重計測を避けるため出力しない。
    $measurement_id = defined('GA_MEASUREMENT_ID') ? GA_MEASUREMENT_ID : '';
    
    // 測定IDが設定されていない場合は何も出力しない
    if (empty($measurement_id)) {
        return;
    }
    
    // 本番環境のみ出力（ローカル開発環境では出力しない）
    if (defined('WP_ENVIRONMENT_TYPE') && WP_ENVIRONMENT_TYPE !== 'production') {
        return;
    }
    ?>
    <!-- Google Analytics 4 (GA4) - 遅延読み込み（パフォーマンス最適化） -->
    <script>
    // GA4を遅延読み込み（PageSpeed Insights 対策）
    (function() {
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        
        var loaded = false;
        function loadGA4() {
            if (loaded) return;
            loaded = true;
            
            var script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js($measurement_id); ?>';
            document.head.appendChild(script);
            
            script.onload = function() {
                gtag('js', new Date());
                gtag('config', '<?php echo esc_js($measurement_id); ?>', {
                    'send_page_view': true,
                    'anonymize_ip': true,
                    'allow_google_signals': false,
                    'allow_ad_personalization_signals': false
                });
            };
        }
        
        // ユーザーインタラクション時に即座に読み込み
        var events = ['scroll', 'click', 'mousemove', 'touchstart', 'keydown'];
        events.forEach(function(event) {
            window.addEventListener(event, loadGA4, { once: true, passive: true });
        });
        
        // 3秒後に自動読み込み（インタラクションがない場合）
        setTimeout(loadGA4, 3000);
    })();
    </script>
    <?php
}
add_action('wp_head', 'mytheme_add_ga4_tag', 1);
