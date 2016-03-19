<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_submit
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */
 
 //header('Content-type:text/html;charset=utf8');

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('style.css','modules/mod_meter_info_submit/css/');

$meter_model = trim(JRequest::getVar('meter_model', '-1')); 

if($meter_model == "-1"){
         mysql_close();
         echo "<script>alert('请先填写电表信息表格，然后按提交按钮提交数据！');history.back(); </script>";
}else{
	   
$location_id = trim(JRequest::getVar('location_id', '-1'));
$meter_address =trim(JRequest::getVar('meter_address', '-1'));
$data_select =trim(JRequest::getVar('data_select', '-1'));


date_default_timezone_set('Asia/Singapore');
$datetime = date('Y-m-d H:i:s');
$datetime_create = $datetime;


// insert to database
ModMeterInfoSubmitHelper::insertMeterInfoValues($datetime_create, $location_id, $meter_address, $meter_model, $data_select);

  
	   
require(JModuleHelper::getLayoutPath('mod_meter_info_submit', 'default'));
	
}
?>