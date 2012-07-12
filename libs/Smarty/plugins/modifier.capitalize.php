<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// |                            Artisan Smarty                            |
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright 2004-2005 ARTISAN PROJECT All rights reserved.             |
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
 * Smarty capitalize modifier plugin
 *
 * Type:     modifier<br>
 * Name:     capitalize<br>
 * Purpose:  capitalize words in the string
 * @link http://smarty.php.net/manual/en/language.modifiers.php#LANGUAGE.MODIFIER.CAPITALIZE
 *      capitalize (Smarty online manual)
 * @param string
 * @return string
 */
function smarty_modifier_capitalize($string, $uc_digits = false)
{
    smarty_modifier_capitalize_ucfirst(null, $uc_digits);
    return preg_replace_callback('!\b\w+\b!', 'smarty_modifier_capitalize_ucfirst', $string);
}

function smarty_modifier_capitalize_ucfirst($string, $uc_digits = null)
{
    static $_uc_digits = false;
    
    if(isset($uc_digits)) {
        $_uc_digits = $uc_digits;
        return;
    }
    
    if(!preg_match('!\d!',$string[0]) || $_uc_digits)
        return ucfirst($string[0]);
    else
        return $string[0];
}


?>
