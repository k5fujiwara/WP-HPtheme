# inc modules guide

`functions.php` はエントリーポイントとして最小化し、実装は `inc/<役割>/` に分割しています。
読み込む一覧と順番は `functions.php` の `$mytheme_modules` にまとめています。

## テーマ全体の配置

```
mytheme/
├─ *.php              テンプレート（WordPressの仕様でテーマ直下に置く必要がある）
├─ style.css / screenshot.png / functions.php
├─ inc/               PHPの機能モジュール（このフォルダ）
├─ assets/
│  ├─ css/            main.css（全ページ共通）と pages/（ページ専用）。*.min.css は npm run build:css で生成
│  ├─ js/
│  ├─ images/         Web用に書き出した画像
│  └─ audio/
├─ data/              クイズの問題データ（外部から直接見えないよう .htaccess で保護）
├─ it1-code-pocket/   情報Ⅰコードポケット（静的HTMLアプリ）
└─ _dev/              開発用ファイル（本番では不要。詳細は _dev/README.md）
```

## module map

### core/ — 基盤
- `bootstrap-init.php` 初期整備（固定ページ作成、メニュー初期化、管理画面での一度きり処理）
- `assets-and-templates.php` CSS/JS の読み込み、テンプレート探索、ナビのBEMクラス
- `seo.php` meta/OGP、JSON-LD、robots、sitemap
- `performance-optimizations.php` 不要なWP機能の削減、resource hints、トップページのクエリキャッシュ
- `image-optimizations.php` 画像属性の補完、画像サイズ・品質・アップロード制御
- `media-helpers.php` `mytheme_picture_tag()`、プロフィール画像の取得
- `accessibility-analytics.php` SVGのアクセシビリティ補助、GA4の遅延読み込み

### content/ — 記事まわり
- `column-support.php` 学習コラムのテーマ分類、カテゴリ整備、目次ショートコード
- `post-engagement.php` 閲覧数カウント、関連記事
- `post-card-renderer.php` 記事タイル（一覧・トップ・検索で共通のカード）
- `search-support.php` 検索
- `internal-links.php` パンくず、関連ページ、次に読む提案
- `navigation-maintenance.php` メニュー整備、電子書籍ページ
- `legal-content.php` お問い合わせ・プライバシーポリシー・免責事項（本文は `legal/`）

### post-types/ — カスタム投稿タイプ
- `dictionary.php` 用語辞書
- `news.php` お知らせ
- `beengineer-news.php` BeEngineer通信
- `works.php` 開発作品（初期データは `work-seed-content.php`）
- `youtube-learning.php` YouTube学習

### apps/ — サイト内アプリ
- `science-quiz.php` / `japanese-quiz.php` クイズ（問題データは `data/`）
- `it1-code-pocket.php` 情報Ⅰコードポケットの配信

### ui/ — UI・外部連携
- `sns-menus.php` シェアメニューとSNSリンク

## editing rules

- 新機能は、役割が合う既存モジュールに追加する。
- 合う場所がない場合は該当フォルダに新規ファイルを作り、`functions.php` の `$mytheme_modules` に追加する。
- `functions.php` には実装ロジックを増やさず、読み込みと最小限の基盤処理に限定する。
- CSS を編集したら `npm run build:css` で `.min.css` を再生成する（min がソースより古いとソースが使われる）。
