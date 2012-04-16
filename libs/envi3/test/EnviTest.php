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

/* ----------------------------------------- */

class EnviTestException extends exception
{

}



class extension
{
    private $configuration;
    private $extensions;
    private static $instance;

    /**
     * +-- コンストラクタ
     *
     * @access private
     * @params  $configuration
     * @return void
     */
    private function __construct()
    {
        $this->configuration = EnviTest::singleton()->system_conf['extension'];
        foreach ($this->configuration as $name => $v) {
            if (!$v['constant']) {
                continue;
            }
            include_once $v['class']['resource'];
            $class_name = $v['class']['class_name'];
            $this->extensions[$name] = new $class_name(EnviTest::singleton()->parseYml(basename($v['router']['resource']), dirname($v['router']['resource']).DIRECTORY_SEPARATOR));
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- エクステンションのオブジェクト取得(magicmethod)
     *
     * @access public
     * @params  $name
     * @params  $arguments
     * @return object
     */
    public function __call($name, $arguments)
    {
        if (!isset($this->configuration[$name])) {
            throw new EnviTestException($name.' extensionが見つかりませんでした');
        }
        $class_name = $this->configuration[$name]['class']['class_name'];

        if (!isset($this->configuration[$name]['class']['singleton']) || !$this->configuration[$name]['class']['singleton']) {
            if (!isset($this->extensions[$name])) {
                include_once $this->configuration[$name]['class']['resource'];
                $this->extensions[$name] = array();
            }
            $c = count($this->extensions[$name]);
            $this->extensions[$name][$c] = $class_name(EnviTest::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
            return $this->extensions[$name][$c];
        } elseif (!isset($this->extensions[$name])) {
            include_once $this->configuration[$name]['class']['resource'];
            $this->extensions[$name] = new $class_name(EnviTest::singleton()->parseYml(basename($this->configuration[$name]['router']['resource']), dirname($this->configuration[$name]['router']['resource']).DIRECTORY_SEPARATOR));
        }
        return $this->extensions[$name];
    }
    /* ----------------------------------------- */

    /**
     * +-- メインのAction実行が完了したタイミングで、暗黙的に実行されるMethodを実行
     *
     * @access public
     * @return void
     */
    public function executeLastShutdownMethod()
    {
        foreach ($this->extensions as $name => $val) {
            $shutdownMethod = false;
            if (isset($this->configuration[$name]['class']['lastShutdownMethod'])) {
                $shutdownMethod = $this->configuration[$name]['class']['lastShutdownMethod'];
            }
            if (!$shutdownMethod) {
                continue;
            }
            if (is_array($val)) {
                foreach ($val as $obj) {
                    $obj->$shutdownMethod();
                }
            } else {
                $val->$shutdownMethod();
            }
        }
    }
    /* ----------------------------------------- */

    public static function _singleton($configuration = NULL)
    {
        if (!isset(self::$instance)) {
            self::$instance = new extension($configuration);
        }
        return self::$instance;
    }

    public function free()
    {
        $this->extensions = array();
    }

}


function extension()
{
    return extension::_singleton();
}

class EnviTestAssert
{
    public function assertArrayHasKey($key, $search, $message = '')
    {
        if (!(is_array($search) && array_key_exists($key, $search) !== false)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertArray($a, $message = '')
    {
        if (!(is_array($a))) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
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
    public function assertCount($count, $array, $message = '')
    {
        if (!(count($array) === $count)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertEmpty($a, $message = '')
    {
        if (!empty($a)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertEqualXMLStructure()
    {

    }

    public function assertEquals($a, $b, $message = '')
    {
        if (!($a === $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertNotEquals($a, $b, $message = '')
    {
        if (!($a !== $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertFalse($a, $message = '')
    {
        if (!($a === false)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertFileEquals($a, $b, $message = '')
    {
        if (!(file_get_contents($a) === file_get_contents($b))) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertFileExists($a, $message = '')
    {
        if (!(file_exists($a))) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertGreaterThan($a, $b, $message = '')
    {
        if (!($a > $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertGreaterThanOrEqual($a, $b, $message = '')
    {
        if (!($a >= $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertInstanceOf($a, $b)
    {
        if (!($a instanceof $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertInternalType($a, $b)
    {

    }

    public function assertLessThan($a, $b, $message = '')
    {
        if (!($a < $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertLessThanOrEqual($a, $b, $message = '')
    {
        if (!($a <= $b)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function assertNull($a, $message = '')
    {
        if (!($a === NULL)) {
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
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
            throw new EnviTestException(__METHOD__.' '.join(' ',func_get_args()));
        }
        return true;
    }

    public function free()
    {
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
    public $get         = array();
    public $post        = array();
    public $headers     = array();
    public $cookie      = array();
    public $request_method = 'POST';
    private $request_url = '';

    public $system_conf;

    public function __construct()
    {
    }

    private function getContext($request_method, $post, $headers_arr, $cookie)
    {

        $headers_arr_sub = array();
        foreach ($headers_arr as $k => $value) {
            $headers_arr_sub[strtolower($k)] = trim($value);
        }
        $headers_arr = $headers_arr_sub;
        unset($headers_arr_sub);

        if (count($cookie)) {
            $headers_arr['cookie'] = "";
            foreach ($cookie as $k => $v) {
                $headers_arr['cookie'] = " $k=$v;";
            }
        }
        $headers = array();
        foreach ($headers_arr as $k => $value) {
            $headers[] = "{$k}: $value";
        }

        if ($request_method === 'GET') {
            $opts = array(
                'http' => array(
                    'method' => $request_method,
                    'header'=> join("\r\n", $headers)."\r\n"
                )
            );
        } else {
            $data_url       = http_build_query ($post);
            $data_length    = strlen ($data_url);
            $headers[] = 'Content-Length: '.$data_length;
            $opts = array(
                'http' => array(
                    'method' => $request_method,
                    'header'=> join("\r\n", $headers)."\r\n",
                    'content' => $data_url
                )
            );
        }
        return stream_context_create($opts);
    }


    abstract public function initialize();

    abstract public function shutdown();

    /**
     * +-- テストの実行
     *
     * @access private
     * @return string
     */
    final protected function emulateExecute($_request_method = false)
    {
        $get         = (array)$this->system_conf['parameter']['get'];
        $post        = (array)$this->system_conf['parameter']['post'];
        $headers     = (array)$this->system_conf['parameter']['headers'];
        $cookie      = (array)$this->system_conf['parameter']['cookie'];
        $request_method    = $this->system_conf['parameter']['request_method'];

        $get    = array_merge($get, $this->get);
        $post   = array_merge($post, $this->post);
        $headers = array_merge($headers, $this->headers);
        $cookie = array_merge($cookie, $this->cookie);
        $request_method    = $_request_method ? $_request_method : $request_method;
        $context = $this->getContext($request_method, $post, $headers, $cookie);
        $query_string = count($get) ? '?'.http_build_query($get) : '';
        // echo $this->request_url.$query_string."\n";
        // $aa = debug_backtrace();
        // var_dump($aa[0]['file'].$aa[0]['line']);
        $contents = file_get_contents($this->request_url.$query_string, false, $context);
        return array($http_response_header, $contents);
    }


    final public function setModuleAction($module, $action)
    {
        $this->request_url = $this->system_conf['app']['url']."/{$module}/{$action}";
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


