<?php
/**
 * EnviInputFilter基底クラス
 *
 * EnviInputFilterは、ルーティング後、初めてのアクションが実行される前に実行されます。
 *
 * すべてのアクションで実行されるため、たとえば、
 *
 * * メンテナンス時のSorry画面へのリダイレクト
 * * ログインセッションと、ユーザーデータの管理
 * * アクセス制限
 *
 * 等を記述することで、処理を簡素化出来ます。
 *
 * InputFilterは、EnviInputFilterBaseを継承し、execute()メソッドをオーバーライドする事で、実装可能です。
 *
 *
 * インストール・設定
 * --------------------------------------------------
 * Envi デフォルトで動作しますが、使用するフィルターは、コンフィグファイルに記述する必要があります。
 *
 * 詳しくは、[基本リファレンス->入力フィルタ](/c/man/v3/core/input_filter)を参照してください。
 *
 *
 * PHP versions 5
 *
 *
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage InputFilter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 * @subpackage_main
 */


/**
 * EnviInputFilter基底クラス
 *
 * InputFilter基底クラスです。
 * InputFilterを作成する場合は、必ず継承してください。
 *
 * @abstract
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage InputFilter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @subpackage_main
 */
abstract class EnviInputFilterBase
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
     * @return void
     */
    public function execute()
    {
    }
    /* ----------------------------------------- */

}
