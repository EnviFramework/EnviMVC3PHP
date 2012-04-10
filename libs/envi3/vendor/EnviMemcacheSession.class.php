<?php
/**
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * Memcacheを使用したセッション
 *
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @since 0.1
 */
class EnviMemcacheSession
{

    public function newSession()
    {
        $session_id = hash('sha512', mt_rand().microtime());
        $str = '';
        $rand = mt_rand(15, 30);
        while ($rand--) {
            $str .= chr(mt_rand(1,126));
        }
        $session_id .= hash('sha512', $str);
        $session_id = substr($session_id, 0, 1).base64_encode(pack('h*', $session_id)).substr($session_id, -1, 1);
        $session_id = str_replace(array('+', '='), '', $session_id);
        session_id($session_id);
        return $session_id;
    }

    public function sessionStart()
    {
        $this->sess_base_save_path = $this->_system_conf['SESSION']['sess_base_save_path'];
        $session_name = $this->_system_conf['SESSION']['cookie_name'];
        session_name($session_name);
        ini_set('session.gc_maxlifetime', $this->_system_conf['SESSION']['gc_lifetime']);
        ini_set('session.cookie_lifetime', $this->_system_conf['SESSION']['cookie_lifetime']);
        session_set_save_handler (
            array($this, 'open'),
            array($this,'close'),
            array($this,'read'),
            array($this,'write'),
            array($this,'destroy'),
            array($this,'gc')
        );
        $is_new_session = true;
        //セッションIDの正誤性をチェックする。
        if (isset($_COOKIE[$session_name])) {
            $key  = $_COOKIE[$session_name];
            if (EnviMemcache::has($key, false, '_session')) {
                $is_new_session = false;
            }
        }

        if ($is_new_session) {
            $key = $this->newSession();
            $dir = substr($id, 0, 1);
        }
        //セッション開始
        session_start();
    }

    public function open($save_path, $session_name)
    {
        return true;
    }

    public function close()
    {
        return(true);
    }

    public function read($key)
    {
        return unserialize(EnviMemcache::get($key, false, 'session'));
    }

    public function write($key, $value)
    {
        EnviMemcache::set($key, serialize($value), false, session_cache_expire(), 'session');
    }

    public function destroy($key)
    {
        return EnviMemcache::delete($key, 'session');
    }


    public function gc($maxlifetime)
    {
        return true;
    }


    public static function setAttribute($key, $value, $expire = 3600)
    {
        $key = self::generateKey($key);
        return EnviMemcache::set($key, serialize($value), false, $expire, 'session');
    }

    public static function getAttribute($key){
        $key = self::generateKey($key);
        return unserialize(EnviMemcache::get($key, false, 'session'));
    }

    public static function hasAttribute($key){
        $key = self::generateKey($key);
        return EnviMemcache::has($key, false, 'session');
    }

    public function login()
    {
        $_SESSION[self::$_is_login] = true;
    }
    public function logout()
    {
        $_SESSION[self::$_is_login] = false;
    }
    public function isLogin()
    {
        return isset($_SESSION[self::$_is_login]) ? $_SESSION[self::$_is_login] : false;
    }

    public static function removeAttribute($key){
        $key = self::generateKey($key);
        return EnviMemcache::delete($key, 'session');
    }

    public function cleanAttributes()
    {
    }

    public static function generateKey($key)
    {
        static $key_gen;
        if (!isset($key_gen)) {
            $key_gen = session_id();
        }
        return $key_gen.'-'.$key;
    }

}