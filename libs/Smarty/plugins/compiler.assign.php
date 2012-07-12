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
 * �ƥ�ץ졼�Ȥ˥ƥ�ץ졼���ѿ��������Ƥޤ���
 *
 * <pre>
 * ���饹���Τ�assign��Ʊ�ͤ�ư���򤷤ޤ���
 * var=''°����value=''°�����ͤ���������ޤ���
 * assign��������줿�ƥ�ץ졼���ѿ��ϡ��̾�ɤ���<%$�ѿ�̾%>�ǻ��Ƚ���ޤ���
 * ----------------------------------------------------
 * Type:       compiler function
 * Name:       assign
 * attribute:  var ������Ƥ���ƥ�ץ졼���ѿ���̾�� ɬ������
 *             value �ƥ�ץ졼���ѿ��˳�����Ƥ���
 * </pre>
 *
 * @author Akito<akito-artisan@five-foxes.com>
 * @param array $tag_attrs ����������
 * @param object $compiler ArtisanSmartyCompiler���֥�������
 */
function smarty_compiler_assign($tag_attrs, &$compiler)
{
    $_params = $compiler->_parse_attrs($tag_attrs);

    if (!isset($_params['var'])) {
        $compiler->_syntax_error("assign: missing 'var' parameter", E_USER_WARNING);
        return;
    }

    if (!isset($_params['value'])) {
        $compiler->_syntax_error("assign: missing 'value' parameter", E_USER_WARNING);
        return;
    }

    return "\$this->assign({$_params['var']}, {$_params['value']});";
}

/* vim: set expandtab: */

?>
