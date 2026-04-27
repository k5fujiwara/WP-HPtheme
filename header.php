<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<!doctype html>
<html <?php language_attributes(); ?> prefix="og: https://ogp.me/ns#" class="page">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Google Search Console 所有権確認 -->
    <meta name="google-site-verification" content="VZH4PGl9zEoiKrryEXmyZqxvXSHNkCl5sI6FhEJXpvc" />
    
    <!-- Google Analytics 4 は Site Kit で管理 -->
    
    <!-- Google Fontsを削除してシステムフォントを使用（パフォーマンス最優先） -->
    <!-- 外部リソース削減: FCP -0.5~1.0秒改善 -->
    
    <!-- 画像フォーマットのプリロード（LCP対象画像を優先読み込み） -->
    <?php
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();
    
    // Worksページ: 最初の作品サムネイルをプリロード
    if (is_page('works')) {
        $lcp_image = 'assets/images/loto6_3.webp';
        if (file_exists($theme_dir . '/' . $lcp_image)) {
            echo '<link rel="preload" as="image" href="' . esc_url($theme_uri . '/' . $lcp_image) . '" type="image/webp" fetchpriority="high">' . "\n    ";
        }
    }
    
    // プロジェクトページ1（ロト６）: ヒーロー画像をプリロード
    else if (is_page('loto6')) {
        $lcp_image = 'assets/images/loto6_3.webp';
        if (file_exists($theme_dir . '/' . $lcp_image)) {
            echo '<link rel="preload" as="image" href="' . esc_url($theme_uri . '/' . $lcp_image) . '" type="image/webp" fetchpriority="high">' . "\n    ";
        }
    }
    
    // プロジェクトページ2（自動タイピング）: ヒーロー画像をプリロード
    else if (is_page('auto-typing')) {
        $lcp_image = 'assets/images/auto_typing1.webp';
        if (file_exists($theme_dir . '/' . $lcp_image)) {
            echo '<link rel="preload" as="image" href="' . esc_url($theme_uri . '/' . $lcp_image) . '" type="image/webp" fetchpriority="high">' . "\n    ";
        }
    }
    
    // プロジェクトページ3（Quest4）: ヒーロー画像をプリロード
    else if (is_page('quest4')) {
        $lcp_image = 'assets/images/quest4_1.webp';
        if (file_exists($theme_dir . '/' . $lcp_image)) {
            echo '<link rel="preload" as="image" href="' . esc_url($theme_uri . '/' . $lcp_image) . '" type="image/webp" fetchpriority="high">' . "\n    ";
        }
    }
    ?>
    
    <!-- Critical CSS（最初のレンダリングに必要な最小限のCSS - 最適化版） -->
    <style>
        /* ベース（最小限） */
        *,*:before,*:after{box-sizing:border-box}
        .site-body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;line-height:1.75;color:#161616;background:linear-gradient(180deg,#edf5ff 0%,#f8fcff 40%,#fff 100%);background-attachment:scroll;font-size:16px;-webkit-font-smoothing:antialiased;opacity:1}
        .site-body.loaded{animation:fadeIn .15s ease-out forwards}
        @keyframes fadeIn{from{opacity:.95}to{opacity:1}}
        
        /* ヘッダー（ATF） */
        .site-header-shell{position:sticky;top:0;z-index:102;background:#fff;box-shadow:0 10px 24px rgba(15,98,254,.08)}
        .site-header{padding:24px 0 0;background:#fff;z-index:100}
        .container{width:min(1100px,92%);margin:0 auto}
        .site-title{font-size:2rem;font-weight:800;text-decoration:none;color:#0f62fe;letter-spacing:-.02em;line-height:1.2;display:inline-block}
        .site-description{margin:0;padding-bottom:16px;color:#525252;font-size:.925rem;font-weight:500}
        
        /* ヒーローセクション（トップページのみ） */
        .hero-section{text-align:center;padding:48px 40px;background:
            radial-gradient(circle at 18% 18%,rgba(255,255,255,.2),transparent 20%),
            radial-gradient(circle at 82% 22%,rgba(0,212,255,.18),transparent 24%),
            linear-gradient(135deg,#001d6c 0%,#0f62fe 52%,#4589ff 100%);border-radius:32px;margin:40px 20px;box-shadow:0 12px 40px rgba(0,45,156,.25);overflow:hidden;border:1px solid rgba(255,255,255,.12);min-height:220px;display:flex;align-items:center;justify-content:center}
        .hero-section__inner{max-width:720px;position:relative;z-index:1}
        .hero-eyebrow{display:inline-flex;align-items:center;gap:8px;margin:0 0 16px;padding:8px 14px;border:1px solid rgba(255,255,255,.22);border-radius:999px;background:rgba(255,255,255,.12);color:rgba(255,255,255,.92);font-size:.78rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;backdrop-filter:blur(8px)}
        .hero-title{font-size:2.9rem;margin:0 auto;font-weight:900;color:#fff;text-shadow:0 4px 12px rgba(0,0,0,.3);letter-spacing:-.03em;line-height:1.12;z-index:1;max-width:none;white-space:nowrap}
        .hero-lead{margin:18px auto 0;max-width:36rem;color:rgba(255,255,255,.9);font-size:1rem;line-height:1.75;text-shadow:0 2px 8px rgba(0,0,0,.16)}
        
        /* ナビゲーション */
        .site-nav{border-top:1px solid rgba(15,98,254,.1);margin:0;background:#fff;position:static;top:auto;z-index:101}
        .site-nav .container{display:flex;align-items:center;padding:12px 0;gap:20px;flex-wrap:nowrap}
        .site-nav__menu{list-style:none;padding:0;margin:0;display:flex;gap:28px;flex-wrap:nowrap;align-items:center}
        .site-nav__link{display:inline-block;padding:10px 6px;text-decoration:none;color:#161616;font-weight:500;transition:color .2s ease;white-space:nowrap}
        .site-nav__actions{display:flex;align-items:center;gap:12px;margin-left:auto}
        .site-nav__action-toggle,.site-nav__action-link{display:inline-flex;align-items:center;gap:6px;padding:10px 6px;background:none;border:none;color:#161616;font-weight:500;text-decoration:none;cursor:pointer;white-space:nowrap}
        body.admin-bar .site-header-shell{top:32px}
        
        /* レスポンシブ */
        @media(max-width:900px){
            .site-nav__menu{display:none}
            .site-nav__actions{display:none}
        }
        @media(max-width:768px){
            .hero-section{padding:34px 22px;margin:32px 16px;min-height:0}
            .hero-eyebrow{margin-bottom:12px;padding:6px 11px;font-size:.64rem;letter-spacing:.06em}
            .hero-title{font-size:1.45rem;max-width:none;white-space:nowrap}
            .hero-lead{margin-top:14px;font-size:.92rem;line-height:1.7}
        }
        @media(max-width:782px){
            body.admin-bar .site-header-shell{top:0}
        }

        @media(min-width:1024px){
            .site-body{background-attachment:fixed}
        }
    </style>
    
    <!-- Google AdSense（初回描画を優先するため遅延ロード） -->
    <script>
    (function() {
        var ADS_SRC = 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6924336257757707';
        var loaded = false;

        function loadAdsScript() {
            if (loaded) return;
            loaded = true;
            var s = document.createElement('script');
            s.async = true;
            s.src = ADS_SRC;
            s.crossOrigin = 'anonymous';
            document.head.appendChild(s);
        }

        function scheduleLoad() {
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(loadAdsScript, { timeout: 4000 });
            } else {
                setTimeout(loadAdsScript, 1500);
            }
        }

        window.addEventListener('load', scheduleLoad, { once: true });

        // 先に操作があれば、その時点で読み込む
        ['pointerdown', 'keydown', 'scroll'].forEach(function(eventName) {
            window.addEventListener(eventName, loadAdsScript, { once: true, passive: true });
        });
    })();
    </script>
    
    <?php wp_head(); ?>
    
    <!-- JavaScriptが無効でもページを表示 -->
    <script>document.documentElement.classList.add('js-enabled');</script>
    <noscript><style>.site-body{opacity:1;visibility:visible}</style></noscript>
</head>
<body <?php body_class('site-body'); ?> itemscope itemtype="https://schema.org/WebPage">
    <?php wp_body_open(); ?>
    
    <!-- 即座にページを表示（JavaScript無効でも動作） -->
    <script>document.body.classList.add('loaded');</script>
    
    <!-- スキップリンク（アクセシビリティ向上） -->
    <a class="skip-link screen-reader-text" href="#main-content">コンテンツへスキップ</a>
    
    <!-- スクロールプログレスバー -->
    <div class="scroll-progress">
        <div class="scroll-progress-bar"></div>
    </div>
    
    <div class="site-header-shell">
        <header class="site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
            <div class="container">
                <div class="header-top">
                    <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url">
                        <span itemprop="name"><?php bloginfo('name'); ?></span>
                    </a>
                    <button class="menu-toggle" aria-label="メニューを開く" aria-expanded="false" aria-controls="primary-menu">
                        <span class="menu-toggle-icon"></span>
                        <span class="menu-toggle-icon"></span>
                        <span class="menu-toggle-icon"></span>
                    </button>
                </div>
                <p class="site-description" itemprop="description"><?php bloginfo('description'); ?></p>
            </div>
        </header>
        
        <nav class="site-nav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="メインナビゲーション">
            <div class="container">
                <?php if ( function_exists('mytheme_primary_menu_fallback') ) : ?>
                    <?php mytheme_primary_menu_fallback(); ?>
                <?php else : ?>
                    <ul id="primary-menu" class="site-nav__menu">
                        <li class="menu-item site-nav__item site-nav__item--current">
                            <a class="site-nav__link" href="<?php echo esc_url( home_url('/') ); ?>">ホーム</a>
                        </li>
                    </ul>
                <?php endif; ?>

                <div class="site-nav__actions">
                    <?php if ( function_exists('mytheme_header_updates_menu') ) : ?>
                        <?php mytheme_header_updates_menu(); ?>
                    <?php endif; ?>

                    <?php if ( function_exists('mytheme_header_channels_menu') ) : ?>
                        <?php mytheme_header_channels_menu(); ?>
                    <?php endif; ?>

                    <?php
                    $contact_url = function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('contact', home_url('/contact/'))
                        : home_url('/contact/');
                    $contact_is_current = function_exists('mytheme_is_current_page_tree') && mytheme_is_current_page_tree('contact');
                    ?>
                    <a class="site-nav__action-link<?php echo $contact_is_current ? ' is-current' : ''; ?>" href="<?php echo esc_url($contact_url); ?>">
                        お問い合わせ
                    </a>
                </div>
            </div>
        </nav>
    </div>
    
<main id="main-content" class="site-main container" role="main" itemprop="mainContentOfPage">
