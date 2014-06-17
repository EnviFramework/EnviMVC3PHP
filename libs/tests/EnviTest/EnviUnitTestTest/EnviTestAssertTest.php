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
 * @see        http://www.enviphp.net/c/man/v3/reference
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
 * @see        http://www.enviphp.net/c/man/v3/reference
 * @since      File available since Release 1.0.0
*/
class UTEnviTestAssert extends envitest\unit\EnviTestAssert
{

}

class BlankClassByTestAssert{}

class HasAttributeAssert
{
    public $public_var;
    protected $protected_var;
    private $private_var;
}


class HasMethodAssert
{
    public function publicMethod()
    {
    }
    protected function protectedMethod()
    {
    }
    private function privateMethod()
    {
    }
}

class ThatAssert extends envitest\unit\EnviTestContain
{
    public function execute($val)
    {
        return $val;
    }
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
 * @see        http://www.enviphp.net/c/man/v3/reference
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
        list($e, $res) = $this->callAssert('assertInstanceOf', __CLASS__, $this);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertInstanceOf', __CLASS__.'asdf', $this);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotInstanceOf
     */
    public function assertNotInstanceOfTest()
    {
        list($e, $res) = $this->callAssert('assertNotInstanceOf', __CLASS__, $this);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotInstanceOf', __CLASS__.'asdf', $this);
        $this->assertNull($e);
        $this->assertTrue($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertInternalType
     */
    public function assertInternalTypeTest()
    {
        list($e, $res) = $this->callAssert('assertInternalType', 'integer', 13456);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertInternalType', 'integer', '123456');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertInternalType', 'integer', 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotInternalType
     */
    public function assertNotInternalTypeTest()
    {
        list($e, $res) = $this->callAssert('assertNotInternalType', 'integer', 13456);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertNotInternalType', 'integer', '123456');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertNotInternalType', 'integer', 'adf146');
        $this->assertNull($e);
        $this->assertTrue($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertLessThan
     */
    public function assertLessThanTest()
    {
        list($e, $res) = $this->callAssert('assertLessThan', 1, 2);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertLessThan', 1, 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertLessThan', 2, 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertLessThanOrEqual
     */
    public function assertLessThanOrEqualTest()
    {
        list($e, $res) = $this->callAssert('assertLessThanOrEqual', 1, 2);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertLessThanOrEqual', 1, 1);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertLessThanOrEqual', 2, 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNull
     * @group EnviUnitTestLast
     */
    public function assertNullTest()
    {
        list($e, $res) = $this->callAssert('assertNull', NULL);
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertNull', '');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectHasAttribute
     * @group EnviUnitTestLast
     */
    public function assertObjectHasAttributeTest()
    {
        $HasAttributeAssert = new HasAttributeAssert;
        list($e, $res) = $this->callAssert('assertObjectHasAttribute', 'public_var', $HasAttributeAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectHasAttribute', 'protected_var', $HasAttributeAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectHasAttribute', 'private_var', $HasAttributeAssert);
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertObjectHasAttribute', __CLASS__.'asdf', $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectHasAttribute', array('private_var'), $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectNotHasAttribute
     * @group EnviUnitTestLast
     */
    public function assertObjectNotHasAttributeTest()
    {
        $HasAttributeAssert = new HasAttributeAssert;
        list($e, $res) = $this->callAssert('assertObjectNotHasAttribute', 'public_var', $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasAttribute', 'protected_var', $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasAttribute', 'private_var', $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertObjectNotHasAttribute', __CLASS__.'asdf', $HasAttributeAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasAttribute', array('private_var'), $HasAttributeAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }



    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectHasMethod
     * @group EnviUnitTestLast
     */
    public function assertObjectHasMethodTest()
    {
        $HasMethodAssert = new HasMethodAssert;
        list($e, $res) = $this->callAssert('assertObjectHasMethod', 'publicMethod', $HasMethodAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectHasMethod', 'protectedMethod', $HasMethodAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectHasMethod', 'privateMethod', $HasMethodAssert);
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertObjectHasMethod', __CLASS__.'asdf', $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectHasMethod', array('privateMethod'), $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertObjectNotHasMethod
     * @group EnviUnitTestLast
     */
    public function assertObjectNotHasMethodTest()
    {
        $HasMethodAssert = new HasMethodAssert;
        list($e, $res) = $this->callAssert('assertObjectNotHasMethod', 'publicMethod', $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasMethod', 'protectedMethod', $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasMethod', 'privateMethod', $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertObjectNotHasMethod', __CLASS__.'asdf', $HasMethodAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertObjectNotHasMethod', array('privateMethod'), $HasMethodAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }


    /**
     * @cover envitest\unit\EnviTestAssert::assertRegExp
     * @group EnviUnitTestLast
     */
    public function assertRegExpTest()
    {
        list($e, $res) = $this->callAssert('assertRegExp', '^.*$', '123456');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertRegExp', '^[0-9]+$', 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertRegExp', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertRegExp', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotRegExp
     * @group EnviUnitTestLast
     */
    public function assertNotRegExpTest()
    {
        list($e, $res) = $this->callAssert('assertNotRegExp', '^.*$', '123456');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertNotRegExp', '^[0-9]+$', 'adf146');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertNotRegExp', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotRegExp', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertPregMatch
     * @group EnviUnitTestLast
     */
    public function assertPregMatchTest()
    {
        list($e, $res) = $this->callAssert('assertPregMatch', '/^.*$/', '123456');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertPregMatch', '/^[0-9]+$/', 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertPregMatch', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertPregMatch', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotPregMatch
     * @group EnviUnitTestLast
     */
    public function assertNotPregMatchTest()
    {
        list($e, $res) = $this->callAssert('assertNotPregMatch', '/^.*$/', '123456');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertNotPregMatch', '/^[0-9]+$/', 'adf146');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertNotPregMatch', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotPregMatch', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringMatchesFormat
     * @group EnviUnitTestLast
     */
    public function assertStringMatchesFormatTest()
    {
        list($e, $res) = $this->callAssert('assertStringMatchesFormat', '%f', '1.456878');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringMatchesFormat', '%dab', '14568789ab');
        $this->assertNull($e);
        $this->assertTrue($res);

        list($e, $res) = $this->callAssert('assertStringMatchesFormat', '%d', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertStringMatchesFormat', '', 'あいうえおかきくけ');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertStringMatchesFormat', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringMatchesFormat', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotMatchesFormat
     * @group EnviUnitTestLast
     */
    public function assertStringNotMatchesFormatTest()
    {
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormat', '%f', '1.456878');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormat', '%dab', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        list($e, $res) = $this->callAssert('assertStringNotMatchesFormat', '%d', '14568789ab');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormat', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormat', array('^[0-9]+$'), 'adf146');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringMatchesFormatFile
     * @group EnviUnitTestTestByMock
     */
    public function assertStringMatchesFormatFileTest()
    {
        $mock = EnviMock::mock('envitest\unit\EnviTestAssert');
        $mock->shouldReceive('fileGetContents')
            ->with(__FILE__)
            ->once()
            ->andReturn('%f');
        list($e, $res) = $this->callAssert('assertStringMatchesFormatFile', __FILE__, '1.456878');
        $this->assertNull($e);
        $this->assertTrue($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%dab');
        list($e, $res) = $this->callAssert('assertStringMatchesFormatFile', __FILE__, '14568789ab');
        $this->assertNull($e);
        $this->assertTrue($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringMatchesFormatFile', __FILE__, '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);


        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringMatchesFormatFile', '%d', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotMatchesFormatFile
     * @group EnviUnitTestTestByMock
     */
    public function assertStringNotMatchesFormatFileTest()
    {
        $mock = EnviMock::mock('envitest\unit\EnviTestAssert');
        $mock->shouldReceive('fileGetContents')
            ->with(__FILE__)
            ->once()
            ->andReturn('%f');
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormatFile', __FILE__, '1.456878');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%dab');
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormatFile', __FILE__, '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormatFile', __FILE__, '14568789ab');
        $this->assertNull($e);
        $this->assertTrue($res);

        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotMatchesFormatFile', '%d', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertSame
     * @group EnviUnitTestLast
     */
    public function assertSameTest()
    {
        list($e, $res) = $this->callAssert('assertSame', array('aaa' => 'aaa'), array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertSame', 'bbb', array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertSame', '1', 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertSame', 1, 1);
        $this->assertNull($e);
        $this->assertTrue($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertNotSame
     * @group EnviUnitTestLast
     */
    public function assertNotSameTest()
    {
        list($e, $res) = $this->callAssert('assertNotSame', array('aaa' => 'aaa'), array('aaa' => 'aaa'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertNotSame', 'bbb', array('aaa' => 'aaa'));
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotSame', '1', 1);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertNotSame', 1, 1);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringEndsWith
     * @group EnviUnitTestLast
     */
    public function assertStringEndsWithTest()
    {
        list($e, $res) = $this->callAssert('assertStringEndsWith', '1', 'asdfasdfasdfa1');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringEndsWith', 'a', 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringEndsWith', array('a'), 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringEndsWith', 'a', array('asdfasdfasdfa1'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotEndsWith
     * @group EnviUnitTestLast
     */
    public function assertStringNotEndsWithTest()
    {
        list($e, $res) = $this->callAssert('assertStringNotEndsWith', '1', 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotEndsWith', 'a', 'asdfasdfasdfa1');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringNotEndsWith', array('a'), 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotEndsWith', 'a', array('asdfasdfasdfa1'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringEqualsFile
     * @group EnviUnitTestTestByMock
     */
    public function assertStringEqualsFileTest()
    {
        $mock = EnviMock::mock('envitest\unit\EnviTestAssert');
        $mock->shouldReceive('fileGetContents')
            ->with(__FILE__)
            ->once()
            ->andReturn('1.456878');
        list($e, $res) = $this->callAssert('assertStringEqualsFile', __FILE__, '1.456878');
        $this->assertNull($e);
        $this->assertTrue($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringEqualsFile', __FILE__, '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringEqualsFile', '%d', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);


        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringEqualsFile', array('%d'), '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);


        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringEqualsFile', '%d', array('14568789ab'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotEqualsFile
     * @group EnviUnitTestTestByMock
     */
    public function assertStringNotEqualsFileTest()
    {
        $mock = EnviMock::mock('envitest\unit\EnviTestAssert');
        $mock->shouldReceive('fileGetContents')
            ->with(__FILE__)
            ->once()
            ->andReturn('1.456878');
        list($e, $res) = $this->callAssert('assertStringNotEqualsFile', __FILE__, '1.456878');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

        $mock->recycle('fileGetContents')
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotEqualsFile', __FILE__, '14568789ab');
        $this->assertNull($e);
        $this->assertTrue($res);

        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotEqualsFile', '%d', '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotEqualsFile', array('%d'), '14568789ab');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);


        $mock->recycle('fileGetContents')
            ->never()
            ->andReturn('%d');
        list($e, $res) = $this->callAssert('assertStringNotEqualsFile', '%d', array('14568789ab'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);

    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringStartsWith
     * @group EnviUnitTestLast
     */
    public function assertStringStartsWithTest()
    {
        list($e, $res) = $this->callAssert('assertStringStartsWith', 'a', 'asdfasdfasdfa1');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringStartsWith', 'd', 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringStartsWith', array('a'), 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringStartsWith', 'a', array('asdfasdfasdfa1'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertStringNotStartsWith
     * @group EnviUnitTestLast
     */
    public function assertStringNotStartsWithTest()
    {
        list($e, $res) = $this->callAssert('assertStringNotStartsWith', 'a', 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotStartsWith', 'd', 'asdfasdfasdfa1');
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertStringNotStartsWith', array('a'), 'asdfasdfasdfa1');
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertStringNotStartsWith', 'a', array('asdfasdfasdfa1'));
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertTag
     */
    public function assertTagTest()
    {
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertThat
     * @group EnviUnitTestLast
     */
    public function assertThatTest()
    {
        $ThatAssert = new ThatAssert;
        list($e, $res) = $this->callAssert('assertThat', true, $ThatAssert);
        $this->assertNull($e);
        $this->assertTrue($res);
        list($e, $res) = $this->callAssert('assertThat', false, $ThatAssert);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
    }

    /**
     * @cover envitest\unit\EnviTestAssert::assertTrue
     * @group EnviUnitTestLast
     */
    public function assertTrueTest()
    {
        list($e, $res) = $this->callAssert('assertTrue', false);
        $this->assertInstanceOf('envitest\unit\EnviTestException', $e);
        $this->assertFalse($res);
        list($e, $res) = $this->callAssert('assertTrue', true);
        $this->assertNull($e);
        $this->assertTrue($res);
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
