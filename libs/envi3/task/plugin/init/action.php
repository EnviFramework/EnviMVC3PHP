<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 *  Actionの追加タスク
 *
 */
umask(0);
if (!isset($argv[4])) {
    eecho('引数が足りません。');

}

$project_name = $argv[2];
$module_name = $argv[3];
$action_name = $argv[4];


$module_dir = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;

$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'Action.class.php');
$text = str_replace(array('%%module_name%%', '%%action_name%%'), array($module_name, $action_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.$action_name.'Action.class.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.$action_name.'Action.class.php', $text);
    touch($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$action_name.'.tpl');
}
