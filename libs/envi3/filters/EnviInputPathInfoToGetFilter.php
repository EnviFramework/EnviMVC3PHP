<?php
/**
 * 余剰のパスインフォを$_GET扱いに
 *
 * 余剰のパスインフォを$_GET扱いに
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */


/**
 * 余剰のパスインフォを$_GET扱いに
 *
 * 余剰のパスインフォを$_GET扱いに
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
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
        $exp_path_info = Request::getPathInfo();
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
