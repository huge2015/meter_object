<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_data
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModDianbiaoSubmitHelper
{
	public function getElectricalData($datetime, $controller_electrical_id, $time_pos, $limit) {
		// read electrical status
		$db = JFactory::getDbo();
		$query = "select * from #__electrical where electrical_id > $controller_electrical_id ORDER BY electrical_id ASC";
		/*$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime', 'phase1_apparent_power',
		   'phase1_voltage', 'phase1_current', 'phase1_frequency') ) );
		$query->from( $db->quoteName('#__electrical') );
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
		    $query = "select * from #__electrical where datetime > $time_pos ORDER BY electrical_id ASC";
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
		$query->from($db->quoteName('#__electrical_status'));
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
		$result = JFactory::getDbo()->updateObject('#__electrical_status', $profile, 'location_id');

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
		$result = JFactory::getDbo()->insertObject('#__electrical', $profile);

	}
	
	
	public function getDataPos() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__varitely WHERE var_name = 'controller_electrical_id'";
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
            $controller_insert = JFactory::getDbo()->insertObject('#__varitely', $profile_controller);
			
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
		$query2 = "SELECT * FROM #__varitely WHERE var_name = 'time_pos'";
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
            $time_pos_insert = JFactory::getDbo()->insertObject('#__varitely', $profile_time);
			
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
            $controller_update = JFactory::getDbo()->updateObject('#__varitely', $profile_update, 'var_name');
	
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
            $time_pos_update = JFactory::getDbo()->updateObject('#__varitely', $profile_update, 'var_name');
	
	}
	
	public function getTryTime() {
		// read DataPos value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__varitely WHERE var_name = 'try_time'";
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
            $trytime_insert = JFactory::getDbo()->insertObject('#__varitely', $trytime);
			
			//return the insert  var_value
			return $var_value;
			
		}else {
			
			$try_time = $row_trytime['var_value'];
		    return $try_time ;
			
		}
	}
	
	
	
	
	
	// A library to implement queues in PHP via arrays  
	// The Initialize function creates a new queue:  
	function queue_initialize() {  
    // In this case, just return a new array  
    	$new = array();  
    	return $new;  
	}  
	// The destroy function will get rid of a queue  
	function queue_destroy($queue) {  
    	// Since PHP is nice to us, we can just use unset  
    	unset($queue);  
	}  
	// The enqueue operation adds a new value unto the back of the queue  
	function queue_enqueue($queue, $value) {  
    	// We are just adding a value to the end of the array, so can use the  
    	//  [] PHP Shortcut for this.  It's faster than using array_push  
    	$queue[] = $value;  
	}  
	// Dequeue removes the front of the queue and returns it to you  
	function queue_dequeue($queue) {  
    	// Just use array unshift  
    	return array_shift($queue);  
	}  
	// Peek returns a copy of the front of the queue, leaving it in place  
	function queue_peek($queue) {  
    	// Return a copy of the value found in front of queue  
    	//  (at the beginning of the array)  
    	return $queue[0];  
	}  
	// Size returns the number of elements in the queue  
	function queue_size($queue) {  
    	// Just using count will give the proper number:  
    	return count($queue);  
	}  
	// Rotate takes the item on the front and sends it to the back of the queue.  
	function queue_rotate($queue) {  
    	// Remove the first item and insert it at the rear.  
    	$queue[] = array_shift($queue);  
	}
     /*
// Let's use these to create a small queue of data and manipulate it.  
// Start by adding a few words to it:  
    $myqueue = queue_initialize(); 
    queue_enqueue($myqueue, 'Opal');  
    queue_enqueue($myqueue, 'Dolphin');  
    queue_enqueue($myqueue, 'Pelican');  
// The queue is: Opal Dolphin Pelican  
// Check the size, it should be 3  
    echo '<p>Queue size is: ', queue_size($myqueue), '</p>';  
// Peek at the front of the queue, it should be: Opal  
    echo '<p>Front of the queue is: ', queue_peek($myqueue), '</p>';  
// Now rotate the queue, giving us: Dolphin Pelican Opal  
    queue_rotate($myqueue);  
// Remove the front element, returning: Dolphin  
    echo '<p>Removed the element at the front of the queue: ',  
    queue_dequeue($myqueue), '</p>'; 
    echo '<p>Now Queue size is: ', queue_size($myqueue), '</p>';
    echo var_dump($myqueue);
   
     queue_dequeue($myqueue); 
	
     echo var_dump($myqueue);
	
// Now destroy it, we are done.  
    queue_destroy($myqueue);  	 
	*/
	
	
	
}//class ModDianbiaoSubmitHelper
