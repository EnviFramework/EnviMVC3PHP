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
 * ArtisanSmartySmarty plugin
 * @package ArtisanSmarty
 * @subpackage plugins
 */


/**
 * ʸ����ʬ��ʸ������Ѥ��ƻ��ꤷ��ʸ��������ʸ�����ʬ�䤹�롣
 *
 * <pre>
 * (���ץ�����) $width�ѥ�᡼���ǻ��ꤷ���� ����ֹ��ʸ����$string��ʬ�䤷�ޤ���
 * (���ץ��� ���)$break�ѥ�᡼�����Ѥ��ƹԤ�ʬ�䤵��ޤ���
 * $width�ޤ���$break�� ���ꤵ��Ƥ��ʤ���硢
 * mb_wordwrap()��80�����Ǽ�ưŪ��ʬ�䤷��'\n'(����)���Ѥ���ʬ�䤷�ޤ���
 * 
 * $cut��1�����ꤵ�줿��硢ʸ����Ͼ�˻��ꤷ�����ǥ�åפ���ޤ���
 * ���ΰ١��ޥ���Х���ʸ�����������¤�ۤ���Ȥ��ϡ���������ʬ�䤵��ޤ���
 * $cut��0�ξ��ϡ���˸��ꤵ�줿ʸ������ʬ����ߤޤ���
 * 
 * ʬ�䤹��ʸ���󤬡�Ⱦ�ѥ��޻������ԡ����֡�Ⱦ�ѥ��ڡ����Ǥ�����ϡ�
 * wordwrap���ƤӽФ��졢��������ޤ���
 *
 * -----------------------------------------------
 * Type:       modifier
 * Name:       mb_wordwrap
 * attribute: 1 (80) ��ɥ�åפ��륫����� �ǥե����
 *            2 ('\n') ��ɥ�åפ˻��Ѥ����ʸ���� �ǥե����
 *            3 (0) ��ɥ�åפ�ʸ�����Ǥ�뤫��ʸ�����Ǥ�뤫
 * </pre>
 *
 * @param string $string ʬ�䤹��ǡ���
 * @param integer $length ������ֹ�
 * @param string $break ���ڤ�ʸ��
 * @param integer $cut �Х��ȷ׻�(�ޥ���Х���ʸ����2�Х���)����ʤ�1ʸ�����׻��ʤ�0 �ǥե����0
 * @see http://php.five-foxes.com/module/php_man/index.php?web=function.wordwrap
 * @return string
 */
function smarty_modifier_mb_wordwrap($string, $length = 80, $break = "\n", $cut = 0)
{
	if (preg_match("/^[\!-\~\s\t\r\n]+$/", $string)) {
		//�̾��Ⱦ�ѱѿ����ʤ�С����̤�wordwrap���롣
		return wordwrap($string, $length, $break, $cut);
	}
	
	//�ޥ���Х���ʸ������
	$word_wrap_array = explode($break, $string);
	foreach ($word_wrap_array as $str) {
		$i = 0;
		if ($cut == 1) {
			$stop = mb_strwidth($str);
		} else {
			$stop = mb_strlen($str);
		}
		while ($i < $stop) {
			if ($cut == 1) {
				$a = mb_strcut($str, $i, $length);
				//�¼��ʹԾ��֤�Ͽ
				$i += mb_strwidth($a);
			} else {
				$a = mb_substr($str, $i, $length);
				//�ʹԾ��֤�Ͽ
				$i += $length;
			}
			$res[]=$a;
		}
		
	}
	return is_array($res) ? join($break, $res) : $res;
}

?>