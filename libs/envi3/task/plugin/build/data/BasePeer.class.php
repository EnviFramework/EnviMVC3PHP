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
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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
    public static function retrieveWithSuffix($query_key, array $bind_array, $suffix = NULL, EnviDBIBase $con = NULL)
    {
        if (!isset(%%class_name%%Peer::$queries[$query_key])) {
            throw new EnviException("{$query_key}は存在しません");
        }
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');
        $sql = self::getReplacedSQL(%%class_name%%Peer::$queries[$query_key], $suffix);
        
        
        $res = $dbi->getRow($sql, array($bind_array));
        if (!$res) {
            return false;
        }
        $ormap = new %%class_name%%;
        $ormap->hydrate($res);
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
    public static function retrieveAllWithSuffix($query_key, array $bind_array, $suffix = NULL, EnviDBIBase $con = NULL)
    {
        if (!isset(%%class_name%%Peer::$queries[$query_key])) {
            throw new EnviException("{$query_key}は存在しません");
        }
        $dbi = $con ? $con : extension()->DBI()->getInstance('%%instance_name%%');
        $sql = self::getReplacedSQL(%%class_name%%Peer::$queries[$query_key], $suffix);
        
        
        $res = $dbi->getAll($sql, array($bind_array));
        if (!$res) {
            return array();
        }
        foreach ($res as $key => $item) {
            $res[$key] = new %%class_name%%;
            $res[$key]->hydrate($item);
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
    public static function retrieveAll($query_key, array $bind_array, EnviDBIBase $con = NULL)
    {
        return self::retrieveAllWithSuffix($query_key, $bind_array, NULL, $con)
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
    public static function retrieve($query_key, array $bind_array, EnviDBIBase $con = NULL)
    {
        return self::retrieveWithSuffix($query_key, $bind_array, NULL, $con)
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
    final protected static function getReplacedSQL($sql, $suffix = NULL)
    {
        $table_name = self::$table_name;
        if ($suffix !== NULL) {
            $table_name .= "_{$suffix}";
        }
        return str_replace(array('__TABLE__'), array($table_name), $sql);
    }
    /* ----------------------------------------- */
}