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

umask(0);
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}
$project_name = $argv[2];

$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR;


foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}