<?php
/**
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
/**
 * @package Envi3
 * @subpackage EnviMVCVendorExtension
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

abstract class OrMapBase
{
    protected $_from_hydrate, $to_save;
    protected $_is_modify = false;
    protected $table_name,$pkeys;

    protected $default_instance_name = 'default_master';

    public function hydrate($arr)
    {
        $this->_from_hydrate = $arr;
        $this->to_save       = $arr;
    }

    public function toArray()
    {
        return $this->to_save;
    }

    public function save($con = NULL)
    {
        $table_name = $this->table_name;
        $pkeys      = $this->pkeys;
        $dbi = $con ? $con : extension()->DBI()->getInstance($this->default_instance_name);

        if (!isset($this->_from_hydrate[$pkeys[0]])) {
            $dbi->autoExecute($table_name, $this->to_save, DB::AUTOQUERY_INSERT);
            if (!isset($this->to_save[$pkeys[0]])) {
                $this->to_save[$pkeys[0]] = $dbi->lastInsertId();
            }
            $this->_from_hydrate = $this->to_save;
            $this->_is_modify = false;
            return true;
        }
        if (!$this->_is_modify) {
            return;
        }

        $and = '';
        $sql = '';
        foreach ($pkeys as $v) {
            $sql .= " {$and} {$v}=".$dbi->quoteSmart($this->_from_hydrate[$v]);
            $and = ' AND ';
        }
        $dbi->autoExecute($table_name, $this->to_save, DB::AUTOQUERY_UPDATE, $sql);
        $this->_from_hydrate = $this->to_save;
        $this->_is_modify = false;
    }

    public function __set($name, $value)
    {
        $this->_is_modify = true;
        $this->to_save[$name] = $value;
    }

    public function __get($name)
    {
        return isset($this->to_save[$name]) ? $this->to_save[$name] : NULL;
    }

    public function __call ($name , $arguments)
    {
        if (strPos($name, 'get') === 0) {
            $name = strtolower(substr(mb_ereg_replace('([A-Z])', '_\1', $name), 4));
            return isset($this->to_save[$name]) ? $this->to_save[$name] : NULL;
        } elseif (strPos($name, 'set') === 0) {
            $name = strtolower(substr(mb_ereg_replace('([A-Z])', '_\1', $name), 4));
            $this->to_save[$name] = $arguments[0];
            $this->_is_modify = true;
            return;
        }
        trigger_error('undefined method:'.$name);
    }

}