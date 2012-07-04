<?php
/**
 * コマンドのエイリアス
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
 * @version    GIT: $Id$
 * @link       https://github.com/EnviMVC/EnviMVC3PHP
 * @see        https://github.com/EnviMVC/EnviMVC3PHP/wiki
 * @since      File available since Release 1.0.0
*/

$alias = array(
    'cc' => array('clear', 'cache'),
    'app' => array('init', 'app'),
    'module' => array('init', 'module'),
    'controller' => array('init', 'action'), // symfony風のコマンドエイリアス
    'action' => array('init', 'action'),
    'build_model' => array('build', 'model'),
);
