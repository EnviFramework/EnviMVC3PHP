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
 * ArtisanSmarty mb_strimwidth modifier plugin
 *
 * Type:     modifier<br>
 * Name:     mb_strimwidth<br>
 * Purpose:  indent lines of text
 *
 * @param string $string
 * @param integer $start
 * @param integer $limit
 * @param string $trimmer
 * @param string $encoding
 * @return string
 */
function smarty_modifier_mb_strimwidth($string,$start = 0,$limit = 100, $trimmer = "¡Ä",$encoding = "AUTO")
{
    return mb_strimwidth($string, $start, $limit, $trimmer, $encoding);
}

?>
