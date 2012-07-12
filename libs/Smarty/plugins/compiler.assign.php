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
 * テンプレートにテンプレート変数を割り当てます。
 *
 * <pre>
 * クラス本体のassignと同様の動きをします。
 * var=''属性にvalue=''属性の値が代入されます。
 * assignで定義されたテンプレート変数は、通常どおり<%$変数名%>で参照出来ます。
 * ----------------------------------------------------
 * Type:       compiler function
 * Name:       assign
 * attribute:  var 割り当てられるテンプレート変数の名前 必須入力
 *             value テンプレート変数に割り当てる値
 * </pre>
 *
 * @author Akito<akito-artisan@five-foxes.com>
 * @param array $tag_attrs タグの要素
 * @param object $compiler ArtisanSmartyCompilerオブジェクト
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
