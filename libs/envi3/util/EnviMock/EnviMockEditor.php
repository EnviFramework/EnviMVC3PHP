<?php
/**
 * モッククラスに対する操作を提供します。
 *
 * EnviTestMockEditorはモッククラスに対する操作を提供します。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
 *
 * EnviTestMockEditorはすべてメソッドチェーンで実行されます。
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
 * @since      Class available since Release 3.3.3.2
 */

/**
 * モッククラスに対する操作を提供します。
 *
 * EnviTestMockEditorはモッククラスに対する操作を提供します。
 *
 * 内部では、runkitを使用しているため、必要に応じてエクステンションをインストールする必要性があります。
 *
 * EnviTestMockEditorはすべてメソッドチェーンで実行されます。
 *
 *
 * @category   自動テスト
 * @package    テストスタブ
 * @subpackage Mock
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 3.3.3.2
 */
interface EnviTestMockEditor
{


    /**
     * +-- コンストラクタ
     *
     *
     * @access      public
     * @param       any $cla_name
     * @return      void
     * @deprecated EnviMock::mock('クラス名');を使用して下さい。
     * @see EnviMock::mock();
     */
    public function __construct($class_name);
    /* ----------------------------------------- */


    /**
     * +-- 定義されているメソッドの一覧を返します。
     *
     * モッククラスに定義されているメソッドの名前を配列として返します。
     * エラー時には NULL を返します。
     *
     * 宣言されているままのメソッド名 (大文字小文字を区別) を返すことに注意して下さい。
     *
     * @access      public
     * @return      array
     */
    public function getMethods();
    /* ----------------------------------------- */

    /**
     * +-- 継承を解除する
     *
     * 他のクラスを継承している場合継承関係を解消し、 親クラスから継承しているメソッドを取り除く
     * @access      public
     * @return      EnviTestMockEditor
     */
    public function emancipate();
    /* ----------------------------------------- */


    /**
     * +-- 指定したクラスを継承させる
     *
     * 継承されている場合、継承を解除し、指定したクラスを継承させる。
     *
     * @access      public
     * @param       string $class_name 継承させるクラス名
     * @return      EnviTestMockEditor
     * @since       3.3.3.5
     */
    public function adopt($class_name);
    /* ----------------------------------------- */

    /**
     * +-- メソッドを削除する
     *
     * クラスから、指定されたメソッドを削除します、
     *
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ {.alert .alert-warning}
     * __注意:__
     * 現在実行中(もしくはチェーンド)のメソッドを操作することはできません。
     * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
     *
     * @access      public
     * @param       string $method 削除するメソッド
     * @return      EnviTestMockEditor
     */
    public function removeMethod($method);
    /* ----------------------------------------- */

    /**
     * +-- removeMethodしたMethodを元に戻す
     *
     * 削除、および変更されたメソッドを元に戻す。
     *
     * @access      public
     * @param       string $method 戻すメソッド
     * @return      EnviTestMockEditor
     * @since       3.3.3.5
     */
    public function restoreMethod($method);
    /* ----------------------------------------- */

    /**
     * +-- 書き換えたクラス定義をすべて元に戻す
     *
     * モックエディタで変更した、クラス定義をすべて元に戻します。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @since       3.3.3.5
     */
    public function restoreAll();
    /* ----------------------------------------- */

    /**
     * +-- emancipateおよび、adoptした継承状態を元に戻す。
     *
     * モックエディタで変更した継承状態を元に戻します。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @since       3.3.3.5
     */
    public function restoreExtends();
    /* ----------------------------------------- */

    /**
     * +-- 空のメソッドを定義する
     *
     * 空のメソッドを定義します。
     * 既にメソッドが定義されている場合は、空のメソッドに置き換えます。
     *
     * @access      public
     * @param       string $method 定義したいメソッド名
     * @return      EnviTestMockEditor
     */
    public function blankMethod($method);
    /* ----------------------------------------- */


    /**
     * +-- 複数の空メソッドを定義する
     *
     * 複数の空メソッドを定義します。
     * 既にメソッドが定義されている場合は、空のメソッドに置き換えます。
     *
     * @access      public
     * @param       array $methods 定義するメソッド名の配列
     * @return      EnviTestMockEditor
     */
    public function blankMethodByArray(array $methods);
    /* ----------------------------------------- */

    /**
     * +-- 全ての定義済メソッドを空メソッドに置き換える
     *
     * 定義されているメソッドを空メソッドに置き換えます
     *
     * @access      public
     * @return      EnviTestMockEditor
     */
    public function blankMethodAll();
    /* ----------------------------------------- */

    /**
     * +-- 制約を追加するためのメソッドを定義します。
     *
     * メソッドに制約を追加できます。
     * 制約を追加したいメソッド名をshouldReceive()で指定し、メソッドチェーンで、制約を追加します。
     *
     * 追加した制約から外れた場合、該当のメソッドは、例外、EnviTestMockExceptionがthrowされます。
     *
     * 返り値を設定するまで、制約は追加されません。
     * 逆に、返り値を設定してしまうと、制約が追加され、メソッドは書き換えられてしまいます。
     *
     * {@example}
     *    $mock
     *    ->shouldReceive('check') // checkというメソッドが呼び出される
     *    ->with('foo') // 引数として'foo'を受け取る
     *    ->andReturn(true); // trueを返却する
     * {/@example}
     * @access      public
     * @param       string $method_name
     * @return      EnviTestMockEditor
     */
    public function shouldReceive($method_name);
    /* ----------------------------------------- */

    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviTestMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function with();
    /* ----------------------------------------- */

    /**
     * +-- メソッドが二回以上呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが二回以上呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviTestMockExceptionがthrowされます。
     *
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function once();
    /* ----------------------------------------- */


    /**
     * +-- メソッドが三回以上呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが三回以上呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviTestMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function twice();
    /* ----------------------------------------- */


    /**
     * +-- メソッドが呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviTestMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function never();
    /* ----------------------------------------- */

    /**
     * +-- メソッドが$n回以上呼び出されないことを定義します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが$n回以上呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviTestMockExceptionがthrowされます。
     *
     * @access      public
     * @param       integer $n 制限回数
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function times($n);
    /* ----------------------------------------- */


    /**
     * +-- 期待メソッドが0回以上呼び出すことができることを宣言します。これは、すべてのメソッドのデフォルトです。
     *
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 期待メソッドが0回以上呼び出すことができることを宣言します。
     * 設定変更しない限り、これは、すべてのメソッドのデフォルトです。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function zeroOrMoreTimes();
    /* ----------------------------------------- */



    /**
     * +-- 戻り値を設定します。
     *
     * 戻り値を設定します。
     *
     * この後のモックメソッドの全ての呼び出しは、常にこの宣言に指定された値を返すことに注意してください。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     *
     *
     * @access      public
     * @param       any $res
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturn($res);
    /* ----------------------------------------- */

    /**
     * +-- NULLを返すメソッドであると定義します
     *
     * NULLを返すメソッドであると定義します
     *
     * この後のモックメソッドの全ての呼び出しは、常にこの宣言に指定されたNULLを返すことに注意してください。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     * @access      public
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnNull();
    /* ----------------------------------------- */



    /**
     * +-- 呼び出された場合、このメソッドは、指定された例外オブジェクトをスローすることを宣言します。
     *
     * この後のモックメソッドの全ての呼び出し、常にこの宣言に例外を返すようになることに注意して下さい。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出され、制限が確定されます。
     *
     * @access      public
     * @param       any $exception_class_name
     * @param       any $message OPTIONAL:''
     * @return      EnviTestMockEditor
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andThrow($exception_class_name, $message = '');
    /* ----------------------------------------- */

}
/* ----------------------------------------- */
