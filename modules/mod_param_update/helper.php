<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_param_update
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModParamUpdateHelper
{
    function updateFreshTime($fresh_time) {
		
		        $var_name = "fresh_time";
				 
				date_default_timezone_set('Asia/Singapore');
                $datetime = date('Y-m-d H:i:s');
                $change_time = $datetime;
				 
                // Create and populate an object.
                $profile = new stdClass();
				$profile->var_name = $var_name;
				$profile->var_value = $fresh_time;
				$profile->change_time = $change_time;

                // Update the object from the user profile table.
                $update_fresh_time = JFactory::getDbo()->updateObject('joomla3_varitely', $profile, 'var_name');

    }
	
	public function updateWaitTime($wait_time) {
		
		        $var_name = "wait_time";
				 
				date_default_timezone_set('Asia/Singapore');
                $datetime = date('Y-m-d H:i:s');
                $change_time = $datetime;
				 
                // Create and populate an object.
                $profile = new stdClass();
				$profile->var_name = $var_name;
				$profile->var_value = $wait_time;
				$profile->change_time = $change_time;

                // Update the object from the user profile table.
                $update_wait_time = JFactory::getDbo()->updateObject('joomla3_varitely', $profile, 'var_name');

    }
	
	public function updateRecordNum($record_num) {
		
		        $var_name = "record_num";
				 
				date_default_timezone_set('Asia/Singapore');
                $datetime = date('Y-m-d H:i:s');
                $change_time = $datetime;
				 
                // Create and populate an object.
                $profile = new stdClass();
				$profile->var_name = $var_name;
				$profile->var_value = $record_num;
				$profile->change_time = $change_time;

                // Update the object from the user profile table.
                $update_record_num = JFactory::getDbo()->updateObject('joomla3_varitely', $profile, 'var_name');

    }
}
