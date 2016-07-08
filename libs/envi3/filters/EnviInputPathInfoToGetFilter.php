<?php
/**
 * 余剰のパスインフォを$_GET扱いに
 *
 * 余剰のパスインフォを$_GET扱いに
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage InputFilter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
 */


/**
 * 余剰のパスインフォを$_GET扱いに
 *
 * 余剰のパスインフォを$_GET扱いに
 *
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage InputFilter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      Class available since Release 1.0.0
 */
class EnviInputPathInfoToGetFilter extends EnviInputFilterBase
{

    /**
     * +-- フィルタの実行
     *
     * @access public
     * @return void
     */
    public function execute()
    {
        $exp_path_info = EnviRequest::getPathInfo();
        if (count($exp_path_info)) {
            while (count($exp_path_info)) {
                $k = array_shift($exp_path_info);
                $v = array_shift($exp_path_info);
                if (!$k) {
                    continue;
                }
                $_GET[$k] = $v;
            }
        }
    }
    /* ----------------------------------------- */
}
