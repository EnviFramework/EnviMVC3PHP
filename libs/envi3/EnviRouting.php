<?php
/**
 * EnviMVCのルーティング処理
 *
 * EnviMVCのルーティングを変更します。
 *
 * ルーティングクラスは、必ず、EnviRouterBaseを継承し、作成して下さい。
 * 設定は、Routingディレクティブ内で行って下さい。
 * 作成しない場合は、デフォルトのルーティングを行います。
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
 * EnviMVCのルーティング処理
 *
 * EnviMVCのルーティングを変更します。
 *
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
 * @since      File available since Release 3.4.0
 * @subpackage_main
 */
class EnviRouting
{
    private $_ext_path_info = array();
    private $_i18n = '';
    private $_request_module_name = '';
    private $_request_action_name = '';

    /**
     * +-- Routingの実行
     *
     * @access      public
     * @return      void
     */
    public function run()
    {
        $_system_conf = Envi::singleton()->getConfigurationAll();
        if (isset($_system_conf['Routing']) || is_array($_system_conf['Routing'])) {
            foreach ($_system_conf['Routing'] as $item) {
                if (!class_exists($item['class_name'], false)) {
                    include $item['resource'];
                }
                $class_name = $item['class_name'];
                $router = new $class_name;
                $initialize_res = $router->initialize($this->_i18n, $this->_request_module_name, $this->_request_action_name, $this->_ext_path_info);
                if ($initialize_res === false) {
                    return;
                }
                $this->_i18n = $router->getI18n();
                $this->_request_module_name = $router->getRequestModule();
                $this->_request_action_name = $router->getRequestAction();
                $this->_ext_path_info = $router->getPathInfo();
                $shutdown_res = $router->shutdown($this->_i18n, $this->_request_module_name, $this->_request_action_name, $this->_ext_path_info);
                if (!$shutdown_res === false) {
                    return;
                }
            }
        }
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


/**
 * EnviMVCのルーティング処理基底クラス
 *
 * すべてのRouterで継承して下さい。
 *
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
 * @since      File available since Release 3.4.0
 */
abstract class EnviRouterBase
{
    /**
     * +-- 初期化する
     *
     * falseを返すと、ルーティングを終了する
     *
     * @access      public
     * @param       string $i18n          現在のi18n
     * @param       string $module_name   現在のmodule_name
     * @param       string $action_name   現在のaction_name
     * @param       string $exp_path_info 現在のexp_path_info
     * @return      boolean
     */
    public function initialize($i18n, $module_name, $action_name, $exp_path_info)
    {
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 終了処理をする
     *
     * falseを返すと、ルーティングを終了する
     *
     * @access      public
     * @param       string $i18n          現在のi18n
     * @param       string $module_name   現在のmodule_name
     * @param       string $action_name   現在のaction_name
     * @param       string $exp_path_info 現在のexp_path_info
     * @return      boolean
     */
    public function shutdown($i18n, $module_name, $action_name, $exp_path_info)
    {
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- リクエストされたモジュールを取得する
     *
     * @access      public
     * @return      string
     */
    abstract public function getRequestModule();
    /* ----------------------------------------- */

    /**
     * +-- リクエストされたアクションを取得する
     *
     * @access      public
     * @return      string
     */
    abstract public function getRequestAction();
    /* ----------------------------------------- */

    /**
     * +-- 国際化情報を取得する
     *
     * @access      public
     * @return      string
     */
    abstract public function getI18n();
    /* ----------------------------------------- */

    /**
     * +-- 残りのpath_infoを取得する
     *
     * @access      public
     * @return      array
     */
    abstract public function getPathInfo();
    /* ----------------------------------------- */
}
