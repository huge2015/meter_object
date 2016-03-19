<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_connect_control
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */
 
 //header('Content-type:text/html;charset=utf8');

defined('_JEXEC') or die;


// Include the functions only once
require_once __DIR__ . '/helper.php';

$action_key = trim(JRequest::getVar('action_key', '-1')); 
	  
if($action_key == "-1"){
	
    echo "<script>alert('请先选择控制行为！');history.back(); </script>";
	
}else if($action_key == "start"){
	$send = "Starting Service successed! ";
	require(JModuleHelper::getLayoutPath('mod_connect_control', 'default'));
	
	system("sudo php /usr/bin/meter_connect.php start > /dev/null &");
	
	/*
	$c_status = ModConnectControlHelper::connectControl();
	//$send = $c_status;

	//echo $c_status." | PID is ".$lock_Pid;
	
    if($c_status == "start"){
		
	    $lock_Pid = file_get_contents('/usr/bin/meter_connect.lock');
        $send = "Starting Service successed! | PID is $lock_Pid <br>";
		
	}else{
		
        $lock_Pid = file_get_contents('/usr/bin/meter_connect.lock');
	    $send = "<b> Warring : </b> connect_status is <b><font color=#ff0000>$c_status</font></b> ! &nbsp;  |&nbsp;  PID is $lock_Pid <br>";
	}

   require(JModuleHelper::getLayoutPath('mod_connect_control', 'default'));
  */
}else{
	  
	$send = system("sudo php /usr/bin/meter_connect.php $action_key", $retrun_code);
    
  require(JModuleHelper::getLayoutPath('mod_connect_control', 'default'));
	
}
?>
