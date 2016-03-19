<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_updata_error
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModUploadDataErrorHelper
{

	function getTryTime() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'try_time'";
		$db->setQuery($query);
		$row_trytime = $db->loadAssoc();
		
	    $try_time = $row_trytime['var_value'];
		return $try_time ;
		
	}
	
	public function setTryTime($try_time) {
		
            $var_name = "try_time";

			$var_value = $try_time;
			
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