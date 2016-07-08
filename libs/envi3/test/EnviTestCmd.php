<?php
/**
 * コマンドラインで自動テストを実行するためのファイル
 *
 * PHP versions 5
 *
 *
 * @category   自動テスト
 * @package    UnitTest
 * @subpackage EnviTest
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 * @doc_ignore
 */
if (!isset($envi_cmd)) {
    /**
     * バッチ用の設定
     */
    set_time_limit(0);
    ini_set('memory_limit', -1);
    umask();

    /* ----------------------------------------- */
    $test_key = $argv[1];
} else {
    $test_key = $argv[2];
}



require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'spyc.php';
require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'EnviTest.php';


$EnviTest = EnviTest::adapter($test_key);

$EnviTest->help();
$EnviTest->execute();
