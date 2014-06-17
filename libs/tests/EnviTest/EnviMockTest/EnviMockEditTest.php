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
require_once dirname(dirname(__FILE__)).'/data/example.php';

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
 * @group EnviMockTest
 * @group small
 */
class EnviMockEditTest extends testCaseBase
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
     * +--
     *
     * @access      public
     * @return      void
     */
    public function mockDataProvider()
    {
        $example = envitest\unit\EnviMock::mock('example');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example);

        $example1 = envitest\unit\EnviMock::mock('example1');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example1);

        $dummyExample = envitest\unit\EnviMock::mock('dummyExample');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $dummyExample);
        $this->assertTrue(class_exists('dummyExample', false));

        return array(array($example, $example1, $dummyExample));
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::getMethods
     */
    public function getMethodsTest($mock_list)
    {
        $this->assertArray($mock_list[0]->getMethods());
        $this->assertArrayHasValue('doSomething', $mock_list[0]->getMethods());
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::getClassName
     */
    public function getClassNameTest($mock_list)
    {
        $this->assertEquals('example', $mock_list[0]->getClassName());
    }
    /* ----------------------------------------- */
    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::isAdapt
     */
    public function isAdaptTest($mock_list)
    {
        $this->assertTrue($mock_list[0]->isAdapt());
        $this->assertFalse($mock_list[1]->isAdapt());
    }
    /* ----------------------------------------- */



    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::blankMethod
     */
    public function blankMethodTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertEquals('test', $test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethod('doSomething'));
        $this->assertCount(6, $mock_list[0]->getMethods());
        $this->assertArrayHasValue('doSomething', $mock_list[0]->getMethods());
        $this->assertNull($test_class->doSomething('test'));
        return $mock_list;

    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @depends     blankMethodTest
     * @cover envitest\unit\EnviMockEditorRunkit::removeMethod
     */
    public function removeMethodTest($mock_list)
    {
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->removeMethod('doSomething2'));
        $this->assertArray($mock_list[0]->getMethods());
        $this->assertArrayNotHasValue('doSomething2', $mock_list[0]->getMethods());
        $this->assertCount(5, $mock_list[0]->getMethods());
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->removeMethod('doNothing'));
        $this->assertCount(5, $mock_list[0]->getMethods());

        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethod('doSomething3'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->removeMethod('doSomething3'));
        $this->assertArray($mock_list[0]->getMethods());
        $this->assertArrayNotHasValue('doSomething3', $mock_list[0]->getMethods());

        // 存在しないMethodを作成削除
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethod('dummyBlankMethod'));
        $this->assertArrayHasValue('dummyBlankMethod', $mock_list[0]->getMethods());
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->removeMethod('dummyBlankMethod'));
        $this->assertArrayNotHasValue('dummyBlankMethod', $mock_list[0]->getMethods());
        return $mock_list;

    }



    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @depends     removeMethodTest
     * @cover envitest\unit\EnviMockEditorRunkit::restoreMethod
     */
    public function restoreMethodTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->restoreMethod('doSomething'));
        $this->assertEquals('test', $test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->restoreMethod('doAnything'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->restoreMethod('doSomething2'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->restoreMethod('doSomething3'));
        $this->assertCount(6, $mock_list[0]->getMethods());

        // runkitのバグ対策
        $method = 'do'.'Something2';
        $this->assertArrayHasValue($method, $mock_list[0]->getMethods());

        $method = 'do'.'Something3';
        $this->assertArrayHasValue($method, $mock_list[0]->getMethods());
    }


    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::blankMethodAll
     */
    public function blankMethodAllTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertEquals('test', $test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethodAll());
        $this->assertCount(6, $mock_list[0]->getMethods());
        $this->assertNull($test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[1]->blankMethodAll());
        $this->assertCount(0, $mock_list[1]->getMethods());
        return $mock_list;
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @depends     blankMethodAllTest
     * @cover envitest\unit\EnviMockEditorRunkit::restoreAll
     */
    public function restoreAllTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $mock_list[0]->blankMethod('exampleTest');
        $this->assertNull($test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->restoreAll());
        $this->assertCount(6, $mock_list[0]->getMethods());
        $this->assertEquals('test', $test_class->doSomething('test'));

        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[1]->restoreAll());
        $this->assertCount(0, $mock_list[1]->getMethods());

        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[2]->restoreAll());
        return $mock_list;
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @return      void
     * @depends     restoreAllTest
     * @cover envitest\unit\EnviMockEditorRunkit::blankMethodByArray
     */
    public function blankMethodByArrayTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertEquals('test', $test_class->doSomething('test'));
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethodByArray(array('doSomething', 'doSomething2', 'exampleTest')));
        $mock_list[0]->blankMethod('exampleTest');
        $this->assertNull($test_class->doSomething('test'));
        $this->assertNull($test_class->doSomething2());
        $this->assertCount(7, $mock_list[0]->getMethods());


        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[0]->blankMethodByArray(array()));
        $mock_list[0]->blankMethod('exampleTest');
        $this->assertNull($test_class->doSomething('test'));
        $this->assertNull($test_class->doSomething2());
        $this->assertCount(7, $mock_list[0]->getMethods());
        $mock_list[0]->restoreAll();
        return $mock_list;
    }


    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::emancipate
     */
    public function emancipateTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertCount(6, $mock_list[0]->getMethods());
        $this->assertTrue($mock_list[0]->isAdapt());
        $mock_list[0]->emancipate();
        $this->assertFalse($mock_list[0]->isAdapt());
        $this->assertCount(3, $mock_list[0]->getMethods());
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $mock_list[1]->emancipate());
        return $mock_list;
    }
    /* ----------------------------------------- */

    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @dataProvider     mockDataProvider
     * @cover envitest\unit\EnviMockEditorRunkit::adopt
     */
    public function adoptTest($mock_list)
    {
        $test_class_name = $mock_list[1]->getClassName();
        $test_class = new $test_class_name;
        $this->assertCount(0, $mock_list[1]->getMethods());

        // 存在しないクラスなので、warning対策
        @$mock_list[1]->adopt('aaaa');
        $this->assertCount(0, $mock_list[1]->getMethods());
        $this->assertFalse($mock_list[1]->isAdapt());


        $mock_list[1]->adopt('exampleBase');
        $this->assertTrue($mock_list[1]->isAdapt());
        $this->assertCount(3, $mock_list[1]->getMethods());
        return $mock_list;
    }
    /* ----------------------------------------- */


    /**
     * +--
     *
     * @access      public
     * @param       var_text $mock_list
     * @depends     emancipateTest
     * @cover envitest\unit\EnviMockEditorRunkit::restoreExtends
     */
    public function restoreExtendsTest($mock_list)
    {
        $test_class_name = $mock_list[0]->getClassName();
        $test_class = new $test_class_name;
        $this->assertCount(3, $mock_list[0]->getMethods());
        $mock_list[0]->restoreExtends();
        $this->assertCount(6, $mock_list[0]->getMethods());
        $mock_list[1]->restoreExtends();
        $this->assertCount(0, $mock_list[1]->getMethods());
        return $mock_list;
    }
    /* ----------------------------------------- */



    /**
     * +-- 終了処理
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }


    /**
     * +--
     *
     * @access      public
     * @static
     * @return      void
     * @afterClass
     */
    public static function shutDownAfterClass()
    {
        envitest\unit\EnviMock::free();
        EnviMock::free();
    }
    /* ----------------------------------------- */
}
