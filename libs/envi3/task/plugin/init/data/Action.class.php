<?php
/**
 *
 *
 * PHP versions 5
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    GIT: $Id$
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @since      File available since Release 1.0.0
 */

// config.phpでロードされるため
// require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'actions.class.php';

/**
 *
 *
 * @category   %%project_category%%
 * @package    %%project_name%%
 * @subpackage
 * @author     %%your_name%% <%%your_email%%>
 * @copyright  %%your_project%%
 * @license    %%your_license%%
 * @version    Release: @package_version@
 * @link       %%your_link%%
 * @see        %%your_see%%
 * @since      Class available since Release 1.0.0
 */
class %%action_name%%Action extends %%module_name%%Actions
{


    /**
     * +-- 一番初めに呼ばれる、メソッド
     *
     *
     * @return bool falseを返すと、そこで処理が止まります。
     */
    public function initialize()
    {
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +--Viewに移る前に実行される処理。Killされない限りは、NONEやfalseを返しても実行される
     *
     *
     * @return boolean
     */
    public function shutdown()
    {
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- バリデートする
     *
     * バリデータを通して、処理を分岐させる。
     *
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function validate()
    {
        $validator = validator();

        $res = $validator->executeAll();
        if ($validator->isError($res)) {
            return false;
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- validate()でEnvi::SUCCESSもしくはtrueが返った場合の処理。
     *
     * @see validate()
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function execute()
    {
        %%return_str%%
    }
    /* ----------------------------------------- */


    /**
     * +--validate()でEnvi::DEFAULTが返った場合の処理。
     *
     *
     * @see validate()
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function defaultAccess()
    {
        return Envi::DEFAULT_ACCESS;
    }
    /* ----------------------------------------- */

    /**
     * +--validate()でEnvi::ERRORもしくはfalseが返った場合の処理。
     *
     *
     * @see validate()
     * @return Envi::DEFAULT | Envi::ERROR | Envi::SUCCESS | boolean
     */
    public function handleError()
    {
        return Envi::ERROR;
    }
    /* ----------------------------------------- */

    /**
     * +--セキュアなページかどうか。
     *
     *
     * @return boolean
     */
    public function isSecure()
    {
        return false;
    }
    /* ----------------------------------------- */

    /**
     * +--Controllerから直接呼ばれるアクションかどうか？
     *
     *
     * @return boolean
     */
    public function isPrivate()
    {
        return false;
    }
    /* ----------------------------------------- */

    /**
     * +--SSLでのみアクセスされるページかどうか？
     *
     *
     * @return boolean
     */
    public function isSSL()
    {
        return false;
    }
    /* ----------------------------------------- */

}