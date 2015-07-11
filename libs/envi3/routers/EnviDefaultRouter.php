<?php
/**
 * EnviMVCのルーティング処理
 *
 * EnviMVCのルーティングを変更します。
 *
 * PHP versions 5
 *
 *
 * @category   フレームワーク基礎処理
 * @package    Envi3
 * @subpackage Routing
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.4.0
 * @subpackage_main
 */



/**
 * デフォルトのルーティング処理を行います
 *
 * EnviMVCデフォルトのルーティング処理を行います
 *
 * @category   フレームワーク基礎処理
 * @package    Envi3
 * @subpackage Routing
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
class EnviDefaultRouter extends EnviRouterBase
{
    private $_ext_path_info = array();
    private $_i18n = '';
    private $_request_module_name = '';
    private $_request_action_name = '';

    /**
     * +-- 初期化
     *
     * @access      public
     * @param       string $i18n
     * @param       string $module_name
     * @param       string $action_name
     * @param       array $exp_path_info
     * @return      void
     */
    public function initialize($i18n, $module_name, $action_name, $exp_path_info)
    {
        $_system_conf = Envi::singleton()->getConfigurationAll();

        // デフォルト指定
        $this->_request_module_name = $_system_conf['SYSTEM']['default_module'];
        $this->_request_action_name = $_system_conf['SYSTEM']['default_action'];
        $this->_i18n                = $_system_conf['SYSTEM']['default_i18n'];
        if (!isset($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] === '/') {
            return true;
        }

        $exp_path_info = explode('/', $_SERVER['PATH_INFO']);

        // 先頭は空になるから削除
        array_shift($exp_path_info);

        // 国際化を使うときは、はじめのパスインフォがi18n
        if ($_system_conf['SYSTEM']['use_i18n']) {
            $this->_i18n = array_shift($exp_path_info);
            if (!isset($_system_conf['I18N'][$this->_i18n])) {
                throw Envi404Exception('404 Error', 20001);
            }
        }

        // モジュール名
        if (count($exp_path_info)) {
            $this->_request_module_name = array_shift($exp_path_info);
        }
        // アクション名
        if (count($exp_path_info) && $exp_path_info[0] !== '') {
            $this->_request_action_name = preg_replace("/\\.".$_system_conf['SYSTEM']['ext'].'$/', '', array_shift($exp_path_info));
        }
        $this->_ext_path_info = $exp_path_info;
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- リクエストされたモジュールを取得する
     *
     * @access      public
     * @return      string
     */
    public function getRequestModule()
    {
        return $this->_request_module_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- リクエストされたアクションを取得する
     *
     * @access      public
     * @return      string
     */
    public function getRequestAction()
    {
        return $this->_request_action_name;
    }
    /* ----------------------------------------- */

    /**
     * +-- 国際化情報を取得する
     *
     * @access      public
     * @return      string
     */
    public function getI18n()
    {
        return $this->_i18n;
    }
    /* ----------------------------------------- */

    /**
     * +-- 残りのpath_infoを取得する
     *
     * @access      public
     * @return      array
     */
    public function getPathInfo()
    {
        return $this->_ext_path_info;
    }
    /* ----------------------------------------- */
}
