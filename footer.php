<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
</main>

<footer class="site-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="container">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <p class="site-footer__text">&copy; <?php echo date('Y'); ?> <span itemprop="copyrightHolder"><?php bloginfo('name'); ?></span></p>
                <p class="footer-tagline">教育現場での実践、AI・プログラミング、継続学習を整理する個人Web資産</p>
                <p class="site-footer__note">日々の学びや実践記録は <a href="https://note.com/k5fujiwara" target="_blank" rel="noopener noreferrer external">note</a> でも軽く発信しています。</p>
            </div>
        
            <?php
            // 必須ページへの導線（AdSense審査で見られやすい）
            $learning_column_url = function_exists('mytheme_get_page_url_by_path')
                ? mytheme_get_page_url_by_path('learning-column', home_url('/learning-column/'))
                : home_url('/learning-column/');
            $works_url = function_exists('mytheme_get_page_url_by_path')
                ? mytheme_get_page_url_by_path('works', home_url('/works/'))
                : home_url('/works/');
            $ebooks_url = function_exists('mytheme_get_page_url_by_path')
                ? mytheme_get_page_url_by_path('ebooks', home_url('/ebooks/'))
                : home_url('/ebooks/');
            $footer_links = [
                [
                    'label' => '学習コラム',
                    'url'   => $learning_column_url,
                ],
                [
                    'label' => '開発作品',
                    'url'   => $works_url,
                ],
                [
                    'label' => '運営者情報',
                    'url'   => function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('about', home_url('/about/'))
                        : home_url('/about/'),
                ],
                [
                    'label' => '電子書籍',
                    'url'   => $ebooks_url,
                ],
                [
                    'label' => 'お問い合わせ',
                    'url'   => function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('contact', home_url('/contact/'))
                        : home_url('/contact/'),
                ],
                [
                    'label' => 'プライバシーポリシー',
                    'url'   => function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('privacy-policy', home_url('/privacy-policy/'))
                        : home_url('/privacy-policy/'),
                ],
                [
                    'label' => '免責事項 / 広告表記',
                    'url'   => function_exists('mytheme_get_page_url_by_path')
                        ? mytheme_get_page_url_by_path('disclaimer', home_url('/disclaimer/'))
                        : home_url('/disclaimer/'),
                ],
            ];
            $beengineer_news_url = function_exists('get_post_type_archive_link')
                ? get_post_type_archive_link('beengineer-news')
                : home_url('/beengineer-news/');
            ?>
            <nav class="site-footer__links" aria-label="フッターリンク">
                <p class="site-footer__links-title">サイト情報</p>
                <ul class="site-footer__links-list">
                    <?php foreach ( $footer_links as $l ) : ?>
                        <li class="site-footer__links-item">
                            <a class="site-footer__links-link" href="<?php echo esc_url($l['url']); ?>">
                                <?php echo esc_html($l['label']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>

        </div>

        <div class="site-footer__bottom">
            <?php
            global $wp;
            $share_url  = rawurlencode( home_url( add_query_arg( [], $wp->request ) ) );
            $share_text = rawurlencode( get_bloginfo('name') );
            ?>
            <div class="global-share" aria-label="このページをシェア">
                <div class="share-buttons">
                    <a class="share-x" href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . $share_url . '&text=' . $share_text ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Xでシェア">
                        <span>𝕏</span>
                        <span class="label-desktop">シェアする</span>
                        <span class="label-mobile">シェア</span>
                    </a>
                    <a class="share-fb" href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebookでシェア">
                        <span>f</span>
                        <span class="label-desktop">シェアする</span>
                        <span class="label-mobile">シェア</span>
                    </a>
                    <a class="share-line" href="<?php echo esc_url( 'https://social-plugins.line.me/lineit/share?url=' . $share_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LINEでシェア">
                        <span>LINE</span>
                        <span class="label-desktop">シェアする</span>
                        <span class="label-mobile">シェア</span>
                    </a>
                    <a class="site-footer__feature-link" href="<?php echo esc_url($beengineer_news_url); ?>" aria-label="BeEngineer通信を見る">
                        <span class="label-desktop">BeEngineer通信を見る</span>
                        <span class="label-mobile">BeEn通信</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
