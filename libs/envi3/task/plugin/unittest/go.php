<?php
if (!isset($argv[2])) {
    eecho('����������܂���Bshow man => envi test-help');
    die;
}

// Envi2�̃f�B���N�g���̃p�X���w�肷��B
$envi_dir = ENVI_BASE_DIR;
$envi_cmd = true;
require $envi_dir.'test/EnviTestCmd.php';


// ���s
$EnviTest = EnviTest::singleton($argv[2]);
$EnviTest->execute();
