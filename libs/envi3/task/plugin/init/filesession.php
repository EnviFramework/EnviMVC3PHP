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


$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."1".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."2".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."3".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."4".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."5".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."6".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."7".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."8".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."9".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."0".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."a".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."b".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."c".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."d".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."e".DIRECTORY_SEPARATOR;
$arr[] = $base_dir."var/sessions".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."f".DIRECTORY_SEPARATOR;


foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}