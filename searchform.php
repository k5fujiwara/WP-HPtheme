<?php
/**
 * 検索フォームテンプレート
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$search_input_id = 'search-input-' . wp_unique_id();
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="<?php echo esc_attr( $search_input_id ); ?>" class="screen-reader-text">検索：</label>
    <div class="search-form-wrapper">
        <input type="hidden" name="post_type" value="post" />
        <input 
            type="search" 
            id="<?php echo esc_attr( $search_input_id ); ?>" 
            class="search-field" 
            placeholder="学習コラムの記事を検索" 
            value="<?php echo esc_attr( get_search_query() ); ?>" 
            name="s" 
            required
        />
        <button type="submit" class="search-submit">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <span class="screen-reader-text">検索</span>
        </button>
    </div>
</form>
