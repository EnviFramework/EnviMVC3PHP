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
class EnviStabTest extends testCaseBase
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
        return array($example);
    }

    /**
     * +--
     *
     * @access      public
     * @return      void
     * @dataProvider     mockDataProvider
     * @cover       envitest\unit\EnviMockEditorRunkit::free
     * @cover       envitest\unit\EnviMockEditorRunkit::shouldReceive
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::unsetAttributeMethodAll
     * @cover       envitest\unit\EnviMockEditorRunkit::resetContainer
     */
    public function shouldReceiveTest($example)
    {
        $EnviMockContainer = EnviMock::mock('envitest\unit\EnviMockContainer');
        $EnviMockContainer->shouldReceive('unsetAttributeMethodAll')
        ->once()
        ->andNoBypass();
        $example->shouldReceive('doSomething');
        $trace = EnviMock::getMockTraceList();
        $this->assertEquals('unset'.'AttributeMethodAll', $trace[0]['method_name']);
        $this->assertEquals('example', $trace[0]['arguments'][0]);
        $this->assertEquals('doSomething', $trace[0]['arguments'][1]);
        return $example;
    }
    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     shouldReceiveTest
     * @cover       envitest\unit\EnviMockEditorRunkit::once
     * @cover       envitest\unit\EnviMockEditorRunkit::times
     * @cover       envitest\unit\EnviMockEditorRunkit::setContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     */
    public function onceTest($example)
    {
        $EnviMockContainer = EnviMock::mock('envitest\unit\EnviMockContainer');
        $EnviMockEditorRunkit = EnviMock::mock('envitest\unit\EnviMockEditorRunkit');

        $EnviMockEditorRunkit->shouldReceive('times')
            ->once()
            ->with(1)
            ->andNoBypass();

        $EnviMockContainer->shouldReceive('setAttribute')
            ->twice()
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times', 1)
            ->withByTimes(2, 'example', 'doSomething', 'min_limit_times', 1)
            ->andNoBypass();
        $res = $example->once();
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
        return array($example, $EnviMockContainer, $EnviMockEditorRunkit);
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     onceTest
     * @cover       envitest\unit\EnviMockEditorRunkit::twice
     * @cover       envitest\unit\EnviMockEditorRunkit::times
     * @cover       envitest\unit\EnviMockEditorRunkit::setContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     */
    public function twiceTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockEditorRunkit->recycle('times')
            ->with(2);
        $EnviMockContainer->recycle('setAttribute')
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times', 2)
            ->withByTimes(2, 'example', 'doSomething', 'min_limit_times', 2);
        $res = $example->twice();
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     onceTest
     * @cover       envitest\unit\EnviMockEditorRunkit::never
     * @cover       envitest\unit\EnviMockEditorRunkit::times
     * @cover       envitest\unit\EnviMockEditorRunkit::setContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     */
    public function neverTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockEditorRunkit->recycle('times')
            ->with(-1);
        $EnviMockContainer->recycle('setAttribute')
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times', -1)
            ->withByTimes(2, 'example', 'doSomething', 'min_limit_times', -1);
        $res = $example->never();
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
    }

    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     onceTest
     * @cover       envitest\unit\EnviMockEditorRunkit::between
     * @cover       envitest\unit\EnviMockEditorRunkit::setContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     */
    public function betweenTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockContainer->recycle('setAttribute')
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times', 10)
            ->withByTimes(2, 'example', 'doSomething', 'min_limit_times', 1);
        $res = $example->between(1, 10);
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
    }


    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     onceTest
     * @cover       envitest\unit\EnviMockEditorRunkit::atLeast
     * @cover       envitest\unit\EnviMockEditorRunkit::unsetContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     * @cover       envitest\unit\EnviMockContainer::unsetAttribute
     */
    public function atLeastTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockContainer->recycle('setAttribute')
            ->once()
            ->withByTimes(1, 'example', 'doSomething', 'min_limit_times', 1);

        $EnviMockContainer->shouldReceive('unsetAttribute')
            ->once()
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times')
            ->andNoBypass();

        $res = $example->atLeast(1);
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
        return $depends;
    }


    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     atLeastTest
     * @cover       envitest\unit\EnviMockEditorRunkit::atMost
     * @cover       envitest\unit\EnviMockEditorRunkit::unsetContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     * @cover       envitest\unit\EnviMockContainer::unsetAttribute
     */
    public function atMostTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockContainer->recycle('setAttribute')
            ->once()
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times', 10);

        $EnviMockContainer->recycle('unsetAttribute')
            ->once()
            ->withByTimes(1, 'example', 'doSomething', 'min_limit_times');

        $res = $example->atMost(10);
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
        return $depends;
    }


    /**
     * +--
     *
     * @access      public
     * @param       var_text $example
     * @return      void
     * @depends     atMostTest
     * @cover       envitest\unit\EnviMockEditorRunkit::zeroOrMoreTimes
     * @cover       envitest\unit\EnviMockEditorRunkit::unsetContainer
     * @cover       envitest\unit\EnviMockContainer::singleton
     * @cover       envitest\unit\EnviMockContainer::setAttribute
     * @cover       envitest\unit\EnviMockContainer::unsetAttribute
     */
    public function zeroOrMoreTimesTest($depends)
    {
        list($example, $EnviMockContainer, $EnviMockEditorRunkit) = $depends;
        $EnviMockContainer->recycle('unsetAttribute')
            ->twice()
            ->withByTimes(1, 'example', 'doSomething', 'max_limit_times')
            ->withByTimes(2, 'example', 'doSomething', 'min_limit_times');


        $res = $example->zeroOrMoreTimes();
        // $trace = EnviMock::getMockTraceList();
        $this->assertInstanceOf('envitest\unit\EnviMockEditor', $res);
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