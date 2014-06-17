<?php

/**
 * テストAssert
 *
 * EnviTestCaseで継承されるため直接参照することはありませんが、
 * EnviTestCaseはすべての、テストで継承されるため、
 * すべてのテストの中でこのクラスに定義されているテストアサーションを使用することが出来ます。
 *
 *
 *
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
 */
abstract class EnviTestAssert extends EnviTestBase
{
    /**
     * +-- 配列にキーがあるかどうかを確認し、ない場合はエラー$message を報告します。
     *
     * このアサーションは、$arrayにキー$keyが存在するかどうかを確認し、存在しない場合はエラー$message を報告します。
     *
     * @access public
     * @param string $key 確認するキー
     * @param array $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertArrayHasKey($key, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_key_exists($key, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 配列にキーがないかどうかを確認し、ある場合はエラー$message を報告します。
     *
     * このアサーションは、$arrayにキー$keyが存在しないかどうかを確認し、存在する場合はエラー$message を報告します。
     *
     * @access public
     * @param string $key 確認するキー
     * @param array $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertArrayNotHasKey($key, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_key_exists($key, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $arrayに値$valueが存在するかどうかを確認します。 存在しない場合はエラー$message を報告します。
     *
     * このアサーションは、$arrayに値$valueが存在するかどうかを確認します。 存在しない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $value 存在確認する値
     * @param array $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertArrayHasValue($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $arrayに値$valueが存在しないかどうかを確認します。 存在する場合はエラー$message を報告します。
     *
     * このアサーションは、$arrayに値$valueが存在するかどうかを確認します。 存在しない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $value 存在確認する値
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertArrayNotHasValue($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 配列かどうかを確認します。配列でない場合はエラー$message を報告します。
     *
     * このアサーションは、配列かどうかを確認します。配列でない場合はエラー$message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertArray($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_array($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $class_name::$attribute_name() が存在しない場合にエラー $message を報告します。
     *
     * このアサーションは、$class_nameクラスに、$attribute_nameメソッドが存在するかを確認します。存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $attribute_name メソッド名
     * @param mixed $class_name クラス名
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertClassHasAttribute($attribute_name, $class_name, $message = '')
    {
        $this->assertionExecuteBefore();
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($attribute_name, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $class_name::attribute_name() が存在する場合にエラー $message を報告します。
     *
     * このアサーションは、$class_nameクラスに、$attribute_nameメソッドが存在するかを確認します。存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $attribute_name メソッド名
     * @param mixed $class_name クラス名
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertClassNotHasAttribute($attribute_name, $class_name, $message = '')
    {
        $this->assertionExecuteBefore();
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($attribute_name, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $arrayに値$valueが存在するかどうかを確認します。 存在しない場合はエラー $message を報告します。
     *
     * このアサーションは、$arrayに値$valueが存在するかどうかを確認します。 存在しない場合はエラー $message を報告します。
     * assertArrayHasValueとの違いは、$valueにstring以外使用でき無い点です。
     *
     * @access public
     * @param mixed $value 存在確認する値
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertContains($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array) || is_array($value)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($value, $array) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }


    /**
     * +-- $arrayに値$valueが存在しないかどうかを確認します。 存在する場合はエラー $message を報告します。
     *
     * このアサーションは、$arrayに値$valueが存在しないかどうかを確認します。 存在する場合はエラー $message を報告します。
     * assertArrayNotHasValueとの違いは、$valueにstring以外使用でき無い点です。
     *
     * @access public
     * @param mixed $value 存在確認する値
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotContains($value, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array) || is_array($value)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (array_search($value, $array) !== false) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /**
     * +-- $arrayの中身の型が $type だけではない場合にエラー $message を報告します。
     *
     * このアサーションは、配列$arrayの中身の型が$typeとなっているかを確認します。$type以外が存在す場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $type 型の名前
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertContainsOnly($type, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (is_array($type) || !is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (!(gettype($value) === $type)) {
                throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $arrayの中身の型が $type だけの場合にエラー $message を報告します。
     *
     * このアサーションは、配列$arrayの中身の型が$type以外となっているかを確認します。$typeが存在す場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $type 型の名前
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotContainsOnly($type, $array, $message = '')
    {
        if (is_array($type) || !is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (gettype($value) === $type) {
                throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array の要素数が $count でない場合にエラー $message を報告します。
     *
     * このアサーションは、配列$arrayの要素数が、$countであることを確認します。違う場合は、$message を報告します。
     *
     * @access public
     * @param mixed $count 配列の要素数
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertCount($count, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(count($array) === $count)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array の要素数が $count の場合にエラー $message を報告します。
     *
     * このアサーションは、配列$arrayの要素数が、$countででないことを確認します。違う場合は、$message を報告します。
     *
     * @access public
     * @param mixed $count 配列の要素数
     * @param mixed $array 確認する配列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotCount($count, $array, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_array($array)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((count($array) === $count)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 空であるかを確認し、空の場合は、エラー $message を報告します。
     *
     * このアサーションは空であるかを確認し、空の場合は、エラー $message を報告します。
     * 下記のような値が、空であると判断されます。
     * + "" (空文字列)
     * + 0 (整数 の 0)
     * + 0.0 (浮動小数点数の 0)
     * + "0" (文字列 の 0)
     * + NULL
     * + FALSE
     * + array() (空の配列)
     * + $var; (変数が宣言されているが、値が設定されていない)
     *
     * @access public
     * @param mixed $a 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertEmpty($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!empty($a)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 空でないかを確認し、空の場合は、エラー $message を報告します。
     *
     * このアサーションは空でないかを確認し、空の場合は、エラー $message を報告します。
     * 下記のような値が、空であると判断されます。
     * + "" (空文字列)
     * + 0 (整数 の 0)
     * + 0.0 (浮動小数点数の 0)
     * + "0" (文字列 の 0)
     * + NULL
     * + FALSE
     * + array() (空の配列)
     * + $var; (変数が宣言されているが、値が設定されていない)
     *
     * @access public
     * @param mixed $a 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotEmpty($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (empty($a)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- 2 つの変数 $a と $b が等しいかどうかを確認し、等しくない場合にエラー $message を報告します。
     *
     * このアサーションは2 つの変数 $a と $b が等しいかどうかを確認し、等しくない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a == $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 2 つの変数 $a と $b が等しくないかどうかを確認し、等しい場合にエラー $message を報告します。
     *
     * このアサーションは2つの変数 $a と $b が等しくないかどうかを確認し、等しい場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (($a == $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- falseかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、falseかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertFalse($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 指定されたファイルが同じファイルかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、指定されたファイルが同じファイルかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param string $a 確認するファイル名
     * @param string $b 確認するファイル名
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertFileEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_file($a) === is_file($b)) || !($this->fileGetContents($a) === $this->fileGetContents($b))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 指定されたファイルが同じファイルでないかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、指定されたファイルが同じファイルでないかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param string $a 確認するファイル名
     * @param string $b 確認するファイル名
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertFileNotEquals($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(is_file($a) === is_file($b)) || !($this->fileGetContents($a) === $this->fileGetContents($b))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルが存在するかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、ファイルが存在するかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認するファイルパス
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertFileExists($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!(file_exists($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルが存在しないかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、ファイルが存在しないかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認するファイルパス
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotFileExists($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if ((file_exists($a))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a > $b かどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、$a > $b かどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertGreaterThan($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a > $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a>=$bかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、$a>=$bかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertGreaterThanOrEqual($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a >= $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual が $expected のインスタンスでない場合にエラー $message を報告します。
     *
     * このアサーションは、$actual が $expected のインスタンスでない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $expected クラス名
     * @param mixed $actual オブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertInstanceOf($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_object($actual) || !is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!($actual instanceof $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $actual が $expected のインスタンスの場合にエラー $message を報告します。
     *
     * このアサーションは、$actual が $expected のインスタンスの場合にエラー $message を報告します。
     *
     * @access public
     * @param string $expected クラス名
     * @param mixed $actual オブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotInstanceOf($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_object($actual) || !is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (($actual instanceof $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual の型が $expected でない場合にエラー $message を報告します。
     *
     * このアサーションは、$actual の型が $expected でない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $expected 型名
     * @param mixed $actual 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertInternalType($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(gettype($actual) === $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */
    /**
     * +-- $actual の型が $expected の場合にエラー $message を報告します。
     *
     * このアサーションは、$actual の型が $expected の場合にエラー $message を報告します。
     *
     * @access public
     * @param string $expected 型名
     * @param mixed $actual 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotInternalType($expected, $actual, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((gettype($actual) === $expected)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<$bかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * このアサーションは、$a<$bかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 調べる値
     * @param mixed $b 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertLessThan($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a < $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<=$bかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * このアサーションは、$a<=$bかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 調べる値
     * @param mixed $b 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertLessThanOrEqual($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a <= $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- Nullかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * このアサーションは、Nullかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNull($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === NULL)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $object->attributeName が存在しない場合にエラー $message を報告します。
     *
     * このアサーションは、$object->attributeName が存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $attribute_name メソッド名
     * @param mixed $object 調べるオブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertObjectHasAttribute($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $ReflectionClass = new ReflectionClass($object);
        if (!($ReflectionClass->hasProperty($attribute_name))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $object->attributeName が存在する場合にエラー $message を報告します。
     *
     * このアサーションは、$object->attributeName が存在する場合にエラー $message を報告します。
     *
     * @access public
     * @param string $attribute_name メソッド名
     * @param mixed $object 調べるオブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertObjectNotHasAttribute($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $ReflectionClass = new ReflectionClass($object);
        if (($ReflectionClass->hasProperty($attribute_name))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- オブジェクト$objectにメソッド$attribute_name があるかを確認し、存在しない場合にエラー $message を報告します。
     *
     * このアサーションは、オブジェクト$objectにメソッド$attribute_name があるかを確認し、存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $attribute_name メソッド名
     * @param mixed $object 調べるオブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertObjectHasMethod($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $ReflectionClass = new ReflectionClass($object);
        if (!($ReflectionClass->hasMethod($attribute_name))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- オブジェクト$objectにメソッド$attribute_name がないかを確認し、存在する場合にエラー $message を報告します。
     *
     * このアサーションは、オブジェクト$objectにメソッド$attribute_name がないかを確認し、存在する場合にエラー $message を報告します。
     *
     * @access public
     * @param string $attribute_name メソッド名
     * @param mixed $object 調べるオブジェクト
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertObjectNotHasMethod($attribute_name, $object, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($attribute_name)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $ReflectionClass = new ReflectionClass($object);
        if (($ReflectionClass->hasMethod($attribute_name))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $string が正規表現 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が正規表現 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 正規表現
     * @param mixed $string 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertRegExp($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_ereg($pattern, $string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が正規表現 $pattern にマッチする場合にエラー $message を報告します。
     *
     * このアサーションは、$string が正規表現 $pattern にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 正規表現
     * @param mixed $string 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotRegExp($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_ereg($pattern, $string))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- $string が(Preg)正規表現 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が(Preg)正規表現 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 正規表現
     * @param mixed $string 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertPregMatch($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(preg_match($pattern, $string) === 1)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が(Preg)正規表現 $pattern にマッチする場合にエラー $message を報告します。
     *
     * このアサーションは、$string が(Preg)正規表現 $pattern にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 正規表現
     * @param mixed $string 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotPregMatch($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((preg_match($pattern, $string) === 1)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- $string が書式文字列 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が書式文字列 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 書式文字列
     * @param mixed $string 調べる値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringMatchesFormat($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $scan = sscanf($string, $pattern);
        if (!count($scan)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        array_unshift($scan, $pattern);
        $diff_string = call_user_func_array('sprintf', $scan);
        if ($diff_string !== $string) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が書式文字列 $pattern にマッチする場合にエラー $message を報告します。
     *
     * このアサーションは、$string が書式文字列 $pattern にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param string $pattern 書式文字列
     * @param mixed $string
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringNotMatchesFormat($pattern, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($pattern) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $scan = sscanf($string, $pattern);
        array_unshift($scan, $pattern);
        $diff_string = call_user_func_array('sprintf', $scan);
        if ($diff_string === $string) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $format_file の内容にマッチしない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $format_file の内容にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $format_file ファイルパス
     * @param mixed $string 文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringMatchesFormatFile($format_file, $string, $message = '')
    {
        if (!is_string($format_file) || !is_file($format_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        try {
            $res = $this->assertStringMatchesFormat($this->fileGetContents($format_file), $string, $message = '');
        } catch (EnviTestAssertionFailException $e) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return $res;
    }
    /* ----------------------------------------- */


    /**
     * +-- $string が $format_file の内容にマッチする場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $format_file の内容にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $format_file ファイルパス
     * @param mixed $string 文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringNotMatchesFormatFile($format_file, $string, $message = '')
    {
        if (!is_string($format_file) || !is_file($format_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }

        try {
            $res = $this->assertStringNotMatchesFormat($this->fileGetContents($format_file), $string, $message = '');
        } catch (EnviTestAssertionFailException $e) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return $res;
    }
    /* ----------------------------------------- */

    /**
     * +-- 型と、値が同じかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * このアサーションは、型と、値が同じかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertSame($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 型と、値が違うかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * このアサーションは、型と、値が違うかどうかを確認し、そうでない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param mixed $b 確認する値
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertNotSame($a, $b, $message = '')
    {
        $this->assertionExecuteBefore();
        if (($a === $b)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $suffix で終わっていない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $suffix で終わっていない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $suffix 終端文字列
     * @param mixed $string 確認する文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringEndsWith($suffix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($suffix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strrpos($string, $suffix) === (mb_strlen($string)-mb_strlen($suffix)))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $string が $suffix で終わっている場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $suffix で終わっている場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $suffix 終端文字列
     * @param mixed $string 確認する文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringNotEndsWith($suffix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($suffix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strrpos($string, $suffix) === (mb_strlen($string)-mb_strlen($suffix)))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- expected_file で指定したファイルの内容に $string が含まれない場合にエラー $message を報告します。
     *
     * このアサーションは、expected_file で指定したファイルの内容に $string が含まれない場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $expected_file ファイルパス
     * @param mixed $string 調べる文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringEqualsFile($expected_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected_file) || !is_string($string) || !is_file($expected_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $this->fileGetContents($expected_file)) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- expected_file で指定したファイルの内容に $string が含まれる場合にエラー $message を報告します。
     *
     * このアサーションは、expected_file で指定したファイルの内容に $string が含まれる場合にエラー $message を報告します。
     *
     * @access public
     * @param mixed $expected_file ファイルパス
     * @param mixed $string 調べる文字列
     * @param string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringNotEqualsFile($expected_file, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($expected_file) || !is_string($string) || !is_file($expected_file)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, $this->fileGetContents($expected_file)) !== false)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }

    /**
     * +-- $string が $prefix で始まっていない場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $prefix で始まっていない場合にエラー $message を報告します。
     *
     * @access      public
     * @param       mixed $prefix 先頭文字列
     * @param       mixed $string 調べる文字列
     * @param       string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return      boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringStartsWith($prefix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($prefix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $prefix) === 0)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $prefix で始まっている場合にエラー $message を報告します。
     *
     * このアサーションは、$string が $prefix で始まっている場合にエラー $message を報告します。
     *
     * @access      public
     * @param       mixed $prefix 先頭文字列
     * @param       mixed $string 調べる文字列
     * @param       string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return      boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertStringNotStartsWith($prefix, $string, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!is_string($prefix) || !is_string($string)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, $prefix) === 0)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    public function assertTag()
    {
        $this->assertionExecuteBefore();
        $this->assertionExecuteAfter();
        return true;
    }

    /**
     * +-- アサーションの追加
     *
     * @access public
     * @param mixed $value
     * @param EnviTestContain $contain
     * @param       string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return      boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertThat($value, EnviTestContain $contain, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($contain->execute($value))) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- trueかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * このアサーションは、trueかどうかを確認します。 そうでない場合はエラー $message を報告します。
     *
     * @access public
     * @param mixed $a 確認する値
     * @param       string $message OPTIONAL:'' 表示するエラーメッセージ
     * @return      boolean OKの場合trueを返します。 テストがNGの場合は、何も返しません。
     */
    public function assertTrue($a, $message = '')
    {
        $this->assertionExecuteBefore();
        if (!($a === true)) {
            throw new EnviTestAssertionFailException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        $this->assertionExecuteAfter();

        return true;
    }
    /* ----------------------------------------- */


    protected function fileGetContents($file)
    {
        return file_get_contents($file);
    }
}

abstract class EnviTestContain
{
    abstract public function execute($val);
}
