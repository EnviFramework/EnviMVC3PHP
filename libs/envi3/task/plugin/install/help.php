<?php
/**
 * マニュアル
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


// ヘルプ表示
cecho('Name:', 33);
cecho('    envi ', 34, '\n         Enviに対する操作を行います');
cecho('Usage:', 33);
    echo '    envi task_name [arguments] [Options]'."\n";
cecho('Task name:', 33);
cecho('    install-bundle {new|update|delete} <bundle.yml uri(or path)>                         ', 32, '\n       パッケージを追加・更新・削除します\n        envi bundle-bundle <mode> <bundle.yml uri(or path)>');
cecho('    install-extension <app_key> <di_yaml path> <extension name>                          ', 32, '\n       エクステンションをインストールします\n       envi install-extension <app_key> <di_yaml path> <extension name>');

cecho('    install-help                       ', 32, '\n        このヘルプを表示します');
exit;
die;