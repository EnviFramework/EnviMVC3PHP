MarkdownExtraを使用するためのエクステンションクラス
=================================

概要
--------------------------------------------------
Markdown拡張である、MarkdownExtra形式で記述されたテキストを、HTMLにコンパイルするエクステンションです。

MarkdownExtraに関する詳細は、

https://michelf.ca/projects/php-markdown/extra/

を参照して下さい。

パッケージ管理
--------------------------------------------------
EnviMarkdownExtensionパッケージをEnviMvcにバンドルさせるには、

`envi install-bundle new https://raw.githubusercontent.com/EnviMVC/EnviMarkdownExtension/master/bundle.yml`

コマンドを実行します。

インストール・設定
--------------------------------------------------

パッケージがバンドルされていれば、

`envi install-extension {app_key} {DI設定ファイル} markdown`

コマンドでインストール出来ます。

