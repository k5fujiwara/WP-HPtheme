<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 関連ページを取得する関数
 */
function mytheme_get_related_pages($current_page_id = null, $limit = 3) {
    if (!$current_page_id) {
        $current_page_id = get_the_ID();
    }
    
    // 関連ページのマッピング（階層構造対応）
    $related_pages_map = array(
        'about' => array('works', 'works/loto6', 'works/auto-typing'),
        'works' => array('works/loto6', 'works/auto-typing', 'works/beengineer-camp'),
        'loto6' => array('works/auto-typing', 'works/quest4', 'works'),
        'auto-typing' => array('works/loto6', 'works/quest4', 'works'),
        'quest4' => array('works/loto6', 'works/auto-typing', 'works'),
        'beengineer-camp' => array('works/loto6', 'works/quest4', 'works')
    );
    
    $current_slug = get_post_field('post_name', $current_page_id);
    
    if (isset($related_pages_map[$current_slug])) {
        $related_slugs = array_slice($related_pages_map[$current_slug], 0, $limit);
        $related_pages = array();
        
        foreach ($related_slugs as $slug) {
            $page = mytheme_get_page_by_path_cached($slug);
            if ($page) {
                $related_pages[] = array(
                    'id' => $page->ID,
                    'title' => get_the_title($page->ID),
                    'url' => get_permalink($page->ID),
                    'excerpt' => wp_trim_words(get_post_field('post_content', $page->ID), 20)
                );
            }
        }
        
        return $related_pages;
    }
    
    return array();
}

/**
 * パンくずリストを表示する関数（BEM命名規則対応）
 */
function mytheme_breadcrumb() {
    // 他プラグイン（例: Yoast）のパンくずが有効な場合はスキップ
    if ( function_exists('wpseo_breadcrumb') || function_exists('rank_math_the_breadcrumbs') ) {
        return;
    }

    if (is_front_page()) {
        return;
    }
    
    $home_title = 'ホーム';
    $home_url = home_url('/');
    
    echo '<nav class="breadcrumb" aria-label="パンくずリスト">';
    echo '<ol class="breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">';
    
    // ホーム
    echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
         '<a class="breadcrumb__link" href="' . esc_url($home_url) . '" itemprop="item"><span itemprop="name">' . esc_html($home_title) . '</span></a>' .
         '<meta itemprop="position" content="1" />' .
         '</li>';
    
    $position = 2;
    
    if (is_singular()) {
        $post_id = get_queried_object_id();
        $post = get_post($post_id);
        $title = get_the_title($post_id);

        // 投稿は「学習コラム（投稿一覧）」を親として表示
        if ( is_singular('post') ) {
            $learning_page = mytheme_get_page_by_path_cached('learning-column');
            if ( ! $learning_page ) {
                $pfp = (int) get_option('page_for_posts');
                if ( $pfp ) $learning_page = get_post($pfp);
            }
            if ( $learning_page ) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
                     '<a class="breadcrumb__link" href="' . esc_url(get_permalink($learning_page->ID)) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($learning_page->ID)) . '</span></a>' .
                     '<meta itemprop="position" content="' . $position . '" />' .
                     '</li>';
                $position++;
            }
        }

        if ( is_singular('news') ) {
            $news_archive_url = get_post_type_archive_link('news');
            if ( $news_archive_url ) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
                     '<a class="breadcrumb__link" href="' . esc_url($news_archive_url) . '" itemprop="item"><span itemprop="name">お知らせ</span></a>' .
                     '<meta itemprop="position" content="' . $position . '" />' .
                     '</li>';
                $position++;
            }
        }

        if ( is_singular('beengineer-news') ) {
            $beengineer_news_archive_url = get_post_type_archive_link('beengineer-news');
            if ( $beengineer_news_archive_url ) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
                     '<a class="breadcrumb__link" href="' . esc_url($beengineer_news_archive_url) . '" itemprop="item"><span itemprop="name">BeEngineer通信</span></a>' .
                     '<meta itemprop="position" content="' . $position . '" />' .
                     '</li>';
                $position++;
            }
        }
        
        // 固定ページで親ページが設定されている場合（階層構造対応）
        if ($post->post_parent) {
            $ancestors = array_reverse(get_post_ancestors($post_id));
            
            foreach ($ancestors as $ancestor_id) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
                     '<a class="breadcrumb__link" href="' . esc_url(get_permalink($ancestor_id)) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($ancestor_id)) . '</span></a>' .
                     '<meta itemprop="position" content="' . $position . '" />' .
                     '</li>';
                $position++;
            }
        }
        
        // 現在のページ
        echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
             '<span itemprop="name">' . esc_html($title) . '</span>' .
             '<meta itemprop="item" content="' . esc_url(get_permalink($post_id)) . '" />' .
             '<meta itemprop="position" content="' . $position . '" />' .
             '</li>';
    } elseif (is_archive()) {
        if ( is_tag() || is_category() || is_tax() ) {
            $learning_page = mytheme_get_page_by_path_cached('learning-column');
            if ( ! $learning_page ) {
                $pfp = (int) get_option('page_for_posts');
                if ( $pfp ) $learning_page = get_post($pfp);
            }
            if ( $learning_page ) {
                echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
                     '<a class="breadcrumb__link" href="' . esc_url(get_permalink($learning_page->ID)) . '" itemprop="item"><span itemprop="name">' . esc_html(get_the_title($learning_page->ID)) . '</span></a>' .
                     '<meta itemprop="position" content="' . $position . '" />' .
                     '</li>';
                $position++;
            }
        }

        if ( is_tag() || is_category() || is_tax() ) {
            $title = single_term_title('', false);
        } elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title('', false);
        } else {
            $title = get_the_archive_title();
        }
        echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' .
             '<span itemprop="name">' . esc_html($title) . '</span>' .
             '<meta itemprop="position" content="' . $position . '" />' .
             '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * 次に読むべきページの提案
 */
function mytheme_next_read_suggestion($current_page_slug) {
    $suggestions = array(
        'about' => array(
            'title' => '開発作品を見る',
            'description' => '実際に制作したPythonプロジェクトをご覧ください',
            'slug' => 'works',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg>'
        ),
        'works' => array(
            'title' => 'プロジェクト詳細を見る',
            'description' => 'ロト6予測ツールの開発事例を詳しく解説',
            'slug' => 'works/loto6',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>'
        ),
        'loto6' => array(
            'title' => '他のプロジェクトも見る',
            'description' => '自動タイピングシステムなど、他の開発作品',
            'slug' => 'works/auto-typing',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>'
        ),
        'auto-typing' => array(
            'title' => '全ての作品を見る',
            'description' => '開発作品一覧ページで他のプロジェクトもチェック',
            'slug' => 'works',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>'
        ),
        'quest4' => array(
            'title' => '開発者について知る',
            'description' => '自己紹介ページで開発者のスキルと経歴をご確認ください',
            'slug' => 'about',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>'
        ),
        'beengineer-camp' => array(
            'title' => '他のプロジェクトも見る',
            'description' => '機械学習やLINE Botなど、他の開発作品もチェック',
            'slug' => 'works',
            'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>'
        )
    );
    
    if (isset($suggestions[$current_page_slug])) {
        return $suggestions[$current_page_slug];
    }
    
    return null;
}
