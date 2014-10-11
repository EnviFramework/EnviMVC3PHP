<?php
/**
 * SimpleTestクラス
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
 * SimpleTestクラス
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
class SimpleTest extends testCaseBase
{
    /**
     * +-- ForceCompileでcompile
     *
     * @access      public
     * @return      void
     */
    public function SimpleCompileTest()
    {
        $symple_test_config = $this->parseYml('unit_tests_config.yml', 'simple_test');
        $EnviScssphpExtension = new EnviScssphpExtension($symple_test_config);
        $res = $EnviScssphpExtension->compile(file_get_contents($this->test_data_dir.'simple_test.scss'), 'test');
        $this->assertEquals(file_get_contents($this->test_data_dir.'simple_test.scss.css'), $res, $res);
    }
    /* ----------------------------------------- */

    /**
     * +-- ForceCompileでcompileFile
     *
     * @access      public
     * @return      void
     */
    public function SimpleCompileFileTest()
    {
        $symple_test_config = $this->parseYml('unit_tests_config.yml', 'simple_test');
        $EnviScssphpExtension = new EnviScssphpExtension($symple_test_config);
        $res = $EnviScssphpExtension->compileFile($this->test_data_dir.'simple_test.scss', 'test');
        $this->assertEquals(file_get_contents($this->test_data_dir.'simple_test.scss.css'), $res);
    }
    /* ----------------------------------------- */
}
