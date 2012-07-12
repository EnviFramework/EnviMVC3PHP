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
 * 文字列囲い込み分割文字を使用して指定した文字数に文字列を分割する
 *
 * wordwrapが、文字列の右側に分割文字を置いて分割するのに対し、
 * strcircleは、文字列を分割文字で囲って分割します。
 *
 * @return string
 * @copyright ver1.0
 * @since 2005/04/06 15:57
 * @package ArtisanSmarty
 * @subpackage plugins
 */
function smarty_modifier_strcircle($str,$partition=1,$left_delimiter="",$right_delimiter=""){
	$counter=strlen($str);
	$i=0;
	while($counter!=$i){
		$res.=$left_delimiter.substr($str,$i,$partition).$right_delimiter;
		$i+=$partition;
	}
	return $res;
}

?>