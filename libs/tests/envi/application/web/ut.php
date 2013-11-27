<?php
/**
 * フロントPHPのサンプル
 *
 * PATH_INFOに対応している必要があります。
 * main.php/module名/action名
 * 形式でリクエストすると、各Module,Actionにリクエストされます。
 * このroutingは現在変更できません。
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $ Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */

// 実行時間計測用(defaultでいい場合は省略可能)
define('LW_START_MTIMESTAMP', microtime(true));
if (!defined('ENVI_MVC_APPKEY_PATH')) {
    // コンフィグファイルのパス(defaultでいい場合は省略可能)
    define('ENVI_MVC_APPKEY_PATH',     realpath(dirname(__FILE__).'/../config/').DIRECTORY_SEPARATOR);
}
// キャッシュディレクトリのパス(defaultでいい場合は省略可能)
define('ENVI_MVC_CACHE_PATH',     realpath(dirname(__FILE__).'/../cache/').DIRECTORY_SEPARATOR);

// 環境ファイルのパス(defaultでいい場合は省略可能)
define('ENVI_SERVER_STATUS_CONF', realpath(dirname(__FILE__).'/../env/status.conf'));

// デバッグのOnOf
$debug = true;

// Envi3の読み込み
require_once(dirname(__FILE__).'/../../../../envi3/Envi.php');

try {
    Envi::dispatch('ut', $debug);
} catch (redirectException $e) {

} catch (killException $e) {

} catch (PDOException $e) {
    if ($debug) {
        var_dump($e);
    }
} catch (Exception $e) {
    if ($debug) {
        var_dump($e);
    }
}
