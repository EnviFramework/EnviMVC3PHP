<?php
/**
 * アウトプットFilterサンプルクラス
 * @package Envi3
 * @subpackage EnviMVC
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * アウトプットFilterサンプルクラス
 *
 * @abstract
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVC
 */
class EnviOutputFilter extends EnviOutputFilterBase
{

    /**
     * フィルタの実行
     *
     *
     * @abstract
     */
    public function execute(&$contents)
    {
    }

}
