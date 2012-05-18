<?php
/**
 * OutFilter基底クラス
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * OutFilter基底クラス
 *
 * @abstract
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVCCore
 */
abstract class EnviOutputFilterBase
{

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @param
     * @return void
     */
    public function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * +-- 一番初めに呼ばれる、メソッド
     *
     * falseを返すと、そこで処理が止まります。
     *
     * @access public
     * @return boolean
     */
    public function initialize()
    {
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- フィルタの実行
     *
     * @access public
     * @param staring &$contents
     * @return void
     */
    public function execute(&$contents)
    {
    }
    /* ----------------------------------------- */
}