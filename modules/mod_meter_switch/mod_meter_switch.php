<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_switch
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */
 
 //header('Content-type:text/html;charset=utf8');

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';


$switch = trim(JRequest::getVar('switch', '-1'));
$key = trim(JRequest::getVar('key', '-1'));   

if($switch == "-1"){
    echo "<script>alert('请先选择要设置的电表信息记录！');history.back(); </script>";
}else{
	  
	  $location_id = trim(JRequest::getVar('location_id', '-1')); 
      $meter_address = trim(JRequest::getVar('meter_address', '-1'));
	  
		
	  date_default_timezone_set('Asia/Singapore');
      $datetime = date('Y-m-d H:i:s');
      $datetime_change = $datetime;
	  
  ModMeterSwitchUpdateHelper::updateMeterSwitchValues($datetime_change, $location_id, $meter_address, $switch, $key );

  require(JModuleHelper::getLayoutPath('mod_meter_switch', 'default'));
	
}
?>