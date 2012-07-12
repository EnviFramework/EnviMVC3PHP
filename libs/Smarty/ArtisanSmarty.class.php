<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// |                            ARTISAN Smarty                            |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright 2004-2005 ARTISAN PROJECT All rights reserved.             |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
/**
 * ARTISAN PROJECT
 * 
 * �ޥ���Х����б�Smarty+ �ղå����ƥ�
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @link http://smarty.php.net/
 * @link http://php.five-foxes.com/
 * @copyright 2001-2005 New Digital Group, Inc.
 * @copyright 2004-2005 Artisan Project
 * @author Monte Ohrt <monte at ohrt dot com>
 * @author Andrei Zmievski <andrei@php.net>
 * @author Akito <akito-artisan@five-foxes.com>
 * @package ArtisanSmarty
 * @version 1.0.12
 */

/**
 * DIR_SEP�Ϻ��ϻ��Ѥ���ޤ��󤬡������ɥѡ��ƥ����ǻ��Ѥ���뤫�⤷��ޤ���
 */
if(!defined('DIR_SEP')) {
    define('DIR_SEP', DIRECTORY_SEPARATOR);
}

/**
 * SMARTY_DIR��Artisan Smarty�Υ饤�֥��ѥ������ꤷ�Ƥ���������
 * �⤷���ꤵ��ʤ����ϡ�include_path �����Ѥ���ޤ���
 * ������������ꤵ��Ƥ��ʤ����˸¤ꡢArtisanSmarty�ϼ�ʬ�ǹͤ���������ޤ���
 */
if (!defined('SMARTY_DIR')) {
    define('SMARTY_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}


if (!defined('SMARTY_CORE_DIR')) {
    define('SMARTY_CORE_DIR', SMARTY_DIR . 'internals' . DIRECTORY_SEPARATOR);
}

define('SMARTY_PHP_PASSTHRU',   0);
define('SMARTY_PHP_QUOTE',      1);
define('SMARTY_PHP_REMOVE',     2);
define('SMARTY_PHP_ALLOW',      3);

/**
 * @package ArtisanSmarty
 */
class Smarty
{
    /**#@+
     * ArtisanSmarty �Υ���ե�����ʬ
     */

    /**
     * �ƥ�ץ졼�ȥե�������֤��ǥ��쥯�ȥ�Ǥ���<br>
     * �ƥ�ץ졼�ȥե�������ɤ߹���ݤ˥ѥ�����ꤷ�ʤ��ä����ϡ����Υǥ��쥯�ȥ꤫��õ���ޤ���
     * 
     * @var string
     */
    var $template_dir    =  'templates';

    /**
     * ����ѥ��뤵�줿�ƥ�ץ졼�Ȥ��֤����ǥ��쥯�ȥ�Ǥ���
     *
     * @var string
     */
    var $compile_dir     =  'templates_c';

    /**
     * �ƥ�ץ졼�Ȥ����ɤ߹��ि�������ե�����(Config�ե�����)���֤��ǥ��쥯�ȥ�Ǥ���
     *
     * @var string
     */
    var $config_dir      =  'configs';

    /**
     * �����ؿ��ʤɤǥե�������Ǥ��ǥ��쥯�ȥ�
     *
     * @var string
     */
    var $etc_dir         =  'etc';
    /**
     * Smarty��ɬ�פȤ���ץ饰������֤��ǥ��쥯�ȥ�Ǥ���<br>
     * SMARTY_DIRľ���ͥ����ȥǥ��쥯�ȥ��php��include_path
     * �ν�ǡ�����Υǥ��쥯�ȥ�򸡺����ޤ���
     *
     * @var array
     */
    var $plugins_dir     =  array('plugins');

    /**
     * �ڡ������ɻ��ˡ���ư�ǥǥХå����󥽡��륦����ɥ���ɽ�����ޤ���<br>
     * �֥饦���Ρ��ݥåץ��åפ���Ĥ��Ƥ���������
     * 
     * @var boolean
     */
    var $debugging       =  false;

    /**
     * ���åȤ���ȡ�Smarty�Υ��顼��٥�򥳥�˥��åȤ��ޤ���<br>
     *
     * @var boolean
     */
    var $error_reporting  =  null;

    /**
     * �ǥХå����󥽡���˻��Ѥ����ƥ�ץ졼�ȥե������̾���Ǥ���<br>
     * ���ꤷ�ʤ����ϡ��ǥե���ȤΥǥХå����󥽡��뤬���Ѥ���ޤ���<br>
     *
     * @var string
     */
    var $debug_tpl       =  '';

    /**
     * �ǥХå��󥰥��󥽡����ͭ���ˤ��뤿���$debugging��������ˡ�Ǥ���
     * <ul>
     *  <li>NONE =>�����̵���ˤ�������̣���ޤ�</li>
     *  <li>URL => QUERY_STRING����˥������"SMARTY_DEBUG"���ޤޤ�Ƥ������˥ǥХå��󥰥��󥽡��뤬ͭ���ˤʤ�����̣���ޤ���</li>
     * </ul>
     * $debugging��"true"�ξ��ϡ����������̵�뤵��ޤ���
     *
     * @link http://www.foo.dom/index.php?SMARTY_DEBUG
     * @var string
     */
    var $debugging_ctrl  =  'NONE';

    /**
     * php���ץꥱ�������γƥꥯ�����Ȼ��ˡ����ߤΥƥ�ץ졼�Ȥ��Ǹ��ˬ�줿�������ѹ�����Ƥ���
     * �ʥ����ॹ����פ��ۤʤ�ˤʤ顢���줬����ѥ��뤵��Ƥ��뤫�ɤ����򸡺����ޤ���<br>
     * �⤷����ѥ��뤵��Ƥ��ʤ���С����Υƥ�ץ졼�Ȥ�ƥ���ѥ��뤷�ޤ���<br>
     * ���Υƥ�ץ졼�Ȥ����٤⥳��ѥ��뤵��Ƥ��ʤ��ä����ϡ���������˴ط��ʤ�����ѥ����Ԥ��ޤ���<br>
     *
     * @var boolean
     */
    var $compile_check   =  true;

    /**
     * �ƥ�ץ졼�Ȥ��ƤӽФ������˶���Ū�˥���ѥ���(�ƥ���ѥ���)��Ԥ��ޤ���<br>
     * ��ȯ�䡢�ǥХå��˻��Ѥ��Ƥ���������
     *
     * @var boolean
     */
    var $force_compile   =  false;

    /**
     * �ƥ�ץ졼�Ȥν��Ϥ򥭥�å��夹�뤫�ɤ��������ꤷ�ޤ���
     * <ul>
     *  <li>0 = ����å��󥰤�Ԥ��ޤ���</li>
     *  <li>1 = �ˤ��Υ���å��夬�����ڤ줫�ɤ�����Ĵ�٤뤿��ˡ� ���ߤλ��֤� $cache_lifetime ���ͤ���Ӥ��ޤ���</li>
     *  <li>2 = �ˤ��Υ���å��夬�������줿�����λ��֤� $cache_lifetime ���ͤ���Ӥ���褦�˻ؼ����ޤ�</li>
     * </ul>
     *
     * @var integer
     */
    var $caching         =  0;

    /**
     * �ƥ�ץ졼�ȤΥ���å��夬��Ǽ�����ǥ��쥯�ȥ�Ǥ���
     *
     * @var string
     */
    var $cache_dir       =  'cache';

    /**
     * �ƥ�ץ졼�ȤΥ���å���δ���(ñ�̡���)�Ǥ������줬�ڤ��ȥ���å���Ϻ���������ޤ���
     * <ul>
     *  <li>0 = ��˥���å���κ��������ޤ���</li>
     *  <li>-1 = ����å����̵���¤����Ѥ��ޤ���</li>
     * </ul>
     *
     * @var integer
     */
    var $cache_lifetime  =  3600;

    /**
     * ����å��夵�줿���Ƥ�insert�������ޤޤ�ʤ����ˡ�
     * ����å���ե�����Υ����ॹ����פ��Ǹ��ˬ�줿�������Ѥ�äƤ��ʤ��ʤ顢
     * ����ƥ�Ĥ������"304 Not Modified"�쥹�ݥ󥹤��֤���ޤ���
     * 
     * @var boolean
     */
    var $cache_modified_check = false;

    /**
     * �ƥ�ץ졼�Ȥ������ޤ줿php�����ɤΰ��������ꤷ�ޤ���<br>
     * �ƥ�ץ졼�����php�����˰Ϥޤ줿php�����ɤˤϱƶ���ڤܤ��ʤ�������դ��Ʋ�������
     * <ul>
     *  <li>SMARTY_PHP_PASSTHRU -> php�����ɤ�¹Ԥ����ˤ��Τޤ޽��Ϥ��ޤ���</li>
     *  <li>SMARTY_PHP_QUOTE    -> php�����ɤ�html�����ǤȤ���ɽ�����ޤ���</li>
     *  <li>SMARTY_PHP_REMOVE   -> php�����ɤ�ƥ�ץ졼�Ȥ������ޤ���</li>
     *  <li>SMARTY_PHP_ALLOW    -> php�����ɤ�¹Ԥ��ޤ���</li>
     * </ul>
     *
     * @var integer
     */
    var $php_handling    =  SMARTY_PHP_PASSTHRU;

    /**
     * �ƥ�ץ졼�ȥ������ƥ���ǽ����Ѥ��뤫�ɤ��������ꤷ�ޤ���<br>
     * ���Ѥ���ȡ��ƥ�ץ졼�Ȥ��͡��ʵ�ǽ����������ޤ���<br>
     * ���ޤ꿮�Ѥ������ʤ����롼�פ��ƥ�ץ졼�Ȥ��Խ�����
     * �ʤɤȸ������˺�Ŭ�ʥ������ƥ����󶡤��ޤ���<br>
     * (���Ȥ��С��ƥ�ץ졼�����php�μ¹Ԥ�����ޤ���)
     *
     * @see $security_settings
     * @var boolean
     */
    var $security       =   false;

    /**
     * �����ȹͤ�����ǥ��쥯�ȥ������Ǥ���<br>
     * ����ϡ�{@link $security}�����Ѥ��줿�Ȥ��ˤϡ�
     * ���Υǥ��쥯�ȥ�ˤ���ƥ�ץ졼�ȤΤߤ���Ѥ������������ޤ���<br>
     * �����ǰ�ǥ��쥯�ȥ�ǻ��ꤷ��
     * �ޤ���{@link $template_dir}�ϻ��ꤻ���Ȥ⡢���Ѳ�ǽ�Ǥ���
     *
     * @var array
     */
    var $secure_dir     =   array();

    /**
     * ArtisanSmarty�Υ������ƥ�����Ǥ���<br>
     * {@link $security}���ѻ���ư��򼨤��ޤ���<br>
     * <ul>
     * <li>PHP_HANDLING -> true/false�ǻ��ꤷ�ޤ���true�ξ�硢�������ƥ��Τ����{@link $php_handling}������å����ޤ���</li>
     * <li>IF_FUNCS -> if���ơ��ȥ��Ȥˤƻ��Ѳ�ǽ��php�ؿ���̾��������Ǥ���</li>
     * <li>INCLUDE_ANY -> true/false�ǻ��ꤷ�ޤ���true�ξ�硢�ƥ�ץ졼�Ȥ�{@link $secure_dir}�Υꥹ�Ȥ˴ط��ʤ������륷���ƥफ�饤�󥯥롼�ɲ�ǽ�Ǥ���</li>
     * <li>PHP_TAGS -> true/false�ǻ��ꤷ�ޤ���true�ξ�硢php�������ƥ�ץ졼�Ȥǻ��ѤǤ��ޤ���</li>
     * <li>MODIFIER_FUNCS -> �ѿ��ν����ҤȤ��ƻ��Ѳ�ǽ��php�ؿ���̾��������Ǥ���</li>
     * </ul>
     * 
     * @var array
     */
    var $security_settings  = array(
                                    'PHP_HANDLING'    => false,
                                    'IF_FUNCS'        => array('array', 'list',
                                                               'isset', 'empty',
                                                               'count', 'sizeof',
                                                               'in_array', 'is_array',
                                                               'true', 'false', 'null'),
                                    'INCLUDE_ANY'     => false,
                                    'PHP_TAGS'        => false,
                                    'MODIFIER_FUNCS'  => array('count'),
                                    'ALLOW_CONSTANTS'  => false
                                   );

    /**
     * This is an array of directories where trusted php scripts reside.
     * {@link $security} is disabled during their inclusion/execution.
     *
     * @var array
     */
    var $trusted_dir        = array();

    /**
     * �ƥ�ץ졼�Ȥˤƻ��Ѥ����ƥ�ץ졼�ȸ���γ��Ϥ�ɽ���ǥ�ߥ��Ǥ���
     * �ܲ�Smarty�Υǥե���Ȥ�"{"�Ǥ�����Javascript��CSS�ʤɤȤ������������١�
     * ArtisanSmarty�Ǥϥǥե���Ȥ�"<%"�Ȥ��Ƥ��ޤ���
     *
     * @var string
     */
    var $left_delimiter  =  '<%';

    /**
     * �ƥ�ץ졼�Ȥˤƻ��Ѥ����ƥ�ץ졼�ȸ���ν�ü��ɽ���ǥ�ߥ��Ǥ���
     * �ܲ�Smarty�Υǥե���Ȥ�"}"�Ǥ�����Javascript��CSS�ʤɤȤ������������١�
     * ArtisanSmarty�Ǥϥǥե���Ȥ�"%>"�Ȥ��Ƥ��ޤ���
     *
     *
     * @var string
     */
    var $right_delimiter =  '%>';

    /**
     * The order in which request variables are registered, similar to
     * variables_order in php.ini E = Environment, G = GET, P = POST,
     * C = Cookies, S = Server
     *
     * @var string
     */
    var $request_vars_order    = 'EGPCS';

    /**
     * Indicates wether $HTTP_*_VARS[] (request_use_auto_globals=false)
     * are uses as request-vars or $_*[]-vars. note: if
     * request_use_auto_globals is true, then $request_vars_order has
     * no effect, but the php-ini-value "gpc_order"
     *
     * @var boolean
     */
    var $request_use_auto_globals      = true;

    /**
     * Set this if you want different sets of compiled files for the same
     * templates. This is useful for things like different languages.
     * Instead of creating separate sets of templates per language, you
     * set different compile_ids like 'en' and 'de'.
     *
     * @var string
     */
    var $compile_id            = null;

    /**
     * This tells Smarty whether or not to use sub dirs in the cache/ and
     * templates_c/ directories. sub directories better organized, but
     * may not work well with PHP safe mode enabled.
     *
     * @var boolean
     *
     */
    var $use_sub_dirs          = false;

    /**
     * This is a list of the modifiers to apply to all template variables.
     * Put each modifier in a separate array element in the order you want
     * them applied. example: <code>array('escape:"htmlall"');</code>
     *
     * @var array
     */
    var $default_modifiers        = array();

    /**
     * This is the resource type to be used when not specified
     * at the beginning of the resource path. examples:
     * $smarty->display('file:index.tpl');
     * $smarty->display('db:index.tpl');
     * $smarty->display('index.tpl'); // will use default resource type
     * {include file="file:index.tpl"}
     * {include file="db:index.tpl"}
     * {include file="index.tpl"} {* will use default resource type *}
     *
     * @var array
     */
    var $default_resource_type    = 'file';

    /**
     * The function used for cache file handling. If not set, built-in caching is used.
     *
     * @var null|string function name
     */
    var $cache_handler_func   = null;

    /**
     * This indicates which filters are automatically loaded into Smarty.
     *
     * @var array array of filter names
     */
    var $autoload_filters = array();

    /**#@+
     * @var boolean
     */
    /**
     * This tells if config file vars of the same name overwrite each other or not.
     * if disabled, same name variables are accumulated in an array.
     */
    var $config_overwrite = true;

    /**
     * This tells whether or not to automatically booleanize config file variables.
     * If enabled, then the strings "on", "true", and "yes" are treated as boolean
     * true, and "off", "false" and "no" are treated as boolean false.
     */
    var $config_booleanize = true;

    /**
     * This tells whether hidden sections [.foobar] are readable from the
     * tempalates or not. Normally you would never allow this since that is
     * the point behind hidden sections: the application can access them, but
     * the templates cannot.
     */
    var $config_read_hidden = false;

    /**
     * ����ե��������mac��dos��newline (\r �� \r\n)�Ϥ���餬�ѡ����������� \n�˥���С��Ȥ���ޤ���
     * �ǥե���Ȥ�true�ǵ�ǽ��ON�ˤʤäƤ��ޤ��� 
     */
    var $config_fix_newlines = true;
    /**#@-*/

    /**
     * �ƥ�ץ졼�ȥե����뤬���Ĥ���ʤ��ä���硢�����ǻ��ꤵ�줿PHP�ؿ����¹Ԥ���ޤ���
     *
     * @var string function name
     */
    var $default_template_handler_func = '';

    /**
     * ����ѥ��饯�饹��ޤ�ե����롣
     * �ե�ѥ���񤯤��������Ǥʤ����php��include_path��SMARTY_DIR�����õ���ޤ���
     *
     * @var string
     */
    var $compiler_file        =    'ArtisanSmarty_Compiler.class.php';

    /**
     * Smarty���ƥ�ץ졼�Ȥ򥳥�ѥ��뤹�뤿��˻��Ѥ��륳��ѥ��饯�饹��̾������ꤷ�ޤ���
     *
     * @var string
     */
    var $compiler_class        =   'Smarty_Compiler';

    /**
     * ����ե����ѿ����ɤ߹��९�饹��̾������ꤷ�ޤ���
     *
     * @var string
     */
    var $config_class          =   'Config_File';

/**#@+
 * END Smarty Configuration Section
 * There should be no need to touch anything below this line.
 * @access private
 */
    /**
     * where assigned template vars are kept
     *
     * @var array
     */
    var $_tpl_vars             = array();

    /**
     * stores run-time $smarty.* vars
     *
     * @var null|array
     */
    var $_smarty_vars          = null;

    /**
     * keeps track of sections
     *
     * @var array
     */
    var $_sections             = array();

    /**
     * keeps track of foreach blocks
     *
     * @var array
     */
    var $_foreach              = array();

    /**
     * keeps track of tag hierarchy
     *
     * @var array
     */
    var $_tag_stack            = array();

    /**
     * configuration object
     *
     * @var Config_file
     */
    var $_conf_obj             = null;

    /**
     * loaded configuration settings
     *
     * @var array
     */
    var $_config               = array(array('vars'  => array(), 'files' => array()));

    /**
     * 'Smarty'��md5 �����å�����Ǥ��� 
     *
     * @var string
     */
    var $_smarty_md5           = 'f8d698aea36fcbead2b9d5359ffca76f';

    /**
     * ArtisanSmarty�ΥС������Ǥ���
     *
     * @var string
     */
    var $_version              = '1.0.12';

    /**
     * current template inclusion depth
     *
     * @var integer
     */
    var $_inclusion_depth      = 0;

    /**
     * for different compiled templates
     *
     * @var string
     */
    var $_compile_id           = null;

    /**
     * text in URL to enable debug mode
     *
     * @var string
     */
    var $_smarty_debug_id      = 'SMARTY_DEBUG';

    /**
     * debugging information for debug console
     *
     * @var array
     */
    var $_smarty_debug_info    = array();

    /**
     * info that makes up a cache file
     *
     * @var array
     */
    var $_cache_info           = array();

    /**
     * default file permissions
     *
     * @var integer
     */
    var $_file_perms           = 0644;

    /**
     * default dir permissions
     *
     * @var integer
     */
    var $_dir_perms               = 0771;

    /**
     * registered objects
     *
     * @var array
     */
    var $_reg_objects           = array();

    /**
     * table keeping track of plugins
     *
     * @var array
     */
    var $_plugins              = array(
                                       'modifier'      => array(),
                                       'function'      => array(),
                                       'block'         => array(),
                                       'compiler'      => array(),
                                       'prefilter'     => array(),
                                       'postfilter'    => array(),
                                       'outputfilter'  => array(),
                                       'resource'      => array(),
                                       'insert'        => array());


    /**
     * cache serials
     *
     * @var array
     */
    var $_cache_serials = array();

    /**
     * name of optional cache include file
     *
     * @var string
     */
    var $_cache_include = null;

    /**
     * indicate if the current code is used in a compiled
     * include
     *
     * @var string
     */
    var $_cache_including = false;

    /**#@-*/
    /**
     * The class constructor.
     */
    function Smarty()
    {
      $this->assign('SCRIPT_NAME', isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME']
                    : @$GLOBALS['HTTP_SERVER_VARS']['SCRIPT_NAME']);
    }

    /**
     * assigns values to template variables
     *
     * @param array|string $tpl_var the template variable name(s)
     * @param mixed $value the value to assign
     */
    function assign($tpl_var, $value = null)
    {
        if (is_array($tpl_var)){
            foreach ($tpl_var as $key => $val) {
                if ($key != '') {
                    $this->_tpl_vars[$key] = $val;
                }
            }
        } else {
            if ($tpl_var != '')
                $this->_tpl_vars[$tpl_var] = $value;
        }
    }

    /**
     * assigns values to template variables by reference
     *
     * @param string $tpl_var the template variable name
     * @param mixed $value the referenced value to assign
     */
    function assign_by_ref($tpl_var, &$value)
    {
        if ($tpl_var != '')
            $this->_tpl_vars[$tpl_var] = &$value;
    }

    /**
     * appends values to template variables
     *
     * @param array|string $tpl_var the template variable name(s)
     * @param mixed $value the value to append
     */
    function append($tpl_var, $value=null, $merge=false)
    {
        if (is_array($tpl_var)) {
            // $tpl_var is an array, ignore $value
            foreach ($tpl_var as $_key => $_val) {
                if ($_key != '') {
                    if(!@is_array($this->_tpl_vars[$_key])) {
                        settype($this->_tpl_vars[$_key],'array');
                    }
                    if($merge && is_array($_val)) {
                        foreach($_val as $_mkey => $_mval) {
                            $this->_tpl_vars[$_key][$_mkey] = $_mval;
                        }
                    } else {
                        $this->_tpl_vars[$_key][] = $_val;
                    }
                }
            }
        } else {
            if ($tpl_var != '' && isset($value)) {
                if(!@is_array($this->_tpl_vars[$tpl_var])) {
                    settype($this->_tpl_vars[$tpl_var],'array');
                }
                if($merge && is_array($value)) {
                    foreach($value as $_mkey => $_mval) {
                        $this->_tpl_vars[$tpl_var][$_mkey] = $_mval;
                    }
                } else {
                    $this->_tpl_vars[$tpl_var][] = $value;
                }
            }
        }
    }

    /**
     * appends values to template variables by reference
     *
     * @param string $tpl_var the template variable name
     * @param mixed $value the referenced value to append
     */
    function append_by_ref($tpl_var, &$value, $merge=false)
    {
        if ($tpl_var != '' && isset($value)) {
            if(!@is_array($this->_tpl_vars[$tpl_var])) {
             settype($this->_tpl_vars[$tpl_var],'array');
            }
            if ($merge && is_array($value)) {
                foreach($value as $_key => $_val) {
                    $this->_tpl_vars[$tpl_var][$_key] = &$value[$_key];
                }
            } else {
                $this->_tpl_vars[$tpl_var][] = &$value;
            }
        }
    }


    /**
     * clear the given assigned template variable.
     *
     * @param string $tpl_var the template variable to clear
     */
    function clear_assign($tpl_var)
    {
        if (is_array($tpl_var))
            foreach ($tpl_var as $curr_var)
                unset($this->_tpl_vars[$curr_var]);
        else
            unset($this->_tpl_vars[$tpl_var]);
    }


    /**
     * Registers custom function to be used in templates
     *
     * @param string $function the name of the template function
     * @param string $function_impl the name of the PHP function to register
     */
    function register_function($function, $function_impl, $cacheable=true, $cache_attrs=null)
    {
        $this->_plugins['function'][$function] =
            array($function_impl, null, null, false, $cacheable, $cache_attrs);

    }

    /**
     * Unregisters custom function
     *
     * @param string $function name of template function
     */
    function unregister_function($function)
    {
        unset($this->_plugins['function'][$function]);
    }

    /**
     * Registers object to be used in templates
     *
     * @param string $object name of template object
     * @param object &$object_impl the referenced PHP object to register
     * @param null|array $allowed list of allowed methods (empty = all)
     * @param boolean $smarty_args smarty argument format, else traditional
     * @param null|array $block_functs list of methods that are block format
     */
    function register_object($object, &$object_impl, $allowed = array(), $smarty_args = true, $block_methods = array())
    {
        settype($allowed, 'array');
        settype($smarty_args, 'boolean');
        $this->_reg_objects[$object] =
            array(&$object_impl, $allowed, $smarty_args, $block_methods);
    }

    /**
     * Unregisters object
     *
     * @param string $object name of template object
     */
    function unregister_object($object)
    {
        unset($this->_reg_objects[$object]);
    }


    /**
     * Registers block function to be used in templates
     *
     * @param string $block name of template block
     * @param string $block_impl PHP function to register
     */
    function register_block($block, $block_impl, $cacheable=true, $cache_attrs=null)
    {
        $this->_plugins['block'][$block] =
            array($block_impl, null, null, false, $cacheable, $cache_attrs);
    }

    /**
     * Unregisters block function
     *
     * @param string $block name of template function
     */
    function unregister_block($block)
    {
        unset($this->_plugins['block'][$block]);
    }

    /**
     * Registers compiler function
     *
     * @param string $function name of template function
     * @param string $function_impl name of PHP function to register
     */
    function register_compiler_function($function, $function_impl, $cacheable=true)
    {
        $this->_plugins['compiler'][$function] =
            array($function_impl, null, null, false, $cacheable);
    }

    /**
     * Unregisters compiler function
     *
     * @param string $function name of template function
     */
    function unregister_compiler_function($function)
    {
        unset($this->_plugins['compiler'][$function]);
    }

    /**
     * Registers modifier to be used in templates
     *
     * @param string $modifier name of template modifier
     * @param string $modifier_impl name of PHP function to register
     */
    function register_modifier($modifier, $modifier_impl)
    {
        $this->_plugins['modifier'][$modifier] =
            array($modifier_impl, null, null, false);
    }

    /**
     * Unregisters modifier
     *
     * @param string $modifier name of template modifier
     */
    function unregister_modifier($modifier)
    {
        unset($this->_plugins['modifier'][$modifier]);
    }

    /**
     * Registers a resource to fetch a template
     *
     * @param string $type name of resource
     * @param array $functions array of functions to handle resource
     */
    function register_resource($type, $functions)
    {
        if (count($functions)==4) {
            $this->_plugins['resource'][$type] =
                array($functions, false);

        } elseif (count($functions)==5) {
            $this->_plugins['resource'][$type] =
                array(array(array(&$functions[0], $functions[1])
                            ,array(&$functions[0], $functions[2])
                            ,array(&$functions[0], $functions[3])
                            ,array(&$functions[0], $functions[4]))
                      ,false);

        } else {
            $this->trigger_error("malformed function-list for '$type' in register_resource");

        }
    }

    /**
     * Unregisters a resource
     *
     * @param string $type name of resource
     */
    function unregister_resource($type)
    {
        unset($this->_plugins['resource'][$type]);
    }

    /**
     * Registers a prefilter function to apply
     * to a template before compiling
     *
     * @param string $function name of PHP function to register
     */
    function register_prefilter($function)
    {
    $_name = (is_array($function)) ? $function[1] : $function;
        $this->_plugins['prefilter'][$_name]
            = array($function, null, null, false);
    }

    /**
     * Unregisters a prefilter function
     *
     * @param string $function name of PHP function
     */
    function unregister_prefilter($function)
    {
        unset($this->_plugins['prefilter'][$function]);
    }

    /**
     * Registers a postfilter function to apply
     * to a compiled template after compilation
     *
     * @param string $function name of PHP function to register
     */
    function register_postfilter($function)
    {
    $_name = (is_array($function)) ? $function[1] : $function;
        $this->_plugins['postfilter'][$_name]
            = array($function, null, null, false);
    }

    /**
     * Unregisters a postfilter function
     *
     * @param string $function name of PHP function
     */
    function unregister_postfilter($function)
    {
        unset($this->_plugins['postfilter'][$function]);
    }

    /**
     * Registers an output filter function to apply
     * to a template output
     *
     * @param string $function name of PHP function
     */
    function register_outputfilter($function)
    {
    $_name = (is_array($function)) ? $function[1] : $function;
        $this->_plugins['outputfilter'][$_name]
            = array($function, null, null, false);
    }

    /**
     * Unregisters an outputfilter function
     *
     * @param string $function name of PHP function
     */
    function unregister_outputfilter($function)
    {
        unset($this->_plugins['outputfilter'][$function]);
    }

    /**
     * load a filter of specified type and name
     *
     * @param string $type filter type
     * @param string $name filter name
     */
    function load_filter($type, $name)
    {
        switch ($type) {
            case 'output':
                $_params = array('plugins' => array(array($type . 'filter', $name, null, null, false)));
                require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
                smarty_core_load_plugins($_params, $this);
                break;

            case 'pre':
            case 'post':
                if (!isset($this->_plugins[$type . 'filter'][$name]))
                    $this->_plugins[$type . 'filter'][$name] = false;
                break;
        }
    }

    /**
     * clear cached content for the given template and cache id
     *
     * @param string $tpl_file name of template file
     * @param string $cache_id name of cache_id
     * @param string $compile_id name of compile_id
     * @param string $exp_time expiration time
     * @return boolean
     */
    function clear_cache($tpl_file = null, $cache_id = null, $compile_id = null, $exp_time = null)
    {

        if (!isset($compile_id))
            $compile_id = $this->compile_id;

        if (!isset($tpl_file))
            $compile_id = null;

        $_auto_id = $this->_get_auto_id($cache_id, $compile_id);

        if (!empty($this->cache_handler_func)) {
            return call_user_func_array($this->cache_handler_func,
                                  array('clear', &$this, &$dummy, $tpl_file, $cache_id, $compile_id, $exp_time));
        } else {
            $_params = array('auto_base' => $this->cache_dir,
                            'auto_source' => $tpl_file,
                            'auto_id' => $_auto_id,
                            'exp_time' => $exp_time);
            require_once(SMARTY_CORE_DIR . 'core.rm_auto.php');
            return smarty_core_rm_auto($_params, $this);
        }

    }


    /**
     * clear the entire contents of cache (all templates)
     *
     * @param string $exp_time expire time
     * @return boolean results of {@link smarty_core_rm_auto()}
     */
    function clear_all_cache($exp_time = null)
    {
        return $this->clear_cache(null, null, null, $exp_time);
    }


    /**
     * test to see if valid cache exists for this template
     *
     * @param string $tpl_file name of template file
     * @param string $cache_id
     * @param string $compile_id
     * @return string|false results of {@link _read_cache_file()}
     */
    function is_cached($tpl_file, $cache_id = null, $compile_id = null)
    {
        if (!$this->caching)
            return false;

        if (!isset($compile_id))
            $compile_id = $this->compile_id;

        $_params = array(
            'tpl_file' => $tpl_file,
            'cache_id' => $cache_id,
            'compile_id' => $compile_id
        );
        require_once(SMARTY_CORE_DIR . 'core.read_cache_file.php');
        return smarty_core_read_cache_file($_params, $this);
    }


    /**
     * clear all the assigned template variables.
     *
     */
    function clear_all_assign()
    {
        $this->_tpl_vars = array();
    }

    /**
     * clears compiled version of specified template resource,
     * or all compiled template files if one is not specified.
     * This function is for advanced use only, not normally needed.
     *
     * @param string $tpl_file
     * @param string $compile_id
     * @param string $exp_time
     * @return boolean results of {@link smarty_core_rm_auto()}
     */
    function clear_compiled_tpl($tpl_file = null, $compile_id = null, $exp_time = null)
    {
        if (!isset($compile_id)) {
            $compile_id = $this->compile_id;
        }
        $_params = array('auto_base' => $this->compile_dir,
                        'auto_source' => $tpl_file,
                        'auto_id' => $compile_id,
                        'exp_time' => $exp_time,
                        'extensions' => array('.inc', '.php'));
        require_once(SMARTY_CORE_DIR . 'core.rm_auto.php');
        return smarty_core_rm_auto($_params, $this);
    }

    /**
     * Checks whether requested template exists.
     *
     * @param string $tpl_file
     * @return boolean
     */
    function template_exists($tpl_file)
    {
        $_params = array('resource_name' => $tpl_file, 'quiet'=>true, 'get_source'=>false);
        return $this->_fetch_resource_info($_params);
    }

    /**
     * Returns an array containing template variables
     *
     * @param string $name
     * @param string $type
     * @return array
     */
    function &get_template_vars($name=null)
    {
        if(!isset($name)) {
            return $this->_tpl_vars;
        } elseif(isset($this->_tpl_vars[$name])) {
            return $this->_tpl_vars[$name];
        } else {
            // var non-existant, return valid reference
            $_tmp = null;
            return $_tmp;   
        }
    }

    /**
     * Returns an array containing config variables
     *
     * @param string $name
     * @param string $type
     * @return array
     */
    function &get_config_vars($name=null)
    {
        if(!isset($name) && is_array($this->_config[0])) {
            return $this->_config[0]['vars'];
        } else if(isset($this->_config[0]['vars'][$name])) {
            return $this->_config[0]['vars'][$name];
        } else {
            // var non-existant, return valid reference
            $_tmp = null;
            return $_tmp;
        }
    }

    /**
     * trigger Smarty error
     *
     * @param string $error_msg
     * @param integer $error_type
     */
    function trigger_error($error_msg, $error_type = E_USER_WARNING)
    {
        trigger_error("Smarty error: $error_msg", $error_type);
    }


    /**
     * executes & displays the template results
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     */
    function display($resource_name, $cache_id = null, $compile_id = null)
    {
        $this->fetch($resource_name, $cache_id, $compile_id, true);
    }

    /**
     * executes & returns or displays the template results
     *
     * @param string $resource_name
     * @param string $cache_id
     * @param string $compile_id
     * @param boolean $display
     */
    function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
    {
        static $_cache_info = array();
        
        $_smarty_old_error_level = $this->debugging ? error_reporting() : error_reporting(isset($this->error_reporting)
               ? $this->error_reporting : error_reporting() & ~E_NOTICE);

        if (!$this->debugging && $this->debugging_ctrl == 'URL') {
            $_query_string = $this->request_use_auto_globals ? $_SERVER['QUERY_STRING'] : $GLOBALS['HTTP_SERVER_VARS']['QUERY_STRING'];
            if (@strstr($_query_string, $this->_smarty_debug_id)) {
                if (@strstr($_query_string, $this->_smarty_debug_id . '=on')) {
                    // enable debugging for this browser session
                    @setcookie('SMARTY_DEBUG', true);
                    $this->debugging = true;
                } elseif (@strstr($_query_string, $this->_smarty_debug_id . '=off')) {
                    // disable debugging for this browser session
                    @setcookie('SMARTY_DEBUG', false);
                    $this->debugging = false;
                } else {
                    // enable debugging for this page
                    $this->debugging = true;
                }
            } else {
                $this->debugging = (bool)($this->request_use_auto_globals ? @$_COOKIE['SMARTY_DEBUG'] : @$GLOBALS['HTTP_COOKIE_VARS']['SMARTY_DEBUG']);
            }
        }

        if ($this->debugging) {
            // capture time for debugging info
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $_debug_start_time = smarty_core_get_microtime($_params, $this);
            $this->_smarty_debug_info[] = array('type'      => 'template',
                                                'filename'  => $resource_name,
                                                'depth'     => 0);
            $_included_tpls_idx = count($this->_smarty_debug_info) - 1;
        }

        if (!isset($compile_id)) {
            $compile_id = $this->compile_id;
        }

        $this->_compile_id = $compile_id;
        $this->_inclusion_depth = 0;

        if ($this->caching) {
            // save old cache_info, initialize cache_info
            array_push($_cache_info, $this->_cache_info);
            $this->_cache_info = array();
            $_params = array(
                'tpl_file' => $resource_name,
                'cache_id' => $cache_id,
                'compile_id' => $compile_id,
                'results' => null
            );
            require_once(SMARTY_CORE_DIR . 'core.read_cache_file.php');
            if (smarty_core_read_cache_file($_params, $this)) {
                $_smarty_results = $_params['results'];
                if (!empty($this->_cache_info['insert_tags'])) {
                    $_params = array('plugins' => $this->_cache_info['insert_tags']);
                    require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
                    smarty_core_load_plugins($_params, $this);
                    $_params = array('results' => $_smarty_results);
                    require_once(SMARTY_CORE_DIR . 'core.process_cached_inserts.php');
                    $_smarty_results = smarty_core_process_cached_inserts($_params, $this);
                }
                if (!empty($this->_cache_info['cache_serials'])) {
                    $_params = array('results' => $_smarty_results);
                    require_once(SMARTY_CORE_DIR . 'core.process_compiled_include.php');
                    $_smarty_results = smarty_core_process_compiled_include($_params, $this);
                }


                if ($display) {
                    if ($this->debugging)
                    {
                        // capture time for debugging info
                        $_params = array();
                        require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
                        $this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = smarty_core_get_microtime($_params, $this) - $_debug_start_time;
                        require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
                        $_smarty_results .= smarty_core_display_debug_console($_params, $this);
                    }
                    if ($this->cache_modified_check) {
                        $_server_vars = ($this->request_use_auto_globals) ? $_SERVER : $GLOBALS['HTTP_SERVER_VARS'];
                        $_last_modified_date = @substr($_server_vars['HTTP_IF_MODIFIED_SINCE'], 0, strpos($_server_vars['HTTP_IF_MODIFIED_SINCE'], 'GMT') + 3);
                        $_gmt_mtime = gmdate('D, d M Y H:i:s', $this->_cache_info['timestamp']).' GMT';
                        if (@count($this->_cache_info['insert_tags']) == 0
                            && !$this->_cache_serials
                            && $_gmt_mtime == $_last_modified_date) {
                            if (php_sapi_name()=='cgi')
                                header('Status: 304 Not Modified');
                            else
                                header('HTTP/1.1 304 Not Modified');

                        } else {
                            header('Last-Modified: '.$_gmt_mtime);
                            echo $_smarty_results;
                        }
                    } else {
                            echo $_smarty_results;
                    }
                    error_reporting($_smarty_old_error_level);
                    // restore initial cache_info
                    $this->_cache_info = array_pop($_cache_info);
                    return true;
                } else {
                    error_reporting($_smarty_old_error_level);
                    // restore initial cache_info
                    $this->_cache_info = array_pop($_cache_info);
                    return $_smarty_results;
                }
            } else {
                $this->_cache_info['template'][$resource_name] = true;
                if ($this->cache_modified_check && $display) {
                    header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
                }
            }
        }

        // load filters that are marked as autoload
        if (count($this->autoload_filters)) {
            foreach ($this->autoload_filters as $_filter_type => $_filters) {
                foreach ($_filters as $_filter) {
                    $this->load_filter($_filter_type, $_filter);
                }
            }
        }

        $_smarty_compile_path = $this->_get_compile_path($resource_name);

        // if we just need to display the results, don't perform output
        // buffering - for speed
        $_cache_including = $this->_cache_including;
        $this->_cache_including = false;
        if ($display && !$this->caching && count($this->_plugins['outputfilter']) == 0) {
            if ($this->_is_compiled($resource_name, $_smarty_compile_path)
                    || $this->_compile_resource($resource_name, $_smarty_compile_path))
            {
                include($_smarty_compile_path);
            }
        } else {
            ob_start();
            if ($this->_is_compiled($resource_name, $_smarty_compile_path)
                    || $this->_compile_resource($resource_name, $_smarty_compile_path))
            {
                include($_smarty_compile_path);
            }
            $_smarty_results = ob_get_contents();
            ob_end_clean();

            foreach ((array)$this->_plugins['outputfilter'] as $_output_filter) {
                $_smarty_results = call_user_func_array($_output_filter[0], array($_smarty_results, &$this));
            }
        }

        if ($this->caching) {
            $_params = array('tpl_file' => $resource_name,
                        'cache_id' => $cache_id,
                        'compile_id' => $compile_id,
                        'results' => $_smarty_results);
            require_once(SMARTY_CORE_DIR . 'core.write_cache_file.php');
            smarty_core_write_cache_file($_params, $this);
            require_once(SMARTY_CORE_DIR . 'core.process_cached_inserts.php');
            $_smarty_results = smarty_core_process_cached_inserts($_params, $this);

            if ($this->_cache_serials) {
                // strip nocache-tags from output
                $_smarty_results = preg_replace('!(\{/?nocache\:[0-9a-f]{32}#\d+\})!s'
                                                ,''
                                                ,$_smarty_results);
            }
            // restore initial cache_info
            $this->_cache_info = array_pop($_cache_info);
        }
        $this->_cache_including = $_cache_including;

        if ($display) {
            if (isset($_smarty_results)) { echo $_smarty_results; }
            if ($this->debugging) {
                // capture time for debugging info
                $_params = array();
                require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
                $this->_smarty_debug_info[$_included_tpls_idx]['exec_time'] = (smarty_core_get_microtime($_params, $this) - $_debug_start_time);
                require_once(SMARTY_CORE_DIR . 'core.display_debug_console.php');
                echo smarty_core_display_debug_console($_params, $this);
            }
            error_reporting($_smarty_old_error_level);
            return;
        } else {
            error_reporting($_smarty_old_error_level);
            if (isset($_smarty_results)) { return $_smarty_results; }
        }
    }

    /**
     * load configuration values
     *
     * @param string $file
     * @param string $section
     * @param string $scope
     */
    function config_load($file, $section = null, $scope = 'global')
    {
        require_once($this->_get_plugin_filepath('function', 'config_load'));
        smarty_function_config_load(array('file' => $file, 'section' => $section, 'scope' => $scope), $this);
    }

    /**
     * return a reference to a registered object
     *
     * @param string $name
     * @return object
     */
    function &get_registered_object($name) {
        if (!isset($this->_reg_objects[$name]))
        $this->_trigger_fatal_error("'$name' is not a registered object");

        if (!is_object($this->_reg_objects[$name][0]))
        $this->_trigger_fatal_error("registered '$name' is not an object");

        return $this->_reg_objects[$name][0];
    }

    /**
     * clear configuration values
     *
     * @param string $var
     */
    function clear_config($var = null)
    {
        if(!isset($var)) {
            // clear all values
            $this->_config = array(array('vars'  => array(),
                                         'files' => array()));
        } else {
            unset($this->_config[0]['vars'][$var]);
        }
    }

/**#@+
 * @access private
 */

    /**
     * Etc�ѥ����֤��ޤ�
     *
     * @return string|false
     */
    function _get_etc_dir()
    {
        if (is_dir($this->etc_dir)) {
            return $this->etc_dir.DIRECTORY_SEPARATOR;
        } elseif(is_dir(SMARTY_DIR.$this->etc_dir)) {
            return SMARTY_DIR.$this->etc_dir.DIRECTORY_SEPARATOR;
        } else {
            $this->trigger_error('unable to etc dir');
        }
    }
    
    /**
     * �ץ饰����Υե�����ѥ���������ޤ���
     *
     * @param string $type
     * @param string $name
     * @return string|false
     */
    function _get_plugin_filepath($type, $name)
    {
        $_params = array('type' => $type, 'name' => $name);
        require_once(SMARTY_CORE_DIR . 'core.assemble_plugin_filepath.php');
        return smarty_core_assemble_plugin_filepath($_params, $this);
    }

   /**
     * �ƥ�ץ졼�ȥ꥽����������ѥ��뤹��ɬ�פ����뤫�ɤ�����Ĵ�٤ޤ���
     *
     * @param string $resource_name
     * @param string $compile_path
     * @return boolean
     */
    function _is_compiled($resource_name, $compile_path)
    {
        if (!$this->force_compile && file_exists($compile_path)) {
            if (!$this->compile_check) {
                // no need to check compiled file
                return true;
            } else {
                // get file source and timestamp
                $_params = array('resource_name' => $resource_name, 'get_source'=>false);
                if (!$this->_fetch_resource_info($_params)) {
                    return false;
                }
                if ($_params['resource_timestamp'] <= filemtime($compile_path)) {
                    // template not expired, no recompile
                    return true;
                } else {
                    // compile template
                    return false;
                }
            }
        } else {
            // compiled template does not exist, or forced compile
            return false;
        }
    }

   /**
     * �ƥ�ץ졼�ȥ꥽�����򥳥�ѥ��뤷�ޤ���
     *
     * @param string $resource_name
     * @param string $compile_path
     * @return boolean
     */
    function _compile_resource($resource_name, $compile_path)
    {

        $_params = array('resource_name' => $resource_name);
        if (!$this->_fetch_resource_info($_params)) {
            return false;
        }

        $_source_content = $_params['source_content'];
        $_cache_include    = substr($compile_path, 0, -4).'.inc';

        if ($this->_compile_source($resource_name, $_source_content, $_compiled_content, $_cache_include)) {
            // if a _cache_serial was set, we also have to write an include-file:
            if ($this->_cache_include_info) {
                require_once(SMARTY_CORE_DIR . 'core.write_compiled_include.php');
                smarty_core_write_compiled_include(array_merge($this->_cache_include_info, array('compiled_content'=>$_compiled_content, 'resource_name'=>$resource_name)),  $this);
            }

            $_params = array('compile_path'=>$compile_path, 'compiled_content' => $_compiled_content);
            require_once(SMARTY_CORE_DIR . 'core.write_compiled_resource.php');
            smarty_core_write_compiled_resource($_params, $this);

            return true;
        } else {
            return false;
        }

    }

   /**
     * Ϳ����줿�������򥳥�ѥ��뤷�ޤ���
     *
     * @param string $resource_name
     * @param string $source_content
     * @param string $compiled_content
     * @return boolean
     */
    function _compile_source($resource_name, &$source_content, &$compiled_content, $cache_include_path=null)
    {
        if (file_exists(SMARTY_DIR . $this->compiler_file)) {
            require_once(SMARTY_DIR . $this->compiler_file);
        } else {
            // use include_path
            require_once($this->compiler_file);
        }


        $smarty_compiler = new $this->compiler_class;

        $smarty_compiler->template_dir      = $this->template_dir;
        $smarty_compiler->compile_dir       = $this->compile_dir;
        $smarty_compiler->plugins_dir       = $this->plugins_dir;
        $smarty_compiler->config_dir        = $this->config_dir;
        $smarty_compiler->force_compile     = $this->force_compile;
        $smarty_compiler->caching           = $this->caching;
        $smarty_compiler->php_handling      = $this->php_handling;
        $smarty_compiler->left_delimiter    = $this->left_delimiter;
        $smarty_compiler->right_delimiter   = $this->right_delimiter;
        $smarty_compiler->_version          = $this->_version;
        $smarty_compiler->security          = $this->security;
        $smarty_compiler->secure_dir        = $this->secure_dir;
        $smarty_compiler->security_settings = $this->security_settings;
        $smarty_compiler->trusted_dir       = $this->trusted_dir;
        $smarty_compiler->use_sub_dirs      = $this->use_sub_dirs;
        $smarty_compiler->_reg_objects      = &$this->_reg_objects;
        $smarty_compiler->_plugins          = &$this->_plugins;
        $smarty_compiler->_tpl_vars         = &$this->_tpl_vars;
        $smarty_compiler->default_modifiers = $this->default_modifiers;
        $smarty_compiler->compile_id        = $this->_compile_id;
        $smarty_compiler->_config            = $this->_config;
        $smarty_compiler->request_use_auto_globals  = $this->request_use_auto_globals;

        if (isset($cache_include_path) && isset($this->_cache_serials[$cache_include_path])) {
            $smarty_compiler->_cache_serial = $this->_cache_serials[$cache_include_path];
        }
        $smarty_compiler->_cache_include = $cache_include_path;


        $_results = $smarty_compiler->_compile_file($resource_name, $source_content, $compiled_content);

        if ($smarty_compiler->_cache_serial) {
            $this->_cache_include_info = array(
                'cache_serial'=>$smarty_compiler->_cache_serial
                ,'plugins_code'=>$smarty_compiler->_plugins_code
                ,'include_file_path' => $cache_include_path);

        } else {
            $this->_cache_include_info = null;

        }

        return $_results;
    }

    /**
     * Get the compile path for this resource
     *
     * @param string $resource_name
     * @return string results of {@link _get_auto_filename()}
     */
    function _get_compile_path($resource_name)
    {
        return $this->_get_auto_filename($this->compile_dir, $resource_name,
                                         $this->_compile_id) . '.php';
    }

    /**
     * fetch the template info. Gets timestamp, and source
     * if get_source is true
     *
     * sets $source_content to the source of the template, and
     * $resource_timestamp to its time stamp
     * @param string $resource_name
     * @param string $source_content
     * @param integer $resource_timestamp
     * @param boolean $get_source
     * @param boolean $quiet
     * @return boolean
     */

    function _fetch_resource_info(&$params)
    {
        if(!isset($params['get_source'])) { $params['get_source'] = true; }
        if(!isset($params['quiet'])) { $params['quiet'] = false; }

        $_return = false;
        $_params = array('resource_name' => $params['resource_name']) ;
        if (isset($params['resource_base_path']))
            $_params['resource_base_path'] = $params['resource_base_path'];
        else
            $_params['resource_base_path'] = $this->template_dir;

        if ($this->_parse_resource_name($_params)) {
            $_resource_type = $_params['resource_type'];
            $_resource_name = $_params['resource_name'];
            switch ($_resource_type) {
                case 'file':
                    if ($params['get_source']) {
                        $params['source_content'] = $this->_read_file($_resource_name);
                    }
                    $params['resource_timestamp'] = filemtime($_resource_name);
                    $_return = is_file($_resource_name);
                    break;

                default:
                    // call resource functions to fetch the template source and timestamp
                    if ($params['get_source']) {
                        $_source_return = isset($this->_plugins['resource'][$_resource_type]) &&
                            call_user_func_array($this->_plugins['resource'][$_resource_type][0][0],
                                                 array($_resource_name, &$params['source_content'], &$this));
                    } else {
                        $_source_return = true;
                    }

                    $_timestamp_return = isset($this->_plugins['resource'][$_resource_type]) &&
                        call_user_func_array($this->_plugins['resource'][$_resource_type][0][1],
                                             array($_resource_name, &$params['resource_timestamp'], &$this));

                    $_return = $_source_return && $_timestamp_return;
                    break;
            }
        }

        if (!$_return) {
            // see if we can get a template with the default template handler
            if (!empty($this->default_template_handler_func)) {
                if (!is_callable($this->default_template_handler_func)) {
                    $this->trigger_error("default template handler function \"$this->default_template_handler_func\" doesn't exist.");
                } else {
                    $_return = call_user_func_array(
                        $this->default_template_handler_func,
                        array($_params['resource_type'], $_params['resource_name'], &$params['source_content'], &$params['resource_timestamp'], &$this));
                }
            }
        }

        if (!$_return) {
            if (!$params['quiet']) {
                $this->trigger_error('unable to read resource: "' . $params['resource_name'] . '"');
            }
        } else if ($_return && $this->security) {
            require_once(SMARTY_CORE_DIR . 'core.is_secure.php');
            if (!smarty_core_is_secure($_params, $this)) {
                if (!$params['quiet'])
                    $this->trigger_error('(secure mode) accessing "' . $params['resource_name'] . '" is not allowed');
                $params['source_content'] = null;
                $params['resource_timestamp'] = null;
                return false;
            }
        }
        return $_return;
    }


    /**
     * parse out the type and name from the resource
     *
     * @param string $resource_base_path
     * @param string $resource_name
     * @param string $resource_type
     * @param string $resource_name
     * @return boolean
     */

    function _parse_resource_name(&$params)
    {

        // split tpl_path by the first colon
        $_resource_name_parts = explode(':', $params['resource_name'], 2);

        if (count($_resource_name_parts) == 1) {
            // no resource type given
            $params['resource_type'] = $this->default_resource_type;
            $params['resource_name'] = $_resource_name_parts[0];
        } else {
            if(strlen($_resource_name_parts[0]) == 1) {
                // 1 char is not resource type, but part of filepath
                $params['resource_type'] = $this->default_resource_type;
                $params['resource_name'] = $params['resource_name'];
            } else {
                $params['resource_type'] = $_resource_name_parts[0];
                $params['resource_name'] = $_resource_name_parts[1];
            }
        }

        if ($params['resource_type'] == 'file') {
            if (!preg_match('/^([\/\\\\]|[a-zA-Z]:[\/\\\\])/', $params['resource_name'])) {
                // relative pathname to $params['resource_base_path']
                // use the first directory where the file is found
                foreach ((array)$params['resource_base_path'] as $_curr_path) {
                    $_fullpath = $_curr_path . DIRECTORY_SEPARATOR . $params['resource_name'];
                    if (file_exists($_fullpath) && is_file($_fullpath)) {
                        $params['resource_name'] = $_fullpath;
                        return true;
                    }
                    // didn't find the file, try include_path
                    $_params = array('file_path' => $_fullpath);
                    require_once(SMARTY_CORE_DIR . 'core.get_include_path.php');
                    if(smarty_core_get_include_path($_params, $this)) {
                        $params['resource_name'] = $_params['new_file_path'];
                        return true;
                    }
                }
                return false;
            } else {
                /* absolute path */
                return file_exists($params['resource_name']);
            }
        } elseif (empty($this->_plugins['resource'][$params['resource_type']])) {
            $_params = array('type' => $params['resource_type']);
            require_once(SMARTY_CORE_DIR . 'core.load_resource_plugin.php');
            smarty_core_load_resource_plugin($_params, $this);
        }

        return true;
    }


    /**
     * Handle modifiers
     *
     * @param string|null $modifier_name
     * @param array|null $map_array
     * @return string result of modifiers
     */
    function _run_mod_handler()
    {
        $_args = func_get_args();
        list($_modifier_name, $_map_array) = array_splice($_args, 0, 2);
        list($_func_name, $_tpl_file, $_tpl_line) =
            $this->_plugins['modifier'][$_modifier_name];

        $_var = $_args[0];
        foreach ($_var as $_key => $_val) {
            $_args[0] = $_val;
            $_var[$_key] = call_user_func_array($_func_name, $_args);
        }
        return $_var;
    }

    /**
     * Remove starting and ending quotes from the string
     *
     * @param string $string
     * @return string
     */
    function _dequote($string)
    {
        if ((substr($string, 0, 1) == "'" || substr($string, 0, 1) == '"') &&
            substr($string, -1) == substr($string, 0, 1))
            return substr($string, 1, -1);
        else
            return $string;
    }


    /**
     * �ƥ�ץ졼�ȥե�������ɤ߹���
     *
     * @since 2005/06/11 12:01
     * @param string $filename
     * @return string
     */
     function _read_file($filename){
          if (file_exists($filename) && ($handle = @fopen($filename, "r"))) {
               $contents = preg_replace("~%%%(.*?)%%%~","",mb_convert_encoding(fread($handle, filesize($filename)), mb_internal_encoding(), "AUTO"));
               fclose($handle);
               return $contents;
          } else {
               return false;
          }
     }

    /**
     * get a concrete filename for automagically created content
     *
     * @param string $auto_base
     * @param string $auto_source
     * @param string $auto_id
     * @return string
     * @staticvar string|null
     * @staticvar string|null
     */
    function _get_auto_filename($auto_base, $auto_source = null, $auto_id = null)
    {
        $_compile_dir_sep =  $this->use_sub_dirs ? DIRECTORY_SEPARATOR : '^';
        $_return = $auto_base . DIRECTORY_SEPARATOR;

        if(isset($auto_id)) {
            // make auto_id safe for directory names
            $auto_id = str_replace('%7C',$_compile_dir_sep,(urlencode($auto_id)));
            // split into separate directories
            $_return .= $auto_id . $_compile_dir_sep;
        }

        if(isset($auto_source)) {
            // make source name safe for filename
            $_filename = urlencode(basename($auto_source));
            $_crc32 = sprintf('%08X', crc32($auto_source));
            // prepend %% to avoid name conflicts with
            // with $params['auto_id'] names
            $_crc32 = substr($_crc32, 0, 2) . $_compile_dir_sep .
                      substr($_crc32, 0, 3) . $_compile_dir_sep . $_crc32;
            $_return .= '%%' . $_crc32 . '%%' . $_filename;
        }

        return $_return;
    }

    /**
     * unlink a file, possibly using expiration time
     *
     * @param string $resource
     * @param integer $exp_time
     */
    function _unlink($resource, $exp_time = null)
    {
        if(isset($exp_time)) {
            if(time() - @filemtime($resource) >= $exp_time) {
                return @unlink($resource);
            }
        } else {
            return @unlink($resource);
        }
    }

    /**
     * returns an auto_id for auto-file-functions
     *
     * @param string $cache_id
     * @param string $compile_id
     * @return string|null
     */
    function _get_auto_id($cache_id=null, $compile_id=null) {
    if (isset($cache_id))
        return (isset($compile_id)) ? $cache_id . '|' . $compile_id  : $cache_id;
    elseif(isset($compile_id))
        return $compile_id;
    else
        return null;
    }

    /**
     * trigger Smarty plugin error
     *
     * @param string $error_msg
     * @param string $tpl_file
     * @param integer $tpl_line
     * @param string $file
     * @param integer $line
     * @param integer $error_type
     */
    function _trigger_fatal_error($error_msg, $tpl_file = null, $tpl_line = null,
            $file = null, $line = null, $error_type = E_USER_ERROR)
    {
        if(isset($file) && isset($line)) {
            $info = ' ('.basename($file).", line $line)";
        } else {
            $info = '';
        }
        if (isset($tpl_line) && isset($tpl_file)) {
            $this->trigger_error('[in ' . $tpl_file . ' line ' . $tpl_line . "]: $error_msg$info", $error_type);
        } else {
            $this->trigger_error($error_msg . $info, $error_type);
        }
    }


    /**
     * callback function for preg_replace, to call a non-cacheable block
     * @return string
     */
    function _process_compiled_include_callback($match) {
        $_func = '_smarty_tplfunc_'.$match[2].'_'.$match[3];
        ob_start();
        $_func($this);
        $_ret = ob_get_contents();
        ob_end_clean();
        return $_ret;
    }


    /**
     * called for included templates
     *
     * @param string $_smarty_include_tpl_file
     * @param string $_smarty_include_vars
     */

    // $_smarty_include_tpl_file, $_smarty_include_vars

    function _smarty_include($params)
    {
        if ($this->debugging) {
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $debug_start_time = smarty_core_get_microtime($_params, $this);
            $this->_smarty_debug_info[] = array('type'      => 'template',
                                                  'filename'  => $params['smarty_include_tpl_file'],
                                                  'depth'     => ++$this->_inclusion_depth);
            $included_tpls_idx = count($this->_smarty_debug_info) - 1;
        }

        $this->_tpl_vars = array_merge($this->_tpl_vars, $params['smarty_include_vars']);

        // config vars are treated as local, so push a copy of the
        // current ones onto the front of the stack
        array_unshift($this->_config, $this->_config[0]);

        $_smarty_compile_path = $this->_get_compile_path($params['smarty_include_tpl_file']);


        if ($this->_is_compiled($params['smarty_include_tpl_file'], $_smarty_compile_path)
            || $this->_compile_resource($params['smarty_include_tpl_file'], $_smarty_compile_path))
        {
            include($_smarty_compile_path);
        }

        // pop the local vars off the front of the stack
        array_shift($this->_config);

        $this->_inclusion_depth--;

        if ($this->debugging) {
            // capture time for debugging info
            $_params = array();
            require_once(SMARTY_CORE_DIR . 'core.get_microtime.php');
            $this->_smarty_debug_info[$included_tpls_idx]['exec_time'] = smarty_core_get_microtime($_params, $this) - $debug_start_time;
        }

        if ($this->caching) {
            $this->_cache_info['template'][$params['smarty_include_tpl_file']] = true;
        }
    }


    /**
     * get or set an array of cached attributes for function that is
     * not cacheable
     * @return array
     */
    function &_smarty_cache_attrs($cache_serial, $count) {
        $_cache_attrs =& $this->_cache_info['cache_attrs'][$cache_serial][$count];

        if ($this->_cache_including) {
            /* return next set of cache_attrs */
            $_return = current($_cache_attrs);
            next($_cache_attrs);
            return $_return;

        } else {
            /* add a reference to a new set of cache_attrs */
            $_cache_attrs[] = array();
            return $_cache_attrs[count($_cache_attrs)-1];

        }

    }


    /**
     * include()�Υ�åѡ��Ǥ���
     *
     * @return mixed
     */
    function _include($filename, $once=false, $params=null)
    {
        if ($once) {
            return include_once($filename);
        } else {
            return include($filename);
        }
    }


    /**
     * eval()�Υ�åѡ��Ǥ���
     *
     * @return mixed
     */
    function _eval($code, $params=null)
    {
        return eval($code);
    }
    /**#@-*/

}

?>