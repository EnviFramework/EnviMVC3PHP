<?php
/**
 *  キャッシュのクリアタスク
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

include_once ENVI_BASE_DIR.'spyc.php';
ob_start();
include $argv[2];
$buff      = ob_get_contents();
ob_end_clean();

$config = spyc_load($buff);
if (!is_dir($config['DIRECTORY']['model_dir'])) {
    mkdir($config['DIRECTORY']['model_dir']);
    echo $config['DIRECTORY']['model_dir']."\n";
}
$model_dir = $config['DIRECTORY']['model_dir'].DIRECTORY_SEPARATOR;
$om_dir    = $model_dir.'om'.DIRECTORY_SEPARATOR;
if (!is_dir($om_dir)) {
    mkdir($om_dir);
    echo $om_dir."\n";
}

function pascalize($string)
{
    $string = strtolower($string);
    $string = str_replace('_', ' ', $string);
    $string = ucwords($string);
    $string = str_replace(' ', '', $string);
    return $string;
}


foreach ($config['SCHEMA'] as $table_name => $schema) {
    // var_dump($schema);
    $class_name = isset($schema['class_name']) ? $schema['class_name'] : pascalize($table_name);
    $sql = "SELECT * FROM {$table_name} ";
    $func_args = array();
    $pkeys = array();
    $comma = '';
    $and = 'WHERE ';
    foreach ($schema['schema'] as $column => $status) {
        if (isset($status['index']) && $status['index'] == 'primary') {
            $sql .= $and.$column.' = ? ';
            $and = 'AND ';
            $func_args[] = '$pkey'.count($func_args);
            $pkeys[] = "'{$column}'";
        }
    }

    $instance_name = isset($schema['instance_name']) ? $schema['instance_name'] : $config['SETTING']['default_instance_name'];


    $text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'BasePeer.class.php');
    $text = str_replace(
        array('%%class_name%%', '%%instance_name%%', '%%sql%%', '%%args%%', '%%pkeys%%', '%%table_name%%'),
        array($class_name, $instance_name, $sql, join(',', $func_args), join(',', $pkeys), $table_name),
        $text
    );
    echo $om_dir.'Base'.$class_name.'Peer.class.php'."\n";
    file_put_contents($om_dir.'Base'.$class_name.'Peer.class.php', $text);


    $text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'Base.class.php');
    $text = str_replace(
        array('%%class_name%%', '%%instance_name%%', '%%sql%%', '%%args%%', '%%pkeys%%', '%%table_name%%'),
        array($class_name, $instance_name, $sql, join(',', $func_args), join(',', $pkeys), $table_name),
        $text
    );

    echo $om_dir.'Base'.$class_name.'.class.php'."\n";
    file_put_contents($om_dir.'Base'.$class_name.'.class.php', $text);

    $text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'OrmapPeer.class.php');
    $text = str_replace(
        array('%%class_name%%', '%%instance_name%%', '%%sql%%', '%%args%%', '%%pkeys%%', '%%table_name%%'),
        array($class_name, $instance_name, $sql, join(',', $func_args), join(',', $pkeys), $table_name),
        $text
    );
    if (!is_file($model_dir.$class_name.'Peer.class.php')) {
        echo $model_dir.$class_name.'.class.php'."\n";
        file_put_contents($model_dir.$class_name.'Peer.class.php', $text);
    }


    $text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'Ormap.class.php');
    $text = str_replace(
        array('%%class_name%%', '%%instance_name%%', '%%sql%%', '%%args%%', '%%pkeys%%', '%%table_name%%'),
        array($class_name, $instance_name, $sql, join(',', $func_args), join(',', $pkeys), $table_name),
        $text
    );
    if (!is_file($model_dir.$class_name.'.class.php')) {
        echo $model_dir.$class_name.'.class.php'."\n";
        file_put_contents($model_dir.$class_name.'.class.php', $text);
    }
}