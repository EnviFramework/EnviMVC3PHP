<?php
/**
 * Memcacheを使用したセッション
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

/**
 * Memcacheを使用したセッション
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
class EnviMemcacheSession
{

    private static  $_is_login = '_is_login';
    private static  $_is_gzip = true;
    private static  $_session_id = null;
    public function newSession()
    {
        $session_id = hash('sha512', mt_rand().microtime());
        $str = '';
        $rand = mt_rand(15, 30);
        while ($rand--) {
            $str .= chr(mt_rand(1,126));
        }
        $session_id .= hash('sha512', $str);
        $session_id = substr($session_id, 0, 1).substr(base64_encode(pack('h*', $session_id)), 0, 20).substr($session_id, -1, 1);
        $session_id = str_replace(array('+', '=', '/'), '', $session_id);
        session_id($session_id);
        return $session_id;
    }

    public function sessionStart()
    {
        $this->sess_base_save_path = $this->_system_conf['SESSION']['sess_base_save_path'];
        $session_name = $this->_system_conf['SESSION']['cookie_name'];
        session_name($session_name);

        $is_new_session = true;
        //セッションIDの正誤性をチェックする。
        if (isset($_COOKIE[$session_name])) {
            $key  = $_COOKIE[$session_name];
            if (EnviMemcache::has($key, 'session', self::$_is_gzip)) {
                $is_new_session = false;
            }
        }
        if ($is_new_session) {
            $i = 0;
            while ($i++ < 30) {
                $key = self::newSession();
                if (!EnviMemcache::has($key, 'session', self::$_is_gzip)) {
                    break;
                }
            }
            if ($i >= 30) {
                throw new EnviException('do not start session');
            }
        }
        //セッション開始
        self::$_session_id = $key;
        EnviMemcache::set($key, serialize(array()), $this->_system_conf['SESSION']['cookie_lifetime'], 'session', self::$_is_gzip);
        setcookie (session_name(), $key, time()+$this->_system_conf['SESSION']['cookie_lifetime']);
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
        return unserialize(EnviMemcache::get($key, 'session', self::$_is_gzip));
    }

    public function write($key, $value)
    {
        return EnviMemcache::set($key, serialize($value), $this->_system_conf['SESSION']['cookie_lifetime'], 'session', self::$_is_gzip);
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
        return EnviMemcache::set($key, serialize($value), $expire, 'session', self::$_is_gzip);
    }

    public static function getAttribute($key)
    {
        $key = self::generateKey($key);
        return unserialize(EnviMemcache::get($key, 'session', self::$_is_gzip));
    }

    public static function hasAttribute($key)
    {
        $key = self::generateKey($key);
        return EnviMemcache::has($key, 'session', self::$_is_gzip);
    }

    public function login()
    {
        $key = self::generateKey(self::$_is_login);
        return EnviMemcache::set($key, serialize(true), $this->_system_conf['SESSION']['cookie_lifetime'], 'session', self::$_is_gzip);
    }
    public function logout()
    {
        $key = self::generateKey(self::$_is_login);
        EnviMemcache::delete($key, 'session');
    }
    public function isLogin()
    {
        $key = self::generateKey(self::$_is_login);
        return EnviMemcache::get($key, 'session', self::$_is_gzip);
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
            $key_gen = self::$_session_id;
        }
        return $key_gen.'-'.$key;
    }

}