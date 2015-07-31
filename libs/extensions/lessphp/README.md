Lessphpを使用するためのエクステンションクラス
=================================

概要
--------------------------------------------------
CSS拡張のLessコンパイラを使用するためのエクステンションです。

 http://leafo.net/lessphp

を内部的に使用しています。

パッケージ管理
--------------------------------------------------
EnviLessphpExtensionパッケージをEnviMvcにバンドルさせるには、

`envi install-bundle new https://raw.githubusercontent.com/EnviMVC/EnviLessphpExtension/master/bundle_newest.yml`

コマンドを実行します。


インストール・設定
--------------------------------------------------

パッケージがバンドルされていれば、

`envi install-extension {app_key} {DI設定ファイル} lessphp`

コマンドでインストール出来ます。

