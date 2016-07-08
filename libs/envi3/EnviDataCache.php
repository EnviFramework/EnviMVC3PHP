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

    /**
     * +--
     *
     * @access      public
     * @static
     * @param  var_text $pk
     * @param  var_text $class_name
     * @param  var_text $use_apc    OPTIONAL:false
     * @return void
     */
    public static function fetchByPk($pk, $class_name, $use_apc = false)
    {
        $key = self::getKey($pk, $class_name);
        if (isset(self::$local_cache[$key])) {
            return self::$local_cache[$key];
        }
        if ($use_apc) {
            $res                     = apc_fetch($key);
            self::$local_cache[$key] = $res;
            return self::$local_cache[$key];
        }
        return false;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @static
     * @param  var_text $pk
     * @param  var_text $class_name
     * @param  var_text $data
     * @param  var_text $use_apc    OPTIONAL:false
     * @return void
     */
    public static function storeByPk($pk, $class_name, $data, $use_apc = false)
    {
        $key                     = self::getKey($pk, $class_name);
        self::$local_cache[$key] = $data;
        if ($use_apc) {
            $ttl = 120;
            if ($data instanceof EnviOrMapBase) {
                $ttl = $data->cache_ttl ? $data->cache_ttl : 120;
            }
            $res = apc_store($key, $data, $ttl);
        }
        return false;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      protected
     * @static
     * @param  var_text $pk
     * @param  var_text $class_name
     * @return void
     */
    protected static function getKey($pk, $class_name)
    {
        return 'single_db_cache_'.$class_name.'-'.$pk;
    }
    /* ----------------------------------------- */
}
