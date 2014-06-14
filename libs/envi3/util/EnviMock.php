<?php
/**
 * テストスタブ
 *
 * EnviMock の `getMock($class_name)` メソッドを使うと、指定したクラスのモッククラスを作成したり、特定のメソッドだけモックに置き換える、スタブが出来きるようになります。
 *
 * `getMock($className)`がコールされたときの状況に応じて、EnviMockは挙動を変えます。
 * 具体的には、
 *
 * $class_nameと言うクラスが存在する
 * : 該当クラスを部分的に書き換える方法を提供する
 *
 * $class_nameと言うクラスが存在しない
 * : 空の$class_nameを定義し、モッククラスとして動作させる
 *
 * と言った形です。
 *
 * 動作環境
 * -----------------------------------------------
 *
 * 現在のバージョンでは、[runkit](http://pecl.php.net/package-changelog.php?package=runkit)拡張モジュールが必要です。
 *
 * 今後のバージョンで、PHP5.3以降において、runkitを使用しない実装が検討されています。
 *
 *
 * モッククラス
 * -----------------------------------------------
 * デフォルトでは、すべてのメソッドが 単に NULL を返すだけのダミー実装になります。
 * たとえば andReturn($this->returnValue()) メソッドを使うと、 ダミー実装がコールされたときに値を返すよう設定することができます。
 *
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.alert .alert-info}
 * __※__ final, private および static メソッドのスタブやモックは作れないことに注意しましょう。
 * EnviMock のテストダブル機能ではこれらを無視し、元のメソッドの振る舞いをそのまま維持します。
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 *
 *
 * テストスタブ
 * -----------------------------------------------
 *
 * 実際のオブジェクトを置き換えて、 設定した何らかの値を (オプションで) 返すようなテストダブルのことを スタブ といいます。
 * スタブ を使うと、依存している実際のクラスを書き換え、依存先の入力を間接的に管理できます。
 *
 *
 *
 * ~~~~~~~~~~~~~~~~~~~~~ {.alert .alert-danger}
 *   __注意：__
 * テストスタブを使うと、実際のクラスが書き換えられて動作します。
 *
 * `EnviMockEditor::restoreAll()`や`EnviMockEditor::restoreAll($method_name)`等のメソッドによって戻されるまで、書き換えられ続けます。
 *
 * また、レストアできるのは、書き換えたEnviMockEditor*クラスのみであることに注意して下さい。
 *
 * `EnviMock::getMock($className)`で同じクラス名を指定したとしても、restoreすることが出来無いと言うことです。
 *
 * ~~~~~~~~~~~~~~~~~~~~~
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 * @subpackage_main
 */


require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviMockEditor.php';
require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviMockEditorRunkit.php';

/**
 * 簡易的なモックテストを提供します。
 *
 * EnviMockは、簡易的にモックテストを提供します。
 *
 *
 * EnviMockは、それ自身でオブジェクトを生成しません。
 *
 * たとえば、下記のようなコードはエラーとなります。
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.php_code .code}
 * <?php
 * $mok = new EnviMock;
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 *
 * EnviMock::mock('クラス名');
 *
 * による、EnviMockEditorの生成のみをサポートします。
 *
 * テストモックに対する実際の処理は、EnviMockEditorによって行われます。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 3.3.3.2
 */
class EnviMock
{

    /**
     * +-- コンストラクタ
     *
     * static クラスなので、privateコンストラクタ
     *
     * @access      private
     * @return      void
     * @doc_ignore
     */
    private function __construct()
    {

    }
    /* ----------------------------------------- */

    /**
     * +-- モックの取得
     *
     * EnviMockEditorによる、モックテストを開始します。
     *
     * 定義済みのクラスを指定した場合は、スタブ可能なモックテストに、
     *
     * 未定義のクラスを指定した場合は、完全なモックを提供します。
     *
     * @access      public
     * @static
     * @param       string $class_name モックを作成するクラス名
     * @return      EnviMockEditor モック操作オブジェクト
     */
    public static function mock($class_name)
    {
        if (!extension_loaded('runkit')) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $res = dl('runkit.dll');
            } else {
                $res = dl('runkit.so');
            }
            if ($res) {
                throw new Exception('please install runkit.http://pecl.php.net/package-changelog.php?package=runkit');
            }
        }

        if (!class_exists($class_name, false)) {
            self::addMockClass($class_name);
        }
        $mock_editor = new EnviMockEditorRunkit($class_name);
        return $mock_editor;
    }
    /* ----------------------------------------- */


    /**
     * +-- モッククラスの作成
     *
     * @access      public
     * @static
     * @param       string $class_name
     * @return      void
     */
    private static function addMockClass($class_name)
    {
        $cf = tmpfile();
        $file_path = stream_get_meta_data($cf);
        $file_path = $file_path['uri'];
        fwrite($cf, '<?php
        class '.$class_name.' extends EnviMockBlankBase
        {
        }'
        );
        include $file_path;
    }
    /* ----------------------------------------- */
}
/* ----------------------------------------- */





/**
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @doc_ignore
 */
abstract class EnviMockBlankBase
{
    public function __get($key)
    {
    }
    public function __set($key, $val)
    {
    }
    public function __call($func_name, $arg_arr)
    {
    }
}
/* ----------------------------------------- */

