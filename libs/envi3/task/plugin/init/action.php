<?php
/**
 *  Actionの追加タスク
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
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */
umask(0);
if (!isset($argv[4])) {
    eecho('引数が足りません。');

}

$project_name = $argv[2];
$module_name = $argv[3];
$action_name = $argv[4];
if (!mb_ereg('^[a-zA-Z0-9.\-_]+$', $project_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}
if (!mb_ereg('^[a-zA-Z0-9.\-_]+$', $module_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}
if (!mb_ereg('^[a-zA-Z0-9.\-_]+$', $action_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}



$module_dir = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$module_test_dir = $base_dir."tests".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modulesTest".DIRECTORY_SEPARATOR;


$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'Action.class.php');
$text = str_replace(array('%%module_name%%', '%%action_name%%'), array($module_name, $action_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.$action_name.'Action.class.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.$action_name.'Action.class.php', $text);
    touch($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$action_name.'.tpl');
}


$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'test.class.php');
$text = str_replace(array('%%module_name%%', '%%action_name%%'), array($module_name, $action_name), $text);
if (!is_file($module_test_dir.DIRECTORY_SEPARATOR.$module_name."Test".DIRECTORY_SEPARATOR.$action_name.'Test.class.php')) {
    file_put_contents($module_test_dir.DIRECTORY_SEPARATOR.$module_name."Test".DIRECTORY_SEPARATOR.$action_name.'Test.class.php', $text);
}
