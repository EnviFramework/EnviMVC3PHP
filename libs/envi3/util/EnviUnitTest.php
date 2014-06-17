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
    private $no_color;

    /**
     * +-- コンストラクタ
     *
     * @access protected
     * @param  $file
     * @return void
     */
    protected function __construct($file)
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

        // テストシナリオオブジェクトの作成
        include_once $this->system_conf['scenario']['path'];
        $scenario              = new $this->system_conf['scenario']['class_name'];
        $scenario->system_conf = $this->system_conf;
        $scenario->unit_test   = $this;
        $test_sweet_list = $scenario->execute();

        // 変数初期化
        $is_ng = false;
        $assertion_count = 0;
        // 時間記録の初期化
        $testing_execution_time_all = 0;
        $testing_time_all           = 0;

        // 実行グループの指定
        $execute_group = $this->getOption('--group', $this->getOption('--exclude-group'));

        // 色無し
        if (isset($this->system_conf['no_color'])) {
            $this->no_color = $this->system_conf['no_color'];
        }
        if ($this->hasOption('--no_color')) {
            $this->no_color = true;
        }

        // カバレッジ
        $code_coverage = false;
        if (isset($this->system_conf['code_coverage']) &&
            $this->system_conf['code_coverage']['use'] &&
            !$this->hasOption('--code_coverage-off')
            ) {
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
        foreach ($test_sweet_list as $sweet) {
            if (is_object($code_coverage)) {
                $code_coverage->filter()->addBlackList($sweet['class_path']);
            }

            // テストプラン作成
            $test_plan = $scenario->sweetToPlan($sweet, $execute_group);
            // 実行プランが0の場合は終了する
            if (count($test_plan['test_method_list']) === 0) {
                continue;
            }
            $afterClass  = $test_plan['afterClass'];
            $after       = $test_plan['after'];
            $beforeClass = $test_plan['beforeClass'];
            $before      = $test_plan['before'];


            // オブジェクト生成処理
            include_once $sweet['class_path'];
            foreach ($beforeClass as $method) {
                $sweet['class_name']::$method();
            }
            $test_obj = new $sweet['class_name'];
            if (is_object($code_coverage)) {
                $test_obj->code_coverage = $code_coverage;
            }
            $test_obj->system_conf = $this->system_conf;
            // オブジェクト生成処理ここまで

            // データプロバイダ&依存データの初期化
            $results = array();
            foreach ($test_plan['test_method_list'] as $method => $plan) {
                $time_out       = $plan['time_out'];
                $backup_globals = $plan['backup_globals'];
                $group          = $plan['group'];
                $docs_method    = $plan['docs_method'];
                $covers_nothing = $plan['covers_nothing'];

                // グローバルデータバックアップの設定と初期化
                $backup_global_data = array();
                if ($backup_globals) {
                    $backup_global_data['GLOBALS']  = $GLOBALS;
                    $backup_global_data['_POST']    = $_POST;
                    $backup_global_data['_GET']     = $_GET;
                    $backup_global_data['_SERVER']  = $_SERVER;
                    $backup_global_data['_ENV']     = $_ENV;
                    $backup_global_data['_COOKIE']  = $_COOKIE;
                    if (isset($_SESSION)) {
                        $backup_global_data['_SESSION'] = $_SESSION;
                    }
                    $backup_global_data['_REQUEST'] = $_REQUEST;
                    $backup_global_data['_FILES']   = $_FILES;
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
                    // データプロバイダー
                    if (isset($docs_method['dataProvider'])) {
                        $provider_method = $docs_method['dataProvider'][0][0];
                        $provider = array_values($test_obj->$provider_method());
                    }
                    // 依存
                    if (isset($docs_method['depends'])) {
                        foreach ($docs_method['depends'] as $val) {
                            if (!isset($results[$val[0]])) {
                                throw new EnviTestDependsException;
                            }
                            $provider[] = $results[$val[0]];
                        }
                    }
                    if (isset($docs_method['cover'])) {
                        foreach ($docs_method['cover'] as $val) {
                            $cover[] = $val[0];
                        }
                        if ($code_coverage !== false) {
                            $code_coverage->setCover($cover);
                        }
                    }
                    if ($covers_nothing) {
                        $code_coverage->startNothing();
                    }
                    $method_start_time = microtime(true);
                    $results[$method] = call_user_func_array(array($test_obj, $method), $provider);
                    $execute_time = (microtime(true) - $method_start_time);

                    // トータル実行時間の制御
                    $testing_execution_time_all += $execute_time;
                    $testing_time = $execute_time - $test_obj->getTestFlameWorkExecutionTime();
                    $testing_time_all += $testing_time;
                    $test_obj->resetTestFlameWorkExecutionTime();
                    // 最大実行時間制限
                    if ($testing_time > $time_out) {
                        throw new EnviTestTimeOutException('max execution time :'.$execute_time.'sec more than '.$time_out.' sec');
                    }

                    // OKメッセージ
                    $this->sendOKMessage($sweet['class_name'].'::'.$method.' : testing_time :'.($testing_time*1000).'ms');

                    // コードカバレッジ計測
                    if ($code_coverage !== false) {
                        $code_coverage->finish();
                        $code_coverage->unSetCover();
                        $code_coverage->start();
                    }
                    if ($covers_nothing) {
                        $code_coverage->endNothing();
                    }

                    // シャットダウン処理
                    $test_obj->shutdown();
                    foreach ($after as $method) {
                        $test_obj->$method();
                    }

                    // グローバルデータバックアップを戻す
                    if ($backup_globals) {
                        $this->replaceGlobals($backup_global_data);
                    }
                } catch (EnviTestDependsException $e) {
                    // 依存元がエラーの場合はテスト自体を省略する
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                } catch (EnviTestTimeOutException $e) {
                    // タイムアウト
                    $this->sendNGMessage($sweet['class_name'].'::'.$method.'  '.$e->getMessage());
                } catch (EnviTestAssertionFailException $e) {
                    // アサーションフェイル
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $this->sendNGMessage($sweet['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e->getMessage());
                } catch (EnviTestException $e) {
                    // その他ユニットテストのエラー
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $this->sendNGMessage($sweet['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e->getMessage());
                } catch (EnviMockException $e) {
                    // モックのエラー
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $test_trace_before = array();
                    foreach ($trace as $test_trace) {
                        if (isset($test_trace['class'], $test_trace['function'])){
                            if (strtolower($test_trace['class']) === strtolower($sweet['class_name']) && strtolower($test_trace['function']) === strtolower($method)) {
                                break;
                            }
                        }
                        $test_trace_before = $test_trace;
                    }
                    $this->sendErrorMessage($sweet['class_name'].'::'.$method." line on {$test_trace_before['line']}".'  '.$e->getMessage());
                    EnviMock::free();
                } catch (exception $e) {
                    $execute_time = (microtime(true) - $method_start_time);
                    $testing_execution_time_all += $execute_time;
                    $is_ng = true;
                    $trace = $e->getTrace();
                    $this->sendErrorMessage($sweet['class_name'].'::'.$method." line on {$trace[0]['line']}".'  '.$e);
                }
                // テスト終了
                $test_obj->free();

                // グローバルデータバックアップを戻す
                if ($backup_globals) {
                    $this->replaceGlobals($backup_global_data);
                }
            }
            $assertion_count += $test_obj->getAssertionCount();
            unset($test_obj);
            foreach ($afterClass as $method) {
                $sweet['class_name']::$method();
            }
        }
        echo 'TotalExecutionTime:'.round(microtime(true) - $start_time, 5),"sec \r\n(testing only : ",
            round($testing_time_all, 5),"sec) \r\n{$assertion_count} assertions test end \r\n",
            number_format(memory_get_peak_usage(true))," memory usage\r\n";
        if ($code_coverage !== false && !$is_ng) {
            $this->showCodeCoverage($code_coverage);
        }
    }

    /**
     * +-- コードCoverage情報を出力する
     *
     * @access      private
     * @param       var_text $code_coverage
     * @return      void
     */
    private function showCodeCoverage($code_coverage)
    {
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
    /* ----------------------------------------- */

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

    /**
     * +-- Coverageデータを元にソースコードを描画する
     *
     * @access      private
     * @param       & $detail
     * @param       & $file_contents_arr
     * @param       var_text $start_line
     * @param       var_text $end_line
     * @return      void
     */
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
    /* ----------------------------------------- */

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

    public function parseYml($file, $dir)
    {
        if (!is_file($dir.$file)) {
            throw new exception('not such file '.$dir.$file);
        }
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

    /**
     * +-- メソッドのアノテーション配列を取得する
     *
     * @access      public
     * @param       string $file_name ファイルパス
     * @return      array
     */
    public function getMethodAnnotation($file_name)
    {
        $res = $this->getAnnotation($file_name);
        return $res['FUNCTION'];
    }
    /* ----------------------------------------- */

    /**
     * +-- クラスのアノテーション配列を取得する
     *
     * @access      public
     * @param       string $file_name ファイルパス
     * @return      array
     */
    public function getClassAnnotation($file_name)
    {
        $res = $this->getAnnotation($file_name);
        return $res['CLASS'];
    }
    /* ----------------------------------------- */

    /**
     * +-- 指定したファイルのAnnotationを取得する
     *
     * @access      protected
     * @param       string $file_name ファイルパス
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
     * @param boolean $yml_path OPTIONAL:false
     * @return EnviUnitTest
     */
    public static function singleton($yml_path = false, $spyc_path = NULL)
    {
        if (!is_object(self::$instance)) {
            if ($spyc_path) {
                include_once $spyc_path;
            }
            $class_name = 'EnviUnitTest';
            if ($yml_path === false || !is_file($yml_path)) {
                throw EnviTestException('YML file can not be found.');
            }
            self::$instance = new $class_name($yml_path);
        }
        return self::$instance;
    }
    /* ----------------------------------------- */
    /**
     * +-- 実行オプションの取得
     *
     * @access      public
     * @param       string $name 取得するオプション
     * @param       mixed $default_param  オプションのデフォルト OPTIONAL:false
     * @return      mixed
     */
    public function getOption($name, $default_param = false) {
        GLOBAL $argv;
        $fargv = array_flip($argv);
        if(isset($fargv[$name])){
            $x = $fargv[$name]+1;
            return isset($argv[$x]) ? $argv[$x] : false;
        }
        return $default_param;
    }
    /* ----------------------------------------- */

    /**
     * +-- 実行オプションの有無の確認
     *
     * @access      public
     * @param       string $name 確認するオプション
     * @return      boolean
     */
    public function hasOption($name) {
        GLOBAL $argv;
        $fargv = array_flip($argv);
        return isset($fargv[$name]);
    }
    /* ----------------------------------------- */

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

        if ($this->no_color) {
            echo $m,$oth;
            return;
        }
        $oth = strtr($oth, array("'" => '', "\\" => ''));
        system("echo -e '\e[{$c}m {$m} \e[m{$oth}'");
    }

    private function replaceGlobals($backup_global_data)
    {
        $GLOBALS    = $backup_global_data['GLOBALS'];
        $_POST      = $backup_global_data['_POST'];
        $_GET       = $backup_global_data['_GET'];
        $_SERVER    = $backup_global_data['_SERVER'];
        $_ENV       = $backup_global_data['_ENV'];
        $_COOKIE    = $backup_global_data['_COOKIE'];
        if (isset($_SESSION)) {
            $_SESSION   = $backup_global_data['_SESSION'];
        }
        $_REQUEST   = $backup_global_data['_REQUEST'];
        $_FILES     = $backup_global_data['_FILES'];
    }
}
