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
 * 文字列分割文字を使用して指定した文字数数に文字列を分割する。
 *
 * <pre>
 * (オプションの) $widthパラメータで指定したカ ラム番号で文字列$stringを分割します。
 * (オプショ ンの)$breakパラメータを用いて行は分割されます。
 * $widthまたは$breakが 指定されていない場合、
 * mb_wordwrap()は80カラムで自動的に分割し、'\n'(改行)を用いて分割します。
 * 
 * $cutが1に設定された場合、文字列は常に指定した幅でラップされます。
 * この為、マルチバイト文字がこの制限を越えるときは、その前で分割されます。
 * $cutが0の場合は、常に固定された文字数で分割を試みます。
 * 
 * 分割する文字列が、半角ローマ字、改行・タブ・半角スペースである場合は、
 * wordwrapが呼び出され、処理されます。
 *
 * -----------------------------------------------
 * Type:       modifier
 * Name:       mb_wordwrap
 * attribute: 1 (80) ワードラップするカラム幅 デフォルト
 *            2 ('\n') ワードラップに使用される文字列 デフォルト
 *            3 (0) ワードラップを文字数でやるか、文字幅でやるか
 * </pre>
 *
 * @param string $string 分割するデータ
 * @param integer $length カラム番号
 * @param string $break 区切り文字
 * @param integer $cut バイト計算(マルチバイト文字は2バイト)するなら1文字数計算なら0 デフォルト0
 * @see http://php.five-foxes.com/module/php_man/index.php?web=function.wordwrap
 * @return string
 */
function smarty_modifier_mb_wordwrap($string, $length = 80, $break = "\n", $cut = 0)
{
	if (preg_match("/^[\!-\~\s\t\r\n]+$/", $string)) {
		//通常の半角英数字ならば、普通にwordwrapする。
		return wordwrap($string, $length, $break, $cut);
	}
	
	//マルチバイト文字処理
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
				//実質進行状態を記録
				$i += mb_strwidth($a);
			} else {
				$a = mb_substr($str, $i, $length);
				//進行状態を記録
				$i += $length;
			}
			$res[]=$a;
		}
		
	}
	return is_array($res) ? join($break, $res) : $res;
}

?>