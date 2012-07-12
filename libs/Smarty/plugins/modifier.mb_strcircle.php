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
 * strcircleのマルチバイト対応版
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
function smarty_modifier_mb_strcircle($str,$partition=1,$left_delimiter="",$right_delimiter="",$encoding="default")
	$counter=mb_strlen($str);
	$i=0;
	switch(strtolower($encoding)){
		case "default":
			while($counter!=$i){
				$res.=$left_delimiter.mb_substr($str,$i,$partition).$right_delimiter;
				$i+=$partition;
			}
		break;
		case "auto":
			$encoding=mb_detect_encoding($str);
		default:
			while($counter!=$i){
				$res.=$left_delimiter.mb_substr($str,$i,$partition,$encoding).$right_delimiter;
				$i+=$partition;
			}
		break;
	}
	return $res;
}
?>