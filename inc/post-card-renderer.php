<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 学習コラムで使うカテゴリ表示メタ
 */
function mytheme_get_column_category_meta(): array {
    return [
        'education' => [
            'label' => '教育',
            'class' => 'is-education',
            'icon'  => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="10" y1="8" x2="16" y2="8"></line><line x1="10" y1="12" x2="16" y2="12"></line><line x1="10" y1="16" x2="16" y2="16"></line></svg>',
        ],
        'programming' => [
            'label' => 'プログラミング',
            'class' => 'is-programming',
            'icon'  => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>',
        ],
        'self-development' => [
            'label' => '学習法・仕事術',
            'class' => 'is-self-development',
            'icon'  => '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M2 12h4"></path><path d="M18 12h4"></path></svg>',
        ],
    ];
}

/**
 * 学習コラム系のカードを共通描画
 */
function mytheme_render_learning_column_card(array $cat_meta = [], bool $show_default_badge = false): void {
    $post_id = (int) get_the_ID();
    if ( $post_id <= 0 ) return;

    $post_url = get_permalink($post_id);
    $primary = function_exists('mytheme_get_learning_column_theme_meta')
        ? mytheme_get_learning_column_theme_meta($post_id)
        : null;
    $updated_ts = function_exists('mytheme_learning_column_modified_timestamp')
        ? mytheme_learning_column_modified_timestamp($post_id)
        : 0;

    echo '<article ';
    post_class(array_filter(['post-card', 'lc-card', $primary ? $primary['class'] : '']));
    echo '>';
    echo '<div class="lc-card-head">';

    if ( $primary ) {
        echo '<span class="lc-badge ' . esc_attr((string) $primary['class']) . '">';
        if ( ! empty($primary['icon']) ) {
            echo '<span class="lc-badge__icon" aria-hidden="true">' . $primary['icon'] . '</span>';
        }
        echo '<span class="lc-badge__text">' . esc_html((string) $primary['label']) . '</span>';
        echo '</span>';
    } elseif ( $show_default_badge ) {
        echo '<span class="lc-badge"><span class="lc-badge__text">学習コラム</span></span>';
    }

    echo '<span class="lc-dates">';
    echo '<time class="lc-date" datetime="' . esc_attr(get_the_date('c', $post_id)) . '">公開: ' . esc_html(get_the_date('', $post_id)) . '</time>';
    if ( $updated_ts > 0 ) {
        $updated_datetime = function_exists('mytheme_learning_column_modified_datetime') ? mytheme_learning_column_modified_datetime($post_id) : '';
        $updated_date = function_exists('mytheme_learning_column_modified_date') ? mytheme_learning_column_modified_date($post_id) : '';
        echo '<time class="lc-date lc-date--updated" datetime="' . esc_attr($updated_datetime) . '">更新: ' . esc_html($updated_date) . '</time>';
    }
    echo '</span>';
    echo '</div>';

    echo '<h2 class="post-title"><a href="' . esc_url($post_url) . '">';
    the_title();
    echo '</a></h2>';

    $raw_excerpt = get_the_excerpt($post_id);
    $excerpt_text = wp_strip_all_tags((string) $raw_excerpt);
    // wp_trim_words は日本語ロケールだと「語数」ではなく「文字数」になる。
    // 本番 ja では 36 文字≒1行で切れるため、文字数ベースで 3 行分を渡して CSS line-clamp に任せる。
    $excerpt = function_exists('wp_html_excerpt')
        ? wp_html_excerpt($excerpt_text, 120, '…')
        : $excerpt_text;
    echo '<div class="post-excerpt">' . esc_html($excerpt) . '</div>';
    echo '<p class="post-readmore"><a class="read-more" href="' . esc_url($post_url) . '">続きを読む</a></p>';
    echo '</article>';
}
