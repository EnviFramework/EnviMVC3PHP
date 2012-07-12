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
 * ArtisanSmarty plugin
 * @package ArtisanSmarty
 * @subpackage plugins
 */


/**
 * Smarty truncate modifier plugin
 *
 * Type:     modifier<br>
 * Name:     mb_convert_kana<br>
 * Purpose:  PHP関数mb_convert_kanaをかけます。
 *           
 *           
 * @param $string string
 * @param $format string
 * @return string
 */
function smarty_modifier_mb_convert_kana($string, $format="asKV")
{
        return mb_convert_kana($string, $format);
}

/* vim: set expandtab: */

?>