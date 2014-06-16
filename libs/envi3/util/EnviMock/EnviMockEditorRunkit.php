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
    private $copy_method_class_name = 'EnviMockMethodContainer';
    private $method_name;
    private $copy_method_list = array();
    private $default_extends;
    private $default_methods;
    private $self_default_methods;
    private $is_adapt = false;
    private $by_default = false;


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

        // 継承も含めたメソッドのリスト
        $methods = get_class_methods($class_name);
        foreach ($methods as $method_name) {
            $this->default_methods[strtolower($method_name)] = $method_name;
        }

        $default_extends = class_parents($class_name, false);
        if (is_array($default_extends) && count($default_extends) >= 1) {
            $this->is_adapt = true;
            $this->default_extends = array_shift($default_extends);
            // クラス単体で作られているメソッド一覧を取得する
            $this->emancipate();
            $methods = get_class_methods($class_name);
            foreach ($methods as $method_name) {
                $this->self_default_methods[strtolower($method_name)] = $method_name;
            }
        } else {
            $this->self_default_methods = $this->default_methods;
        }
        $this->restoreExtends();
    }
    /* ----------------------------------------- */

    /**
     * +-- 継承されているかどうか
     *
     * @access      public
     * @return      boolean
     */
    public function isAdapt()
    {
        return $this->is_adapt;
    }
    /* ----------------------------------------- */

    /**
     * +-- クラス名を取得する
     *
     * @access      public
     * @return      string
     */
    public function getClassName()
    {
        return $this->class_name;
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
     * @return      EnviTestMockEditorRunkit
     */
    public function emancipate()
    {
        if ($this->is_adapt) {
            runkit_class_emancipate($this->class_name);
        }
        $this->is_adapt = false;
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
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function adopt($class_name)
    {
        $this->emancipate();
        if (runkit_class_adopt($this->class_name, $class_name)) {
            $this->is_adapt = true;
        }

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
     * @param       string $method_name 削除するメソッド
     * @return      EnviTestMockEditorRunkit
     */
    public function removeMethod($method_name)
    {
        $method = strtolower($method_name);
        if (method_exists($this->class_name, $method)) {
            if (!isset($this->copy_method_list[$method]) && isset($this->default_methods[$method])) {
                $this->copy_method_list[$method] = $this->class_name.'_'.$method.'_'.sha1(microtime());
                runkit_method_copy($this->copy_method_class_name, $this->copy_method_list[$method], $this->class_name, $method);
            }
            runkit_method_remove($this->class_name, $method);
        }
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- スタブしたMethodを元に戻す
     *
     * 削除、および変更されたメソッドを元に戻す。
     *
     * @access      public
     * @param       string $method_name 戻すメソッド
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreMethod($method_name)
    {
        $method = strtolower($method_name);
        if (!isset($this->copy_method_list[$method])) {
            return $this;
        }
        if (method_exists($this->class_name, $method)) {
            runkit_method_remove($this->class_name, $method);
        }
        runkit_method_copy($this->class_name, $this->default_methods[$method], $this->copy_method_class_name, $this->copy_method_list[$method]);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- デフォルトのメソッドを実行する
     *
     * @access      public
     * @param       string $method_name 実行するメソッド
     * @param       object|string $obj OPTIONAL:NULL
     * @param       array $arguments OPTIONAL:array() 引数
     * @return      mixed
     */
    public function executeDefaultMethod($method_name, $obj = NULL, array $arguments = array())
    {
        if ($obj === NULL) {
            $obj = $this->class_name;
        }
        $method = strtolower($method_name);
        if (!isset($this->copy_method_list[$method])) {
            return call_user_func_array(array($obj, $method_name), $arguments);
        }
        runkit_method_copy($this->class_name, $this->copy_method_list[$method], $this->copy_method_class_name, $this->copy_method_list[$method]);
        $res = call_user_func_array(array($obj, $this->copy_method_list[$method]), $arguments);
        runkit_method_remove($this->class_name, $this->copy_method_list[$method]);
        return $res;
    }
    /* ----------------------------------------- */


    /**
     * +-- スタブされたメソッドかどうか
     *
     * @access      public
     * @param       any $method_name
     * @return      boolean
     */
    public function isStab($method_name)
    {
        $method = strtolower($method_name);
        if (isset($this->copy_method_list[$method])) {
            return true;
        }
        return isset($this->default_methods[$method]);
    }
    /* ----------------------------------------- */

    /**
     * +-- 書き換えたクラス定義をすべて元に戻す
     *
     * モックエディタで変更した、クラス定義をすべて元に戻します。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreAll()
    {
        // 追加メソッドの削除
        foreach ($this->getMethods() as $method_name) {
            $method = strtolower($method_name);
            if (!isset($this->self_default_methods[$method])) {
                $this->removeMethod($method_name);
            }
        }

        // 継承を戻す
        $this->restoreExtends();

        // メソッドを戻す
        foreach ($this->copy_method_list as $method_name => $tmp) {
            if (isset($this->self_default_methods[$method_name])) {
                $this->restoreMethod($method_name);
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
     * @return      EnviTestMockEditorRunkit
     * @since       3.3.3.5
     */
    public function restoreExtends()
    {
        if ($this->default_extends) {
            $this->adopt($this->default_extends);
        } else {
            $this->emancipate();
        }
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
     * @return      EnviTestMockEditorRunkit
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
     * @return      EnviTestMockEditorRunkit
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
     * @return      EnviTestMockEditorRunkit
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
     * 追加した制約から外れた場合、該当のメソッドは、例外、EnviMockExceptionがthrowされます。
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
     * @return      EnviTestMockEditorRunkit
     */
    public function shouldReceive($method_name)
    {
        $this->free();
        $this->method_name = $method_name;
        $this->resetContainer();
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 定義済みの制限を再利用する
     *
     * 一度テストされた定義や、byDefault()された定義を再利用して、制限を加えます。
     *
     * @access      public
     * @param       string $method_name
     * @return      EnviTestMockEditorRunkit
     */
    public function recycle($method_name)
    {
        $this->free();
        $this->method_name = $method_name;
        $this->setContainer('is_should_receive', true);
        $this->replaceEnviMockFlame();
        $this->saveEditor();
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 制限をテンプレートとして登録する
     *
     * 現在指定している制限や返り値を、デフォルトとして指定します。
     * デフォルト期待値はデフォルトではない制限や返り値が使われるまで、適用されます。
     * あとで定義されたデフォルト期待値は、先に宣言されたものを即座に置き換えます。
     *
     * initialize()や、データプロバイダーで制限だけ先に加えて、各テストで再利用する等という方法に利用できます。
     *
     * スタブ化前であれば、スタブする処理をスキップしますが、
     * スタブ化済のメソッドを、restore()することはしないので、定義順序に注意してください。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     */
    public function byDefault()
    {
        $this->by_default = true;
        $this->setContainer('is_should_receive', false);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function with()
    {
        $this->setContainer('with', func_get_args());
        return $this;
    }
    /* ----------------------------------------- */

    public function withNoArgs()
    {
        $this->setContainer('with', array());
    }

    public function withNoArgsByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = array();
        $this->setContainer('with_by_times', $res);
        return $this;
    }


    public function withAnyArgs()
    {
        $this->setContainer('with', false);
    }

    public function withAnyArgsByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = false;
        $this->setContainer('with_by_times', $res);
        return $this;
    }


    /**
     * +-- このメソッドにのみ期待される引数のリストの制約を追加します。
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * 指定のメソッドに渡される引数のリストを追加します。
     * 指定された引数以外が渡された場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function withByTimes($times)
    {
        $args = func_get_args();
        $times = array_shift($args);
        $res = $this->getContainer('with_by_times', array());
        $res[(integer)$times] = $args;
        $this->setContainer('with_by_times', $res);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- メソッドが1回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが1回だけ呼び出されることを定義します
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.4から、下限の制限がつきました。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function once()
    {
        $this->times(1);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- メソッドが2回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが2回だけ呼び出されることを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.4から、下限の制限がつきました。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::time()
     */
    public function twice()
    {
        $this->times(2);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 呼び出し回数の上限と下限を定義します
     *
     * @access      public
     * @param       any $min
     * @param       any $max
     * @return      EnviTestMockEditorRunkit
     */
    public function between($min, $max)
    {
        $this->setContainer('max_limit_times', (integer)$max);
        $this->setContainer('min_limit_times', (integer)$min);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 最小実行回数を定義し、最大実行回数は削除します
     *
     * @access      public
     * @param       any $n
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function atLeast($n)
    {
        $this->unsetContainer('max_limit_times');
        $this->setContainer('min_limit_times', (integer)$n);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 最大実行回数を定義し、最小実行回数は削除します
     *
     *
     *
     * @access      public
     * @param       any $n
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     * @see         EnviTestMockEditor::once()
     * @see         EnviTestMockEditor::twice()
     * @see         EnviTestMockEditor::time()
     */
    public function atMost($n)
    {
        $this->setContainer('max_limit_times', (integer)$n);
        $this->unsetContainer('min_limit_times');
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドが呼び出されないことを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが呼び出されないことを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * @access      public
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function never()
    {
        $this->times(-1);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッドが$n回だけ呼び出されることを定義します
     *
     * EnviTestMockEditor::shouldReceive()から、メソッドチェーンで呼び出されます。
     *
     * メソッドが$n回だけ呼び出されることを定義します。
     * 制約から外れた場合は、例外、EnviMockExceptionがthrowされます。
     *
     * このメソッドはv3.4から、下限の制限がつきました。
     *
     * @access      public
     * @param       integer $n 制限回数
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function times($n)
    {
        $this->setContainer('max_limit_times', (integer)$n);
        $this->setContainer('min_limit_times', (integer)$n);
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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function zeroOrMoreTimes()
    {
        $this->unsetContainer('max_limit_times');
        $this->unsetContainer('min_limit_times');
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- メソッド実行回数をリセットするかどうか
     *
     * Defaultでは、assert時にリセットされます。
     *
     * @access      public
     * @param       boolean $is_pool OPTIONAL:true
     * @return      EnviTestMockEditorRunkit
     */
    public function executionCountPooling($is_pool = true)
    {
        $this->setContainer('execution_count_pooling', false);
        return $this;
    }
    /* ----------------------------------------- */



    /**
     * +-- Assert後も同じ制限を継続して利用するかどうかを指定する
     *
     * デフォルトでは、Assert後は制限が解除されます。
     *
     * @access      public
     * @param       boolean $val OPTIONAL:true
     * @return      void
     */
    public function autoRecycle($val = true)
    {
        $this->setContainer('is_auto_recycle', $val);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 自動的にrestoreを行うかどうかを定義する
     *
     * 自動的にrestoreを行うかどうかを定義します。
     *
     * trueを指定すると、スタブされたメソッドについてはAssert後に自動的にrestoreを行います。
     *
     * デフォルトでは、Assert後もrestoreを行わず、andXXXで指定した処理を行います。
     *
     * @access      public
     * @param       boolean $val OPTIONAL:true
     * @return      void
     */
    public function autoRestore($val = true)
    {
        $this->setContainer('is_auto_restore', $val);
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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturn($res)
    {
        $this->mockCommit();
        $this->setContainer('return_values', $res);
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
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnNull()
    {
        $this->mockCommit();
        $this->setContainer('return_values', NULL);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 指定した場所の引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugment($val = 0)
    {
        $this->mockCommit();
        $this->setContainer('return_is_augment', true);
        $this->setContainer('return_values', $val);
        return $this;
    }
    /* ----------------------------------------- */


    /**
     * +-- 引数をそのまま返すメソッドであると定義します
     *
     * @access      public
     * @param       integer $val 返す引数の場所 OPTIONAL:0
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andReturnAugmentAll()
    {
        $this->mockCommit();
        $this->setContainer('return_is_augment_all', true);
        $this->setContainer('return_values', true);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- コールバックの結果を返すメソッドであると定義します
     *
     * @access      public
     * @param       callback $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnCallBack($val)
    {
        $this->mockCommit();
        $this->setContainer('return_is_callback', true);
        $this->setContainer('return_values', $val);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行回数毎にバラバラの値を返すためのマップを登録します、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnConsecutive(array $val)
    {
        $this->mockCommit();
        $this->setContainer('return_is_consecutive ', true);
        $this->setContainer('return_values', array_values($val));
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 引数によって返す値を変える為のマップを登録し、マップに沿った値を返すメソッドであると定義します
     *
     * @access      public
     * @param       array $map
     * @param       array $val
     * @return      EnviTestMockEditorRunkit
     */
    public function andReturnMap(array $map, array $val)
    {
        $this->mockCommit();
        $this->setContainer('return_is_map ', true);
        $return_values = array();
        foreach ($map as $arguments) {
            $return_value = each($val);
            $return_values[] = array('arguments' => $arguments, 'return_values' => $return_value ? $return_value[1] : NULL);
        }
        $this->setContainer('return_values', array_values($return_values));

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
     * @param       string|exception $exception_class throwされるexceptionオブジェクトかexceptionクラス名
     * @param       any $message OPTIONAL:''
     * @return      EnviTestMockEditorRunkit
     * @see         EnviTestMockEditor::shouldReceive()
     */
    public function andThrow($exception_class, $message = '')
    {
        $this->mockCommit();
        $this->setContainer('return_is_throw', true);
        $this->setContainer('return_values', $exception_class);
        return $this;
    }
    /* ----------------------------------------- */

    /**
     * +-- 処理を迂回せず実行するメソッドであると定義します。
     *
     * @access      public
     * @return      void
     */
    public function andNoBypass()
    {
        $this->mockCommit();
        $this->setContainer('no_bypass', true);
        return $this;
    }
    /* ----------------------------------------- */

    private function mockCommit()
    {
        if ($this->by_default) {
            return;
        }
        $this->setContainer('is_should_receive', true);

        $this->saveEditor();
        $this->replaceEnviMockFlame();
    }

    private function replaceEnviMockFlame()
    {
        $this->removeMethod($this->method_name);
        $code = '        $executer = new EnviMockExecuter;
        return $executer->execute(\''.$this->class_name.'\', "'.$this->method_name.'", func_get_args(), $this);';
        runkit_method_add(
            $this->class_name,
            $this->method_name,
            '',
            $code,
            RUNKIT_ACC_PUBLIC
        );
    }



    private function setContainer($setter_key, $setter_value)
    {
        EnviMockContainer::singleton()->setAttribute($this->class_name, $this->method_name, $setter_key, $setter_value);
    }

    private function getContainer($setter_key, $default_value)
    {
        return EnviMockContainer::singleton()->getAttribute($this->class_name, $this->method_name, $setter_key, $default_value);
    }


    private function unsetContainer($setter_key)
    {
        EnviMockContainer::singleton()->unsetAttribute($this->class_name, $this->method_name, $setter_key);
    }

    private function resetContainer()
    {
        EnviMockContainer::singleton()->unsetAttributeMethodAll($this->class_name, $this->method_name);
    }

    private function saveEditor()
    {
        EnviMockContainer::singleton()->setEditor($this->class_name, $this->method_name, $this);
    }

    private function free()
    {
        $this->method_name = '';
        $this->by_default = false;
        return $this;
    }

}
/* ----------------------------------------- */

class EnviMockMethodContainer
{
}
