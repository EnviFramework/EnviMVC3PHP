<?php
if (!isset($argv[2])) {
    eecho('引数が足りません。show man => envi test-help');
    die;
}

// Envi2のディレクトリのパスを指定する。
$envi_dir = ENVI_BASE_DIR;
$envi_cmd = true;
require $envi_dir.'test/EnviTestCmd.php';


// 実行
$EnviTest = EnviTest::singleton($argv[2]);
$EnviTest->execute();
