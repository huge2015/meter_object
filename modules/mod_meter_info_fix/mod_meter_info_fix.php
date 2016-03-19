<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_fix
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';

$info_id = trim(JRequest::getVar('info_id', "-1")); 

if($info_id == "-1"){
    mysql_close();
    echo "<script>alert('请先选择要更新的记录！');history.back(); </script>";
}else{
	
	$result = ModMeterInfoHelper::getMeterInfoValues($info_id);
	//ModMeterInfoHelper::getElectricalStatus();
	
    /*$sq = "select * from joomla3_meter_info where info_id = '$info_id' ";
	$rst = mysql_query($sq);
	//$rsnum = mysql_num_rows($rst);
    $row = mysql_fetch_array($rst);*/
   
    
    if($result == ""){
      mysql_close();
      echo " <script>alert('不存在的记录项！');history.back(); </script>";
    }else{
	  foreach ($result as $row){
	  $location_id = $row['location_id'];
	  $meter_address = $row['meter_address'];
	  $meter_model = $row['meter_model'];
	  $data_select = $row['data_select'];
	  }
		
	  date_default_timezone_set('Asia/Singapore');
      $datetime = date('Y-m-d H:i:s');
      $datetime_change = $datetime;
 
	}  
	   
	   
	require(JModuleHelper::getLayoutPath('mod_meter_info_fix', 'default'));
	
}
?>