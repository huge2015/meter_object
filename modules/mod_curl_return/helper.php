<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_return
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModCurlReturnHelper
{
	
	public function getQueueId() {
		//get the last Queue_id from joomla3_queue
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_queue  ORDER BY queue_id DESC ";

		$db->setQuery($query, 0, 1);
		$rows_id = $db->loadAssoc();

//		$electrical_id = $row['electrical_status'];
        if($rows_id == ""){ //while the electrical table has delete or anyway trouble  but the time will update
			/*$db = JFactory::getDbo();
		    $query = "select * from #__electrical where datetime > $time_pos ORDER BY electrical_id ASC";
			$db->setQuery($query,0, $limit);
		    $rows = $db->loadAssocList();
			*/
		}else{
			$queue_id = $rows_id['queue_id'];
		    return $queue_id;
			
		}	
	}
	
	public function delQueueData($queue_id) {
		
			$db = JFactory::getDbo();
			$query = "DELETE FROM joomla3_queue WHERE queue_id = '$queue_id' ORDER BY queue_id ASC";
			$db->setQuery($query);
			$db->Execute($query);

	}
	
	
	public function setDataPos($DataPos) {
		IF(($DataPos=="")||($DataPos==0)){}ELSE{
            $var_name = "controller_electrical_id";
			$var_value = $DataPos ;
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
			
			
            $profile_update = new stdClass();
			$profile_update->var_name = $var_name;
			$profile_update->var_value = $var_value;
			$profile_update->change_time = $change_time;
               
            // Update the object from the user profile table.
            $controller_update = JFactory::getDbo()->updateObject('joomla3_varitely', $profile_update, 'var_name');
	    } 
	}
	
	public function setTimePos($TimePos) {
		IF($TimePos==""){}ELSE{
            $var_name = "time_pos";
			$var_value = $TimePos ;
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
			
			
            $profile_update = new stdClass();
			$profile_update->var_name = $var_name;
			$profile_update->var_value = $var_value;
			$profile_update->change_time = $change_time;
               
            // Update the object from the user profile table.
            $time_pos_update = JFactory::getDbo()->updateObject('joomla3_varitely', $profile_update, 'var_name');
	    }
	}
	
	
}//class
