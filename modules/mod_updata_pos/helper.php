<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_updata_pos
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModUpdataHelper
{

	public function setDataPos($DataPos) {
		
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
	
	public function setTimePos($TimePos) {
		
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
	
	public function setTryTime() {
		
            $var_name = "try_time";

			$var_value = 3;
			
			//echo "<br>setTryTime try_time : $try_time";
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
			
			
            $profile_update = new stdClass();
			$profile_update->var_name = $var_name;
			$profile_update->var_value = $var_value;
			$profile_update->change_time = $change_time;
               
            // Update the object from the user profile table.
            $try_time_update = JFactory::getDbo()->updateObject('joomla3_varitely', $profile_update, 'var_name');
			return $var_value;
	
	}
	
	
}
?>