<?php
/**
 * PropelPDO風のオブジェクトを作成するベースクラス
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
 * PropelPDO風のオブジェクトを作成するベースクラス
 *
 * @abstract
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
class Base%%class_name%%Peer
{
    /**
     * テーブル名
     *
     * @access      protected
     * @var         string
     */
    protected static $table_name = '%%table_name%%';

    /**
     * クエリリスト
     *
     * @access      protected
     * @var         array
     */
    protected static $queries = array();


    /**
     * +-- Suffix対応でクエリを実行する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       string $suffix OPTIONAL:NULL
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      %%class_name%%|boolean
     */
    public static function queryWithSuffix($query_key, array $bind_array = array(), $suffix = NULL, EnviDBIBase $con = NULL)
    {
        if (!isset(%%class_name%%Peer::$queries[$query_key])) {
            throw new EnviException("{$query_key}は存在しません");
        }
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');
        $sql = self::getReplacedSQL(%%class_name%%Peer::$queries[$query_key], $bind_array, $suffix);


        return $dbi->query($sql, $bind_array);
    }
    /* ----------------------------------------- */


    /**
     * +-- Suffix対応で一行抽出する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       string $suffix OPTIONAL:NULL
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      %%class_name%%|boolean
     */
    public static function retrieveWithSuffix($query_key, array $bind_array = array(), $suffix = NULL, EnviDBIBase $con = NULL)
    {
        if (!isset(%%class_name%%Peer::$queries[$query_key])) {
            throw new EnviException("{$query_key}は存在しません");
        }
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');
        $sql = self::getReplacedSQL(%%class_name%%Peer::$queries[$query_key], $bind_array, $suffix);


        $res = $dbi->getRow($sql, $bind_array);
        if (!$res) {
            return false;
        }
        $ormap = new %%class_name%%;
        $ormap->hydrate($res);
        if ($suffix !== NULL) {
            $ormap->setSuffix($suffix);
        }
        return $ormap;
    }
    /* ----------------------------------------- */


    /**
     * +-- Suffix対応で複数行抽出する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       string $suffix OPTIONAL:NULL
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      array
     */
    public static function retrieveAllWithSuffix($query_key, array $bind_array = array(), $suffix = NULL, EnviDBIBase $con = NULL)
    {
        if (!isset(%%class_name%%Peer::$queries[$query_key])) {
            throw new EnviException("{$query_key}は存在しません");
        }
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');
        $sql = self::getReplacedSQL(%%class_name%%Peer::$queries[$query_key], $bind_array, $suffix);


        $res = $dbi->getAll($sql, $bind_array);
        if (!$res) {
            return array();
        }
        foreach ($res as $key => $item) {
            $res[$key] = new %%class_name%%;
            $res[$key]->hydrate($item);
            if ($suffix !== NULL) {
                $res[$key]->setSuffix($suffix);
            }
        }
        return $res;
    }
    /* ----------------------------------------- */

    /**
     * +-- 複数行抽出する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      array
     */
    public static function retrieveAll($query_key, array $bind_array = array(), EnviDBIBase $con = NULL)
    {
        return self::retrieveAllWithSuffix($query_key, $bind_array, NULL, $con);
    }
    /* ----------------------------------------- */

    /**
     * +-- 一行抽出する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      %%class_name%%|boolean
     */
    public static function retrieve($query_key, array $bind_array = array(), EnviDBIBase $con = NULL)
    {
        return self::retrieveWithSuffix($query_key, $bind_array, NULL, $con);
    }
    /* ----------------------------------------- */

    /**
     * +-- SQLを実行する
     *
     * @access      public
     * @static
     * @param       string $query_key
     * @param       array $bind_array
     * @param       EnviDBIBase $con OPTIONAL:NULL
     * @return      %%class_name%%|boolean
     */
    public static function query($query_key, array $bind_array = array(), EnviDBIBase $con = NULL)
    {
        return self::queryWithSuffix($query_key, $bind_array, NULL, $con);
    }
    /* ----------------------------------------- */


    /**
     * +-- PKで抽出
     *
     * @access public
     * @static
     * @param %%args%%
     * @param EnviDBIBase $con OPTIONAL:NULL
     * @return void
     */
    public static function retrieveByPK(%%args%%, EnviDBIBase $con = NULL)
    {
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');

        $res = $dbi->getRow('%%sql%%', array(%%args%%));
        if (!$res) {
            return false;
        }
        $ormap = new %%class_name%%;
        $ormap->hydrate($res);
        return $ormap;
    }
    /* ----------------------------------------- */

    /**
     * +-- $sqlの__TABLE__を正しいテーブル名に置き換えて、返す。
     *
     * @access public
     * @static
     * @param string $sql 置き換え元のSQL分
     * @param string $suffix テーブル名+_の後ろにつける文字列。NULLの場合は_も省略されテーブル名のみとなる。 OPTIONAL:NULL
     * @return void
     */
    final protected static function getReplacedSQL($sql, &$bind_array, $suffix = NULL)
    {
        $table_name = self::$table_name;
        if ($suffix !== NULL) {
            $table_name .= "_{$suffix}";
        }
        foreach ($bind_array as $column => $value) {
            if (!is_array($value)) {
                continue;
            }
            unset($bind_array[$column]);
            $add_query_str = '';
            foreach ($value as $key => $item) {
                $add_query_str .= ",:{$column}_mul_{$key}";
                $bind_array["{$column}_mul_{$key}"] = $item;
            }
            $sql = mb_ereg_replace(":{$column}([^a-z0-9A=Z])", substr($add_query_str, 1)."\\1", $sql);
        }
        return str_replace(array('__TABLE__'), array($table_name), $sql);
    }
    /* ----------------------------------------- */
}