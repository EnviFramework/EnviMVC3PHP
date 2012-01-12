<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

define('ENVI_BASE_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR);
require ENVI_BASE_DIR.'spyc.php';
require ENVI_BASE_DIR.'serverStatus.php';
require ENVI_BASE_DIR.'ActionBase.php';
require ENVI_BASE_DIR.'ViewBase.php';
require ENVI_BASE_DIR.'Controller.php';
require ENVI_BASE_DIR.'Request.php';
require ENVI_BASE_DIR.'enviUser.php';
require ENVI_BASE_DIR.'validator.php';
require ENVI_BASE_DIR.'logWriter.php';


/**
 * +-- Redirect用の例外
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class redirectException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        if (Envi()->getConfiguration('SYSTEM', 'use_i18n')) {
            $envi = Envi()->getI18n('envi');
            echo '<a href="'.$message.'">'.$envi['redirect_message'].'</a>';
        } else {
            echo '<a href="'.$message.'">リダイレクトされない場合はこちらへ</a>';
        }

        // parent::__construct($message, $code, $previous);
    }

}
/* ----------------------------------------- */

/**
 * +-- 処理中断用の例外
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class killException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        // parent::__construct($message, $code, $previous);
    }
}
/* ----------------------------------------- */

/**
 * +-- 404エラー
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class Envi404Exception extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        if (Envi::$debug) {
            echo "{$message} Envi404[{$code}]";
        } else {
            header("HTTP/1.0 404 Not Found");
        }
        // parent::__construct($message, $code, $previous);
    }
}
/* ----------------------------------------- */
/**
 * +-- 403エラー
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class Envi403Exception extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        if (Envi::$debug) {
            echo "{$message} Envi403[{$code}]";
        } else {
            header("HTTP/1.0 403 Forbidden");
        }
        // parent::__construct($message, $code, $previous);
    }
}
/* ----------------------------------------- */

/**
 * +-- 汎用的な例外
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
/* ----------------------------------------- */


/** ユーザー定義可能な定数 */
if (!defined('ENVI_MVC_APPKEY_PATH')) {
    define('ENVI_MVC_APPKEY_PATH',     realpath(ENVI_BASE_DIR.'dsn'.DIRECTORY_SEPARATOR));
}
if (!defined('ENVI_MVC_CACHE_PATH')) {
    define('ENVI_MVC_CACHE_PATH',     realpath(ENVI_BASE_DIR.'cache'.DIRECTORY_SEPARATOR));
}


/**
 * +-- Envi
 *
 * @params  $app OPTIONAL:false
 * @params  $debug OPTIONAL:false
 * @return Envi
 */
function Envi($app = false, $debug = false)
{
    return Envi::singleton($app, $debug);
}
/* ----------------------------------------- */



/**
 *
 *
 * @access public
 * @since 0.1
 * @package Envi3
 * @subpackage Envi3
 */
class Envi
{
    const DEFAULT_ACCESS = 'DEFAULT';
    const SUCCESS        = 'SUCCESS';
    const ERROR          = 'ERROR';
    const CONFORM        = 'CONFORM';
    const COMMIT         = 'COMMIT';
    const NONE           = 'NONE';

    private static $app_key;
    private $_system_conf;
    private $_i18n = array();
    public $module_dir;
    public $autoload_dirs;
    private static $instance;
    public  static $debug;


    /**
     * +-- コンストラクタ
     *
     * @access private
     * @params  $app
     * @params  $debug OPTIONAL:false
     * @return void
     */
    private function __construct($app, $debug = false)
    {
        self::$debug     = $debug;
        self::$app_key   = $app;
        $this->_system_conf      = $this->parseYml($app.'.yml');

        if ($debug || !is_file(ENVI_MVC_CACHE_PATH.$app.ENVI_ENV.'.autoload_constant.cash')) {
            $autoload_constant_dir = array_merge(
                array(
                    ENVI_BASE_DIR.'libs'.DIRECTORY_SEPARATOR,
                    ENVI_BASE_DIR.'plugins'.DIRECTORY_SEPARATOR,
                ), $this->_system_conf['AUTOLOAD_CONSTANT']
            );
            $autoload_constant = array();
            $autoload_constant[] = $this->_system_conf['SYSTEM']['renderer'];
            foreach ($autoload_constant_dir as $dir) {
                if (is_dir($dir)) {
                    if ($dh = opendir($dir)) {
                        while (($file = readdir($dh)) !== false) {
                            if (strpos($file, '.php')) {
                                $autoload_constant[] = $dir.$file;
                            }
                        }
                        closedir($dh);
                    }
                }
            }
            $cache = "<?php\n";
            foreach ($autoload_constant as $v) {
                $cache .= "include '{$v}';\n";
            }
            file_put_contents(ENVI_MVC_CACHE_PATH.$app.ENVI_ENV.'.autoload_constant.cash', $cache);
        }

        // 国際化
        if ($this->_system_conf['SYSTEM']['use_i18n']) {
            $this->_i18n = $this->parseYml($this->_system_conf['I18N'][Request::getIi8n()], ENVI_BASE_DIR.'i18n'.DIRECTORY_SEPARATOR);
        }

        // DBを使用するかどうか
        if ($this->_system_conf['SYSTEM']['use_databases']) {
            require ENVI_BASE_DIR.'EnviDBI.php';
        }

        $this->autoload_dirs = array_merge(
            array(
                ENVI_BASE_DIR,
                ENVI_BASE_DIR.'libs'.DIRECTORY_SEPARATOR,
                ENVI_BASE_DIR.'plugins'.DIRECTORY_SEPARATOR,
            ), $this->_system_conf['AUTOLOAD']
        );

    }
    /* ----------------------------------------- */


    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @params  $app OPTIONAL:false
     * @params  $debug OPTIONAL:false
     * @return Envi
     */
    public static function singleton($app = false, $debug = false)
    {
        if (!isset(self::$instance)) {
            if (!$app) {
                throw new Envi404Exception('アプリキーの指定がないです。', 90001);
            }
            $className = __CLASS__;
            self::$instance = new $className($app, $debug);
        }
        return self::$instance;
    }
    /* ----------------------------------------- */

    /**
     * +-- コンフィグデータをすべて返します
     *
     * @access public
     * @return array
     */
    public function &getConfigurationAll()
    {
        return $this->_system_conf;
    }
    /* ----------------------------------------- */



    /**
     * +-- コンフィグデータを返します
     *
     * @access public
     * @params string $key
     * @params string $key2 可変長引数です。OPTIONAL:....
     * @return mixed
     */
    public function getConfiguration($key)
    {
        $args = func_get_args();
        $system_conf = $this->_system_conf;
        foreach ($args as $k) {
            if (!isset($system_conf[$k])) {
                return null;
            }
            $system_conf = $system_conf[$k];
        }
        return $system_conf;
    }
    /* ----------------------------------------- */

    /**
     * +-- アプリキーを返す
     *
     * @access public
     * @return string
     */
    public function getApp()
    {
        return self::$app_key;
    }
    /* ----------------------------------------- */

    /**
     * +-- 国際化データを返します
     *
     * @param stging $key キー
     * @access public
     * @return array
     */
    public function getI18n($key)
    {
        return $this->_i18n[$key];
    }
    /* ----------------------------------------- */

    /**
     * +-- Loggerを取得
     *
     * @static
     * @return logWriter
     */
    public static function getLogger()
    {
        return logWriter::singleton();
    }
    /* ----------------------------------------- */

    /**
     * +-- DBのコネクション取得
     *
     * @access public
     * @params  $db_key
     * @return object
     */
    public function getDBConnection($db_key)
    {
        if (!isset($this->_system_conf['DATABASE'][$db_key])) {
            throw new EnviException("DB: {$db_key}が存在してません。");
        }
        $class_name = $this->_system_conf['DATABASE'][$db_key]['class_name'];
        return $class_name::getConnection($this->_system_conf['DATABASE'][$db_key]['params'], $db_key);
    }
    /* ----------------------------------------- */

    /**
     * +-- 処理を振り分ける
     *
     * @access public
     * @static
     * @params string $app アプリキー
     * @params boolean $debug OPTIONAL:false
     * @return void
     */
    public static function dispatch($app, $debug = false)
    {
        try {
            $envi = self::singleton($app, $debug);
            // リクエストモジュールの初期化
            Request::initialize();
            include ENVI_MVC_CACHE_PATH.self::$app_key.ENVI_ENV.'.autoload_constant.cash';
            $envi->_run(true);
        } catch (redirectException $e) {
            throw $e;
        } catch (killException $e) {
            throw $e;
        } catch (PDOException $e) {
            Envi::getLogger()->fatal($e->getMessage());
            Envi::getLogger()->fatal($e->getFile().' line on '.$e->getLine());
            if (!$debug) {
                header('HTTP/1.0 500 Internal Server Error');
            }
            throw $e;
        } catch (Exception $e) {
            Envi::getLogger()->fatal($e->getMessage());
            Envi::getLogger()->fatal($e->getFile().' line on '.$e->getLine());
            if (!$debug) {
                header('HTTP/1.0 500 Internal Server Error');
            }
            throw $e;
        }
    }

    /**
     * +-- YAMLファイルをパースする
     *
     * @access public
     * @params  $file
     * @return array
     */
    public function parseYml($file, $dir = ENVI_MVC_APPKEY_PATH)
    {
        if (!is_file(ENVI_MVC_CACHE_PATH.$file.ENVI_ENV.'.cash') || (self::$debug && @filemtime(ENVI_MVC_APPKEY_PATH.$file) > @filemtime($dir.$file.ENVI_ENV.'.cash'))) {
            ob_start();
            include $dir.$file;
            $buff      = ob_get_contents();
            ob_end_clean();
            $buff = spyc_load($buff);

            $res = isset($buff[ENVI_ENV]) ? array_merge($buff['all'], $buff[ENVI_ENV]) : $buff['all'];
            file_put_contents(ENVI_MVC_CACHE_PATH.$file.ENVI_ENV.'.cash', serialize($res));
        } else {
            $res      = unserialize(file_get_contents(ENVI_MVC_CACHE_PATH.$file.ENVI_ENV.'.cash'));
        }
        return $res;
    }
    /* ----------------------------------------- */


    /**
     * Performerから呼ばれる、実処理メソッド
     *
     * @final
     * @access private
     * @return mixed
     */
    final public function _run($is_first = false)
    {
        // 規定のconfig.phpファイルを読み込む
        if ($is_first && is_file($this->_system_conf['DIRECTORY']['modules'].'config.php')) {
            include_once($this->_system_conf['DIRECTORY']['modules'].'config.php');
        }
        $base_module_dir = Controller::isActionChain() ?
            $this->_system_conf['DIRECTORY']['chain_modules'] : $this->_system_conf['DIRECTORY']['modules'];

        // Module
        $module_dir = $base_module_dir.Request::getThisModule().DIRECTORY_SEPARATOR;

        // Action
        $action_dir = $module_dir.$this->_system_conf['DIRECTORY']['actions'];

        // View
        $view_dir   = $module_dir.$this->_system_conf['DIRECTORY']['views'];

        if (realpath($module_dir).DIRECTORY_SEPARATOR !== $module_dir) {
            throw new EnviException('設定ファイルは絶対パスで指定する必要があります。', 10001);
        }

        // モジュール規定のconfig.phpファイルを読み込む
        if (is_file($module_dir.'config.php')) {
            include_once($module_dir.'config.php');
        }

        // アクションの存在確認
        $action_class_path = $action_dir.Request::getThisAction().'Action.class.php';
        $action_sf = ucwords(Request::getThisAction());

        if (is_file($action_class_path)) {
            if (dirname($action_class_path) !== realpath($action_dir)) {
                throw new EnviException('Actionのパスが変です。', 10002);
            }
            include_once($action_class_path);
            $action = Request::getThisAction().'Action';
            $action = new $action;
            if (method_exists($action, "execute{$action_sf}")) {
                if (method_exists($action, "isPrivate{$action_sf}")) {
                    $isPrivate      = "isPrivate{$action_sf}";
                } else {
                    $isPrivate      = "isPrivate";
                }
                if (method_exists($action, "isSSL{$action_sf}")) {
                    $isSSL      = "isSSL{$action_sf}";
                } else {
                    $isSSL      = "isSSL";
                }
                if (method_exists($action, "isSecure{$action_sf}")) {
                    $isSecure      = "isSecure{$action_sf}";
                } else {
                    $isSecure      = "isSecure";
                }
                if (method_exists($action, "initialize{$action_sf}")) {
                    $initialize      = "initialize{$action_sf}";
                } else {
                    $initialize      = "initialize";
                }
                if (method_exists($action, "shutdown{$action_sf}")) {
                    $shutdown      = "shutdown{$action_sf}";
                } else {
                    $shutdown      = "shutdown";
                }

                $validate       = "validate{$action_sf}";
                $execute        = "execute{$action_sf}";
                $defaultAccess  = "defaultAccess{$action_sf}";
                $handleError    = "handleError{$action_sf}";
            } else {
                $isPrivate      = 'isPrivate';
                $isSSL          = 'isSSL';
                $isSecure       = 'isSecure';
                $initialize     = 'initialize';
                $validate       = 'validate';
                $execute        = 'execute';
                $defaultAccess  = 'defaultAccess';
                $handleError    = 'handleError';
                $shutdown       = 'shutdown';
            }
        } elseif (is_file($action_dir.'actions.class.php')) {
            $action_class_path = $action_dir.'actions.class.php';
            include_once($action_class_path);
            $action = Request::getThisModule().'Actions';
            $action         = new $action;
            if (method_exists($action, "execute{$action_sf}")) {
                $validate       = "validate{$action_sf}";
                $execute        = "execute{$action_sf}";
                $defaultAccess  = "defaultAccess{$action_sf}";
                $handleError    = "handleError{$action_sf}";

                if (method_exists($action, "isPrivate{$action_sf}")) {
                    $isPrivate      = "isPrivate{$action_sf}";
                } else {
                    $isPrivate      = "isPrivate";
                }
                if (method_exists($action, "isSSL{$action_sf}")) {
                    $isSSL      = "isSSL{$action_sf}";
                } else {
                    $isSSL      = "isSSL";
                }
                if (method_exists($action, "isSecure{$action_sf}")) {
                    $isSecure      = "isSecure{$action_sf}";
                } else {
                    $isSecure      = "isSecure";
                }
                if (method_exists($action, "initialize{$action_sf}")) {
                    $initialize      = "initialize{$action_sf}";
                } else {
                    $initialize      = "initialize";
                }
                if (method_exists($action, "shutdown{$action_sf}")) {
                    $shutdown      = "shutdown{$action_sf}";
                } else {
                    $shutdown      = "shutdown";
                }
            } else {
                throw new Envi404Exception("execute{$action_sf}がないです", 10003);
            }
        } else {
            throw new Envi404Exception('Actionがないです。', 10004);
        }

        // アクション開始
        if ($is_first ? $action->$isPrivate() : false) {
            // privateなアクションかどうか
            throw new Envi404Exception('this is private action', 20000);
        } elseif ($is_first ? $action->$isSSL() && !isset($_SERVER['HTTPS']) : false) {
            // sslなアクションかどうか
            throw new Envi404Exception('is not ssl', 20001);
        }
        if ($action->$isSecure() && Session::isLogin() === false) {
            // セキュアなページかどうか
            throw new Envi403Exception('please login if you show this action.', 20000);
        }

        // イニシャライズ
        $res = $action->$initialize();
        if ($res === false) {
            return false;
        }

        // バリデートする
        if (method_exists($action, $validate)) {
            $res = $action->$validate();
        }


        if ($res === self::DEFAULT_ACCESS) {
            $res = $action->$defaultAccess();
        } elseif ($res === self::ERROR || $res === false) {
            $res = $action->$handleError();
        } else {
            $res = $action->$execute();
        }

        if (!$action->$shutdown()) {
            return true;
        }
        if ($res === self::NONE || !$res) {
            return true;
        }

        $view_class_path = $view_dir.Request::getThisAction()."View_{$res}.class.php";

        if (is_file($view_class_path)) {
            if (dirname($view_class_path) !== realpath($view_dir)) {
                throw new EnviException('Viewのパスが変です。', 11002);
            }
            include_once($view_class_path);
            $view = Request::getThisView().'View';
            $view = new $view;
            if (method_exists($view, "execute{$action_sf}")) {
                $initialize     = "initialize{$action_sf}";
                $execute       = "execute{$action_sf}";
                $setRenderer    = "setRenderer{$action_sf}";

            } else {
                $initialize     = 'initialize';
                $execute        = 'execute';
                $setRenderer    = 'setRenderer';
            }

        } elseif (is_file($view_dir.'views.class.php')) {
            $view_class_path = $view_dir.'views.class.php';
            include_once($view_class_path);
            $view = Request::getThisModule().'Views';
            $view         = new $view;
            if (method_exists($view, "execute{$action_sf}")) {
                $initialize     = "initialize{$action_sf}";
                $execute       = "execute{$action_sf}";
                $setRenderer    = "setRenderer{$action_sf}";
            } else {
                throw new EnviException("execute{$action_sf}がないです", 11003);
            }
        } else {
            throw new EnviException('Viewがないです。', 11004);
        }

        // View
        $view->$setRenderer();
        $view->renderer->_system_conf =& $this->_system_conf;
        $view->renderer->setting($module_dir);

        // イニシャライズ
        $res = $view->$initialize();
        if ($res === false) {
            return false;
        }
        $res = $view->$execute();
    }

    /**
     * +-- オートロードする
     *
     * @access public
     * @params string $class_name
     * @return void
     */
    public function autoload($class_name)
    {
        $class_name2  = $class_name . '.php';
        $class_name  = $class_name . '.class.php';
        foreach ($this->autoload_dirs as $v) {
            if (is_file($v.$class_name)) {
                include $v.$class_name;
                return;
            }
            if (is_file($v.$class_name2)) {
                include $v.$class_name2;
                return;
            }
        }
    }

    /**
     * +-- マジックメソッド
     *
     * @access public
     * @return void
     */
    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
    /* ----------------------------------------- */

    /**
     * +-- マジックメソッド
     *
     * @access public
     * @params
     * @return void
     */
    public function __wakeup()
    {
        trigger_error('Unserializing is not allowed.', E_USER_ERROR);
    }
    /* ----------------------------------------- */

}


function __autoload($class_name) {
    Envi()->autoload($class_name);
}
