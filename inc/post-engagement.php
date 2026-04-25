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
 * 1. 同タグ × 人気
 * 2. 同タグ × 新着
 * 3. 同カテゴリ × 人気
 * 4. 同カテゴリ × 新着
 */
function mytheme_get_related_post_ids(int $post_id, int $limit = 3): array {
    $limit = max(1, min(12, $limit));

    $exclude = [$post_id];
    $found = [];

    $tag_ids = wp_list_pluck((array) get_the_tags($post_id), 'term_id');
    $tag_ids = array_values(array_filter(array_map('intval', $tag_ids)));
    $cat_ids = wp_list_pluck((array) get_the_category($post_id), 'term_id');
    $cat_ids = array_values(array_filter(array_map('intval', $cat_ids)));
    // タグ/カテゴリがどちらも無い投稿は関連記事を出さない
    if ( empty($tag_ids) && empty($cat_ids) ) {
        return [];
    }

    // 高速化：関連記事IDを投稿ごとにキャッシュ
    // - 人気順（postmetaソート）は重くなりやすいので、結果をトランジェントに保存して再利用
    $cache_hash = md5(implode(',', $tag_ids) . '|' . implode(',', $cat_ids));
    $cache_key = 'mytheme_rel_v2_' . $post_id . '_' . $limit . '_' . substr($cache_hash, 0, 10);
    $cached = get_transient($cache_key);
    if ( is_array($cached) ) {
        // 念のため型と除外を整える
        $cached = array_values(array_filter(array_map('intval', $cached), function($id) use ($post_id) {
            return $id > 0 && $id !== (int) $post_id;
        }));
        return array_slice($cached, 0, $limit);
    }

    $run = function(array $args) use (&$exclude, &$found, $limit): void {
        if ( count($found) >= $limit ) return;
        $args['posts_per_page'] = $limit - count($found);
        $args['fields'] = 'ids';
        $args['post_status'] = 'publish';
        $args['post_type'] = 'post';
        $args['post__not_in'] = $exclude;
        $q = new WP_Query($args);
        if ( $q->have_posts() ) {
            foreach ( $q->posts as $pid ) {
                $pid = (int) $pid;
                if ( $pid <= 0 ) continue;
                $found[] = $pid;
                $exclude[] = $pid;
                if ( count($found) >= $limit ) break;
            }
        }
        wp_reset_postdata();
    };

    // 1) 同タグ × 人気（閲覧数）優先
    if ( ! empty($tag_ids) ) {
        $run([
            'tag__in'   => $tag_ids,
            'meta_key'  => '_mytheme_post_views',
            'orderby'   => [
                'meta_value_num' => 'DESC',
                'date'           => 'DESC',
            ],
        ]);
    }

    // 2) 同タグ × 新着
    if ( ! empty($tag_ids) ) {
        $run([
            'tag__in'  => $tag_ids,
            'orderby'  => 'date',
            'order'    => 'DESC',
        ]);
    }

    // 3) 同カテゴリ × 人気（閲覧数）優先
    if ( ! empty($cat_ids) ) {
        $run([
            'category__in' => $cat_ids,
            'meta_key'     => '_mytheme_post_views',
            'orderby'      => [
                'meta_value_num' => 'DESC',
                'date'           => 'DESC',
            ],
        ]);
    }

    // 4) 同カテゴリ × 新着
    if ( ! empty($cat_ids) ) {
        $run([
            'category__in' => $cat_ids,
            'orderby'      => 'date',
            'order'        => 'DESC',
        ]);
    }

    // 念のため、現在の記事が混ざっていないことを保証
    $found = array_values(array_filter($found, function($id) use ($post_id) {
        return (int) $id !== (int) $post_id;
    }));

    // 6時間キャッシュ（アクセス増でもDB負荷を抑える）
    set_transient($cache_key, $found, 6 * HOUR_IN_SECONDS);

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
        echo '<article class="related-posts__card">';
        echo '<h3 class="related-posts__card-title"><a class="related-posts__link" href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h3>';
        echo '<div class="related-posts__meta">';
        echo '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>';
        if ( has_category() ) {
            echo ' <span class="related-posts__sep">|</span> <span class="related-posts__cats">' . wp_kses_post(get_the_category_list(', ')) . '</span>';
        }
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
        } elseif ( has_category() ) {
            $cats = get_the_category();
            if ( is_array($cats) && ! empty($cats) ) {
                echo '<div class="related-posts__tags" aria-label="カテゴリ">';
                foreach ( array_slice($cats, 0, 2) as $cat ) {
                    $cat_name = isset($cat->name) ? (string) $cat->name : '';
                    if ( $cat_name === '' ) continue;
                    echo '<span class="related-posts__tag related-posts__tag--category">' . esc_html($cat_name) . '</span>';
                }
                echo '</div>';
            }
        }
        $raw_excerpt = get_the_excerpt();
        $excerpt = wp_trim_words( wp_strip_all_tags((string) $raw_excerpt), 22, '…' );
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
    $key = 'mytheme_rel_v2_' . (int) $post_id . '_3_' . substr(md5(implode(',', $tag_ids) . '|' . implode(',', $cat_ids)), 0, 10);
    delete_transient($key);
}
add_action('save_post', 'mytheme_purge_related_posts_cache_on_save', 10, 3);
