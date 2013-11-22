<?php
/**
 * ユーザークラス
 *
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
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

/**
 * ユーザークラス
 *
 * Sessionを利用した、ユーザー固有のデータ管理を行います。
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      Class available since Release 1.0.0
 */
class EnviUser
{

    private static $_system_conf;
    private static  $_envi_system_value = '__ENVI_USER__';
    private static  $_attribute = array();
    private static  $_is_login = '_is_login';
    public static $session;


    private static $_is_session_start = false;


    /**
     * +-- セッションを開始する
     *
     * 通常は明示的に実行する必要はありません。
     *
     * @return void
     */
    public static function sessionStart()
    {
        $session_manager = Envi::singleton()->getConfiguration('SESSION', 'session_manager');
        self::$session = new $session_manager;
        self::$session->_system_conf = Envi::singleton()->getConfigurationAll();
        self::$session->sessionStart();
        self::$_is_session_start = true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ログイン状態にする
     *
     * @return void
     */
    public static function login()
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        self::$session->login();
    }
    /* ----------------------------------------- */

    /**
     * +-- ログアウト状態にする
     *
     * @return void
     */
    public static function logout()
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        self::$session->logout();
    }
    /* ----------------------------------------- */

    /**
     * +-- ログイン状態かどうかを確認する
     *
     * @return boolean
     */
    public static function isLogin()
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }

        return self::$session->isLogin();
    }
    /* ----------------------------------------- */

    /**
     * +-- ユーザーAttributeにデータを格納する
     *
     * @param string $name Attribute名
     * @param mixed $value 値
     * @return void
     */
    public static function setAttribute($name, $value)
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        $arr = func_get_args();
        return call_user_func_array(array(self::$session, 'setAttribute'), $arr);
    }
    /* ----------------------------------------- */

    /**
     * +-- ユーザーAttributeにデータがあるか確認する
     *
     * @param string $name Attribute名
     * @return void
     */
    public static function hasAttribute($name)
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        $arr = func_get_args();
        return call_user_func_array(array(self::$session, 'hasAttribute'), $arr);
    }
    /* ----------------------------------------- */

    /**
     * +-- ユーザーAttributeのデータを削除する
     *
     * @param string $name Attribute名
     * @return void
     */
    public static function removeAttribute($name)
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        $arr = func_get_args();
        return call_user_func_array(array(self::$session, 'removeAttribute'), $arr);
    }
    /* ----------------------------------------- */

    /**
     * +-- ユーザーAttributeのデータを全て削除する
     *
     * @return void
     */
    public static function cleanAttributes()
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        self::$session->cleanAttributes();
    }
    /* ----------------------------------------- */

    /**
     * +-- ユーザーAttributeに格納されている値を取得する
     *
     * @param string $name Attribute名
     * @return mixd
     */
    public static function getAttribute($name)
    {
        if (!self::$_is_session_start) {
            self::sessionStart();
        }
        $arr = func_get_args();
        return call_user_func_array(array(self::$session, 'getAttribute'), $arr);
    }
    /* ----------------------------------------- */
}
