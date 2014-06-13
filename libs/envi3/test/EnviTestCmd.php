<?php
/**
 * コマンドラインで自動テストを実行するためのファイル
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage EnviTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */
if (!isset($envi_cmd)) {
/**
 * バッチ用の設定
 *
 */
$start_time = microtime(true);
set_time_limit(0);
ini_set('memory_limit', -1);
umask();


// 引数の整形
foreach ($argv as $k => $item) {
    if (!strlen($item)) {
        unset($argv[$k]);
    }
}

ksort($argv);

$fargv = array_flip($argv);



/** 関数定義 */

/**
 * 引数の取得
 *
 * 指定した引数の次の値(-f "filename"のfilename)
 * を取得します。<br />
 * 存在しない場合は、
 * $default_paramの値を返す。
 *
 * @param string $name
 * @param mix $default_param (optional:false)
 */
function getOption($name, $default_param = false) {
    GLOBAL $argv,$fargv;
    if(isset($fargv[$name])){
        $x = $fargv[$name]+1;
        return isset($argv[$x]) ? $argv[$x] : false;
    } else {
        return $default_param;
    }
}

/**
 * $nameで指定された引数が存在するかどうかを確認する
 *
 * @param string $name
 */
function isOption($name) {
    GLOBAL $argv,$fargv;
    $fargv = array_flip($argv);
    return isset($fargv[$name]);
}

/**
 * 色付 echo
 */
function cecho($m, $c = 30, $oth = '') {
     system("echo -e '\e[{$c}m {$m} \e[m{$oth}'");
}


/**
 * エラーメッセージ
 */
function eecho($err)
{
    fwrite(STDERR, "[ERR]".$err."\n");
}

// debug
$debug_mode = isOption("--debug");
function debug_msg($msg)
{
    global $debug_mode,$start_time;
    if ($debug_mode) {
        echo microtime(true) - $start_time." : {$msg}  --  ".memory_get_usage(true)."byte\r\n";
    }

}

/* ----------------------------------------- */


// ヘルプ・マニュアル
if (isOption('-h') || isOption('--help') || isOption('-?') || !isset($argv[1])) {
    // ヘルプ表示
    cecho('Name:', 33);
    cecho('    EnviTest.php <テスト用yamlファイルのパス>');
    cecho('    --help,-h,-?                         ', 32, '\n         このヘルプメッセージを表示します。');
    cecho('    --debug                              ', 32, '\n         デバッグモードで実行します。');
    exit;
}

}


if (!isset($envi_cmd)) {
    $test_key = $argv[1];
} else {
    $test_key = $argv[2];
}

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviUnitTest.php';
// 実行
$EnviTest = EnviUnitTest::singleton($test_key);

// 設定ファイルから Envi自体の実行方法を選択する
if (!isset($EnviTest->system_conf['parameter']['test_mode'], $EnviTest->system_conf['app']['key']) ||
$EnviTest->system_conf['parameter']['test_mode'] === 'dummy') {
    include dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviDummy.php';
} elseif ($EnviTest->system_conf['parameter']['test_mode'] === 'resist_only') {
    define('ENVI_SERVER_STATUS_CONF', dirname(__FILE__).DIRECTORY_SEPARATOR.'test.conf');
    if (isset($EnviTest->system_conf['app']['appkey_path']) && $EnviTest->system_conf['app']['appkey_path'] !== '') {
        define('ENVI_MVC_APPKEY_PATH', $EnviTest->system_conf['app']['appkey_path']);
    }
    if (isset($EnviTest->system_conf['app']['cache_path']) && $EnviTest->system_conf['app']['cache_path'] !== '') {
        define('ENVI_MVC_CACHE_PATH', $EnviTest->system_conf['app']['appkey_path']);
    }

    include(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'Envi.php');
    Envi::registerOnly($EnviTest->system_conf['app']['key'], true);
}

if (!defined('ENVI_BASE_DIR')) {
    define('ENVI_BASE_DIR', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
}


$EnviTest->execute();


/**
 * コマンドラインで実行するためのクラス
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage EnviTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @doc_ignore
 */
class EnviTest
{
    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @param boolean $app OPTIONAL:false
     * @return Envi
     */
    public static function singleton($app = false)
    {
        return EnviUnitTest::singleton($app = false);
    }
    /* ----------------------------------------- */
}



