<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * SNSシェアボタンを表示（コンテンツ内用）
 */
function mytheme_sns_share_buttons() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    // X (Twitter)のシェアURL
    $twitter_url = 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title;
    
    // Facebookのシェアurl
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
    
    // LINEのシェアURL
    $line_url = 'https://social-plugins.line.me/lineit/share?url=' . $url;
    
    ?>
    <div class="sns-share">
        <span class="sns-share-label">シェア：</span>
        <div class="sns-share-buttons">
            <a href="<?php echo esc_url($twitter_url); ?>" 
               class="sns-share-btn twitter" 
               target="_blank" 
               rel="noopener noreferrer"
               aria-label="Xでシェア">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
            
            <a href="<?php echo esc_url($facebook_url); ?>" 
               class="sns-share-btn facebook" 
               target="_blank" 
               rel="noopener noreferrer"
               aria-label="Facebookでシェア">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
            
            <a href="<?php echo esc_url($line_url); ?>" 
               class="sns-share-btn line" 
               target="_blank" 
               rel="noopener noreferrer"
               aria-label="LINEでシェア">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/>
                </svg>
            </a>
        </div>
    </div>
    <?php
}

/**
 * ヘッダーメニュー用のSNSシェアドロップダウンを表示
 */
function mytheme_header_sns_share_menu() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    // X (Twitter)のシェアURL
    $twitter_url = 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title;
    
    // Facebookのシェアurl
    $facebook_url = 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
    
    // LINEのシェアURL
    $line_url = 'https://social-plugins.line.me/lineit/share?url=' . $url;
    
    echo '<div class="sns-share-menu-wrapper">' .
         '<button class="sns-share-menu-toggle" aria-expanded="false" aria-label="シェアする">' .
         '<svg class="sns-share-menu-toggle__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' .
         '<circle cx="18" cy="5" r="3"></circle>' .
         '<circle cx="6" cy="12" r="3"></circle>' .
         '<circle cx="18" cy="19" r="3"></circle>' .
         '<line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>' .
         '<line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>' .
         '</svg>' .
         '<span>シェアする</span>' .
         '</button>' .
         '<div class="sns-share-dropdown">' .
         '<a href="' . esc_url($twitter_url) . '" class="sns-share-dropdown-item twitter" target="_blank" rel="noopener noreferrer">' .
         '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">' .
         '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>' .
         '</svg>' .
         '<span class="sns-share-dropdown-item__text">X (Twitter)</span>' .
         '</a>' .
         '<a href="' . esc_url($facebook_url) . '" class="sns-share-dropdown-item facebook" target="_blank" rel="noopener noreferrer">' .
         '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">' .
         '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>' .
         '</svg>' .
         '<span class="sns-share-dropdown-item__text">Facebook</span>' .
         '</a>' .
         '<a href="' . esc_url($line_url) . '" class="sns-share-dropdown-item line" target="_blank" rel="noopener noreferrer">' .
         '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">' .
         '<path d="M19.365 9.863c.349 0 .63.285.63.631 0 .345-.281.63-.63.63H17.61v1.125h1.755c.349 0 .63.283.63.63 0 .344-.281.629-.63.629h-2.386c-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63h2.386c.346 0 .627.285.627.63 0 .349-.281.63-.63.63H17.61v1.125h1.755zm-3.855 3.016c0 .27-.174.51-.432.596-.064.021-.133.031-.199.031-.211 0-.391-.09-.51-.25l-2.443-3.317v2.94c0 .344-.279.629-.631.629-.346 0-.626-.285-.626-.629V8.108c0-.27.173-.51.43-.595.06-.023.136-.033.194-.033.195 0 .375.104.495.254l2.462 3.33V8.108c0-.345.282-.63.63-.63.345 0 .63.285.63.63v4.771zm-5.741 0c0 .344-.282.629-.631.629-.345 0-.627-.285-.627-.629V8.108c0-.345.282-.63.63-.63.346 0 .628.285.628.63v4.771zm-2.466.629H4.917c-.345 0-.63-.285-.63-.629V8.108c0-.345.285-.63.63-.63.348 0 .63.285.63.63v4.141h1.756c.348 0 .629.283.629.63 0 .344-.282.629-.629.629M24 10.314C24 4.943 18.615.572 12 .572S0 4.943 0 10.314c0 4.811 4.27 8.842 10.035 9.608.391.082.923.258 1.058.59.12.301.079.766.038 1.08l-.164 1.02c-.045.301-.24 1.186 1.049.645 1.291-.539 6.916-4.078 9.436-6.975C23.176 14.393 24 12.458 24 10.314"/>' .
         '</svg>' .
         '<span class="sns-share-dropdown-item__text">LINE</span>' .
         '</a>' .
         '</div>' .
         '</div>';
}

/**
 * ヘッダー用の汎用ドロップダウンメニューを表示
 */
function mytheme_render_header_dropdown_menu($args = []) {
    $defaults = [
        'label'          => '',
        'aria_label'     => '',
        'items'          => [],
        'wrapper_class'  => '',
        'button_class'   => '',
        'is_current'     => false,
    ];
    $args = wp_parse_args($args, $defaults);

    $label = trim((string) $args['label']);
    $items = is_array($args['items']) ? $args['items'] : [];
    if ( $label === '' || empty($items) ) {
        return;
    }

    $wrapper_classes = ['sns-share-menu-wrapper', 'site-nav__dropdown'];
    if ( $args['wrapper_class'] !== '' ) {
        $wrapper_classes[] = (string) $args['wrapper_class'];
    }
    if ( ! empty($args['is_current']) ) {
        $wrapper_classes[] = 'site-nav__dropdown--current';
    }

    $button_classes = ['sns-share-menu-toggle', 'site-nav__action-toggle'];
    if ( $args['button_class'] !== '' ) {
        $button_classes[] = (string) $args['button_class'];
    }

    echo '<div class="' . esc_attr(implode(' ', $wrapper_classes)) . '">';
    echo '<button type="button" class="' . esc_attr(implode(' ', $button_classes)) . '" aria-expanded="false" aria-label="' . esc_attr((string) ($args['aria_label'] ?: $label . 'メニュー')) . '">';
    echo '<span>' . esc_html($label) . '</span>';
    echo '<svg class="site-nav__action-caret" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>';
    echo '</button>';
    echo '<div class="sns-share-dropdown site-nav__dropdown-panel">';

    foreach ( $items as $item ) {
        $item_label = isset($item['label']) ? trim((string) $item['label']) : '';
        $item_url = isset($item['url']) ? (string) $item['url'] : '';
        if ( $item_label === '' || $item_url === '' ) {
            continue;
        }

        $item_classes = ['sns-share-dropdown-item', 'site-nav__dropdown-item'];
        if ( ! empty($item['is_external']) ) {
            $item_classes[] = 'site-nav__dropdown-item--external';
        }
        if ( ! empty($item['is_current']) ) {
            $item_classes[] = 'site-nav__dropdown-item--current';
        }

        $target = ! empty($item['is_external']) ? ' target="_blank"' : '';
        $rel = ! empty($item['is_external']) ? ' rel="noopener noreferrer external"' : '';

        echo '<a href="' . esc_url($item_url) . '" class="' . esc_attr(implode(' ', $item_classes)) . '"' . $target . $rel . '>';
        echo '<span class="sns-share-dropdown-item__text">' . esc_html($item_label) . '</span>';
        echo '</a>';
    }

    echo '</div></div>';
}

/**
 * ヘッダー（ナビ）に「SNS」ドロップダウンを表示（アカウントへのリンク）
 */
function mytheme_header_sns_links_menu() {
    $links = [
        [
            'key'   => 'twitter',
            'label' => 'X (Twitter)',
            'url'   => 'https://x.com/K5_jukukoshi',
            'icon'  => '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
        ],
        [
            'key'   => 'instagram',
            'label' => 'Instagram',
            'url'   => 'https://www.instagram.com/k5_jukukoshi/',
            'icon'  => '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5zm6.25-2.6a1.1 1.1 0 1 1-1.1-1.1 1.1 1.1 0 0 1 1.1 1.1z"/></svg>',
        ],
        [
            'key'   => 'threads',
            'label' => 'Threads',
            'url'   => 'https://www.threads.com/@k5_jukukoshi',
            'icon'  => '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 12a4 4 0 1 0-8 0 4 4 0 0 0 8 0z"/><path d="M16 12v1.5a2.5 2.5 0 0 0 5 0V12a9 9 0 1 0-9 9h4"/></svg>',
        ],
        [
            'key'   => 'facebook',
            'label' => 'Facebook',
            'url'   => 'https://www.facebook.com/profile.php?id=100067108881612',
            'icon'  => '<svg class="sns-share-dropdown-item__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.56 9.87v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.88h-2.34v6.99A10 10 0 0 0 22 12z"/></svg>',
        ],
    ];

    echo '<div class="sns-share-menu-wrapper sns-links-menu-wrapper">' .
         '<button class="sns-share-menu-toggle sns-links-menu-toggle" aria-expanded="false" aria-label="SNSメニュー">' .
         // アカウント/フォロー系のアイコン（シェア用と区別）
         '<svg class="sns-share-menu-toggle__icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' .
         '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>' .
         '<circle cx="12" cy="7" r="4"></circle>' .
         '</svg>' .
         '<span>SNS</span>' .
         '</button>' .
         '<div class="sns-share-dropdown">';

    foreach ( $links as $l ) {
        $key = $l['key'];
        $url = $l['url'];
        $label = $l['label'];
        $icon = $l['icon'];
        echo '<a href="' . esc_url($url) . '" class="sns-share-dropdown-item ' . esc_attr($key) . '" target="_blank" rel="noopener noreferrer">' .
             $icon .
             '<span class="sns-share-dropdown-item__text">' . esc_html($label) . '</span>' .
             '</a>';
    }

    echo '</div></div>';
}

/**
 * ヘッダー（ナビ）に「更新情報」ドロップダウンを表示
 */
function mytheme_header_updates_menu() {
    $news_url = function_exists('get_post_type_archive_link')
        ? get_post_type_archive_link('news')
        : '';
    if ( ! $news_url ) {
        $news_url = home_url('/news/');
    }

    $beengineer_url = function_exists('get_post_type_archive_link')
        ? get_post_type_archive_link('beengineer-news')
        : '';
    if ( ! $beengineer_url ) {
        $beengineer_url = home_url('/beengineer-news/');
    }

    mytheme_render_header_dropdown_menu([
        'label'      => '更新情報',
        'aria_label' => '更新情報メニュー',
        'is_current' => is_post_type_archive('news') || is_singular('news') || is_post_type_archive('beengineer-news') || is_singular('beengineer-news'),
        'items'      => [
            [
                'label'      => 'お知らせ',
                'url'        => $news_url,
                'is_current' => is_post_type_archive('news') || is_singular('news'),
            ],
            [
                'label'      => 'BeEngineer通信',
                'url'        => $beengineer_url,
                'is_current' => is_post_type_archive('beengineer-news') || is_singular('beengineer-news'),
            ],
        ],
    ]);
}

/**
 * ヘッダー（ナビ）に「発信」ドロップダウンを表示
 */
function mytheme_header_channels_menu() {
    mytheme_render_header_dropdown_menu([
        'label'      => '発信',
        'aria_label' => '外部発信メニュー',
        'items'      => [
            [
                'label'       => 'note',
                'url'         => 'https://note.com/k5fujiwara',
                'is_external' => true,
            ],
            [
                'label'       => 'YouTube',
                'url'         => 'https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw',
                'is_external' => true,
            ],
        ],
    ]);
}
