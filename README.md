# 各部名称

* 従来 3PR BOX や 3PR AREA などとしていた特定の要素の集合部分は「セクション」に統一する。  
→ 3PR Section / ChildPage List Section / CTA Section など

# コーディングルール

## function名

接頭辞は <del>vkExUnit_</del>veu_ にする

- 他のプラグインなどと関数名がバッティングするのを避けるため

## ファイル名

<del>単語を連結する場合は _ で連結する</del>
※WordPressのコーディングルール的には - なので、順次 - に切り替える

## テーマオプション／ポストメタに保存する名前

単語を連結する場合は _ で連結する

## CSS命名について

- ウィジェットやcontentに追加する一番外側の要素に接頭辞"veu_"を付与する事でcssがテーマやプラグインのクラス名と被って余計なstyleの影響を受ける事を防ぐ
- セクションの一番外側が veu_セクション名 / その内側の要素は セクション名_XXXX とする
- 複数の単語の場合はキャメルケース（連結する単語の最初の１文字を大文字）にする  
※一つの単語なのか複数の単語が合わさっているのかわからないため
※WordPressのコーディングルール的にキャメルケースは微妙なのでそのうちどこかのタイミングで変更する必要がある...
- 要素が複数の場合は、単語をアンダーバーで区切る  
※ハイフンだとダブルクリックで選択出来ないため  
※WordPressのコーディングルール的にアンダーバーは微妙なのでそのうちどこかのタイミングで変更する必要がある...

## 機能追加の際の注意事項

- packages.php に書き込む時は、一番下に追加するのではなく、同類の機能は上下隣接するようにする  
例1）固定ページの本文にフックする 子ページリスト、お問い合わせ情報表示、HTMLサイトマップ出力機能などは隣接  
例2) 投稿ページの本文にフックする関連記事、Follow Me Section、CTAなどは隣接  
- vkExUnit.php に機能の有効化部分を書き込む時には上記同様なるべくグルーピングする。  
※ ただし、この順番は表示には影響しないので絶対きれいに並べておかないといけないわけではない。
- vkExUnit.php に機能の有効化部分を書き込む時には veu_package_is_enable() を使用する。
