<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 学習おすすめYouTube動画
 */
function mytheme_register_youtube_learning_cpt_and_taxonomies() {
    register_post_type('youtube_learning', [
        'labels' => [
            'name'               => '学習おすすめ動画',
            'singular_name'      => '学習おすすめ動画',
            'add_new'            => '新規追加',
            'add_new_item'       => '学習おすすめ動画を追加',
            'edit_item'          => '学習おすすめ動画を編集',
            'new_item'           => '新しい学習おすすめ動画',
            'view_item'          => '学習おすすめ動画を表示',
            'search_items'       => '学習おすすめ動画を検索',
            'not_found'          => '学習おすすめ動画が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に学習おすすめ動画はありません',
            'menu_name'          => '学習おすすめ動画',
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'youtube-learning', 'with_front' => false],
        'show_in_rest'        => true,
        'menu_position'       => 25,
        'menu_icon'           => 'dashicons-video-alt3',
        'supports'            => ['title', 'editor', 'excerpt'],
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
    ]);

    register_taxonomy('yt_channel', ['youtube_learning'], [
        'labels' => [
            'name'          => 'YouTuber',
            'singular_name' => 'YouTuber',
            'menu_name'     => 'YouTuber',
        ],
        'public'            => true,
        'hierarchical'      => false,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'youtube-channel', 'with_front' => false],
    ]);

    register_taxonomy('yt_topic', ['youtube_learning'], [
        'labels' => [
            'name'          => '学習ジャンル',
            'singular_name' => '学習ジャンル',
            'menu_name'     => '学習ジャンル',
        ],
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'youtube-topic', 'with_front' => false],
    ]);

}
add_action('init', 'mytheme_register_youtube_learning_cpt_and_taxonomies', 9);

function mytheme_youtube_learning_topic_order() {
    return ['AI', 'IT', '学習方法', '教育', '心理学', '自己啓発', '人材育成・指導', 'スピーチ・プレゼン', 'プログラミング'];
}

function mytheme_youtube_learning_sort_terms_by_topic_order($terms) {
    if ( ! is_array($terms) || empty($terms) ) return $terms;

    $order_index = array_flip(mytheme_youtube_learning_topic_order());
    usort($terms, function($a, $b) use ($order_index) {
        $a_name = isset($a->name) ? (string) $a->name : '';
        $b_name = isset($b->name) ? (string) $b->name : '';
        $a_pos = array_key_exists($a_name, $order_index) ? (int) $order_index[$a_name] : 999;
        $b_pos = array_key_exists($b_name, $order_index) ? (int) $order_index[$b_name] : 999;
        if ( $a_pos === $b_pos ) {
            return strnatcasecmp($a_name, $b_name);
        }
        return $a_pos <=> $b_pos;
    });

    return $terms;
}

function mytheme_seed_youtube_learning_terms_once() {
    $version = 'youtube-learning-terms-v2';
    if ( get_option('mytheme_youtube_learning_terms_seeded_version') === $version ) return;

    $topics = mytheme_youtube_learning_topic_order();
    foreach ( $topics as $name ) {
        if ( ! term_exists($name, 'yt_topic') ) {
            wp_insert_term($name, 'yt_topic');
        }
    }

    $legacy_topics = ['数学', '理科', '英語', '学習法'];
    foreach ( $legacy_topics as $name ) {
        $term = get_term_by('name', $name, 'yt_topic');
        if ( $term && ! is_wp_error($term) && isset($term->term_id, $term->count) && (int) $term->count === 0 ) {
            wp_delete_term((int) $term->term_id, 'yt_topic');
        }
    }

    update_option('mytheme_youtube_learning_terms_seeded_version', $version, false);
}
add_action('init', 'mytheme_seed_youtube_learning_terms_once', 20);

function mytheme_youtube_learning_meta_fields() {
    return [
        '_mytheme_yt_video_url',
        '_mytheme_yt_video_id',
        '_mytheme_yt_embed_url',
        '_mytheme_yt_title',
        '_mytheme_yt_channel_name',
        '_mytheme_yt_channel_id',
        '_mytheme_yt_channel_url',
        '_mytheme_yt_thumbnail_url',
        '_mytheme_yt_fetched_at',
    ];
}

function mytheme_get_youtube_learning_meta($post_id, $key, $default = '') {
    $value = get_post_meta((int) $post_id, (string) $key, true);
    return $value !== '' ? $value : $default;
}

function mytheme_youtube_learning_extract_video_id($url) {
    $url = trim((string) $url);
    if ( $url === '' ) return '';

    $parts = wp_parse_url($url);
    if ( ! is_array($parts) ) return '';

    $host = isset($parts['host']) ? strtolower((string) $parts['host']) : '';
    $path = isset($parts['path']) ? trim((string) $parts['path'], '/') : '';
    $id = '';

    if ( strpos($host, 'youtu.be') !== false ) {
        $segments = explode('/', $path);
        $id = isset($segments[0]) ? (string) $segments[0] : '';
    } elseif ( strpos($host, 'youtube.com') !== false || strpos($host, 'youtube-nocookie.com') !== false ) {
        if ( strpos($path, 'shorts/') === 0 ) {
            $id = substr($path, 7);
        } elseif ( strpos($path, 'embed/') === 0 ) {
            $id = substr($path, 6);
        } elseif ( ! empty($parts['query']) ) {
            parse_str((string) $parts['query'], $query);
            $id = isset($query['v']) ? (string) $query['v'] : '';
        }
    }

    $id = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $id);
    return strlen($id) >= 8 ? $id : '';
}

function mytheme_youtube_learning_build_embed_url($video_id) {
    $video_id = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $video_id);
    return $video_id !== '' ? 'https://www.youtube.com/embed/' . $video_id : '';
}

function mytheme_youtube_learning_build_thumbnail_url($video_id) {
    $video_id = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $video_id);
    return $video_id !== '' ? 'https://i.ytimg.com/vi/' . $video_id . '/hq720.jpg' : '';
}

function mytheme_youtube_learning_build_post_slug($title, $video_id = '') {
    $video_id = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $video_id);
    return $video_id !== '' ? 'yt-' . strtolower($video_id) : '';
}

function mytheme_youtube_learning_get_thumbnail_url($post_id) {
    $video_id = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_video_id');
    $thumbnail_url = mytheme_youtube_learning_build_thumbnail_url($video_id);
    if ( $thumbnail_url !== '' ) return $thumbnail_url;

    return mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_thumbnail_url');
}

function mytheme_youtube_learning_fetch_remote_json($url) {
    $response = wp_remote_get($url, [
        'timeout' => 8,
        'headers' => [
            'Accept' => 'application/json',
        ],
    ]);

    if ( is_wp_error($response) ) return [];
    if ( (int) wp_remote_retrieve_response_code($response) !== 200 ) return [];

    $data = json_decode((string) wp_remote_retrieve_body($response), true);
    return is_array($data) ? $data : [];
}

function mytheme_youtube_learning_fetch_oembed($video_url) {
    $endpoint = add_query_arg([
        'url'    => (string) $video_url,
        'format' => 'json',
    ], 'https://www.youtube.com/oembed');

    $data = mytheme_youtube_learning_fetch_remote_json($endpoint);
    if ( empty($data) ) return [];

    return [
        'title'         => isset($data['title']) ? sanitize_text_field((string) $data['title']) : '',
        'channel_name'  => isset($data['author_name']) ? sanitize_text_field((string) $data['author_name']) : '',
        'channel_url'   => isset($data['author_url']) ? esc_url_raw((string) $data['author_url']) : '',
        'thumbnail_url' => isset($data['thumbnail_url']) ? esc_url_raw((string) $data['thumbnail_url']) : '',
    ];
}

function mytheme_youtube_learning_upsert_channel_term($channel_name, $channel_url = '', $channel_id = '') {
    $channel_name = trim((string) $channel_name);
    if ( $channel_name === '' ) return 0;

    $term = term_exists($channel_name, 'yt_channel');
    if ( ! $term ) {
        $term = wp_insert_term($channel_name, 'yt_channel');
    }
    if ( is_wp_error($term) || empty($term['term_id']) ) return 0;

    $term_id = (int) $term['term_id'];
    if ( $channel_url !== '' ) {
        update_term_meta($term_id, '_mytheme_yt_channel_url', esc_url_raw((string) $channel_url));
    }
    if ( $channel_id !== '' ) {
        update_term_meta($term_id, '_mytheme_yt_channel_id', sanitize_text_field((string) $channel_id));
    }
    update_term_meta($term_id, '_mytheme_yt_channel_fetched_at', (string) time());

    return $term_id;
}

function mytheme_youtube_learning_add_meta_box() {
    add_meta_box(
        'mytheme-youtube-learning-details',
        'YouTube動画情報',
        'mytheme_youtube_learning_render_meta_box',
        'youtube_learning',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes_youtube_learning', 'mytheme_youtube_learning_add_meta_box');

function mytheme_youtube_learning_admin_enqueue($hook) {
    if ( ! in_array($hook, ['post.php', 'post-new.php'], true) ) return;

    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if ( ! $screen || $screen->post_type !== 'youtube_learning' ) return;

    wp_enqueue_script('jquery');

    $data = [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('mytheme_youtube_learning_fetch_video'),
    ];

    $script = 'window.mythemeYoutubeLearningAdmin=' . wp_json_encode($data) . ';
    (function($) {
        function setEditorTitle(title) {
            title = $.trim(title || "");
            if (!title) return;

            if (window.wp && wp.data && wp.data.dispatch) {
                try {
                    wp.data.dispatch("core/editor").editPost({ title: title });
                } catch (e) {}
            }

            var $classicTitle = $("#title");
            if ($classicTitle.length && !$.trim($classicTitle.val())) {
                $classicTitle.val(title).trigger("input").trigger("change");
            }
        }

        function fallbackTitleFromUrl(url) {
            var match = String(url || "").match(/(?:v=|youtu\.be\/|shorts\/|embed\/)([A-Za-z0-9_-]{8,})/);
            return match && match[1] ? "YouTube動画 " + match[1] : "YouTube動画";
        }

        function fetchTitle(url) {
            url = $.trim(url || "");
            if (!url) return;

            setEditorTitle(fallbackTitleFromUrl(url));

            $.post(window.mythemeYoutubeLearningAdmin.ajaxUrl, {
                action: "mytheme_youtube_learning_fetch_video",
                nonce: window.mythemeYoutubeLearningAdmin.nonce,
                video_url: url
            }).done(function(response) {
                if (response && response.success && response.data && response.data.title) {
                    setEditorTitle(response.data.title);
                }
            });
        }

        $(document).on("change blur", "#mytheme_yt_video_url", function() {
            fetchTitle($(this).val());
        });

        $(document).on("submit", "form#post", function() {
            var url = $("#mytheme_yt_video_url").val();
            if (url) {
                setEditorTitle(fallbackTitleFromUrl(url));
            }
        });
    })(jQuery);';

    wp_add_inline_script('jquery', $script, 'after');
}
add_action('admin_enqueue_scripts', 'mytheme_youtube_learning_admin_enqueue');

function mytheme_youtube_learning_ajax_fetch_video() {
    check_ajax_referer('mytheme_youtube_learning_fetch_video', 'nonce');

    if ( ! current_user_can('edit_posts') ) {
        wp_send_json_error(['message' => '権限がありません。'], 403);
    }

    $video_url = isset($_POST['video_url']) ? esc_url_raw(wp_unslash((string) $_POST['video_url'])) : '';
    $video_id = mytheme_youtube_learning_extract_video_id($video_url);
    if ( $video_id === '' ) {
        wp_send_json_error(['message' => 'YouTube動画URLを確認してください。'], 400);
    }

    $remote = mytheme_youtube_learning_fetch_oembed($video_url);

    if ( empty($remote['title']) ) {
        wp_send_json_error(['message' => '動画タイトルを取得できませんでした。'], 404);
    }

    wp_send_json_success([
        'title'        => sanitize_text_field((string) $remote['title']),
        'channel_name' => isset($remote['channel_name']) ? sanitize_text_field((string) $remote['channel_name']) : '',
    ]);
}
add_action('wp_ajax_mytheme_youtube_learning_fetch_video', 'mytheme_youtube_learning_ajax_fetch_video');

function mytheme_youtube_learning_auto_title_before_insert($data, $postarr) {
    if ( empty($data['post_type']) || $data['post_type'] !== 'youtube_learning' ) return $data;
    if ( ! empty($data['post_title']) && $data['post_title'] !== '自動下書き' ) return $data;
    if ( empty($_POST['mytheme_yt_video_url']) ) return $data;

    $video_url = esc_url_raw(wp_unslash((string) $_POST['mytheme_yt_video_url']));
    $video_id = mytheme_youtube_learning_extract_video_id($video_url);
    if ( $video_id === '' ) return $data;

    $remote = mytheme_youtube_learning_fetch_oembed($video_url);

    if ( ! empty($remote['title']) ) {
        $title = sanitize_text_field((string) $remote['title']);
        $data['post_title'] = $title;

        $slug = mytheme_youtube_learning_build_post_slug($title, $video_id);
        if ( $slug !== '' ) {
            $data['post_name'] = $slug;
        }
    }

    return $data;
}
add_filter('wp_insert_post_data', 'mytheme_youtube_learning_auto_title_before_insert', 10, 2);

function mytheme_youtube_learning_render_meta_box($post) {
    $post_id = (int) $post->ID;
    wp_nonce_field('mytheme_youtube_learning_meta_action', 'mytheme_youtube_learning_meta_nonce');
    $video_url = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_video_url');
    $video_id = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_video_id');
    $channel_name = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_channel_name');
    $channel_url = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_channel_url');
    $thumbnail_url = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_thumbnail_url');
    $fetched_at = (int) mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_fetched_at', 0);
    ?>
    <p>
        <label for="mytheme_yt_video_url"><strong>YouTube動画URL</strong></label><br>
        <input type="url" id="mytheme_yt_video_url" name="mytheme_yt_video_url" value="<?php echo esc_attr($video_url); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=...">
        <span class="description">保存時に動画タイトル、チャンネル名、サムネイルなどを取得します。公式埋め込みで表示します。</span>
    </p>
    <p class="description">URLスラッグは、投稿タイトルやパーマリンク欄で内容が分かる名前にしてください。例: programming-beginner-roadmap</p>
    <hr>
    <h3>自動取得された情報</h3>
    <table class="widefat striped">
        <tbody>
            <tr>
                <th style="width:180px;">動画ID</th>
                <td><?php echo $video_id !== '' ? esc_html($video_id) : '未取得'; ?></td>
            </tr>
            <tr>
                <th>チャンネル名</th>
                <td><?php echo $channel_name !== '' ? esc_html($channel_name) : '未取得'; ?></td>
            </tr>
            <tr>
                <th>チャンネルURL</th>
                <td>
                    <?php if ( $channel_url !== '' ) : ?>
                        <a href="<?php echo esc_url($channel_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($channel_url); ?></a>
                    <?php else : ?>
                        未取得
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>サムネイル</th>
                <td>
                    <?php if ( $thumbnail_url !== '' ) : ?>
                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="" style="max-width:180px;height:auto;">
                    <?php else : ?>
                        未取得
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>最終取得</th>
                <td><?php echo $fetched_at > 0 ? esc_html(date_i18n('Y.m.d H:i', $fetched_at)) : '未取得'; ?></td>
            </tr>
        </tbody>
    </table>
    <p class="description">タイトル・チャンネル名・サムネイルはYouTubeの公開情報から取得します。</p>
    <?php
}

function mytheme_youtube_learning_save_meta($post_id, $post, $update) {
    if ( ! $post || $post->post_type !== 'youtube_learning' ) return;
    if ( wp_is_post_revision($post_id) || wp_is_post_autosave($post_id) ) return;
    if ( ! current_user_can('edit_post', $post_id) ) return;

    $nonce = isset($_POST['mytheme_youtube_learning_meta_nonce']) ? (string) $_POST['mytheme_youtube_learning_meta_nonce'] : '';
    if ( $nonce === '' || ! wp_verify_nonce($nonce, 'mytheme_youtube_learning_meta_action') ) return;

    $video_url = isset($_POST['mytheme_yt_video_url']) ? esc_url_raw(wp_unslash((string) $_POST['mytheme_yt_video_url'])) : '';
    $video_id = mytheme_youtube_learning_extract_video_id($video_url);
    $embed_url = mytheme_youtube_learning_build_embed_url($video_id);
    $remote = $video_id !== '' ? mytheme_youtube_learning_fetch_oembed($video_url) : [];

    $values = [
        '_mytheme_yt_video_url'        => $video_url,
        '_mytheme_yt_video_id'         => $video_id,
        '_mytheme_yt_embed_url'        => $embed_url,
        '_mytheme_yt_thumbnail_url'    => mytheme_youtube_learning_build_thumbnail_url($video_id),
        '_mytheme_yt_fetched_at'       => $video_id !== '' ? (string) time() : '',
    ];

    $remote_map = [
        'title'         => '_mytheme_yt_title',
        'channel_name'  => '_mytheme_yt_channel_name',
        'channel_id'    => '_mytheme_yt_channel_id',
        'channel_url'   => '_mytheme_yt_channel_url',
    ];

    foreach ( $remote_map as $remote_key => $meta_key ) {
        if ( isset($remote[$remote_key]) && trim((string) $remote[$remote_key]) !== '' ) {
            $values[$meta_key] = sanitize_text_field((string) $remote[$remote_key]);
        }
    }

    foreach ( $values as $key => $value ) {
        if ( $value === '' ) {
            delete_post_meta($post_id, $key);
        } else {
            update_post_meta($post_id, $key, $value);
        }
    }

    $expected_slug = mytheme_youtube_learning_build_post_slug(
        ! empty($remote['title']) ? (string) $remote['title'] : get_the_title($post_id),
        $video_id
    );
    $current_slug = (string) get_post_field('post_name', $post_id);
    $needs_title_update = ! empty($remote['title']) && get_the_title($post_id) !== (string) $remote['title'];
    $needs_slug_update = $expected_slug !== '' && $current_slug !== $expected_slug;

    if ( $needs_title_update || $needs_slug_update ) {
        remove_action('save_post_youtube_learning', 'mytheme_youtube_learning_save_meta', 10);

        $post_update = ['ID' => $post_id];
        if ( $needs_title_update ) {
            $post_update['post_title'] = (string) $remote['title'];
        }
        if ( $needs_slug_update ) {
            $post_update['post_name'] = $expected_slug;
        }

        wp_update_post($post_update);
        add_action('save_post_youtube_learning', 'mytheme_youtube_learning_save_meta', 10, 3);
    }

    $channel_name = isset($remote['channel_name']) ? (string) $remote['channel_name'] : '';
    $channel_url = isset($remote['channel_url']) ? (string) $remote['channel_url'] : '';
    $channel_id = isset($remote['channel_id']) ? (string) $remote['channel_id'] : '';
    $term_id = mytheme_youtube_learning_upsert_channel_term($channel_name, $channel_url, $channel_id);
    if ( $term_id > 0 ) {
        wp_set_object_terms($post_id, [$term_id], 'yt_channel', false);
    }
}
add_action('save_post_youtube_learning', 'mytheme_youtube_learning_save_meta', 10, 3);

function mytheme_youtube_learning_add_channel_term_fields($taxonomy) {
    ?>
    <div class="form-field term-channel-url-wrap">
        <label for="mytheme_yt_channel_url">チャンネルURL</label>
        <input type="url" name="mytheme_yt_channel_url" id="mytheme_yt_channel_url" value="">
    </div>
    <div class="form-field term-channel-id-wrap">
        <label for="mytheme_yt_channel_id">チャンネルID</label>
        <input type="text" name="mytheme_yt_channel_id" id="mytheme_yt_channel_id" value="">
    </div>
    <?php
}
add_action('yt_channel_add_form_fields', 'mytheme_youtube_learning_add_channel_term_fields');

function mytheme_youtube_learning_edit_channel_term_fields($term) {
    $term_id = isset($term->term_id) ? (int) $term->term_id : 0;
    $channel_url = get_term_meta($term_id, '_mytheme_yt_channel_url', true);
    $channel_id = get_term_meta($term_id, '_mytheme_yt_channel_id', true);
    ?>
    <tr class="form-field term-channel-url-wrap">
        <th scope="row"><label for="mytheme_yt_channel_url">チャンネルURL</label></th>
        <td><input type="url" name="mytheme_yt_channel_url" id="mytheme_yt_channel_url" value="<?php echo esc_attr((string) $channel_url); ?>"></td>
    </tr>
    <tr class="form-field term-channel-id-wrap">
        <th scope="row"><label for="mytheme_yt_channel_id">チャンネルID</label></th>
        <td><input type="text" name="mytheme_yt_channel_id" id="mytheme_yt_channel_id" value="<?php echo esc_attr((string) $channel_id); ?>"></td>
    </tr>
    <?php
}
add_action('yt_channel_edit_form_fields', 'mytheme_youtube_learning_edit_channel_term_fields');

function mytheme_youtube_learning_save_channel_term_meta($term_id) {
    if ( isset($_POST['mytheme_yt_channel_url']) ) {
        update_term_meta((int) $term_id, '_mytheme_yt_channel_url', esc_url_raw(wp_unslash((string) $_POST['mytheme_yt_channel_url'])));
    }
    if ( isset($_POST['mytheme_yt_channel_id']) ) {
        update_term_meta((int) $term_id, '_mytheme_yt_channel_id', sanitize_text_field(wp_unslash((string) $_POST['mytheme_yt_channel_id'])));
    }
}
add_action('created_yt_channel', 'mytheme_youtube_learning_save_channel_term_meta');
add_action('edited_yt_channel', 'mytheme_youtube_learning_save_channel_term_meta');

function mytheme_youtube_learning_archive_order($query) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( ! is_post_type_archive('youtube_learning') ) return;

    $query->set('posts_per_page', 12);
    $query->set('orderby', 'date');
    $query->set('order', 'DESC');

    $tax_query = [];
    $filters = [
        'yt_topic'   => 'yt_topic',
        'yt_channel' => 'yt_channel',
    ];

    foreach ( $filters as $param => $taxonomy ) {
        $slug = isset($_GET[$param]) ? sanitize_text_field(wp_unslash((string) $_GET[$param])) : '';
        if ( $slug === '' ) continue;
        $tax_query[] = [
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => [$slug],
        ];
    }

    if ( ! empty($tax_query) ) {
        $tax_query['relation'] = 'AND';
        $query->set('tax_query', $tax_query);
    }
}
add_action('pre_get_posts', 'mytheme_youtube_learning_archive_order');

function mytheme_youtube_learning_get_channel_data($post_id) {
    $terms = get_the_terms((int) $post_id, 'yt_channel');
    $term = is_array($terms) && ! empty($terms) ? $terms[0] : null;

    $name = $term && isset($term->name)
        ? (string) $term->name
        : mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_channel_name');
    $url = $term && isset($term->term_id)
        ? (string) get_term_meta((int) $term->term_id, '_mytheme_yt_channel_url', true)
        : '';
    if ( $url === '' ) {
        $url = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_channel_url');
    }

    return [
        'name' => $name,
        'url'  => $url,
    ];
}

function mytheme_youtube_learning_render_term_links($post_id, $taxonomy, $class_name) {
    $terms = get_the_terms((int) $post_id, (string) $taxonomy);
    if ( ! is_array($terms) || empty($terms) ) return;
    foreach ( $terms as $term ) {
        if ( ! isset($term->name) ) continue;
        echo '<span class="' . esc_attr($class_name) . '">' . esc_html((string) $term->name) . '</span>';
    }
}

function mytheme_youtube_learning_get_card_title($post_id) {
    $remote_title = mytheme_get_youtube_learning_meta($post_id, '_mytheme_yt_title');
    return $remote_title !== '' ? $remote_title : get_the_title((int) $post_id);
}

function mytheme_youtube_learning_render_card($post_id) {
    $post_id = (int) $post_id;
    $title = mytheme_youtube_learning_get_card_title($post_id);
    $url = get_permalink($post_id);
    $thumbnail_url = mytheme_youtube_learning_get_thumbnail_url($post_id);
    ?>
    <article class="youtube-learning-card">
        <a class="youtube-learning-card__thumb" href="<?php echo esc_url($url); ?>">
            <?php if ( $thumbnail_url !== '' ) : ?>
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
            <?php else : ?>
                <span class="youtube-learning-card__thumb-placeholder">YouTube</span>
            <?php endif; ?>
        </a>
    </article>
    <?php
}

function mytheme_youtube_learning_flush_rewrite_on_switch() {
    mytheme_register_youtube_learning_cpt_and_taxonomies();
    flush_rewrite_rules(false);
}
add_action('after_switch_theme', 'mytheme_youtube_learning_flush_rewrite_on_switch');

function mytheme_youtube_learning_flush_rewrite_once_after_register() {
    $version = 'youtube-learning-rewrite-v2';
    if ( get_option('mytheme_youtube_learning_rewrite_version') === $version ) return;

    flush_rewrite_rules(false);
    update_option('mytheme_youtube_learning_rewrite_version', $version, false);
}
add_action('init', 'mytheme_youtube_learning_flush_rewrite_once_after_register', 99);
