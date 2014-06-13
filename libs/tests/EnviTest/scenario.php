<?php
/**
 * テストのScenarioクラス
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

require_once ENVI_BASE_DIR.'/test/EnviTest.php';
require_once dirname(__FILE__).'/testCaseBase.php';

$scenario_dir = dirname(__FILE__).DIRECTORY_SEPARATOR;
define('ENVI_TEST_YML', basename(dirname(__FILE__)).'.yml');
$cmd = 'cp -rf '.ENVI_BASE_DIR.'/test/* '.dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/test/';
`$cmd`;
$cmd = 'cp -rf '.ENVI_BASE_DIR.'/util/* '.dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/util/';
`$cmd`;

$test = array(dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/test/EnviTest.php', dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/test/EnviDummy.php');

$test = array_merge($test, glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/util/EnviCode*.php'));
$test = array_merge($test, glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/util/CodeCoverage/*.php'));
$test = array_merge($test, glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'copy/util/CodeParser/*.php'));
foreach ($test as $k => $file_path) {
    $file = file($file_path);
    $rep_file = array();
    $name_space = 'namespace envitest\unit;'."\n";
    if ($k === 0) {
        $name_space .= 'class exception extends \exception{}'."\n";
        $name_space .= 'interface ArrayAccess{}'."\n";
        $name_space .= 'interface Countable{}'."\n";
        $name_space .= 'interface SeekableIterator{}'."\n";
    }
    foreach ($file as $line) {
        $rep_file[] = $line;
        if ($name_space) {
            $rep_file[] = $name_space;
            $name_space = '';
        }
    }
    file_put_contents($file_path, join('', $rep_file));

}
foreach ($test as $k => $file_path) {
    require_once $file_path;
}

/**
 * テストのScenarioクラス
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
class Scenario extends EnviTestScenario
{
    public static $stack_data;

    /**
     * +-- データスタック用
     *
     * @access public
     * @static
     * @param  $k
     * @param  $v
     * @return void
     */
    public static function setAttribute($k, $v)
    {
        self::$stack_data[$k] = $v;
    }
    /* ----------------------------------------- */

    /**
     * +-- スタックしたデータを取得する用
     *
     * @access public
     * @static
     * @param  $k
     * @return void
     */
    public static function getAttribute($k)
    {
        return isset(self::$stack_data[$k]) ? self::$stack_data[$k] : NULL;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行するテストの配列をYamlから返す
     *
     * @access public
     * @return array
     */
    public function execute()
    {
        if (isOption('--auto')) {
            return parent::execute();
        }
        $arr = array();
        if (!isOption('-s')) {
            foreach ($this->system_conf['scenario']['dirs'] as $dir_name) {
                $arr = $this->getTestByDir($dir_name, 1, $arr);
            }
        } else {
            foreach (explode(',', getOption('-s')) as $dir_name) {
                $arr = $this->getTestByDir($this->system_conf['scenario']['dirs'][$dir_name], 1, $arr);
            }
        }
        if (isOption('-t')) {
            $sub_arr = array();
            foreach ($arr as $val) {
                foreach (explode(',', getOption('-t')) as $class_name) {
                    if ($val['class_name'] === $class_name) {
                        $sub_arr[] = $val;
                    }
                }
            }
            return $sub_arr;
        }
        return $arr;
    }
    /* ----------------------------------------- */

}
