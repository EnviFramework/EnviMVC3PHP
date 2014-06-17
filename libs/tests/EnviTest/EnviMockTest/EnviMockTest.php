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
class EnviMockTest extends testCaseBase
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
     * @cover envitest\unit\EnviMock::addMockClass
     * @cover envitest\unit\EnviMock::mock
     * @cover envitest\unit\EnviMockEditorRunkit::__construct
     */
    public function mockMultiTest()
    {
        $example = envitest\unit\EnviMock::mock('example');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example);
        return $example;
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover envitest\unit\EnviMock::addMockClass
     * @cover envitest\unit\EnviMock::mock
     * @cover envitest\unit\EnviMockEditorRunkit::__construct
     */
    public function mockSingleTest()
    {
        $example1 = envitest\unit\EnviMock::mock('example1');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example1);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @cover envitest\unit\EnviMock::addMockClass
     * @cover envitest\unit\EnviMock::mock
     * @cover envitest\unit\EnviMockEditorRunkit::__construct
     */
    public function mockBlankTest()
    {
        $dummyExample = envitest\unit\EnviMock::mock('dummyExample');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $dummyExample);
        $this->assertTrue(class_exists('dummyExample', false));
    }


    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     mockMultiTest
     * @cover envitest\unit\EnviMock::addMockClass
     * @cover envitest\unit\EnviMock::mock
     * @cover envitest\unit\EnviMockEditorRunkit::__construct
     */
    public function mockCacheTest($example)
    {
        // キャッシュの確認
        $example_ref = envitest\unit\EnviMock::mock('example');
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example_ref);
        $this->assertEquals(spl_object_hash($example), spl_object_hash($example_ref));

    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @depends     mockMultiTest
     * @cover envitest\unit\EnviMock::addMockClass
     * @cover envitest\unit\EnviMock::mock
     * @cover envitest\unit\EnviMockEditorRunkit::__construct
     */
    public function mockNoCacheTest($example)
    {
        // noキャッシュの確認
        $example_clone = envitest\unit\EnviMock::mock('example', false, false);
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $example);
        $this->assertNotEquals(spl_object_hash($example), spl_object_hash($example_clone));
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
