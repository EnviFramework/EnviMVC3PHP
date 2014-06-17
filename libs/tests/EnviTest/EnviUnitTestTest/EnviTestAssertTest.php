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


/**
 *
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
class UTEnviTestAssert extends envitest\unit\EnviTestAssert
{

}

class BlankClassByTestAssert{}


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
 * @group EnviUnitTestTest
 * @group small
 */
class EnviTestAssertTest extends testCaseBase
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
        $envi_test = new UTEnviTestAssert;
        return array($envi_test);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertArrayHasKey
     */
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
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertArrayNotHasKey
     */
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
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertArrayHasValue
     */
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
        list($e, $res) = $this->callAssert('assertArrayHasValue', array('aaa' => 'aaa'), array('aaa' => 'aaa', 2 => array('aaa' => 'aaa')));
        $this->assertNull($e);
        $this->assertTrue($res);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertArrayNotHasValue
     */
    public function assertArrayNotHasValueTest()
    {
        list($e, $res) = $this->callAssert('assertArrayNotHasValue', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasValue', 'aaa', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasValue', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertArrayNotHasValue', array('aaa' => 'aaa'), array('aaa' => 'aaa',array('aaa' => 'aaa')));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertArray
     */
    public function assertArrayTest()
    {
        list($e, $res) = $this->callAssert('assertArray', array('aaa' => 'aaa'), 'bbb');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertArray', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertClassHasAttribute
     */
    public function assertClassHasAttributeTest()
    {
        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'exec', '\PDO');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'exec', 'BlankClassByTestAssert');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'bbbbb', '\PDO');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertClassHasAttribute', 'exec', '\PDOaaaaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertClassNotHasAttribute
     */
    public function assertClassNotHasAttributeTest()
    {
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'bbb', '\PDO');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', 'BlankClassByTestAssert');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', '\PDO');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertClassNotHasAttribute', 'exec', '\PDOaaaaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertFileExists
     */
    public function assertFileExistsTest()
    {
        list($e, $res) = $this->callAssert('assertFileExists', __FILE__);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertFileExists',  __FILE__.'aafasasas');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertNotFileExists
     */
    public function assertNotFileExistsTest()
    {
        list($e, $res) = $this->callAssert('assertNotFileExists', __FILE__.'aafasasas');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotFileExists',  __FILE__);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertEmpty
     */
    public function assertEmptyTest()
    {
        list($e, $res) = $this->callAssert('assertEmpty', '');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertEmpty',  __FILE__.'aafasasas');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover       envitest\unit\EnviTestAssert::assertNotEmpty
     */
    public function assertNotEmptyTest()
    {
        list($e, $res) = $this->callAssert('assertNotEmpty', '');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotEmpty',  __FILE__.'aafasasas');
        $this->assertNull($e);
        $this->assertTrue($res);
    }
    /* ----------------------------------------- */


    /**
     * @cover envitest\unit\EnviTestAssert::assertContains
     */
    public function assertContainsTest()
    {
        list($e, $res) = $this->callAssert('assertContains', 'aaa', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertContains', 'bbb', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertContains', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertContains', array('aaa' => 'aaa'), array('aaa' => 'aaa', array(array('aaa' => 'aaa'))));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotContains
     */
    public function assertNotContainsTest()
    {
        list($e, $res) = $this->callAssert('assertNotContains', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotContains', 'aaa', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotContains', 'aaa', 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotContains', array(array(array('aaa' => 'aaa'))), array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertContainsOnly
     */
    public function assertContainsOnlyTest()
    {
        list($e, $res) = $this->callAssert('assertContainsOnly', 'string', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertContainsOnly', 'integer', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertContainsOnly', 'integer', array(1, 'aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertContainsOnly', array('integer'), array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotContainsOnly
     */
    public function assertNotContainsOnlyTest()
    {
        list($e, $res) = $this->callAssert('assertNotContainsOnly', 'integer', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotContainsOnly', 'string', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotContainsOnly', 'integer', array('1', 'aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotContainsOnly', array('string'), array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertCount
     */
    public function assertCountTest()
    {
        list($e, $res) = $this->callAssert('assertCount', 2, array('aaa' => 'aaa', '123'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertCount', 2, array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertCount', 1, 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotCount
     */
    public function assertNotCountTest()
    {
        list($e, $res) = $this->callAssert('assertNotCount', 1, array('aaa' => 'aaa', '123'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotCount', 1, array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotCount', 1, 'aaa');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertEquals
     */
    public function assertEqualsTest()
    {
        list($e, $res) = $this->callAssert('assertEquals', array('aaa' => 'aaa'), array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertEquals', 'bbb', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertEquals', '1', 1);
        $this->assertNull($e);
        $this->assertTrue($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotEquals
     */
    public function assertNotEqualsTest()
    {
        list($e, $res) = $this->callAssert('assertNotEquals', array('aaa' => 'aaa'), array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotEquals', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotEquals', '1', 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertFalse
     */
    public function assertFalseTest()
    {
        list($e, $res) = $this->callAssert('assertFalse', false);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertFalse', true);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertFileEquals
     */
    public function assertFileEqualsTest()
    {
        list($e, $res) = $this->callAssert('assertFileEquals', __FILE__, __FILE__);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertFileEquals',  __FILE__, __FILE__.'aafasasas');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertFileEquals',  dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'scenario.php');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertFileNotEquals
     */
    public function assertFileNotEqualsTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertGreaterThan
     */
    public function assertGreaterThanTest()
    {
        list($e, $res) = $this->callAssert('assertGreaterThan', 2, 1);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertGreaterThan', 1, 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertGreaterThan', 1, 2);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertGreaterThanOrEqual
     */
    public function assertGreaterThanOrEqualTest()
    {
        list($e, $res) = $this->callAssert('assertGreaterThanOrEqual', 2, 1);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertGreaterThanOrEqual', 1, 1);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertGreaterThanOrEqual', 1, 2);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertInstanceOf
     */
    public function assertInstanceOfTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotInstanceOf
     */
    public function assertNotInstanceOfTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertInternalType
     */
    public function assertInternalTypeTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotInternalType
     */
    public function assertNotInternalTypeTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertLessThan
     */
    public function assertLessThanTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertLessThanOrEqual
     */
    public function assertLessThanOrEqualTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNull
     */
    public function assertNullTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectHasAttribute
     */
    public function assertObjectHasAttributeTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectNotHasAttribute
     */
    public function assertObjectNotHasAttributeTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertRegExp
     */
    public function assertRegExpTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotRegExp
     */
    public function assertNotRegExpTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertPregMatch
     */
    public function assertPregMatchTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotPregMatch
     */
    public function assertNotPregMatchTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringMatchesFormat
     */
    public function assertStringMatchesFormatTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotMatchesFormat
     */
    public function assertStringNotMatchesFormatTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringMatchesFormatFile
     */
    public function assertStringMatchesFormatFileTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotMatchesFormatFile
     */
    public function assertStringNotMatchesFormatFileTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertSame
     */
    public function assertSameTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotSame
     */
    public function assertNotSameTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringEndsWith
     */
    public function assertStringEndsWithTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotEndsWith
     */
    public function assertStringNotEndsWithTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringEqualsFile
     */
    public function assertStringEqualsFileTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotEqualsFile
     */
    public function assertStringNotEqualsFileTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringStartsWith
     */
    public function assertStringStartsWithTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotStartsWith
     */
    public function assertStringNotStartsWithTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertTag
     */
    public function assertTagTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertThat
     */
    public function assertThatTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertTrue
     */
    public function assertTrueTest()
    {
    }


    private function callAssert($method_name, $a, $b = '')
    {
        static $envi_test;
        if (!$envi_test) {
            $envi_test = new UTEnviTestAssert;
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
