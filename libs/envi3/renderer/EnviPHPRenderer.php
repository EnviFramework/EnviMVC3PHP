<?php
/**
 * @package Envi3
 * @subpackage EnviMVCRenderer
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */



/**
 *
 *
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVCRenderer
 */
class EnviPHPRenderer
{
    private $_system_conf;

    public function __construct()
    {
        $this->_system_conf = Envi()->getConfigurationAll();
    }

    /**
     * templateに値を格納する
     *
     * @param string $key 格納する名前
     * @param mixed $value 値
     * @return void
     */
    public function setAttribute($name, $value)
    {
        $this->assign($name, $value);
    }

    public function assign($name, $value)
    {
    }

    public function display($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        //
        include $this->_system_conf['DIRECTORY']['modules'].$module_dir.DIRECTORY_SEPARATOR.$this->_system_conf['DIRECTORY']['templates'].$file_name;
    }

    public function is_cached($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        //
    }

    public function clear_cache($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        //
    }

    public function displayRef($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        //
    }

}
