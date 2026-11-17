<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * サイト内検索で「タグ名に一致する投稿」も検索結果へ含める
 * - 通常のタイトル/本文検索はそのまま維持
 * - 一致するタグを持つ投稿IDだけを OR 条件で追加する
 */
function mytheme_expand_search_results_with_tags($query) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) return;

    $query->set('post_type', 'post');

    $search_term = trim((string) $query->get('s'));
    if ( $search_term === '' ) return;

    $matched_tag_ids = get_terms([
        'taxonomy'   => 'post_tag',
        'hide_empty' => false,
        'fields'     => 'ids',
        'search'     => $search_term,
        'number'     => 20,
    ]);
    if ( is_wp_error($matched_tag_ids) || empty($matched_tag_ids) ) return;

    $matched_post_ids = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'posts_per_page' => 50,
        'tag__in'        => array_map('intval', (array) $matched_tag_ids),
        'orderby'        => 'date',
        'order'          => 'DESC',
        'no_found_rows'  => true,
    ]);
    $matched_post_ids = array_values(array_filter(array_map('intval', (array) $matched_post_ids)));
    if ( empty($matched_post_ids) ) return;

    $query->set('_mytheme_search_tag_post_ids', $matched_post_ids);
}
add_action('pre_get_posts', 'mytheme_expand_search_results_with_tags');

/**
 * 検索SQLへ「タグ一致の投稿ID」を OR 条件で追加
 */
function mytheme_extend_search_sql_with_tag_matches($search, $query) {
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_search() ) return $search;

    $post_ids = array_values(array_filter(array_map('intval', (array) $query->get('_mytheme_search_tag_post_ids'))));
    if ( empty($post_ids) ) return $search;

    global $wpdb;
    $id_sql = implode(',', $post_ids);
    if ( $id_sql === '' ) return $search;

    $trimmed_search = trim((string) $search);
    if ( $trimmed_search === '' ) {
        return " AND ({$wpdb->posts}.ID IN ({$id_sql}))";
    }

    $trimmed_search = preg_replace('/^\s*AND\s*/', '', $trimmed_search, 1);
    return " AND (({$trimmed_search}) OR ({$wpdb->posts}.ID IN ({$id_sql})))";
}
add_filter('posts_search', 'mytheme_extend_search_sql_with_tag_matches', 10, 2);
