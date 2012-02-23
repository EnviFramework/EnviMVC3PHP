<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

// ディスパッチャーのサンプル

// 実行時間計測用
define('LW_START_MTIMESTAMP', microtime(true));

// コンフィグファイルのパス
define('ENVI_MVC_APPKEY_PATH',     realpath('../config/'));

// キャッシュディレクトリのパス
define('ENVI_MVC_CACHE_PATH',     realpath('../cache/'));

// 環境ファイルのパス
define('ENVI_SERVER_STATUS_CONF', realpath('../env/ServerStatus.conf'));

// Envi3の読み込み
require('../libs/envi3/Envi.php');

// 環境
define('ENVI_ENV', EnviServerStatus()->getServerStatus());

try {
    Envi::dispatch('main', true);
} catch (redirectException $e) {

} catch (killException $e) {

} catch (PDOException $e) {

} catch (Exception $e) {

}
