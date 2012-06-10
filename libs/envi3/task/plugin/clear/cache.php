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
 * @version    GIT: $Id:$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
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
