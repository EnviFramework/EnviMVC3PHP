<?php
/**
 * マイグレーション
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
 * @see        http://www.enviphp.net/
 * @since      File available since Release 1.0.0
 */



umask(0);


require ENVI_BASE_DIR.'util'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.'EnviMigrationBase.php';
require ENVI_BASE_DIR.'util'.DIRECTORY_SEPARATOR.'Migration'.DIRECTORY_SEPARATOR.'drivers'.DIRECTORY_SEPARATOR.'EnviMigrationDriversBase.php';



if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}
$project_dir = $current_work_dir;
while (!is_file($project_dir.'envi.prj') && strlen($project_dir) > 2) {
    $project_dir = dirname($project_dir).DIRECTORY_SEPARATOR;
}

$db_dir = $project_dir.'db'.DIRECTORY_SEPARATOR;
$migration_dir = $project_dir.'db'.DIRECTORY_SEPARATOR.'migrate'.DIRECTORY_SEPARATOR;

$migration_class_files = glob($migration_dir.$argv[2].'_*.php');


$env = trim(file_get_contents($db_dir.'env'));
if (isset($argv[3])) {
    $env = $argv[3];
}

$migration_file = $db_dir.'envi_migration_'.$argv[2].'_'.$env.'.php';
$migration = array('last_version' => '0', 'executed' => array());
if (is_file($migration_file)) {
    $migration = include $migration_file;
}

foreach ($migration_class_files as $migration_class_file) {
    list($app, $version, $migration_class) = explode('_', substr(basename($migration_class_file), 0, -4));
    if ($version <= $migration['last_version']) {
        continue;
    }
    echo $migration_class_file,"\n";
    include $migration_class_file;
    $class_name = $app.'_'.$migration_class;
    $obj = new $class_name;
    $obj->env = $env;
    $obj->change();
    $obj->up();
    $migration['last_version'] = $version;
    $migration['executed'][]   = $migration_class_file;
}

file_put_contents($migration_file, "<?php\n".var_export($migration, true));

