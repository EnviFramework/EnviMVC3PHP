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
 * ArtisanSmarty {select_date} plugin
 *
 * Type:     function<br>
 * Name:     html_select_date<br>
 * Purpose:  Prints the dropdowns for date selection.
 *
 * ChangeLog:<br>
 *           - 1.0 initial release
 *           - 1.1 added support for +/- N syntax for begin
 *                and end year values. (Monte)
 *           - 1.2 added support for yyyy-mm-dd syntax for
 *                time value. (Jan Rosier)
 *           - 1.3 added support for choosing format for
 *                month values (Gary Loescher)
 *           - 1.3.1 added support for choosing format for
 *                day values (Marcus Bointon)
 *           - 1.3.2 suppport negative timestamps, force year
 *             dropdown to include given date unless explicitly set (Monte)
 *
 *
 * @version 1.3.3
 * @author Andrei Zmievski
 * @author Akito<akito-artisan@five-foxes.com>
 * @param array $params パラメータ
 * @param object $smarty Smarty
 * @return string
 */
function smarty_function_html_select_date($params, &$smarty)
{
    require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
    require_once $smarty->_get_plugin_filepath('function','html_options');
    /* Default values. */
    $prefix          = "Date_";
    $start_year      = strftime("%Y");
    $end_year        = $start_year;
    $display_days    = true;
    $display_months  = true;
    $display_years   = true;
    $month_format    = "%B";
    /* Write months as numbers by default  GL */
    $month_value_format = "%m";
    $day_format      = "%02d";
    /* Write day values using this format MB */
    $day_value_format = "%d";
    $year_as_text    = false;
    /* Display years in reverse order? Ie. 2000,1999,.... */
    $reverse_years   = false;
    /* Should the select boxes be part of an array when returned from PHP?
       e.g. setting it to "birthday", would create "birthday[Day]",
       "birthday[Month]" & "birthday[Year]". Can be combined with prefix */
    $field_array     = null;
    /* <select size>'s of the different <select> tags.
       If not set, uses default dropdown. */
    $day_size        = null;
    $month_size      = null;
    $year_size       = null;
    /* Unparsed attributes common to *ALL* the <select>/<input> tags.
       An example might be in the template: all_extra ='class ="foo"'. */
    $all_extra       = null;
    /* Separate attributes for the tags. */
    $day_extra       = null;
    $month_extra     = null;
    $year_extra      = null;
    /* Order in which to display the fields.
       "D" -> day, "M" -> month, "Y" -> year. */
    $field_order     = 'MDY';
    $field_design    = '%s%s%s';
    /* String printed between the different fields. */
    $field_separator = "\n";
    $time = time();
    $all_empty       = null;
    $day_empty       = null;
    $month_empty     = null;
    $year_empty      = null;
    $default_time    = null;

    foreach ($params as $_key=>$_value) {
        switch ($_key) {
            case 'prefix':
            case 'time':
            case 'start_year':
            case 'end_year':
            case 'month_format':
            case 'day_format':
            case 'day_value_format':
            case 'field_array':
            case 'day_size':
            case 'month_size':
            case 'year_size':
            case 'all_extra':
            case 'day_extra':
            case 'month_extra':
            case 'year_extra':
            case 'field_order':
            case 'field_separator':
            case 'month_value_format':
            case 'month_empty':
            case 'day_empty':
            case 'field_design':
            case 'year_empty':
                $$_key = (string)$_value;
                break;

            case 'all_empty':
                $$_key = (string)$_value;
                $day_empty = $month_empty = $year_empty = $all_empty;
                break;

            case 'display_days':
            case 'display_months':
            case 'display_years':
            case 'year_as_text':
            case 'reverse_years':
                $$_key = (bool)$_value;
                break;
            case 'default_time':
                $default_time = $_value;
                break;
            default:
                $smarty->trigger_error("[html_select_date] unknown parameter $_key", E_USER_WARNING);

        }
    }
    if ($default_time) {
        if (is_array($default_time)) {
            
            $default_time = array($default_time[$prefix . 'Year'], $default_time[$prefix . 'Month'], $default_time[$prefix . 'Day']);
            
        } else {
            if(preg_match('!^-\d+$!',$default_time)) {
                // negative timestamp, use date()
                $default_time = date('Y-m-d',$default_time);
            }
            // If $default_time is not in format yyyy-mm-dd
            if (!preg_match('/^\d{0,4}-\d{0,2}-\d{0,2}$/', $default_time)) {
                // use smarty_make_timestamp to get an unix timestamp and
                // strftime to make yyyy-mm-dd
                $default_time = strftime('%Y-%m-%d', smarty_make_timestamp($default_time));
            }
            // Now split this in pieces, which later can be used to set the select
            $default_time = explode("-", $default_time);
        }
    }
    // make syntax "+N" or "-N" work with start_year and end_year
    if (preg_match('!^(\+|\-)\s*(\d+)$!', $end_year, $match)) {
        if ($match[1] == '+') {
            $end_year = strftime('%Y') + $match[2];
        } else {
            $end_year = strftime('%Y') - $match[2];
        }
    }
    if (preg_match('!^(\+|\-)\s*(\d+)$!', $start_year, $match)) {
        if ($match[1] == '+') {
            $start_year = strftime('%Y') + $match[2];
        } else {
            $start_year = strftime('%Y') - $match[2];
        }
    }
    if (strlen($time[0]) > 0) { 
        if ($start_year > $time[0] && !isset($params['start_year'])) {
            // force start year to include given date if not explicitly set
            $start_year = $time[0];
        }
        if($end_year < $time[0] && !isset($params['end_year'])) {
            // force end year to include given date if not explicitly set
            $end_year = $time[0];
        }
    }

    $field_order = strtoupper($field_order);

    $html_result = $month_result = $day_result = $year_result = "";

    if ($display_months) {
        $month_names = array();
        $month_values = array();
        
        for ($i = 1; $i <= 12; $i++) {
            $month_names[$i] = strftime($month_format, @mktime(0, 0, 0, $i, 1, 2000));
            $month_values[$i] = strftime($month_value_format, @mktime(0, 0, 0, $i, 1, 2000));
        }
        $month_result .= '<select name=';
        if (null !== $field_array) {
            $month_result .= '"' . $field_array . '[' . $prefix . 'Month]"';
        } else {
            $month_result .= '"' . $prefix . 'Month"';
        }
        if (null !== $month_size) {
            $month_result .= ' size="' . $month_size . '"';
        }
        if (null !== $month_extra) {
            $month_result .= ' ' . $month_extra;
        }
        if (null !== $all_extra) {
            $month_result .= ' ' . $all_extra;
        }
        $month_result .= '>'."\n";
        if(isset($year_empty)) {
            array_unshift($month_names, $month_empty);
            array_unshift($month_values, '');
        }
        $month_result .= smarty_function_html_options(array('output'     => $month_names,
                                                            'values'     => $month_values,
                                                            'selected'   => $default_time[1] ? strftime($month_value_format, @mktime(0, 0, 0, (int)$default_time[1], 1, 2000)) : '',
                                                            'print_result' => false),
                                                      $smarty);
        $month_result .= '</select>';
    }
    
    if ($display_days) {
        $days = array();
        for ($i = 1; $i <= 31; $i++) {
            $days[] = strftime($day_format, @mktime(0, 0, 0, 1, $i, 2000));
            $day_values[] = strftime($day_value_format, @mktime(0, 0, 0, 1, $i, 2000));
        }
        if(isset($year_empty)) {
            array_unshift($days, $day_empty);
            array_unshift($day_values, '');
        }
        $day_result .= '<select name=';
        if (null !== $field_array) {
            $day_result .= '"' . $field_array . '[' . $prefix . 'Day]"';
        } else {
            $day_result .= '"' . $prefix . 'Day"';
        }
        if (null !== $day_size) {
            $day_result .= ' size="' . $day_size . '"';
        }
        if (null !== $all_extra) {
            $day_result .= ' ' . $all_extra;
        }
        if (null !== $day_extra) {
            $day_result .= ' ' . $day_extra;
        }
        $day_result .= '>'."\n";
        
        $day_result .= smarty_function_html_options(array('output'     => $days,
                                                          'values'     => $day_values,
                                                          'selected'   => $default_time[2] ? strftime($day_value_format, @mktime(0, 0, 0, 1, (int)$default_time[2], 2000)) : '',
                                                          'print_result' => false),
                                                    $smarty);
        $day_result .= '</select>';
    }

    if ($display_years) {
        if (null !== $field_array) {
            $year_name = $field_array . '[' . $prefix . 'Year]';
        } else {
            $year_name = $prefix . 'Year';
        }
        if ($year_as_text) {
            $year_result .= '<input type="text" name="' . $year_name . '" value="' . $default_time[0] . '" size="4" maxlength="4"';
            if (null !== $all_extra) {
                $year_result .= ' ' . $all_extra;
            }
            if (null !== $year_extra) {
                $year_result .= ' ' . $year_extra;
            }
            $year_result .= '>';
        } else {
            $years = range((int)$start_year, (int)$end_year);
            if ($reverse_years) {
                rsort($years, SORT_NUMERIC);
            } else {
                sort($years, SORT_NUMERIC);
            }
            $yearvals = $years;
            if(isset($year_empty)) {
                array_unshift($years, $year_empty);
                array_unshift($yearvals, '');
            }
            $year_result .= '<select name="' . $year_name . '"';
            if (null !== $year_size) {
                $year_result .= ' size="' . $year_size . '"';
            }
            if (null !== $all_extra) {
                $year_result .= ' ' . $all_extra;
            }
            if (null !== $year_extra) {
                $year_result .= ' ' . $year_extra;
            }
            $year_result .= '>'."\n";
            $year_result .= smarty_function_html_options(array('output' => $years,
                                                               'values' => $yearvals,
                                                               'selected'   => $default_time[0], 
                                                               'print_result' => false),
                                                         $smarty);
            $year_result .= '</select>';
        }
    }
    // Loop thru the field_order field
    for ($i = 0; $i <= 2; $i++){
        $c = substr($field_order, $i, 1);
        switch ($c){
            case 'D':
                $html_result[] = $day_result.($i != 2 ? $field_separator : '');
                break;

            case 'M':
                $html_result[] = $month_result.($i != 2 ? $field_separator : '');
                break;

            case 'Y':
                $html_result[] = $year_result.($i != 2 ? $field_separator : '');
                break;
        }
    }
    $html_result = sprintf($field_design, $html_result[0], $html_result[1], $html_result[2]);
    return $html_result;
}
?>