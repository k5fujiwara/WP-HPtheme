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
        .site-body{margin:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;line-height:1.75;color:#161616;background:#faf9f6;font-size:16px;-webkit-font-smoothing:antialiased;opacity:1}
        .site-body.loaded{opacity:1}
        
        /* ヘッダー（ATF） */
        .site-header-shell{position:sticky;top:0;z-index:102;background:#fff;box-shadow:0 10px 24px rgba(31, 58, 104,.08)}
        .site-header{padding:24px 0 0;background:#fff;z-index:100}
        .container{width:min(1100px,92%);margin:0 auto}
        .site-title{font-size:1.5rem;font-weight:800;text-decoration:none;color:#1c2321;letter-spacing:-.01em;line-height:1.2;display:inline-block}
        .site-description{margin:0;padding-bottom:16px;color:#525252;font-size:.925rem;font-weight:500}
        
        /* ナビゲーション */
        .site-nav{border-top:1px solid rgba(31, 58, 104,.1);margin:0;background:#fff;position:static;top:auto;z-index:101}
        .site-nav .container{display:flex;align-items:center;padding:12px 0;gap:20px;flex-wrap:nowrap}
        .site-nav__menu{list-style:none;padding:0;margin:0;display:flex;gap:28px;flex-wrap:nowrap;align-items:center}
        .site-nav__link{display:inline-block;padding:10px 6px;text-decoration:none;color:#161616;font-weight:500;transition:color .2s ease;white-space:nowrap}
        .site-nav__item--has-children{position:relative}
        .site-nav__submenu{display:none;list-style:none;margin:0;padding:8px 0;position:absolute;left:0;top:100%;min-width:max-content;width:max-content;background:#fff;border:1px solid rgba(31, 58, 104,.12);border-radius:14px;box-shadow:0 14px 32px rgba(31, 58, 104,.12);z-index:120}
        .site-nav__item--has-children:hover>.site-nav__submenu,
        .site-nav__item--has-children:focus-within>.site-nav__submenu,
        .site-nav__item--has-children.is-open>.site-nav__submenu{display:block}
        .site-nav__submenu .site-nav__link{display:block;padding:10px 16px}
        .site-nav__submenu-toggle{display:inline-flex;align-items:center;gap:6px;background:none;border:none;cursor:pointer;font-family:inherit}
        .site-nav__caret{display:inline-block;width:0;height:0;margin-top:1px;border-left:4px solid transparent;border-right:4px solid transparent;border-top:5px solid currentColor}
        .site-nav__actions{display:flex;align-items:center;gap:12px;margin-left:auto}
        .site-nav__action-toggle,.site-nav__action-link{display:inline-flex;align-items:center;gap:6px;padding:10px 6px;background:none;border:none;color:#161616;font-weight:500;text-decoration:none;cursor:pointer;white-space:nowrap}
        .site-nav__note{display:inline-flex;align-items:center;justify-content:center;min-height:36px;margin:0;padding:8px 14px;border:1.5px solid #111;border-radius:10px;background:#fff;color:#111;font-weight:800;font-size:.875rem;line-height:1.2;text-decoration:none;white-space:nowrap}
        body.admin-bar .site-header-shell{top:32px}
        
        /* レスポンシブ */
        @media(max-width:900px){
            .site-nav__menu{display:none}
            .site-nav__actions{display:none}
            .site-nav__submenu{position:static;border:none;box-shadow:none;background:transparent;min-width:0;width:100%;padding:0 0 8px}
            .site-nav__item--has-children:hover>.site-nav__submenu,
            .site-nav__item--has-children:focus-within>.site-nav__submenu{display:none}
            .site-nav__item--has-children.is-open>.site-nav__submenu{display:block}
            .site-nav__submenu .site-nav__link{padding:12px 12px 12px 28px}
        }
        @media(max-width:782px){
            body.admin-bar .site-header-shell{top:0}
        }

        @media(min-width:1024px){
            .site-body{background:#faf9f6}
        }
        <?php if ( function_exists('mytheme_is_quiz_page') && mytheme_is_quiz_page() ) : ?>
        <?php
        $quiz_paper = is_page('japanese-quiz') ? '#f3e6d8' : '#efe6d4';
        $quiz_accent = is_page('japanese-quiz') ? '#9a3b32' : '#1f6b4a';
        ?>
        .site-body{background:<?php echo $quiz_paper; ?>!important}
        .site-header-shell{background:<?php echo $quiz_paper; ?>;box-shadow:none}
        .site-header{padding:14px 0 12px;background:<?php echo $quiz_paper; ?>}
        .site-title,.site-title span{color:<?php echo $quiz_accent; ?>!important;font-size:1.05rem!important}
        .site-nav,.site-description,.menu-toggle,.scroll-progress,.skip-link{display:none!important}
        .sq-tools{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
        .sq-tools__again[hidden]{display:none!important}
        .sq-tools a,.sq-tools button{flex:1 1 7.5rem;min-height:44px;display:inline-flex;align-items:center;justify-content:center;padding:8px 10px;border:1px solid rgba(31,26,20,.16);border-radius:8px;background:#fff;color:<?php echo $quiz_accent; ?>;font-size:.82rem;font-weight:700;text-decoration:none;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}
        .sq-tools a.sq-tools__btn--science,.sq-tools button.sq-tools__btn--science{color:#fff;background:#1f6b4a;border-color:#1f6b4a}
        .sq-tools a.sq-tools__btn--japanese,.sq-tools button.sq-tools__btn--japanese{color:#fff;background:#9a3b32;border-color:#9a3b32}
        .sq-tools a.sq-tools__btn--info{color:#fff;background:#2563eb;border-color:#2563eb}
        @media(max-width:640px){
            .site-header{padding:10px 0 8px}
            .sq-tools{gap:6px;margin-top:8px}
            .sq-tools a,.sq-tools button{flex:1 1 auto;min-height:36px;padding:6px 8px;font-size:.74rem}
        }
        <?php endif; ?>
    </style>
    
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
                <?php if ( function_exists('mytheme_is_quiz_page') && mytheme_is_quiz_page() && function_exists('mytheme_quiz_tools_nav') ) : ?>
                    <?php mytheme_quiz_tools_nav( is_page('japanese-quiz') ? 'japanese-quiz' : 'science-quiz' ); ?>
                <?php endif; ?>
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
                    <a class="note-cta site-nav__note" href="<?php echo esc_url('https://note.com/k5fujiwara?utm_source=info-study&utm_medium=referral&utm_campaign=nav'); ?>" target="_blank" rel="noopener noreferrer external">note を読む</a>
                </div>
            </div>
        </nav>
    </div>
    
<main id="main-content" class="site-main container" role="main" itemprop="mainContentOfPage">
