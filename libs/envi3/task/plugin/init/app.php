<?php
/**
 * @package Envi3
 * @subpackage
 * @since 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 *  アプリキーの追加タスク
 *
 */

$ds = DIRECTORY_SEPARATOR;
umask(0);
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}
$project_name = $argv[2];

$arr[] = $base_dir."apps".$ds.$project_name.$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."modules".$ds;
$arr[] = $base_dir."apps".$ds.$project_name.$ds."libs".$ds;


foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}

$default_config_dir = dirname(__FILE__)."{$ds}..{$ds}..{$ds}..{$ds}default_config{$ds}";
copy($default_config_dir.'main.yml', $base_dir."config{$ds}".$project_name.'.yml');
copy($default_config_dir.'main_databases.yml', $base_dir."config{$ds}".$project_name.'_databases.yml');
copy($default_config_dir.'main_di_container.yml', $base_dir."config{$ds}".$project_name.'_di_container.yml');

