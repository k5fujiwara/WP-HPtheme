<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 開発作品（work）投稿タイプ
 */
function mytheme_register_work_cpt() {
    $editor_template = [
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => 'プロジェクト概要']],
                ['core/paragraph', ['className' => 'project-section__text', 'placeholder' => '作品の概要を入力します。']],
            ],
        ],
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => '開発目的']],
                ['core/list', ['className' => 'feature-list']],
            ],
        ],
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => '使用技術']],
                ['core/paragraph', ['className' => 'project-section__text', 'placeholder' => '技術スタックや選定理由を入力します。']],
            ],
        ],
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => '主な機能']],
                ['core/list', ['className' => 'feature-list']],
            ],
        ],
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => '工夫した点']],
                ['core/list', ['className' => 'feature-list']],
            ],
        ],
        [
            'core/group',
            ['className' => 'project-section'],
            [
                ['core/heading', ['level' => 2, 'className' => 'project-section__title', 'content' => 'デモ動画']],
                ['core/paragraph', ['className' => 'project-section__text', 'placeholder' => '動画URLや説明を入力します。']],
            ],
        ],
    ];

    register_post_type('work', [
        'labels' => [
            'name'               => '開発作品',
            'singular_name'      => '開発作品',
            'add_new'            => '新規追加',
            'add_new_item'       => '開発作品を追加',
            'edit_item'          => '開発作品を編集',
            'new_item'           => '新しい開発作品',
            'view_item'          => '開発作品を表示',
            'search_items'       => '開発作品を検索',
            'not_found'          => '開発作品が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に開発作品はありません',
            'menu_name'          => '開発作品',
        ],
        'public'              => true,
        'has_archive'         => false,
        'rewrite'             => ['slug' => 'work', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 24,
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail', 'page-attributes'],
        'template'            => $editor_template,
        'template_lock'       => false,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);
}
add_action('init', 'mytheme_register_work_cpt', 9);

function mytheme_work_meta_fields() {
    return [
        '_mytheme_work_card_image_path',
        '_mytheme_work_card_image_alt',
        '_mytheme_work_tech_tags',
        '_mytheme_work_demo_url',
        '_mytheme_work_external_url',
    ];
}

function mytheme_get_work_meta($post_id, $key, $default = '') {
    $value = get_post_meta((int) $post_id, (string) $key, true);
    return $value !== '' ? $value : $default;
}

function mytheme_get_work_tech_tags($post_id) {
    $raw = (string) mytheme_get_work_meta($post_id, '_mytheme_work_tech_tags');
    if ( $raw === '' ) return [];

    $items = preg_split('/[\r\n,]+/', $raw);
    $items = array_map('trim', is_array($items) ? $items : []);
    $items = array_filter($items, function($item) {
        return $item !== '';
    });

    return array_values(array_unique($items));
}

function mytheme_work_sanitize_url_or_anchor($value) {
    $value = trim((string) $value);
    if ( $value === '' ) return '';

    if ( strpos($value, '#') === 0 ) {
        return sanitize_text_field($value);
    }

    return esc_url_raw($value);
}

function mytheme_get_work_detail_url($post_id) {
    return get_permalink((int) $post_id);
}

function mytheme_work_image_shortcode($atts) {
    $atts = shortcode_atts([
        'path'    => '',
        'alt'     => '',
        'class'   => '',
        'loading' => 'lazy',
    ], $atts, 'theme_image');

    $path = ltrim((string) $atts['path'], '/');
    if ( $path === '' || strpos($path, '..') !== false ) {
        return '';
    }

    $alt = (string) $atts['alt'];
    $class = (string) $atts['class'];
    $loading = (string) $atts['loading'];

    if ( function_exists('mytheme_picture_tag') ) {
        return mytheme_picture_tag($path, $alt, $class, $loading);
    }

    return '<img src="' . esc_url(get_template_directory_uri() . '/' . $path) . '" alt="' . esc_attr($alt) . '" class="' . esc_attr($class) . '" loading="' . esc_attr($loading) . '">';
}
add_shortcode('theme_image', 'mytheme_work_image_shortcode');

function mytheme_work_add_meta_box() {
    add_meta_box(
        'mytheme-work-details',
        '作品カード設定',
        'mytheme_work_render_meta_box',
        'work',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_work', 'mytheme_work_add_meta_box');

function mytheme_work_render_meta_box($post) {
    $post_id = (int) $post->ID;
    wp_nonce_field('mytheme_work_meta_action', 'mytheme_work_meta_nonce');
    ?>
    <p>
        <label for="mytheme_work_card_image_path"><strong>カード画像パス</strong></label><br>
        <input type="text" id="mytheme_work_card_image_path" name="mytheme_work_card_image_path" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_card_image_path')); ?>" class="widefat" placeholder="assets/images/example.png">
        <span class="description">アイキャッチ画像が設定されている場合は、アイキャッチ画像を優先します。</span>
    </p>
    <p>
        <label for="mytheme_work_card_image_alt"><strong>画像alt</strong></label><br>
        <input type="text" id="mytheme_work_card_image_alt" name="mytheme_work_card_image_alt" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_card_image_alt')); ?>" class="widefat">
    </p>
    <p>
        <label for="mytheme_work_tech_tags"><strong>使用技術</strong></label><br>
        <textarea id="mytheme_work_tech_tags" name="mytheme_work_tech_tags" rows="4" class="widefat" placeholder="Python, Flask, JavaScript"><?php echo esc_textarea(mytheme_get_work_meta($post_id, '_mytheme_work_tech_tags')); ?></textarea>
        <span class="description">カンマ区切り、または改行区切りで入力できます。</span>
    </p>
    <p>
        <label for="mytheme_work_demo_url"><strong>デモURL / アンカー</strong></label><br>
        <input type="text" id="mytheme_work_demo_url" name="mytheme_work_demo_url" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_demo_url')); ?>" class="widefat" placeholder="#demo-video">
    </p>
    <p>
        <label for="mytheme_work_external_url"><strong>外部リンクURL</strong></label><br>
        <input type="url" id="mytheme_work_external_url" name="mytheme_work_external_url" value="<?php echo esc_attr(mytheme_get_work_meta($post_id, '_mytheme_work_external_url')); ?>" class="widefat" placeholder="https://example.com/">
    </p>
    <?php
}

function mytheme_work_save_meta($post_id, $post, $update) {
    if ( ! $post || $post->post_type !== 'work' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $nonce = isset($_POST['mytheme_work_meta_nonce']) ? (string) $_POST['mytheme_work_meta_nonce'] : '';
    if ( $nonce === '' || ! wp_verify_nonce($nonce, 'mytheme_work_meta_action') ) {
        return;
    }

    $values = [
        '_mytheme_work_card_image_path' => isset($_POST['mytheme_work_card_image_path']) ? sanitize_text_field(wp_unslash((string) $_POST['mytheme_work_card_image_path'])) : '',
        '_mytheme_work_card_image_alt'  => isset($_POST['mytheme_work_card_image_alt']) ? sanitize_text_field(wp_unslash((string) $_POST['mytheme_work_card_image_alt'])) : '',
        '_mytheme_work_tech_tags'       => isset($_POST['mytheme_work_tech_tags']) ? sanitize_textarea_field(wp_unslash((string) $_POST['mytheme_work_tech_tags'])) : '',
        '_mytheme_work_demo_url'        => isset($_POST['mytheme_work_demo_url']) ? mytheme_work_sanitize_url_or_anchor(wp_unslash((string) $_POST['mytheme_work_demo_url'])) : '',
        '_mytheme_work_external_url'    => isset($_POST['mytheme_work_external_url']) ? esc_url_raw(wp_unslash((string) $_POST['mytheme_work_external_url'])) : '',
    ];

    foreach ( $values as $key => $value ) {
        if ( $value === '' ) {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }
}
add_action('save_post_work', 'mytheme_work_save_meta', 10, 3);

function mytheme_get_seed_work_items() {
    return [
        [
            'seed_key'    => 'loto6',
            'title'       => 'ロト６予測ツール',
            'slug'        => 'loto6',
            'excerpt'     => '複数の機械学習モデル（ロジスティック回帰・RandomForest）を活用したロト6の次回当選番号予測システム。2つのモデルの結果を比較表示。',
            'content'     => "過去のロト6抽選データを分析し、機械学習アルゴリズムを用いて次回の当選番号を予測するWebアプリケーションです。",
            'image_path'  => 'assets/images/loto6_3.png',
            'image_alt'   => 'ロト６予測ツール - 機械学習を活用した数字予測システム',
            'demo_url'    => '#demo-video',
            'tech_tags'   => "Python\nFlask\nscikit-learn\nSelenium",
            'template'    => 'project-1.php',
            'intro_media' => '<div class="project-gallery"><div class="gallery-item">[theme_image path="assets/images/loto6_1.png" alt="ロト６予測ツール - 予測開始画面" class="gallery-item__image" loading="lazy"]<p class="gallery-caption">予測開始画面</p></div><div class="gallery-item">[theme_image path="assets/images/loto6_2.png" alt="ロト６予測ツール - データ分析中" class="gallery-item__image" loading="lazy"]<p class="gallery-caption">データ分析中</p></div></div>',
            'menu_order'  => 10,
        ],
        [
            'seed_key'    => 'auto-typing',
            'title'       => 'e-typing自動タイピング',
            'slug'        => 'auto-typing',
            'excerpt'     => 'Selenium WebDriverを活用したe-typing練習サイトの自動入力システム。XPathによる動的要素取得とiframe操作を実装。',
            'content'     => "日本最大級のタイピング練習サイト「e-typing」に対応した自動入力プログラムです。",
            'image_path'  => 'assets/images/auto_typing1.png',
            'image_alt'   => 'e-typing自動タイピング - Selenium WebDriverによるブラウザ自動化',
            'demo_url'    => '#demo-video',
            'tech_tags'   => "Python\nSelenium\nwebdriver-manager\nXPath",
            'template'    => 'project-2.php',
            'menu_order'  => 20,
        ],
        [
            'seed_key'    => 'quest4',
            'title'       => 'Quest4 - LINE学習クイズBot',
            'slug'        => 'quest4',
            'excerpt'     => 'Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システム。4科目24カテゴリから選択でき、リアルタイムで正誤判定と解説を提供します。',
            'content'     => "Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システムです。",
            'image_path'  => 'assets/images/quest4_1.png',
            'image_alt'   => 'Quest4 - LINE学習クイズBot',
            'demo_url'    => '#demo-video',
            'external_url'=> 'https://lin.ee/cyB8XEGb',
            'tech_tags'   => "JavaScript\nGoogle Apps Script\nLINE Messaging API",
            'template'    => 'project-3.php',
            'intro_media' => '<div class="phone-gallery"><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_1.png" alt="Quest4 - 科目選択画面" class="phone-screen__image" loading="lazy"]</div></div><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_2.png" alt="Quest4 - クイズ画面" class="phone-screen__image" loading="lazy"]</div></div><div class="phone-mockup"><div class="phone-screen">[theme_image path="assets/images/quest4_3.png" alt="Quest4 - 結果画面" class="phone-screen__image" loading="lazy"]</div></div></div>',
            'menu_order'  => 30,
        ],
        [
            'seed_key'    => 'beengineer-camp',
            'title'       => 'BeEngineer合宿案内サイト',
            'slug'        => 'beengineer-camp',
            'excerpt'     => 'BeEngineerプログラミング合宿の案内用Webサイト。HTML5、CSS3、Vanilla JavaScriptを使用した静的サイトで、レスポンシブデザインに完全対応。',
            'content'     => "BeEngineerプログラミング合宿向けの情報提供サイトです。",
            'image_path'  => 'assets/images/beengineer_camp_1.png',
            'image_alt'   => 'BeEngineer Programming Camp - 合宿案内サイト',
            'demo_url'    => '#demo-video',
            'external_url'=> 'https://keigo-fujiwara.github.io/public_beengineer_camp25/',
            'tech_tags'   => "HTML5\nCSS3\nJavaScript\nlocalStorage",
            'template'    => 'project-4.php',
            'intro_media' => '<div class="project-gallery"><div class="gallery-item">[theme_image path="assets/images/beengineer_camp_2.png" alt="BeEngineer合宿案内サイト - 持ち物リスト" class="gallery-item__image gallery-item__image--16x9" loading="lazy"]<p class="gallery-caption" style="min-height: 2.4em;">持ち物リスト</p></div><div class="gallery-item">[theme_image path="assets/images/beengineer_camp_3.png" alt="BeEngineer合宿案内サイト - お問い合わせ" class="gallery-item__image gallery-item__image--16x9" loading="lazy"]<p class="gallery-caption" style="min-height: 2.4em;">お問い合わせ</p></div></div>',
            'menu_order'  => 40,
        ],
    ];
}

function mytheme_work_convert_template_php_to_shortcodes($content) {
    $content = (string) $content;
    $content = preg_replace_callback(
        "/<\\?php\\s+echo\\s+mytheme_picture_tag\\(\\s*'([^']*)'\\s*,\\s*'([^']*)'\\s*,\\s*'([^']*)'\\s*,\\s*'([^']*)'\\s*\\);\\s*\\?>/u",
        function($matches) {
            return sprintf(
                '[theme_image path="%s" alt="%s" class="%s" loading="%s"]',
                esc_attr($matches[1]),
                esc_attr($matches[2]),
                esc_attr($matches[3]),
                esc_attr($matches[4])
            );
        },
        $content
    );

    return preg_replace('/<\?php.*?\?>/s', '', $content);
}

function mytheme_work_extract_template_content($template_name) {
    $path = get_template_directory() . '/templates/projects/' . basename((string) $template_name);
    if ( ! file_exists($path) ) return '';

    $source = (string) file_get_contents($path);
    $parts = preg_split('/<div class="project-content">/u', $source, 2);
    if ( ! is_array($parts) || count($parts) < 2 ) return '';

    $tail = (string) $parts[1];
    $content_parts = preg_split('/\R\s*<\/div>\s*\R\s*<div class="back-link"/u', $tail, 2);
    $content = is_array($content_parts) ? (string) $content_parts[0] : $tail;
    $content = mytheme_work_convert_template_php_to_shortcodes($content);

    return trim($content);
}

function mytheme_work_build_seed_content($item) {
    $content = '';
    if ( ! empty($item['intro_media']) ) {
        $content .= (string) $item['intro_media'] . "\n\n";
    }

    if ( ! empty($item['template']) ) {
        $template_content = mytheme_work_extract_template_content((string) $item['template']);
        if ( $template_content !== '' ) {
            return $content . $template_content;
        }
    }

    return $content . '<section class="project-section"><h2 class="project-section__title">プロジェクト概要</h2><p class="project-section__text">' . esc_html((string) $item['content']) . '</p></section>';
}

function mytheme_seed_work_entries_once() {
    if ( get_option('mytheme_work_seeded_v2') ) return;

    foreach ( mytheme_get_seed_work_items() as $item ) {
        $existing = get_posts([
            'post_type'              => 'work',
            'post_status'            => ['publish', 'draft', 'pending', 'private'],
            'posts_per_page'         => 1,
            'fields'                 => 'ids',
            'meta_key'               => '_mytheme_work_seed_key',
            'meta_value'             => (string) $item['seed_key'],
            'no_found_rows'          => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        $content = mytheme_work_build_seed_content($item);
        $post_data = [
            'post_type'    => 'work',
            'post_status'  => 'publish',
            'post_title'   => (string) $item['title'],
            'post_name'    => (string) $item['slug'],
            'post_excerpt' => (string) $item['excerpt'],
            'post_content' => $content,
            'menu_order'   => (int) $item['menu_order'],
        ];

        if ( ! empty($existing) ) {
            $post_data['ID'] = (int) $existing[0];
            $post_id = wp_update_post($post_data, true);
        } else {
            $post_id = wp_insert_post($post_data, true);
        }

        if ( is_wp_error($post_id) || (int) $post_id <= 0 ) {
            continue;
        }

        update_post_meta((int) $post_id, '_mytheme_work_seed_key', (string) $item['seed_key']);
        update_post_meta((int) $post_id, '_mytheme_work_card_image_path', (string) $item['image_path']);
        update_post_meta((int) $post_id, '_mytheme_work_card_image_alt', (string) $item['image_alt']);
        update_post_meta((int) $post_id, '_mytheme_work_demo_url', (string) $item['demo_url']);
        update_post_meta((int) $post_id, '_mytheme_work_tech_tags', (string) $item['tech_tags']);
        delete_post_meta((int) $post_id, '_mytheme_work_detail_url');

        if ( ! empty($item['external_url']) ) {
            update_post_meta((int) $post_id, '_mytheme_work_external_url', esc_url_raw((string) $item['external_url']));
        }
    }

    update_option('mytheme_work_seeded_v2', 1, false);
}
add_action('init', 'mytheme_seed_work_entries_once', 30);

function mytheme_redirect_legacy_work_pages() {
    if ( is_admin() || ! is_page() ) return;

    $post_id = (int) get_queried_object_id();
    if ( $post_id <= 0 ) return;

    $uri = trim((string) get_page_uri($post_id), '/');
    $legacy_map = [
        'works/loto6'           => 'loto6',
        'works/auto-typing'     => 'auto-typing',
        'works/quest4'          => 'quest4',
        'works/beengineer-camp' => 'beengineer-camp',
    ];

    if ( ! isset($legacy_map[$uri]) ) return;

    $work = get_page_by_path($legacy_map[$uri], OBJECT, 'work');
    if ( ! $work || get_post_status($work->ID) !== 'publish' ) return;

    wp_safe_redirect(get_permalink($work->ID), 301);
    exit;
}
add_action('template_redirect', 'mytheme_redirect_legacy_work_pages');

function mytheme_get_work_archive_query($args = []) {
    $defaults = [
        'post_type'      => 'work',
        'post_status'    => 'publish',
        'posts_per_page' => 50,
        'orderby'        => ['menu_order' => 'ASC', 'date' => 'DESC'],
        'no_found_rows'  => true,
    ];

    return new WP_Query(wp_parse_args($args, $defaults));
}

function mytheme_render_work_card($post_id) {
    $post_id = (int) $post_id;
    $url = mytheme_get_work_detail_url($post_id);
    $title = get_the_title($post_id);
    $description = has_excerpt($post_id)
        ? get_the_excerpt($post_id)
        : wp_trim_words(wp_strip_all_tags((string) get_post_field('post_content', $post_id)), 80, '...');
    $image_alt = mytheme_get_work_meta($post_id, '_mytheme_work_card_image_alt', $title);
    $image_path = mytheme_get_work_meta($post_id, '_mytheme_work_card_image_path');
    $tech_tags = mytheme_get_work_tech_tags($post_id);
    $demo_url = mytheme_get_work_meta($post_id, '_mytheme_work_demo_url');

    if ( strpos($demo_url, '#') === 0 ) {
        $demo_url = $url . $demo_url;
    }
    ?>
    <div class="work-item">
        <div class="work-thumbnail">
            <a class="work-thumbnail__link" href="<?php echo esc_url($url); ?>">
                <?php if ( has_post_thumbnail($post_id) ) : ?>
                    <?php echo get_the_post_thumbnail($post_id, 'large', ['class' => 'work-thumbnail__image', 'alt' => $image_alt]); ?>
                <?php elseif ( $image_path !== '' && function_exists('mytheme_picture_tag') ) : ?>
                    <?php echo mytheme_picture_tag($image_path, $image_alt, 'work-thumbnail__image', 'lazy'); ?>
                <?php endif; ?>
            </a>
        </div>
        <div class="work-info">
            <h2 class="work-title"><?php echo esc_html($title); ?></h2>
            <?php if ( $description !== '' ) : ?>
                <p class="work-description"><?php echo esc_html($description); ?></p>
            <?php endif; ?>
            <?php if ( ! empty($tech_tags) ) : ?>
                <div class="work-tech">
                    <?php foreach ( $tech_tags as $tag ) : ?>
                        <span class="tech-tag"><?php echo esc_html($tag); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="work-links">
                <a href="<?php echo esc_url($url); ?>" class="work-link">詳細を見る</a>
                <?php if ( $demo_url !== '' ) : ?>
                    <a href="<?php echo esc_url($demo_url); ?>" class="work-link work-link-demo">
                        <svg class="work-link-demo__icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="5 3 19 12 5 21 5 3"></polygon>
                        </svg>
                        デモを見る
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

function mytheme_work_flush_rewrite_on_switch() {
    mytheme_register_work_cpt();
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'mytheme_work_flush_rewrite_on_switch');

function mytheme_work_flush_rewrite_once_after_register() {
    $version = 'work-rewrite-v2';
    if ( get_option('mytheme_work_rewrite_version') === $version ) return;

    flush_rewrite_rules(false);
    update_option('mytheme_work_rewrite_version', $version, false);
}
add_action('init', 'mytheme_work_flush_rewrite_once_after_register', 99);
