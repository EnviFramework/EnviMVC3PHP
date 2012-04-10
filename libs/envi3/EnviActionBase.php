<?php
/**
 * @package Envi3
 * @subpackage EnviMVCCore
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * アクション基底クラス
 *
 * @abstract
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVCCore
 */
abstract class EnviActionBase
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
     * validate()でEnvi::SUCCESSもしくはtrueが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function execute()
    {
        return Envi::SUCCESS;
    }

    /**
     * Viewに移る前に実行される処理。Killされない限りは、NONEやfalseを返しても実行される
     *
     * @see validate()
     * @abstract
     */
    public function shutdown()
    {
        return true;
    }


    /**
     * バリデートする
     *
     * バリデータを通して、処理を分岐させる。
     *
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     *
     * @abstract
     */
    public function validate()
    {
        return true;
    }

    /**
     * validate()でEnvi::DEFAULTが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function defaultAccess()
    {
        return Envi::DEFAULT_ACCESS;
    }

    /**
     * validate()でEnvi::ERRORもしくはfalseが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function handleError()
    {
        return Envi::ERROR;
    }

    /**
     * セキュアなページかどうか。
     *
     * @abstract
     */
    public function isSecure()
    {
        return false;
    }

    /**
     * Controllerから直接呼ばれるアクションかどうか？
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return false;
    }

    /**
     * SSLでのみアクセスされるページかどうか？
     *
     * @return boolean
     */
    public function isSSL()
    {
        return false;
    }

}
