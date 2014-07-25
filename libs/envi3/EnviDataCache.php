<?php
/**
 * 内部キャッシュ
 *
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage DB
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
*/

/**
 * 内部キャッシュ
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage DB
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
class EnviDataCache
{
    private static $local_cache = array();


    public static function fetchByPk($pk, $class_name, $use_apc = false)
    {
        $key = self::getKey($pk, $class_name);
        if (isset(self::$local_cache[$key])) {
            return self::$local_cache[$key];
        }
        if ($use_apc) {
            $res = apc_fetch($key);
            if ($res) {
                $main_class_name = substr($class_name, -4);
                $main_class = new $main_class_name;
                $main_class->hydrate($res);
                return $main_class;
            }
        }
        return false;
    }

    public static function storeByPk($pk, $class_name, $data, $use_apc = false)
    {
        $key = self::getKey($pk, $class_name);
        self::$local_cache[$key] = $data;
        if ($use_apc) {
            $res = apc_store($key, $data, 120);
        }
        return false;
    }

    private static function getKey($pk, $class_name)
    {
        return 'single_db_cache_'.$class_name.'-'.$pk;
    }

}
