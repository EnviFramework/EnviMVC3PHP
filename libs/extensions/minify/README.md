minifyを使用するためのエクステンションクラス
=================================

概要
--------------------------------------------------
JSやCSSを連結、minifyするExtensionクラスです。

詳しくは、

http://www.enviphp.net/c/man/v3/reference/EnviPHP%E3%81%8C%E7%94%A8%E6%84%8F%E3%81%99%E3%82%8B%E3%82%A8%E3%82%AF%E3%82%B9%E3%83%86%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%B3/MinifyExtension

を参照して下さい。


パッケージ管理
--------------------------------------------------
EnviMarkdownExtensionパッケージをEnviMvcにバンドルさせるには、

`envi install-bundle new https://raw.githubusercontent.com/EnviMVC/EnviMinifyExtension/master/bundle.yml`

コマンドを実行します。

インストール・設定
--------------------------------------------------

パッケージがバンドルされていれば、

`envi install-extension {app_key} {DI設定ファイル} minify`

コマンドでインストール出来ます。

