<?php

set_time_limit(0);


$dir_name = realpath($argv[1]);
$dir_name OR die('パスの指定がおかしいです。');

$cmd = 'find '.$dir_name.'|grep ".php$"';

$proc = popen($cmd, 'r');
while ($file_path = fgets($proc)) {
    $file_path = trim($file_path);
    $encode_cmd = 'nkf -e '.$file_path.' > '.$file_path.'.euc';
    `$encode_cmd`;
    echo $encode_cmd."\n";
    unlink($file_path);
    rename($file_path.'.euc', $file_path);
}

