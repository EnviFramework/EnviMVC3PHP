<?php
/**
 * @package Envi3
 * @subpackage
 * @since 0.1
 * @author     Akito <akito-artisan@five-foxes.com>
 */

/**
 *  アプリキーの追加タスク
 *
 */

umask(0);
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}
$project_name = $argv[2];

$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."controller".DIRECTORY_SEPARATOR;

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
