<?php
/**
 * DB処理
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
 * pearDB風のインスタンスを提供するためのラッパー
 *
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
class DB
{
    const AUTOQUERY_INSERT = 1;
    const AUTOQUERY_UPDATE = 2;
    const AUTOQUERY_REPLACE = 3;

    private static $connections = array();


    /**
     * +-- Enviから呼ばれるメソッド。必ず作る
     *
     * @access public
     * @static
     * @param  $param
     * @param  $instance_name
     * @return EnviDBIBase
     */
    public static function getConnection($param, $instance_name)
    {
        if (isset(self::$connections[$instance_name])) {
            return self::$connections[$instance_name];
        }
        if (is_array($param['dsn'])) {
            shuffle($param['dsn']);
            foreach ($param['dsn'] as $dsn) {
                $dbi = self::getNewConnection($dsn, $param);
                if ($dbi !== false) {
                    break;
                }
            }
        } else {
            $dbi = self::getNewConnection($param['dsn'], $param);
        }

        if ($param['instance_pool']) {
            self::$connections[$instance_name] = $dbi;
        }
        return $dbi;
    }
    /* ----------------------------------------- */


    private static function getNewConnection($dsn, array $param)
    {
        parse_str($dsn, $conf);
        try{
            $dbi = self::connect($conf, '', '', $param['connection_pool']);
            if ($param['initialize_query']) {
                $dbi->query($param['initialize_query']);
            }
            return $dbi;
        } catch (exception $e) {
            return false;
        }
    }

    /**
     * +-- EnviDBIBaseを取得する
     *
     * @access public
     * @static
     * @param  $dsn
     * @param  $user OPTIONAL:false
     * @param  $password OPTIONAL:false
     * @return EnviDBIBase
     */
    public static function connect($dsn, $user = false, $password = false, $is_pool = false)
    {
        if ($is_pool) {
            if ($user === false) {
                return new EnviDBIBase($dsn, '', '',  array(PDO::ATTR_PERSISTENT => true));
            } else {
                return new EnviDBIBase($dsn, $user, $password, array(PDO::ATTR_PERSISTENT => true));
            }
        } else {
            if ($user === false) {
                return new EnviDBIBase($dsn, '', '');
            } else {
                return new EnviDBIBase($dsn, $user, $password);
            }
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- ダミー
     *
     * @static
     * @param & $obj
     * @return boolean
     */
    public static function isError(&$obj)
    {
        return false;
    }
    /* ----------------------------------------- */
}
