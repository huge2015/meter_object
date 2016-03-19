<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_switch
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModUploadSwitchHelper
{
    public function getUploadStatus() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__varitely WHERE var_name = 'upload_status'";
		$db->setQuery($query);
		$row_id = $db->loadAssoc();
		

		if($row_id == ""){
			
            $var_name = "upload_status";
			$var_value = "" ;
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if DataPos is  null
            $profile_controller = new stdClass();
			$profile_controller->var_name = $var_name;
			$profile_controller->var_value = $var_value;
			$profile_controller->create_time = $create_time;
               
            // Insert the object from the user profile table.
            $controller_insert = JFactory::getDbo()->insertObject('#__varitely', $profile_controller);
			
			//return the insert  var_value
			return $var_value;
			
		}else {
			
			$upload_status = $row_id['var_value'];
		    return $upload_status ;
			
		}
	}
	
	
	public function setUploadStatus($action_key) {
		// read fresh_time value
		$sql_ConnectStatus = "SELECT * FROM joomla3_varitely WHERE var_name = 'upload_status'";
		$rs_ConnectStatus = mysql_query($sql_ConnectStatus);
		$num_ConnectStatus = mysql_num_rows($rs_ConnectStatus);
		
		$var_name = "upload_status";
		$var_value = $action_key ;
		
		if(($num_ConnectStatus == 0) && ($var_value != "start")){
			//while the argv of first command not follw "start",  will not do any thing 
		}else if(($num_ConnectStatus == 0) && ($var_value == "start")){

			

            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if fresh_time is  null
               
            // Update the object from the user profile table.
			$ConnectStatus_update =  "insert into joomla3_varitely (var_name, var_value, create_time) values ('$var_name', '$var_value', '$create_time')";
			mysql_query($ConnectStatus_update);
			//return the insert  var_value
			//return $var_value;

		}else{
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
 
            // Update the object from the user profile table.
			$ConnectStatus_update = "update joomla3_varitely set var_value='$var_value', change_time='$change_time' where var_name = '$var_name'";
			mysql_query($ConnectStatus_update);
			return $var_value;
		}
	}
	
	
}//class
