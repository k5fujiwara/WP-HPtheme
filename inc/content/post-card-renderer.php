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
 * 記事タイル（アイキャッチ付きカード）を描画
 *
 * @param int   $post_id 投稿ID（0なら現在のループの投稿）
 * @param array $args {
 *     @type string $heading   見出しタグ（h2/h3）
 *     @type bool   $excerpt   抜粋を表示するか
 *     @type string $loading   画像の loading 属性
 *     @type string $variant   追加のモディファイア（例: compact）
 * }
 */
function mytheme_render_post_tile(int $post_id = 0, array $args = []): void {
    $post_id = $post_id > 0 ? $post_id : (int) get_the_ID();
    if ( $post_id <= 0 ) return;

    $args = array_merge([
        'heading' => 'h2',
        'excerpt' => true,
        'loading' => 'lazy',
        'variant' => '',
    ], $args);
    $heading = in_array($args['heading'], ['h2', 'h3', 'h4'], true) ? $args['heading'] : 'h2';

    $theme = function_exists('mytheme_get_learning_column_theme_meta')
        ? mytheme_get_learning_column_theme_meta($post_id)
        : ['slug' => 'default', 'label' => '学習コラム', 'class' => 'is-theme-default'];
    $theme_slug  = (string) ($theme['slug'] ?? 'default');
    $theme_label = $theme_slug === 'review-required' ? '学習コラム' : (string) ($theme['label'] ?? '学習コラム');
    $theme_class = $theme_slug === 'review-required' ? 'is-theme-default' : (string) ($theme['class'] ?? 'is-theme-default');

    $updated_ts = function_exists('mytheme_learning_column_modified_timestamp')
        ? mytheme_learning_column_modified_timestamp($post_id)
        : 0;

    $classes = ['post-tile', $theme_class];
    if ( $args['variant'] !== '' ) {
        $classes[] = 'post-tile--' . sanitize_html_class((string) $args['variant']);
    }

    $permalink = get_permalink($post_id);
    $title     = get_the_title($post_id);
    ?>
    <article <?php post_class($classes, $post_id); ?>>
        <a class="post-tile__link" href="<?php echo esc_url($permalink); ?>">
            <div class="post-tile__media">
                <?php if ( has_post_thumbnail($post_id) ) : ?>
                    <?php echo get_the_post_thumbnail($post_id, 'medium_large', [
                        'class'    => 'post-tile__image',
                        'alt'      => '',
                        'loading'  => $args['loading'],
                        'decoding' => 'async',
                        'sizes'    => '(max-width: 640px) 34vw, (max-width: 1024px) 50vw, 360px',
                    ]); ?>
                <?php else : ?>
                    <span class="post-tile__cover" aria-hidden="true">
                        <span class="post-tile__cover-label"><?php echo esc_html($theme_label); ?></span>
                        <span class="post-tile__cover-title"><?php echo esc_html($title); ?></span>
                    </span>
                <?php endif; ?>
            </div>
            <div class="post-tile__body">
                <div class="post-tile__meta">
                    <span class="post-tile__badge"><?php echo esc_html($theme_label); ?></span>
                    <?php if ( $updated_ts > 0 && function_exists('mytheme_learning_column_modified_datetime') ) : ?>
                        <time class="post-tile__date" datetime="<?php echo esc_attr(mytheme_learning_column_modified_datetime($post_id)); ?>"><?php echo esc_html(mytheme_learning_column_modified_date($post_id, 'Y.m.d')); ?> 更新</time>
                    <?php else : ?>
                        <time class="post-tile__date" datetime="<?php echo esc_attr(get_the_date('c', $post_id)); ?>"><?php echo esc_html(get_the_date('Y.m.d', $post_id)); ?></time>
                    <?php endif; ?>
                </div>
                <<?php echo $heading; ?> class="post-tile__title"><?php echo esc_html($title); ?></<?php echo $heading; ?>>
                <?php if ( $args['excerpt'] ) : ?>
                    <?php
                    $excerpt_text = wp_strip_all_tags((string) get_the_excerpt($post_id));
                    $excerpt = function_exists('wp_html_excerpt') ? wp_html_excerpt($excerpt_text, 90, '…') : $excerpt_text;
                    ?>
                    <?php if ( $excerpt !== '' ) : ?>
                        <p class="post-tile__excerpt"><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </a>
    </article>
    <?php
}

/**
 * 学習コラム系のカードを共通描画（一覧・検索・アーカイブ）
 * 互換のため旧シグネチャを維持し、記事タイルに委譲する。
 */
function mytheme_render_learning_column_card(array $cat_meta = [], bool $show_default_badge = false): void {
    mytheme_render_post_tile((int) get_the_ID(), ['heading' => 'h2']);
}
