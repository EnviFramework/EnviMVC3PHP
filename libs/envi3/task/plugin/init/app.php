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
 * @copyright  2011-2012 Artisan Project
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
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


$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."constant".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."tests".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."tests".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modulesTest".DIRECTORY_SEPARATOR;

$ds = DIRECTORY_SEPARATOR;

$default_config_dir = dirname(__FILE__)."{$ds}..{$ds}..{$ds}..{$ds}default_config{$ds}";

foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}

$text = copy($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'actionBase.class.php', $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR.'actionBase.class.php');
$text = copy($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'viewBase.class.php', $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR.'viewBase.class.php');
copy($default_config_dir.'main.yml', $base_dir."config{$ds}".$project_name.'.yml');
copy($default_config_dir.'main_databases.yml', $base_dir."config{$ds}".$project_name.'_databases.yml');
copy($default_config_dir.'main_di_container.yml', $base_dir."config{$ds}".$project_name.'_di_container.yml');
copy($default_config_dir.'main_web_type.yml', $base_dir."config{$ds}".$project_name.'_web_type.yml');
copy($default_config_dir.'main_schema.yml', $base_dir."config{$ds}".$project_name.'_schema.yml');

touch($base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR.'config.php');


$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'main.php');
$text = str_replace(array('%%app_name%%'), array($project_name), $text);
if (!is_file($base_dir.'web'.DIRECTORY_SEPARATOR.$project_name.'.php')) {
    file_put_contents($base_dir.'web'.DIRECTORY_SEPARATOR.$project_name.'.php', $text);
}
