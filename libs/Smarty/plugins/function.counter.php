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
 * 高機能な昨日今日総合カウンターを提供します。
 *
 * Type:     function<br>
 * Name:     counter<br>
 * Purpose:  load config file vars
 * @param array $params Format:
 * <pre>
 * array('assign' => カウンター値がassignされる変数の名前,
 *       'name' => カウンターの名前(ファイル名になります。)
 *       'scope' => local/parent/global
 *       'global' => overrides scope, setting to parent if true)
 * </pre>
 * @param object $smaty smatyクラスオブジェクト
 * @since 2005/06/10 23:57
 * @author Akito<akito-artisan@five-foxes.com>
 * @return bool
 */
function smarty_function_counter($params, &$smarty)
{
	$name = isset($params['name']) ? $params['name'] : 'default';
	$etc_dir = $smarty->_get_etc_dir();
	
	if(file_exists($etc_dir.$name."_counter.php") && !isset($params["reset"])){
		
		$counter=unserialize(file_get_contents($etc_dir.$name."_counter.php"));
		$counter_ck=(mktime(0,0,0,date("m"),date("d"),date("Y"))-$counter["time_stamp"]);

	//日付が変わっていれば値を変更
		if($counter_ck>0){
			if($counter_ck>86401){
				$counter["today"]=0;
				$counter["yesterday"]=0;
			}else{
				$counter["yesterday"]=$counter["today"];
				$counter["today"]=0;
			}
			$counter["time_stamp"]=mktime(0,0,0,date("m"),date("d"),date("Y"));
		}
	}else{
		$counter["total"]=0;
		$counter["today"]=0;
		$counter["yesterday"]=0;
		$counter["time_stamp"]=mktime(0,0,0,date("m"),date("d"),date("Y"));
		$counter["ip"]="";
	}
	//カウンターを回す
	if(isset($params['count_up']) && isset($params['ck_ip']) ? $counter["ip"]!==$_SERVER['REMOTE_ADDR'] : isset($params['count_up'])){
		if(isset($params['skip']) ? is_numeric($params['skip']) : false){
			$skip= $params['skip'];
		}else{
			$skip=1;
		}
		$counter["total"]+=$skip;
		$counter["today"]+=$skip;

		$f=fopen($etc_dir.$name."_counter.php","w");
		flock($f,LOCK_EX);
		fwrite($f,serialize($counter));
		flock($f,LOCK_UN);
		fclose($f);
	}

	if (isset($params['assign'])) {
		$smarty->assign($params['assign'], $counter);
	}else{
		$smarty->assign("counter", $counter);
	}
	
}

?>
