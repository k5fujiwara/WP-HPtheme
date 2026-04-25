<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * お知らせ（news）投稿タイプ + タクソノミー
 */
function mytheme_register_news_cpt_and_taxonomy() {
    register_post_type('news', [
        'labels' => [
            'name'               => 'お知らせ',
            'singular_name'      => 'お知らせ',
            'add_new'            => '新規追加',
            'add_new_item'       => 'お知らせを追加',
            'edit_item'          => 'お知らせを編集',
            'new_item'           => '新しいお知らせ',
            'view_item'          => 'お知らせを表示',
            'search_items'       => 'お知らせを検索',
            'not_found'          => 'お知らせが見つかりません',
            'not_found_in_trash' => 'ゴミ箱にお知らせはありません',
            'menu_name'          => 'お知らせ',
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'news', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 22,
        'menu_icon'           => 'dashicons-megaphone',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail'],
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);

    register_taxonomy('news_category', ['news'], [
        'labels' => [
            'name'          => 'お知らせカテゴリ',
            'singular_name' => 'お知らせカテゴリ',
            'menu_name'     => 'お知らせカテゴリ',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'news-category', 'with_front' => false],
    ]);
}
add_action('init', 'mytheme_register_news_cpt_and_taxonomy', 9);

/**
 * 初期カテゴリを自動作成
 */
function mytheme_ensure_news_category_terms() {
    $terms = [
        'important-notice' => '重要なお知らせ',
        'update-notice'    => '更新のお知らせ',
        'site-update'      => 'サイト改善',
        'book-info'        => '書籍情報',
        'other'            => 'その他',
    ];

    foreach ( $terms as $slug => $name ) {
        if ( ! term_exists($slug, 'news_category') ) {
            wp_insert_term($name, 'news_category', ['slug' => $slug]);
        }
    }
}
add_action('init', 'mytheme_ensure_news_category_terms', 20);

/**
 * お知らせカテゴリの表示優先順
 */
function mytheme_get_news_category_priority() {
    return [
        'important-notice',
        'update-notice',
        'site-update',
        'book-info',
        'other',
    ];
}

/**
 * 主カテゴリタームを取得
 */
function mytheme_get_news_primary_category_term($post_id) {
    $post_id = (int) $post_id;
    $terms = get_the_terms($post_id, 'news_category');
    if ( ! is_array($terms) || empty($terms) ) {
        return null;
    }

    $priority = mytheme_get_news_category_priority();
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

/**
 * 主カテゴリスラッグを取得
 */
function mytheme_get_news_primary_category_slug($post_id) {
    $primary = mytheme_get_news_primary_category_term($post_id);
    if ( ! $primary || ! isset($primary->slug) ) {
        return 'other';
    }
    return (string) $primary->slug;
}

/**
 * 主カテゴリ名を取得
 */
function mytheme_get_news_primary_category_label($post_id) {
    $primary = mytheme_get_news_primary_category_term($post_id);
    if ( ! $primary || ! isset($primary->name) ) {
        return 'その他';
    }
    return (string) $primary->name;
}

/**
 * 表示用タイトル
 *
 * タイトル先頭に手動の【カテゴリ】が入っていても重複しないようにする。
 */
function mytheme_get_news_display_title($post_id) {
    $post_id = (int) $post_id;
    $title = get_the_title($post_id);
    $title = is_string($title) ? trim($title) : '';
    $title = preg_replace('/^[\[\【][^\]\】]{1,30}[\]\】]\s*/u', '', $title);
    $label = mytheme_get_news_primary_category_label($post_id);

    if ( $title === '' ) {
        return '【' . $label . '】';
    }

    return '【' . $label . '】' . $title;
}

/**
 * お知らせ一覧項目を共通描画
 */
function mytheme_render_news_list_items($query, $args = []) {
    if ( ! ( $query instanceof WP_Query ) || ! $query->have_posts() ) {
        return;
    }

    $defaults = [
        'item_class'     => 'news-archive-item',
        'link_class'     => 'news-archive-item__link',
        'date_class'     => 'news-archive-item__date',
        'title_class'    => 'news-archive-item__title',
        'date_format'    => 'Y.m.d',
        'date_position'  => 'left',
    ];
    $args = wp_parse_args($args, $defaults);

    while ( $query->have_posts() ) {
        $query->the_post();
        $post_id = (int) get_the_ID();
        $display_title = mytheme_get_news_display_title($post_id);
        $date_html = '<time class="' . esc_attr((string) $args['date_class']) . '" datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date((string) $args['date_format'])) . '</time>';
        $title_html = '<span class="' . esc_attr((string) $args['title_class']) . '">' . esc_html((string) $display_title) . '</span>';

        echo '<li class="' . esc_attr((string) $args['item_class']) . '">';
        echo '<a class="' . esc_attr((string) $args['link_class']) . '" href="' . esc_url(get_permalink()) . '">';
        echo $args['date_position'] === 'right' ? $title_html . $date_html : $date_html . $title_html;
        echo '</a>';
        echo '</li>';
    }
}

/**
 * お知らせ連番を採番
 */
function mytheme_news_assign_serial_if_needed($post_id) {
    $post_id = (int) $post_id;
    $serial = (int) get_post_meta($post_id, '_mytheme_news_serial', true);
    if ( $serial > 0 ) {
        return $serial;
    }

    $next = (int) get_option('mytheme_news_serial_sequence', 0) + 1;
    update_option('mytheme_news_serial_sequence', $next, false);
    update_post_meta($post_id, '_mytheme_news_serial', $next);

    return $next;
}

/**
 * スラッグ候補を作成
 */
function mytheme_news_build_slug($serial, $category_slug) {
    $serial = max(1, (int) $serial);
    $category_slug = sanitize_title((string) $category_slug);

    if ( $category_slug === '' ) {
        $category_slug = 'other';
    }

    return sprintf('n%03d-%s', $serial, $category_slug);
}

/**
 * 保存時に英語スラッグを自動設定
 *
 * - WordPress が初回保存時に自動生成したスラッグは上書き対象
 * - 手動変更されたスラッグは上書きしない
 */
function mytheme_news_maybe_apply_generated_slug($post_id, $post) {
    static $is_updating = false;

    if ( $is_updating ) return;
    if ( ! $post || $post->post_type !== 'news' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( in_array($post->post_status, ['auto-draft', 'inherit', 'trash'], true) ) return;

    $serial = mytheme_news_assign_serial_if_needed($post_id);
    $generated = mytheme_news_build_slug($serial, mytheme_get_news_primary_category_slug($post_id));
    $last_generated = (string) get_post_meta($post_id, '_mytheme_news_generated_slug', true);
    $current_slug = (string) $post->post_name;
    $default_title_slug = sanitize_title((string) $post->post_title);

    // WP標準の自動スラッグ（タイトル由来）は、まだ「手動変更」ではないとみなす
    $can_update_slug = (
        $current_slug === '' ||
        $current_slug === 'auto-draft' ||
        $current_slug === $last_generated ||
        $current_slug === $default_title_slug
    );
    $unique_slug = wp_unique_post_slug($generated, $post_id, $post->post_status, 'news', 0);

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
        update_post_meta($post_id, '_mytheme_news_generated_slug', $current_slug !== '' ? $current_slug : $unique_slug);
    }
}

function mytheme_news_apply_generated_slug_after_insert($post_id, $post, $update, $post_before) {
    mytheme_news_maybe_apply_generated_slug($post_id, $post);
}
add_action('wp_after_insert_post', 'mytheme_news_apply_generated_slug_after_insert', 20, 4);

/**
 * 互換用: 古い環境や保存経路差異でも確実に適用
 */
function mytheme_news_apply_generated_slug_on_save($post_id, $post, $update) {
    mytheme_news_maybe_apply_generated_slug($post_id, $post);
}
add_action('save_post_news', 'mytheme_news_apply_generated_slug_on_save', 20, 3);

/**
 * アイキャッチは任意だと管理画面で分かるように補助
 */
function mytheme_news_featured_image_help($content) {
    global $post;

    if ( ! $post || $post->post_type !== 'news' ) {
        return $content;
    }

    $help = '<p style="margin-top:8px;font-size:12px;color:#50575e;">アイキャッチ画像は任意です。書籍情報や機能追加では設定推奨、サイト案内や更新告知では未設定でも問題ありません。</p>';

    return $content . $help;
}
add_filter('admin_post_thumbnail_html', 'mytheme_news_featured_image_help');

/**
 * 一覧/個別URL用のリライトルールを有効化
 */
function mytheme_news_flush_rewrite_on_switch() {
    mytheme_register_news_cpt_and_taxonomy();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'mytheme_news_flush_rewrite_on_switch');

function mytheme_news_flush_rewrite_once_after_register() {
    if ( get_option('mytheme_news_rewrite_flushed_v1') ) return;
    flush_rewrite_rules();
    update_option('mytheme_news_rewrite_flushed_v1', 1, false);
}
add_action('init', 'mytheme_news_flush_rewrite_once_after_register', 99);
