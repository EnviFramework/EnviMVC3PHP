<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * 下位互換用
 *
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviDBI
{
    public static function getConnection($db_key)
    {
        return extension()->DBConnection()->getInstance($db_key);
    }
}
