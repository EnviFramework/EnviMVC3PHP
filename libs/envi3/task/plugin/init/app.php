<?php
/**
 *  アプリキーの追加タスク
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2013 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

umask(0);
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}
$project_name = $argv[2];
if (!mb_ereg('^[a-zA-Z0-9.\-_]+$', $project_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}

$ds = DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".$ds.$project_name.$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."modules".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds."controller".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds."common".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds."constant".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds."models".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds."models".$ds."om";

// テスト用
$arr[] = $base_dir."tests".$ds.$project_name.$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."modulesTest".$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."libsTest".$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."libsTest".$ds."controllerTest".$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."libsTest".$ds."commonTest".$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."libsTest".$ds."constantTest".$ds;
$arr[] = $base_dir."tests".$ds.$project_name.$ds."libsTest".$ds."modelsTest".$ds;



$default_config_dir = dirname(__FILE__)."{$ds}..{$ds}..{$ds}..{$ds}default_config{$ds}";

foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}


copy($task_plugin_dir.$module.$ds.'data'.$ds.'scenario.php', $base_dir."tests".$ds.$project_name.$ds.'scenario.php');
copy($task_plugin_dir.$module.$ds.'data'.$ds.'testCaseBase.php', $base_dir."tests".$ds.$project_name.$ds.'testCaseBase.php');

copy($task_plugin_dir.$module.$ds.'data'.$ds.'actionBase.class.php', $base_dir."apps".$ds.$project_name.$ds."libs".$ds."controller".$ds.'actionBase.class.php');
copy($task_plugin_dir.$module.$ds.'data'.$ds.'viewBase.class.php', $base_dir."apps".$ds.$project_name.$ds."libs".$ds."controller".$ds.'viewBase.class.php');
copy($default_config_dir.'main.yml', $base_dir."config{$ds}".$project_name.'.yml');
copy($default_config_dir.'main_databases.yml', $base_dir."config{$ds}".$project_name.'_databases.yml');
copy($default_config_dir.'main_di_container.yml', $base_dir."config{$ds}".$project_name.'_di_container.yml');
copy($default_config_dir.'main_web_type.yml', $base_dir."config{$ds}".$project_name.'_web_type.yml');
copy($default_config_dir.'main_send_mail.yml', $base_dir."config{$ds}".$project_name.'_send_mail.yml');
copy($default_config_dir.'main_schema.yml', $base_dir."config{$ds}".$project_name.'_schema.yml');

copy($default_config_dir.'main_test.yml', $base_dir."tests".$ds.$project_name.'_test.yml');


touch($base_dir."apps".$ds.$project_name.$ds."modules".$ds.'config.php');


$text = file_get_contents($task_plugin_dir.$module.$ds.'data'.$ds.'main.php');
$text = str_replace(array('%%app_name%%'), array($project_name), $text);
if (!is_file($base_dir.'web'.$ds.$project_name.'.php')) {
    file_put_contents($base_dir.'web'.$ds.$project_name.'.php', $text);
}
