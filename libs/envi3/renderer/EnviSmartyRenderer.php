<?php
/**
 * ArtisanSmartyレンダラー
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
 * @version    GIT: $Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

require 'ArtisanSmarty.class.php';

/**
 * ArtisanSmartyレンダラー
 *
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
class EnviSmartyRenderer extends Smarty
{
    public $_system_conf;
    public $_compile_id;

    public function __construct()
    {
        $this->_compile_id  = Request::getThisModule();
        $this->_system_conf = Envi()->getConfigurationAll();
        $this->setting(Request::getThisModule());
    }


    public function setting($module_dir)
    {
        $this->compile_dir  = $this->_system_conf['DIRECTORY']['templatec'];
        $this->etc_dir      = $this->_system_conf['DIRECTORY']['templateetc'];
        $this->config_dir   = $this->_system_conf['DIRECTORY']['config'];
        $this->template_dir = $this->_system_conf['DIRECTORY']['modules'].$module_dir.DIRECTORY_SEPARATOR.'templates';
        $this->assign('Envi', Envi::singleton());
        $this->assign('base_url', Envi::singleton()->getBaseUrl());
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

    public function display($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        parent::display($file_name, $cache_id, $this->_compile_id);
    }

    public function is_cached($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return parent::is_cached($file_name, $cache_id, $this->_compile_id);
    }

    public function clear_cache($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return parent::clear_cache($file_name, $cache_id, $this->_compile_id);
    }

    public function displayRef($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return parent::fetch($file_name, $cache_id, $this->_compile_id);
    }
}
