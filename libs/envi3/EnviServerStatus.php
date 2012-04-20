<?php
/**
 * サーバーステータスの取得
 *
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
if (!defined('ENVI_SERVER_STATUS_CONF')) {
    define('ENVI_SERVER_STATUS_CONF',
        realpath(dirname(__FILE__)
            .DIRECTORY_SEPARATOR
            .'..'
            .DIRECTORY_SEPARATOR
            .'..'
            .DIRECTORY_SEPARATOR
            .'env'
            .DIRECTORY_SEPARATOR
            .'ServerStatus.conf'
        )
    );
}

/**
 * +-- シングルトン用
 *
 * @return EnviServerStatus
 */
function EnviServerStatus()
{
    return EnviServerStatus::singleton();
}
/* ----------------------------------------- */

/**
 * サーバーステータスの取得
 *
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviServerStatus
{
    const DEVELOPER  = 'dev';
    const STAGE      = 'stg';
    const PRODUCTION = 'prod';

    private $_stutus_conf;
    private static  $instance;
    /**
     * +-- コンストラクタ
     *
     * @access private
     * @return void
     */
    private function __construct()
    {
        $this->_stutus_conf = file_get_contents(ENVI_SERVER_STATUS_CONF);
    }
    /* ----------------------------------------- */

    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @return EnviServerStatus
     */
    public static function &singleton()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EnviServerStatus();
        }
        return self::$instance;
    }
    /* ----------------------------------------- */

    /**
     * サーバーステータスを取得する
     * @return int
     */
    public function getServerStatus()
    {
        return $this->_stutus_conf;
    }

}

