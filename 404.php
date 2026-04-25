<?php
/**
 * 404エラーページテンプレート
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
?>

<div class="page-header">
    <div class="container">
        <h1 class="page-title">ページが見つかりません</h1>
        <p class="page-description">お探しのページは存在しないか、移動した可能性があります。</p>
    </div>
</div>

<div class="error-404-content">
    <div class="error-404-inner fade-in-element">
        <div class="error-code">404</div>
        <p class="error-message">申し訳ございませんが、お探しのページが見つかりませんでした。</p>
        
        <div class="error-actions">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="btn btn-primary">
                ホームページに戻る
            </a>
        </div>
        
        <div class="search-box">
            <h2>検索してみる</h2>
            <?php get_search_form(); ?>
        </div>
        
        <div class="helpful-links">
            <h2>おすすめのページ</h2>
            <ul class="page-links">
                <?php
                $pages = array('learning-column', 'about', 'works');
                foreach ($pages as $slug) {
                    $page = get_page_by_path($slug);
                    if ($page) {
                        echo '<li><a href="' . esc_url(get_permalink($page->ID)) . '">' . esc_html(get_the_title($page->ID)) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>

<style>
.error-404-content {
    padding: 80px 0;
    text-align: center;
}

.error-404-inner {
    max-width: 700px;
    margin: 0 auto;
    padding: 0 20px;
}

.error-code {
    font-size: clamp(4rem, 10vw, 8rem);
    font-weight: 900;
    color: #0f62fe;
    line-height: 1;
    margin-bottom: 20px;
    text-shadow: 0 4px 12px rgba(15, 98, 254, 0.2);
}

.error-message {
    font-size: 1.25rem;
    color: #4a5568;
    margin-bottom: 40px;
    line-height: 1.7;
}

.error-actions {
    margin-bottom: 60px;
}

.btn {
    display: inline-block;
    padding: 16px 32px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-primary {
    background: linear-gradient(135deg, #0f62fe 0%, #0353e9 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(15, 98, 254, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 98, 254, 0.4);
}

.search-box,
.helpful-links {
    margin-top: 60px;
    padding: 40px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
}

.search-box h2,
.helpful-links h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 24px;
}

.search-box .search-form {
    margin-top: 20px;
}

.search-box input[type="search"] {
    width: 100%;
    padding: 12px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-box input[type="search"]:focus {
    outline: none;
    border-color: #0f62fe;
    box-shadow: 0 0 0 3px rgba(15, 98, 254, 0.1);
}

.page-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.page-links li {
    margin: 0;
}

.page-links a {
    display: block;
    padding: 16px 24px;
    background: #f8fafc;
    border-radius: 8px;
    color: #0f62fe;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.page-links a:hover {
    background: #edf5ff;
    transform: translateX(8px);
}

@media (max-width: 768px) {
    .error-code {
        font-size: 4rem;
    }
    
    .search-box,
    .helpful-links {
        padding: 30px 20px;
    }
}
</style>

<?php get_footer(); ?>

