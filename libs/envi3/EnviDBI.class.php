<?php
/**
 * 下位互換ようのDBIクラス
 *
 * extensionからの利用をおすすめします。
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
 * @since      Class available since Release 1.0.0
 * @deprecated File deprecated in Release 1.0.0
 */

/**
 * 下位互換ようのDBIクラス
 *
 * extensionからの利用をおすすめします。
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
 * @deprecated Class deprecated in Release 1.0.0
 */
class EnviDBI
{
    /**
     * +-- コネクションの取得
     *
     * @access public
     * @static
     * @param string $db_key データーベースキー
     * @return void
     */
    public static function getConnection($db_key)
    {
        return extension()->DBConnection()->getInstance($db_key);
    }
    /* ----------------------------------------- */
}
