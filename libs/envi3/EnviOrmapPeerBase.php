<?php
/**
 * PropelPDO風のクラスを作成するベースクラス
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage DB
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release v3.4.0
 */


/**
 * PropelPDO風のクラスを作成するベースクラス
 *
 * @abstract
 * @category   EnviMVC拡張
 * @package    EnviPHPが用意するエクステンション
 * @subpackage DB
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release v3.4.0
 */
abstract class EnviOrMapPeerBase
{
    /**
     * クエリリスト
     *
     * @access      protected
     * @var         array
     */
    protected static $queries = array();



    /**
     * +-- $sqlの__TABLE__を正しいテーブル名に置き換えて、返す。
     *
     * @access public
     * @static
     * @param string $sql 置き換え元のSQL分
     * @param string $suffix テーブル名+_の後ろにつける文字列。NULLの場合は_も省略されテーブル名のみとなる。 OPTIONAL:NULL
     * @return string
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
            $sql = preg_replace("/\\:{$column}([^a-z0-9A-Z])/", substr($add_query_str, 1)."\\1", $sql);
        }
        return str_replace(array('__TABLE__'), array($table_name), $sql);
    }
    /* ----------------------------------------- */

}
