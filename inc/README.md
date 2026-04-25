# inc modules guide

`functions.php` はエントリーポイントとして最小化し、実装は `inc/` に分割しています。

## module map

- `bootstrap-init.php`  
  初期整備（固定ページ作成、メニュー初期化、管理画面での一度きり処理）。

- `assets-and-templates.php`  
  アセット読み込み、テンプレート探索、ナビBEMクラス、critical CSS preload。

- `column-support.php`  
  学習コラム運用支援（カテゴリ整備、投稿本文テンプレ、TOCショートコード）。

- `post-engagement.php`  
  投稿閲覧数カウント、関連記事ID取得/表示、関連キャッシュ削除。

- `internal-links.php`  
  パンくず、関連ページ提案、次に読む提案。

- `navigation-maintenance.php`  
  プライマリメニュー整備、ebooksデータ/言語切替、ebooksページ整備。

- `legal-content.php`  
  Contact/Privacy/Disclaimer の表示統一と法務文面装飾。

- `seo.php`  
  meta/OGP、JSON-LD、robots、sitemap関連。

- `performance-optimizations.php`  
  不要WP機能の削減、resource hints、prefetch、キャッシュヘッダー補助。

- `image-optimizations.php`  
  画像属性補完、次世代画像対応、画像サイズ/品質/アップロード制御。

- `media-helpers.php`  
  `mytheme_picture_tag()`（WebPフォールバック付き `<picture>` ヘルパー）。

- `sns-menus.php`  
  シェアメニューとSNSリンクUI。

- `accessibility-analytics.php`  
  SVGアクセシビリティ補助、GA4遅延読み込み。

## editing rules

- 新機能は、既存モジュールに責務が合うならそこへ追加。
- 合う場所がない場合は新規 `inc/*.php` を作成し、`functions.php` に `require_once` を追加。
- `functions.php` には実装ロジックを増やさず、読み込み・最小限の基盤処理に限定する。
