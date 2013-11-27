<?php
/**
 * コマンドラインで実行するためのクラス
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
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

if (!defined('ENVI_BASE_DIR')) {
    define('ENVI_BASE_DIR', realpath(dirname(__FILE__).'/../').DIRECTORY_SEPARATOR);
}

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



// 実行
$EnviTest = EnviTest::singleton($argv[1]);
$EnviTest->execute();

}

/**
 * コマンドライン用のクラス
 *
 *
 * @package    Envi3
 * @category   MVC
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviTest
{
    public $system_conf;
    private static $instance;

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @param  $file
     * @return void
     */
    public function __construct($file)
    {
        $this->system_conf = $this->parseYml(basename($file), dirname($file).DIRECTORY_SEPARATOR);
    }
    /* ----------------------------------------- */

    public function execute()
    {
        global $start_time;
        include_once $this->system_conf['scenario']['path'];
        $scenario              = new $this->system_conf['scenario']['class_name'];
        $scenario->system_conf = $this->system_conf;

        $arr = $scenario->execute();
        foreach ($arr as $test_val) {
            include_once $test_val['class_path'];
            $test_obj = new $test_val['class_name'];
            $test_obj->system_conf = $this->system_conf;
            $methods = isset($test_val['methods']) && count($test_val['methods']) ?
                $test_val['methods'] : get_class_methods($test_val['class_name']);
            foreach ($methods as $method) {
                if (!strpos($method, 'Test')) {
                    continue;
                }
                $test_obj->initialize();
                try{
                    $test_obj->$method();
                    $this->sendOKMessage($test_val['class_name'].'::'.$method);
                } catch (EnviTestException $e) {
                    $trace = $e->getTrace();
                    $this->sendNGMessage($test_val['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e->getMessage());
                } catch (exception $e) {
                    $this->sendErrorMessage($test_val['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e);
                }
                $test_obj->shutdown();
                $test_obj->free();
            }
        }
        echo round(microtime(true) - $start_time, 5)." : test end \r\n";
    }

    public function parseYml($file, $dir = ENVI_MVC_APPKEY_PATH)
    {
        if (!is_file($dir.$file)) {
            throw new EnviException('not such file '.$dir.$file);
        }
        include_once dirname(__FILE__).'/../spyc.php';
        ob_start();
        include $dir.$file;
        $buff      = ob_get_contents();
        ob_end_clean();

        $buff = spyc_load($buff);
        $res = isset($buff['test']) ? array_merge($buff['all'], $buff['test']) : $buff['all'];
        return $res;
    }

    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @param  $app OPTIONAL:false
     * @param  $debug OPTIONAL:false
     * @return Envi
     */
    public static function singleton($app = false)
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className($app);
        }
        return self::$instance;
    }
    /* ----------------------------------------- */


    private function sendOKMessage($msg)
    {
        cecho("[OK]", "36", $msg);
    }


    private function sendNGMessage($msg)
    {
        cecho("[NG]", "31", $msg);
    }

    private function sendErrorMessage($msg)
    {
        cecho("[ERROR]", "31", $msg);
    }

}



