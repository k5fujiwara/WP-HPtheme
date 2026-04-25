<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * BeEngineer通信 投稿タイプ + タクソノミー
 */
function mytheme_register_beengineer_news_cpt_and_taxonomy() {
    register_post_type('beengineer-news', [
        'labels' => [
            'name'               => 'BeEngineer通信',
            'singular_name'      => 'BeEngineer通信',
            'add_new'            => '新規追加',
            'add_new_item'       => 'BeEngineer通信を追加',
            'edit_item'          => 'BeEngineer通信を編集',
            'new_item'           => '新しいBeEngineer通信',
            'view_item'          => 'BeEngineer通信を表示',
            'search_items'       => 'BeEngineer通信を検索',
            'not_found'          => 'BeEngineer通信が見つかりません',
            'not_found_in_trash' => 'ゴミ箱にBeEngineer通信はありません',
            'menu_name'          => 'BeEngineer通信',
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'beengineer-news', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 23,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail'],
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);

    register_taxonomy('beengineer_news_category', ['beengineer-news'], [
        'labels' => [
            'name'          => 'BeEngineer通信カテゴリ',
            'singular_name' => 'BeEngineer通信カテゴリ',
            'menu_name'     => 'BeEngineer通信カテゴリ',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'beengineer-news-category', 'with_front' => false],
    ]);
}
add_action('init', 'mytheme_register_beengineer_news_cpt_and_taxonomy', 9);

/**
 * 初期カテゴリを自動作成
 */
function mytheme_ensure_beengineer_news_category_terms() {
    $terms = [
        'classroom-initiatives'   => '教室の取り組み',
        'educational-philosophy'  => '教育の考え方',
        'events-and-activities'   => 'イベント・活動報告',
        'announcements'           => 'お知らせ',
        'other'                   => 'その他',
    ];

    foreach ( $terms as $slug => $name ) {
        if ( ! term_exists($slug, 'beengineer_news_category') ) {
            wp_insert_term($name, 'beengineer_news_category', ['slug' => $slug]);
        }
    }
}
add_action('init', 'mytheme_ensure_beengineer_news_category_terms', 20);

function mytheme_get_beengineer_news_category_priority() {
    return [
        'classroom-initiatives',
        'educational-philosophy',
        'events-and-activities',
        'announcements',
        'other',
    ];
}

function mytheme_get_beengineer_news_primary_category_term($post_id) {
    $post_id = (int) $post_id;
    $terms = get_the_terms($post_id, 'beengineer_news_category');
    if ( ! is_array($terms) || empty($terms) ) {
        return null;
    }

    $priority = mytheme_get_beengineer_news_category_priority();
    usort($terms, function($a, $b) use ($priority) {
        $a_slug = isset($a->slug) ? (string) $a->slug : '';
        $b_slug = isset($b->slug) ? (string) $b->slug : '';
        $a_pos = array_search($a_slug, $priority, true);
        $b_pos = array_search($b_slug, $priority, true);
        $a_pos = $a_pos === false ? 999 : (int) $a_pos;
        $b_pos = $b_pos === false ? 999 : (int) $b_pos;
        return $a_pos <=> $b_pos;
    });

    $primary = reset($terms);
    return $primary ?: null;
}

function mytheme_get_beengineer_news_primary_category_slug($post_id) {
    $primary = mytheme_get_beengineer_news_primary_category_term($post_id);
    if ( ! $primary || ! isset($primary->slug) ) {
        return 'other';
    }
    return (string) $primary->slug;
}

function mytheme_get_beengineer_news_primary_category_label($post_id) {
    $primary = mytheme_get_beengineer_news_primary_category_term($post_id);
    if ( ! $primary || ! isset($primary->name) ) {
        return 'その他';
    }
    return (string) $primary->name;
}

function mytheme_get_beengineer_news_featured_post_id() {
    $post_id = (int) get_option('mytheme_beengineer_news_featured_post_id', 0);
    if ( $post_id <= 0 ) {
        return 0;
    }

    $post = get_post($post_id);
    if ( ! $post || $post->post_type !== 'beengineer-news' || $post->post_status !== 'publish' ) {
        return 0;
    }

    return $post_id;
}

function mytheme_beengineer_news_assign_serial_if_needed($post_id) {
    $post_id = (int) $post_id;
    $serial = (int) get_post_meta($post_id, '_mytheme_beengineer_news_serial', true);
    if ( $serial > 0 ) {
        return $serial;
    }

    $next = (int) get_option('mytheme_beengineer_news_serial_sequence', 0) + 1;
    update_option('mytheme_beengineer_news_serial_sequence', $next, false);
    update_post_meta($post_id, '_mytheme_beengineer_news_serial', $next);

    return $next;
}

function mytheme_beengineer_news_build_slug($serial, $category_slug) {
    $serial = max(1, (int) $serial);
    $category_slug = sanitize_title((string) $category_slug);
    if ( $category_slug === '' ) {
        $category_slug = 'other';
    }
    return sprintf('b%03d-%s', $serial, $category_slug);
}

function mytheme_beengineer_news_maybe_apply_generated_slug($post_id, $post) {
    static $is_updating = false;

    if ( $is_updating ) return;
    if ( ! $post || $post->post_type !== 'beengineer-news' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( in_array($post->post_status, ['auto-draft', 'inherit', 'trash'], true) ) return;

    $serial = mytheme_beengineer_news_assign_serial_if_needed($post_id);
    $generated = mytheme_beengineer_news_build_slug($serial, mytheme_get_beengineer_news_primary_category_slug($post_id));
    $last_generated = (string) get_post_meta($post_id, '_mytheme_beengineer_news_generated_slug', true);
    $current_slug = (string) $post->post_name;
    $default_title_slug = sanitize_title((string) $post->post_title);

    $can_update_slug = (
        $current_slug === '' ||
        $current_slug === 'auto-draft' ||
        $current_slug === $last_generated ||
        $current_slug === $default_title_slug
    );
    $unique_slug = wp_unique_post_slug($generated, $post_id, $post->post_status, 'beengineer-news', 0);

    if ( $can_update_slug && $current_slug !== $unique_slug ) {
        $is_updating = true;
        wp_update_post([
            'ID'        => $post_id,
            'post_name' => $unique_slug,
        ]);
        $is_updating = false;
        $current_slug = $unique_slug;
    }

    if ( $can_update_slug ) {
        update_post_meta($post_id, '_mytheme_beengineer_news_generated_slug', $current_slug !== '' ? $current_slug : $unique_slug);
    }
}

function mytheme_beengineer_news_apply_generated_slug_after_insert($post_id, $post, $update, $post_before) {
    mytheme_beengineer_news_maybe_apply_generated_slug($post_id, $post);
}
add_action('wp_after_insert_post', 'mytheme_beengineer_news_apply_generated_slug_after_insert', 20, 4);

function mytheme_beengineer_news_apply_generated_slug_on_save($post_id, $post, $update) {
    mytheme_beengineer_news_maybe_apply_generated_slug($post_id, $post);
}
add_action('save_post_beengineer-news', 'mytheme_beengineer_news_apply_generated_slug_on_save', 20, 3);

/**
 * アイキャッチは任意だが推奨である旨を表示
 */
function mytheme_beengineer_news_featured_image_help($content) {
    global $post;

    if ( ! $post || $post->post_type !== 'beengineer-news' ) {
        return $content;
    }

    $help = '<p style="margin-top:8px;font-size:12px;color:#50575e;">アイキャッチ画像は任意ですが、BeEngineer通信では設定推奨です。活動報告やイベント発信では画像があると雰囲気が伝わりやすくなります。</p>';
    return $content . $help;
}
add_filter('admin_post_thumbnail_html', 'mytheme_beengineer_news_featured_image_help');

function mytheme_beengineer_news_add_featured_metabox() {
    add_meta_box(
        'mytheme-beengineer-news-featured',
        '固定表示',
        'mytheme_beengineer_news_render_featured_metabox',
        'beengineer-news',
        'side',
        'high'
    );
}
add_action('add_meta_boxes_beengineer-news', 'mytheme_beengineer_news_add_featured_metabox');

function mytheme_beengineer_news_render_featured_metabox($post) {
    $post_id = (int) $post->ID;
    $is_featured = mytheme_get_beengineer_news_featured_post_id() === $post_id;

    wp_nonce_field('mytheme_beengineer_news_featured_action', 'mytheme_beengineer_news_featured_nonce');
    ?>
    <p>
        <label>
            <input type="checkbox" name="mytheme_beengineer_news_featured" value="1" <?php checked($is_featured); ?>>
            一覧ページの最上部に固定表示する
        </label>
    </p>
    <p style="margin:0;color:#50575e;font-size:12px;">固定できるのは1記事だけです。別の記事を固定すると自動で切り替わります。</p>
    <?php
}

function mytheme_beengineer_news_save_featured_setting($post_id, $post, $update) {
    if ( ! $post || $post->post_type !== 'beengineer-news' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $nonce = isset($_POST['mytheme_beengineer_news_featured_nonce']) ? (string) $_POST['mytheme_beengineer_news_featured_nonce'] : '';
    if ( $nonce === '' || ! wp_verify_nonce($nonce, 'mytheme_beengineer_news_featured_action') ) {
        return;
    }

    $should_feature = ! empty($_POST['mytheme_beengineer_news_featured']);
    $current_featured_id = (int) get_option('mytheme_beengineer_news_featured_post_id', 0);

    if ( $should_feature ) {
        update_option('mytheme_beengineer_news_featured_post_id', (int) $post_id, false);
    } elseif ( $current_featured_id === (int) $post_id ) {
        delete_option('mytheme_beengineer_news_featured_post_id');
    }
}
add_action('save_post_beengineer-news', 'mytheme_beengineer_news_save_featured_setting', 30, 3);

function mytheme_beengineer_news_clear_featured_on_status_change($new_status, $old_status, $post) {
    if ( ! $post || $post->post_type !== 'beengineer-news' ) return;

    $featured_id = (int) get_option('mytheme_beengineer_news_featured_post_id', 0);
    if ( $featured_id !== (int) $post->ID ) return;

    if ( $new_status !== 'publish' ) {
        delete_option('mytheme_beengineer_news_featured_post_id');
    }
}
add_action('transition_post_status', 'mytheme_beengineer_news_clear_featured_on_status_change', 10, 3);

function mytheme_beengineer_news_exclude_featured_from_archive($query) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive('beengineer-news') ) {
        return;
    }

    $featured_id = mytheme_get_beengineer_news_featured_post_id();
    if ( $featured_id > 0 ) {
        $query->set('post__not_in', [$featured_id]);
    }
}
add_action('pre_get_posts', 'mytheme_beengineer_news_exclude_featured_from_archive');

function mytheme_beengineer_news_flush_rewrite_on_switch() {
    mytheme_register_beengineer_news_cpt_and_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'mytheme_beengineer_news_flush_rewrite_on_switch');

function mytheme_beengineer_news_flush_rewrite_once_after_register() {
    $version = 'beengineer-news-rewrite-v1';
    if ( get_option('mytheme_beengineer_news_rewrite_version') === $version ) return;

    flush_rewrite_rules();
    update_option('mytheme_beengineer_news_rewrite_version', $version, false);
}
add_action('init', 'mytheme_beengineer_news_flush_rewrite_once_after_register', 99);
