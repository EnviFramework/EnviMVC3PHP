<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * Proxyのチェック
 *
 * @package Envi
 * @sinse 0.1
 */
class EnviCheckproxy
{
    public $check=0;

    public function __construct()
    {
        if (isset($_SERVER["HTTP_VIA"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_CACHE_INFO"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_SP_HOST"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_FORWARDED"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $this->check += 1;
        }
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $this->check += 1;
        }
        $remote_addr = @gethostbyaddr($_SERVER["REMOTE_ADDR"]);
        if (stristr($remote_addr,"prox")!==FALSE) {
            $this->check += 3;
        }
        if (stristr($remote_addr,"squid")!==FALSE) {
            $this->check += 3;
        }
        if (stristr($remote_addr,"cache")!==FALSE) {
            $this->check += 3;
        }
        if (stristr($remote_addr,"www")!==FALSE) {
            $this->check += 3;
        }
        if (stristr($remote_addr,"firewall")!==FALSE) {
            $this->check += 3;
        }
        if (stristr($remote_addr,"dns")!==FALSE) {
            $this->check += 3;
        }
    }
}
