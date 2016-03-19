<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_excute
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModUploadExcuteHelper
{
	function getRecordNum() {
		
		$var_name = "record_num";
		
		// read record_num value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = '$var_name' ";
		$db->setQuery($query);
		$rows_record = $db->loadAssoc();

		
        
		if($rows_record == ""){
			  
            // Update the object from the user profile table.
			date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');
			
		    // Create and populate an object.
		    $profile = new stdClass();
		    $profile->var_name = $var_name;
			$profile->create_time = $create_time;
		
		    // Insert the object into the user profile table.
		    $result = JFactory::getDbo()->insertObject('joomla3_varitely', $profile);
			
        }else{
			
			$record_num = $rows_record['var_value'];
			return $record_num;
		}
	}
	
	
	public function getQueueData($limit) {
		// read electrical status
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_queue  ORDER BY queue_id ASC";
        
		$db->setQuery($query, 0, $limit);
		$rows = $db->loadAssocList();

//		$electrical_id = $row['electrical_status'];
        if($rows == ""){ //while the electrical table has delete or anyway trouble  but the time will update
			/*$db = JFactory::getDbo();
		    $query = "select * from #__electrical where datetime > $time_pos ORDER BY electrical_id ASC";
			$db->setQuery($query,0, $limit);
		    $rows = $db->loadAssocList();
			*/
		}else{
			
		    return $rows;
			
		}	
	}
	
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
	
	public function delQueueData($_POST_data, $limit) {
		//$queue_id = $_POST_data;
		for ($n=0; $n<$limit; $n++){ // delete queue from joomla3_queue table
			
			$queue_id = $_POST_data["queue_id-$n"];

			$db = JFactory::getDbo();
			$query = "DELETE FROM joomla3_queue WHERE queue_id <= '$queue_id' ORDER BY queue_id ASC";
			$db->setQuery($query);
			
			$db->Execute($query);
	
		}
   	
	}
	
	public function getElectricalData($electrical_id, $location_id, $meter_address, $datetime) {
		// read electrical data
		$db = JFactory::getDbo();
		$query = "SELECT * FROM #__electrical WHERE electrical_id = '$electrical_id' AND location_id = '$location_id' AND meter_address = '$meter_address' AND datetime = '$datetime' ";
		
		$db->setQuery($query);
		$rows = $db->loadAssocList();

        if($rows == ""){ 
		
		    $db = JFactory::getDbo();
		    $query = "DELETE * FROM #__queue WHERE electrical_id = '$electrical_id' AND location_id = '$location_id' AND meter_address = '$meter_address' AND datetime = '$datetime' ";
		    $db->setQuery($query);
			
		}else{
			
		    return $rows;
			
		}
	}
	
	
	public function getDataRaw($datetime, $data_pos, $time_pos, $limit) {
		
		if($data_pos == ""){$data_pos = 0;}
		if($time_pos == ""){$time_pos = date("Y-m-d H:i:s", strtotime($time_pos));}
		
		// read electrical status
		$db = JFactory::getDbo();
		$query = "select * from #__electrical where electrical_id > '$data_pos' ORDER BY electrical_id ASC";
		
		$db->setQuery($query,0, $limit);
		$rows_raw = $db->loadAssocList();

//		$electrical_id = $row['electrical_status'];
        if($rows_raw == ""){ //while the electrical table has delete or anyway trouble  but the time will update
			$db = JFactory::getDbo();
		    $query = "select * from #__electrical where datetime > '$time_pos' ORDER BY electrical_id ASC";
			$db->setQuery($query,0, $limit);
		    $rows_raw = $db->loadAssocList();
		}
		return $rows_raw;
	}

	
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
	
	
	public function getContent($line_url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $line_url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; U; Linux i686; zh-CN; rv:1.9.1.2) Gecko/20120829 Firefox/3.5.2 GTB5');
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_REFERER, $line_url);
        $content = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode == 200) {
                $content = mb_convert_encoding($content, "UTF-8", "GBK");
        }
         return $content;
        
    }
	
	
	
	
	//----****------------------------------------------------------------------------------
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
	
	
	
	// A library to implement queues in PHP via arrays  
	// The Initialize function creates a new queue:  
	public function queue_initialize() {  
	    // In this case, just return a new array  
	    $new = array();  
	    return $new;  
	}  
	// The destroy function will get rid of a queue  
	public function queue_destroy(&$queue) {  
    	// Since PHP is nice to us, we can just use unset  
	    unset($queue);  
	}  
	// The enqueue operation adds a new value unto the back of the queue  
	public function queue_enqueue(&$queue, $value) {  
	    // We are just adding a value to the end of the array, so can use the  
 	   //  [] PHP Shortcut for this.  It's faster than using array_push  
	    $queue[] = $value;  
	}  
	// Dequeue removes the front of the queue and returns it to you  
	public function queue_dequeue(&$queue) {  
	    // Just use array unshift  
	    return array_shift($queue);  
	}  
	// Peek returns a copy of the front of the queue, leaving it in place  
	public function queue_peek(&$queue) {  
	    // Return a copy of the value found in front of queue  
	    //  (at the beginning of the array)  
	    return $queue[0];  
	}  
	// Size returns the number of elements in the queue  
	public function queue_size(&$queue) {  
	    // Just using count will give the proper number:  
	    return count($queue);  
	}  
	// Rotate takes the item on the front and sends it to the back of the queue.  
	public function queue_rotate(&$queue) {  
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
