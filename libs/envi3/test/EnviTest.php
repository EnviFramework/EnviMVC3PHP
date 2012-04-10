<?php
/**
 * @package Envi
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 * テスト実行用のEnvi設定
 *
 */

// コンフィグファイルのパス
if  (!defined('ENVI_MVC_APPKEY_PATH')) {
    define('ENVI_MVC_APPKEY_PATH',     realpath($scenario_dir.'/config/').DIRECTORY_SEPARATOR);
}

// キャッシュディレクトリのパス
if  (!defined('ENVI_MVC_CACHE_PATH')) {
    define('ENVI_MVC_CACHE_PATH',     realpath($scenario_dir.'/cache/').DIRECTORY_SEPARATOR);
}

// 環境ファイルのパス
if  (!defined('ENVI_SERVER_STATUS_CONF')) {
    define('ENVI_SERVER_STATUS_CONF', realpath($scenario_dir.'/env/ServerStatus.conf'));
}

// 実行時間計測用
if  (!defined('LW_START_MTIMESTAMP')) {
    define('LW_START_MTIMESTAMP', microtime(true));
}

// Envi3の読み込み
require(dirname(__FILE__).'/../Envi.php');

// 環境
define('ENVI_ENV', EnviServerStatus()->getServerStatus());

/* ----------------------------------------- */

class EnviTestException extends exception
{

}



class EnviTestAssert
{
    public function assertArrayHasKey($key, $search, $message = '')
    {
        if (!(array_key_exists($key, $search) !== false)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertClassHasAttribute()
    {

    }
    public function assertClassHasStaticAttribute()
    {

    }
    public function assertContains()
    {

    }
    public function assertContainsOnly()
    {

    }
    public function assertCount()
    {

    }

    public function assertEmpty($a, $message = '')
    {
        if (!empty($a)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertEqualXMLStructure()
    {

    }

    public function assertEquals($a, $b, $message = '')
    {
        if (!($a === $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertFalse($a, $message = '')
    {
        if (!($a === false)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertFileEquals($a, $b, $message = '')
    {
        if (!(file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertFileExists($a, $message = '')
    {
        if (!(file_exists($a))) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertGreaterThan($a, $b, $message = '')
    {
        if (!($a > $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertGreaterThanOrEqual($a, $b, $message = '')
    {
        if (!($a >= $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertInstanceOf($a, $b)
    {
        if (!($a instanceof $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertInternalType($a, $b)
    {

    }

    public function assertLessThan($a, $b, $message = '')
    {
        if (!($a < $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertLessThanOrEqual($a, $b, $message = '')
    {
        if (!($a <= $b)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }

    public function assertNull($a, $message = '')
    {
        if (!($a === NULL)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }
    public function assertObjectHasAttribute()
    {

    }
    public function assertRegExp()
    {

    }
    public function assertStringMatchesFormat()
    {

    }
    public function assertStringMatchesFormatFile()
    {

    }
    public function assertSame()
    {

    }
    public function assertSelectCount()
    {

    }
    public function assertSelectEquals()
    {

    }
    public function assertSelectRegExp()
    {

    }
    public function assertStringEndsWith()
    {

    }
    public function assertStringEqualsFile()
    {

    }
    public function assertStringStartsWith()
    {

    }
    public function assertTag()
    {

    }
    public function assertThat()
    {

    }
    public function assertTrue($a)
    {
        if (!($a === true)) {
            throw new EnviTestException(__METHOD__.' '.$message);
        }
        return true;
    }


}


/**
 * @package Envi
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
abstract class EnviTestCase extends EnviTestAssert
{
    public $_GET = array();
    public $_POST = array();
    public $_SERVER = array();
    public $_COOKIE = array();
    public $_ENV = array();

    public $system_conf;

    public function __construct()
    {
    }

    abstract public function initialize();

    abstract public function shutdown();

    /**
     * +-- テストの実行
     *
     * @access private
     * @return string
     */
    final protected function emulateExecute()
    {
        $_GET    = (array)$this->system_conf['parameter']['_GET'];
        $_POST   = (array)$this->system_conf['parameter']['_POST'];
        $_SERVER = (array)$this->system_conf['parameter']['_SERVER'];
        $_COOKIE = (array)$this->system_conf['parameter']['_COOKIE'];
        $_ENV    = (array)$this->system_conf['parameter']['_ENV'];

        $_GET    = array_merge($_GET, $this->_GET);
        $_POST   = array_merge($_POST, $this->_GET);
        $_SERVER = array_merge($_SERVER, $this->_SERVER);
        $_COOKIE = array_merge($_COOKIE, $this->_COOKIE);
        $_ENV    = array_merge($_COOKIE, $this->_ENV);

        $_SERVER['REQUEST_TIME'] = time();
        if (count($_POST)) {
            $_SERVER['REQUEST_METHOD'] = 'POST';
        }

        if (isset($_SERVER['PATH_INFO'])) {
            $_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'].$_SERVER['PATH_INFO'];
        }


        header_remove();
        ob_start();

        try {
            Envi::dispatch($this->system_conf['app']['app_key'], true);
        } catch (redirectException $e) {

        } catch (killException $e) {

        } catch (PDOException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        Envi::_free();
        $contents = ob_get_contents();
        ob_end_clean();
        return array(headers_list(), $contents);
    }


    final public function setModuleAction($module, $action)
    {
        $_SERVER['PATH_INFO'] = "/{$module}/{$action}";
    }



}

/**
 * @package Envi
 * @subpackage EnviTest
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */
class EnviTestScenario
{
    public $system_conf;



    public function execute()
    {
        return $this->getTestByDir(dirname($this->system_conf['scenario']['path']));
    }

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

}


