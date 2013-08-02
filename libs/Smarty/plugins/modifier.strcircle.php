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
 * ʸ����Ϥ�����ʬ��ʸ������Ѥ��ƻ��ꤷ��ʸ������ʸ�����ʬ�䤹��
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
function smarty_modifier_strcircle($str,$partition=1,$left_delimiter="",$right_delimiter=""){
	$counter=strlen($str);
	$i=0;
	while($counter!=$i){
		$res.=$left_delimiter.substr($str,$i,$partition).$right_delimiter;
		$i+=$partition;
	}
	return $res;
}

