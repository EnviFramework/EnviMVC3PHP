<?php
/**
 *  モジュールの追加タスク
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    GIT: $Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
umask(0);
if (!isset($argv[3])) {
    eecho('引数が足りません。');
    die;
}

$project_name = $argv[2];
$module_name = $argv[3];


$module_dir = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR;

foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}

$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'actions.class.php');
$text = str_replace(array('%%module_name%%'), array($module_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.'actions.class.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.'actions.class.php', $text);
}
