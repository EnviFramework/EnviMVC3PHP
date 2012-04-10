<?php
/**
 * @package Envi3
 * @subpackage EnviMVCRenderer
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */



/**
 * ファイルベースのTwigレンダラー
 *
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVCRenderer
 */

$ds = DIRECTORY_SEPARATOR;
require ENVI_BASE_DIR."..{$ds}Twig{$ds}Autoloader.php";

class EnviTwigRenderer
{
    public $_system_conf;
    public $_compile_id;
    private $loader;
    private $twig;
    private $compile_dir;
    private $etc_dir;
    private $config_dir;
    private $template_dir;
    private $_attributer;

    public function __construct()
    {
        Twig_Autoloader::register();
        $this->setting(Request::getThisModule());
    }


    public function setting($module_dir)
    {
        $this->compile_dir  = $this->_system_conf['DIRECTORY']['templatec'];
        $this->etc_dir      = $this->_system_conf['DIRECTORY']['templateetc'];
        $this->config_dir   = $this->_system_conf['DIRECTORY']['config'];
        $this->template_dir = $module_dir.$this->_system_conf['DIRECTORY']['template'];

        $this->loader = new Twig_Loader_Filesystem($this->template_dir);
        $this->twig   = new Twig_Environment($this->loader, array(
          'cache' => $this->compile_dir,
        ));
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
        $this->_attributer[$name] = $value;
    }

    public function display($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        echo $this->twig->render($file_name, $this->_attributer);
    }

    public function displayRef($file_name, $cache_id  = NULL, $dummy2 = NULL)
    {
        return $this->twig->render($file_name, $this->_attributer);
    }
}
