<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<article class="page-content dictionary-archive-page">
    <?php if ( function_exists('mytheme_breadcrumb') ) : ?>
        <?php mytheme_breadcrumb(); ?>
    <?php endif; ?>

    <header class="page-header">
        <h1 class="page-title">辞書一覧</h1>
        <p class="post-subtitle">教育・プログラミング・自己啓発に関する重要用語を、カードからすぐ確認できます。</p>
    </header>

    <div class="page-body">
        <?php
        $selected_dic_cat = isset($_GET['dic_cat']) ? sanitize_text_field(wp_unslash((string) $_GET['dic_cat'])) : '';
        $dic_terms = get_terms([
            'taxonomy'   => 'dic_category',
            'hide_empty' => false,
        ]);
        if ( is_array($dic_terms) && ! empty($dic_terms) ) {
            $desired_order = ['教育', 'プログラミング', '自己啓発'];
            $order_index = array_flip($desired_order);
            usort($dic_terms, function($a, $b) use ($order_index) {
                $a_name = isset($a->name) ? (string) $a->name : '';
                $b_name = isset($b->name) ? (string) $b->name : '';
                $a_pos = array_key_exists($a_name, $order_index) ? (int) $order_index[$a_name] : 999;
                $b_pos = array_key_exists($b_name, $order_index) ? (int) $order_index[$b_name] : 999;
                if ( $a_pos === $b_pos ) {
                    return strnatcasecmp($a_name, $b_name);
                }
                return $a_pos <=> $b_pos;
            });
        }
        $base_url = get_post_type_archive_link('dictionary');
        $all_url = remove_query_arg(['dic_cat', 'paged'], $base_url);
        ?>

        <?php if ( is_array($dic_terms) && ! empty($dic_terms) ) : ?>
            <nav class="learning-column-filters dictionary-filters" aria-label="辞書カテゴリで絞り込み">
                <a class="learning-column-filters__item is-all <?php echo $selected_dic_cat === '' ? 'is-active' : ''; ?>" href="<?php echo esc_url($all_url); ?>">
                    <span class="lc-filter-text">すべて</span>
                </a>
                <?php foreach ( $dic_terms as $term ) : ?>
                    <?php
                    if ( ! isset($term->slug) || ! isset($term->name) ) continue;
                    $slug = (string) $term->slug;
                    $name = (string) $term->name;
                    $url = add_query_arg('dic_cat', $slug, remove_query_arg('paged', $base_url));
                    $active = $selected_dic_cat === $slug;

                    $kind_class = '';
                    $icon_svg = '';
                    if ( $name === '教育' ) {
                        $kind_class = 'is-education';
                        $icon_svg = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path><line x1="10" y1="8" x2="16" y2="8"></line><line x1="10" y1="12" x2="16" y2="12"></line><line x1="10" y1="16" x2="16" y2="16"></line></svg>';
                    } elseif ( $name === 'プログラミング' ) {
                        $kind_class = 'is-programming';
                        $icon_svg = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>';
                    } elseif ( $name === '自己啓発' ) {
                        $kind_class = 'is-self-development';
                        $icon_svg = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><path d="M12 2v4"></path><path d="M12 18v4"></path><path d="M2 12h4"></path><path d="M18 12h4"></path></svg>';
                    }
                    ?>
                    <a class="learning-column-filters__item <?php echo esc_attr(trim($kind_class . ' ' . ($active ? 'is-active' : ''))); ?>" href="<?php echo esc_url($url); ?>">
                        <?php if ( $icon_svg !== '' ) : ?>
                            <span class="lc-filter-icon" aria-hidden="true"><?php echo $icon_svg; ?></span>
                        <?php endif; ?>
                        <span class="lc-filter-text"><?php echo esc_html($name); ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        <?php endif; ?>

        <div class="dictionary-results" data-dictionary-results>
            <?php if ( have_posts() ) : ?>
                <div class="dictionary-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                    <?php
                    $post_id = (int) get_the_ID();
                    $term_name = get_the_title();
                    $detail_id = 'dictionary-detail-' . $post_id;

                    $dic_terms = get_the_terms($post_id, 'dic_category');
                    $labels = [];
                    if ( is_array($dic_terms) ) {
                        foreach ( $dic_terms as $t ) {
                            if ( isset($t->name) ) $labels[] = (string) $t->name;
                        }
                    }

                    $related_ids = function_exists('mytheme_dictionary_get_related_posts_hybrid')
                        ? mytheme_dictionary_get_related_posts_hybrid($post_id, $term_name, 3)
                        : [];
                    if ( empty($related_ids) && function_exists('mytheme_dictionary_get_latest_posts_fallback') ) {
                        $related_ids = mytheme_dictionary_get_latest_posts_fallback(3);
                    }
                    ?>

                    <button
                        type="button"
                        class="dictionary-card"
                        data-dictionary-open="<?php echo esc_attr($detail_id); ?>"
                        aria-haspopup="dialog"
                        aria-controls="dictionary-modal"
                    >
                        <span class="dictionary-card__term"><?php echo esc_html($term_name); ?></span>
                        <?php if ( ! empty($labels) ) : ?>
                            <span class="dictionary-card__cats">
                                <?php echo esc_html( implode(' / ', $labels) ); ?>
                            </span>
                        <?php endif; ?>
                    </button>

                    <div id="<?php echo esc_attr($detail_id); ?>" class="dictionary-detail-template" hidden>
                        <h2 class="dictionary-modal__term"><?php echo esc_html($term_name); ?></h2>
                        <div class="dictionary-modal__content">
                            <?php echo wp_kses_post( apply_filters('the_content', get_the_content()) ); ?>
                        </div>

                        <?php if ( ! empty($related_ids) ) : ?>
                            <section class="dictionary-modal__related" aria-label="関連記事">
                                <h3 class="dictionary-modal__related-title">関連記事</h3>
                                <ul class="dictionary-modal__related-list">
                                    <?php foreach ( $related_ids as $rid ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url( get_permalink($rid) ); ?>">
                                                <?php echo esc_html( get_the_title($rid) ); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </section>
                        <?php endif; ?>
                    </div>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php the_posts_pagination([
                        'add_args' => $selected_dic_cat !== '' ? ['dic_cat' => $selected_dic_cat] : [],
                    ]); ?>
                </div>
            <?php else : ?>
                <p>辞書項目はまだありません。</p>
            <?php endif; ?>
        </div>
    </div>
</article>

<div id="dictionary-modal" class="dictionary-modal" hidden aria-hidden="true">
    <div class="dictionary-modal__backdrop" data-dictionary-close></div>
    <div class="dictionary-modal__dialog" role="dialog" aria-modal="true" aria-labelledby="dictionary-modal-title">
        <button type="button" class="dictionary-modal__close" data-dictionary-close aria-label="閉じる">×</button>
        <div class="dictionary-modal__body" data-dictionary-modal-body></div>
    </div>
</div>

<?php get_footer(); ?>

