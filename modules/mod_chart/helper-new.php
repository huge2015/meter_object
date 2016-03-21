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
		
//JLog::add(JText::_(" getVar meter_address is : $meter_address"), JLog::ERROR, 'jerror');

//explode $data_index     
	$strArr=explode('-',$meter_address); 
	$mchk = sizeof($strArr); //cout array numbers or // $mchk = count($strArr);
	unset($meter_address);
	for($i = 0; $i<$mchk ; $i++){
        $meter_address[$i] = $strArr[$i];
    }
//JLog::add(JText::_(" getVar meter_address is : $meter_address[0] - $meter_address[1] - $meter_address[2]"), JLog::ERROR, 'jerror');
	
//exit;
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

		if ($from_datetime_string == null) {
			$time = strtotime($to_datetime);
			$time = $time - (1 * 60); // 1 minute in seconds
			$from_datetime = date("Y-m-d H:i:s", $time);
		} else {
			$from_datetime = date($from_datetime_string);
		}

		if ($columns_string == null) {
			if ($t == 1) {
				$columns = array('electrical_id', 'meter_address', 'location_id', 'datetime', 'phase1_apparent_power', 'phase1_voltage', 'phase1_current', 'phase1_frequency');
				$select_string = '`electrical_id`, `meter_address`, `location_id`, `datetime`, `phase1_apparent_power`, `phase1_voltage`, `phase1_current`, `phase1_frequency`';
			} else {
				$columns = array('electrical_id', 'meter_address', 'location_id', 'MAX(`datetime`)', 'AVG(phase1_apparent_power)', 'AVG(phase1_voltage)', 'AVG(phase1_current)', 'AVG(phase1_frequency)');
				$select_string = '`electrical_id`, `meter_address`, `location_id`, MAX(`datetime`) AS `datetime`, AVG(`phase1_apparent_power`) AS phase1_apparent_power, AVG(`phase1_voltage`) AS phase1_voltage, AVG(`phase1_current`) AS phase1_voltage, AVG(`phase1_frequency`) AS phase1_frequency';
			} // if t = 1
		} else {
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
						$select_string .= "$comma MAX(`datetime`) AS `datetime` ";
					} else {
						$select_string .= "$comma AVG(`$columns[$j]`) AS `$columns[$j]`";
					}		
				} // for
			} else {
				for($j=0; $j<sizeOf($columns);$j++) {
					if ($first_time) {
						$first_time = 0;
						$comma = '';
					} else {
						$comma = ',';
					}		
					$select_string .= "$comma `$columns[$j]`";
				} // for
			} //$t > 1
		} // if $columns_string
		

	    
		
	unset($format_datetime);
	unset($phase1_apparent_power);
	unset($phase2_apparent_power);
	unset($phase3_apparent_power);
	unset($count_time);
	
	for($s = 0; $s < $mchk; $s++){	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
//		$query->select( $db->quoteName($columns) );
		$query->select( $select_string );

		$query->from( $db->quoteName("#__$table") );		
		$query->where(
		              $db->quoteName('location_id')." = ".$db->quote($location_id) . 
					  " AND `meter_address` >= " . $db->quote($meter_address[$s]) . 
				      " AND `datetime` >= " . $db->quote($from_datetime) . 
					  " AND `datetime` <= " . $db->quote($to_datetime)  
				);
		if ($t > 1) { // more than 1 s data interval, need to group and average
			$query->group( "(TIME_TO_SEC(datetime) - (TIME_TO_SEC (datetime) % ($t) ) )" );		
		}
		$query->order('datetime ASC');
	
//  echo("query is " . $query->__toString() . '---');

		$db->setQuery($query,0,$num_records);
		$rows = $db->loadAssocList();
JLog::add(JText::_(" getVar rows[0] is : $rows[0]"), JLog::ERROR, 'jerror');	
		
		$t = 0; //for get every $s loop time value of format_datetime
			foreach ($rows as $row){
				    $phase1_apparent_power[$s."_".$t] = $row['phase1_apparent_power'];
				    $phase2_apparent_power[$s."_".$t] = $row['phase2_apparent_power'];
				    $phase3_apparent_power[$s."_".$t] = $row['phase3_apparent_power'];
					$format_datetime[$s."_".$t] = $row['datetime'];
			    $t++;	
			}// for each
			$count_time[$s] = $t ;
    }//for(query)
		
	
	$ArrO = 0;
        for ($s = 0; $s < $mchk; $s++){
			if (!$ArrO) { $ArrO = 1;}
			else {echo ",";}
			
			$ArrA = 0;
			for($t = 0; $t <$count_time[$s]; $t++){
				if (!$ArrA) { $ArrA = 1;}
			    else {echo ",";}
				if(sizeof($meter_address) == 1){
		            $row[] =$format_datetime[$s."_".$t].",".$phase1_apparent_power[$s."_".$t].",".$phase2_apparent_power[$s."_".$t].", ".$phase3_apparent_power[$s."_".$t]." ]";
				}else{
					echo "[ new Date(".$format_datetime[$s."_".$t]."),".$phase1_apparent_power[$s."_".$t].",".$phase2_apparent_power[$s."_".$t].", ".$phase3_apparent_power[$s."_".$t].", ";
					
					
					$ArrB = 0;
					for($i = 1; $i < $mchk; $i++){
						if (!$ArrB) { $ArrB = 1;}
			            else {echo ",";}
						echo $phase1_apparent_power[$i."_".$t].",".$phase2_apparent_power[$i."_".$t].", ".$phase3_apparent_power[$i."_".$t];	 
					}
					
					echo "]";
				}//if
			}//for($t)
				
		}//for($s)
	
JLog::add(JText::_(" getVar rows is : json_encode($rows)"), JLog::ERROR, 'jerror');			
		return json_encode($rows);
	} // getChartData

	
	
}