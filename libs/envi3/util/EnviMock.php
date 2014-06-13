<?php
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
 * による、EnviTestMockEditorの生成のみをサポートします。
 *
 * テストモックに対する実際の処理は、EnviTestMockEditorによって行われます。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
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


require dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock'.DIRECTORY_SEPARATOR.'EnviTestMockEditor.php';
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
 * による、EnviTestMockEditorの生成のみをサポートします。
 *
 * テストモックに対する実際の処理は、EnviTestMockEditorによって行われます。
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
     * EnviTestMockEditorによる、モックテストを開始します。
     *
     * 定義済みのクラスを指定した場合は、スタブ可能なモックテストに、
     *
     * 未定義のクラスを指定した場合は、完全なモックを提供します。
     *
     * @access      public
     * @static
     * @param       string $class_name モックを作成するクラス名
     * @return      EnviTestMockEditor モック操作オブジェクト
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

        $mock_editor = new EnviMockEditorRunkit($class_name);
        if (!class_exists($class_name, false)) {
            self::addMockClass($class_name);
        }
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
        class '.$class_name.' extends EnviTestBlankMockBase
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
abstract class EnviTestBlankMockBase
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

