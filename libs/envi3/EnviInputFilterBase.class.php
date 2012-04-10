<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * EnviInputFilter基底クラス
 *
 * @abstract
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVCCore
 */
abstract class EnviInputFilterBase
{

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @params
     * @return void
     */
    public function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * 一番初めに呼ばれる、メソッド
     *
     * @return bool falseを返すと、そこで処理が止まります。
     * @abstract
     */
    public function initialize()
    {
        return true;
    }

    /**
     * フィルタの実行
     *
     *
     * @abstract
     */
    public function execute()
    {
    }

}