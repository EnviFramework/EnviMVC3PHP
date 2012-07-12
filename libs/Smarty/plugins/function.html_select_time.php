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
 * ArtisanSmarty {html_select_time} function plugin
 *
 * Type:     function<br>
 * Name:     html_select_time<br>
 * Purpose:  Prints the dropdowns for time selection
 * @param array $params パラメータ
 * @param object $smarty Smarty
 * @return string
 * @uses smarty_make_timestamp()
 */
function smarty_function_html_select_time($params, &$smarty)
{
    require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
    require_once $smarty->_get_plugin_filepath('function','html_options');
    /* Default values. */
    $prefix             = "Time_";
    $time               = time();
    $display_hours      = true;
    $display_minutes    = true;
    $display_seconds    = true;
    $display_meridian   = true;
    $default_time       = null;
    $field_separator    = "\n";
    $field_order        = 'HMSA';
    $field_design       = '%s%s%s%s';
    $use_24_hours       = true;
    $minute_interval    = 1;
    $second_interval    = 1;
    /* Should the select boxes be part of an array when returned from PHP?
       e.g. setting it to "birthday", would create "birthday[Hour]",
       "birthday[Minute]", "birthday[Seconds]" & "birthday[Meridian]".
       Can be combined with prefix. */
    $field_array         = null;
    $all_extra           = null;
    $hour_extra          = null;
    $minute_extra        = null;
    $second_extra        = null;
    $meridian_extra      = null;
    $hour_format         = "%02d";
    $minute_format       = "%02d";
    $second_format       = "%02d";
    $meridian_format     = "%A";
    $hour_value_format   = "%02d";
    $minute_value_format = "%02d";
    $second_value_format = "%02d";
    $hour_empty          = null;
    $minute_empty        = null;
    $second_empty        = null;
    $meridian_empty      = null;

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'prefix':
            case 'time':
            case 'field_array':
            case 'all_extra':
            case 'hour_extra':
            case 'minute_extra':
            case 'second_extra':
            case 'meridian_extra':
            case 'field_order':
            case 'field_design':
            case 'hour_format':
            case 'minute_format':
            case 'second_format':
            case 'meridian_format':
            case 'hour_value_format':
            case 'minute_value_format':
            case 'second_value_format':
            case 'hour_empty':
            case 'minute_empty':
            case 'second_empty':
            case 'meridian_empty':
            case 'default_time':
            case 'field_separator':
                $$_key = (string)$_value;
                break;

            case 'display_hours':
            case 'display_minutes':
            case 'display_seconds':
            case 'display_meridian':
            case 'use_24_hours':
                $$_key = (bool)$_value;
                break;

            case 'minute_interval':
            case 'second_interval':
                $$_key = (int)$_value;
                break;

            default:
                $smarty->trigger_error("[html_select_time] unknown parameter $_key", E_USER_WARNING);
        }
    }

    $time = smarty_make_timestamp($time);
    $hour_fmt = $use_24_hours ? '%H' : '%I';
    if ($default_time) {
        if (is_array($default_time)) {
            $a = array(strftime($hour_fmt, mktime($default_time[$prefix . 'Hour'],0,0,1,1,2000)), 
                        sprintf($minute_value_format, $default_time[$prefix . 'Minute']), 
                        sprintf($minute_value_format, $default_time[$prefix . 'Second']), 
                        $default_time[$prefix . 'Meridian']);
        } else {
            if (!is_numeric($default_time)) {
                $default_time = strftime($default_time);
            }
            $a = array(strftime($hour_fmt, $default_time), 
                        sprintf($minute_value_format, intval(floor(strftime('%M', $default_time) / $minute_interval) * $minute_interval)), 
                        sprintf($second_value_format, intval(floor(strftime('%S', $default_time) / $second_interval) * $second_interval)), 
                        strftime("%p", $default_time));
        }
        $default_time = $a;
        
    }
    
    $hours_result = '';
    if ($display_hours) {
        $hours       = $use_24_hours ? range(0, 23) : range(1, 12);
        
        for ($i = 0, $for_max = count($hours); $i < $for_max; $i++) {
            $hours_names[$i] = sprintf($hour_format, $hours[$i]);
            $hours_values[$i] = sprintf($hour_value_format, $hours[$i]);
        }
        $hours_result .= '<select name=';
        if (null !== $field_array) {
            $hours_result .= '"' . $field_array . '[' . $prefix . 'Hour]"';
        } else {
            $hours_result .= '"' . $prefix . 'Hour"';
        }
        if (null !== $hour_extra){
            $hours_result .= ' ' . $hour_extra;
        }
        if (null !== $all_extra){
            $hours_result .= ' ' . $all_extra;
        }
        $hours_result .= '>'."\n";
        if(isset($hour_empty)) {
            array_unshift($hours_names, $hour_empty);
            array_unshift($hours_values, '');
        }
        $hours_result .= smarty_function_html_options(array('output'          => $hours_names,
                                                           'values'          => $hours_values,
                                                           'selected'      => $default_time[0],
                                                           'print_result' => false),
                                                     $smarty);
        $hours_result .= "</select>\n";
    }

    $minutes_result = "";
    if ($display_minutes) {
        $all_minutes = range(0, 59);
        for ($i = 0, $for_max = count($all_minutes); $i < $for_max; $i+= $minute_interval) {
            $minutes_names[] = sprintf($minute_format, $all_minutes[$i]);
            $minutes_values[] = sprintf($minute_value_format, $all_minutes[$i]);
        }
        $minutes_result .= '<select name=';
        if (null !== $field_array) {
            $minutes_result .= '"' . $field_array . '[' . $prefix . 'Minute]"';
        } else {
            $minutes_result .= '"' . $prefix . 'Minute"';
        }
        if (null !== $minute_extra){
            $minutes_result .= ' ' . $minute_extra;
        }
        if (null !== $all_extra){
            $minutes_result .= ' ' . $all_extra;
        }
        $minutes_result .= '>'."\n";
        
        if(isset($minute_empty)) {
            array_unshift($minutes_names, $minute_empty);
            array_unshift($minutes_values, '');
        }
        $minutes_result .= smarty_function_html_options(array('output'          => $minutes_names,
                                                           'values'          => $minutes_values,
                                                           'selected'      => $default_time[1],
                                                           'print_result' => false),
                                                     $smarty);
        $minutes_result .= "</select>\n";
    }
    
    $seconds_result = "";
    if ($display_seconds) {
        $all_seconds = range(0, 59);
        for ($i = 0, $for_max = count($all_seconds); $i < $for_max; $i+= $second_interval) {
            $seconds_names[] = sprintf($second_format, $all_seconds[$i]);
            $seconds_values[] = sprintf($second_value_format, $all_seconds[$i]);
        }
        $selected = intval(floor(strftime('%S', $time) / $second_interval) * $second_interval);
        $seconds_result .= '<select name=';
        if (null !== $field_array) {
            $seconds_result .= '"' . $field_array . '[' . $prefix . 'Second]"';
        } else {
            $seconds_result .= '"' . $prefix . 'Second"';
        }
        
        if (null !== $second_extra){
            $seconds_result .= ' ' . $second_extra;
        }
        if (null !== $all_extra){
            $seconds_result .= ' ' . $all_extra;
        }
        $seconds_result .= '>'."\n";

        if(isset($second_empty)) {
            array_unshift($seconds_names, $second_empty);
            array_unshift($seconds_values, '');
        }
        $seconds_result .= smarty_function_html_options(array('output'          => $seconds_names,
                                                           'values'          => $seconds_values,
                                                           'selected'      => $default_time[2],
                                                           'print_result' => false),
                                                     $smarty);
        $seconds_result .= "</select>\n";
    }

    $meridian_result = "";
    if ($display_meridian && !$use_24_hours) {
        $meridian_name = array('AM', 'PM');
        $meridian_value = array('am', 'pm');
        $meridian_result .= '<select name=';
        if (null !== $field_array) {
            $meridian_result .= '"' . $field_array . '[' . $prefix . 'Meridian]"';
        } else {
            $meridian_result .= '"' . $prefix . 'Meridian"';
        }
        
        if (null !== $meridian_extra){
            $meridian_result .= ' ' . $meridian_extra;
        }
        if (null !== $all_extra){
            $meridian_result .= ' ' . $all_extra;
        }
        $meridian_result .= '>'."\n";

        if(isset($meridian_empty)) {
            array_unshift($meridian_name, $meridian_empty);
            array_unshift($meridian_value, '');
        }
        $meridian_result .= smarty_function_html_options(array('output'          => $meridian_name,
                                                           'values'          => $meridian_value,
                                                           'selected'      => $default_time[3],
                                                           'print_result' => false),
                                                     $smarty);
        $meridian_result .= "</select>\n";
    }
    
    $html_result = array();
    for ($i = 0; $i <= 3; $i++){
        $c = substr($field_order, $i, 1);
        switch ($c){
            case 'H':
                $html_result[] = $hours_result.($i != 3 ? $field_separator : '');
                break;

            case 'M':
                $html_result[] = $minutes_result.($i != 3 ? $field_separator : '');
                break;

            case 'S':
                $html_result[] = $seconds_result.($i != 3 ? $field_separator : '');
                break;
                
            case 'A':
                $html_result[] = $meridian_result.($i != 3 ? $field_separator : '');
                break;
        }
    }
    $html_result = sprintf($field_design, $html_result[0], $html_result[1], $html_result[2], $html_result[3]);
    return $html_result;
}

/* vim: set expandtab: */

?>
