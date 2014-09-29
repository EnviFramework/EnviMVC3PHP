<?php
if (!isset($argv[2])) {
    eecho('引数が足りません。');
    die;
}

$_SERVER['HTTP_HOST'] = 'localhost';

require $envi_dir.'EnviLogWriter.php';
require $envi_dir.'spyc.php';

ob_start();
include $argv[2];
$buff      = ob_get_contents();
ob_end_clean();

$buff = spyc_load($buff);

var_export($buff);
