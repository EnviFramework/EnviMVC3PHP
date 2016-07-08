<?php
/**
 * エクステンションの追加タスク
 *
 *
 * PHP versions 5
 *
 *
 * @category   MVC
 * @package    Envi3
 * @subpackage EnviMVCCore
 * @author     Akito <akito-artisan@five-foxes.com>
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release v3.4.0.0
 */
umask(0);
if (!isset($argv[4])) {
    eecho('引数が足りません。');
    eecho('envi install-extension {app_key} {di_yaml_path} {extension_name}');
    die;
}
$project_dir = $current_work_dir;
while (!is_file($project_dir.'envi.prj') && strlen($project_dir) > 2) {
    $project_dir = dirname($project_dir).DIRECTORY_SEPARATOR;
}

if (!is_file($project_dir.'envi.prj')) {
    echo 'please change directory. envi project directory';
    die;
}

$project_name   = $argv[2];
$di_yaml_path   = $argv[3];
$extension_name = $argv[4];

if (!is_dir($project_dir.'apps'.DIRECTORY_SEPARATOR.$project_name)) {
    eecho('project'.$project_name.'が存在しません。');
    eecho('envi install-extension {app_key} {di_yaml_path} {extension_name}');
    die;
}

if (!is_file($di_yaml_path)) {
    eecho('DI設定ファイル'.$di_yaml_path.'が存在しません。');
    eecho('envi install-extension {app_key} {di_yaml_path} {extension_name}');
    die;
}

$extension_dir = realpath(ENVI_BASE_DIR.'..'.DIRECTORY_SEPARATOR.'extensions').DIRECTORY_SEPARATOR.$extension_name.DIRECTORY_SEPARATOR;
if (!is_dir($extension_dir)) {
    eecho('エクステンション '.$extension_name.'が存在しません。');
    var_dump(ENVI_BASE_DIR);
    eecho('envi install-extension {app_key} {di_yaml_path} {extension_name}');
    die;
}
$work_dir = $project_dir.'works'.DIRECTORY_SEPARATOR.'install'.DIRECTORY_SEPARATOR;
if (!is_dir($work_dir)) {
    mkdir($work_dir, 0777, true);
}

// SpyCの読み込み
include_once ENVI_BASE_DIR.'spyc.php';




// +-- DI設定
// main yaml
$buff      = file_get_contents($di_yaml_path);

$di_yaml = spyc_load($buff);
// extention yaml
$buff        = file_get_contents($extension_dir.'config'.DIRECTORY_SEPARATOR.'main_di_container.yml');
$add_di_yaml = spyc_load($buff);

// 設定の追加
$keys                     = array_keys($add_di_yaml);
$values                   = array_values($add_di_yaml);
$di_yaml['all'][$keys[0]] = $values[0];

// ファイルバックアップ
$bk_file = $work_dir.basename($di_yaml_path).'.'.time().'.bk';
rename($di_yaml_path, $bk_file);
echo $bk_file."\n";

// 設定上書き
$file_name = $di_yaml_path;
$yaml      = Spyc::YAMLDump($di_yaml, 2, 60);
file_put_contents($file_name, file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'yaml_header.yml').$yaml);
echo $file_name."\n";

// ----------------

// +-- DI本体設定

// ファイルバックアップ
$di_contents_yaml_path = dirname($di_yaml_path).DIRECTORY_SEPARATOR.$project_name.'_'.$extension_name.'.yml';
if (is_file($di_contents_yaml_path)) {
    $bk_file = $work_dir.basename($di_contents_yaml_path).'.'.time().'.bk';
    rename($di_contents_yaml_path, $bk_file);
    echo $bk_file."\n";
}
// 設定コピー
copy($extension_dir.'config'.DIRECTORY_SEPARATOR.'main_'.$extension_name.'.yml', $di_contents_yaml_path);
echo $di_contents_yaml_path."\n";


// ----------------
