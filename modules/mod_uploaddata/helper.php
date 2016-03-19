<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_uploaddata
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

//jimport('joomla.log.log');
//JLog::addLogger(array());

//JLog::add(JText::_("Require helper!"), JLog::ERROR, 'jerror');

class modUploaddataHelper
{
	public static function isDataNew($controller_electrical_id, $location_id, $meter_address) {
		// check if data is new based on controller_electrical_id and location_id
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('electrical_id', 'controller_electrical_id', 'meter_address')));
		//$query->from($db->quoteName('joomla3_electrical'));
		$query->from($db->quoteName('y3u_electrical'));
		$query->where("controller_electrical_id = " . $db->quote($controller_electrical_id) . " AND "
		      . "location_id =  " . $db->quote($location_id). " AND "
		      . "meter_address =  " . $db->quote($meter_address) );
			  
	    //$query = "SELECT * FROM y3u_electrical WHERE controller_electrical_id = $controller_electrical_id  AND location_id =  $location_id ";		  

		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
	    //$row = $db->loadAssoc();

		if ($num_rows == 0) {
			return 1; // new
		} else {
			return 0; // not new
		}
	}
	
	
  
  public static function getUploadDataAjax(){
	  
	$allarr = JRequest::getVar('allarr', '-1');
    $num_records = JRequest::getVar('num_records', '-1');
    $fields = JRequest::getVar('fields', '-1');
	
    //var_dump($allarr);
   
   $Arr_fields = $allarr;

//*JLog- write error info to  error file-----------------------------------------------------------------*/
 //JLog::add(JText::_("Before return : $allarr"), JLog::ERROR, 'jerror');


   /*---while get $allarr is json data ---- explode style----
	$arr_len = strlen($allarr);
    $allarr = substr($allarr , 1, $arr_len-2);
    $data_index = str_replace('"' , '', $allarr);
   
	
    //explode $data_index     
	$strArr=explode(',',$data_index); 
	$arr_num = sizeof($strArr); //cout array numbers or // $arr_num = count($strArr);
	for($i = 0; $i<$arr_num ; $i++){
        //echo $i.':'.$strArr[$i].'<br/>';
    }
    
    unset($Arr_fields);
	$Arr_fields_nums = $fields * $num_records ;
    for ($j = 0; $j < $Arr_fields_nums; $j++){
	  $var = $strArr[$j]; 
	  $arr = explode(":",$var);
	  $var_name = $arr[0];
	  $var_vaule = $arr[1];   // explode Array value
	  $Arr_fields[$var_name] = $var_vaule ;
    }
    */
    

    if ($num_records>0) {
	for ($n=0; $n<$num_records; $n++){

		//check record is new

		$controller_electrical_id = $Arr_fields["controller_electrical_id-$n"];
		$location_id = $Arr_fields["location_id-$n"];
		$meter_address = $Arr_fields["meter_address-$n"];


	
	
		if ( ($controller_electrical_id >0) && ($location_id > 0) ) {
			$new = ModUploaddataHelper::isDataNew($controller_electrical_id, $location_id, $meter_address);

			if ( $new ) {
             
				// Create and populate an object.
				$electrical = new stdClass();
				$electrical->controller_electrical_id = $controller_electrical_id;
				$electrical->location_id = $location_id;
				$electrical->meter_address = $meter_address;
				$electrical->datetime = $Arr_fields["datetime-$n"];
				
				$electrical->total_power = $Arr_fields["total_power-$n"];
				$electrical->energy_kwh = $Arr_fields["energy_kwh-$n"];
				$electrical->phase1_power_factor = $Arr_fields["phase1_power_factor-$n"];
				
				$electrical->phase1_real_power = $Arr_fields["phase1_real_power-$n"];
				$electrical->phase2_real_power = $Arr_fields["phase2_real_power-$n"];
				$electrical->phase3_real_power = $Arr_fields["phase3_real_power-$n"];
				
				
				$electrical->phase1_frequency = $Arr_fields["phase1_frequency-$n"];
				$electrical->phase1_apparent_power = $Arr_fields["phase1_apparent_power-$n"];
				$electrical->phase1_voltage = $Arr_fields["phase1_voltage-$n"];
				$electrical->phase1_current = $Arr_fields["phase1_current-$n"];
				
				//$electrical->phase2_frequency = $Arr_fields["phase2_frequency-$n"];
				$electrical->phase2_apparent_power = $Arr_fields["phase2_apparent_power-$n"];
				$electrical->phase2_voltage = $Arr_fields["phase2_voltage-$n"];
				$electrical->phase2_current = $Arr_fields["phase2_current-$n"];
				
				//$electrical->phase3_frequency = $Arr_fields["phase3_frequency-$n"];
				$electrical->phase3_apparent_power = $Arr_fields["phase3_apparent_power-$n"];
				$electrical->phase3_voltage = $Arr_fields["phase3_voltage-$n"];
				$electrical->phase3_current = $Arr_fields["phase3_current-$n"];
				
				
				$electrical->Uab = $Arr_fields["Uab-$n"];
				$electrical->Ubc = $Arr_fields["Ubc-$n"];
				$electrical->Uca = $Arr_fields["Uca-$n"];
				
				$electrical->Qa = $Arr_fields["Qa-$n"];
				$electrical->Qb = $Arr_fields["Qb-$n"];
				$electrical->Qc = $Arr_fields["Qc-$n"];
				$electrical->Qs = $Arr_fields["Qs-$n"];
				
				$electrical->PFa = $Arr_fields["PFa-$n"];
				$electrical->PFb = $Arr_fields["PFb-$n"];
				$electrical->PFc = $Arr_fields["PFc-$n"];
				$electrical->PFs = $Arr_fields["PFs-$n"];
				
				$electrical->Sa = $Arr_fields["Sa-$n"];
				$electrical->Sb = $Arr_fields["Sb-$n"];
				$electrical->Sc = $Arr_fields["Sc-$n"];
				$electrical->Ss = $Arr_fields["Ss-$n"];
				
				$electrical->WPP = $Arr_fields["WPP-$n"];
				$electrical->WPN = $Arr_fields["WPN-$n"];
				$electrical->WQP = $Arr_fields["WQP-$n"];
				$electrical->WQN = $Arr_fields["WQN-$n"];
				
				$electrical->EPN = $Arr_fields["EPN-$n"];
				$electrical->EQP = $Arr_fields["EQP-$n"];
				$electrical->EQN = $Arr_fields["EQN-$n"];
		
				// Insert the object into the user profile table.
				//$result = JFactory::getDbo()->insertObject('joomla3_electrical2', $electrical);
				$result = JFactory::getDbo()->insertObject('y3u_electrical', $electrical);
				
				
			} //if
		} // if
	}// for
    }//if ($num_records>0) 


//JLog::add(JText::_("Before return 1"), JLog::ERROR, 'jerror');

        
		
 } // getUploadData

	
// A library to implement queues in PHP via arrays  
// The Initialize function creates a new queue:  
public function &queue_initialize() {  
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
function queue_peek(&$queue) {  
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

	
}//class modUploaddataHelper
?>