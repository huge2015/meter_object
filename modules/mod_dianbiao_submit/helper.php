<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_dianbiao
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModDianbiaoSubmitHelper
{
	public function getElectricalData($datetime, $controller_electrical_id, $time_pos, $limit) {
		// read electrical status
		$db = JFactory::getDbo();
		$query = "select * from joomla3_electrical where electrical_id > $controller_electrical_id ORDER BY electrical_id ASC";
		/*$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime', 'phase1_apparent_power',
		   'phase1_voltage', 'phase1_current', 'phase1_frequency') ) );
		$query->from( $db->quoteName('joomla3_electrical') );
		$query->where( $db->quoteName('location_id')." = ".$db->quote(1) . 
		   " AND `datetime` > '$datetime'" );
		$query->order('datetime ASC');

		$db->setQuery($query,0,$limit);*/
		// $row = $db->loadAssoc();
		
		$db->setQuery($query,0, $limit);
		$rows = $db->loadAssocList();

//		$electrical_id = $row['electrical_status'];
        if($rows == ""){ //while the electrical table has delete or anyway trouble  but the time will update
			$db = JFactory::getDbo();
		    $query = "select * from joomla3_electrical where datetime > $time_pos ORDER BY electrical_id ASC";
			$db->setQuery($query,0, $limit);
		    $rows = $db->loadAssocList();
		}
		return $rows;
	}

	public function getElectricalStatus() {
		// read electrical status
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('electrical_status');
		$query->from($db->quoteName('joomal3_electrical_status'));
		$query->where($db->quoteName('location_id')." = ".$db->quote(1));

		$db->setQuery($query);
		$row = $db->loadAssoc();

		$electrical_status = $row['electrical_status'];
		return $electrical_status;
	}

	public function setElectricalStatus($electrical_status) {
		// Create and populate an object.
		$profile = new stdClass();
		$profile->location_id = 1;
		$profile->electrical_status = $electrical_status;

		// Update the object into the user profile table.
		$result = JFactory::getDbo()->updateObject('joomal3_electrical_status', $profile, 'location_id');

	}

	
	public function insertElectricalValues($datetime,$u, $i, $s, $f) {
		// Create and populate an object.
		$profile = new stdClass();
		$profile->location_id = 1;
		$profile->datetime = $datetime;
		$profile->phase1_voltage = $u;
		$profile->phase1_current = $i;
		$profile->phase1_apparent_power = $s;
		$profile->phase1_frequency = $f;

		// Insert the object into the user profile table.
		$result = JFactory::getDbo()->insertObject('joomal3_electrical', $profile);

	}
	
	
	public function getDataPos() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'controller_electrical_id'";
		$db->setQuery($query);
		$row_id = $db->loadAssoc();
		

		if($row_id == ""){
			
            $var_name = "controller_electrical_id";
			$var_value = "" ;
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if DataPos is  null
            $profile_controller = new stdClass();
			$profile_controller->var_name = $var_name;
			$profile_controller->var_value = $var_value;
			$profile_controller->create_time = $create_time;
               
            // Insert the object from the user profile table.
            $controller_insert = JFactory::getDbo()->insertObject('joomla3_varitely', $profile_controller);
			
			//return the insert  var_value
			return $var_value;
			
		}else {
			
			$data_pos = $row_id['var_value'];
		    return $data_pos ;
			
		}
	}

    public function getTimePos(){
		//---------------------------------------------------------------------------
		$db2 = JFactory::getDbo();
		$query2 = "SELECT * FROM joomla3_varitely WHERE var_name = 'time_pos'";
		$db2->setQuery($query2);
		$row_time = $db2->loadAssoc();
		
		if($row_time == ""){
			
            $var_name = "time_pos";
			$var_value = "" ;
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if time_pos is  null
            $profile_time = new stdClass();
			$profile_time->var_name = $var_name;
			$profile_time->var_value = $var_value;
			$profile_time->create_time = $create_time;
               
            // Insert the object from the user profile table.
            $time_pos_insert = JFactory::getDbo()->insertObject('joomla3_varitely', $profile_time);
			
			//return the insert  var_value
			return $var_value;
			
		}else {
			
			$time_pos = $row_time['var_value'];
		    return $time_pos ;
			
		}
		
		
	}
	
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
	
	public function getTryTime() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'try_time'";
		$db->setQuery($query);
		$row_trytime = $db->loadAssoc();
		

		if($row_trytime == ""){
			
            $var_name = "try_time";
			$var_value = 3 ;
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if DataPos is  null
            $trytime = new stdClass();
			$trytime->var_name = $var_name;
			$trytime->var_value = $var_value;
			$trytime->create_time = $create_time;
               
            // Insert the object from the user profile table.
            $trytime_insert = JFactory::getDbo()->insertObject('joomla3_varitely', $trytime);
			
			//return the insert  var_value
			return $var_value;
			
		}else {
			
			$try_time = $row_trytime['var_value'];
		    return $try_time ;
			
		}
	}
	
}
