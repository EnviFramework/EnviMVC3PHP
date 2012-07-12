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
 * 空白と特別な文字列を取り除き、境界をラップし行をインデントして段落を整形します。
 *
 * <pre>
 * <%textformat%><%/textformat%>
 * で囲まれた範囲を、フォーマットします。
 * --------------------------------------------------
 * Type:      block function<br>
 * Name:      textformat<br>
 * attribute: style: string () あらかじめ決められたスタイルをセット出来ます。現在、"email"のみが有効なスタイルです。
 *            indent_first: integer (0) 各行をインデントするキャラ数
 *            wrap: integer (80) 各行をいくつのキャラクタ数でラップするか
 *            wrap_char string ("\n") 各行を分割するためのキャラクタ(又はキャラの文字列)
 *            indent_char: string (" ") インデントするために使われるキャラクタ(又はキャラの文字列)
 *            assign: string () 出力が割り当てられるテンプレート変数
 *            wrap_cut: boolean (false) trueならば、ラップは単語の境界の代わりに正確なキャラクタ数で行を分割します。
 * </pre>
 *
 * @author Akito<akito-artisan@five-foxes.com>
 * @param array $params タグの属性
 * @param string $contents ブロックコンテンツ
 * @param object $smarty ArtisanSmartyオブジェクト
 * @return string フォーマットされた文字列
 */
function smarty_block_textformat($params, $content, &$smarty)
{
    if (is_null($content)) {
        return;
    }

    $style = null;
    $indent = 0;
    $indent_first = 0;
    $indent_char = ' ';
    $wrap = 80;
    $wrap_char = "\n";
    $wrap_cut = false;
    $assign = null;
    
    foreach ($params as $_key => $_val) {
        switch ($_key) {
            case 'style':
            case 'indent_char':
            case 'wrap_char':
            case 'assign':
                $$_key = (string)$_val;
                break;

            case 'indent':
            case 'indent_first':
            case 'wrap':
                $$_key = (int)$_val;
                break;

            case 'wrap_cut':
                $$_key = (bool)$_val;
                break;

            default:
                $smarty->trigger_error("textformat: unknown attribute '$_key'");
        }
    }

    if ($style == 'email') {
        $wrap = 72;
    }

    // split into paragraphs
    $_paragraphs = preg_split('![\r\n][\r\n]!',$content);
    $_output = '';

    for($_x = 0, $_y = count($_paragraphs); $_x < $_y; $_x++) {
        if ($_paragraphs[$_x] == '') {
            continue;
        }
        // convert mult. spaces & special chars to single space
        $_paragraphs[$_x] = preg_replace(array('!\s+!','!(^\s+)|(\s+$)!'), array(' ',''), $_paragraphs[$_x]);
        // indent first line
        if($indent_first > 0) {
            $_paragraphs[$_x] = str_repeat($indent_char, $indent_first) . $_paragraphs[$_x];
        }
        // wordwrap sentences
        $_paragraphs[$_x] = wordwrap($_paragraphs[$_x], $wrap - $indent, $wrap_char, $wrap_cut);
        // indent lines
        if($indent > 0) {
            $_paragraphs[$_x] = preg_replace('!^!m', str_repeat($indent_char, $indent), $_paragraphs[$_x]);
        }
    }
    $_output = implode($wrap_char . $wrap_char, $_paragraphs);

    return $assign ? $smarty->assign($assign, $_output) : $_output;

}

/* vim: set expandtab: */

?>
