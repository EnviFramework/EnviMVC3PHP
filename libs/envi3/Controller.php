<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 *
 *
 * @access public
 * @sinse 0.1
 * @package Envi3
 * @subpackage EnviMVC
 */
class Controller
{
    private static $_action_chain = array();
    private static $_system_conf;
    private static $_is_action_chain = false;

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
     * 他のアクションに処理を明渡す
     * @final
     * @param string $action アクション名
     * @param string $module モジュール名
     */
    final public static function forward($action, $module = null)
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

    /**
     * 他のURLにリダイレクトする
     *
     * @param string $url リダイレクトするURL
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

    /**
     * +-- 処理を中断します。
     *
     * Envi内では、exitやdieなどの関数で処理を中断することは推奨されません。
     *
     * @final
     * @access public
     * @static
     * @params  $kill OPTIONAL:''
     * @params  $is_shutDown OPTIONAL:true
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
     * @params string $name チェイン名
     * @params string $action アクション名
     * @params string $module モジュール名 OPTIONAL:null
     * @return void
     */
    final public static function setActionChain($name, $action, $module = null)
    {
        self::$_action_chain[$name] = array($action, $module);
    }
    /* ----------------------------------------- */

    /**
     * アクションチェインしたアクションを実行リストから削除する
     *
     * @final
     * @param string $name チェイン名
     */
    final public static function unsetActionChain($name)
    {
        unset(self::$_action_chain[$name]);
    }

    /**
     * アクションを連続して実行して、出力を受け取る
     *
     * @final
     * @see setActionChain()
     * @return array
     */
    final public static function go()
    {
        self::$_is_action_chain = true;
        $_attribute = Request::getAttributeAll();
        foreach (self::$_action_chain as $key => $value) {
            ob_start();
            self::forward($value[0], $value[1]);

            Request::setAttributeAll($_attribute);
            $res[$key] = ob_get_contents();
            ob_clean();
        }
        self::$_action_chain = array();
        self::$_is_action_chain = false;
        return $res;
    }
}
