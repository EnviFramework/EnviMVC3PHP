<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * Memcache
 *
 * @package Envi
 * @sinse 0.1
 */

class EnviMemcache
{
    private static $connection;
    private static $prefix;
    private static $cache;

    /**
     * Connection取得
     *
     */
    public function getConnection($name = 'default')
    {
        if (isset(self::$connection[$name])) {
            return self::$connection[$name];
        }
        $system_conf = Envi::singleton()->getConfiguration('MEMCACHE');
        self::$connection[$name] = new Memcache;
        self::$connection[$name]->connect($system_conf["{$name}_host"], $system_conf["{$name}_port"]);
        self::$prefix[$name] = $system_conf["{$name}_prefix"];
        return self::$connection[$name];
    }

    /**
     *
     *
     * Memcache::set() は、キー key に var という値を 関連付け、memcached サーバに格納します。
     * パラメータ expire は、データの有効期限を秒単位で指定します。
     * もし 0 を指定した場合は その項目が期限切れになることはありません
     * (これは、その項目のデータが memcached サーバ上にずっと残り続けることを保証するものではありません。
     * 他の項目をキャッシュするための場所を確保するためにサーバから 削除されてしまうこともあります)。
     * (zlib を使用して) その場でのデータの圧縮を行いたい場合は、 flag の値として、定数 MEMCACHE_COMPRESSED を指定します。
     */
    public function set($key, $var, $flag = false, $expire = 3600, $name= 'default')
    {
        $con = self::getConnection($name);
        $key = self::$prefix[$name].$key;
        self::$cache[$name][$key] = $var;
        return $con->set($key, $var, $flag, $expire);
    }

    public function get($key, $flag = false,  $name= 'default')
    {
        $con = self::getConnection($name);
        $key = self::$prefix[$name].$key;

        if (!isset(self::$cache[$name][$key])) {
            self::$cache[$name][$key] = $con->get($key, $flag);
        }
        return self::$cache[$name][$key];
    }

    public function has($key, $flag = false,  $name= 'default')
    {
        $con = self::getConnection($name);
        $key = self::$prefix[$name].$key;
        if (isset(self::$cache[$name][$key]) && self::$cache[$name][$key] !== FALSE) {
            return true;
        }
        self::$cache[$name][$key] = $con->get($key, $flag);
        return self::$cache[$name][$key] !== FALSE;
    }

    public function delete($key, $name= 'default')
    {
        $con = self::getConnection($name);
        $key = self::$prefix[$name].$key;
        return $con->delete($key) !== FALSE;
    }
}