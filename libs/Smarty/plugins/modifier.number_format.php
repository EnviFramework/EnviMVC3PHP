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
 * ArtisanSmarty number_format modifier plugin
 *
 * number_formatする
 * @param string $string number_formatしたい文字列
 * @param string $esc_type html|htmlall|url|quotes|hex|hexentity|javascript
 * @return string
 */
function smarty_modifier_number_format($string, $decimals = 0, $dec_point = '.', $thousands_sep =',')
{
	return number_format((int)$string, (int)$decimals, $dec_point, $thousands_sep);
}


?>
