<?php
/**
 * ビュー基底クラス
 *
 * ビューを書くときは必ずこのクラスを継承すること。
 *
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
 * ビュー基底クラス
 *
 * ビューを書くときは必ずこのクラスを継承すること。
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
abstract class EnviViewBase
{
    public $renderer;


    public function __construct()
    {
    }

    /**
     * @abstract
     */
    public function initialize()
    {
        return true;
    }

    /**
     * @abstract
     */
    public function execute()
    {
        return true;
    }


    /**
     * @abstract
     */
    public function setRenderer()
    {
        $renderer_path = Envi()->getConfiguration('SYSTEM', 'renderer');
        include_once $renderer_path;
        $renderer_class = substr(basename($renderer_path), 0, -4);
        $this->renderer = new $renderer_class();
    }

    /**
     * @abstract
     */
    public function shutdown()
    {
        return true;
    }
}
