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
 * @doc_ignore
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
class EnviMockEditorRunkit implements EnviMockEditor
{
    private $class_name;
    private $method_name;
    private $with;
    private $times;
    private $copy_method_list = array();
    private $default_extends;
    private $default_methods;
    private $mock_hash;


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
    public function __construct($class_name)
    {
        $this->class_name = $class_name;
        $methods = get_class_methods($class_name);
        $this->default_methods = count($methods) ? array_flip($methods) : array();
        $default_extends = class_parents($class_name, false);
        if (is_array($default_extends) && count($default_extends) >= 1) {
            $this->default_extends = array_shift($default_extends);
        }
        $this->mock_hash = mt_rand().sha1(microtime());
    }
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
    public function getMethods()
    {
        return get_class_methods($this->class_name);
    }
    /* ----------------------------------------- */

    /**
     * +-- 継承を解除する
     *
     * 他のクラスを継承している場合継承関係を解消し、 親クラスから継承しているメソッドを取り除く
     * @access      public
     * @return      EnviTestMockEditor
     */
    public function emancipate()
    {
        runkit_class_emancipate($this->class_name);
        runkit_class_adopt($this->class_name , 'EnviMockBlankBase');
        return $this;
    }
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
    public function adopt($class_name)
    {
        runkit_class_emancipate($this->class_name);
        runkit_class_adopt($this->class_name , $class_name);
        return $this;
    }
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
    public function removeMethod($method)
    {
        if (method_exists($this->class_name, $method)) {
            if (!isset($this->copy_method_list[$method]) && isset($this->default_methods[$method])) {
                $this->copy_method_list[$method] = $this->class_name.'_'.$method.sha1(microtime());
                runkit_method_copy ('EnviTestMockTemporary', $this->copy_method_list[$method], $this->class_name, $method);
            }
            runkit_method_remove($this->class_name, $method);
        }
        return $this;
    }
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
    public function restoreMethod($method)
    {
        if (!isset($this->copy_method_list[$method])) {
            return $this;
        }
        if (method_exists($this->class_name, $method)) {
            runkit_method_remove($this->class_name, $method);
        }
        runkit_method_copy ($this->class_name, $method, 'EnviTestMockTemporary', $this->copy_method_list[$method]);
        return $this;
    }
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
    public function restoreAll()
    {
        // 継承を戻す
        $this->restoreExtends();

        // メソッドを戻す
        foreach ($this->copy_method_list as $method_name => $tmp) {
            $this->restoreMethod($method_name);
        }

        // 追加メソッドの削除
        foreach ($this->getMethods() as $method_name) {
            if (!isset($this->default_methods[$method_name])) {
                $this->removeMethod($method_name);
            }
        }
        return $this;
    }
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
    public function restoreExtends()
    {
        $this->adopt($this->default_extends);
        return $this;
    }
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
    public function blankMethod($method)
    {
        $this->removeMethod($method);
        runkit_method_add($this->class_name, $method, '', '');
        return $this;
    }
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
    public function blankMethodByArray(array $methods)
    {
        foreach ($methods as $method) {
            $this->blankMethod($method);
        }
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 全ての定義済メソッドを空メソッドに置き換える
     *
     * 定義されているメソッドを空メソッドに置き換えます
     *
     * @access      public
     * @return      EnviTestMockEditor
     */
    public function blankMethodAll()
    {
        foreach ($this->getMethods() as $method) {
            $this->blankMethod($method);
        }
        return $this;
    }
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
    public function shouldReceive($method_name)
    {
        $this->free();
        $this->method_name = $method_name;
        return $this;
    }
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
    public function with()
    {
        $this->with = func_get_args();
        return $this;
    }
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
    public function once()
    {
        $this->times = 1;
        return $this;
    }
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
    public function twice()
    {
        $this->times = 2;
        return $this;
    }
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
    public function never()
    {
        $this->times = -1;
        return $this;
    }
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
    public function times($n)
    {
        $this->times = $n;
        return $this;
    }
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
    public function zeroOrMoreTimes()
    {
        $this->times = false;
        return $this;
    }
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
    public function andReturn($res)
    {
        $this->removeMethod($this->method_name);
        $method_script = $this->createMethodScript();
        EnviTestMockAndReturn::$return_values[$this->mock_hash] = $res;
        $method_script .= 'return EnviTestMockAndReturn::$return_values['.$this->mock_hash.'];';
        runkit_method_add($this->class_name, $this->method_name, '', $method_script);
        $this->free();
        return $this;
    }
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
    public function andReturnNull()
    {
        $this->removeMethod($this->method_name);
        $method_script = $this->createMethodScript();
        $method_script .= 'return NULL;';
        runkit_method_add($this->class_name, $this->method_name, '', $method_script);

        $this->free();
        return $this;
    }
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
    public function andThrow($exception_class_name, $message = '')
    {
        if (is_object($exception_class_name)) {
            $message = $exception_class_name->getMessage();
            $exception_class_name = get_class($exception_class_name);
        }
        $this->removeMethod($this->method_name);
        $method_script = $this->createMethodScript();
        $method_script .= ' throw new '.$exception_class_name.'('.var_export($message, true).');';
        runkit_method_add($this->class_name, $this->method_name, '', $method_script);

        $this->free();
        return $this;
    }
    /* ----------------------------------------- */


    private function createMethodScript()
    {
        $method_script = "\n";

        if (is_integer($this->times)) {
            $method_script .= 'static $times = 0;
                if ($times < '.$this->times.') {
                    ++$times;
                } else {
                    $e = new EnviTestMockException("duplicate call method");
                    $e->setArgument('.$this->method_name.');
                    $e->setArgument(func_get_args());
                    $e->setArgument('.var_export($this->with, true).');
                    throw $e;
                }
                ';
        }

        if (is_array($this->with)) {
            $method_script .= 'if (func_get_args() !== '.var_export($this->with, true).') {
                $e = new EnviTestMockException("arguments Error");
                $e->setArgument('.$this->method_name.');
                $e->setArgument(func_get_args());
                $e->setArgument('.var_export($this->with, true).');
                throw $e;
            }
            ';
        }
        return $method_script;
    }



    private function free()
    {
        $this->method_name = '';
        $this->with = false;
        $this->once = false;
        return $this;
    }

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
 * @codeCoverageIgnore
 */
class EnviTestMockTemporary
{
}
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
 * @codeCoverageIgnore
 */
class EnviTestMockAndReturn
{
    public static $return_values = array();
}

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
 * @codeCoverageIgnore
 */
class EnviTestMockException extends exception
{
   public $argument;
   public function setArgument($setter)
   {
       $this->argument[] = $setter;
   }
}
/* ----------------------------------------- */

