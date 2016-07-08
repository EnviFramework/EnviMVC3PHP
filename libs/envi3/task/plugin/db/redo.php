<?php
/**
 * マイグレーション
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.4.0
 */
umask(0);


require_once ENVI_BASE_DIR.'util'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.'EnviMigrationBase.php';
require_once ENVI_BASE_DIR.'util'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.'drivers'.DIRECTORY_SEPARATOR.'EnviMigrationDriversBase.php';

require_once ENVI_BASE_DIR.'vendor'.DIRECTORY_SEPARATOR.'EnviDB.php';

// SpyCの読み込み
require_once ENVI_BASE_DIR.'spyc.php';

$step = 1;
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    eecho('envi db-redo {app key} {戻すステップ数} (env:{環境キー})');
    die;
} elseif (!isset($argv[3])) {
    $step = 1;
}
if (isset($argv[3]) && !ctype_digit($argv[3]) && strpos($arg, 'env:') !== false && (int)$argv[3] < 0) {
    eecho('戻すステップ数は数字で入力して下さい。');
    eecho('envi db-redo {app key} {戻すステップ数} (env:{環境キー})');
    die;
} elseif (isset($argv[3]) && ctype_digit($argv[3])) {
    $step = $argv[3];
}
require_once ENVI_BASE_DIR.'util'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.'EnviMigrationCmd.php';

$EnviMigrationCmd = new EnviMigrationCmd($current_work_dir);
$EnviMigrationCmd->executeRedo($step);
