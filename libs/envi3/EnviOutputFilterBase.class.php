<?php
/**
 * OutFilter基底クラス
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
 * @version    GIT: $ Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */


/**
 * OutFilter基底クラス
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
abstract class EnviOutputFilterBase
{

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @param
     * @return void
     */
    public function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * +-- 一番初めに呼ばれる、メソッド
     *
     * falseを返すと、そこで処理が止まります。
     *
     * @access public
     * @return boolean
     */
    public function initialize()
    {
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- フィルタの実行
     *
     * @access public
     * @param staring &$contents
     * @return void
     */
    public function execute(&$contents)
    {
    }
    /* ----------------------------------------- */
}