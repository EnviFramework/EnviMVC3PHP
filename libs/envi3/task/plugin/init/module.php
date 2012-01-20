<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 *  モジュールの追加タスク
 *
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
