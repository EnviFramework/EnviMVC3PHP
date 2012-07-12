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
 * strcircle�Υޥ���Х����б���
 *
 * wordwrap����ʸ����α�¦��ʬ��ʸ�����֤���ʬ�䤹��Τ��Ф���
 * strcircle�ϡ�ʸ�����ʬ��ʸ���ǰϤä�ʬ�䤷�ޤ���
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