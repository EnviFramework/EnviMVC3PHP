<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * ファイルを使用したSESSION
 *
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviSecureSession
{
    public $sess_dir_array = array(
        '0' => '0/',
        '1' => '1/',
        '2' => '2/',
        '3' => '3/',
        '4' => '4/',
        '5' => '5/',
        '6' => '6/',
        '7' => '7/',
        '8' => '8/',
        '9' => '9/',
        'a' => 'a/',
        'b' => 'b/',
        'c' => 'c/',
        'd' => 'd/',
        'e' => 'e/',
        'f' => 'f/',
    );
    private static  $_envi_system_value = "__ENVI_USER__";
    private static  $_attribute = array();
    private static  $_is_login = '_is_login';

    public $_system_conf;
    public $sess_base_save_path;

    public function open($save_path, $session_name)
    {
        return true;
    }

    public function close()
    {
        return(true);
    }

    public function read($id)
    {
        $dir = substr($id, 0, 1);
        $sess_file = session_save_path().DIRECTORY_SEPARATOR.'.sess_'.$id;
        if (is_file($sess_file)) {
            touch($sess_file);
            return file_get_contents($sess_file);
        }
        return '';
    }

    public function write($id, $sess_data)
    {
        $sess_file = session_save_path().DIRECTORY_SEPARATOR.'.sess_'.$id;

        if ($fp = @fopen($sess_file, 'w')) {
            fwrite($fp, $sess_data);
            return fclose($fp);
        }
        return false;
    }

    public function destroy($id)
    {
        $dir = substr(sha1(substr($id, 0, 10)), 0, 1);
        $sess_file = session_save_path().DIRECTORY_SEPARATOR.'.sess_'.$id;
        setcookie (session_name(), $id, time() - 3600);
        return @unlink($sess_file);
    }


    public function gc($maxlifetime)
    {
        $a = array_rand($this->sess_dir_array);
        if ($dh = @opendir($this->sess_base_save_path.$a)) {
            while ($file = @readdir($dh)) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                if (is_file($this->sess_base_save_path.$a.DIRECTORY_SEPARATOR.$file)) {
                    $lifetime = time()-filemtime($this->sess_base_save_path.$a.DIRECTORY_SEPARATOR.$file);
                    if ($lifetime > $maxlifetime) {
                        if (!@unlink($this->sess_base_save_path.$a.DIRECTORY_SEPARATOR.$file)) {
                            return false;
                        }
                    }
                }
            }
            closedir($dh);
            return true;
        }
        return false;
    }

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
            $id  = $_COOKIE[$session_name];
            $dir = substr($id, 0, 1);
            if (isset($this->sess_dir_array[$dir])) {
                $sess_file = $this->sess_base_save_path.$this->sess_dir_array[$dir].'.sess_'.$id;
                if(is_file($sess_file)){
                    $is_new_session = false;
                }
            }
        }

        if ($is_new_session) {
            $id = $this->newSession();
            $dir = substr($id, 0, 1);
        }
        ini_set('session.save_path', $this->sess_base_save_path.$this->sess_dir_array[$dir]);
        //セッション開始
        session_start();
    }

    public function getAttribute($key)
    {
        $key = $key[0];
        return isset($_SESSION[self::$_envi_system_value][$key]) ? $_SESSION[self::$_envi_system_value][$key] : NULL;
    }
    public function hasAttribute($key)
    {
        $key = $key[0];
        return isset($_SESSION[self::$_envi_system_value][$key]);
    }
    public function setAttribute($key, $value)
    {
        $_SESSION[self::$_envi_system_value][$key] = $value;
    }

    public function removeAttribute($key)
    {
        unset($_SESSION[self::$_envi_system_value][$key]);
    }

    public function cleanAttributes()
    {
        $_SESSION[self::$_envi_system_value] = array();
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

}