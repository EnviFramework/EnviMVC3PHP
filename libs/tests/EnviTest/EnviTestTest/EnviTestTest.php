<?php
/**
 *
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */

class UTEnviTest extends envitest\unit\EnviTestAssert
{

}

/**
 *
 *
 *
 * PHP versions 5
 *
 *
 *
 * @category   テスト
 * @package    テスト
 * @subpackage TestCode
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
class EnviTestTest extends testCaseBase
{
    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
        $this->free();
    }
    /* ----------------------------------------- */

    /**
     * +-- データプロバイダ
     *
     * @access      public
     * @return      void
     */
    public function provider()
    {
        $envi_test = new UTEnviTest;
        return array($envi_test);
    }
    /* ----------------------------------------- */


    public function assertArrayHasKeyTest()
    {
        list($e, $res) = $this->callAssert('assertArrayHasKey', 'aaa', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArrayHasKey', 'bbb', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayHasKey', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertArrayNotHasKeyTest()
    {
        list($e, $res) = $this->callAssert('assertArrayNotHasKey', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasKey', 'aaa', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasKey', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }



    public function assertArrayHasValueTest()
    {
        list($e, $res) = $this->callAssert('assertArrayHasValue', 'aaa', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArrayHasValue', 'bbb', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayHasValue', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertArrayNotHasValueTest()
    {
        list($e, $res) = $this->callAssert('assertArrayNotHasValue', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasKey', 'aaa', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasKey', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertArrayTest()
    {
        list($e, $res) = $this->callAssert('assertArray', array('aaa' => 'aaa'), 'bbb');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArray', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertClassHasAttributeTest()
    {
        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'exec', '\PDO');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'bbbbb', '\PDO');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', '\PDOaaaaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }



    public function assertClassNotHasAttributeTest()
    {
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'bbb', '\PDO');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', '\PDO');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', '\PDOaaaaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }


    public function assertFileExistsTest()
    {
        list($e, $res) = $this->callAssert('assertFileExists', __FILE__);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertFileExists',  __FILE__.'aafasasas');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertNotFileExistsTest()
    {
        list($e, $res) = $this->callAssert('assertNotFileExists', __FILE__.'aafasasas');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotFileExists',  __FILE__);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }


    public function assertEmptyTest()
    {
        list($e, $res) = $this->callAssert('assertEmpty', '');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertEmpty',  __FILE__.'aafasasas');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    public function assertNotEmptyTest()
    {
        list($e, $res) = $this->callAssert('assertNotEmpty', '');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotEmpty',  __FILE__.'aafasasas');
        $this->assertNull($e);
        $this->assertTrue($res);
    }

    private function callAssert($method_name, $a, $b = '')
    {
        static $envi_test;
        if (!$envi_test) {
            $envi_test = new UTEnviTest;
        }
        $e = NULL;
        $res = false;
        try {
            $res = $envi_test->$method_name($a, $b);
        } catch (exception $e) {

        }
        return array($e, $res);
    }

    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }

}
