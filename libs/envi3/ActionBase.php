<?php
/**
 * @package Envi3
 * @subpackage EnviMVC
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */


/**
 * アクション基底クラス
 *
 * @abstract
 * @since 0.1
 * @package Envi3
 * @subpackage EnviMVC
 */
abstract class Envi_ActionBase
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
     * validate()でENVI_MVC_SUCCESSが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function execute()
    {
        return ENVI_MVC_SUCCESS;
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
     * @return ENVI_MVC_DEFAULT | ENVI_MVC_ERROR | ENVI_MVC_SUCCESS
     *
     * @abstract
     */
    public function validate()
    {
        return true;
    }

    /**
     * validate()でENVI_MVC_DEFAULTが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function defaultAccess()
    {
        return ENVI_MVC_DEFAULT;
    }

    /**
     * validate()でENVI_MVC_ERRORが返った場合の処理。
     *
     * @see validate()
     * @abstract
     */
    public function handleError()
    {
        return ENVI_MVC_ERROR;
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
