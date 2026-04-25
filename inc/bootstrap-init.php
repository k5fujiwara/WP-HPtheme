<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * primary メニューのIDを取得（なければ作成）
 */
function mytheme_get_or_create_primary_menu_id() {
    $locations = get_theme_mod('nav_menu_locations');
    if ( ! is_array($locations) ) {
        $locations = [];
    }
    $menu_location = 'primary';
    $menu_id = isset($locations[$menu_location]) ? (int) $locations[$menu_location] : 0;
    if ( $menu_id ) {
        return $menu_id;
    }

    $menu_id = wp_create_nav_menu('Primary Menu');
    if ( is_wp_error($menu_id) || ! $menu_id ) {
        return 0;
    }

    $locations[$menu_location] = (int) $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    return (int) $menu_id;
}

/**
 * 自己紹介ページを作成/整備し、メニュー整備を呼び出す
 */
function mytheme_setup_about_page_and_menu() {
    // 自己紹介ページの作成/取得
    $about_page = mytheme_get_page_by_path_cached('about');
    if ( ! $about_page ) {
        $page_id = wp_insert_post([
            'post_title'   => '自己紹介',
            'post_name'    => 'about',
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => '',
        ]);
        if ( ! is_wp_error($page_id) ) {
            // 念のためテンプレートを明示
            update_post_meta($page_id, '_wp_page_template', 'page-about.php');
        }
    } else {
        $page_id = $about_page->ID;
        update_post_meta($page_id, '_wp_page_template', 'page-about.php');
    }

    if ( empty($page_id) || is_wp_error($page_id) ) {
        return;
    }

    // 学習コラムページだけ軽量に保証（ヘッダーは固定ナビ）
    if ( function_exists('mytheme_ensure_learning_column_page') ) {
        mytheme_ensure_learning_column_page();
    }
}

// テーマ有効化済みサイト向けの初回補正
function mytheme_ensure_about_page_once() {
    // Gutenberg/REST中は実行しない（エディタのREST応答を壊さない）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( get_option('mytheme_about_page_seeded') ) return;
    mytheme_setup_about_page_and_menu();
    update_option('mytheme_about_page_seeded', 1);
}

/**
 * お問い合わせ / プライバシーポリシー / 免責事項（広告表記）ページを一度だけ作成
 * - AdSense審査・サイト信頼性の最低要件を満たすためのベース
 * - 内容はWordPress管理画面から自由に編集してください
 */
function mytheme_ensure_site_legal_pages_once() {
    // Gutenberg/REST中は実行しない（エディタのREST応答を壊さない）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( get_option('mytheme_legal_pages_seeded') ) return;

    $pages = [
        [
            'slug'  => 'contact',
            'title' => 'お問い合わせ',
            'content' => "お問い合わせは以下よりお願いいたします。\n\n- お問い合わせ先（メール等）：（ここに連絡先を記載してください）\n\n※返信までお時間をいただく場合があります。",
        ],
        [
            'slug'  => 'privacy-policy',
            'title' => 'プライバシーポリシー',
            'content' => "当サイト（以下「当サイト」）は、個人情報の保護に最大限配慮し、以下の方針に基づいて適切に取り扱います。\n\n■ 広告配信について\n当サイトは、第三者配信の広告サービス（Google AdSense）を利用する予定/利用する場合があります。第三者配信事業者は、ユーザーの興味に応じた広告を表示するため Cookie を使用することがあります。\n\n■ アクセス解析について\n当サイトは、アクセス解析（Google Analytics 等）を利用する場合があります。アクセス解析は Cookie を利用してトラフィックデータを収集しますが、個人を特定するものではありません。\n\n■ Cookieの利用について\n当サイトは、利便性向上のため Cookie を利用する場合があります（例：電子書籍ページの表示言語の保持など）。\nブラウザ設定により Cookie を無効化することも可能です。\n\n■ 免責\n当サイトに掲載する情報は可能な限り正確な情報を提供するよう努めますが、内容の正確性・安全性を保証するものではありません。\n\n■ お問い合わせ窓口\nお問い合わせは「お問い合わせ」ページよりご連絡ください。\n\n（最終更新日：2026-01-16）",
        ],
        [
            'slug'  => 'disclaimer',
            'title' => '免責事項 / 広告表記',
            'content' => "■ 免責事項\n当サイトに掲載する情報は、可能な限り正確な情報を提供するよう努めていますが、内容の正確性・完全性を保証するものではありません。\n当サイトの利用によって生じた損害等について、当サイトは一切の責任を負いかねます。\n\n■ 外部リンクについて\n当サイトから外部サイトへ移動された場合、移動先サイトで提供される情報・サービス等について一切責任を負いません。\n\n■ 広告表記\n当サイトは、第三者配信の広告サービス（Google AdSense）や、アフィリエイトプログラム等を利用する場合があります。\n\n■ 著作権\n当サイトに掲載している文章・画像等の著作物の無断転載を禁止します。\n\n（最終更新日：2026-01-16）",
        ],
    ];

    foreach ( $pages as $p ) {
        $slug = (string) $p['slug'];
        $title = (string) $p['title'];
        $content = (string) $p['content'];

        if ( mytheme_get_page_by_path_cached($slug) ) {
            continue;
        }
        $page_id = wp_insert_post([
            'post_title'   => $title,
            'post_name'    => $slug,
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_content' => $content,
        ]);
        if ( is_wp_error($page_id) ) {
            // 途中で失敗しても再実行できるように seeded は最後に立てる
            continue;
        }
    }

    update_option('mytheme_legal_pages_seeded', 1);
}

/**
 * プロジェクト詳細ページの作成（階層構造）
 * 注：移行処理を削除し、新規作成・更新のみに簡素化
 */
function mytheme_get_or_create_works_page_id() {
    $works_page = mytheme_get_page_by_path_cached('works');
    if ( $works_page ) {
        $works_id = (int) $works_page->ID;
        update_post_meta($works_id, '_wp_page_template', 'page-works.php');
        return $works_id;
    }

    $works_id = wp_insert_post([
        'post_title'   => '開発作品',
        'post_name'    => 'works',
        'post_type'    => 'page',
        'post_status'  => 'publish',
        'post_content' => '',
    ]);
    if ( is_wp_error($works_id) || ! $works_id ) {
        return 0;
    }
    update_post_meta((int) $works_id, '_wp_page_template', 'page-works.php');
    return (int) $works_id;
}

function mytheme_create_project_pages($works_id = 0) {
    $works_id = (int) $works_id;
    if ( $works_id <= 0 ) {
        $works_id = mytheme_get_or_create_works_page_id();
    }
    if ( $works_id <= 0 ) return;
    
    // プロジェクト情報を配列で管理
    $projects = [
        'loto6' => [
            'title' => 'ロト６予測ツール',
            'template' => 'templates/projects/project-1.php'
        ],
        'auto-typing' => [
            'title' => 'e-typing自動タイピング',
            'template' => 'templates/projects/project-2.php'
        ],
        'quest4' => [
            'title' => 'Quest4 - LINE学習クイズBot',
            'template' => 'templates/projects/project-3.php'
        ],
        'beengineer-camp' => [
            'title' => 'BeEngineer合宿案内サイト',
            'template' => 'templates/projects/project-4.php'
        ]
    ];
    
    // 各プロジェクトページを作成または更新
    foreach ( $projects as $slug => $project ) {
        $page = mytheme_get_page_by_path_cached('works/' . $slug);
        
        if ( ! $page ) {
            // ページが存在しない場合は新規作成
            $page_id = wp_insert_post([
                'post_title'   => $project['title'],
                'post_name'    => $slug,
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_content' => '',
                'post_parent'  => $works_id,
            ]);
            
            if ( ! is_wp_error($page_id) ) {
                update_post_meta($page_id, '_wp_page_template', $project['template']);
            }
        } else {
            // ページが存在する場合はテンプレートのみ更新
            update_post_meta($page->ID, '_wp_page_template', $project['template']);
        }
    }
}

/**
 * テーマ切替時の初期整備を一括実行
 */
function mytheme_after_switch_theme_bootstrap() {
    // aboutページ作成・テンプレ整備・メニュー整備
    mytheme_setup_about_page_and_menu();

    // works親ページと子プロジェクトページを整備
    $works_id = mytheme_get_or_create_works_page_id();
    if ( $works_id > 0 ) {
        mytheme_create_project_pages($works_id);
    }
}
add_action('after_switch_theme', 'mytheme_after_switch_theme_bootstrap');

/**
 * 作品ページと子プロジェクトページを常時同期
 * - works 親ページがなければ作成し、テンプレートを割り当てる
 * - 子プロジェクトページを作成/更新（idempotent）
 */
function mytheme_sync_project_pages() {
    // Gutenberg/REST中は実行しない（エディタのREST応答を壊さない）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    // 管理画面で一度だけ（重い＆DB更新があるため）
    if ( ! is_admin() ) return;
    if ( ! current_user_can('edit_pages') ) return;
    if ( get_option('mytheme_project_pages_synced') ) return;

    // 親 works ページを確保
    $works_id = mytheme_get_or_create_works_page_id();
    if ( $works_id <= 0 ) return;

    // 子プロジェクトページを整備
    mytheme_create_project_pages($works_id);

    update_option('mytheme_project_pages_synced', 1);
}

/**
 * 管理画面向けの初期整備を1つのフックに集約
 * - admin_init の多重フックを減らし、初回同期処理を一括で実行
 */
function mytheme_admin_bootstrap_once() {
    // Gutenberg/REST中は実行しない（エディタのREST応答を壊さない）
    if ( function_exists('wp_doing_ajax') && wp_doing_ajax() ) return;
    if ( defined('REST_REQUEST') && REST_REQUEST ) return;
    if ( ! is_admin() ) return;

    // 必要権限を満たす処理のみを実行
    if ( current_user_can('manage_categories') ) {
        mytheme_ensure_column_categories();
    }
    if ( current_user_can('manage_options') ) {
        mytheme_ensure_about_page_once();
        mytheme_ensure_site_legal_pages_once();
        mytheme_ensure_learning_column_page();
    }
    if ( current_user_can('edit_pages') ) {
        mytheme_sync_project_pages();
        mytheme_ensure_ebooks_page_once();
    }
    if ( current_user_can('edit_theme_options') && function_exists('mytheme_ensure_primary_menu_links') ) {
        mytheme_ensure_primary_menu_links();
    }
}
add_action('admin_init', 'mytheme_admin_bootstrap_once', 10);
