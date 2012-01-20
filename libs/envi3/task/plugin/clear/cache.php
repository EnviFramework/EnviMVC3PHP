<?php
/**
 * @package Envi3
 * @subpackage
 * @sinse 0.1
 * @author     Akito<akito-artisan@five-foxes.com>
 */

/**
 *  キャッシュのクリアタスク
 *
 */
umask(0);
$dir = realpath('./cache');
if (($handle = opendir($dir.'/'))) {
    while ($file = readdir($handle)) {
        if ($file === '..' || $file === '.') {
            continue;
        } elseif (is_file($dir . '/' . $file) && mb_ereg("\\.envicc", $file)) {
            unlink($dir . '/' . $file);
            echo $dir . '/' . $file."\n";
        }
    }
    closedir($handle);
}
