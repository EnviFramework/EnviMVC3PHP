<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @sinse 0.1
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

function EnviServerStatus()
{
    return EnviServerStatus::singleton();
}
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviServerStatus
{
    const DEVELOPER  = 'dev';
    const STAGE      = 'stg';
    const PRODUCTION = 'prod';

    private $_stutus_conf;
    private static  $instance;

    private function __construct()
    {
        $this->_stutus_conf = file_get_contents(ENVI_SERVER_STATUS_CONF);
    }

    public static function &singleton()
    {
        if (!isset(self::$instance)) {
            self::$instance = new EnviServerStatus();
        }
        return self::$instance;
    }

    /**
     * サーバーステータスを取得する
     * @return int
     */
    public function getServerStatus()
    {
        return $this->_stutus_conf;
    }

}

