<?php defined('_JEXEC') or die;

/**
 * File       helper.php
 */
jimport('joomla.log.log');
JLog::addLogger(array());

class modChartHelper {

	public static function getChartDataAjax(){
		// $table is the table to read from. can have electrical, water, etc
		// $location_id is the location id. unique for each building
		// $meter_address is an array of the meter_address to read pertaining to the location
		// $from_datetime is the datetime to start the search from
		// $to_datetime is the datetime to end the search
		// $num_records is the number of records to retrieve
		// $data interval is the interval between records
			// n-t, n is a number, t is the term, like y,m,d,w,h,i,s. Eg. 1-s
	
		$table = JRequest::getVar('table', 'electrical');
		$location_id = JRequest::getVar('location_id', '1');
		$meter_address = JRequest::getVar('meter_address', '-1' );
		$columns_string = JRequest::getVar('columns', NULL );
		$from_datetime_string = JRequest::getVar('from_datetime', NULL);
		$to_datetime_string = JRequest::getVar('to_datetime', NULL);
		$num_records = JRequest::getVar('num_records', '30');
		$data_interval = JRequest::getVar('data_interval', '1-s');

    //explode $data_index     
	$strArr=explode('-',$meter_address); 
	$mchk = sizeof($strArr); //cout array numbers or // $mchk = count($strArr);
	unset($meter_address);
	for($i = 0; $i<$mchk ; $i++){
        $meter_address[$i] = $strArr[$i];
    }

/*
echo "meter_address is $meter_address ---";
echo "columns_string is $columns_string ---";
echo "num_records is $num_records ---";
echo "from_datetime_string is $from_datetime_string ---";
echo "to_datetime_string is $to_datetime_string ---";
echo "data_interval is $data_interval ---";
*/
		date_default_timezone_set('Asia/Singapore');
		if ($to_datetime_string == null) {
			$to_datetime = date('Y-m-d H:i:s');
		} else {
			$to_datetime = date($to_datetime_string);
		}

		$data_interval_array = explode('-',$data_interval);
		if ($data_interval_array[1] == 's') { // seconds
			$t = 1 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'i') { // minutes
			$t = 60 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'h') { //hour
			$t = 60 * 60 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'd') { //day
			$t = 24 * 60 * 60 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'w') { //week
			$t = 7 * 24 * 60 * 60 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'm') { // month
			$t = 30 * 24 * 60 * 60 * $data_interval_array[0]; // convert to seconds
		} elseif ($data_interval_array[1] == 'y') { // year
			$t = 365 * 24 * 60 * 60 * $data_interval_array[0]; // convert to seconds
		} 

		/*if ($from_datetime_string == null) {
			$time = strtotime($to_datetime);
			$time = $time - (1 * 60); // 1 minute in seconds
			$from_datetime = date("Y-m-d H:i:s", $time);
		//} else {
			*/
			$from_datetime = date($from_datetime_string);
		//}
        
		/*
		if ($columns_string == null) {
			if ($t == 1) {
				$columns = array('electrical_id', 'meter_address', 'location_id', 'datetime', 'phase1_apparent_power', 'phase1_voltage', 'phase1_current', 'phase1_frequency');
				$select_string = '`electrical_id`, `meter_address`, `location_id`, `datetime`, `phase1_apparent_power`, `phase1_voltage`, `phase1_current`, `phase1_frequency`';
			} else {
				$columns = array('electrical_id', 'meter_address', 'location_id', 'MAX(`datetime`)', 'AVG(phase1_apparent_power)', 'AVG(phase1_voltage)', 'AVG(phase1_current)', 'AVG(phase1_frequency)');
				$select_string = '`electrical_id`, `meter_address`, `location_id`, MAX(`datetime`) AS `datetime`, AVG(`phase1_apparent_power`) AS phase1_apparent_power, AVG(`phase1_voltage`) AS phase1_voltage, AVG(`phase1_current`) AS phase1_voltage, AVG(`phase1_frequency`) AS phase1_frequency';
			} // if t = 1
		} else {
        */
			$columns = explode(',', $columns_string);
			$select_string = '';
			$first_time = 1;
			if ($t > 1) {
				for($j=0; $j<sizeOf($columns);$j++) {
					if ($first_time) {
						$first_time = 0; 
						$comma = '';
					} else {
						$comma = ',';
					}
					if ($columns[$j] == 'datetime') {
						$select_string .= " $comma MAX(`datetime`) AS `datetime` ";
					} else {
						$select_string .= " $comma AVG(`$columns[$j]`) AS `$columns[$j]`";
						//JLog::add(JText::_(" columns[$j] is : $columns[$j]"), JLog::ERROR, 'jerror');
					}		
				} // for
				$select_string .= ", `location_id`, `meter_address`";
            } else {
				for($j=0; $j<sizeOf($columns);$j++) {
					if ($first_time) {
						$first_time = 0;
						$comma = '';
					} else {
						$comma = ',';
					}
					
                    if ($columns[$j] == 'datetime') {
						$select_string .= " $comma MAX(`datetime`) AS `datetime` ";
					} else {					
					    $select_string .= " $comma AVG(`$columns[$j]`) AS `$columns[$j]` ";
					}
				} // for
				$select_string .= ", `location_id`, `meter_address`";
				
			} //if($t > 1)
		//} // if $columns_string

		
	unset($format_datetime);
	unset($phase1);
	unset($phase2);
	unset($phase3);
	unset($count_time);
	
	for($s = 0; $s < $mchk; $s++){	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
//		$query->select( $db->quoteName($columns) );
		$query->select( $select_string );
          
		$query->from( $db->quoteName("#__$table") );		
		$query->where(
		              $db->quoteName('location_id')." = ".$db->quote($location_id) . 
					  " AND `meter_address` = " . $db->quote($meter_address[$s]) . 
				      " AND `datetime` >= " . $db->quote($from_datetime) . 
					  " AND `datetime` <= " . $db->quote($to_datetime)  
				);
		//if ($t > 1) { // more than 1 s data interval, need to group and average
			$query->group( "(TIME_TO_SEC(datetime) - (TIME_TO_SEC (datetime) % ($t) ) )" );		
		//}
		$query->order('datetime ASC');
//  echo("query is " . $query->__toString() . '---');
		$db->setQuery($query);
		$rows = $db->loadAssocList();

		    $m = 0; //for get every $s loop time value of format_datetime
			foreach ($rows as $row){
				//for($cols = 1; $cols < sizeof($columns); $col++){
					//$phase1[$s."_".$m] = $row["$columns[1]"];
				//}
				    $phase1[$s."_".$m] = $row["$columns[1]"];
				    $phase2[$s."_".$m] = $row["$columns[2]"];
				    $phase3[$s."_".$m] = $row["$columns[3]"];
					$format_datetime[$s."_".$m] = $row['datetime'];
					
			    $m++;	
			}// for each
			$count_time[$s] = $m ;
JLog::add(JText::_("count_time[$s]  is : ".$count_time[$s]), JLog::ERROR, 'jerror');
    }//for(query)
		
	    for($s = 0; $s < $mchk; $s++){
			if($s == 0){
				$count_each = $count_time[$s];
			}else{
				if($count_each > $count_time[$s]){
				    $count_each = $count_time[$s];
			    }
			}	
		}//for
//JLog::add(JText::_("count_each  is : ".$count_each), JLog::ERROR, 'jerror');	
	 
	 unset($jrows);
	
        for ($s = 0; $s < $mchk; $s++){
			
			for($m = 0; $m < $count_each; $m++){
				if(sizeof($meter_address) == 1){
		            $jrows[$m]['datetime'] = $format_datetime[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase1'] = $phase1[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase2'] = $phase2[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase3'] = $phase3[$s.'_'.$m];
					
				}else{
					$jrows[$m]['datetime'] = $format_datetime[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase1'] = $phase1[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase2'] = $phase2[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase3'] = $phase3[$s.'_'.$m];
					
					for($i = 1; $i < $mchk; $i++){
						$jrows[$m]['Meter'.$meter_address[$i].'_phase1'] = $phase1[$i.'_'.$m];
					    $jrows[$m]['Meter'.$meter_address[$i].'_phase2'] = $phase2[$i.'_'.$m];
					    $jrows[$m]['Meter'.$meter_address[$i].'_phase3'] = $phase3[$i.'_'.$m];	 
					}
					
				}//if
			}//for($m)
		
		}//for($s)
			
		
        $json_rows = json_encode($jrows);	
		return $json_rows;
	} // getChartData

	
	
}