<?php
/**
 * 自動テストフレームワーク
 *
 * EnviUnitTestは、PHPプログラマー向けのテストフレームワークです。
 * これは、単体テストフレームワークとして、必要な機能を網羅しています。
 *
 * EnviUnitTest は PHP 5.2 以降のバージョンで動作しますが、最新版の PHP を使うことを強く推奨します。
 *
 * EnviUnitTestはPHP標準で動作します。
 *
 * ただし、コードカバレッジをサポートするには Xdebug 2.1.3以降及び、
 * [tokenizer](http://www.php.net/manual/ja/tokenizer.installation.php)拡張モジュールが必要です。
 * モックテストをサポートするには、runkitが必要です。
 *
 * いずれも、最新版を使うことを推奨します。(tokenizerはデフォルトでのインストールで封入されます)
 *
 *
 * php 5.3以降に関しては、runkitを使用しない改善が検討されていますので、将来のバージョンでは、必要が無くなる可能性があります。
 *
 *
 * 詳細は、[自動テスト](http://www.enviphp.net/c/man/v3/core/unittest)を参照して下さい。
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
 * @subpackage_main
 */

require_once dirname(__FILE__).'/EnviUnitTest/EnviUnitTestBase.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviMock.php';

/**
 * 自動テストフレームワーク
 *
 * 設定ファイルと、テストシナリオに応じて、自動テストを行います。
 *
 * 現在のバージョンではコマンドラインのみのテストが実装されています。
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
class EnviUnitTest
{
    public $system_conf;
    private static $instance;

    protected $parser;

    /**
     * +-- コンストラクタ
     *
     * @access public
     * @param  $file
     * @return void
     */
    public function __construct($file)
    {
        $this->system_conf = $this->parseYml(basename($file), dirname($file).DIRECTORY_SEPARATOR);
    }
    /* ----------------------------------------- */

    public function execute()
    {
        global $start_time;
        if (!$start_time) {
            $start_time = microtime(true);
        }
        include_once $this->system_conf['scenario']['path'];
        $scenario              = new $this->system_conf['scenario']['class_name'];
        $scenario->system_conf = $this->system_conf;


        $arr = $scenario->execute();
        $is_ng = false;
        $assertion_count = 0;

        // カバレッジ
        $code_coverage = false;
        if (isset($this->system_conf['code_coverage']) && $this->system_conf['code_coverage']['use']) {
            if (!class_exists('EnviCodeCoverage', false)) {
                include_once dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviCodeCoverage.php';
            }
            $code_coverage = EnviCodeCoverage::factory();
            if (isset($this->system_conf['code_coverage']['black_list']) &&
                is_array($this->system_conf['code_coverage']['black_list'])) {
                foreach ($this->system_conf['code_coverage']['black_list'] as $black_list) {
                    if (is_file($black_list)) {
                        $code_coverage->filter()->addBlackList($black_list);
                    } elseif (is_dir($black_list)) {
                        $code_coverage->filter()->addBlackListByDirectory($black_list);
                    }
                }
            }
            if (isset($this->system_conf['code_coverage']['white_list']) &&
                is_array($this->system_conf['code_coverage']['white_list'])) {
                foreach ($this->system_conf['code_coverage']['white_list'] as $black_list) {
                    if (is_file($black_list)) {
                        $code_coverage->filter()->addWhiteList($black_list);
                    } elseif (is_dir($black_list)) {
                        $code_coverage->filter()->addWhiteListByDirectory($black_list);
                    }
                }
            }
            $code_coverage->start();
        }
        foreach ($arr as $test_val) {
            if (is_object($code_coverage)) {
                $code_coverage->filter()->addBlackList($test_val['class_path']);
            }


            $docs_methods = $this->getMethodAnnotation($test_val['class_path']);
            $before = array();
            $after = array();
            $beforeClass = array();
            $afterClass = array();
            $default_time_out = 1;
            $default_group = 'small';
            $group = array();

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



            $docs_classes = $this->getClassAnnotation($test_val['class_path']);
            $class_docs = $docs_classes[$test_val['class_name']];

            include_once $test_val['class_path'];
            foreach ($beforeClass as $method) {
                $test_val['class_name']::$method();
            }
            $test_obj = new $test_val['class_name'];
            if (is_object($code_coverage)) {
                $test_obj->code_coverage = $code_coverage;
            }
            $test_obj->system_conf = $this->system_conf;
            $methods = array();
            if (isset($test_val['methods']) && count($test_val['methods'])) {
                $methods = array_fill($test_val['methods']);
            }

            $class_group = array();
            if (isset($class_docs['group'][0][0])) {
                foreach ($class_docs['group'] as $g) {
                    if (isset($g[0])) {
                        $class_group[$g[0]] = $g[0];
                    }
                }
            }

            $results = array();
            $class_backupGlobals = true;

            if (isset($class_docs['backupGlobals'][0][0])  && $class_docs['backupGlobals'][0][0] === 'disabled') {
                $class_backupGlobals = false;
            }
            $backupGlobals = $class_backupGlobals;
            $execute_group = $this->getOption('--group', $this->getOption('--exclude-group'));
            $testing_execution_time_all = 0;
            foreach (get_class_methods($test_val['class_name']) as $method) {
                if (!isset($methods[$method]) && !mb_ereg('Test$', $method)) {
                    continue;
                }

                // 必ずデフォルトグループには入れる
                if (!isset($group[$method]) && count($class_docs) === 0) {
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

                // タイムアウト時間確認
                $time_out = $default_time_out;
                if (isset($this->system_conf['time_out'][$execute_group])) {
                    $time_out = $this->system_conf['time_out'][$execute_group];
                } else {
                    foreach ($group[$method] as $self_group) {
                        if (isset($this->system_conf['time_out'][$self_group])) {
                            $time_out = max($this->system_conf['time_out'][$self_group], $time_out);
                        }
                    }
                }

                // グローバルデータバックアップ
                $backupGlobals = $class_backupGlobals;
                $backup_global_data = array();
                if (isset($docs_methods[$method]['backupGlobals'][0][0])) {
                    $backupGlobals = $docs_methods[$method]['backupGlobals'][0][0] !== 'disabled';
                }
                if ($backupGlobals) {
                    $backup_global_data = $GLOBALS;
                }

                // テスト開始
                try{
                    // セットアップ処理
                    $test_obj->initialize();
                    foreach ($before as $method) {
                        $test_obj->$method();
                    }
                    $provider = array();
                    $cover = array();
                    if (isset($docs_methods[$method]['dataProvider'])) {
                        $provider_method = $docs_methods[$method]['dataProvider'][0][0];
                        $provider = array_values($test_obj->$provider_method());
                    }
                    if (isset($docs_methods[$method]['depends'])) {
                        foreach ($docs_methods[$method]['depends'] as $val) {
                            if (!isset($results[$val[0]])) {
                                throw new EnviTestDependsException;
                            }
                            $provider[] = $results[$val[0]];
                        }
                    }
                    if (isset($docs_methods[$method]['cover'])) {
                        foreach ($docs_methods[$method]['cover'] as $val) {
                            $cover[] = $val[0];
                        }
                        if ($code_coverage !== false) {
                            $code_coverage->setCover($cover);
                        }
                    }
                    if (isset($docs_methods[$method]['coversNothing']) || isset($class_docs['coversNothing'])) {
                        $code_coverage->startNothing();
                    }
                    $method_start_time = microtime(true);
                    $results[$method] = call_user_func_array(array($test_obj, $method), $provider);

                    // 最大実行時間
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    if ($execute_time > $time_out) {
                        throw new EnviTestTimeOutException('max execution time :'.$execute_time.'sec more than '.$time_out.' sec');
                    }
                    $this->sendOKMessage($test_val['class_name'].'::'.$method);
                    if ($code_coverage !== false) {
                        $code_coverage->finish();
                        $code_coverage->unSetCover();
                        $code_coverage->start();
                    }
                    if (isset($docs_methods[$method]['coversNothing']) || isset($class_docs['coversNothing'])) {
                        $code_coverage->endNothing();
                    }

                    // シャットダウン処理
                    $test_obj->shutdown();
                    foreach ($after as $method) {
                        $test_obj->$method();
                    }


                } catch (EnviTestDependsException $e) {
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                } catch (EnviTestTimeOutException $e) {
                    $this->sendNGMessage($test_val['class_name'].'::'.$method.'  '.$e->getMessage());
                } catch (EnviTestException $e) {
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $this->sendNGMessage($test_val['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e->getMessage());
                } catch (EnviMockException $e) {
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $test_trace_before = array();
                    foreach ($trace as $test_trace) {
                        if (isset($test_trace['class'], $test_trace['function'])){
                            if (strtolower($test_trace['class']) === strtolower($test_val['class_name']) && strtolower($test_trace['function']) === strtolower($method)) {
                                break;
                            }
                        }
                        $test_trace_before = $test_trace;
                    }
                    $this->sendErrorMessage($test_val['class_name'].'::'.$method." line on {$test_trace_before['line']}".'  '.$e->getMessage());


                } catch (exception $e) {
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $this->sendErrorMessage($test_val['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e);
                }
                // テスト終了
                $test_obj->free();

                // グローバルデータバックアップを戻す
                if ($backupGlobals) {
                    $GLOBALS = $backup_global_data;
                }
            }
            $assertion_count += $test_obj->getAssertionCount();
            unset($test_obj);
            foreach ($afterClass as $method) {
                $test_val['class_name']::$method();
            }
        }
        echo round(microtime(true) - $start_time, 5),"sec \r\n(testing only : ",
            round($testing_execution_time_all, 5),"sec) \r\n{$assertion_count} assertions test end \r\n",
            number_format(memory_get_peak_usage(true))," memory usage\r\n";
        if ($code_coverage !== false && !$is_ng) {
            $code_coverage_data = $code_coverage->getCodeCoverage();
            echo 'total : '.$code_coverage_data['cover_rate']."% : test coverage \r\n";
            foreach ($code_coverage_data['class_coverage_data'] as $class_name => $class_item) {
                $file_contents_arr = NULL;
                echo $class_name." total: ".$class_item['class']['cover_rate']."% covered. \r\n";
                foreach ($class_item['methods'] as $method_name => $method_item) {
                    if (isset($this->system_conf['code_coverage']['use_all_covered_filter']) && $this->system_conf['code_coverage']['use_all_covered_filter']) {
                        if ($method_item['cover_rate'] == 100) {
                            continue;
                        }
                    }
                    echo $class_name.'::'.$method_name." ".$method_item['cover_rate']."% covered. \r\n";
                    if ($method_item['cover_count'][EnviCodeCoverage::COVERD] === $method_item['cover_count'][EnviCodeCoverage::TOTAL_COVER] ||
                        $method_item['cover_count'][EnviCodeCoverage::COVERD] === 0) {
                        continue;
                    }
                    if ($file_contents_arr === NULL) {
                        $file_contents_arr = file($class_item['file_name']);
                    }
                    if (isset($this->system_conf['code_coverage']['use_coverage_detail']) && $this->system_conf['code_coverage']['use_coverage_detail']) {
                        $this->showCoverError($method_item['detail'], $file_contents_arr);
                    }
                }
            }

            if ($this->system_conf['code_coverage']['save_path']) {
                file_put_contents($this->system_conf['code_coverage']['save_path'], json_encode($code_coverage_data, true));
            }
        }
    }

    /**
     * +-- Coverageのエラー出力を出すかどうか
     *
     * @access      private
     * @param       & $detail
     * @param       & $file_contents_arr
     * @return      void
     */
    private function showCoverError(&$detail, &$file_contents_arr)
    {
        $start_line = false;
        $end_line   = false;
        foreach ($detail as $line => $coverage_data) {
            if ($coverage_data[2] === false && $start_line === false) {
                $start_line = $line;
                $end_line = $line;
            } elseif ($coverage_data[2] === false && $start_line !== false) {
                $end_line = $line;

            } elseif ($coverage_data[2] === true && $start_line !== false) {
                $this->showSauce($detail, $file_contents_arr, $start_line-2, $end_line+2);
                $start_line = false;
                $end_line   = false;
            }
        }
        if ($start_line !== false) {
            $this->showSauce($detail, $file_contents_arr, $start_line-2, $line+2);
        }
    }
    /* ----------------------------------------- */

    private function showSauce(&$detail, &$file_contents_arr, $start_line, $end_line)
    {
        $start_line = max(0, $start_line-1);
        $end_line = min(count($file_contents_arr), $end_line-1);
        while ($start_line <= $end_line) {
            $start_line++;
            $line_text = str_pad($start_line, 5, ' ', STR_PAD_LEFT);
            $code_coverage = '';
            if (isset($detail[$start_line])) {
                $code_coverage = min($detail[$start_line][EnviCodeCoverage::COVERD], $detail[$start_line][EnviCodeCoverage::TOTAL_COVER])
                    .'/'.$detail[$start_line][EnviCodeCoverage::TOTAL_COVER];
            }
            $code_coverage = str_pad($code_coverage, 10, ' ', STR_PAD_LEFT);
            if (!isset($detail[$start_line])) {
                $this->skipLine($line_text, $code_coverage.' : '.$file_contents_arr[$start_line-1]);
            } elseif ($detail[$start_line][EnviCodeCoverage::COVERD] >= $detail[$start_line][EnviCodeCoverage::TOTAL_COVER]) {
                $this->successLine($line_text, $code_coverage.' : '.$file_contents_arr[$start_line-1]);
            } else {
                $this->errorLine($line_text, $code_coverage.' : '.$file_contents_arr[$start_line-1]);
            }

        }
    }

    private function errorLine($line, $line_string)
    {
        $line_string = rtrim($line_string);
        $line .= '  ';
        $cmd = 'echo -e "\033[7;33m'.$line.'\033[0;39m\033[1;41m'.$this->escapeShell($line_string).'\033[0;39m"';
        system($cmd);

    }

    private function successLine($line, $line_string)
    {
        $line_string = rtrim($line_string);
        $line .= '  ';
        $cmd = 'echo -e "\033[7;33m'.$line.'\033[0;39m\033[1;42m'.$this->escapeShell($line_string).'\033[0;39m"';
        system($cmd);
    }

    private function skipLine($line, $line_string)
    {
        $line_string = rtrim($line_string);
        $line .= '  ';
        $cmd = 'echo -e "\033[7;33m'.$line.'\033[0;39m\033[1;39m'.$this->escapeShell($line_string).'\033[0;39m"';
        system($cmd);
    }

    public function parseYml($file, $dir = ENVI_MVC_APPKEY_PATH)
    {
        if (!is_file($dir.$file)) {
            throw new exception('not such file '.$dir.$file);
        }
        include_once dirname(__FILE__).'/../spyc.php';
        ob_start();
        include $dir.$file;
        $buff      = ob_get_contents();
        ob_end_clean();

        $buff = spyc_load($buff);
        $res = isset($buff['test']) ? array_merge($buff['all'], $buff['test']) : $buff['all'];
        return $res;
    }

    private function  escapeShell($str)
    {
        return str_replace(array("\\", '$', '"'), array("\\\\", '\$', '\"'), $str);
    }


    /**
     * +-- コードパーサを返す
     *
     * @access      public
     * @return      void
     */
    public function parser()
    {
        if (!$this->parser) {
            if (!class_exists('EnviCodeParser', false)) {
                include dirname(dirname(__FILE__)).'/util/EnviCodeParser.php';
            }
            $this->parser = new EnviCodeParser;
        }
       return $this->parser;
    }
    /* ----------------------------------------- */

    protected function getMethodAnnotation($file_name)
    {
        $res = $this->getAnnotation($file_name);
        return $res['FUNCTION'];
    }

    protected function getClassAnnotation($file_name)
    {
        $res = $this->getAnnotation($file_name);
        return $res['CLASS'];
    }

    /**
     * +-- 指定したファイルのAnnotationを取得する
     *
     * @access      protected
     * @param       any $file_name
     * @return      array
     */
    protected function getAnnotation($file_name)
    {
        static $doc_tags;
        if (isset($doc_tags[$file_name])) {
            return $doc_tags[$file_name];
        }
        $doc_tag = '';
        $is_function = false;
        $is_class = false;
        foreach (token_get_all(file_get_contents($file_name)) as $token) {
            if (is_array($token)) {
                $name = substr(token_name($token[0]), 2);
                if ($name === 'DOC_COMMENT') {
                    $doc_tag = $token[1];
                }
                if ($name === 'FUNCTION') {
                    $is_function = true;
                }
                if ($name === 'CLASS') {
                    $is_class = true;
                }
                if ($name === 'STRING' && $is_class) {
                    $doc_tags[$file_name]['CLASS'][$token[1]] = $this->parseAnnotation($doc_tag);
                }
                if ($name === 'STRING' && $is_function) {
                    $doc_tags[$file_name]['FUNCTION'][$token[1]] = $this->parseAnnotation($doc_tag);
                }
            }
            if ($token === '{') {
                $doc_tag = '';
                $is_function = false;
                $is_class = false;
            }
        }
        return $doc_tags[$file_name];
    }
    /* ----------------------------------------- */

    /**
     * +-- アノテーションのパース
     *
     * @access      private
     * @param       any $doc_tag
     * @return      void
     */
    private function parseAnnotation($doc_tag)
    {
        preg_match_all('/@(.*)\n/' ,$doc_tag, $match);
        $docs = array();
        foreach ($match[1] as $doc) {
            $doc = mb_ereg_replace(' +', ' ', $doc);
            $doc = explode(' ', $doc);
            $tag = trim(array_shift($doc));
            $docs[$tag][] = $doc;
        }
        return $docs;
    }
    /* ----------------------------------------- */


    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @param boolean $app OPTIONAL:false
     * @return Envi
     */
    public static function singleton($app = false)
    {
        if (!isset(self::$instance)) {
            $className = __CLASS__;
            self::$instance = new $className($app);
        }
        return self::$instance;
    }
    /* ----------------------------------------- */
    private function getOption($name, $default_param = false) {
        GLOBAL $argv,$fargv;
        if(isset($fargv[$name])){
            $x = $fargv[$name]+1;
            return isset($argv[$x]) ? $argv[$x] : false;
        } else {
            return $default_param;
        }
    }

    private function sendOKMessage($msg)
    {
        $this->cecho("[OK]", "36", $msg);
    }


    private function sendNGMessage($msg)
    {
        $this->cecho("[NG]", "31", $msg);
    }

    private function sendErrorMessage($msg)
    {
        $this->cecho("[ERROR]", "31", $msg);
    }

    private function cecho($m, $c = 30, $oth = '') {
         system("echo -e '\e[{$c}m {$m} \e[m{$oth}'");
    }


}

class EnviTestDependsException extends Exception
{

}

class EnviTestTimeOutException extends Exception
{

}
