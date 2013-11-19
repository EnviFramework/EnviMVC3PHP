<?php
/**
 *  プロジェクトの追加タスク
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
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
 */

umask(0);
$arr[] = $base_dir."apps";
$arr[] = $base_dir."web";
$arr[] = $base_dir."cache";
$arr[] = $base_dir."config";
$arr[] = $base_dir."logs";
$arr[] = $base_dir."tests";
$ds = DIRECTORY_SEPARATOR;
foreach ($arr as $item) {
    mkdir($item);
    echo $item."\n";
}

