<?php
/**
 * Mathクラス
 *
 * ActionControllerから、全て静的にコールされます。
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
 * Mathクラス
 *
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
class EnviMath
{
    /**
     * +-- 端数の切り上げ
     *
     * 端数の切り上げ
     *
     * @access public
     * @static
     * @param float $value
     * @return float
     */
    public static function ceil($value)
    {
        $value = ((string)$value);
        return ceil($value);
    }
    /* ----------------------------------------- */

    /**
     * +-- 端数の切り捨て
     *
     * @access public
     * @static
     * @param float $value
     * @return float
     */
    public static function floor($value)
    {
        $value = ((string)$value);
        return floor($value);
    }
    /* ----------------------------------------- */


    /**
     * +-- 浮動小数点数を丸める
     *
     * @access public
     * @static
     * @param  $value
     * @param  $precision OPTIONAL:0
     * @param  $mode OPTIONAL:PHP_ROUND_HALF_UP
     * @return float
     */
    public static function round($value, $precision = 0, $mode = PHP_ROUND_HALF_UP)
    {
        $value = ((string)$value);
        return round($value, $precision, $mode);
    }
    /* ----------------------------------------- */
}
