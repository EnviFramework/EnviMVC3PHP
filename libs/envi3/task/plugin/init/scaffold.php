<?php
/**
 *  コードの自動生成
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
 * @since      File available since Release 1.0.0
 */
umask(0);
if (!isset($argv[4])) {
    eecho('引数が足りません。');
    die;
}
$i = 2;

// タイプの設定
$type = 'type:default';
if (strpos($argv[$i], 'type:')) {
    $type = $argv[$i];
    $i++;
}
list(, $type) = explode(':', $type, 2);

// プロジェクト名
$project_name = $argv[$i];
$i++;

// モジュール名
$module_name  = $argv[$i];
$i++;



include_once ENVI_BASE_DIR.'spyc.php';



if (!preg_match('/^[a-zA-Z0-9.\-_]+$/', $project_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}
if (!preg_match('/^[a-zA-Z0-9.\-_]+$/', $module_name)) {
    eecho('英数と._-以外の文字は使えません。');
    die;
}



$project_dir = $current_work_dir;
while (!is_file($project_dir.'envi.prj') && strlen($project_dir) > 2) {
    $project_dir = dirname($project_dir).DIRECTORY_SEPARATOR;
}

if (!is_file($project_dir.'envi.prj')) {
    echo 'please change directory. envi project directory';
    die;
}


// モジュールの作成
if (!isset($argv[$i])) {
    eecho('引数が足りません。');
    die;
}



$module_dir = $project_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modules".DIRECTORY_SEPARATOR;
$action_dir = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'actions'.DIRECTORY_SEPARATOR;
$template_dir = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR;


$module_test_dir = $project_dir."tests".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."modulesTest".DIRECTORY_SEPARATOR;
$action_test_dir = $module_test_dir.DIRECTORY_SEPARATOR.$module_name.'Test';


$model_dir = $project_dir."apps".DIRECTORY_SEPARATOR.$project_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR."models".DIRECTORY_SEPARATOR;




$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR;
$arr[] = $module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."libs".DIRECTORY_SEPARATOR;

// テスト用
$arr[] = $module_test_dir;
$arr[] = $action_test_dir;;


foreach ($arr as $item) {
    if (is_dir($item)) {
        continue;
    }
    mkdir($item);
    echo $item."\n";
}

$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'actions.class.php.snp');
$text = str_replace(array('%%module_name%%'), array($module_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.'actions.class.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."actions".DIRECTORY_SEPARATOR.'actions.class.php', $text);
}

$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'views.class.php.snp');
$text = str_replace(array('%%module_name%%'), array($module_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'views.class.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.'views.class.php', $text);
}

$text = file_get_contents($task_plugin_dir.$module.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'config.php.snp');
$text = str_replace(array('%%module_name%%'), array($module_name), $text);
if (!is_file($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'config.php')) {
    file_put_contents($module_dir.DIRECTORY_SEPARATOR.$module_name.DIRECTORY_SEPARATOR.'config.php', $text);
}


// アクションの作成

$validators = array(

    'equal'             => '_typeEqual',
    'notequal'          => '_typeNotEqual',
    'xdigit'            => '_typeXdigit',
    'digit'             => '_typeDigit',
    'cntrl'             => '_typeCntrl',
    'graph'             => '_typeGraph',
    'lower'             => '_typeLower',
    'upper'             => '_typeUpper',
    'print'             => '_typePrint',
    'punct'             => '_typePunct',
    'space'             => '_typeSpace',
    'notxdigit'         => '_typeNotXdigit',
    'withoutdigit'      => '_typeWithoutDigit',
    'withoutcntrl'      => '_typeWithoutCntrl',
    'withoutgraph'      => '_typeWithoutGraph',
    'withoutlower'      => '_typeWithoutLower',
    'withoutupper'      => '_typeWithoutUpper',
    'withoutprint'      => '_typeWithoutPrint',
    'withoutpunct'      => '_typeWithoutPunct',
    'withoutspace'      => '_typeWithoutSpace',
    'withoutalphabet'              => '_typeWithoutAlphabet',
    'withoutalphabetornumber'      => '_typeWithoutAlphabetOrNumber',
    'number'           => '_typeNumber',
    'naturalnumber'    => '_typeNaturalNumber',
    'integer'          => '_typeInteger',
    'numbermax'        => '_typeNumberMax',
    'numbermin'        => '_typeNumberMin',
    'alphabet'         => '_typeAlphabet',
    'alphabetornumber' => '_typeAlphabetOrNumber',
    'rome'             => '_typeRome',
    'maxlen'           => '_typeMaxLen',
    'minlen'           => '_typeMinLen',
    'maxwidth'         => '_typeMaxWidth',
    'minwidth'         => '_typeMinWidth',
    'blank'            => '_typeBlank',
    'noblank'          => '_typeNoBlank',
    'nosubmit'         => '_typeNoSubmit',
    'encoding'         => '_typeEncoding',
    'notags'           => '_typeNoTags',
    'depend'           => '_typeDepend',
    'mailformat'       => '_typeMailFormat',
    'mailsimple'       => '_typeMailFormatSymple',
    'mail'             => '_typeMail',
    'hiragana'         => '_typeHiragana',
    'katakana'         => '_typeKatakana',
    'hfurigana'        => '_typeHFurigana',
    'kfurigana'        => '_typeKFurigana',
    'urlformat'        => '_typeUrlFormat',
    'url'              => '_typeUrl',
    'postcodeformat'   => '_typePostcodeFormat',
    'telephone'        => '_typeTelephoneFormat',
    'whitelist'        => '_typeWhiteList',
    'date'             => '_typeDate',
    'time'             => '_typeTime',
    'array'            => '_typeArray',
    'notarray'         => '_typeNotArray',
    'arraykeyexists'   => '_typeArrayKeyExists',
    'arraynumber'      => '_typeArrayNumber',
    'arraynumbermax'   => '_typeArrayNumberMax',
    'arraynumbermin'   => '_typeArrayNumberMin',
    'arraycountmax'    => '_typeArrayCountMax',
    'arraycountmin'    => '_typeArrayCountMin',
    'arrayunique'      => '_typeArrayUnique',
    'maxbr'            => '_typeMaxBr',
    'minbr'            => '_typeMinBr',
    'dirpath'          => '_typeDirPath',
    'file'             => '_typeFile',
    'ereg'             => '_typeEreg',
    'preg'             => '_typePreg',
);

$db_data_type = array(
    'id' => array(
    'type' => 'int(11)',
    'primary' => 'PRIMARY',
    'auto_increment' => true,
    'not_null' => true,
    'default' => NULL,
    )
);

$setter_text = '';
$validate_text = '';
$form_text = '';
$confirm_text = '';
$show_text = '';
while (isset($argv[$i]) ? $scaffold_data = $argv[$i] : false) {
    // scafold 引数を展開
    $scaffold_data   = explode(',', $scaffold_data);
    $scaffold_data_f = array();

    // 第一引数
    $scaffold_form = array_shift($scaffold_data);
    $scaffold_form = explode(':', $scaffold_form);
    $scaffold_name = $scaffold_form[0];

    // 残りをパースする
    foreach ($scaffold_data as $val) {
        $val_p = explode(':', $val);
        if (count($val_p) === 1) {
            $scaffold_data_f[$val] = true;
        } else {
            $val_key = array_shift($val_p);
            $scaffold_data_f[$val_key] = $val_p[0];
        }
    }

    // データ型の調整
    $scaffold_type      = isset($scaffold_form[1]) ? $scaffold_form[1] : 'string';
    $scaffold_form_name = isset($scaffold_form[2]) ? $scaffold_form[2] : $scaffold_type;

    // スキーマの初期化
    $db_data_type[$scaffold_name] = array();

    // ファイルパス
    $file_poth = dirname(__FILE__).'/scaffold/default/validate_start';
    // notnullならかえる
    if (isset($scaffold_data_f['notnull'])) {
        $file_poth .= '_notnull';
    }
    $file_poth .= '.php';
    if (!is_file($file_poth)) {
        throw new exception($file_poth.'is not exists.');
    }

    // バリデータの初期化
    $validate = array();
    foreach ($scaffold_data_f as $key => $item) {
        if (isset($validators[$key])) {
            $validate[$key] = $item;
        }
    }

    $validate_text .= str_replace(
        array(
            '_____scaffold_name_____',
            '_____scaffold_form_name_____',
        ),
        array($scaffold_name, $scaffold_form_name),
        file_get_contents($file_poth)
    );

    $scaffold_form_type = 'text';
    switch ($scaffold_type) {
    case 'integer':
    case 'int':
        $scaffold_form_type = 'number';
        $db_data_type[$scaffold_name]['type'] = 'int(11)';
        $validate['integer'] = true;
        if ($scaffold_data_f['unsigned']) {
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 2147483647;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : -2147483648;
        } else {
            $db_data_type[$scaffold_name]['unsigned'] = true;
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 4294967295;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        }
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
    break;
    case 'naturalnumber':
        $scaffold_form_type = 'number';
        $validate['naturalnumber'] = true;
        $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 4294967295;
        $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
        $db_data_type[$scaffold_name]['type'] = 'int(11)';
        $db_data_type[$scaffold_name]['unsigned'] = true;
    break;
    case 'bigint':
        $scaffold_form_type = 'number';
        $validate['integer'] = true;
        $db_data_type[$scaffold_name]['type'] = 'bigint(20)';
        if ($scaffold_data_f['unsigned']) {
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 9223372036854775807;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : -9223372036854775808;
        } else {
            $db_data_type[$scaffold_name]['unsigned'] = true;
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : '18446744073709551615';
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        }
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
    break;
    case 'tinyint':
        $scaffold_form_type = 'number';
        $db_data_type[$scaffold_name]['type'] = 'tinyint(4)';
        $validate['integer'] = true;
        if ($scaffold_data_f['unsigned']) {
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 127;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : -128;
        } else {
            $db_data_type[$scaffold_name]['unsigned'] = true;
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 255;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        }
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
    break;
    case 'smallint':
        $scaffold_form_type = 'number';
        $db_data_type[$scaffold_name]['type'] = 'smallint(6)';
        $validate['integer'] = true;
        if ($scaffold_data_f['unsigned']) {
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 32767;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : -32768;
        } else {
            $db_data_type[$scaffold_name]['unsigned'] = true;
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 65535;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        }
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
    break;
    case 'mediumint':
        $scaffold_form_type = 'number';
        $db_data_type[$scaffold_name]['type'] = 'mediumint(7)';
        $validate['integer'] = true;
        if ($scaffold_data_f['unsigned']) {
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 8388607;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : -8388608;
        } else {
            $db_data_type[$scaffold_name]['unsigned'] = true;
            $validate['numbermax'] = isset($validate['numbermax']) ? $validate['numbermax'] : 16777215;
            $validate['numbermin'] = isset($validate['numbermin']) ? $validate['numbermin'] : 0;
        }
        $validate['maxwidth'] = isset($validate['maxwidth']) ? $validate['maxwidth'] : max(strlen($validate['numbermax']), strlen($validate['numbermin']));
    break;
    case 'string':
    case 'varchar':
        $scaffold_form_type = 'text';
        if (!isset($validate['maxwidth'])) {
            $validate['maxwidth'] = 255;
        }
        $db_data_type[$scaffold_name]['type'] = 'varchar('.$validate['maxwidth'].')';
    break;
    case 'email':
        $scaffold_form_type = 'email';
        if (!isset($validate['maxwidth'])) {
            $validate['maxwidth'] = 255;
        }
        $db_data_type[$scaffold_name]['type'] = 'varchar('.$validate['maxwidth'].')';
        $validate['mailsimple'] = true;
    break;
    case 'password':
        $scaffold_form_type = 'password';
        if (!isset($validate['maxwidth'])) {
            $validate['maxwidth'] = 255;
        }
        $db_data_type[$scaffold_name]['type'] = 'varchar('.$validate['maxwidth'].')';
        $validate['rome'] = true;
    break;
    case 'textarea':
    case 'text':
        $scaffold_form_type = 'textarea';
        if (!isset($validate['maxwidth'])) {
            $validate['maxwidth'] = 1000;
        }
        $db_data_type[$scaffold_name]['type'] = 'text';
    break;
    default:
        throw new exception($scaffold_type . 'は存在しないデータ型です。');
        break;
    }

    // Not Null対応
    $db_data_type[$scaffold_name]['not_null'] = false;
    if (isset($scaffold_data_f['notnull'])) {
        $db_data_type[$scaffold_name]['not_null'] = true;
    }

    // デフォルト値対応
    $db_data_type[$scaffold_name]['default'] = isset($scaffold_data_f['default']) ? (int)$scaffold_data_f['default'] : NULL;

    foreach ($validate as $validator => &$val) {
        $val = var_export($val, true);

        $validate_text .= str_replace(
            array(
                '_____scaffold_name_____',
                '_____scaffold_form_name_____',
                '_____scaffold_validate_type_____',
                '_____scaffold_validate_value_____',
            ),
            array($scaffold_name, $scaffold_form_name, $validator, $val),
            file_get_contents(dirname(__FILE__).'/scaffold/default/validate_chain.php')
        );
    }

    $form_text .= str_replace(
        array(
            '_____scaffold_name_____',
            '_____scaffold_form_name_____',
            '_____scaffold_form_type_____',
            '_____scaffold_validate_type_____',
            '_____scaffold_validate_value_____',
            '_____scaffold_form_default_____',
        ),
        array($scaffold_name, $scaffold_form_name, $scaffold_form_type, $validator, $val, $db_data_type[$scaffold_name]['default']),
        file_get_contents(dirname(__FILE__).'/scaffold/default/__form_column.tpl')
    );

    $confirm_text .= str_replace(
        array(
            '_____scaffold_name_____',
            '_____scaffold_form_name_____',
            '_____scaffold_form_type_____',
            '_____scaffold_validate_type_____',
            '_____scaffold_validate_value_____',
            '_____scaffold_form_default_____',
        ),
        array($scaffold_name, $scaffold_form_name, $scaffold_form_type, $validator, $val, $db_data_type[$scaffold_name]['default']),
        file_get_contents(dirname(__FILE__).'/scaffold/default/__confirm_column.tpl')
    );
    $show_text .= str_replace(
        array(
            '_____scaffold_name_____',
            '_____scaffold_form_name_____',
            '_____scaffold_form_type_____',
            '_____scaffold_validate_type_____',
            '_____scaffold_validate_value_____',
            '_____scaffold_form_default_____',
        ),
        array($scaffold_name, $scaffold_form_name, $scaffold_form_type, $validator, $val, $db_data_type[$scaffold_name]['default']),
        file_get_contents(dirname(__FILE__).'/scaffold/default/__show_column.tpl')
    );

    $setter_text .= str_replace(
        array(
            '_____scaffold_name_____',
            '_____scaffold_pascal_case_name_____',
            '_____modle_pascal_case_name_____',
            '_____scaffold_form_name_____',
            '_____scaffold_validate_type_____',
            '_____scaffold_validate_value_____',
        ),
        array($scaffold_name, pascalize($scaffold_name), pascalize($module_name), $scaffold_form_name, $validator, $val),
        file_get_contents(dirname(__FILE__).'/scaffold/default/setter.php')
    );
    $i++;
}
$db_data_type['insert_date'] = array(
    'type' => 'datetime',
    'insert_date' => true,
    'not_null' => true,
    'default' => NULL,
);
$db_data_type['update_date'] = array(
    'type' => 'datetime',
    'update_date' => true,
    'not_null' => true,
    'default' => NULL,
);
$db_data_type['owner'] = array(
    'type' => 'varchar(128)',
    'not_null' => true,
    'default' => 'system_insert',
);
$db_data_type['time_stamp'] = array(
    'type' => 'timestamp',
    'not_null' => true,
    'default' => NULL,
);





$yaml = Spyc::YAMLDump(array('SCHEMA' => array(pascalize($module_name) => $db_data_type)), 2, 60);
writeAction($yaml, $project_name.'_'.$module_name, $project_dir.'config'.DIRECTORY_SEPARATOR, '.yml');

$replace_from = array(
        '_____action_name_____',
        '/*%%validate_text%%*/',
        '/*%%setter_text%%*/',
        '/*%%form_text%%*/',
        '/*%%confirm_text%%*/',
        '/*%%show_text%%*/',
        '_____module_name_____',
        '_____modle_pascal_case_name_____',
    );
$replace_to = array(
        'new',
        $validate_text,
        $setter_text,
        $form_text,
        $confirm_text,
        $show_text,
        $module_name,
        pascalize($module_name),
    );

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/new.tpl')
);
writeAction($contents, 'new', $template_dir, '.tpl');


$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/edit.tpl')
);
writeAction($contents, 'edit', $template_dir, '.tpl');



$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/new_confirm.tpl')
);
writeAction($contents, 'new_confirm', $template_dir, '.tpl');


$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/edit_confirm.tpl')
);
writeAction($contents, 'edit_confirm', $template_dir, '.tpl');



$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/_form_helper.tpl')
);
writeAction($contents, '_form_helper', $template_dir, '.tpl');

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/_confirm_helper.tpl')
);
writeAction($contents, '_confirm_helper', $template_dir, '.tpl');


$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/common_error.tpl')
);
writeAction($contents, 'common_error', $template_dir, '.tpl');

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/show.tpl')
);
writeAction($contents, 'show', $template_dir, '.tpl');

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/index.tpl')
);
writeAction($contents, 'index', $template_dir, '.tpl');

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/destroy.tpl')
);
writeAction($contents, 'destroy', $template_dir, '.tpl');

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/newAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);



$replace_to[0] = 'create';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/createAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);

$replace_to[0] = 'show';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/showAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);

$replace_to[0] = 'edit';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/editAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);


$replace_to[0] = 'update';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/updateAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);

$replace_to[0] = 'destroy';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/destroyAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);

$replace_to[0] = 'index';
$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/indexAction.php')
);
writeAction($contents, $replace_to[0].'Action', $action_dir);


$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/OrmapPeer.php')
);
writeAction($contents, pascalize($module_name).'Peer', $model_dir);

$contents = str_replace(
    $replace_from,
    $replace_to,
    file_get_contents(dirname(__FILE__).'/scaffold/default/Ormap.php')
);
writeAction($contents, pascalize($module_name), $model_dir);




function pascalize($string)
{
    $string = strtolower($string);
    $string = str_replace('_', ' ', $string);
    $string = ucwords($string);
    $string = str_replace(' ', '', $string);
    return $string;
}


function writeAction($contents, $file_name, $dir, $ext = '.class.php')
{
    file_put_contents($dir.$file_name.$ext, $contents);
}