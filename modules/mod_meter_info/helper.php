<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterInfoHelper
{

    function getMeterInfoValues() {
		  // read meter_model values
		   $db = JFactory::getDBO();

          $query = 'SELECT * FROM joomla3_meter_info order by info_id desc';
          $db->setQuery($query);
          $result = $db->loadAssocList();
          return $result;
	}
	
	public function getMeterStatus($location_id, $meter_address) {
		  // read meter_model values
		  $db = JFactory::getDBO();

          $query = "SELECT * FROM joomla3_electrical_status where location_id = '$location_id' and meter_address = '$meter_address' ";
          $db->setQuery($query);
          //$result = $db->loadAssocList();
          //return $result;
		  $row = $db->loadAssoc();

		  $electrical_status = $row['electrical_status'];
		  return $electrical_status;
	}
	
	public function getFreshTime() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'fresh_time'";
		$db->setQuery($query);
		$row_fresh = $db->loadAssoc();
		
		if($row_fresh == ""){
			
			$fresh_time = 5 ;
		    return $fresh_time ;
	
		}else {
			
			$fresh_time = $row_fresh['var_value'];
		    return $fresh_time ;		
	    }
    }
	public function getWaitTime() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'wait_time'";
		$db->setQuery($query);
		$row_wait = $db->loadAssoc();
		
		if($row_wait == ""){
			
			$wait_time = 1.5 ;
		    return $wait_time ;
	
		}else {
			
			$wait_time = $row_wait['var_value'];
		    return $wait_time ;		
	    }
    }
	
}
