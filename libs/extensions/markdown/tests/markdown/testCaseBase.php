<?php
/**
 * テストのベースクラス
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

require dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'EnviMarkdownExtension.php';

/**
 * テストのベースクラス
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
 */
class testCaseBase extends EnviTestCase
{

    protected $test_data_dir;
    /**
     * +-- コンストラクタ
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->test_data_dir = dirname(__FILE__).'/../datas/';
        parent::__construct();

    }
    /* ----------------------------------------- */

    /**
     * +-- 初期化
     *
     * @access public
     * @return void
     */
    public function initialize()
    {
    }
    /* ----------------------------------------- */


    /**
     * +-- 終了処理をする
     *
     * @access public
     * @return void
     */
    public function shutdown()
    {
    }
    /* ----------------------------------------- */

    public function parseYml($file, $env, $dir = NULL)
    {
        static $ymldatas;

        $dir = ($dir === NULL ? dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'config' : $dir).DIRECTORY_SEPARATOR;
        $file_path = realpath($dir.$file);
        if (!isset($ymldatas[$file_path])) {
            ob_start();
            include $dir.$file;
            $buff      = ob_get_contents();
            ob_end_clean();
            $buff = spyc_load($buff);
            $ymldatas[$file_path] = $buff;
        } else {
            $buff = $ymldatas[$file_path];
        }
        $res = isset($buff[$env]) ? array_merge($buff['all'], $buff[$env]) : $buff['all'];
        $res = isset($buff[$env]) ? $this->mergeConfiguration($buff['all'], $buff[$env]) : $buff['all'];
        return $res;
    }
    /* ----------------------------------------- */

    private function mergeConfiguration($all_conf, $env_conf)
    {
        foreach ($all_conf as $key => $values) {
            if (!isset($env_conf[$key])) {
                continue;
            }
            if (is_array($env_conf[$key]) && !isset($env_conf[$key][0])) {
                $all_conf[$key] = $this->mergeConfiguration($values, $env_conf[$key]);
                continue;
            }
            return array_merge($all_conf, $env_conf);
        }
        return $all_conf;
    }
}

