<?php
/**
 * Template Name: プロジェクト詳細 - プロジェクト3
 */
if ( ! defined( 'ABSPATH' ) ) exit;
get_header();

// 開発作品一覧ページのURLを取得
$works_page = get_page_by_path('works');
$works_url = $works_page ? get_permalink($works_page->ID) : home_url('/works/');
?>

<?php while ( have_posts() ) : the_post(); ?>
    <article class="page-content project-detail">
        <?php mytheme_breadcrumb(); ?>
        
        <header class="page-header">
            <h1 class="page-title">Quest4 - LINE学習クイズBot</h1>
        </header>

        <!-- プロジェクト画像 - スマホモックアップ（3枚横並び） -->
        <div class="phone-gallery">
            <!-- 画像1: 科目選択画面 -->
            <div class="phone-mockup">
                <div class="phone-screen">
                    <?php echo mytheme_picture_tag('assets/images/quest4_1.png', 'Quest4 - 科目選択画面', 'phone-screen__image', 'eager'); ?>
                </div>
            </div>
            
            <!-- 画像2: クイズ画面 -->
            <div class="phone-mockup">
                <div class="phone-screen">
                    <?php echo mytheme_picture_tag('assets/images/quest4_2.png', 'Quest4 - クイズ画面', 'phone-screen__image', 'lazy'); ?>
                </div>
            </div>
            
            <!-- 画像3: 結果画面 -->
            <div class="phone-mockup">
                <div class="phone-screen">
                    <?php echo mytheme_picture_tag('assets/images/quest4_3.png', 'Quest4 - 結果画面', 'phone-screen__image', 'lazy'); ?>
                </div>
            </div>
        </div>

        <div class="project-content">
            <!-- プロジェクト概要 -->
            <section class="project-section">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin: 0 0 12px;">
                    <h2 class="project-section__title" style="margin: 0;">プロジェクト概要</h2>
                    <a href="https://lin.ee/cyB8XEGb" target="_blank" rel="noopener noreferrer" style="text-wrap: nowrap;">
                        <img src="https://scdn.line-apps.com/n/line_add_friends/btn/ja.png" alt="友だち追加" height="36" border="0" style="vertical-align: middle;">
                    </a>
                </div>
                <p class="project-section__text">Google Apps ScriptとLINE Messaging APIを活用した<strong>対話型学習支援システム</strong>です。LINE Botを通じて、理科・社会・国語・英語の4科目24カテゴリから学習でき、Google Spreadsheetに格納された問題データベースから、ユーザーが選択した科目・分野・問題数に応じて出題し、リアルタイムで正誤判定と解説を提供します。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">LINE Messaging APIを活用した実践的なBot開発スキルの習得</li>
                    <li class="feature-list__item">Google Apps Scriptによるサーバーレスアーキテクチャの実装</li>
                    <li class="feature-list__item">Flex Messageを駆使したモダンなUI/UX設計</li>
                    <li class="feature-list__item">教育分野におけるチャットボットの有効活用</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">JavaScript (ES6+)</span>
                    <span class="tech-tag">JSON</span>
                </div>

                <h3 class="tech-category">バックエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Google Apps Script</span>
                    <span class="tech-tag">LINE Messaging API v2</span>
                    <span class="tech-tag">Google Spreadsheet API v4</span>
                    <span class="tech-tag">Properties Service</span>
                </div>
                <p class="project-section__text" style="margin-top: 12px; color: var(--text-secondary); font-size: 0.9rem;"><strong>Google Apps Script</strong>: サーバーレスバックエンド・Webhook処理<br>
                <strong>LINE Messaging API</strong>: メッセージ送受信・Bot機能<br>
                <strong>Properties Service</strong>: ユーザー状態管理・セッション保持</p>

                <h3 class="tech-category">フロントエンド（LINE UI）</h3>
                <div class="tech-stack">
                    <span class="tech-tag">LINE Flex Message</span>
                    <span class="tech-tag">Postback Action</span>
                    <span class="tech-tag">Carousel Template</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>

                <h3 class="feature-heading">1. 4科目対応の総合学習システム</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>理科（12カテゴリ）</strong>: 中1〜中3の物理・化学・生物・地学</li>
                    <li class="feature-list__item"><strong>社会（3カテゴリ）</strong>: 歴史・地理・公民</li>
                    <li class="feature-list__item"><strong>国語（5カテゴリ）</strong>: 漢字・ことわざ・慣用句・四字熟語・文法</li>
                    <li class="feature-list__item"><strong>英語（4カテゴリ）</strong>: 英単語・英熟語・英文法・穴埋め</li>
                    <li class="feature-list__item">合計24カテゴリの幅広い学習範囲をカバー</li>
                </ul>

                <h3 class="feature-heading">2. 直感的な3段階選択UI</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>科目選択</strong>: 2×2グリッドレイアウトで4科目を一覧表示</li>
                    <li class="feature-list__item"><strong>カテゴリ選択</strong>: Carouselで複数カテゴリをスワイプ表示</li>
                    <li class="feature-list__item"><strong>問題数選択</strong>: 5問/10問/20問/30問から選択</li>
                </ul>

                <h3 class="feature-heading">3. インタラクティブなクイズ機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>ランダム出題</strong>: データベースから問題をランダム抽出</li>
                    <li class="feature-list__item"><strong>4択問題</strong>: Flex Messageによる美しいボタンUI</li>
                    <li class="feature-list__item"><strong>即時フィードバック</strong>: 正誤判定と正解・解説の表示</li>
                    <li class="feature-list__item"><strong>進捗管理</strong>: 問題番号と正解数のリアルタイム表示</li>
                </ul>

                <h3 class="feature-heading">4. Google Spreadsheet連携</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">科目ごとに独立したSpreadsheet管理</li>
                    <li class="feature-list__item">カテゴリ別シート構成</li>
                    <li class="feature-list__item">データ更新時の自動反映</li>
                    <li class="feature-list__item">問題形式: 問題文・選択肢4つ・正解・解説</li>
                </ul>

                <h3 class="feature-heading">5. セッション管理機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">Properties Serviceによるユーザー状態保持</li>
                    <li class="feature-list__item">出題中の問題データ保存</li>
                    <li class="feature-list__item">正解数・進捗のトラッキング</li>
                    <li class="feature-list__item">クイズ終了時の自動クリーンアップ</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">データフロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">LINEユーザー</div>
                        <div class="flow-arrow">↓ メッセージ送信</div>
                        <div class="flow-item">LINE Platform</div>
                        <div class="flow-arrow">↓ Webhook</div>
                        <div class="flow-item">Google Apps Script</div>
                        <div class="flow-arrow">↓ データ取得</div>
                        <div class="flow-item">Google Spreadsheet（問題DB）</div>
                        <div class="flow-arrow">↓ 問題抽出・ランダム化</div>
                        <div class="flow-item">Flex Message生成</div>
                        <div class="flow-arrow">↓ LINE Messaging API</div>
                        <div class="flow-item">ユーザーへ返信</div>
                        <div class="flow-arrow">↓ Postback（回答）</div>
                        <div class="flow-item">正誤判定・次問題送信</div>
                    </div>
                </div>
            </section>

            <!-- 工夫した点 -->
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>

                <h3 class="feature-heading">1. Flex Messageによる高度なUI設計</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>2×2グリッドレイアウト</strong>: 科目選択・問題数選択を視覚的に整理</li>
                    <li class="feature-list__item"><strong>Carouselテンプレート</strong>: 多数のカテゴリを4つずつグループ化してスワイプ表示</li>
                    <li class="feature-list__item"><strong>カラーリング</strong>: 科目選択（紺色）、カテゴリ選択（オレンジ）、選択肢（青色）で視覚的に区別</li>
                </ul>

                <h3 class="feature-heading">2. 堅牢なエラーハンドリング</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">Spreadsheet/シート存在確認</li>
                    <li class="feature-list__item">データ空チェック → 「準備中」メッセージ表示</li>
                    <li class="feature-list__item">try-catchによる例外処理</li>
                    <li class="feature-list__item">ユーザーへの分かりやすいエラーメッセージ</li>
                </ul>

                <h3 class="feature-heading">3. 状態管理の最適化</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">Properties Serviceを活用したセッション管理</li>
                    <li class="feature-list__item">必要最小限のデータ保存（JSON形式）</li>
                    <li class="feature-list__item">クイズ終了時の自動クリーンアップ（<code class="feature-table__code">deleteAllProperties()</code>）</li>
                </ul>

                <h3 class="feature-heading">4. ユーザビリティの向上</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>連続出題</strong>: 正誤判定と次問題を1回の応答で送信（ユーザー待機時間短縮）</li>
                    <li class="feature-list__item"><strong>正解表示の充実</strong>: 不正解時に正解記号と内容を両方表示</li>
                    <li class="feature-list__item"><strong>進捗表示</strong>: 「問題3/10」のように現在位置を明示</li>
                </ul>

                <h3 class="feature-heading">5. データ構造の柔軟性</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">Spreadsheet IDを定数化 → メンテナンス性向上</li>
                    <li class="feature-list__item">カテゴリとシート名の動的マッピング</li>
                    <li class="feature-list__item">問題数の配列管理 → 簡単に変更可能</li>
                </ul>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>

                <h3 class="feature-heading">1. Postbackデータの階層的設計</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">// 科目選択
data: `subject=理科`

// カテゴリ選択
data: `category=理科|中１物理`

// 問題数選択
data: `start_quiz=理科|中１物理|10`

// 回答選択
data: `answer=①`</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">パイプ区切りで複数情報を1つのデータに格納</li>
                    <li class="feature-list__item"><code class="feature-table__code">split()</code>で復元し、科目・カテゴリ・問題数を取得</li>
                    <li class="feature-list__item">シンプルなデータ構造で状態管理を効率化</li>
                </ul>

                <h3 class="feature-heading">2. ランダム出題アルゴリズム</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">while (questions.length < parseInt(questionCount) && dataRows.length > 0) {
    const idx = Math.floor(Math.random() * dataRows.length);
    questions.push(dataRows.splice(idx, 1)[0]);
}</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item"><code class="feature-table__code">Math.random()</code>でランダムインデックスを生成</li>
                    <li class="feature-list__item"><code class="feature-table__code">splice()</code>で抽出済み問題を配列から削除</li>
                    <li class="feature-list__item">重複出題を完全に防止</li>
                    <li class="feature-list__item">指定問題数に達するまでループ</li>
                </ul>

                <h3 class="feature-heading">3. 連続出題の最適化</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">// 正誤判定 + 次問題を1つの配列で送信
const messages = [
    { type: 'text', text: '🎉 正解です！' },
    createQuestionMessage(userId, index + 1)  // 次問題
];
sendReply(replyToken, messages);</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">複数メッセージの一括送信でユーザー待機時間を短縮</li>
                    <li class="feature-list__item">正誤判定と次問題を同時に表示</li>
                    <li class="feature-list__item">LINE Messaging APIの配列機能を活用</li>
                    <li class="feature-list__item">スムーズな学習体験を実現</li>
                </ul>
            </section>

            <!-- 活用シーン -->
            <section class="project-section">
                <h2 class="project-section__title">活用シーン</h2>

                <h3 class="feature-heading">1. 学生向け</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>通学時間</strong>: スマホで手軽に復習</li>
                    <li class="feature-list__item"><strong>テスト前</strong>: 苦手分野の集中学習</li>
                    <li class="feature-list__item"><strong>隙間時間</strong>: 5問モードでサクッと学習</li>
                </ul>

                <h3 class="feature-heading">2. 教育者向け</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>宿題配信</strong>: LINE Botで問題を配布</li>
                    <li class="feature-list__item"><strong>小テスト</strong>: 授業前の確認テスト</li>
                    <li class="feature-list__item"><strong>データ更新</strong>: Spreadsheetで簡単に問題追加</li>
                </ul>

                <h3 class="feature-heading">3. 学習塾向け</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>生徒管理</strong>: 学習状況の把握</li>
                    <li class="feature-list__item"><strong>反転授業</strong>: 事前学習ツール</li>
                    <li class="feature-list__item"><strong>保護者連携</strong>: 学習報告の自動化（拡張機能として）</li>
                </ul>
            </section>

            <!-- 今後の展望 -->
            <section class="project-section">
                <h2 class="project-section__title">今後の展望</h2>

                <h3 class="feature-heading">1. 短期的な改善</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">解説の表示/非表示切り替え機能</li>
                    <li class="feature-list__item">出題履歴の記録（同じ問題の重複回避）</li>
                    <li class="feature-list__item">タイマー機能（制限時間設定）</li>
                    <li class="feature-list__item">正答率の可視化グラフ</li>
                </ul>

                <h3 class="feature-heading">2. 中期的な機能追加</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">ユーザー別の学習履歴管理</li>
                    <li class="feature-list__item">弱点分野の自動抽出</li>
                    <li class="feature-list__item">ランキング機能（友達と競争）</li>
                    <li class="feature-list__item">復習モード（不正解問題の再出題）</li>
                </ul>

                <h3 class="feature-heading">3. 長期的な拡張</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">AIによる問題自動生成</li>
                    <li class="feature-list__item">音声問題の対応</li>
                    <li class="feature-list__item">画像問題の対応</li>
                    <li class="feature-list__item">高校生・大学受験への対応</li>
                    <li class="feature-list__item">他の学習コンテンツ（英会話、数学など）の追加</li>
                </ul>
            </section>

            <!-- 開発情報 -->
            <section class="project-section">
                <h2 class="project-section__title">開発情報</h2>
                <div class="project-info-grid">
                    <div class="info-item">
                        <h3 class="info-item__title">開発形態</h3>
                        <p class="info-item__text">個人開発</p>
                    </div>
                    <div class="info-item">
                        <h3 class="info-item__title">役割</h3>
                        <p class="info-item__text">企画・設計・実装・テスト</p>
                    </div>
                </div>
            </section>

            <!-- 開発時の注意事項 -->
            <section class="project-section">
                <h2 class="project-section__title">開発時の注意事項</h2>
                <div class="disclaimer-box">
                    <p class="disclaimer-box__text"><strong>本プロジェクトは教育・学習目的で開発しました。開発および運用にあたり、以下の点に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>LINE Messaging APIの適切な利用</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">LINE Developersの利用規約を遵守し、個人的な学習範囲内での開発</li>
                        <li class="feature-list__item">メッセージ送信のレート制限を守り、過度なAPI呼び出しを避ける</li>
                        <li class="feature-list__item">ユーザーのプライバシーを尊重し、個人情報の収集は最小限に留める</li>
                        <li class="feature-list__item">テストは限定的なユーザーでのみ実施し、大規模配信は行わない</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>Google Apps Scriptの制限事項</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">Google Apps Scriptの実行時間制限（6分）を考慮した設計</li>
                        <li class="feature-list__item">Properties Serviceの容量制限（9KB）に配慮したデータ管理</li>
                        <li class="feature-list__item">Spreadsheet APIの1日あたりの読み取り上限を意識した実装</li>
                        <li class="feature-list__item">同時アクセス時の処理を考慮したエラーハンドリング</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>問題データの著作権配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">問題データは自作またはオープンソースのものを使用</li>
                        <li class="feature-list__item">教育目的での利用範囲を遵守</li>
                        <li class="feature-list__item">第三者の著作権を侵害しないよう、問題内容に十分配慮</li>
                        <li class="feature-list__item">商用利用や無断転載を行わない方針を明示</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>技術的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">セキュリティ: アクセストークンの適切な管理（環境変数化推奨）</li>
                        <li class="feature-list__item">パフォーマンス: 必要最小限のデータ取得でSpreadsheetへの負荷を軽減</li>
                        <li class="feature-list__item">保守性: コードの可読性を重視し、将来的な機能追加に対応</li>
                        <li class="feature-list__item">ユーザビリティ: 直感的なUI設計でストレスフリーな学習体験を提供</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>倫理的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">本ツールはポートフォリオとしての技術紹介を目的としている</li>
                        <li class="feature-list__item">学習支援という教育的価値を最優先に考えた設計</li>
                        <li class="feature-list__item">実用的な学習ツールとして、学生・教育者・塾への貢献を目指す</li>
                        <li class="feature-list__item">オープンソース化については、悪用防止の観点から慎重に検討</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; margin: 0 0 12px;">
                    <h2 class="project-section__title" style="margin: 0;">デモ動画（ショート）</h2>
                    <a href="https://lin.ee/cyB8XEGb" target="_blank" rel="noopener noreferrer" style="text-wrap: nowrap;">
                        <img src="https://scdn.line-apps.com/n/line_add_friends/btn/ja.png" alt="友だち追加" height="36" border="0" style="vertical-align: middle;">
                    </a>
                </div>
                <p class="project-section__text" style="margin-top: 0;">実際の動作をご覧いただけます。Quest4の操作画面と機能をわかりやすく紹介しています。</p>
                <div class="video-container video-container--shorts">
                    <iframe 
                        class="video-container__iframe" 
                        src="https://www.youtube.com/embed/_jCdPxBMmHA" 
                        title="Quest4 - LINE学習クイズBot デモ動画"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>LINE Corporation</strong>: LINE Messaging APIの提供と充実したドキュメント</li>
                    <li class="feature-list__item"><strong>Google</strong>: Google Apps ScriptとSpreadsheet APIの無償提供</li>
                    <li class="feature-list__item"><strong>教育関係者の皆様</strong>: 問題内容の監修や学習カリキュラムへの助言</li>
                    <li class="feature-list__item"><strong>オープンソースコミュニティ</strong>: JavaScriptライブラリと技術情報の共有</li>
                </ul>
            </section>
        </div>

        <div class="back-link">
            <a class="back-link__anchor" href="<?php echo esc_url( $works_url ); ?>">← 開発作品一覧に戻る</a>
        </div>
    </article>

    <!-- 構造化データ: SoftwareApplication -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SoftwareApplication",
        "name": "Quest4 - LINE学習クイズBot",
        "description": "Google Apps ScriptとLINE Messaging APIを活用した対話型学習支援システム。4科目24カテゴリから選択でき、リアルタイムで正誤判定と解説を提供します。",
        "applicationCategory": "EducationalApplication",
        "operatingSystem": "LINE",
        "offers": {
            "@type": "Offer",
            "price": "0",
            "priceCurrency": "JPY"
        },
        "author": {
            "@type": "Person",
            "name": "<?php echo esc_js( get_the_author_meta('display_name') ); ?>",
            "url": "<?php echo esc_url( home_url('/about/') ); ?>"
        },
        "datePublished": "2025-11-04T00:00:00+09:00",
        "image": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/quest4_1.png' ); ?>",
        "screenshot": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/quest4_1.png' ); ?>",
        "softwareVersion": "1.0",
        "programmingLanguage": ["JavaScript", "Google Apps Script"],
        "keywords": "LINE Bot, 学習支援, Google Apps Script, LINE Messaging API, Flex Message, 対話型, クイズ, 教育, JavaScript",
        "video": {
            "@type": "VideoObject",
            "name": "Quest4 - LINE学習クイズBot デモ動画",
            "description": "Quest4の実際の操作画面と機能を紹介するデモ動画です。",
            "thumbnailUrl": "<?php echo esc_url( get_template_directory_uri() . '/assets/images/quest4_1.png' ); ?>",
            "uploadDate": "2025-12-05T00:00:00+09:00",
            "contentUrl": "https://www.youtube.com/watch?v=_jCdPxBMmHA",
            "embedUrl": "https://www.youtube.com/embed/_jCdPxBMmHA"
        }
    }
    </script>
    
    <!-- 関連ページセクション -->
    <?php 
    $related_pages = mytheme_get_related_pages(get_the_ID(), 3);
    if (!empty($related_pages)): 
    ?>
    <section class="related-pages">
        <h2 class="related-pages-title">関連ページ</h2>
        <div class="related-pages-grid">
            <?php foreach ($related_pages as $page): ?>
            <div class="related-page-card">
                <h3 class="related-page-card__title"><?php echo esc_html($page['title']); ?></h3>
                <p class="related-page-card__description"><?php echo esc_html($page['excerpt']); ?></p>
                <a class="related-page-card__link" href="<?php echo esc_url($page['url']); ?>">
                    詳しく見る
                    <svg class="related-page-card__link-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- 次に読むべきページ提案 -->
    <?php 
    $next_suggestion = mytheme_next_read_suggestion('project-3');
    if ($next_suggestion): 
        $next_page = get_page_by_path($next_suggestion['slug']);
        if ($next_page):
            $icon_html = $next_suggestion['icon'];
            $icon_html = str_replace('<svg', '<svg class="next-read-btn__icon"', $icon_html);
    ?>
    <section class="next-read-section">
        <h2 class="next-read-title"><?php echo esc_html($next_suggestion['title']); ?></h2>
        <p class="next-read-description"><?php echo esc_html($next_suggestion['description']); ?></p>
        <a href="<?php echo esc_url(get_permalink($next_page->ID)); ?>" class="next-read-btn">
            <?php echo $icon_html; ?>
            今すぐ見る
        </a>
    </section>
    <?php 
        endif;
    endif; 
    ?>
<?php endwhile; ?>

<?php get_footer(); ?>
