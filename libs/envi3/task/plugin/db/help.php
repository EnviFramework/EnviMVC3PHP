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
 * @copyright  2011-2014 Artisan Project
 * @license    http://opensource.org/licenses/BSD-2-Clause The BSD 2-Clause License
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        http://www.enviphp.net/
 * @since      File available since Release 3.4.0
 */


// ヘルプ表示
cecho('Name:', 33);
cecho('    envi ', 34, '\n         Enviに対する操作を行います');
cecho('Usage:', 33);
    echo '    envi task_name [arguments] [Options]'."\n";
cecho('Task name:', 33);
cecho('    db-migrate <app_key> ([--dry_run]) (env:<envelopment>)       ', 32, '\n       DBのマイグレーション\n       envi db-migration <app_key> ([--dry_run]) (env:<envelopment>)');
cecho('    db-rollback <app_key> ([--dry_run]) (env:<envelopment>)      ', 32, '\n       一個前のバージョンに戻す\n       envi db-rollback <app_key> ([--dry_run]) (env:<envelopment>)');

cecho('    db-redo <app_key> (<count>) ([--dry_run]) (env:<envelopment>)       ', 32, '\n       バージョンを戻してmigrate\n       envi db-redo <app_key> (<count>) ([--dry_run]) (env:<envelopment>)');
cecho('    db-up <app_key> <count> ([--dry_run]) (env:<envelopment>)           ', 32, '\n       DBのマイグレーションを<count>分だけ実行\n       envi db-up <app_key> <count> ([--dry_run]) (env:<envelopment>)');
cecho('    db-down <app_key> <count> ([--dry_run]) (env:<envelopment>)         ', 32, '\n       <count>個前のバージョンに戻す\n       envi db-down <app_key> <count> ([--dry_run]) (env:<envelopment>)');

cecho('    db-cursor <app_key> up                                     ', 32, '\n       バージョンだけをすすめる\n       envi db-cursor <app_key> up');
cecho('    db-cursor <app_key> down                                   ', 32, '\n       バージョンだけを戻す\n       envi db-cursor <app_key> down');
cecho('    db-abort_if_pending_migrations <app_key>                   ', 32, '\n       未実行のマイグレーションを取得する\n       envi db-abort_if_pending_migrations <app_key>');
cecho('    db-new <app_key> <limit>                                   ', 32, '\n       未実行のマイグレーションをすべて取得する\n       envi db-new <app_key> <limit>');
cecho('    db-history <app_key> <limit>                               ', 32, '\n       実行済みのマイグレーションを取得する\n       envi db-new <app_key> <limit>');


cecho('    db-help                       ', 32, '\n       このヘルプを表示します');
exit;
die;