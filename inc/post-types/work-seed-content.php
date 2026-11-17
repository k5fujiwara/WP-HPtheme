<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Legacy work detail content used only for one-time production migration.
 *
 * The old page templates were removed after the local migration. Production
 * environments that seed after that deletion still need the original detailed
 * body HTML so the admin-managed work posts match the previous pages.
 */
function mytheme_get_legacy_work_seed_contents() {
    return array (
  'loto6' => '<!-- プロジェクト概要 -->
            <section class="project-section">
                <h2 class="project-section__title">プロジェクト概要</h2>
                <p class="project-section__text">過去のロト6抽選データを分析し、機械学習アルゴリズムを用いて次回の当選番号を予測するWebアプリケーションです。<strong>2つの異なる予測モデル</strong>を実装し、結果を比較表示することで、多角的な予測を提供します。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">機械学習を活用した実践的なデータ分析スキルの習得</li>
                    <li class="feature-list__item">複数の予測モデルの実装と比較検証</li>
                    <li class="feature-list__item">モダンなWebアプリケーション開発</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Python 3.x</span>
                    <span class="tech-tag">HTML5</span>
                    <span class="tech-tag">CSS3</span>
                    <span class="tech-tag">JavaScript</span>
                </div>

                <h3 class="tech-category">バックエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Flask 3.0.3</span>
                    <span class="tech-tag">scikit-learn 1.7.1</span>
                    <span class="tech-tag">pandas 2.3.1</span>
                    <span class="tech-tag">NumPy 2.3.2</span>
                    <span class="tech-tag">Selenium 4.34.2</span>
                    <span class="tech-tag">webdriver-manager 4.0.2</span>
                </div>
                <p class="project-section__text" style="margin-top: 12px; color: var(--text-secondary); font-size: 0.9rem;"><strong>Selenium</strong>: WebブラウザでのXPath要素取得によるデータ自動収集<br>
                <strong>webdriver-manager</strong>: ChromeDriverの自動管理</p>

                <h3 class="tech-category">フロントエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Vanilla JavaScript</span>
                    <span class="tech-tag">CSS Grid/Flexbox</span>
                    <span class="tech-tag">CSS Animations</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>
                
                <h3 class="feature-heading">1. 2つの予測モデルによる比較分析</h3>
                <div class="model-comparison">
                    <div class="model-box">
                        <h4 class="model-box__title">モデルA: 確率モデル（ロジスティック回帰）</h4>
                        <ul class="feature-list">
                            <li class="feature-list__item">過去の出現パターンを統計的に分析</li>
                            <li class="feature-list__item">特徴量: 直近出現回数、累計出現数、経過回数など10種類</li>
                            <li class="feature-list__item">クラス不均衡対策として class_weight="balanced" を適用</li>
                        </ul>
                    </div>
                    <div class="model-box">
                        <h4 class="model-box__title">モデルB: RandomForestモデル</h4>
                        <ul class="feature-list">
                            <li class="feature-list__item">アンサンブル学習による高精度予測</li>
                            <li class="feature-list__item">複雑なパターン・非線形関係の学習</li>
                            <li class="feature-list__item">特徴量重要度の可視化が可能</li>
                        </ul>
                    </div>
                </div>

                <h3 class="feature-heading">2. 自動データ収集機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">SeleniumによるWebブラウザ自動操作</li>
                    <li class="feature-list__item">XPathを使った要素取得による過去の抽選結果の自動収集</li>
                    <li class="feature-list__item">みずほ銀行公式サイトから複数URLを巡回してデータ取得</li>
                    <li class="feature-list__item">取得データのCSV形式での保存</li>
                </ul>

                <h3 class="feature-heading">3. モダンなUI/UX</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">グラデーション背景による視覚的に魅力的なデザイン</li>
                    <li class="feature-list__item">ボールのバウンスアニメーション効果</li>
                    <li class="feature-list__item">予測計算中のローディング表示</li>
                    <li class="feature-list__item">レスポンシブデザイン（PC・タブレット・スマートフォン対応）</li>
                </ul>

                <h3 class="feature-heading">4. 予測結果の視覚化</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">本数字6個とボーナス数字を直感的に表示</li>
                    <li class="feature-list__item">2つのモデルの予測結果を並列比較</li>
                    <li class="feature-list__item">ボール形式での見やすい表示</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">データフロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">公式サイト</div>
                        <div class="flow-arrow">↓ Selenium XPath取得</div>
                        <div class="flow-item">collect_loto6.py（データ収集）</div>
                        <div class="flow-arrow">↓ CSV出力</div>
                        <div class="flow-item">loto6_results.csv</div>
                        <div class="flow-arrow">↓ データ読込</div>
                        <div class="flow-item">予測モデルA・B（学習・推論）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">Flask（結果表示）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">index.html（ブラウザ表示）</div>
                    </div>
                </div>
            </section>

            <!-- 工夫した点 -->
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>
                
                <h3 class="feature-heading">1. 機械学習モデルの工夫</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>クラス不均衡対策</strong>: 出現しない数字が圧倒的に多いため、class_weightで調整</li>
                    <li class="feature-list__item"><strong>特徴量エンジニアリング</strong>: 10種類の独自特徴量を設計
                        <ul class="nested-list">
                            <li class="nested-list__item">直近5回/10回の出現回数</li>
                            <li class="nested-list__item">累計出現回数</li>
                            <li class="nested-list__item">最終出現からの経過回数</li>
                            <li class="nested-list__item">ボーナス数字としての出現傾向</li>
                            <li class="nested-list__item">時間トレンド</li>
                        </ul>
                    </li>
                </ul>

                <h3 class="feature-heading">2. フォールバック機能</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">scikit-learnが利用できない環境でもヒューリスティック手法で動作</li>
                    <li class="feature-list__item">データ不足時の自動切り替え</li>
                </ul>

                <h3 class="feature-heading">3. UX/UIデザイン</h3>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>非同期処理</strong>: 予測計算中もUIが固まらない設計</li>
                    <li class="feature-list__item"><strong>視覚フィードバック</strong>: ローディングアニメーションで待機時間を退屈させない</li>
                    <li class="feature-list__item"><strong>色分け</strong>: 本数字（金色）とボーナス数字（青色）を明確に区別</li>
                </ul>

                <h3 class="feature-heading">4. 保守性・拡張性</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">型ヒント（Type Hints）による可読性向上</li>
                    <li class="feature-list__item">関数の単一責任原則（SRP）に基づいた設計</li>
                    <li class="feature-list__item">CSV形式の柔軟な対応（複数ヘッダー形式に対応）</li>
                </ul>
            </section>

            <!-- 特徴量設計の詳細 -->
            <section class="project-section">
                <h2 class="project-section__title">特徴量設計の詳細</h2>
                <p class="project-section__text">各数字（1～43）について以下の特徴量を抽出：</p>
                <div class="feature-table-wrapper">
                    <table class="feature-table">
                        <thead class="feature-table__head">
                            <tr>
                                <th class="feature-table__header-cell">特徴量</th>
                                <th class="feature-table__header-cell">説明</th>
                                <th class="feature-table__header-cell">目的</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent5_cnt</code></td>
                                <td class="feature-table__cell">直近5回での出現回数</td>
                                <td class="feature-table__cell">短期トレンド</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent10_cnt</code></td>
                                <td class="feature-table__cell">直近10回での出現回数</td>
                                <td class="feature-table__cell">中期トレンド</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">cumulative_cnt</code></td>
                                <td class="feature-table__cell">累計出現回数</td>
                                <td class="feature-table__cell">長期的な出現頻度</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">last_draw_flag</code></td>
                                <td class="feature-table__cell">前回出現したか</td>
                                <td class="feature-table__cell">連続出現傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent5_bonus_cnt</code></td>
                                <td class="feature-table__cell">直近5回でボーナス出現</td>
                                <td class="feature-table__cell">ボーナス短期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">recent10_bonus_cnt</code></td>
                                <td class="feature-table__cell">直近10回でボーナス出現</td>
                                <td class="feature-table__cell">ボーナス中期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">cumulative_bonus_cnt</code></td>
                                <td class="feature-table__cell">ボーナス累計出現</td>
                                <td class="feature-table__cell">ボーナス長期傾向</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">gap_main</code></td>
                                <td class="feature-table__cell">最終出現からの経過回数</td>
                                <td class="feature-table__cell">Recency効果</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">gap_bonus</code></td>
                                <td class="feature-table__cell">ボーナス最終出現からの経過</td>
                                <td class="feature-table__cell">ボーナスRecency</td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell"><code class="feature-table__code">time_trend</code></td>
                                <td class="feature-table__cell">時間的トレンド（正規化）</td>
                                <td class="feature-table__cell">経年変化</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>
                
                <h3 class="feature-heading">1. 複数モデルの並列実行</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 2つのモデルを同時に実行し結果を比較
prob_main, prob_bonus = predict_probabilities(draws_main, draws_bonus)
a_main_numbers, a_bonus_number = pick_numbers(prob_main, prob_bonus)

b_main_numbers, b_bonus_number = run_been_model("loto6_results.csv", time_to_predict=next_time)</code></pre>
                </div>

                <h3 class="feature-heading">2. 柔軟なCSV読み込み</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 複数の異なるヘッダー形式に対応
# 例: "数字1", "num_1", "当選番号1" など</code></pre>
                </div>

                <h3 class="feature-heading">3. エラーハンドリング</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">try:
    # メインロジック
except Exception as e:
    # フォールバック処理
    context["error"] = f"エラー: {e}"</code></pre>
                </div>
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
                    <p class="disclaimer-box__text"><strong>本プロジェクトは教育・学習目的で開発しました。開発および使用にあたり、以下の点に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>データ収集における配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">公開データのみを使用し、みずほ銀行公式サイトの利用規約を遵守</li>
                        <li class="feature-list__item">適切な待機時間（sleep）を設定し、サーバーへの負荷を最小限に抑制</li>
                        <li class="feature-list__item">過度なアクセスを避け、必要最小限のデータ取得に留める</li>
                        <li class="feature-list__item">取得したデータは個人的な学習目的にのみ使用</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>予測システムの位置づけ</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">機械学習技術の学習・検証を目的とした実験的プロジェクト</li>
                        <li class="feature-list__item">予測結果は統計的な分析に基づくものであり、確実性を保証するものではない</li>
                        <li class="feature-list__item">本システムを商用利用や実際の購入判断には使用していない</li>
                        <li class="feature-list__item">ギャンブル依存症への配慮から、あくまで技術研究の範囲内で運用</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>倫理的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">本ツールはポートフォリオとしての技術紹介を目的としている</li>
                        <li class="feature-list__item">オープンソースとして公開せず、悪用防止に配慮</li>
                        <li class="feature-list__item">教育目的の範囲を超えた利用を推奨しない立場を明示</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <h2 class="project-section__title">デモ動画</h2>
                <p class="project-section__text">実際の動作をご覧いただけます。予測モデルの動作や画面の使い方をわかりやすく紹介しています。</p>
                <div class="video-container">
                    <iframe 
                        class="video-container__iframe"
                        src="https://www.youtube.com/embed/7Cmkga044EA" 
                        title="ロト6予測ツール デモ動画"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>データ提供</strong>: みずほ銀行ロト6公式サイト</li>
                    <li class="feature-list__item"><strong>機械学習ライブラリ</strong>: scikit-learn開発チーム</li>
                    <li class="feature-list__item"><strong>Webフレームワーク</strong>: Flask開発チーム</li>
                    <li class="feature-list__item"><strong>ブラウザ自動操作</strong>: Seleniumプロジェクト</li>
                </ul>
            </section>',
  'auto-typing' => '<!-- プロジェクト概要 -->
            <section class="project-section">
                <h2 class="project-section__title">プロジェクト概要</h2>
                <p class="project-section__text">日本最大級のタイピング練習サイト「e-typing」に対応した自動入力プログラムです。<strong>Selenium WebDriver</strong>によるブラウザ自動操作技術を活用し、XPathによる動的要素取得と文字列自動入力を実装しました。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">Web自動化技術（Selenium）の実践的スキル習得</li>
                    <li class="feature-list__item">XPathを用いた動的要素取得の理解</li>
                    <li class="feature-list__item">iframe操作を含む複雑なDOM構造への対応</li>
                    <li class="feature-list__item">ブラウザ操作の自動化プログラミング体験</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Python 3.x</span>
                </div>

                <h3 class="tech-category">ブラウザ自動化</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Selenium 4.34.2</span>
                    <span class="tech-tag">webdriver-manager 4.0.2</span>
                    <span class="tech-tag">requests 2.32.4</span>
                    <span class="tech-tag">python-dotenv 1.1.1</span>
                </div>
                <p class="project-section__text" style="margin-top: 12px; color: var(--text-secondary); font-size: 0.9rem;"><strong>Selenium</strong>: Webブラウザの自動操作・要素取得<br>
                <strong>webdriver-manager</strong>: ChromeDriverの自動インストール・管理</p>

                <h3 class="tech-category">その他依存ライブラリ</h3>
                <div class="tech-stack">
                    <span class="tech-tag">trio / trio-websocket</span>
                    <span class="tech-tag">urllib3</span>
                    <span class="tech-tag">certifi</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>
                
                <h3 class="feature-heading">1. e-typing自動タイピング機能</h3>
                <p class="project-section__text"><strong>対象サイト</strong>: <a href="https://www.e-typing.ne.jp/" target="_blank" rel="noopener noreferrer" style="color: var(--primary-blue);">e-typing（イータイピング）</a> - 日本最大級のタイピング練習サイト</p>
                
                <p class="project-section__text"><strong>実装機能</strong>:</p>
                <ul class="feature-list">
                    <li class="feature-list__item">ローマ字タイピングチェックの自動実行</li>
                    <li class="feature-list__item">XPathによる動的テキスト要素の取得</li>
                    <li class="feature-list__item">15問の自動入力処理</li>
                    <li class="feature-list__item">スコア・レベルの自動取得とコンソール表示</li>
                    <li class="feature-list__item">無限ループモード対応（コメントアウト解除で有効化）</li>
                    <li class="feature-list__item">iframe内要素への正確なアクセス</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">動作フロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">e-typingサイトアクセス</div>
                        <div class="flow-arrow">↓ 1秒待機</div>
                        <div class="flow-item">ローマ字チェックリンククリック</div>
                        <div class="flow-arrow">↓ 1秒待機</div>
                        <div class="flow-item">腕試しレベルチェックボタンクリック</div>
                        <div class="flow-arrow">↓ 2秒待機・iframe切り替え</div>
                        <div class="flow-item">タイピング開始ボタンクリック</div>
                        <div class="flow-arrow">↓ 2秒待機・body要素取得</div>
                        <div class="flow-item">スペースキー送信でタイピング準備</div>
                        <div class="flow-arrow">↓ 3秒待機</div>
                        <div class="flow-item">15問の文字列を1文字ずつ自動入力</div>
                        <div class="flow-arrow">↓ 各問題後1秒待機</div>
                        <div class="flow-item">結果画面からスコア・レベル取得</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">コンソールに結果表示</div>
                    </div>
                </div>
            </section>

            <!-- 工夫した点 -->
            <section class="project-section">
                <h2 class="project-section__title">工夫した点</h2>
                
                <h3 class="feature-heading">1. XPathによる柔軟な要素取得</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># 次にタイプする文字列を動的に取得
text = driver.find_element("xpath", 
    "//div[@id=\'sentenceText\']/div/span/following-sibling::span").text</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">following-sibling軸を使用した兄弟要素の取得</li>
                    <li class="feature-list__item">動的に変化するテキストへの対応</li>
                    <li class="feature-list__item">タイピング済み文字ではなく「未タイプ文字」のみを正確に取得</li>
                </ul>

                <h3 class="feature-heading">2. iframeへの切り替え処理</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># タイピング画面はiframe内にあるため切り替えが必要
driver.switch_to.frame("typing_content")</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">e-typingのタイピング画面はtyping_contentというiframe内に実装</li>
                    <li class="feature-list__item">正確な要素操作のためのコンテキスト切り替えが必須</li>
                    <li class="feature-list__item">iframe切り替えなしでは要素が見つからない</li>
                </ul>

                <h3 class="feature-heading">3. ChromeDriverの自動管理</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">from webdriver_manager.chrome import ChromeDriverManager

service = Service(ChromeDriverManager().install())
driver = webdriver.Chrome(service=service, options=options)</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">webdriver-managerにより環境に応じたChromeDriverを自動ダウンロード</li>
                    <li class="feature-list__item">手動でのドライバー管理が不要</li>
                    <li class="feature-list__item">Chromeバージョンアップ時も自動対応</li>
                </ul>

                <h3 class="feature-heading">4. 適切な待機時間の設定</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">各処理の間に適切な待機時間を設定</li>
                    <li class="feature-list__item">ページ読み込みやJavaScript実行の完了を待つ</li>
                    <li class="feature-list__item">エラーを防ぐための安全マージン確保</li>
                </ul>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>
                
                <h3 class="feature-heading">1. 動的要素の監視と文字単位での入力</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code"># タイピング問題を1文字ずつ自動入力
for _ in range(15):
    text = driver.find_element("xpath", 
        "//div[@id=\'sentenceText\']/div/span/following-sibling::span").text
    for char in text:
        body_element.send_keys(char)
    time.sleep(1)</code></pre>
                </div>

                <h3 class="feature-heading">2. XPath軸を活用した柔軟な要素取得</h3>
                <div class="code-block">
                    <pre class="code-block__pre"><code class="code-block__code">"//div[@id=\'sentenceText\']/div/span/following-sibling::span"</code></pre>
                </div>
                <ul class="feature-list">
                    <li class="feature-list__item">sentenceTextという特定IDの要素から出発</li>
                    <li class="feature-list__item">子要素のdiv、さらにその子のspanへ移動</li>
                    <li class="feature-list__item">following-sibling軸で兄弟要素（未タイプ部分）を取得</li>
                    <li class="feature-list__item">複雑なDOM構造を正確にナビゲート</li>
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
                    <p class="disclaimer-box__text"><strong>本プロジェクトは教育・学習目的で開発しました。開発および検証にあたり、以下の点に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>利用規約の遵守</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">e-typingサイトの利用規約を事前に確認し、個人的な学習範囲内での開発</li>
                        <li class="feature-list__item">自動化技術の学習を目的とし、ランキングや公式記録への影響を避ける</li>
                        <li class="feature-list__item">Webスクレイピング技術の研究として、倫理的配慮を持って実装</li>
                        <li class="feature-list__item">本番環境での継続的な使用は行わず、あくまで技術検証に限定</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>サーバーへの配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">適切な待機時間（time.sleep）を各処理に設定し、過度な負荷を防止</li>
                        <li class="feature-list__item">無限ループモードはコメントアウトし、デフォルトでは実行されない設計</li>
                        <li class="feature-list__item">テスト実行は必要最小限に留め、連続実行を控える運用方針</li>
                        <li class="feature-list__item">ページ読み込み完了を確認してから次の操作を実行する設計</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>技術的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">ブラウザ自動化技術（Selenium）の学習を主目的とした開発</li>
                        <li class="feature-list__item">XPath、iframe操作など、複雑なDOM構造への対応技術の習得</li>
                        <li class="feature-list__item">実用ツールではなく、技術研究・ポートフォリオとしての位置づけ</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>倫理的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">オープンソースとして公開せず、悪用防止に配慮</li>
                        <li class="feature-list__item">自動化技術の学習範囲を超えた使用を推奨しない立場を明示</li>
                        <li class="feature-list__item">e-typingサービスの健全な運営を尊重する姿勢を維持</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <h2 class="project-section__title">デモ動画</h2>
                <p class="project-section__text">実際の動作をご覧いただけます。e-typingサイトでの自動タイピングの様子をわかりやすく紹介しています。</p>
                <div class="video-container">
                    <iframe 
                        class="video-container__iframe"
                        src="https://www.youtube.com/embed/dyzOZBjYJcU" 
                        title="e-typing自動タイピング デモ動画"
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>e-typing</strong>: 日本最大級のタイピング練習サイトの提供</li>
                    <li class="feature-list__item"><strong>Seleniumプロジェクト</strong>: 強力なブラウザ自動化フレームワーク</li>
                    <li class="feature-list__item"><strong>webdriver-manager</strong>: ChromeDriver自動管理ツールの開発</li>
                    <li class="feature-list__item"><strong>Pythonコミュニティ</strong>: 豊富なライブラリとドキュメント</li>
                </ul>
            </section>',
  'quest4' => '<!-- プロジェクト概要 -->
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
    { type: \'text\', text: \'🎉 正解です！\' },
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
            </section>',
  'beengineer-camp' => '<!-- プロジェクト概要 -->
            <section class="project-section">
                <div class="project-section__heading-row">
                    <h2 class="project-section__title">プロジェクト概要</h2>
                    <a class="work-link work-link--compact" href="https://keigo-fujiwara.github.io/public_beengineer_camp25/" target="_blank" rel="noopener noreferrer">
                        <span class="work-link__label">合宿案内サイトはこちら</span>
                    </a>
                </div>
                <p class="project-section__text">BeEngineerプログラミング合宿（2025年11月22日〜24日）向けの情報提供サイト。ロゴスランド京都での2泊3日に必要な情報をまとめ、<strong>HTML5/CSS3/Vanilla JavaScriptのみで構成した軽量・静的サイト</strong>です。レスポンシブデザインでPC/タブレット/スマホに対応し、合宿中のスケジュール・持ち物・アクセス・フロア案内を一元化します。</p>
            </section>

            <!-- 開発目的 -->
            <section class="project-section">
                <h2 class="project-section__title">開発目的</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">参加者への情報提供を効率化（スケジュール・持ち物・アクセス）</li>
                    <li class="feature-list__item">フレームワーク不使用で軽量なレスポンシブサイトを構築</li>
                    <li class="feature-list__item">タブ/アコーディオンなどインタラクティブUIの実装</li>
                    <li class="feature-list__item">チェックリストの状態をlocalStorageで保持し、再訪問時に復元</li>
                </ul>
            </section>

            <!-- 使用技術 -->
            <section class="project-section">
                <h2 class="project-section__title">使用技術</h2>
                
                <h3 class="tech-category">プログラミング言語</h3>
                <div class="tech-stack">
                    <span class="tech-tag">HTML5</span>
                    <span class="tech-tag">CSS3</span>
                    <span class="tech-tag">JavaScript (ES6+)</span>
                </div>

                <h3 class="tech-category">フロントエンド</h3>
                <div class="tech-stack">
                    <span class="tech-tag">Vanilla JavaScript</span>
                    <span class="tech-tag">CSS Custom Properties</span>
                    <span class="tech-tag">CSS Grid / Flexbox</span>
                    <span class="tech-tag">Intersection Observer</span>
                </div>

                <h3 class="tech-category">データ管理・API</h3>
                <div class="tech-stack">
                    <span class="tech-tag">localStorage</span>
                    <span class="tech-tag">Google Maps埋め込み</span>
                </div>
            </section>

            <!-- 主な機能 -->
            <section class="project-section">
                <h2 class="project-section__title">主な機能</h2>

                <h3 class="feature-heading">1. レスポンシブナビゲーション</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">PC: 固定サイドバー + セクション内リンク</li>
                    <li class="feature-list__item">SP: ハンバーガーメニュー + スライドメニュー</li>
                    <li class="feature-list__item">スクロールスパイで現在セクションをハイライト</li>
                </ul>

                <h3 class="feature-heading">2. インタラクティブUI</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">スケジュール：1日目/2日目/3日目のタブ切り替え</li>
                    <li class="feature-list__item">アクセス：車・電車/バス・京都駅タブ切り替え</li>
                    <li class="feature-list__item">フロアマップ：1F/2F/3F切り替え</li>
                    <li class="feature-list__item">SPではアコーディオンで情報を整理</li>
                </ul>

                <h3 class="feature-heading">3. 持ち物チェックリスト</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">チェック状態をlocalStorageに保存・復元</li>
                    <li class="feature-list__item">チェック済みを視覚的にフィードバック</li>
                </ul>

                <h3 class="feature-heading">4. ブログ（day1/day2/day3）</h3>
                <ul class="feature-list">
                    <li class="feature-list__item">日別の写真ギャラリー</li>
                    <li class="feature-list__item">前後日のナビゲーション</li>
                </ul>
            </section>

            <!-- システム構成 -->
            <section class="project-section">
                <h2 class="project-section__title">システム構成</h2>
                <div class="system-architecture">
                    <h3 class="system-architecture__title">ページ構成</h3>
                    <div class="dataflow">
                        <div class="flow-item">index.html（トップ）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">セクション（案内/日程/プログラム/フロア/持ち物/アクセス）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">blog/day1.html / day2.html / day3.html</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">assets（fav, logos, blog images）</div>
                    </div>

                    <h3 class="system-architecture__title" style="margin-top: 32px;">データフロー</h3>
                    <div class="dataflow">
                        <div class="flow-item">ユーザー操作（チェックリスト）</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">localStorageへ保存</div>
                        <div class="flow-arrow">↓</div>
                        <div class="flow-item">再訪時に復元しUIへ反映</div>
                    </div>
                </div>
            </section>

            <!-- 技術的ハイライト -->
            <section class="project-section">
                <h2 class="project-section__title">技術的ハイライト</h2>

                <h3 class="feature-heading">1. Intersection Observerでスクロールスパイ</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">const observer = new IntersectionObserver(observerCallback, {
  root: null,
  rootMargin: \'-20% 0px -70% 0px\',
  threshold: 0
});
sections.forEach(section => observer.observe(section));</code></pre>
                </div>

                <h3 class="feature-heading">2. localStorageでチェックリスト状態を永続化</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">checklistItems.forEach(item => {
  const key = item.dataset.item;
  if (localStorage.getItem(key) === \'true\') {
    item.checked = true;
    item.parentElement.classList.add(\'checked\');
  }
});</code></pre>
                </div>

                <h3 class="feature-heading">3. CSS変数でテーマ管理</h3>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">:root {
  --color-primary: #0E8B62;
  --color-secondary: #F47F2E;
  --color-accent: #FF6B6B;
  --color-bg: #FAFAF8;
}</code></pre>
                </div>
            </section>

            <!-- ファイル構成 -->
            <section class="project-section">
                <h2 class="project-section__title">ファイル構成</h2>
                <div class="code-block">
<pre class="code-block__pre"><code class="code-block__code">BeEnCamp/
├── index.html
├── styles.css
├── script.js
├── blog/
│   ├── day1.html
│   ├── day2.html
│   └── day3.html
└── assets/
    ├── fav/
    ├── logos/
    └── blog/images/</code></pre>
                </div>
            </section>

            <!-- デザインシステム -->
            <section class="project-section">
                <h2 class="project-section__title">デザインシステム</h2>
                <div class="feature-table-wrapper">
                    <table class="feature-table">
                        <thead class="feature-table__head">
                            <tr>
                                <th class="feature-table__header-cell">カテゴリ</th>
                                <th class="feature-table__header-cell">カラー名</th>
                                <th class="feature-table__header-cell">カラーコード</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">メイン</td>
                                <td class="feature-table__cell">Primary</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#0E8B62</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">メイン</td>
                                <td class="feature-table__cell">Secondary</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#F47F2E</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">アクセント</td>
                                <td class="feature-table__cell">Accent</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#FF6B6B</code></td>
                            </tr>
                            <tr class="feature-table__row">
                                <td class="feature-table__cell">背景</td>
                                <td class="feature-table__cell">Background</td>
                                <td class="feature-table__cell"><code class="feature-table__code">#FAFAF8</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <ul class="feature-list" style="margin-top:16px;">
                    <li class="feature-list__item">フォント: \'Segoe UI\', \'Yu Gothic UI\', \'Meiryo\', sans-serif</li>
                    <li class="feature-list__item">タイトル: 2.5rem / 本文: 1rem</li>
                    <li class="feature-list__item">行間: 1.7</li>
                </ul>
            </section>

            <!-- 活用シーン -->
            <section class="project-section">
                <h2 class="project-section__title">活用シーン</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">イベント・合宿の案内サイト</li>
                    <li class="feature-list__item">教育機関のイベント告知・レポート</li>
                    <li class="feature-list__item">シンプルなLPテンプレートとして再利用</li>
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
                        <p class="info-item__text">フロントエンド / UI/UX / デザイン</p>
                    </div>
                    <div class="info-item">
                        <h3 class="info-item__title">期間</h3>
                        <p class="info-item__text">2025年11月（約1ヶ月）</p>
                    </div>
                </div>
            </section>

            <!-- パフォーマンス・セキュリティ -->
            <section class="project-section">
                <h2 class="project-section__title">パフォーマンス・セキュリティ</h2>
                <ul class="feature-list">
                    <li class="feature-list__item">静的サイトで高速表示・脆弱性が少ない</li>
                    <li class="feature-list__item">XSS対策: innerHTMLを避けtextContentを使用</li>
                    <li class="feature-list__item">外部リソースはGoogle Mapsのみ</li>
                    <li class="feature-list__item">localStorageのみを利用し個人情報を扱わない</li>
                </ul>
            </section>

            <!-- 開発時の注意事項 -->
            <section class="project-section">
                <h2 class="project-section__title">開発時の注意事項</h2>
                <div class="disclaimer-box">
                    <p class="disclaimer-box__text"><strong>本サイトは合宿参加者向けの情報提供を目的としており、以下に配慮しています。</strong></p>
                    
                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>デザイン・著作権</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">画像・ロゴは適切な権利範囲で使用（許諾確認済み）</li>
                        <li class="feature-list__item">カラーパレットやアイコンも許諾確認済み</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>技術的配慮</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">モダンブラウザ向け（IE非対応）</li>
                        <li class="feature-list__item">静的サイト構成でサーバーサイド依存を最小化</li>
                        <li class="feature-list__item">JavaScript無効時も基本情報は閲覧可能</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>アクセシビリティ</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">セマンティックHTMLで構造化し、キーボード操作に配慮</li>
                        <li class="feature-list__item">コントラスト比を確保、スクリーンリーダー対応は継続改善予定</li>
                    </ul>

                    <p class="disclaimer-box__text" style="margin-top: 16px;"><strong>プライバシー</strong></p>
                    <ul class="feature-list">
                        <li class="feature-list__item">個人情報を収集しない（localStorageはチェックリスト状態のみ）</li>
                        <li class="feature-list__item">外部リソースは信頼できるもの（Google Maps）に限定</li>
                    </ul>
                </div>
            </section>

            <!-- デモ動画 -->
            <section class="project-section" id="demo-video">
                <div class="project-section__heading-row">
                    <h2 class="project-section__title">デモ動画</h2>
                    <a class="work-link work-link--compact" href="https://keigo-fujiwara.github.io/public_beengineer_camp25/" target="_blank" rel="noopener noreferrer">
                        <span class="work-link__label">合宿案内サイトはこちら</span>
                    </a>
                </div>
                <p class="project-section__text" style="margin-top: 0;">実際の合宿案内サイトの動作を動画でご覧いただけます。</p>
                <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 12px; background: #000;">
                    <iframe src="https://www.youtube.com/embed/p38oM7Z5viM?si=iX_xIrVRePTAp5oU" title="YouTube video player" style="position:absolute; top:0; left:0; width:100%; height:100%; border:0; border-radius:12px;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </section>

            <!-- 謝辞 -->
            <section class="project-section">
                <h2 class="project-section__title">謝辞</h2>
                <ul class="feature-list">
                    <li class="feature-list__item"><strong>ロゴスランド京都</strong>: 会場の提供</li>
                    <li class="feature-list__item"><strong>BeEngineer</strong>: 合宿の企画・運営</li>
                    <li class="feature-list__item"><strong>MDN Web Docs</strong>: Web技術ドキュメント</li>
                </ul>
            </section>',
);
}
