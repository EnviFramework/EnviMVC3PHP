<?php
/**
 * EnviTestへのエイリアス
 *
 * ファイルのパスが移動になった為、移動先へエイリアス
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

require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'util'.DIRECTORY_SEPARATOR.'EnviUnitTest.php';


/**
 * コマンドラインで実行するためのクラス
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage EnviTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    Release: @package_version@
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      Class available since Release 1.0.0
 * @doc_ignore
 */
class EnviTest extends EnviUnitTest
{
    private static $envi_test_instance;
    private static $yml_path;

    protected function __construct()
    {
    }

    /**
     * +-- シングルトン
     *
     * @access public
     * @static
     * @param boolean $yml_path OPTIONAL:false
     * @return EnviTest
     */
    public static function adapter($yml_path = false)
    {
        if (!is_object(self::$envi_test_instance)) {
            self::$yml_path = $yml_path;
            $class_name = 'EnviTest';
            self::$envi_test_instance = new $class_name();
        }
        return self::$envi_test_instance;
    }
    /* ----------------------------------------- */

    public function execute()
    {
        $EnviTest = EnviUnitTest::singleton(self::$yml_path);
        // 設定ファイルから Envi自体の実行方法を選択する
        if (!isset($EnviTest->system_conf['parameter']['test_mode'], $EnviTest->system_conf['app']['key']) ||
        $EnviTest->system_conf['parameter']['test_mode'] === 'dummy') {
            include dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviDummy.php';
        } elseif ($EnviTest->system_conf['parameter']['test_mode'] === 'resist_only') {
            define('ENVI_SERVER_STATUS_CONF', dirname(__FILE__).DIRECTORY_SEPARATOR.'test.conf');
            if (isset($EnviTest->system_conf['app']['appkey_path']) && $EnviTest->system_conf['app']['appkey_path'] !== '') {
                define('ENVI_MVC_APPKEY_PATH', $EnviTest->system_conf['app']['appkey_path']);
            }
            if (isset($EnviTest->system_conf['app']['cache_path']) && $EnviTest->system_conf['app']['cache_path'] !== '') {
                define('ENVI_MVC_CACHE_PATH', $EnviTest->system_conf['app']['appkey_path']);
            }

            include(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'Envi.php');
            Envi::registerOnly($EnviTest->system_conf['app']['key'], true);
        }

        if (!defined('ENVI_BASE_DIR')) {
            define('ENVI_BASE_DIR', dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR);
        }

        return $EnviTest->execute();
    }

    public function help()
    {
        global $argv;
        // ヘルプ・マニュアル
        if ($this->hasOption('-h') || $this->hasOption('--help') || $this->hasOption('-?') || !isset($argv[1])) {
            // ヘルプ表示
            $this->cecho('Name:', 33);
            $this->cecho('    EnviTest.php <テスト用yamlファイルのパス> [--group <group_name> --no_color --code_coverage-off]');
            $this->cecho('    --help,-h,-?                         ', 32, '\n         このヘルプメッセージを表示します。');
            $this->cecho('    --debug                              ', 32, '\n         デバッグモードで実行します。');
            exit;
        }
    }
}

