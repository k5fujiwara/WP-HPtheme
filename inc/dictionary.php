<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 辞書（dictionary）投稿タイプ + タクソノミー
 */
function mytheme_register_dictionary_cpt_and_taxonomy() {
    register_post_type('dictionary', [
        'labels' => [
            'name'               => '辞書',
            'singular_name'      => '辞書',
            'add_new'            => '新規追加',
            'add_new_item'       => '辞書を追加',
            'edit_item'          => '辞書を編集',
            'new_item'           => '新しい辞書',
            'view_item'          => '辞書を表示',
            'search_items'       => '辞書を検索',
            'not_found'          => '辞書が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に辞書はありません',
            'menu_name'          => '辞書',
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'dictionary', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 21,
        'menu_icon'           => 'dashicons-book-alt',
        'supports'            => ['title', 'editor', 'excerpt', 'thumbnail'],
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);

    register_taxonomy('dic_category', ['dictionary'], [
        'labels' => [
            'name'          => '辞書カテゴリ',
            'singular_name' => '辞書カテゴリ',
            'menu_name'     => '辞書カテゴリ',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'dic-category', 'with_front' => false],
    ]);
}
add_action('init', 'mytheme_register_dictionary_cpt_and_taxonomy', 9);

/**
 * 辞書カテゴリの初期タームを作成（1回だけ）
 */
function mytheme_ensure_dic_category_terms() {
    $terms = ['教育', 'プログラミング', '自己啓発'];
    foreach ( $terms as $name ) {
        if ( ! term_exists($name, 'dic_category') ) {
            wp_insert_term($name, 'dic_category');
        }
    }
}
add_action('init', 'mytheme_ensure_dic_category_terms', 20);

/**
 * 辞書のダミー3件を一度だけ作成
 */
function mytheme_seed_dictionary_dummy_entries_once() {
    if ( get_option('mytheme_dictionary_dummy_seeded_v1') ) return;

    $items = [
        [
            'title'    => '知的体力',
            'content'  => '知的体力とは、地道な作業や反復を通じて思考を持続させる力です。学習や開発の現場で成果を積み上げる土台になります。',
            'category' => '自己啓発',
        ],
        [
            'title'    => 'メタ認知',
            'content'  => 'メタ認知とは、自分の理解状態や思考プロセスを客観的に捉える力です。学習効率の改善や意思決定の質向上に直結します。',
            'category' => '教育',
        ],
        [
            'title'    => 'リファクタリング',
            'content'  => 'リファクタリングとは、外部仕様を変えずに内部構造を改善する開発手法です。保守性を高め、長期的な開発速度を維持します。',
            'category' => 'プログラミング',
        ],
    ];

    foreach ( $items as $it ) {
        $title = (string) $it['title'];
        if ( $title === '' ) continue;

        // 同名タイトルが既にあれば重複作成しない
        $existing = get_page_by_title($title, OBJECT, 'dictionary');
        if ( $existing && ! is_wp_error($existing) ) continue;

        $new_id = wp_insert_post([
            'post_type'    => 'dictionary',
            'post_status'  => 'publish',
            'post_title'   => $title,
            'post_content' => (string) $it['content'],
        ]);

        if ( ! is_wp_error($new_id) && ! empty($it['category']) ) {
            wp_set_object_terms((int) $new_id, [(string) $it['category']], 'dic_category', false);
        }
    }

    update_option('mytheme_dictionary_dummy_seeded_v1', 1);
}
add_action('init', 'mytheme_seed_dictionary_dummy_entries_once', 30);

/**
 * 辞書アーカイブを50音順相当（タイトル昇順）に整列
 */
function mytheme_dictionary_archive_order($query) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( ! is_post_type_archive('dictionary') ) return;

    // カテゴリ絞り込み（?dic_cat=slug）
    $dic_cat = isset($_GET['dic_cat']) ? sanitize_text_field(wp_unslash((string) $_GET['dic_cat'])) : '';
    if ( $dic_cat !== '' ) {
        $term = get_term_by('slug', $dic_cat, 'dic_category');
        if ( $term && ! is_wp_error($term) ) {
            $query->set('tax_query', [
                [
                    'taxonomy' => 'dic_category',
                    'field'    => 'slug',
                    'terms'    => [$dic_cat],
                ],
            ]);
        }
    }

    // あいうえお順相当（タイトル昇順）
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', 300);
}
add_action('pre_get_posts', 'mytheme_dictionary_archive_order');

/**
 * 辞書単語にマッチする既存コラム候補を取得してスコアリング
 */
function mytheme_dictionary_find_related_posts($term, $limit = 3) {
    $term = trim((string) $term);
    if ( $term === '' ) return [];

    // 文字種ゆれ対策（全角/半角）
    $normalized = mb_convert_kana($term, 'asKV', 'UTF-8');
    $needle     = mb_strtolower($normalized, 'UTF-8');

    // 初期候補は検索APIに任せて絞る（重い全件走査を避ける）
    $candidates = get_posts([
        'post_type'              => 'post',
        'post_status'            => 'publish',
        's'                      => $term,
        'posts_per_page'         => 40,
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'fields'                 => 'ids',
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'suppress_filters'       => false,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);

    if ( empty($candidates) ) return [];

    $scores = [];
    foreach ( $candidates as $pid ) {
        $title   = get_the_title($pid);
        $content = (string) get_post_field('post_content', $pid);

        $title_n   = mb_strtolower(mb_convert_kana((string) $title, 'asKV', 'UTF-8'), 'UTF-8');
        $content_n = mb_strtolower(mb_convert_kana($content, 'asKV', 'UTF-8'), 'UTF-8');

        $title_hits = preg_match_all('/' . preg_quote($needle, '/') . '/u', $title_n, $m1);
        $body_hits  = preg_match_all('/' . preg_quote($needle, '/') . '/u', $content_n, $m2);

        // タイトル一致を強く評価 + 直近記事を微加点
        $score = ($title_hits * 10) + ($body_hits * 2);
        $score += max(0, 3 - (int) ((time() - (int) get_post_time('U', true, $pid)) / DAY_IN_SECONDS / 30));

        if ( $score > 0 ) {
            $scores[$pid] = $score;
        }
    }

    if ( empty($scores) ) return [];

    arsort($scores, SORT_NUMERIC);
    return array_slice(array_map('intval', array_keys($scores)), 0, max(1, (int) $limit));
}

/**
 * 辞書保存時に関連記事を再計算（常に最新状態を反映）
 */
function mytheme_dictionary_update_related_posts_on_save($post_id, $post, $update) {
    if ( ! $post || $post->post_type !== 'dictionary' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    if ( $post->post_status !== 'publish' ) {
        delete_post_meta($post_id, '_related_post_ids');
        return;
    }

    $related_ids = mytheme_dictionary_find_related_posts($post->post_title, 3);
    update_post_meta($post_id, '_related_post_ids', $related_ids);
    update_post_meta($post_id, '_related_post_ids_updated_at', time());
}
add_action('save_post_dictionary', 'mytheme_dictionary_update_related_posts_on_save', 10, 3);

/**
 * ハイブリッド方式の関連記事取得
 * - 通常は保存済みメタを使う
 * - 一定時間（デフォルト6時間）を過ぎたら最新投稿状態で再計算して更新
 */
function mytheme_dictionary_get_related_posts_hybrid($dictionary_post_id, $term, $limit = 3) {
    $dictionary_post_id = (int) $dictionary_post_id;
    $limit = max(1, (int) $limit);
    $ttl = 6 * HOUR_IN_SECONDS;

    $ids = get_post_meta($dictionary_post_id, '_related_post_ids', true);
    $ids = is_array($ids) ? array_values(array_map('intval', $ids)) : [];
    $ids = array_values(array_filter($ids, function($id) {
        return $id > 0 && get_post_status($id) === 'publish';
    }));

    $updated_at = (int) get_post_meta($dictionary_post_id, '_related_post_ids_updated_at', true);
    $is_stale = ( $updated_at <= 0 ) || ( (time() - $updated_at) >= $ttl );

    // 古い/未計算時のみ再計算（負荷抑制）
    if ( $is_stale ) {
        $recalculated = mytheme_dictionary_find_related_posts($term, $limit);
        update_post_meta($dictionary_post_id, '_related_post_ids', $recalculated);
        update_post_meta($dictionary_post_id, '_related_post_ids_updated_at', time());
        $ids = $recalculated;
    }

    return array_slice($ids, 0, $limit);
}

/**
 * デッドエンド防止用: 最新コラム3件（短期キャッシュ）
 */
function mytheme_dictionary_get_latest_posts_fallback($limit = 3) {
    $limit = max(1, (int) $limit);
    $key   = 'mytheme_dict_latest_posts_' . $limit;
    $ids   = get_transient($key);
    if ( is_array($ids) ) return $ids;

    $ids = get_posts([
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'posts_per_page'         => $limit,
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'fields'                 => 'ids',
        'no_found_rows'          => true,
        'ignore_sticky_posts'    => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    ]);

    $ids = array_values(array_map('intval', (array) $ids));
    set_transient($key, $ids, 10 * MINUTE_IN_SECONDS);
    return $ids;
}

/**
 * 辞書詳細ページの末尾に関連記事を自動表示
 */
function mytheme_dictionary_append_related_links($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('dictionary') || ! in_the_loop() || ! is_main_query() ) return $content;

    $post_id = (int) get_the_ID();
    $ids = mytheme_dictionary_get_related_posts_hybrid($post_id, get_the_title($post_id), 3);

    $title = '関連記事';
    if ( empty($ids) ) {
        $ids = mytheme_dictionary_get_latest_posts_fallback(3);
        $title = '関連記事';
    }

    if ( empty($ids) ) return $content;

    $html = '<section class="dictionary-related-posts" aria-label="' . esc_attr($title) . '">';
    $html .= '<h2 class="dictionary-related-posts__title">' . esc_html($title) . '</h2>';
    $html .= '<ul class="dictionary-related-posts__list">';
    foreach ( $ids as $pid ) {
        $html .= '<li class="dictionary-related-posts__item">';
        $html .= '<a class="dictionary-related-posts__link" href="' . esc_url(get_permalink($pid)) . '">';
        $html .= esc_html(get_the_title($pid));
        $html .= '</a>';
        $html .= '</li>';
    }
    $html .= '</ul>';
    $html .= '</section>';

    return $content . $html;
}
add_filter('the_content', 'mytheme_dictionary_append_related_links', 30);

/**
 * メインメニュー末尾に「辞書一覧」を自動挿入（既存があれば二重追加しない）
 */
function mytheme_append_dictionary_menu_item($items, $args) {
    if ( ! isset($args->theme_location) || $args->theme_location !== 'primary' ) return $items;

    $archive = get_post_type_archive_link('dictionary');
    if ( ! $archive ) return $items;
    if ( strpos($items, esc_url($archive)) !== false ) return $items;

    $class = ( is_post_type_archive('dictionary') || is_singular('dictionary') )
        ? ' menu-item current-menu-item site-nav__item site-nav__item--current'
        : ' menu-item site-nav__item';

    $items .= '<li class="' . esc_attr(trim($class)) . '">';
    $items .= '<a class="site-nav__link" href="' . esc_url($archive) . '">辞書一覧</a>';
    $items .= '</li>';
    return $items;
}
add_filter('wp_nav_menu_items', 'mytheme_append_dictionary_menu_item', 20, 2);

/**
 * 初回有効化時にリライトルール更新（テーマ切り替え時）
 */
function mytheme_dictionary_flush_rewrite_on_switch() {
    mytheme_register_dictionary_cpt_and_taxonomy();
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'mytheme_dictionary_flush_rewrite_on_switch');

/**
 * 辞書CPT導入後のリライトルール更新（1回だけ）
 * - /dictionary/ が404になる初期状態を自動復旧
 */
function mytheme_dictionary_flush_rewrite_once_after_register() {
    $version = 'dictionary-rewrite-v1';
    if ( get_option('mytheme_dictionary_rewrite_version') === $version ) return;

    // register_post_type 後に実行されるよう init の遅い優先度で呼ぶ
    flush_rewrite_rules(false);
    update_option('mytheme_dictionary_rewrite_version', $version);
}
add_action('init', 'mytheme_dictionary_flush_rewrite_once_after_register', 99);

