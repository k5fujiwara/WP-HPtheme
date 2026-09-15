<?php
if ( ! defined( 'ABSPATH' ) ) exit;

function mytheme_it1_dir(): string {
    return get_template_directory() . '/it1-code-pocket';
}

function mytheme_it1_asset_uri(string $rel = ''): string {
    return get_template_directory_uri() . '/it1-code-pocket/' . ltrim($rel, '/');
}

function mytheme_it1_home_url(): string {
    return home_url('/it1-code-pocket/');
}

function mytheme_it1_page_url(string $slug): string {
    $slug = trim($slug, '/');
    if ( $slug === '' || $slug === 'index' ) {
        return mytheme_it1_home_url();
    }
    return home_url('/it1-code-pocket/' . $slug . '/');
}

function mytheme_is_it1_page(): bool {
    return is_page('it1-code-pocket') || (string) get_query_var('it1_page') !== '';
}

function mytheme_it1_blocked_slugs(): array {
    return ['admin', 'sim-logic'];
}

function mytheme_it1_legal_redirects(): array {
    return [
        'about'    => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('about', home_url('/about/')) : home_url('/about/'),
        'operator' => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('about', home_url('/about/')) : home_url('/about/'),
        'privacy'  => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('privacy-policy', home_url('/privacy-policy/')) : home_url('/privacy-policy/'),
        'contact'  => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('contact', home_url('/contact/')) : home_url('/contact/'),
        'terms'    => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('disclaimer', home_url('/disclaimer/')) : home_url('/disclaimer/'),
    ];
}

function mytheme_ensure_it1_page(): void {
    if ( get_option('mytheme_it1_page_ready') === '1' ) {
        return;
    }
    $existing = get_page_by_path('it1-code-pocket');
    if ( ! $existing ) {
        $page_id = wp_insert_post([
            'post_title'   => '情報Ⅰ 第3問対策',
            'post_name'    => 'it1-code-pocket',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( is_wp_error($page_id) ) {
            return;
        }
    }
    update_option('mytheme_it1_page_ready', '1', false);
}
add_action('init', 'mytheme_ensure_it1_page', 30);

function mytheme_it1_query_vars(array $vars): array {
    $vars[] = 'it1_page';
    return $vars;
}
add_filter('query_vars', 'mytheme_it1_query_vars');

function mytheme_it1_rewrite_rules(): void {
    add_rewrite_rule(
        '^it1-code-pocket/([a-z0-9-]+)/?$',
        'index.php?pagename=it1-code-pocket&it1_page=$matches[1]',
        'top'
    );
    $version = '2';
    if ( get_option('mytheme_it1_rewrite_version') !== $version ) {
        flush_rewrite_rules(false);
        update_option('mytheme_it1_rewrite_version', $version, false);
    }
}
add_action('init', 'mytheme_it1_rewrite_rules', 20);

function mytheme_it1_current_slug(): string {
    $slug = sanitize_title((string) get_query_var('it1_page'));
    return $slug !== '' ? $slug : 'index';
}

function mytheme_it1_hp_config(): array {
    return [
        'quizHome'    => mytheme_it1_home_url(),
        'examples'    => mytheme_it1_page_url('question-examples'),
        'guide'       => mytheme_it1_page_url('study-guide'),
        'about'       => mytheme_it1_legal_redirects()['about'],
        'privacy'     => mytheme_it1_legal_redirects()['privacy'],
        'contact'     => mytheme_it1_legal_redirects()['contact'],
        'disclaimer'  => mytheme_it1_legal_redirects()['terms'],
        'science'     => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('science-quiz', home_url('/science-quiz/')) : home_url('/science-quiz/'),
        'japanese'    => function_exists('mytheme_get_page_url_by_path') ? mytheme_get_page_url_by_path('japanese-quiz', home_url('/japanese-quiz/')) : home_url('/japanese-quiz/'),
        'siteHome'    => home_url('/'),
        'siteName'    => get_bloginfo('name'),
    ];
}

function mytheme_it1_hp_bar_html(): string {
    $hp = mytheme_it1_hp_config();
    return '<div class="it1-hp-bar">'
        . '<a class="it1-hp-bar__brand" href="' . esc_url($hp['siteHome']) . '">' . esc_html($hp['siteName']) . '</a>'
        . '<nav class="it1-hp-bar__nav" aria-label="学習ツール">'
        . '<a class="it1-hp-bar__btn it1-hp-bar__btn--science" href="' . esc_url($hp['science']) . '">理科クイズへ</a>'
        . '<a class="it1-hp-bar__btn it1-hp-bar__btn--japanese" href="' . esc_url($hp['japanese']) . '">国語クイズへ</a>'
        . '<a class="it1-hp-bar__btn" href="' . esc_url($hp['siteHome']) . '">トップに戻る</a>'
        . '</nav></div>';
}

function mytheme_it1_hp_bar_css(): string {
    return '<style>
:root{--it1-hp-h:52px}
@media(max-width:720px){:root{--it1-hp-h:96px}}
.it1-hp-bar{position:fixed;top:0;left:0;right:0;z-index:70;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:8px 12px;padding:8px 16px;background:#fff;border-bottom:1px solid #e2e8f0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Noto Sans JP",sans-serif}
.it1-hp-bar__brand{font-weight:800;color:#0f62fe;text-decoration:none;font-size:.95rem}
.it1-hp-bar__nav{display:flex;flex-wrap:wrap;gap:8px}
.it1-hp-bar__btn{display:inline-flex;align-items:center;justify-content:center;min-height:36px;padding:6px 10px;border-radius:8px;border:1px solid #d0d5dd;background:#fff;color:#0f62fe;font-size:.8rem;font-weight:700;text-decoration:none}
.it1-hp-bar__btn--science{color:#fff;background:#1f6b4a;border-color:#1f6b4a}
.it1-hp-bar__btn--japanese{color:#fff;background:#9a3b32;border-color:#9a3b32}
body .themed-header{top:var(--it1-hp-h)!important}
body .themed-header+main{padding-top:calc(var(--header-total-height) + var(--it1-hp-h) + 1rem)!important}
body.is-quiz-screen .quiz-progress{top:calc(var(--header-total-height) + var(--it1-hp-h))!important}
.it1-ad--bottom{margin:20px 0 0}
.it1-ad--bottom:not(.is-filled){margin:0;min-height:0}
.it1-ad--bottom:not(.is-filled) .adsbygoogle{min-height:0;display:none}
@media(max-width:1099px){
body.has-it1-bottom-ad{padding-bottom:128px}
.it1-ad--bottom.is-filled{position:fixed;left:0;right:0;bottom:0;z-index:90;margin:0;padding:8px 12px 12px;background:var(--bg,#fff);box-shadow:0 -10px 16px var(--bg,#fff)}
}
</style>';
}

function mytheme_it1_rewrite_html_links(string $html): string {
    $legal = mytheme_it1_legal_redirects();
    return (string) preg_replace_callback(
        '#\b(href|content|src)="(?:\./)?([a-z0-9-]+)\.html(\#[^"]*)?"#i',
        static function (array $m) use ($legal): string {
            $slug = strtolower($m[2]);
            $hash = $m[3] ?? '';
            if ( isset($legal[$slug]) ) {
                return $m[1] . '="' . esc_url($legal[$slug] . $hash) . '"';
            }
            if ( in_array($slug, mytheme_it1_blocked_slugs(), true) ) {
                return $m[1] . '="' . esc_url(mytheme_it1_home_url()) . '"';
            }
            return $m[1] . '="' . esc_url(mytheme_it1_page_url($slug) . $hash) . '"';
        },
        $html
    );
}

function mytheme_it1_rewrite_assets(string $html): string {
    $base = trailingslashit(mytheme_it1_asset_uri());
    $html = preg_replace('#\b(href|src)="((?:css|js|assets)/[^"]+)"#', '$1="' . $base . '$2"', $html);
    $html = str_replace('href="site.webmanifest"', 'href="' . esc_url($base . 'site.webmanifest') . '"', $html);
    return $html;
}

function mytheme_it1_rewrite_canonical(string $html, string $slug): string {
    $page_url = mytheme_it1_page_url($slug);
    $og_image = mytheme_it1_asset_uri('assets/ogp-card.png');
    if ( ! file_exists(mytheme_it1_dir() . '/assets/ogp-card.png') && function_exists('mytheme_seo_default_image_url') ) {
        $og_image = mytheme_seo_default_image_url();
    }
    $legal = mytheme_it1_legal_redirects();
    $html = (string) preg_replace_callback(
        '#https://it1-code-pocket\.com/([a-z0-9.-]+\.html)?#i',
        static function (array $m) use ($legal): string {
            if ( empty($m[1]) ) {
                return mytheme_it1_home_url();
            }
            $file = strtolower($m[1]);
            $name = preg_replace('/\.html$/', '', $file);
            if ( isset($legal[$name]) ) {
                return $legal[$name];
            }
            return mytheme_it1_page_url($name);
        },
        $html
    );
    $html = preg_replace('#<link rel="canonical" href="[^"]*"#', '<link rel="canonical" href="' . esc_url($page_url) . '"', $html);
    $html = preg_replace('#property="og:url" content="[^"]*"#', 'property="og:url" content="' . esc_url($page_url) . '"', $html);
    $html = preg_replace('#property="og:image" content="[^"]*"#', 'property="og:image" content="' . esc_url($og_image) . '"', $html);
    $html = preg_replace('#name="twitter:image" content="[^"]*"#', 'name="twitter:image" content="' . esc_url($og_image) . '"', $html);
    return $html;
}

function mytheme_it1_disable_canonical_redirect($redirect_url, $requested_url) {
    unset($requested_url);
    if ( get_query_var('it1_page') || ( is_page('it1-code-pocket') && get_query_var('it1_page') !== '' ) ) {
        return false;
    }
    if ( is_page('it1-code-pocket') ) {
        return false;
    }
    return $redirect_url;
}
add_filter('redirect_canonical', 'mytheme_it1_disable_canonical_redirect', 10, 2);

function mytheme_it1_bottom_ad_html(): string {
    return '<div class="it1-ad it1-ad--bottom" data-it1-ad>'
        . '<ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-6924336257757707" data-ad-format="horizontal" data-full-width-responsive="true"></ins>'
        . '</div>'
        . '<script>'
        . '(function(){function mark(){var box=document.querySelector("[data-it1-ad]");if(!box)return;var iframe=box.querySelector("iframe");var filled=!!(iframe&&iframe.offsetHeight>40);box.classList.toggle("is-filled",filled);document.body.classList.toggle("has-it1-bottom-ad",filled);}'
        . 'function request(){var box=document.querySelector("[data-it1-ad]");if(!box)return;var ins=box.querySelector("ins.adsbygoogle");if(!ins||ins.getAttribute("data-adsbygoogle-status")){mark();return;}try{(window.adsbygoogle=window.adsbygoogle||[]).push({});}catch(e){}[400,1200,3000,6000].forEach(function(ms){setTimeout(mark,ms);});}'
        . 'if(document.readyState==="complete")request();else window.addEventListener("load",request);})();'
        . '</script>';
}

function mytheme_it1_inject_chrome(string $html): string {
    $hp = mytheme_it1_hp_config();
    $config = '<script>window.IT1_HP=' . wp_json_encode($hp) . ';</script>';
    $inject_head = mytheme_it1_hp_bar_css() . $config;
    $html = preg_replace(
        '#<script[^>]*adsbygoogle\.js\?client=[^>]*>\s*</script>#is',
        '$0<script>(window.adsbygoogle=window.adsbygoogle||[]).push({overlays:{bottom:false}});</script>',
        $html,
        1
    );
    $html = str_replace('</head>', $inject_head . '</head>', $html);
    $html = preg_replace('/<body([^>]*)>/', '<body$1>' . mytheme_it1_hp_bar_html(), $html, 1);
    if ( strpos($html, '</body>') !== false ) {
        $html = str_replace('</body>', mytheme_it1_bottom_ad_html() . '</body>', $html);
    } else {
        $html .= mytheme_it1_bottom_ad_html();
    }
    return $html;
}

function mytheme_it1_transform_footer(string $html): string {
    $hp = mytheme_it1_hp_config();
    $nav = '<nav class="site-footer-links" aria-label="サイト情報">'
        . '<a href="' . esc_url($hp['examples']) . '">問題例と解き方</a>'
        . '<a href="' . esc_url($hp['guide']) . '">学習ガイド</a>'
        . '<a href="' . esc_url($hp['about']) . '">このサイトについて</a>'
        . '<a href="' . esc_url($hp['privacy']) . '">プライバシーポリシー</a>'
        . '<a href="' . esc_url($hp['contact']) . '">お問い合わせ</a>'
        . '<a href="' . esc_url($hp['disclaimer']) . '">利用規約・免責事項</a>'
        . '</nav>';
    $html = preg_replace('#<nav class="site-footer-links"[\s\S]*?</nav>#', $nav, $html, 1);
    $home = mytheme_it1_home_url();
    $html = str_replace('https://it1-code-pocket.com/', $home, $html);
    $html = str_replace('https%3A%2F%2Fit1-code-pocket.com%2F', rawurlencode($home), $html);
    return $html;
}

function mytheme_it1_output(): void {
    $slug = mytheme_it1_current_slug();
    $legal = mytheme_it1_legal_redirects();
    if ( isset($legal[$slug]) ) {
        wp_safe_redirect($legal[$slug], 301);
        exit;
    }
    if ( in_array($slug, mytheme_it1_blocked_slugs(), true) ) {
        wp_safe_redirect(mytheme_it1_home_url(), 302);
        exit;
    }

    $file = $slug === 'index' ? 'index.html' : $slug . '.html';
    $path = mytheme_it1_dir() . '/' . $file;
    if ( ! is_readable($path) ) {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        nocache_headers();
        include get_query_template('404');
        exit;
    }

    $html = (string) file_get_contents($path);
    $html = mytheme_it1_rewrite_assets($html);
    $html = mytheme_it1_rewrite_html_links($html);
    $html = mytheme_it1_rewrite_canonical($html, $slug);
    $html = mytheme_it1_transform_footer($html);
    $html = mytheme_it1_inject_chrome($html);

    status_header(200);
    header('Content-Type: text/html; charset=UTF-8');
    echo $html;
    exit;
}
