<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * リクエストを管理するクラス
 *
 * @access public
 * @sinse 0.1
 * @package Envi3
 * @subpackage EnviMVCCore
 */
class Request
{
    private static $_ext_path_info = array();
    private static $_attribute     = array();

    private static $_error_code    = array();
    private static $_error_message = array();


    private static $_i18n = '';
    private static $_request_module_name = '';
    private static $_request_action_name = '';
    public static $_module_name = '';
    public static $_action_name = '';

    const POST = 1;
    const GET  = 2;


    /**
     * +-- リクエストされたモジュール名を返す
     *
     * @access public
     * @static
     * @return string
     */
    public static function getRequestModule()
    {
        return self::$_request_module_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- リクエストされたアクション名を返す
     *
     * @access public
     * @static
     * @return string
     */
    public static function getRequestAction()
    {
        return self::$_request_action_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行中のモジュール名を返す
     *
     * @access public
     * @static
     * @return string
     */
    public static function getThisModule()
    {
        return self::$_module_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行中のアクション名を返す
     *
     * @access public
     * @static
     * @params
     * @return string
     */
    public static function getThisAction()
    {
        return self::$_action_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 現在の言語を返す
     *
     * @access public
     * @static
     * @params
     * @return string
     */
    public static function getIi8n()
    {
        return self::$_i18n;
    }
    /* ----------------------------------------- */

    /**
     * +-- 初期化
     *
     * ディスパッチャーが勝手にコールするので、基本呼ばない
     *
     * @access public
     * @static
     * @return void
     */
    public static function initialize()
    {
        $_system_conf = Envi::singleton()->getConfigurationAll();
        // デフォルト指定
        self::$_request_module_name = $_system_conf['SYSTEM']['default_module'];
        self::$_request_action_name = $_system_conf['SYSTEM']['default_action'];
        self::$_i18n = $_system_conf['SYSTEM']['default_i18n'];
        if (!isset($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] === '/') {
            self::$_module_name = self::$_request_module_name;
            self::$_action_name = self::$_request_action_name;
            return;
        }

        $exp_pathinfo = explode('/', $_SERVER['PATH_INFO']);

        // 先頭は空になるから削除
        array_shift($exp_pathinfo);

        // 国際化を使うときははじめのパスインフォがi18n
        if ($_system_conf['SYSTEM']['use_i18n']) {
            self::$_i18n = array_shift($exp_pathinfo);
            if (!isset($_system_conf['I18N'][self::$_i18n])) {
                throw Envi404Exception('404 Error', 20001);
            }
        }

        // モジュール名
        if (count($exp_pathinfo)) {
            self::$_request_module_name = array_shift($exp_pathinfo);
        }
        // アクション名
        if (count($exp_pathinfo)) {
            self::$_request_action_name = mb_ereg_replace("\\.".$_system_conf['SYSTEM']['ext'].'$', '', array_shift($exp_pathinfo));
        }

        self::$_ext_path_info = $exp_pathinfo;
        // 余剰のパスインフォは$_GET扱いに
        if (count($exp_pathinfo)) {
            while (count($exp_pathinfo)) {
                $k = array_shift($exp_pathinfo);
                $v = array_shift($exp_pathinfo);
                if (!$k) {
                    continue;
                }
                $_GET[$k] = $v;
            }
        }
        self::$_module_name = self::$_request_module_name;
        self::$_action_name = self::$_request_action_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- パースしたパスインフォで、フレームワークで使用されなかった分を取得する
     *
     * @access public
     * @return array
     */
    public function getPathInfo()
    {
        return self::$_ext_path_info;
    }
    /* ----------------------------------------- */


    /**
     * +-- データをAttributeします
     *
     * @param string $name Attribute名
     * @param mixd $data 値
     * @return void
     */
    public static function setAttribute($name, $data)
    {
        self::$_attribute[$name] = $data;
    }
    /* ----------------------------------------- */


    public static function setAttributeAll($data)
    {
        self::$_attribute = $data;
    }


    /**
     * Attributeしたデータを取り出します
     *
     * @param string $name Attribute名
     * @return mixd
     */
    public static function getAttribute($key)
    {
        if (is_array(self::$_attribute) ? !count(self::$_attribute) : true) {
            return null;
        }

        if (func_num_args() === 1) {
            return isset(self::$_attribute[$key]) ? self::$_attribute[$key] : null;
        }
        $fga = func_get_args();
        $data = self::$_attribute;
        foreach ($fga as $id => $node) {
            if (is_array($data) && isset($data[$node])) {
                $data = $data[$node];
                continue;
            }
            return null;
        }
        return $data;
    }
    /* ----------------------------------------- */

    /**
     * +-- Attributeした情報をすべて返す
     *
     * @access public
     * @static
     * @return array
     */
    public static function getAttributeAll()
    {
        return self::$_attribute;
    }
    /* ----------------------------------------- */

    /**
     * +-- Attributeされているか確認します
     *
     * @access public
     * @static
     * @param string $name Attribute名
     * @return boolean
     */
    public static function hasAttribute($name)
    {
        return isset(self::$_attribute[$name]);
    }
    /* ----------------------------------------- */

    /**
     * +-- Attributeされているデータを削除します
     *
     * @access public
     * @static
     * @param string $name Attribute名
     * @return void
     */
    public static function removeAttribute($name)
    {
        if (isset(self::$_attribute[$name])) {
            unset(self::$_attribute[$name]);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- Attributeされているデータを全削除します
     *
     * @access public
     * @static
     * @param string $name Attribute名
     * @return void
     */
    public static function cleanAttributes()
    {
        self::$_attribute = array();
    }
    /* ----------------------------------------- */

    /**
     * +-- $_GETもしくは、$_POSTから値を取得します。
     *
     * @access public
     * @static
     * @param string|array|int $name
     * @param mixed $default_parameter
     * @param int $post_only
     * @return mixed
     */
    public static function getParameter($name, $default_parameter = false, $post_only = 3)
    {
        if (($post_only === 3 || $post_only === 1) && isset($_POST[$name])) {
            return $_POST[$name] === '' ? $default_parameter : $_POST[$name];
        } elseif (($post_only === 3 || $post_only === 2) && isset($_GET[$name])) {
            return $_GET[$name] === '' ? $default_parameter : $_GET[$name];
        }
        return $default_parameter;
    }

    /**
     * +-- 存在する値かどうかを確認する
     *
     * @access public
     * @static
     * @param string|array|int $name
     * @param int $post_only
     * @return boolean
     */
    public static function hasParameter($name, $post_only = 3)
    {
        if ($post_only == 3) {
            return (isset($_POST[$name]) || isset($_GET[$name]));
        } elseif ($post_only == 1) {
            return isset($_POST[$name]);
        } else {
            return isset($_GET[$name]);
        }
    }
    /* ----------------------------------------- */



    /**
     * +-- エラーをセットする
     *
     * Validatorクラスから呼ばれるので、あまり使わないかも
     *
     * @access public
     * @static
     * @params エラー名 $name
     * @params 引っかかったValidator $validator
     * @params エラーコード $code
     * @params エラーメッセージ $message
     * @return void
     */
    public static function setError($name, $validator, $code, $message)
    {
        self::$_error_code[$name][$validator]    = $code;
        self::$_error_message[$name][$validator] = $message;
    }
    /* ----------------------------------------- */


    /**
     * +-- エラーを全て取得
     *
     * @access public
     * @static
     * @return array
     */
    public static function getErrors()
    {
        $i = 0;
        foreach (self::$_error_message as $key => $values) {
            foreach ($values as $id => $value) {
                $res['message'][$i] = $value;
                $res['keys'][$key][] = $i;
                $i++;
            }
        }
        $res['count'] = $i;
        return $res;
    }
    /* ----------------------------------------- */


    /**
     * +-- エラーを全てリファレンスで取得
     *
     * @access public
     * @static
     * @return array
     */
    public static function &getErrorsByRef()
    {
        return self::$_error_message;
    }
    /* ----------------------------------------- */

    /**
     * +-- エラーを指定して取得
     *
     * @access public
     * @static
     * @params string $name エラー名
     * @return array
     */
    public static function getError($name)
    {
        return isset(self::$_error_message[$name]) ? array('message' => self::$_error_message[$name], 'code' => self::$_error_code[$name]) : null;
    }
    /* ----------------------------------------- */

    /**
     * +-- エラーがあるかどうか
     *
     * @access public
     * @static
     * @return boolean
     */
    public static function hasErrors()
    {
        return count(self::$_error_message) > 0;
    }
    /* ----------------------------------------- */

    /**
     * +-- 指定したエラーがあるかどうか
     *
     * @access public
     * @static
     * @params string $name エラー名
     * @return boolean
     */
    public static function hasError($name)
    {
        return isset(self::$_error_message[$name]);
    }
    /* ----------------------------------------- */
}