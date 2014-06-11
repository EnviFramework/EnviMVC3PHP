<?php
/**
 * アクションコントローラー基底クラス
 *
 * アクションコントローラーの基底クラスです。
 *
 * アクションコントローラーを書くときは必ずこのクラスを継承して下さい。
 *
 * 通常であれば、このクラスを直接継承することは無く、`envi init-app`によって生成される、actionBaseを介して継承されます。
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage ActionController
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 */


/**
 * アクションコントローラー基底クラス
 *
 * アクションコントローラーの基底クラスです。
 *
 * アクションコントローラーを書くときは必ずこのクラスを継承して下さい。
 *
 * 通常であれば、このクラスを直接継承することは無く、`envi init-app`によって生成される、actionBaseを介して継承されます。
 *
 * @abstract
 * @category   MVC
 * @package    Envi3
 * @subpackage ActionController
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
abstract class EnviActionBase
{
    /**
     * +-- コンストラクタ
     *
     * @abstract
     * @access public
     * @return void
    */
    public function __construct()
    {
    }
    /* ----------------------------------------- */

    /**
     * 一番初めに呼ばれる、メソッド
     *
     * @abstract
     * @return bool falseを返すと、そこで処理が止まります。
     */
    public function initialize()
    {
        return true;
    }

    /**
     * validate()でEnvi::SUCCESSもしくはtrueが返った場合の処理。
     *
     * @abstract
     * @see validate()
     * @return Envi::DEFAULT_ACCESS | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function execute()
    {
        return Envi::SUCCESS;
    }

    /**
     * Viewに移る前に実行される処理。Killされない限りは、NONEやfalseを返しても実行される
     *
     * @abstract
     * @return boolean
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
     * @abstract
     * @return Envi::DEFAULT_ACCESS | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function validate()
    {
        return true;
    }

    /**
     * validate()でEnvi::DEFAULT_ACCESSが返った場合の処理。
     *
     * @abstract
     * @see validate()
     * @return Envi::DEFAULT_ACCESS | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function defaultAccess()
    {
        return Envi::DEFAULT_ACCESS;
    }

    /**
     * validate()でEnvi::ERRORもしくはfalseが返った場合の処理。
     *
     * @abstract
     * @see validate()
     * @return Envi::DEFAULT_ACCESS | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function handleError()
    {
        return Envi::ERROR;
    }

    /**
     * セキュアなページかどうか
     *
     * [EnviUser::isLogin()](/c/man/v3/reference/EnviUser/EnviUser/isLogin)がtrueの場合のみ、
     * アクセス可能なアクションコントローラーとして定義します。
     *
     * 制限に引っかかった場合は、Envi403Exceptionを発行し、403ヘッダを出力します。
     *
     * @abstract
     * @return boolean
     */
    public function isSecure()
    {
        return false;
    }

    /**
     * Controllerから直接呼ばれるアクションかどうか？
     *
     * ディスパッチャーから直接アクセスされず、
     * [EnviController::forward()](/c/man/v3/reference/EnviController/EnviController/forward)や、
     * [アクションチェイン](/c/man/v3/core/action_chain)でのみアクセス可能なアクションコントローラーとして定義されます。
     *
     * 制限に引っかかった場合は、Envi404Exceptionを発行し、404ヘッダを出力します。
     *
     *
     * @abstract
     * @return boolean
     */
    public function isPrivate()
    {
        return false;
    }

    /**
     * SSLでのみアクセスされるページかどうか？
     *
     * @abstract
     * @return boolean
     */
    public function isSSL()
    {
        return false;
    }

}
