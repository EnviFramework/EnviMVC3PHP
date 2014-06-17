<?php
/**
 * 自動テスト
 *
 *
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 */
require_once dirname(__FILE__).'/EnviUnitTestExceptions.php';
require_once dirname(__FILE__).'/EnviTestAssert.php';

/**
 * +-- テストの共通基底クラス
 *
 * EnviTestAssertで継承されているため、自動生成される、EnviTestCaseでも自動的に継承されます。
 *
 * 現在は、テストフレームワークが持つ機能を除き、callメソッドのみを提供します。
 *

 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @abstract
 * @since      File available since Release 1.0.0
 * @author     akito<akito-artisan@five-foxes.com>
 */
abstract class EnviTestBase
{
    public $code_coverage = false;
    protected $assertion_count = 0;
    protected $stop_watch = array(0, 0);
    const START_TIME = 0;
    const DIFF_TIME  = 1;

    public function free()
    {
        $this->codeCoverageRestart();
    }

    /**
     * +-- 配列を文字列にする
     *
     * @access public
     * @param array $arr
     * @return string
     */
    public function toString($arr){
        $str = '';
        foreach ($arr as $val) {
            if (is_array($val)) {
                $str .= "{".$this->toString($val).'}';
                continue;
            } elseif (is_object($val)) {
                $str .= "{".get_class($val)."}";
                continue;
            }

            $val = (string)$val;
            $str .= ",{$val}";
        }
        return $str;
    }
    /* ----------------------------------------- */

    protected function codeCoverageRestart()
    {
        if ($this->code_coverage === false) {
            return;
        }
        $this->code_coverage->finish();
        $this->code_coverage->start();
    }

    protected function assertionExecuteBefore()
    {
        $this->stop_watch[self::START_TIME] = microtime(true);
        $this->codeCoverageRestart();
        ++$this->assertion_count;
    }

    protected function assertionExecuteAfter()
    {
        EnviMock::assertionExecuteAfter();
        $this->stop_watch[self::DIFF_TIME] += microtime(true) - $this->stop_watch[self::START_TIME];
    }

    public function getTestFlameWorkExecutionTime()
    {
        return $this->stop_watch[self::DIFF_TIME];
    }

    public function resetTestFlameWorkExecutionTime()
    {
        $this->stop_watch = array(0, 0);
    }

    public function getAssertionCount()
    {
        return $this->assertion_count;
    }

    /**
     * +-- $objの$methodを、アクセス権に関係なく実行する
     *
     * $objの$methodを、アクセス権に関係なく実行します。
     *
     *
     * @access      public
     * @param       objedt $obj 実行するオブジェクト
     * @param       string $method 実行するメソッド
     * @param       array $args 引数の配列 OPTIONAL:array
     * @return      mixed
     */
    public function call($obj, $method, array $args = array())
    {
        $reflection = false;
        if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
            $reflection = new ReflectionMethod(get_class($obj), $method);
            $default_accessible = $reflection->isPublic();
        } else {
            return $this->callByRunkit($obj, $method, $args);
        }
        try{
            $reflection->setAccessible(true);
            $res = $reflection->invokeArgs($obj, $args);
        } catch (ReflectionException $e) {
            $reflection->setAccessible($default_accessible);
            return $this->callByRunkit($obj, $method, $args);
        } catch (exception $e) {
            $reflection->setAccessible($default_accessible);
            throw $e;
        }
        $reflection->setAccessible($default_accessible);
        return $res;
    }
    /* ----------------------------------------- */

    private function callByRunkit($obj, $method, array $args = array())
    {
         if (!extension_loaded('runkit')) {
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                $res = dl('runkit.dll');
            } else {
                $res = dl('runkit.so');
            }
            if ($res) {
                throw new Exception('please install runkit.http://pecl.php.net/package-changelog.php?package=runkit');
            }
        }
        $class_name = get_class($obj);
        $executer_method = $method.time().sha1(microtime());
        $code = 'return call_user_func_array(array($this, "'.$method.'"), func_get_args());';
        runkit_method_add($class_name, $executer_method, '', $code, RUNKIT_ACC_PUBLIC);
        $res = call_user_func_array(array($obj, $executer_method), $args);
        runkit_method_remove($class_name, $executer_method);
        return $res;
    }


    /**
     * +-- emulateExecuteで発行するGETパラメータを追加します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @param       string $value  パラメータの値
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function setGetParameter($key, $value)
    {
        $this->get[$key] = $value;
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するPOSTパラメータを追加します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @param       string $value  パラメータの値
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function setPostParameter($key, $value)
    {
        $this->post[$key] = $value;
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するクッキーパラメータを追加します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @param       string $value  パラメータの値
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function setCookieParameter($key, $value)
    {
        $this->cookie[$key] = $value;
    }
    /* ----------------------------------------- */


    /**
     * +-- emulateExecuteで発行するヘッダを追加します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @param       string $value  パラメータの値
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function setHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }
    /* ----------------------------------------- */



    /**
     * +-- emulateExecuteで発行するGETパラメータを削除します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function removeGetParameter($key)
    {
        if (isset($this->get[$key])) {
            unset($this->get[$key]);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するPOSTパラメータを削除します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function removePostParameter($key)
    {
        if (isset($this->post[$key])) {
            unset($this->post[$key]);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するクッキーパラメータを削除します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function removeCookieParameter($key)
    {
        if (isset($this->cookie[$key])) {
            unset($this->cookie[$key]);
        }
    }
    /* ----------------------------------------- */


    /**
     * +-- emulateExecuteで発行するヘッダを削除します
     *
     * @access      public
     * @param       string $key    パラメータのキー
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function removeHeader($key)
    {
        if (isset($this->headers[$key])) {
            unset($this->headers[$key]);
        }
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するGETパラメータをすべて削除します
     *
     * @access      public
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function resetGetParameter()
    {
        $this->get = array();
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するPOSTパラメータをすべて削除します
     *
     * @access      public
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function resetPostParameter()
    {
        $this->post = array();
    }
    /* ----------------------------------------- */

    /**
     * +-- emulateExecuteで発行するクッキーパラメータをすべて削除します
     *
     * @access      public
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function resetCookieParameter()
    {
        $this->cookie = array();
    }
    /* ----------------------------------------- */


    /**
     * +-- emulateExecuteで発行するヘッダをすべて削除します
     *
     * @access      public
     * @return      void
     * @see EnviTestCase::emulateExecute()
     * @since       3.3.3.5
     */
    public function resetHeader()
    {
        $this->headers = array();
    }
    /* ----------------------------------------- */

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

    /**
     * +-- テストリクエストを発行して、結果を受け取る
     *
     * 特定のアクションに対してアクセスするテストリクエストを発行し、その結果を返します。
     * 結果は、配列で返され、0番目がサーバーから返されたhttpヘッダ、1番目が、実際の出力となります。
     *
     * @param       string $_request_method リクエストメソッド。省略した場合は自動で選択。 OPTIONAL:NULL
     * @access public
     * @return array
     */
    final public function emulateExecute($_request_method = NULL)
    {
        $get         = is_array($this->system_conf['parameter']['get']) ? $this->system_conf['parameter']['get'] : array();
        $post        = is_array($this->system_conf['parameter']['post']) ? $this->system_conf['parameter']['post'] : array();
        $headers     = is_array($this->system_conf['parameter']['headers']) ? $this->system_conf['parameter']['headers'] : array();
        $cookie      = is_array($this->system_conf['parameter']['cookie']) ? $this->system_conf['parameter']['cookie'] : array();

        $request_method    = $this->system_conf['parameter']['request_method'];

        $get    = array_merge($get, $this->get);
        $post   = array_merge($post, $this->post);
        $headers = array_merge($headers, $this->headers);
        $cookie = array_merge($cookie, $this->cookie);
        $request_method    = is_string($_request_method) ? $_request_method : $request_method;
        $context = $this->getContext($request_method, $post, $headers, $cookie);
        $query_string = count($get) ? '?'.http_build_query($get) : '';
        $contents = file_get_contents($this->request_url.$query_string, false, $context);
        return array($http_response_header, $contents);
    }
    /* ----------------------------------------- */


    final public function setModuleAction($module, $action)
    {
        $this->request_url = $this->system_conf['app']['url']."/{$module}/{$action}";
    }

}
/* ----------------------------------------- */

/**
 * テストクラスで継承されるクラス
 *
 * EnviTestCaseはすべてのテストクラスで継承されるクラスです。
 * envi コマンドで生成されるテスト以外に手動でテストクラスを作成する場合も、必ずこのクラスを継承して下さい。
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @since 0.1
 * @author     Akito <akito-artisan@five-foxes.com>
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


    abstract public function initialize();

    abstract public function shutdown();

}


/**
 * シナリオクラスで継承されるクラス
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage UnitTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 */
abstract class EnviTestScenario
{
    public $system_conf;
    public $unit_test;


    /**
     * +-- 実行するスイートのリストを返す
     *
     * @access public
     * @return array
     */
    public function execute()
    {
        return $this->getTestByDir(dirname($this->system_conf['scenario']['path']));
    }
    /* ----------------------------------------- */

    /**
     * +-- DIRECTORYの再帰検索
     *
     * @access public
     * @param mixed $dir_name
     * @param mixed $node OPTIONAL:0
     * @param mixed $arr OPTIONAL:array
     * @return array
     */
    public function getTestByDir($dir_name, $node = 0, $arr = array())
    {
        if (is_dir($dir_name)) {
            if ($dh = opendir($dir_name)) {
                while (($file = readdir($dh)) !== false) {
                    if (strpos($file, '.') === 0) {
                        continue;
                    }
                    if (is_dir($dir_name.DIRECTORY_SEPARATOR.$file)) {
                        if (mb_ereg('Test$', $file)) {
                            $arr = $this->getTestByDir($dir_name.DIRECTORY_SEPARATOR.$file, $node +1, $arr);
                        }
                        continue;
                    }
                    if (!mb_ereg('Test(\.class)?\.php$', $file)) {
                        continue;
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
    /* ----------------------------------------- */

    /**
     * +-- テストスイートからテストプランを作成する
     *
     * @access      public
     * @param       array $sweet   テストスイート
     * @param       string|boolean $execute_group
     * @return      array
     */
    public function sweetToPlan($sweet, $execute_group)
    {
        // 変数初期化
        $docs_methods  = $this->unit_test->getMethodAnnotation($sweet['class_path']);
        $before        = array();
        $after         = array();
        $beforeClass   = array();
        $afterClass    = array();
        $default_group = 'small';
        $group         = array();
        $class_backup_globals = true;
        $backup_globals = true;
        $test_method_list = array();

        $default_time_out = isset($this->system_conf['default_time_out']) ? (int)$this->system_conf['default_time_out'] : 1;

        // routingの反映
        $methods = array();
        if (isset($sweet['methods']) && count($sweet['methods'])) {
            $methods = array_fill($sweet['methods']);
        }
        foreach ($docs_methods as $method => $docs) {
            // @testアノテーションの処理
            if (isset($docs['test'])) {
                $methods[$method] = true;
            }
            // @beforeアノテーションの処理
            if (isset($docs['after'])) {
                $before[$method] = $method;
            }
            // @afterアノテーションの処理
            if (isset($docs['after'])) {
                $after[$method] = $method;
            }
            // @beforeClassアノテーションの処理
            if (isset($docs['beforeClass'])) {
                $beforeClass[$method] = $method;
            }
            // @afterClassアノテーションの処理
            if (isset($docs['afterClass'])) {
                $afterClass[$method] = $method;
            }

            // グループ
            if (isset($docs['group'][0])) {
                foreach ($docs['group'] as $g) {
                    if (isset($g[0])) {
                        $group[$method][$g[0]] = $g[0];
                    }
                }
            }
        }

        $docs_classes = $this->unit_test->getClassAnnotation($sweet['class_path']);
        $class_docs   = $docs_classes[$sweet['class_name']];

        $class_group = array();
        if (isset($class_docs['group'][0][0])) {
            foreach ($class_docs['group'] as $g) {
                if (isset($g[0])) {
                    $class_group[$g[0]] = $g[0];
                }
            }
        }

        // グローバル変数バックアップ
        if ((isset($class_docs['backup_globals'][0][0])  && $class_docs['backup_globals'][0][0] === 'disabled') ||
            (isset($class_docs['backupGlobals'][0][0])  && $class_docs['backupGlobals'][0][0] === 'disabled')
        ) {
            $class_backup_globals = false;
        }
        $backup_globals = $class_backup_globals;
        $single_mode = $this->unit_test->getOption('--single_mode');
        foreach (array_keys($docs_methods) as $method) {
            if (!isset($methods[$method]) && !mb_ereg('Test$', $method)) {
                continue;
            }
            if ($single_mode) {
                if ($single_mode !== $method) {
                    continue;
                }
            }
            // 必ずデフォルトグループには入れる
            if (!isset($group[$method]) && count($class_group) === 0) {
                $group[$method][$default_group] = $default_group;
            } elseif (count($class_group) > 0) {
                foreach ($class_group as $val) {
                    $group[$method][$val] = $val;
                }
            }
            // グループ指定実行の場合の処理
            if ($execute_group && !isset($group[$method][$execute_group])) {
                continue;
            }
            $backup_globals = $class_backup_globals;
            if (isset($docs_methods[$method]['backup_globals'][0][0])) {
                $backup_globals = $docs_methods[$method]['backup_globals'][0][0] !== 'disabled';
            } elseif (isset($docs_methods[$method]['backupGlobals'][0][0])) {
                $backup_globals = $docs_methods[$method]['backupGlobals'][0][0] !== 'disabled';
            }

            // タイムアウト時間確認
            $time_out = $default_time_out;
            if (isset($this->system_conf['time_out'][$execute_group])) {
                $time_out = $this->system_conf['time_out'][$execute_group];
            } elseif (isset($group[$method])) {
                foreach ($group[$method] as $self_group) {
                    if (isset($this->system_conf['time_out'][$self_group])) {
                        $time_out = max($this->system_conf['time_out'][$self_group], $time_out);
                    }
                }
            }
            $test_method_list[$method] = array(
                'group'          => $group[$method],
                'backup_globals' => $backup_globals,
                'docs_method'    => isset($docs_methods[$method]) ? $docs_methods[$method] : $docs_methods[$method],
                'covers_nothing' => isset($docs_methods[$method]['coversNothing']) || isset($class_docs['coversNothing']),
                'time_out'       => $time_out,
            );
        }
        return array(
            'test_method_list' => $test_method_list,
            'before'      => $before,
            'after'       => $after,
            'beforeClass' => $beforeClass,
            'afterClass'  => $afterClass,
        );
    }
    /* ----------------------------------------- */
}
