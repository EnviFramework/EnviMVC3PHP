<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// |                            Artisan Smarty                            |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright 2004-2005 ARTISAN PROJECT All rights reserved.             |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
/**
 * Artisan Smarty plugin
 * @package ArtisanSmarty
 * @subpackage plugins
 */


/**
 * Smarty default modifier plugin
 *
 * 0でも、Default値が優先されてしまう為、修正。
 * モード切替によって、空文字を省くことが出来るように修正。
 * Type:     modifier<br>
 * Name:     default<br>
 * Purpose:  designate default value for empty variables
 * @link http://smarty.php.net/manual/en/language.modifier.default.php
 *          default (Smarty online manual)
 * @param string
 * @param string
 * @return string
 */
function smarty_modifier_default($string, $default = '', $mode = "all")
{
    if (($mode == "all" && ($string === false || $string === NULL || $string === "")) || 
    ($mode == "none" && ($string === false || $string === NULL))
    ) {
        return $default;
    } else {
        return $string;
    }
}

/* vim: set expandtab: */

?>
