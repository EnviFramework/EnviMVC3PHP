<?php
/**
 * テスト用の処理
 *
 * @package Envi3
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */



/**
 * テスト用例外
 *
 * @package Envi3
 * @subpackage EnviTest
 * @since 0.1
 * @author     fumikazu.kitagawa<kitagawa-f@klab.jp>
 */
class EnviTestException extends exception
{

}

if (!defined('ENVI_ENV')) {
    define('ENVI_ENV', 'unittest');
}
/**
 * test用エクステンションloader
 *
 * @package Envi3
 * @subpackage EnviTest
 * @since 0.1
 * @author     fumikazu.kitagawa<kitagawa-f@klab.jp>
 */
class extension
{
    private $configuration;
    private $extensions;
    private static $instance;

    /**
     * +-- コンストラクタ
     *
     * @access private
     * @param  $configuration
     * @return void
     */
    private function __construct()
    {
        $this->configuration = EnviTest::singleton()->system_conf['extension'];
        foreach ($this->configuration as $name => $v) {
            if (!$v['constant']) {
                continue;
            }
            include_once $v['class']['resource'];
            $class_name = $v['class']['class_name'];
            $this->extensions[$name] = new $class_name(EnviTest::singleton()->parseYml(basename($v['router']['resource']), dirname($v['router']['resource']).DIRECTORY_SEPARATOR));
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- エクステンションのオブジェクト取得(magicmethod)
     *
     * @access public
     * @param  $name
     * @param  $arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->configuration[$name])) {
            throw new EnviTestException($name.' extensionが見つかりませんでした');
        }
        $class_name = $this->configuration[$name]['class']['class_name'];

        if (!isset($this->configuration[$name]['class']['singleton']) || !$this->configuration[$name]['class']['singleton']) {
            if (!isset($this->extensions[$name])) {
                include_once $this->configuration[$name]['class']['resource'];
                $this->extensions[$name] = array();
            }
            $c = count($this->extensions[$name]);
            $this->extensions[$name][$c] = $class_name(EnviTest::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
            return $this->extensions[$name][$c];
        } elseif (!isset($this->extensions[$name])) {
            include_once $this->configuration[$name]['class']['resource'];
            $this->extensions[$name] = new $class_name(EnviTest::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
        }
        return $this->extensions[$name];
    }
    /* ----------------------------------------- */

    /**
     * +-- メインのAction実行が完了したタイミングで、暗黙的に実行されるMethodを実行
     *
     * @access public
     * @return void
     */
    public function executeLastShutdownMethod()
    {
        foreach ($this->extensions as $name => $val) {
            $shutdownMethod = false;
            if (isset($this->configuration[$name]['class']['lastShutdownMethod'])) {
                $shutdownMethod = $this->configuration[$name]['class']['lastShutdownMethod'];
            }
            if (!$shutdownMethod) {
                continue;
            }
            if (is_array($val)) {
                foreach ($val as $obj) {
                    $obj->$shutdownMethod();
                }
            } else {
                $val->$shutdownMethod();
            }
        }
    }
    /* ----------------------------------------- */

    public static function _singleton($configuration = NULL)
    {
        if (!isset(self::$instance)) {
            self::$instance = new extension($configuration);
        }
        return self::$instance;
    }

    public function free()
    {
        $this->extensions = array();
    }

}

/**
 * +-- シングルトン
 *
 * @return extension
 */
function extension()
{
    return extension::_singleton();
}
/* ----------------------------------------- */

/**
 * テストAssert
 *
 * EnviTestCaseで継承されます。
 *
 * @package
 * @subpackage
 * @since 0.1
 * @author     fumikazu.kitagawa<kitagawa-f@klab.jp>
 */
class EnviTestAssert
{
    /**
     * +-- 配列にキーがあるかどうか
     *
     * @access public
     * @param string $key
     * @param array $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertArrayHasKey($key, $array, $message = '')
    {
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_key_exists($key, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 配列にキーがないかどうか
     *
     * @access public
     * @param string $key
     * @param array $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertArrayNotHasKey($key, $array, $message = '')
    {
        if (!(!is_array($key) && is_array($array))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_key_exists($key, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 配列に値があるかどうか
     *
     * @access public
     * @param  $value
     * @param array $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertArrayHasValue($value, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($value, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- 配列に値がないかどうか
     *
     * @access public
     * @param  $value
     * @param  $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertArrayNotHasValue($value, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($value, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 配列かどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertArray($a, $message = '')
    {
        if (!(is_array($a))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $className::attribute_name が存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $attribute_name
     * @param  $class_name
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertClassHasAttribute($attribute_name, $class_name, $message = '')
    {
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(array_search($attribute_name, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    /**
     * +-- $className::attribute_name が存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $attribute_name
     * @param  $class_name
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertClassNotHasAttribute($attribute_name, $class_name, $message = '')
    {
        $array = get_class_methods($class_name);
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((array_search($attribute_name, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    /**
     * +-- $valueが$array要素でない場合エラーを返します。
     *
     * assertArrayHasValueとの違いは、$valueにstring以外使用でき無い点です
     *
     * @access public
     * @param  $value
     * @param  $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertContains($value, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(!is_array($value) && array_search($value, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }


    /**
     * +-- $valueが$array要素の場合エラーを返します。
     *
     * assertArrayNotHasValueとの違いは、$valueにstring以外使用でき無い点です
     *
     * @access public
     * @param  $value
     * @param  $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotContains($value, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((!is_array($value) && array_search($value, $array) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    public function assertContainsOnly($type, $array, $message)
    {
        if (!(is_array($array) && !is_array($value))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (!(gettype($value) === $type)) {
                throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        return true;
    }

    /**
     * +-- $arrayの中身の型が $type だけではない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $type
     * @param  $array
     * @param  $message
     * @return boolean
     */
    public function assertNotContainsOnly($type, $array, $message)
    {
        if (!(is_array($array) && !is_array($value))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        foreach ($array as $value) {
            if (!(gettype($value) === $type)) {
                throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
            }
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array の要素数が $count でない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $count
     * @param  $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertCount($count, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(count($array) === $count)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $array の要素数が $count の場合にエラー $message を報告します。
     *
     * @access public
     * @param  $count
     * @param  $array
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotCount($count, $array, $message = '')
    {
        if (!is_array($array)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((count($array) === $count)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 空かどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertEmpty($a, $message = '')
    {
        if (!empty($a)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */
    /**
     * +-- 空でかどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotEmpty($a, $message = '')
    {
        if (empty($a)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */



    /**
     * +-- 同じかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertEquals($a, $b, $message = '')
    {
        if (!($a == $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 違うかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotEquals($a, $b, $message = '')
    {
        if (($a == $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- falseかどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertFalse($a, $message = '')
    {
        if (!($a === false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 同じファイルかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertFileEquals($a, $b, $message = '')
    {
        if (!(file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 同じファイルでないかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertFileNotEquals($a, $b, $message = '')
    {
        if ((file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルが存在するかどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertFileExists($a, $message = '')
    {
        if (!(file_exists($a))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- ファイルが存在しないかどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotFileExists($a, $message = '')
    {
        if ((file_exists($a))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a > $b かどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertGreaterThan($a, $b, $message = '')
    {
        if (!($a > $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a>=$bかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertGreaterThanOrEqual($a, $b, $message = '')
    {
        if (!($a >= $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual が $expected のインスタンスでない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected
     * @param  $actual
     * @return boolean
     */
    public function assertInstanceOf($expected, $actual, $message)
    {
        if (!!is_array($expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!($actual instanceof $expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $actual が $expected のインスタンスの場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected
     * @param  $actual
     * @return boolean
     */
    public function assertNotInstanceOf($expected, $actual, $message)
    {
        if (!!is_array($expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (($actual instanceof $expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $actual の型が $expected でない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected
     * @param  $actual
     * @return boolean
     */
    public function assertInternalType($expected, $actual)
    {
        if (!!is_array($expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(gettype($actual) === $expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */
    /**
     * +-- $actual の型が $expected の場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected
     * @param  $actual
     * @return boolean
     */
    public function assertNotInternalType($expected, $actual)
    {
        if (!!is_array($expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((gettype($actual) === $expected)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<$bかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertLessThan($a, $b, $message = '')
    {
        if (!($a < $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $a<=$bかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertLessThanOrEqual($a, $b, $message = '')
    {
        if (!($a <= $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- Nullかどうか
     *
     * @access public
     * @param  $a
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNull($a, $message = '')
    {
        if (!($a === NULL)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $object->attribute_name が存在しない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $attribute_name
     * @param  $object
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertObjectHasAttribute($attribute_name, $object, $message = '')
    {
        if (!!is_array($attribute_name)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(method_exists($object, $attribute_name) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $object->attribute_name が存在する場合にエラー $message を報告します。
     *
     * @access public
     * @param  $attribute_name
     * @param  $object
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertObjectNotHasAttribute($attribute_name, $object, $message = '')
    {
        if (!!is_array($attribute_name)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((method_exists($object, $attribute_name) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が正規表現 $pattern にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $pattern
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertRegExp($pattern, $string, $message = '')
    {
        if (!!is_array($pattern) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_ereg($pattern, $string) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が正規表現 $pattern にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param  $pattern
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotRegExp($format, $string, $message = '')
    {
        if (!!is_array($format) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_ereg($format, $string) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $string が書式文字列 $format にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $pattern
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringMatchesFormat($pattern, $string, $message = '')
    {
        if (!!is_array($pattern) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(sprintf($pattern, $string) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が書式文字列 $format にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param  $pattern
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringNotMatchesFormat($pattern, $string, $message = '')
    {
        if (!!is_array($pattern) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((sprintf($pattern, $string) === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $formatFile の内容にマッチしない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $format_file
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringMatchesFormatFile($format_file, $string, $message = '')
    {
        if (!!is_array($format_file) || !!is_array($string) || is_file($format_file)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(file_get_contents($format_file) === $string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- $string が $formatFile の内容にマッチする場合にエラー $message を報告します。
     *
     * @access public
     * @param  $format_file
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringNotMatchesFormatFile($format_file, $string, $message = '')
    {
        if (!!is_array($format_file) || !!is_array($string) || is_file($format_file)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((file_get_contents($format_file) === $string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 型と、値が同じかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertSame($a, $b, $message = '')
    {
        if (!($a === $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- 型と、値が違うかどうか
     *
     * @access public
     * @param  $a
     * @param  $b
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertNotSame($a, $b, $message = '')
    {
        if (($a === $b)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $suffix で終わっていない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $suffix
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringEndsWith($suffix, $string, $message = '')
    {
        if (!!is_array($suffix) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $suffix) === mb_strlen($string))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    /**
     * +-- $string が $suffix で終わっている場合にエラー $message を報告します。
     *
     * @access public
     * @param  $suffix
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringNotEndsWith($suffix, $string, $message = '')
    {
        if (!!is_array($suffix) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, $suffix) === mb_strlen($string))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    /**
     * +-- expected_file で指定したファイルの内容に $string が含まれない場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected_file
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringEqualsFile($expected_file, $string, $message = '')
    {
        if (!!is_array($expected_file) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, file_get_contents($expected_file)) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */


    /**
     * +-- expected_file で指定したファイルの内容に $string が含まれる場合にエラー $message を報告します。
     *
     * @access public
     * @param  $expected_file
     * @param  $string
     * @param  $message OPTIONAL:''
     * @return boolean
     */
    public function assertStringNotEqualsFile($suffix, $string, $message = '')
    {
        if (!!is_array($expected_file) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if ((mb_strpos($string, file_get_contents($expected_file)) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }

    /**
     * +-- $string が $suffix で始まっていない場合にエラー $message を報告します。
     *
     * @access public
     * @return boolean
     */
    public function assertStringStartsWith()
    {
        if (!!is_array($suffix) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $suffix) === 0)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    /**
     * +-- $string が $suffix で始まっている場合にエラー $message を報告します。
     *
     * @access public
     * @return boolean
     */
    public function assertStringNotStartsWith()
    {
        if (!!is_array($suffix) || !!is_array($string)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        if (!(mb_strpos($string, $suffix) === 0)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    public function assertTag()
    {

    }
    /**
     * +-- $valueが$containにマッチしない
     *
     * @access public
     * @param  $value
     * @param EnviTestContain $contain
     * @return boolean
     */
    public function assertThat($value, EnviTestContain $contain)
    {
        if (!($contain->execute($value))) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */
    /**
     * +-- trueかどうか
     *
     * @access public
     * @param  $a
     * @return boolean
     */
    public function assertTrue($a)
    {
        if (!($a === true)) {
            throw new EnviTestException(__METHOD__.' '.$this->toString(func_get_args()));
        }
        return true;
    }
    /* ----------------------------------------- */

    public function free()
    {
    }

    /**
     * +-- 配列を文字列にする
     *
     * @access public
     * @param array $arr
     * @return string
     */
    public function toString($arr){
        $str = '';
        foreach ($arr as $val) {
            if (is_array($val)) {
                $str .= "{".$this->toString($val).'}';
                continue;
            }
            $val = (string)$val;
            $str .= ",{$val}";
        }
        return $str;
    }
    /* ----------------------------------------- */


}


/**
 * テストケースクラスで継承されるクラス
 *
 * @package Envi3
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
abstract class EnviTestCase extends EnviTestAssert
{
    public $get         = array();
    public $post        = array();
    public $headers     = array();
    public $cookie      = array();
    public $request_method = 'POST';
    private $request_url = '';

    public $system_conf;

    public function __construct()
    {
    }

    private function getContext($request_method, $post, $headers_arr, $cookie)
    {

        $headers_arr_sub = array();
        foreach ($headers_arr as $k => $value) {
            $headers_arr_sub[strtolower($k)] = trim($value);
        }
        $headers_arr = $headers_arr_sub;
        unset($headers_arr_sub);

        if (count($cookie)) {
            $headers_arr['cookie'] = "";
            foreach ($cookie as $k => $v) {
                $headers_arr['cookie'] = " $k=$v;";
            }
        }
        $headers = array();
        foreach ($headers_arr as $k => $value) {
            $headers[] = "{$k}: $value";
        }

        if ($request_method === 'GET') {
            $opts = array(
                'http' => array(
                    'method' => $request_method,
                    'header'=> join("\r\n", $headers)."\r\n"
                )
            );
        } else {
            $data_url       = http_build_query ($post);
            $data_length    = strlen ($data_url);
            $headers[] = 'Content-Length: '.$data_length;
            $opts = array(
                'http' => array(
                    'method' => $request_method,
                    'header'=> join("\r\n", $headers)."\r\n",
                    'content' => $data_url
                )
            );
        }
        return stream_context_create($opts);
    }


    abstract public function initialize();

    abstract public function shutdown();

    /**
     * +-- テストの実行
     *
     * @access private
     * @return string
     */
    final protected function emulateExecute($_request_method = false)
    {
        $get         = (array)$this->system_conf['parameter']['get'];
        $post        = (array)$this->system_conf['parameter']['post'];
        $headers     = (array)$this->system_conf['parameter']['headers'];
        $cookie      = (array)$this->system_conf['parameter']['cookie'];
        $request_method    = $this->system_conf['parameter']['request_method'];

        $get    = array_merge($get, $this->get);
        $post   = array_merge($post, $this->post);
        $headers = array_merge($headers, $this->headers);
        $cookie = array_merge($cookie, $this->cookie);
        $request_method    = $_request_method ? $_request_method : $request_method;
        $context = $this->getContext($request_method, $post, $headers, $cookie);
        $query_string = count($get) ? '?'.http_build_query($get) : '';
        // echo $this->request_url.$query_string."\n";
        // $aa = debug_backtrace();
        // var_dump($aa[0]['file'].$aa[0]['line']);
        $contents = file_get_contents($this->request_url.$query_string, false, $context);
        return array($http_response_header, $contents);
    }


    final public function setModuleAction($module, $action)
    {
        $this->request_url = $this->system_conf['app']['url']."/{$module}/{$action}";
    }



}

/**
 * シナリオクラスで継承されるクラス
 *
 * @package Envi3
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviTestScenario
{
    public $system_conf;


    /**
     * +-- 実行するスイートのリストを返す
     *
     * @access public
     * @return array
     */
    public function execute()
    {
        return $this->getTestByDir(dirname($this->system_conf['scenario']['path']));
    }
    /* ----------------------------------------- */

    /**
     * +-- DIRECTORYの再帰検索
     *
     * @access public
     * @param  $dir_name
     * @param  $node OPTIONAL:0
     * @param  $arr OPTIONAL:array
     * @return array
     */
    public function getTestByDir($dir_name, $node = 0, $arr = array())
    {
        if (is_dir($dir_name)) {
            if ($dh = opendir($dir_name)) {
                while (($file = readdir($dh)) !== false) {
                    if (!strpos($file, 'Test')) {
                        continue;
                    }
                    if (is_dir($dir_name.DIRECTORY_SEPARATOR.$file)) {
                        $arr = $this->getTestByDir($dir_name.DIRECTORY_SEPARATOR.$file, $node +1, $arr);
                    }
                    if (is_file($dir_name.DIRECTORY_SEPARATOR.$file) && $node > 0) {
                        $arr[] = array(
                            'class_path' => $dir_name.DIRECTORY_SEPARATOR.$file,
                            'class_name' => str_replace(array('.class.php', '.php'), '', $file)
                        );
                    }
                }
                closedir($dh);
            }
        }
        return $arr;
    }
    /* ----------------------------------------- */

}


