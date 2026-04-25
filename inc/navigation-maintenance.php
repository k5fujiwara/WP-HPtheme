<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 表示用プライマリメニュー項目を一元管理
 */
function mytheme_get_primary_menu_items() {
    $learning_column_url = function_exists('mytheme_get_page_url_by_path')
        ? mytheme_get_page_url_by_path('learning-column', home_url('/learning-column/'))
        : home_url('/learning-column/');
    $works_url = function_exists('mytheme_get_page_url_by_path')
        ? mytheme_get_page_url_by_path('works', home_url('/works/'))
        : home_url('/works/');
    $about_url = function_exists('mytheme_get_page_url_by_path')
        ? mytheme_get_page_url_by_path('about', home_url('/about/'))
        : home_url('/about/');
    $ebooks_url = function_exists('mytheme_get_page_url_by_path')
        ? mytheme_get_page_url_by_path('ebooks', home_url('/ebooks/'))
        : home_url('/ebooks/');

    return [
        [
            'label' => 'ホーム',
            'url'   => home_url('/'),
        ],
        [
            'label' => '学習コラム',
            'url'   => $learning_column_url,
        ],
        [
            'label' => '開発作品',
            'url'   => $works_url,
        ],
        [
            'label' => '電子書籍',
            'url'   => $ebooks_url,
        ],
        [
            'label' => '自己紹介',
            'url'   => $about_url,
        ],
    ];
}

/**
 * 固定ページ配下も含めて現在位置か判定
 */
function mytheme_is_current_page_tree($path) {
    $path = trim((string) $path, '/');
    if ( $path === '' || ! is_page() ) {
        return false;
    }

    $page = function_exists('mytheme_get_page_by_path_cached')
        ? mytheme_get_page_by_path_cached($path)
        : get_page_by_path($path);
    if ( ! $page || empty($page->ID) ) {
        return false;
    }

    $current_id = (int) get_queried_object_id();
    $target_id  = (int) $page->ID;
    if ( $current_id === $target_id ) {
        return true;
    }

    $ancestors = get_post_ancestors($current_id);
    return is_array($ancestors) && in_array($target_id, array_map('intval', $ancestors), true);
}

/**
 * プライマリメニュー項目が現在地か判定
 */
function mytheme_is_primary_menu_item_current(string $label): bool {
    if ( $label === 'ホーム' ) {
        return is_front_page();
    }

    if ( $label === '学習コラム' ) {
        if ( is_front_page() ) {
            return false;
        }

        return is_page('learning-column') || is_home() || is_singular('post') || is_search() || is_category() || is_tag() || is_tax();
    }

    if ( $label === '開発作品' ) {
        return mytheme_is_current_page_tree('works');
    }

    if ( $label === '電子書籍' ) {
        return mytheme_is_current_page_tree('ebooks');
    }

    if ( $label === '自己紹介' ) {
        return mytheme_is_current_page_tree('about');
    }

    return false;
}

/**
 * primary メニューに実アイテムがあるか判定
 */
function mytheme_primary_menu_has_items() {
    $locations = get_nav_menu_locations();
    if ( ! is_array($locations) ) {
        return false;
    }

    $menu_id = isset($locations['primary']) ? (int) $locations['primary'] : 0;
    if ( $menu_id <= 0 ) {
        return false;
    }

    $items = wp_get_nav_menu_items($menu_id);
    return is_array($items) && ! empty($items);
}

/**
 * primary メニューのフォールバック描画
 */
function mytheme_primary_menu_fallback($args = []) {
    $defaults = [
        'menu_id'    => 'primary-menu',
        'menu_class' => 'site-nav__menu',
    ];
    $args = wp_parse_args($args, $defaults);

    $menu_items = mytheme_get_primary_menu_items();
    if ( empty($menu_items) ) {
        return;
    }

    echo '<ul id="' . esc_attr((string) $args['menu_id']) . '" class="' . esc_attr((string) $args['menu_class']) . '">';
    foreach ( $menu_items as $it ) {
        if ( ! isset($it['label'], $it['url']) ) {
            continue;
        }

        $classes = ['menu-item', 'site-nav__item'];
        $url = (string) $it['url'];
        $label = (string) $it['label'];
        $is_current = mytheme_is_primary_menu_item_current($label);

        if ( $is_current ) {
            $classes[] = 'current-menu-item';
            $classes[] = 'site-nav__item--current';
        }

        echo '<li class="' . esc_attr(implode(' ', $classes)) . '">';
        echo '<a class="site-nav__link" href="' . esc_url($url) . '"' . ( $is_current ? ' aria-current="page"' : '' ) . '>' . esc_html($label) . '</a>';
        echo '</li>';
    }
    echo '</ul>';
}

/**
 * primary メニューを描画
 */
function mytheme_render_primary_menu() {
    if ( mytheme_primary_menu_has_items() ) {
        wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'menu_id'        => 'primary-menu',
            'menu_class'     => 'site-nav__menu',
            'fallback_cb'    => 'mytheme_primary_menu_fallback',
        ]);
        return;
    }

    mytheme_primary_menu_fallback([
        'menu_id'    => 'primary-menu',
        'menu_class' => 'site-nav__menu',
    ]);
}

/**
 * primary メニューの重複項目を表示時に除去
 *
 * 管理画面の実メニューに旧項目が残っていても、
 * フロントでは同名・同URLの重複を出さない。
 */
function mytheme_dedupe_primary_menu_items($items, $args) {
    if ( ! isset($args->theme_location) || $args->theme_location !== 'primary' ) {
        return $items;
    }
    if ( ! is_array($items) || empty($items) ) {
        return $items;
    }

    $seen = [];
    $deduped = [];

    foreach ( $items as $item ) {
        $title = isset($item->title) ? trim(wp_strip_all_tags((string) $item->title)) : '';
        $url   = isset($item->url) ? rtrim((string) $item->url, '/') : '';
        $key   = strtolower($title) . '|' . strtolower($url);

        if ( $title !== '' && isset($seen[$key]) ) {
            continue;
        }

        $seen[$key] = true;
        $deduped[] = $item;
    }

    return $deduped;
}
add_filter('wp_nav_menu_objects', 'mytheme_dedupe_primary_menu_items', 20, 2);

/**
 * プライマリメニューを必要最小限に整備（冪等）
 * - 外部誘導（YouTube/note 等）をナビから排除し、情報メディアとしての導線に絞る
 * - ホーム / 学習コラム / 開発作品 / 電子書籍 / 自己紹介
 */
function mytheme_ensure_primary_menu_links() {
    $sync_key = 'mytheme_primary_menu_links_done_v2';
    // Gutenberg/REST中に走ると遅延やエラーの原因になるため、管理画面でのみ実行
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( ! is_admin() ) return;
    if ( ! current_user_can('edit_theme_options') ) return;
    // 何度も走らせない（重い処理＋DB更新を含むため）
    if ( get_transient($sync_key) ) return;
    set_transient($sync_key, 1, 12 * HOUR_IN_SECONDS);

    // メニューの存在を確保
    $menu_id = mytheme_get_or_create_primary_menu_id();
    if ( ! $menu_id ) return;

    // 既存アイテム収集
    $items = wp_get_nav_menu_items($menu_id);

    // 不要なメニュー（外部誘導/重複しやすい旧導線）を削除
    if ( $items && ! is_wp_error($items) ) {
        $remove_urls = [
            'https://note.com/k5fujiwara',
            'https://www.youtube.com/channel/UCp0Bt81y7Dd5uuXNOaErNkw',
            'https://www.youtube.com/@KoshiK5',
        ];
        $managed_titles = ['ホーム', '学習コラム', 'お知らせ', '辞書一覧', '電子書籍', '自己紹介', 'お問い合わせ', '開発作品'];

        $remove_object_ids = [];
        $ebooks_page = mytheme_get_page_by_path_cached('ebooks');
        if ( $ebooks_page ) $remove_object_ids[] = (int) $ebooks_page->ID;
        $works_page = mytheme_get_page_by_path_cached('works');
        if ( $works_page ) $remove_object_ids[] = (int) $works_page->ID;

        foreach ( $items as $it ) {
            $url = isset($it->url) ? (string) $it->url : '';
            $url = rtrim($url, '/');
            $obj = isset($it->object_id) ? (int) $it->object_id : 0;
            $title = isset($it->title) ? trim((string) $it->title) : '';

            $should_remove = false;
            foreach ( $remove_urls as $ru ) {
                if ( $url !== '' && $url === rtrim((string) $ru, '/') ) {
                    $should_remove = true;
                    break;
                }
            }
            if ( ! $should_remove && $obj && in_array($obj, $remove_object_ids, true) ) {
                $should_remove = true;
            }
            if ( ! $should_remove && $title !== '' && in_array($title, $managed_titles, true) ) {
                $should_remove = true;
            }

            if ( $should_remove && ! empty($it->ID) ) {
                wp_delete_post((int) $it->ID, true);
            }
        }
    }

    // 再取得（削除後の状態に合わせる）
    $items = wp_get_nav_menu_items($menu_id);
    $get_item_id_by_object = function($object_id) use ($items) {
        if ( ! $items || is_wp_error($items) ) return null;
        foreach ($items as $item) {
            if ( intval($item->object_id) === intval($object_id) ) {
                return $item->ID;
            }
        }
        return null;
    };
    $get_item_id_by_url = function($url) use ($items) {
        if ( ! $items || is_wp_error($items) ) return null;
        foreach ($items as $item) {
            if ( isset($item->url) && rtrim($item->url, '/') === rtrim($url, '/') ) {
                return $item->ID;
            }
        }
        return null;
    };
    $has_by_object = function($object_id) use ($items) {
        if ( ! $items || is_wp_error($items) ) return false;
        foreach ($items as $item) {
            if ( intval($item->object_id) === intval($object_id) ) return true;
        }
        return false;
    };
    $has_by_url = function($url) use ($items) {
        if ( ! $items || is_wp_error($items) ) return false;
        foreach ($items as $item) {
            if ( isset($item->url) && rtrim($item->url, '/') === rtrim($url, '/') ) return true;
        }
        return false;
    };

    // ホームをメニューに追加し、左端(最優先)に配置
    $home_url = home_url('/');
    $top_item_id = $get_item_id_by_url($home_url);
    $top_item_args = [
        'menu-item-type'      => 'custom',
        'menu-item-title'     => 'ホーム',
        'menu-item-url'       => $home_url,
        'menu-item-status'    => 'publish',
        'menu-item-position'  => 1,
    ];
    if ( $top_item_id ) {
        wp_update_nav_menu_item($menu_id, $top_item_id, $top_item_args);
    } elseif ( ! $has_by_url($home_url) ) {
        wp_update_nav_menu_item($menu_id, 0, $top_item_args);
    }

    // 学習コラム（投稿一覧）ページを作成・割り当てし、メニューに追加
    $learning_column_page = mytheme_get_page_by_path_cached('learning-column');
    if ( ! $learning_column_page ) {
        $learning_column_id = wp_insert_post([
            'post_title'   => '学習コラム',
            'post_name'    => 'learning-column',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( ! is_wp_error($learning_column_id) ) {
            $learning_column_page = get_post((int) $learning_column_id);
        }
    }
    $learning_column_id = $learning_column_page ? (int) $learning_column_page->ID : 0;

    // 投稿ページ（一覧）として未設定なら割り当て（既存設定があれば尊重）
    if ( $learning_column_id ) {
        $current_page_for_posts = (int) get_option('page_for_posts');
        if ( ! $current_page_for_posts || get_post_status($current_page_for_posts) !== 'publish' ) {
            update_option('page_for_posts', $learning_column_id);
        }

        $learning_column_item_id = $get_item_id_by_object($learning_column_id);
        $learning_column_item_args = [
            'menu-item-object-id' => $learning_column_id,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-title'     => '学習コラム',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 2,
        ];
        if ( $learning_column_item_id ) {
            wp_update_nav_menu_item($menu_id, $learning_column_item_id, $learning_column_item_args);
        } elseif ( ! $has_by_object($learning_column_id) ) {
            wp_update_nav_menu_item($menu_id, 0, $learning_column_item_args);
        }
    }

    // 開発作品
    $works_page = mytheme_get_page_by_path_cached('works');
    $works_id = $works_page ? (int) $works_page->ID : 0;
    $works_url = $works_id ? get_permalink($works_id) : home_url('/works/');
    $works_item_id = $works_id ? $get_item_id_by_object($works_id) : $get_item_id_by_url($works_url);
    $works_item_args = $works_id
        ? [
            'menu-item-object-id' => $works_id,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-title'     => '開発作品',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 3,
        ]
        : [
            'menu-item-type'      => 'custom',
            'menu-item-title'     => '開発作品',
            'menu-item-url'       => $works_url,
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 3,
        ];
    if ( $works_item_id ) {
        wp_update_nav_menu_item($menu_id, $works_item_id, $works_item_args);
    } elseif ( ($works_id && ! $has_by_object($works_id)) || (! $works_id && ! $has_by_url($works_url)) ) {
        wp_update_nav_menu_item($menu_id, 0, $works_item_args);
    }

    // 電子書籍
    $ebooks_page = mytheme_get_page_by_path_cached('ebooks');
    $ebooks_id = $ebooks_page ? (int) $ebooks_page->ID : 0;
    $ebooks_url = $ebooks_id ? get_permalink($ebooks_id) : home_url('/ebooks/');
    $ebooks_item_id = $ebooks_id ? $get_item_id_by_object($ebooks_id) : $get_item_id_by_url($ebooks_url);
    $ebooks_item_args = $ebooks_id
        ? [
            'menu-item-object-id' => $ebooks_id,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-title'     => '電子書籍',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 4,
        ]
        : [
            'menu-item-type'      => 'custom',
            'menu-item-title'     => '電子書籍',
            'menu-item-url'       => $ebooks_url,
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 4,
        ];
    if ( $ebooks_item_id ) {
        wp_update_nav_menu_item($menu_id, $ebooks_item_id, $ebooks_item_args);
    } elseif ( ($ebooks_id && ! $has_by_object($ebooks_id)) || (! $ebooks_id && ! $has_by_url($ebooks_url)) ) {
        wp_update_nav_menu_item($menu_id, 0, $ebooks_item_args);
    }

    // 自己紹介
    $about_page = mytheme_get_page_by_path_cached('about');
    $about_id = $about_page ? (int) $about_page->ID : 0;
    $about_url = $about_id ? get_permalink($about_id) : home_url('/about/');
    $about_item_id = $about_id ? $get_item_id_by_object($about_id) : $get_item_id_by_url($about_url);
    $about_item_args = $about_id
        ? [
            'menu-item-object-id' => $about_id,
            'menu-item-object'    => 'page',
            'menu-item-type'      => 'post_type',
            'menu-item-title'     => '自己紹介',
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 5,
        ]
        : [
            'menu-item-type'      => 'custom',
            'menu-item-title'     => '自己紹介',
            'menu-item-url'       => $about_url,
            'menu-item-status'    => 'publish',
            'menu-item-position'  => 5,
        ];
    if ( $about_item_id ) {
        wp_update_nav_menu_item($menu_id, $about_item_id, $about_item_args);
    } elseif ( ($about_id && ! $has_by_object($about_id)) || (! $about_id && ! $has_by_url($about_url)) ) {
        wp_update_nav_menu_item($menu_id, 0, $about_item_args);
    }

}

/**
 * 学習コラムページの存在と「投稿ページ」割り当てだけを保証
 */
function mytheme_ensure_learning_column_page() {
    $learning_column_page = mytheme_get_page_by_path_cached('learning-column');
    if ( ! $learning_column_page ) {
        $learning_column_id = wp_insert_post([
            'post_title'   => '学習コラム',
            'post_name'    => 'learning-column',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( ! is_wp_error($learning_column_id) ) {
            $learning_column_page = get_post((int) $learning_column_id);
        }
    }

    $learning_column_id = $learning_column_page ? (int) $learning_column_page->ID : 0;
    if ( $learning_column_id <= 0 ) return;

    $current_page_for_posts = (int) get_option('page_for_posts');
    if ( ! $current_page_for_posts || get_post_status($current_page_for_posts) !== 'publish' ) {
        update_option('page_for_posts', $learning_column_id);
    }
}

/**
 * 電子書籍（Kindle本）データ
 * - ここに本を追加していくと「本棚」ページとトップページに反映されます
 * - cover はテーマ内パス（例: assets/images/my-kindle-book.webp）を推奨
 */
function mytheme_get_ebooks() {
    return [
        [
            'store'       => 'Kindle',
            'published'   => '', // 例: 2026-01-01
            'editions'    => [
                'ja' => [
                    'label'       => '日本語版',
                    'title'       => '伝わらないのは、相手を見ていないからだ',
                    'subtitle'    => '塾講師×管理職が教える、情報を引き出す「観察」の作法',
                    'description' => '伝え方の前に必要な、相手を深く観察し情報を読み解く力をまとめた一冊です。塾講師と管理職の実体験をもとに、AI時代にも通用する「知的受信力」と信頼を生む対話の土台を解説します。',
                    'cover'       => 'assets/images/ebook-5.jpg',
                    'url'         => 'https://amzn.to/4bYSQr8',
                ],
            ],
        ],
        [
            'store'       => 'Kindle',
            'published'   => '', // 例: 2026-01-01
            'editions'    => [
                'ja' => [
                    'label'       => '日本語版',
                    'title'       => '地味な仕事には全て意味がある',
                    'subtitle'    => '知的体力の鍛え方',
                    'description' => '効率化だけでは得られない「知的体力」を、現場の地道な実践から育てるための一冊です。書く・伝える・やり切るという泥臭い積み重ねが、AI時代でも通用する思考力とキャリアの土台になることを解説します。',
                    'cover'       => 'assets/images/ebook-4.jpg',
                    'url'         => 'https://amzn.to/4czxDVn',
                ],
                'en' => [
                    'label'       => 'English',
                    'title'       => 'Intellectual Stamina',
                    'subtitle'    => 'Why Every Menial Task is a Seed for Future Success: The Blueprint for Mastery in Your Early Career',
                    'description' => 'In the AI era, real growth comes from Intellectual Stamina built through gritty, hands-on work. This book shows why the tasks others avoid can become your greatest advantage and a powerful foundation for long-term leadership.',
                    'cover'       => 'assets/images/ebook-4-en.jpg',
                    'url'         => 'https://amzn.to/4d2i5d3',
                ],
            ],
        ],
        [
            'store'       => 'Kindle',
            'published'   => '', // 例: 2026-01-01
            'editions'    => [
                'ja' => [
                    'label'       => '日本語版',
                    'title'       => '最速の学びは「泥臭さ」の中にしかない',
                    'subtitle'    => '塾講師が教える、脳を強制起動させる「4つの基本動作」',
                    'description' => '「学びが続かない」「頭が動かない」を抜け出すための、脳を強制起動させる4つの基本動作をまとめた一冊です。',
                    'cover'       => 'assets/images/ebook-3.jpg',
                    'url'         => 'https://amzn.to/45NesDi',
                ],
                'en' => [
                    'label'       => 'English',
                    'title'       => 'The Fastest Way to Learn is the Grittiest Way',
                    'subtitle'    => 'A Cram School Teacher\'s Guide: 4 Physical Actions to Jumpstart Your Brain',
                    'description' => 'Break free from the \"Efficiency Trap\" and rebuild real thinking power through four embodied actions: Write, Read (Double Reading), Vocalize (Self-Lecturing), and Recall (Time Compression). This is not a book of hacks but a practical form for authentic mastery, confidence, and long-term adaptability in the AI era.',
                    'cover'       => 'assets/images/ebook-3-en.jpg',
                    'url'         => 'https://amzn.to/4sejKk5',
                ],
            ],
        ],
        [
            'store'       => 'Kindle',
            'published'   => '', // 例: 2026-01-01
            'editions'    => [
                'ja' => [
                    'label'       => '日本語版',
                    'title'       => '妄想（イメトレ）で「伝える力」は9割変わる。',
                    'subtitle'    => '塾講師の技術をビジネスに転用する「超・アウトプット」の型',
                    'description' => '「教える」視点でアウトプットを回し、妄想（イメトレ）とAI（ChatGPT）を使った壁打ちで、伝える精度を高める実践法をまとめた一冊です。',
                    'cover'       => 'assets/images/ebook-2.jpg',
                    'url'         => 'https://amzn.to/49hNC8A',
                ],
                'en' => [
                    'label'       => 'English',
                    'title'       => 'The Power of Delusional Output',
                    'subtitle'    => 'Transform Your Communication by 90% with Strategic Image Training: The Cram School Master’s Blueprint for Business Success',
                    'description' => 'Input alone is a trap. Shift from a “Student” mindset to a “Teacher” mindset and make your learning visible through “Delusional Output.” This book teaches instructional design, strategic image training, AI-as-student practice (ChatGPT/Gemini), ruthless subtraction, and leadership through education.',
                    'cover'       => 'assets/images/ebook-2-en.jpg',
                    'url'         => 'https://amzn.to/49hYy67',
                ],
            ],
        ],
        [
            'store'       => 'Kindle',
            'published'   => '', // 例: 2026-01-01
            'editions'    => [
                'ja' => [
                    'label'       => '日本語版',
                    'title'       => 'スマートに働くための『根性』の使い所',
                    'subtitle'    => '思考を止めた効率化を捨て、圧倒的な『量』で壁を突破する技術',
                    'description' => '「効率化・時短」だけでは突き抜けられない人へ。論理的思考×泥臭い根性で『圧倒的な量』を積み上げ、壁を突破する技術をまとめた一冊です。',
                    'cover'       => 'assets/images/ebook-1.jpg',
                    'url'         => 'https://amzn.to/454Rbwn',
                ],
                'en' => [
                    'label'       => 'English',
                    'title'       => 'Smart Grit',
                    'subtitle'    => 'Mastering the Art of Effort: Why Strategic Intensity Trumps Mindless Efficiency',
                    'description' => 'Stop hiding behind “efficiency” and start breaking through. This book shows how strategic intensity and sheer volume build real skill, confidence, and leadership—without burning out. (English translation of the Japanese business book “Smart Grit.”)',
                    'cover'       => 'assets/images/ebook-1-en.jpg',
                    'url'         => 'https://amzn.to/4sFAFx4',
                ],
            ],
        ],
    ];
}

function mytheme_get_ebooks_lang() {
    // 1) Cookie（ユーザーの選択）を最優先
    if ( isset($_COOKIE['mytheme_ebooks_lang']) ) {
        $cookie_lang = sanitize_key((string) $_COOKIE['mytheme_ebooks_lang']);
        if ( in_array($cookie_lang, ['ja', 'en'], true) ) return $cookie_lang;
    }

    // 2) ブラウザ言語で推定（初回のみ）
    $accept = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? (string) $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
    $accept = strtolower($accept);
    if ( strpos($accept, 'en') === 0 ) return 'en';

    return 'ja';
}

/**
 * 指定言語のエディションを取得（無ければ日本語版にフォールバック）
 */
function mytheme_get_ebook_edition($book, $lang = 'ja') {
    if ( ! is_array($book) ) return null;
    $editions = isset($book['editions']) && is_array($book['editions']) ? $book['editions'] : [];
    if ( isset($editions[$lang]) && is_array($editions[$lang]) ) return $editions[$lang];

    // 英語表示に切り替えたが英語版が未公開の場合は「Coming soon」を表示
    if ( $lang === 'en' ) {
        $ja_cover = (isset($editions['ja']) && is_array($editions['ja']) && ! empty($editions['ja']['cover']))
            ? (string) $editions['ja']['cover']
            : '';
        return [
            'label'       => 'English',
            'title'       => 'Coming soon',
            'subtitle'    => '',
            'description' => 'English edition is coming soon.',
            'cover'       => $ja_cover,
            'url'         => '',
        ];
    }

    // 日本語が無いケースは基本想定外だが、あれば日本語にフォールバック
    if ( isset($editions['ja']) && is_array($editions['ja']) ) return $editions['ja'];
    return null;
}

/**
 * 電子書籍の表示言語を「自然に」切り替える
 * - /ebooks/?lang=en のように指定された場合は Cookie に保存し、URLからlangを除去してリダイレクト
 * - URLに lang=ja/en を残さずに運用できます
 */
function mytheme_handle_ebooks_lang_preference() {
    if ( ! ( is_page('ebooks') || is_front_page() ) ) return;
    if ( empty($_GET['lang']) ) return;

    $lang = sanitize_key((string) $_GET['lang']);
    if ( ! in_array($lang, ['ja', 'en'], true) ) return;

    // 1年保持（サイト全体）
    setcookie('mytheme_ebooks_lang', $lang, [
        'expires'  => time() + 365 * DAY_IN_SECONDS,
        'path'     => '/',
        'secure'   => is_ssl(),
        'httponly' => false,
        'samesite' => 'Lax',
    ]);

    // URLから lang を消して戻す
    $redirect = remove_query_arg('lang');
    wp_safe_redirect($redirect);
    exit;
}
add_action('template_redirect', 'mytheme_handle_ebooks_lang_preference', 1);

/**
 * 電子書籍ページ（/ebooks）を作成し、テンプレートを割り当て（冪等）
 */
function mytheme_ensure_ebooks_page() {
    $slug = 'ebooks';
    $page = mytheme_get_page_by_path_cached($slug);

    if ( ! $page ) {
        $page_id = wp_insert_post([
            'post_title'   => '電子書籍',
            'post_name'    => $slug,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);

        if ( is_wp_error($page_id) || empty($page_id) ) {
            return;
        }
        update_post_meta($page_id, '_wp_page_template', 'page-ebooks.php');
        return;
    }

    // 既存ページがある場合もテンプレートは揃える
    update_post_meta($page->ID, '_wp_page_template', 'page-ebooks.php');
}

/**
 * 一度だけ実行（ただしページが無ければ作る）
 */
function mytheme_ensure_ebooks_page_once() {
    // Gutenberg/REST中は実行しない（エディタのREST応答を壊さない）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    // 管理画面で一度だけ（重い＆DB更新があるため）
    if ( ! is_admin() ) return;
    if ( ! current_user_can('edit_pages') ) return;
    if ( get_option('mytheme_ebooks_page_synced') ) return;
    // テンプレが存在しない場合は無理に作らない（白画面回避）
    $tpl = get_template_directory() . '/page-ebooks.php';
    if ( ! file_exists($tpl) ) return;
    mytheme_ensure_ebooks_page();
    update_option('mytheme_ebooks_page_synced', 1);
}

/**
 * 万が一メニューにホームがない場合でも先頭に挿入
 */
function mytheme_force_top_menu_item($items, $args) {
    if ( ! isset($args->theme_location) || $args->theme_location !== 'primary' ) {
        return $items;
    }
    $home_url = home_url('/');
    // すでに含まれていればそのまま
    if ( strpos($items, esc_url($home_url)) !== false ) {
        return $items;
    }
    $current_class = is_front_page() ? ' site-nav__item--current current-menu-item' : '';
    $top_li  = '<li class="menu-item menu-item-type-custom menu-item-home site-nav__item' . $current_class . '">';
    $top_li .= '<a class="site-nav__link" href="' . esc_url($home_url) . '">ホーム</a>';
    $top_li .= '</li>';
    return $top_li . $items;
}
add_filter('wp_nav_menu_items', 'mytheme_force_top_menu_item', 10, 2);
