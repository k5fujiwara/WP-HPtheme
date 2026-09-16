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

function mytheme_it1_page_aliases(): array {
    return [
        'settings' => 'design',
    ];
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
        'year'        => (string) date('Y'),
    ];
}

function mytheme_it1_hp_bar_html(): string {
    $hp = mytheme_it1_hp_config();
    return '<div class="it1-hp-head">'
        . '<a class="it1-hp-head__site" href="' . esc_url($hp['siteHome']) . '">' . esc_html($hp['siteName']) . '</a>'
        . '<a class="it1-hp-head__tool" href="' . esc_url($hp['quizHome']) . '">IT1-CODE-POCKET</a>'
        . '</div>'
        . '<nav class="it1-hp-tools" aria-label="学習ツール">'
        . '<a class="it1-hp-tools__btn it1-hp-tools__btn--science" href="' . esc_url($hp['science']) . '">理科クイズへ</a>'
        . '<a class="it1-hp-tools__btn it1-hp-tools__btn--japanese" href="' . esc_url($hp['japanese']) . '">国語クイズへ</a>'
        . '<a class="it1-hp-tools__btn" href="' . esc_url($hp['siteHome']) . '">トップに戻る</a>'
        . '</nav>';
}

function mytheme_it1_hp_bar_css(): string {
    return '<style>
html{background:#fff!important}
html,body{margin:0!important}
body{--header-bg:#fff!important;--header-text:#1e3a5f!important}
body .themed-header{position:fixed!important;top:0!important;left:0!important;right:0!important;z-index:70;display:flex!important;flex-flow:row wrap!important;align-items:center!important;justify-content:flex-start!important;gap:8px 10px!important;width:100%!important;min-height:0!important;padding:8px 14px!important;padding-top:max(8px,env(safe-area-inset-top,0px))!important;background:#fff!important;background-image:none!important;background-clip:border-box!important;color:#1e3a5f!important;border:0!important;outline:0!important;box-shadow:0 -24px 0 0 #fff,0 1px 0 0 #e2e8f0!important;transform:translateZ(0);isolation:isolate;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI","Noto Sans JP",sans-serif}
body .themed-header::before,body .themed-header::after{content:none!important;display:none!important}
body .themed-header+main{padding-top:calc(4.25rem + env(safe-area-inset-top,0px))!important}
body.is-quiz-screen .quiz-progress{position:relative!important;top:auto!important}
.themed-header .header-brand{display:contents!important}
.themed-header .app-title{display:none!important}
.it1-hp-head{order:1;display:flex;flex-direction:column;justify-content:center;align-items:flex-start;gap:1px;min-width:0;flex:0 1 auto;max-width:min(100%,22rem);line-height:1.2}
.it1-hp-head__site{display:inline-block;max-width:100%;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:.68rem;font-weight:700;color:#64748b;text-decoration:none}
.it1-hp-head__tool{display:inline-block;font-size:.95rem;font-weight:800;color:#0f62fe;letter-spacing:.02em;text-decoration:none;white-space:nowrap}
.it1-hp-tools{order:2;display:flex!important;flex-wrap:wrap;align-items:center;justify-content:flex-end;gap:6px;margin-left:auto}
.themed-header .header-back-btn{order:0;flex:0 0 auto;width:32px;height:32px;min-height:32px;padding:0;border-radius:8px;border:1px solid rgba(31,26,20,.16);background:#fff;color:#2563eb}
.themed-header .header-back-btn::before{margin:0}
.themed-header .it1-hp-tools__btn{flex:0 0 auto!important;width:auto!important;min-width:0;min-height:32px;display:inline-flex!important;align-items:center;justify-content:center;padding:5px 11px;border-radius:8px;border:1px solid rgba(31,26,20,.16)!important;background:#fff!important;color:#2563eb!important;font-size:.75rem;font-weight:700;line-height:1.2;text-decoration:none;white-space:nowrap}
.themed-header .it1-hp-tools__btn--science{color:#fff!important;background:#1f6b4a!important;border-color:#1f6b4a!important}
.themed-header .it1-hp-tools__btn--japanese{color:#fff!important;background:#9a3b32!important;border-color:#9a3b32!important}
.it1-ad--bottom{margin:20px auto 0;max-width:48rem;width:calc(100% - 2rem);display:flex;justify-content:center;text-align:center}
.it1-ad--bottom .adsbygoogle{width:100%;max-width:100%}
.it1-ad--bottom:not(.is-filled){margin:0;min-height:0;width:auto}
.it1-ad--bottom:not(.is-filled) .adsbygoogle{min-height:0;display:none}
@media(max-width:1099px){
body.has-it1-bottom-ad{padding-bottom:128px}
.it1-ad--bottom.is-filled{position:fixed;left:0;right:0;bottom:0;z-index:90;margin:0;max-width:none;width:auto;display:block;padding:8px 12px 12px;background:var(--bg,#fff);box-shadow:0 -10px 16px var(--bg,#fff)}
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

function mytheme_it1_skip_ads(string $slug): bool {
    return $slug === 'design';
}

function mytheme_it1_public_slugs(): array {
    $skip = array_merge(
        mytheme_it1_blocked_slugs(),
        array_keys(mytheme_it1_legal_redirects()),
        array_keys(mytheme_it1_page_aliases())
    );
    $slugs = ['index'];
    foreach ( glob(mytheme_it1_dir() . '/*.html') as $file ) {
        $name = basename($file, '.html');
        if ( $name === 'index' || in_array($name, $skip, true) ) {
            continue;
        }
        $slugs[] = $name;
    }
    sort($slugs);
    return $slugs;
}

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

function mytheme_it1_inject_chrome(string $html, string $slug = 'index'): string {
    $hp = mytheme_it1_hp_config();
    $config = '<script>window.IT1_HP=' . wp_json_encode($hp) . ';</script>';
    $theme_color = '<meta name="theme-color" content="#ffffff">';
    $inject_head = $theme_color . mytheme_it1_hp_bar_css() . $config;
    if ( mytheme_it1_skip_ads($slug) ) {
        $html = preg_replace('#<script[^>]*adsbygoogle\.js\?client=[^>]*>\s*</script>#is', '', $html, 1);
    } else {
        $html = preg_replace(
            '#<script[^>]*adsbygoogle\.js\?client=[^>]*>\s*</script>#is',
            '$0<script>(window.adsbygoogle=window.adsbygoogle||[]).push({overlays:{bottom:false}});</script>',
            $html,
            1
        );
    }
    $html = str_replace('</head>', $inject_head . '</head>', $html);
    $replaced = 0;
    $html = preg_replace(
        '/(<header\b[^>]*class="[^"]*\bthemed-header\b[^"]*"[^>]*>)/i',
        '$1' . mytheme_it1_hp_bar_html(),
        $html,
        1,
        $replaced
    );
    if ( ! $replaced ) {
        $html = preg_replace('/<body([^>]*)>/', '<body$1>' . mytheme_it1_hp_bar_html(), $html, 1);
    }
    if ( ! mytheme_it1_skip_ads($slug) ) {
        if ( strpos($html, '</body>') !== false ) {
            $html = str_replace('</body>', mytheme_it1_bottom_ad_html() . '</body>', $html);
        } else {
            $html .= mytheme_it1_bottom_ad_html();
        }
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
    $copy = '© ' . esc_html($hp['year']) . ' ' . esc_html($hp['siteName']);
    $html = preg_replace('#<p class="site-footer-copy">.*?</p>#', '<p class="site-footer-copy">' . $copy . '</p>', $html, 1);
    $home = mytheme_it1_home_url();
    $html = str_replace('https://it1-code-pocket.com/', $home, $html);
    $html = str_replace('https%3A%2F%2Fit1-code-pocket.com%2F', rawurlencode($home), $html);
    return $html;
}

function mytheme_it1_output(): void {
    $slug = mytheme_it1_current_slug();
    $aliases = mytheme_it1_page_aliases();
    if ( isset($aliases[$slug]) ) {
        wp_safe_redirect(mytheme_it1_page_url($aliases[$slug]), 301);
        exit;
    }
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
    $html = mytheme_it1_inject_chrome($html, $slug);

    status_header(200);
    header('Content-Type: text/html; charset=UTF-8');
    echo $html;
    exit;
}

function mytheme_it1_register_sitemap(): void {
    if ( ! function_exists('wp_register_sitemap_provider') || ! class_exists('WP_Sitemaps_Provider') ) {
        return;
    }
    wp_register_sitemap_provider('it1', new class extends WP_Sitemaps_Provider {
        public function __construct() {
            $this->name        = 'it1';
            $this->object_type = 'it1';
        }

        public function get_url_list( $page_num, $object_subtype = '' ) {
            unset($page_num, $object_subtype);
            $entries = [];
            foreach ( mytheme_it1_public_slugs() as $slug ) {
                $entries[] = [
                    'loc' => mytheme_it1_page_url($slug),
                ];
            }
            return $entries;
        }

        public function get_max_num_pages( $object_subtype = '' ) {
            unset($object_subtype);
            return 1;
        }
    });
}
add_action('init', 'mytheme_it1_register_sitemap', 110);
