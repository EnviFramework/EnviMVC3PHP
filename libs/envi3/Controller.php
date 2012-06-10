<?php
/**
 * ActionControllerから、Framework自体の振る舞いを変更する
 *
 * ActionControllerから、全て静的にコールされます。
 * ActionChainの仕組みを利用するなど、FW自体に振る舞いの変更を通知します。
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $ Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */


/**
 * ActionControllerから、Framework自体の振る舞いを変更する
 *
 * ActionControllerから、全て静的にコールされます。
 * ActionChainの仕組みを利用するなど、FW自体に振る舞いの変更を通知します。
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class Controller
{
    private static $_action_chain      = array();
    private static $_action_chain_data = array();
    private static $_system_conf;
    private static $_is_action_chain   = false;
    private static $_action_chain_name = NULL;

    /**
     * +-- アクションチェインの中かどうか
     *
     * @final
     * @access public
     * @static
     * @return boolean
     */
    final public static function isActionChain()
    {
        return self::$_is_action_chain;
    }
    /* ----------------------------------------- */

    /**
     * +-- 他のアクションに処理を明け渡す
     *
     * @final
     * @param string $action アクション名
     * @param string $module モジュール名 OPTIONAL:NULL
     * @return boolean
     */
    final public static function forward($action, $module = NULL)
    {
        $cpm = Request::$_module_name;
        $cpa = Request::$_action_name;
        if (!is_null($module)) {
            Request::$_module_name = $module;
        }

        //Action
        Request::$_action_name = $action;
        //実行
        Envi::singleton()->_run();
        //戻す
        Request::$_module_name = $cpm;
        Request::$_action_name = $cpa;
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- 他のURLにリダイレクトする
     *
     * 第二引数の、$dieは、trueで中断、falseで続行します。
     * defaultはtrueとなります。
     *
     * @final
     * @access public
     * @static
     * @param string $url リダイレクトするURL
     * @param boolean $die リダイレクトヘッダ出力後の処理を中断するかどうか。 OPTIONAL:true
     * @return void
     */
    final public static function redirect($url, $die = true)
    {
        header('location:'.$url);
        ob_clean();
        ob_start();
        if ($die) {
            ob_clean();
            throw new redirectException($url);
        }
        ob_clean();
    }
    /* ----------------------------------------- */

    /**
     * +-- 処理を中断します。
     *
     * Envi内では、exitやdieなどの関数で処理を中断することは推奨されません。
     * Envi::kill()と機能は一緒です。
     *
     * @final
     * @access public
     * @static
     * @param  $kill OPTIONAL:''
     * @param  $is_shutDown OPTIONAL:true
     * @return void
     */
    final public static function kill($kill = '', $is_shutDown = true)
    {
        Envi()->kill($kill, $is_shutDown);
    }
    /* ----------------------------------------- */

    /**
     * +-- アクションを連続して実行する準備をする
     *
     * @final
     * @access public
     * @static
     * @param string $name チェイン名
     * @param string $action アクション名
     * @param string $module モジュール名 OPTIONAL:NULL
     * @param string $data チェイン先に渡すデータ OPTIONAL:NULL
     * @return void
     */
    final public static function setActionChain($name, $action, $module = NULL, $data = NULL)
    {
        self::$_action_chain[$name]      = array($action, $module);
        self::$_action_chain_data[$name] = $data;
    }
    /* ----------------------------------------- */

    /**
     * +-- アクションチェインしたアクションを実行リストから削除する
     *
     * @final
     * @access public
     * @static
     * @param string $name チェイン名
     * @return void
     */
    final public static function unsetActionChain($name)
    {
        unset(self::$_action_chain[$name]);
        unset(self::$_action_chain_data[$name]);
    }
    /* ----------------------------------------- */

    /**
     * +-- アクションを連続して実行して、出力を受け取る
     *
     * @final
     * @access public
     * @static
     * @see setActionChain()
     * @return array
     */
    final public static function go()
    {
        self::$_is_action_chain = true;
        $_attribute     = Request::getAttributeAll();
        $_error_message = Request::getErrorsByRef();
        $_error_code    = Request::getErrorCodesByRef();
        $post_data = $_POST;
        foreach (self::$_action_chain as $key => $value) {
            self::$_action_chain_name = $key;
            if (!is_null(self::$_action_chain_data[$key])) {
                $_POST = array_merge($_POST, self::$_action_chain_data[$key]);
            }
            ob_start();
            self::forward($value[0], $value[1]);
            $res[$key] = ob_get_contents();
            ob_clean();
            Request::setAttributeAll($_attribute);
            Request::setErrorsAll($_error_message);
            Request::setErrorCodesAll($_error_code);
            $_POST = $post_data;
        }

        self::$_action_chain      = array();
        self::$_action_chain_data = array();
        self::$_is_action_chain   = false;
        self::$_action_chain_name = NULL;
        return $res;
    }
    /* ----------------------------------------- */

    /**
     * +-- アクションチェイン中、その実行プロセス名を返す
     *
     * @final
     * @access public
     * @static
     * @return string
     */
    final public static function getActionChainName()
    {
        return self::$_action_chain_name;
    }
    /* ----------------------------------------- */
}
