<?php
/**
 * OutputFilter基底クラス
 *
 *
 * EnviOutputFilterは、リクエストアクションの実行後に実行されます。
 *
 * [forward](/c/man/v3/reference/Envi3/Controller/EnviController/forward)や、[actionChain](t/c/man/v3/core/action_chain)での実行時には、実行されません。
 *
 * より正確には、ビュークラスのshutdownよりも後の実行で、最後に実行されるクラスとなります。
 *
 * その特性上、
 *
 * * DB接続の切断
 * * Temporaryデータの削除
 *
 * 等の処理と相性がよいです。
 *
 *
 * OutputFilterは、EnviInputFilterBaseを継承し、execute()メソッドをオーバーライドする事で、実装可能です。
 *
 * execute()は&$contentsと言う引数を一つだけ取ります。
 *
 * $contentsには、最終的に画面に出力されるデータが格納されています。
 * 上書きをする事で、最終的に、画面に出力されるデータを変更できます。
 *
 * インストール・設定
 * --------------------------------------------------
 * Envi デフォルトで動作しますが、使用するフィルターは、コンフィグファイルに記述する必要があります。
 *
 * 詳しくは、[基本リファレンス->出力フィルタ](/c/man/v3/core/output_filter)を参照してください。
 *
 *
 *
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage OutputFilter
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
 * OutputFilter基底クラス
 *
 * OutputFilter基底クラスです。
 * OutputFilterを作成する場合は、必ず継承してください。
 *
 * @abstract
 * @category   EnviMVC拡張
 * @package    フィルタ
 * @subpackage OutputFilter
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @subpackage_main
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
     * @param staring $contents
     * @return void
     */
    public function execute(&$contents)
    {
    }
    /* ----------------------------------------- */
}
