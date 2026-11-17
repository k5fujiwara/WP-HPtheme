<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 投稿の閲覧数を軽量にカウント（人気記事の並び替え用）
 * - 1投稿につき、同一ブラウザは1日1回だけ加算（Cookieで抑制）
 */
function mytheme_track_post_views() {
    if ( is_admin() ) return;
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( ! is_singular('post') ) return;
    // ログイン中（運営者）・ボットは除外（DB書き込み削減）
    if ( function_exists('is_user_logged_in') && is_user_logged_in() ) return;
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? (string) $_SERVER['HTTP_USER_AGENT'] : '';
    if ( $ua === '' || preg_match('/bot|spider|crawl|slurp|bingpreview|facebookexternalhit|discordbot|twitterbot|googlebot|adsbot|duckduckbot|baiduspider|yandexbot/i', $ua) ) {
        return;
    }

    $post_id = (int) get_queried_object_id();
    if ( $post_id <= 0 ) return;

    $cookie_name = 'mytheme_viewed_post_' . $post_id;
    if ( isset($_COOKIE[$cookie_name]) ) return;

    $views = (int) get_post_meta($post_id, '_mytheme_post_views', true);
    $views++;
    update_post_meta($post_id, '_mytheme_post_views', $views);

    if ( ! headers_sent() ) {
        setcookie($cookie_name, '1', [
            'expires'  => time() + DAY_IN_SECONDS,
            'path'     => '/',
            'secure'   => is_ssl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
add_action('template_redirect', 'mytheme_track_post_views', 1);

/**
 * 関連記事IDを取得
 * 優先度:
 * 1. 同タグ
 * 2. 同一表示テーマ
 * 3. 同カテゴリ
 * 4. 公開日の近さ
 */
function mytheme_get_related_post_ids(int $post_id, int $limit = 3): array {
    $limit = max(1, min(12, $limit));

    $tag_ids = wp_list_pluck((array) get_the_tags($post_id), 'term_id');
    $tag_ids = array_values(array_filter(array_map('intval', $tag_ids)));
    $cat_ids = wp_list_pluck((array) get_the_category($post_id), 'term_id');
    $cat_ids = array_values(array_filter(array_map('intval', $cat_ids)));
    $theme_slug = function_exists('mytheme_get_learning_column_theme_slug')
        ? mytheme_get_learning_column_theme_slug($post_id)
        : '';
    $published = (int) get_the_time('U', $post_id);
    $cat_lookup = array_fill_keys($cat_ids, true);
    $tag_lookup = array_fill_keys($tag_ids, true);

    $candidate_ids = get_posts([
        'post_type'              => 'post',
        'post_status'            => 'publish',
        'fields'                 => 'ids',
        'posts_per_page'         => 80,
        'post__not_in'           => [$post_id],
        'orderby'                => 'date',
        'order'                  => 'DESC',
        'no_found_rows'          => true,
        'update_post_meta_cache' => true,
        'update_post_term_cache' => true,
    ]);

    $scored = [];
    foreach ( (array) $candidate_ids as $candidate_id ) {
        $candidate_id = (int) $candidate_id;
        if ( $candidate_id <= 0 || $candidate_id === $post_id ) continue;

        $candidate_tag_ids = wp_list_pluck((array) get_the_tags($candidate_id), 'term_id');
        $candidate_tag_ids = array_values(array_filter(array_map('intval', $candidate_tag_ids)));
        $shared_tag_count = 0;
        foreach ( $candidate_tag_ids as $tag_id ) {
            if ( isset($tag_lookup[$tag_id]) ) {
                $shared_tag_count++;
            }
        }

        $candidate_theme = function_exists('mytheme_get_learning_column_theme_slug')
            ? mytheme_get_learning_column_theme_slug($candidate_id)
            : '';
        $same_theme = $theme_slug !== '' && $theme_slug !== 'review-required' && $candidate_theme === $theme_slug;

        $candidate_cat_ids = wp_list_pluck((array) get_the_category($candidate_id), 'term_id');
        $candidate_cat_ids = array_values(array_filter(array_map('intval', $candidate_cat_ids)));
        $shared_cat_count = 0;
        foreach ( $candidate_cat_ids as $cat_id ) {
            if ( isset($cat_lookup[$cat_id]) ) {
                $shared_cat_count++;
            }
        }

        $score = ($shared_tag_count * 3) + ($same_theme ? 2 : 0) + ($shared_cat_count > 0 ? 1 : 0);
        $scored[] = [
            'id'        => $candidate_id,
            'score'     => $score,
            'sharedTag' => $shared_tag_count,
            'sameTheme' => $same_theme ? 1 : 0,
            'sharedCat' => $shared_cat_count,
            'date'      => (int) get_the_time('U', $candidate_id),
            'distance'  => $published > 0 ? abs((int) get_the_time('U', $candidate_id) - $published) : PHP_INT_MAX,
        ];
    }

    usort($scored, function($a, $b) {
        if ( (int) $a['score'] !== (int) $b['score'] ) {
            return (int) $b['score'] <=> (int) $a['score'];
        }
        if ( (int) $a['sharedTag'] !== (int) $b['sharedTag'] ) {
            return (int) $b['sharedTag'] <=> (int) $a['sharedTag'];
        }
        if ( (int) $a['sameTheme'] !== (int) $b['sameTheme'] ) {
            return (int) $b['sameTheme'] <=> (int) $a['sameTheme'];
        }
        if ( (int) $a['score'] === 0 && (int) $a['distance'] !== (int) $b['distance'] ) {
            return (int) $a['distance'] <=> (int) $b['distance'];
        }
        return (int) $b['date'] <=> (int) $a['date'];
    });

    $found = [];
    foreach ( $scored as $item ) {
        $id = (int) $item['id'];
        if ( $id <= 0 || $id === $post_id || in_array($id, $found, true) ) continue;
        $found[] = $id;
        if ( count($found) >= $limit ) break;
    }

    return $found;
}

/**
 * 投稿ページ下部に「関連記事」を表示
 */
function mytheme_render_related_posts(int $post_id, int $limit = 3): void {
    if ( $post_id <= 0 ) return;
    $ids = mytheme_get_related_post_ids($post_id, $limit);
    if ( empty($ids) ) return;
    $current_tag_ids = wp_list_pluck((array) get_the_tags($post_id), 'term_id');
    $current_tag_ids = array_values(array_filter(array_map('intval', $current_tag_ids)));

    $q = new WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => count($ids),
        'post__in'       => $ids,
        'orderby'        => 'post__in',
    ]);
    if ( ! $q->have_posts() ) {
        wp_reset_postdata();
        return;
    }

    echo '<section class="related-posts" aria-label="関連記事">';
    echo '<h2 class="related-posts__title">関連記事</h2>';
    echo '<div class="related-posts__grid">';
    $rendered = 0;
    while ( $q->have_posts() ) {
        $q->the_post();
        if ( (int) get_the_ID() === (int) $post_id ) {
            continue; // 念のための保険（同一記事は絶対出さない）
        }
        $theme = function_exists('mytheme_get_learning_column_theme_meta')
            ? mytheme_get_learning_column_theme_meta(get_the_ID())
            : null;
        echo '<article class="related-posts__card">';
        if ( $theme ) {
            echo '<span class="related-posts__theme ' . esc_attr((string) $theme['class']) . '">' . esc_html((string) $theme['label']) . '</span>';
        }
        echo '<h3 class="related-posts__card-title"><a class="related-posts__link" href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
        echo '<div class="related-posts__meta">';
        echo '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>';
        echo '</div>';
        $shared_tags = [];
        if ( ! empty($current_tag_ids) ) {
            $post_tags = get_the_tags();
            if ( is_array($post_tags) ) {
                foreach ( $post_tags as $tag ) {
                    $tag_id = isset($tag->term_id) ? (int) $tag->term_id : 0;
                    if ( $tag_id > 0 && in_array($tag_id, $current_tag_ids, true) ) {
                        $shared_tags[] = isset($tag->name) ? (string) $tag->name : '';
                    }
                    if ( count($shared_tags) >= 3 ) break;
                }
            }
        }
        $shared_tags = array_values(array_filter($shared_tags));
        if ( ! empty($shared_tags) ) {
            echo '<div class="related-posts__tags" aria-label="共通タグ">';
            foreach ( $shared_tags as $tag_name ) {
                echo '<span class="related-posts__tag">#' . esc_html($tag_name) . '</span>';
            }
            echo '</div>';
        }
        $raw_excerpt = get_the_excerpt();
        $excerpt_text = wp_strip_all_tags((string) $raw_excerpt);
        $excerpt = function_exists('wp_html_excerpt')
            ? wp_html_excerpt($excerpt_text, 90, '…')
            : $excerpt_text;
        echo '<p class="related-posts__excerpt">' . esc_html($excerpt) . '</p>';
        echo '</article>';
        $rendered++;
    }
    echo '</div></section>';

    wp_reset_postdata();
    if ( $rendered === 0 ) {
        // もし全て弾かれて空になった場合はセクションごと出さない
        // （出力済みなので、ここでは何もしない＝仕様上ほぼ起きない想定）
    }
}

/**
 * 関連記事キャッシュの削除（投稿更新時）
 * - 投稿のカテゴリ変更/内容変更で関連が変わるため、その投稿のキャッシュだけ削除
 * - 他投稿のキャッシュはTTLで自然更新（高速化優先）
 */
function mytheme_purge_related_posts_cache_on_save($post_id, $post, $update) {
    if ( wp_is_post_revision($post_id) ) return;
    if ( ! $post || $post->post_type !== 'post' ) return;

    // limit=3 を想定（必要なら増やす）
    $cat_ids = wp_list_pluck((array) get_the_category($post_id), 'term_id');
    $cat_ids = array_values(array_filter(array_map('intval', $cat_ids)));
    if ( empty($cat_ids) ) return;

    $tag_ids = wp_list_pluck((array) get_the_tags($post_id), 'term_id');
    $tag_ids = array_values(array_filter(array_map('intval', $tag_ids)));
    $theme_slug = function_exists('mytheme_get_learning_column_theme_slug')
        ? mytheme_get_learning_column_theme_slug($post_id)
        : '';
    $key = 'mytheme_rel_v3_' . (int) $post_id . '_3_' . substr(md5(implode(',', $tag_ids) . '|' . implode(',', $cat_ids) . '|' . $theme_slug), 0, 10);
    delete_transient($key);
}
add_action('save_post', 'mytheme_purge_related_posts_cache_on_save', 10, 3);
