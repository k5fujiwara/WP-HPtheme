<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 学習コラム用のカテゴリを用意（冪等）
 * - 教育系 / プログラミング / 自己啓発
 * - 未分類（Uncategorized）を避けるため、デフォルトカテゴリも設定（未設定/初期値のみ）
 */
function mytheme_ensure_column_categories() {
    // Gutenberg/REST中に走ると「予期しないエラー」になり得るため、管理画面でのみ実行
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( ! is_admin() ) return;
    if ( ! current_user_can('manage_categories') ) return;
    // 何度も走らせない（重い処理＋削除を含むため）
    if ( get_option('mytheme_column_categories_done') ) return;

    if ( ! function_exists('wp_insert_term') ) return;

    $cats = [
        [
            'name' => '教育系',
            'slug' => 'education',
        ],
        [
            'name' => 'プログラミング',
            'slug' => 'programming',
        ],
        [
            'name' => '自己啓発',
            'slug' => 'self-development',
        ],
    ];

    $created_ids = [];
    foreach ( $cats as $c ) {
        $slug = (string) $c['slug'];
        $name = (string) $c['name'];

        $term = get_term_by('slug', $slug, 'category');
        if ( $term && ! is_wp_error($term) ) {
            $created_ids[$slug] = (int) $term->term_id;
            continue;
        }

        $res = wp_insert_term($name, 'category', [
            'slug' => $slug,
        ]);
        if ( is_wp_error($res) ) continue;

        if ( isset($res['term_id']) ) {
            $created_ids[$slug] = (int) $res['term_id'];
        }
    }

    // デフォルトカテゴリが未分類（通常 term_id=1）のままなら、教育系に変更
    // 既に別カテゴリをデフォルトにしている場合は尊重する
    $default_cat = (int) get_option('default_category');
    if ( $default_cat === 1 && ! empty($created_ids['education']) ) {
        update_option('default_category', (int) $created_ids['education']);
    }

    // Uncategorized を「なし」にする
    // - 1) 既存投稿のカテゴリ付け替え（教育系へ）
    // - 2) デフォルトカテゴリが切り替わっていれば削除（可能なら）
    $uncat = get_term_by('slug', 'uncategorized', 'category');
    $education_id = ! empty($created_ids['education']) ? (int) $created_ids['education'] : 0;
    if ( $uncat && ! is_wp_error($uncat) && $education_id ) {
        $uncat_id = (int) $uncat->term_id;

        // Uncategorized が付いた投稿を教育系へ寄せる（重複は許可）
        $post_ids = get_posts([
            'post_type'      => 'post',
            'post_status'    => 'any',
            'fields'         => 'ids',
            'posts_per_page' => -1,
            'tax_query'      => [
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => [$uncat_id],
                ],
            ],
        ]);
        if ( is_array($post_ids) ) {
            foreach ( $post_ids as $pid ) {
                $pid = (int) $pid;
                if ( $pid <= 0 ) continue;
                // Uncategorized を外し、教育系を付ける
                wp_set_post_categories($pid, [$education_id], false);
            }
        }

        // デフォルトカテゴリが Uncategorized でなければ、Uncategorized を削除
        $default_cat = (int) get_option('default_category');
        if ( $default_cat !== $uncat_id ) {
            // 失敗してもサイト表示に影響しないように握りつぶす（管理画面で削除してもOK）
            if ( function_exists('wp_delete_term') ) {
                @wp_delete_term($uncat_id, 'category');
            }
        }
    }

    update_option('mytheme_column_categories_done', 1);
}
// サブタイトル機能はSEO必須ではないため撤去（必要なら後から復活可能）

/**
 * 新規投稿の本文に「型」を自動セット（毎回の目次・見出し作成を省略）
 */
function mytheme_default_post_content_template($content, $post = null) {
    // WPバージョン/呼び出し元によっては $post が渡らない場合があるため、必ずガードする
    if ( ! is_object($post) || empty($post->post_type) ) return $content;
    if ( $post->post_type !== 'post' ) return $content;
    if ( is_string($content) && trim($content) !== '' ) return $content;

    // ユーザー要望: 目次ショートコードのみを自動挿入
    return implode("\n", [
        '<!-- wp:shortcode -->',
        '[mytheme_toc]',
        '<!-- /wp:shortcode -->',
        '',
    ]);
}
add_filter('default_content', 'mytheme_default_post_content_template', 10, 2);

/**
 * 辞書アーカイブURLを取得
 */
function mytheme_get_dictionary_archive_url(): string {
    $url = function_exists('get_post_type_archive_link')
        ? get_post_type_archive_link('dictionary')
        : '';

    if ( ! $url ) {
        $url = home_url('/dictionary/');
    }

    return (string) $url;
}

/**
 * 学習コラム導線ブロック（検索 + 辞書）を表示
 */
function mytheme_render_learning_column_toolbox(string $context = 'archive'): void {
    $context = $context === 'single' ? 'single' : 'archive';
    $dictionary_url = mytheme_get_dictionary_archive_url();

    if ( $context === 'single' ) {
        $eyebrow = 'Learning Tools';
        $summary_title = '記事を検索したい方はここから！';
        $search_title = '記事をキーワードで探す';
        $search_text = '関連記事や、今の内容に近いテーマをすぐに検索できます。';
        $search_hint = '例: AI / 勉強法 / プログラミング / 塾講師';
        $dictionary_title = '辞書から理解を深める';
        $dictionary_text = '本文中で気になった概念やキーワードを、辞書ページで一覧から確認できます。';
        $dictionary_cta = '辞書を見る';
    } else {
        $eyebrow = 'Learning Tools';
        $summary_title = '記事を検索したい方はここから！';
        $search_title = '記事を検索する';
        $search_text = '読みたいテーマが決まっているときは、キーワード検索から始めるのが最短です。';
        $search_hint = '例: 自己啓発 / Python / 教育 / 継続';
        $dictionary_title = '辞書からたどる';
        $dictionary_text = '学習コラムに登場する重要語句をまとめています。基礎から整理したいときに便利です。';
        $dictionary_cta = '辞書ページへ';
    }

    ob_start();
    get_search_form();
    $search_form = (string) ob_get_clean();
    ?>
    <section class="learning-column-toolbox learning-column-toolbox--<?php echo esc_attr($context); ?>" aria-label="学習コラムの検索と辞書導線">
        <details class="learning-column-toolbox__details">
            <summary class="learning-column-toolbox__summary">
                <span class="learning-column-toolbox__summary-eyebrow"><?php echo esc_html($eyebrow); ?></span>
                <h2 class="learning-column-toolbox__summary-title"><?php echo esc_html($summary_title); ?></h2>
                <span class="learning-column-toolbox__summary-toggle" aria-hidden="true">
                    <span class="learning-column-toolbox__summary-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </span>
                </span>
            </summary>

            <div class="learning-column-toolbox__content">
                <div class="learning-column-toolbox__grid">
                    <div class="learning-column-toolbox__search learning-column-toolbox__panel">
                        <div class="learning-column-toolbox__panel-head">
                            <span class="learning-column-toolbox__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"></circle>
                                    <path d="m20 20-3.5-3.5"></path>
                                </svg>
                            </span>
                            <p class="learning-column-toolbox__label">記事を検索</p>
                        </div>
                        <p class="learning-column-toolbox__panel-text"><?php echo esc_html($search_text); ?></p>
                        <?php echo $search_form; ?>
                        <p class="learning-column-toolbox__search-hint"><?php echo esc_html($search_hint); ?></p>
                    </div>

                    <div class="learning-column-toolbox__dictionary learning-column-toolbox__panel learning-column-toolbox__panel--dictionary">
                        <div class="learning-column-toolbox__panel-head">
                            <span class="learning-column-toolbox__icon learning-column-toolbox__icon--dictionary" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15.5A2.5 2.5 0 0 0 17.5 16H4z"></path>
                                    <path d="M6.5 3v13"></path>
                                    <path d="M8.5 7H16"></path>
                                    <path d="M8.5 11H14"></path>
                                </svg>
                            </span>
                            <p class="learning-column-toolbox__label">辞書から探す</p>
                        </div>
                        <p class="learning-column-toolbox__panel-text"><?php echo esc_html($dictionary_text); ?></p>
                        <a class="learning-column-toolbox__card-link" href="<?php echo esc_url($dictionary_url); ?>">
                            <?php echo esc_html($dictionary_cta); ?>
                            <svg class="learning-column-toolbox__card-link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </details>
    </section>
    <?php
}

/**
 * 目次（TOC）ショートコード
 * - 投稿本文の h2/h3 を抽出して自動生成
 * - 見出しにidが無ければ自動付与（the_content側で付与）
 */
function mytheme_toc_heading_id(string $text, array &$used): string {
    $text = trim(wp_strip_all_tags($text));
    $id = sanitize_title($text);
    if ( $id === '' ) {
        $id = 'h-' . substr(md5($text), 0, 10);
    }
    $base = $id;
    $i = 2;
    while ( isset($used[$id]) ) {
        $id = $base . '-' . $i;
        $i++;
    }
    $used[$id] = true;
    return $id;
}

function mytheme_shortcode_toc(): string {
    if ( ! is_singular('post') ) return '';
    $post_id = get_queried_object_id();
    if ( ! $post_id ) return '';

    $raw = (string) get_post_field('post_content', $post_id);
    if ( $raw === '' ) return '';

    if ( ! preg_match_all('/<h([2-3])([^>]*)>(.*?)<\/h\\1>/is', $raw, $m, PREG_SET_ORDER) ) {
        return '';
    }

    $used = [];
    $items = [];
    foreach ( $m as $h ) {
        $level = (int) $h[1];
        $attrs = (string) $h[2];
        $inner = (string) $h[3];
        $label = trim(wp_strip_all_tags($inner));
        if ( $label === '' ) continue;

        // 既に id がある場合はそれを尊重
        $id = '';
        if ( preg_match('/\\sid=(["\'])([^"\']+)\\1/i', $attrs, $mm) ) {
            $id = (string) $mm[2];
            $used[$id] = true;
        } else {
            $id = mytheme_toc_heading_id($label, $used);
        }

        $items[] = [
            'level' => $level,
            'id'    => $id,
            'label' => $label,
        ];
    }

    if ( count($items) < 2 ) return '';

    // デフォルトは「閉じる」。見たい人だけクリックで開く。
    $html = '<details class="mytheme-toc" data-mytheme-toc>';
    $html .= '<summary class="mytheme-toc__summary"><span class="mytheme-toc__summary-text">目次</span><span class="mytheme-toc__chevron" aria-hidden="true"></span></summary>';
    $html .= '<nav class="mytheme-toc__nav" aria-label="目次"><ul class="mytheme-toc__list">';
    foreach ( $items as $it ) {
        $li_class = $it['level'] === 3 ? ' class="mytheme-toc__item mytheme-toc__item--h3"' : ' class="mytheme-toc__item"';
        $html .= '<li' . $li_class . '><a class="mytheme-toc__link" href="#' . esc_attr($it['id']) . '">' . esc_html($it['label']) . '</a></li>';
    }
    $html .= '</ul></nav></details>';

    return $html;
}
add_shortcode('mytheme_toc', 'mytheme_shortcode_toc');

function mytheme_add_heading_ids_for_toc($content) {
    if ( is_admin() ) return $content;
    if ( ! is_singular('post') ) return $content;

    $used = [];
    return preg_replace_callback('/<h([2-3])([^>]*)>(.*?)<\/h\\1>/is', function($m) use (&$used) {
        $level = (string) $m[1];
        $attrs = (string) $m[2];
        $inner = (string) $m[3];

        // 既に id がある場合はそのまま
        if ( preg_match('/\\sid=(["\'])([^"\']+)\\1/i', $attrs, $mm) ) {
            $used[(string) $mm[2]] = true;
            return '<h' . $level . $attrs . '>' . $inner . '</h' . $level . '>';
        }

        $label = trim(wp_strip_all_tags($inner));
        if ( $label === '' ) {
            return '<h' . $level . $attrs . '>' . $inner . '</h' . $level . '>';
        }

        $id = mytheme_toc_heading_id($label, $used);
        return '<h' . $level . $attrs . ' id="' . esc_attr($id) . '">' . $inner . '</h' . $level . '>';
    }, $content);
}
add_filter('the_content', 'mytheme_add_heading_ids_for_toc', 15);
