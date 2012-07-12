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
 * ��������̤�ʸ�������������������åפ��Ԥ򥤥�ǥ�Ȥ���������������ޤ���
 *
 * <pre>
 * <%textformat%><%/textformat%>
 * �ǰϤޤ줿�ϰϤ򡢥ե����ޥåȤ��ޤ���
 * --------------------------------------------------
 * Type:      block function<br>
 * Name:      textformat<br>
 * attribute: style: string () ���餫�������줿��������򥻥åȽ���ޤ������ߡ�"email"�Τߤ�ͭ���ʥ�������Ǥ���
 *            indent_first: integer (0) �ƹԤ򥤥�ǥ�Ȥ��륭����
 *            wrap: integer (80) �ƹԤ򤤤��ĤΥ���饯�����ǥ�åפ��뤫
 *            wrap_char string ("\n") �ƹԤ�ʬ�䤹�뤿��Υ���饯��(���ϥ�����ʸ����)
 *            indent_char: string (" ") ����ǥ�Ȥ��뤿��˻Ȥ��륭��饯��(���ϥ�����ʸ����)
 *            assign: string () ���Ϥ�������Ƥ���ƥ�ץ졼���ѿ�
 *            wrap_cut: boolean (false) true�ʤ�С���åפ�ñ��ζ�������������Τʥ���饯�����ǹԤ�ʬ�䤷�ޤ���
 * </pre>
 *
 * @author Akito<akito-artisan@five-foxes.com>
 * @param array $params ������°��
 * @param string $contents �֥�å�����ƥ��
 * @param object $smarty ArtisanSmarty���֥�������
 * @return string �ե����ޥåȤ��줿ʸ����
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
