<?php
/**
 * アクション基底クラス
 *
 * アクションを書くときは必ずこのクラスを継承すること。
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $ Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */


/**
 * アクション基底クラス
 *
 * アクションを書くときは必ずこのクラスを継承すること。
 *
 * @abstract
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
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
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
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
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function validate()
    {
        return true;
    }

    /**
     * validate()でEnvi::DEFAULTが返った場合の処理。
     *
     * @abstract
     * @see validate()
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
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
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function handleError()
    {
        return Envi::ERROR;
    }

    /**
     * セキュアなページかどうか。
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
