<?php
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();
$home_url = home_url('/');
?>
<div class="sq" data-science-quiz>
    <p class="sq-kicker">Science Quiz</p>
    <h1 class="sq-title">中学理科クイズ</h1>
    <p class="sq-lead">学年と分野を選ぶと、ランダムに4択が出ます。</p>

    <section class="sq-panel" data-sq-setup>
        <div class="sq-field">
            <span class="sq-label">学年</span>
            <div class="sq-chips" data-sq-grades></div>
        </div>
        <div class="sq-field">
            <span class="sq-label">分野</span>
            <div class="sq-chips" data-sq-units></div>
        </div>
        <div class="sq-field">
            <span class="sq-label">問題数</span>
            <div class="sq-chips" data-sq-counts></div>
        </div>
        <p class="sq-hint" data-sq-pool-hint></p>
        <button type="button" class="sq-start" data-sq-start disabled>クイズを始める</button>
    </section>

    <section class="sq-panel sq-panel--play" data-sq-play hidden>
        <div class="sq-progress">
            <span data-sq-progress>1 / 10</span>
            <span data-sq-context></span>
        </div>
        <p class="sq-question" data-sq-question></p>
        <div class="sq-play-stage">
            <div class="sq-choices" data-sq-choices></div>
            <div class="sq-stamp" data-sq-stamp hidden></div>
        </div>
        <p class="sq-visually-hidden" data-sq-feedback aria-live="polite"></p>
        <button type="button" class="sq-next" data-sq-next disabled>次の問題へ</button>
    </section>

    <section class="sq-panel sq-panel--result" data-sq-result hidden>
        <p class="sq-score" data-sq-score></p>
        <div class="sq-review" data-sq-review></div>
        <button type="button" class="sq-start" data-sq-retry>もう一度</button>
    </section>

    <aside class="sq-ad sq-ad--rail sq-ad--left" data-sq-ad>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-6924336257757707"
             data-ad-format="vertical"
             data-full-width-responsive="false"></ins>
    </aside>
    <aside class="sq-ad sq-ad--rail sq-ad--right" data-sq-ad>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-6924336257757707"
             data-ad-format="vertical"
             data-full-width-responsive="false"></ins>
    </aside>

    <p class="sq-home">
        <a href="<?php echo esc_url($home_url); ?>">トップに戻る</a>
    </p>

    <div class="sq-ad sq-ad--bottom" data-sq-ad>
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-6924336257757707"
             data-ad-format="horizontal"
             data-full-width-responsive="true"></ins>
    </div>
</div>
<?php
get_footer();
