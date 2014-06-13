<?php
/**
 * CacheTestクラス
 *
 *
 * PHP versions 5
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
 * CacheTestクラス
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
class CacheTest extends testCaseBase
{
    public function initialize()
    {
        @unlink($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc');
    }

    /**
     * +-- 終了処理をする
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
        @unlink($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc');
    }
    /* ----------------------------------------- */

    /**
     * +-- cache有りCompileでcompile
     *
     * @access      public
     * @return      void
     */
    public function CachedCompileTest()
    {
        $symple_test_config = $this->parseYml('unit_tests_config.yml', 'cached_test');
        $EnviMarkdownExtension = new EnviMarkdownExtension($symple_test_config);
        $res = $EnviMarkdownExtension->compile(file_get_contents($this->test_data_dir.'simple_test.md'), 'test');
        $this->assertEquals(file_get_contents($this->test_data_dir.'simple_test.md.html'), $res, $res);
        $this->assertFileExists($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc');
        // 再コンパイルしてみる
        $res2 = $EnviMarkdownExtension->compile(file_get_contents($this->test_data_dir.'simple_test.md'), 'test');
        $this->assertEquals($res2, $res);

        // 再コンパイルしてみる
        file_put_contents($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc', '1234');
        $res3 = $EnviMarkdownExtension->compile(file_get_contents($this->test_data_dir.'simple_test.md'), 'test');
        $this->assertNotEquals($res3, $res);


    }
    /* ----------------------------------------- */

    /**
     * +-- cache有りCompileでcompileFile
     *
     * @access      public
     * @return      void
     */
    public function CachedCompileFileTest()
    {
        $symple_test_config = $this->parseYml('unit_tests_config.yml', 'cached_test');
        $EnviMarkdownExtension = new EnviMarkdownExtension($symple_test_config);
        $res = $EnviMarkdownExtension->compileFile($this->test_data_dir.'simple_test.md', 'test');
        $this->assertEquals(file_get_contents($this->test_data_dir.'simple_test.md.html'), $res);
        $this->assertFileExists($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc');

        // 再コンパイルしてみる
        $res2 = $EnviMarkdownExtension->compileFile($this->test_data_dir.'simple_test.md', 'test');
        $this->assertEquals($res2, $res);

        // 再コンパイルしてみる
        file_put_contents($this->test_data_dir.'mark_down_cache_test_1.0_unittest.html.envicc', '1234');
        $res3 = $EnviMarkdownExtension->compile(file_get_contents($this->test_data_dir.'simple_test.md'), 'test');
        $this->assertNotEquals($res3, $res);
    }
    /* ----------------------------------------- */
}
