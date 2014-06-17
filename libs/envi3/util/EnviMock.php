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


require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviMockExceptions.php';
require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviMockContainer.php';
require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviMockExecuter.php';
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
    private static $mock_editor_cache = array();

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
     * @param       boolean $auto_loading  モックを作るときにオートロードするか OPTIONAL:false
     * @param       boolean $is_cache  キャッシュするかどうか OPTIONAL:true
     * @return      EnviMockEditor モック操作オブジェクト
     */
    public static function mock($class_name, $auto_loading = false, $is_cache = true)
    {
        // @codeCoverageIgnoreStart
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
        $class_name = strtolower($class_name);
        // @codeCoverageIgnoreEnd
        if ($is_cache && isset(self::$mock_editor_cache[$class_name])) {
            return self::$mock_editor_cache[$class_name];
        }

        if (!class_exists($class_name, $auto_loading)) {
            self::addMockClass($class_name);
        }
        $mock_editor = new EnviMockEditorRunkit($class_name);
        if ($is_cache) {
            self::$mock_editor_cache[$class_name] = $mock_editor;
        }
        return $mock_editor;
    }
    /* ----------------------------------------- */

    public static function deleteCache($class_name)
    {
        $class_name = strtolower($class_name);
        if (isset(self::$mock_editor_cache[$class_name])) {
            self::$mock_editor_cache[$class_name]->restoreAll();
            unset(self::$mock_editor_cache[$class_name]);
        }
    }

    public static function free()
    {
        $keys = array_keys(self::$mock_editor_cache);
        foreach ($keys as $class_name) {
            $class_name = strtolower($class_name);
            if (self::$mock_editor_cache[$class_name] instanceof EnviMockEditorRunkit) {
                self::$mock_editor_cache[$class_name]->restoreAll();
            }
            unset(self::$mock_editor_cache[$class_name]);
        }
    }


    /**
     * +-- モックメソッドの実行トレースを取得する
     *
     * @access      public
     * @static
     * @return      array
     */
    public static function getMockTraceList()
    {
        return EnviMockContainer::singleton()->getProcessAll();
    }
    /* ----------------------------------------- */

    /**
     * +-- モックメソッドの実行トレースを削除する
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function resetMockTraceList()
    {
        return EnviMockContainer::singleton()->unsetProcessAll();
    }
    /* ----------------------------------------- */

    /**
     * +-- Assertionの最後に毎回実行される
     *
     * @access      public
     * @static
     * @return      void
     */
    public static function assertionExecuteAfter()
    {
        $container = EnviMockContainer::singleton();
        $mock_execute = new EnviMockExecuter;
        foreach ($container->getAttributeAll() as $class_name => $method_list) {
            foreach ($method_list as $method_name => $values) {
                if (isset($values['is_should_receive']) && $values['is_should_receive']) {
                    $mock_execute->assertionExecuteAfter($class_name, $method_name);
                }
            }
        }
        self::resetMockTraceList();
    }
    /* ----------------------------------------- */

    /**
     * +-- モッククラスの作成
     *
     * @access      private
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

