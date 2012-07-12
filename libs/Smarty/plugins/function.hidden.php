<?php
// +----------------------------------------------------------------------+
// |                            ARTISANシステム                           |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002-2004 The Artisan Member                           |
// +----------------------------------------------------------------------+
// | Authors: Akito<akito-artisan@five-foxes.com>                         |
// +----------------------------------------------------------------------+
//
/**
* ArtisanSmarty plugin
* @package ArtisanSmarty
* @subpackage plugins
*/

/**
* ArtisanSmarty {hidden} plugin
* @version 1.0.1
* @author   Akito
* @param array
* @param Smarty
* @return string
*/

function smarty_function_hidden($params, &$smarty)
{
    if (is_array($params["item"])) {
        return make_hidden($params, $smarty, $params["item"]);
    }
}

function make_hidden(&$params, &$smarty, $item, $name = false)
{
    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
    foreach ($item as $key => $value) {
        if (isset($params["split"][$key])) {
            continue;
        }
        $key = $params["escape"] ? htmlspecialchars($key) : $key;
        if ($name !== false) {
            $key = $name."[".$key."]";
        }
        
        if (is_array($value)) {
            $res  .= make_hidden($params, $smarty, $value, $key);
        } else {
            $value = $params["escape"] ? htmlspecialchars($value) : $value;
            $res  .= "<input type=\"hidden\" name=\"".smarty_function_escape_special_chars($key)."\" value=\"".smarty_function_escape_special_chars($value)."\">";
        }
    }
    return $res;
}

?>