コンソールログを使用するためのエクステンションクラス
=================================

概要
--------------------------------------------------
`console()->log('fooo');`
で、ブラウザのコンソールに、ログを出力できるようになるエクステンションです。

詳しくはこちらをどうぞ

http://www.enviphp.net/c/man/v3/man/reference/EnviPHP%E3%81%8C%E7%94%A8%E6%84%8F%E3%81%99%E3%82%8B%E3%82%A8%E3%82%AF%E3%82%B9%E3%83%86%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%B3/ConsoleExtension/EnviConsoleExtension

パッケージ管理
--------------------------------------------------
EnviConsoleExtensionパッケージをEnviMvcにバンドルさせるには、

`envi install-bundle new https://raw.githubusercontent.com/EnviMVC/EnviConsoleExtension/master/bundle.yml`

コマンドを実行します。

インストール・設定
--------------------------------------------------

パッケージがバンドルされていれば、

`envi install-extension {app_key} {DI設定ファイル} console`

コマンドでインストール出来ます。

