﻿<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_local
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

header('Content-type: text/html; charset=utf8');
defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_dianbiao_submit/css/');


$location_id = trim(JRequest::getVar('location_id', '1')); 
$expression = trim(JRequest::getVar('expression', '1-i new')); 
$live_data = trim(JRequest::getVar('live_data', '1')); 

   
	



    $db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select( $db->quoteName(array('info_id', 'location_id', 'meter_address') ) ); 
	$query->from( $db->quoteName("#__meter_info_server") );
	$query->where( $db->quoteName('location_id')." = ".$db->quote($location_id) );
	$query->order('meter_address ASC');
	$db->setQuery($query);
	$Inforows = $db->loadAssocList();
        
	$met = 0;
	$mchk = 0;
	$count_Mvalue = 0; //for check Array meter_address is empty
	$M_address = "";  //Format Array [meter_address] ,for upload meter_address by ajax data style, while element jump the next one follow "," 
	unset($Meter);
	unset($MeterName);
	unset($MeterValue);
	unset($meter_address);
    foreach($Inforows AS $InfoVaule){
		$Meter[$met] = $InfoVaule['meter_address'];	
		$MeterName[$met] = "Meter".$InfoVaule['meter_address'];
        $MeterValue[$met] = trim(JRequest::getVar("$MeterName[$met]", '-1'));
	    //echo "<br>$MeterName[$met] : $MeterValue[$met]";
		$count_Mvalue = $count_Mvalue + $MeterValue[$met] + 1;  //if $count_Mvalue = 0 Array meter_address is empty
		
		if($MeterValue[$met] == "1"){
			
		    $meter_address[$mchk] = $InfoVaule['meter_address'];
			
			if($M_address == ""){
				$M_address = $meter_address[$mchk];
			}else{
				$M_address = $M_address."-".$meter_address[$mchk];
			}
			
			$mchk++;
		}
		
    $met++;
    }
	
	

	//echo "<br>$count_Mvalue"; 
	if($count_Mvalue == 0){ //while all meter none cheched
		$meter_address[0] = $Meter[0];
		$M_address = $Meter[0];
		$mchk++;
	}
	
	echo "<br>";
	//var_dump($meter_address);
	echo "<br>mchk: $mchk";
	echo "<br>met: $met";
	

    $num_records = 30;
	
	$select_string = '`electrical_id`, `meter_address`, `location_id`, MAX(`datetime`) AS `datetime`, AVG(`phase1_apparent_power`) AS phase1_apparent_power, AVG(`phase2_apparent_power`) AS phase2_apparent_power, AVG(`phase3_apparent_power`) AS phase3_apparent_power';
	
	$from_datetime = date('Y-m-d H:i:s', ( time() - 5*60) ); 
	$to_datetime = date('Y-m-d H:i:s');	
	
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
          
		$query->from( $db->quoteName("#__electrical") );		
		$query->where(
		              $db->quoteName('location_id')." = ".$db->quote($location_id) . 
					  " AND `meter_address` = " . $db->quote($meter_address[$s]) . 
				      " AND `datetime` >= " . $db->quote($from_datetime) . 
					  " AND `datetime` <= " . $db->quote($to_datetime)  
				);
		//if ($t > 1) { // more than 1 s data interval, need to group and average
			$query->group( "(TIME_TO_SEC(datetime) - (TIME_TO_SEC (datetime)  ) )" );		
		//}
		$query->order('datetime ASC');
//  echo("query is " . $query->__toString() . '---');
		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
        $rows = $db->loadAssocList();
		
		
		$m = 0; //for get every $s loop time value of format_datetime
		if($num_rows == "0"){}else{
		foreach ($rows as $row){
			//for($cols = 1; $cols < sizeof($columns); $col++){
				//$phase1[$s."_".$m] = $row["$columns[1]"];
			//}
			$phase1[$s."_".$m] = $row['phase1_apparent_power'];
			$phase2[$s."_".$m] = $row['phase2_apparent_power'];
			$phase3[$s."_".$m] = $row['phase3_apparent_power'];
			$format_datetime[$s."_".$m] = $row['datetime'];
					
			$m++;	
		}// for each
		}	
		$count_time[$s] = $m ;
    }//for(query)
		
	
	    for($s = 0; $s < $mchk; $s++){
			if($s == 0){
				$count_max = $count_time[$s];
				$MaxMeterId = $s;
			}else{
				if($count_max < $count_time[$s]){
				    $count_max = $count_time[$s];
					$MaxMeterId = $s;
			    }
			}	
		}//for
		


	unset($jrows); 
	     
        //get max recoders datetime
		for($m = 0; $m < $count_max; $m++){
		    $jrows[$m]['datetime'] = $format_datetime[$MaxMeterId.'_'.$m];
		}//for($m)
		
//$jtime = json_encode($jrows);
//JLog::add(JText::_("jtime datetime is : ".$jtime), JLog::ERROR, 'jerror');	 

        for ($s = 0; $s < $mchk; $s++){
			
			for($m = 0; $m < $count_max; $m++){
				if(sizeof($meter_address) == 1){
		            $jrows[$m]['datetime'] = $format_datetime[$MaxMeterId.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase1'] = $phase1[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase2'] = $phase2[$s.'_'.$m];
					$jrows[$m]['Meter'.$meter_address[$s].'_phase3'] = $phase3[$s.'_'.$m];
					
				}else{
					
					$jrows[$m]['datetime'] = $format_datetime[$MaxMeterId.'_'.$m];
					
					if($phase1[$s.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$s].'_phase1'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$s].'_phase1'] = $phase1[$s.'_'.$m];}
					if($phase2[$s.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$s].'_phase2'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$s].'_phase2'] = $phase2[$s.'_'.$m];}
					if($phase3[$s.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$s].'_phase3'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$s].'_phase3'] = $phase3[$s.'_'.$m];}
					
					for($i = 1; $i < $mchk; $i++){
						if($phase1[$i.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$i].'_phase1'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$i].'_phase1'] = $phase1[$i.'_'.$m];}
					    if($phase2[$i.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$i].'_phase2'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$i].'_phase2'] = $phase2[$i.'_'.$m];}
					    if($phase3[$i.'_'.$m] == null){$jrows[$m]['Meter'.$meter_address[$i].'_phase3'] = '0.00000000';}else{$jrows[$m]['Meter'.$meter_address[$i].'_phase3'] = $phase3[$i.'_'.$m];}						
					}
					
				}//if
			}//for($m)
		
		}//for($s)
			
		
        $json_rows = json_encode($jrows);
		
		echo "<br><br><br>json_rows : ".$json_rows;
	
?>

<form name=chart_form action="index.php/upload-local" method="POST">
<table >
<tr>
<td width=500px>
    
	
    <select id='location_frame' name='location_id' class="input-small" onChange="javascript:changeLocation(this.value);">
	    <option value="<?php echo $location_id; ?>" selected>Locat <?php echo $location_id; ?></option>
<?php 
	    $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('info_id', 'location_id') ) ); 
		$query->from( $db->quoteName("#__meter_info_server") );
		//$query->where( $db->quoteName('meter_address')." = ".$db->quote($meter_address) );
		$query->order('location_id ASC');
		$db->setQuery($query);
		$locrows = $db->loadAssocList();
		
        $l = 1;
        $l2 = $l - 1;		
        unset($location);		
	    foreach($locrows AS $LocVaule){
			
				$location["$l"] = $LocVaule['location_id'];
				$location_2 = $location["$l2"];
			    if(($location["$l"] != $location_2)&&($location["$l"] != $location_id)){
?>  
				
		<option value="<?php echo $LocVaule['location_id']; ?>" >Locat <?php echo $LocVaule['location_id']; ?></option>
		
<?php		}
        $l++;
		$l2++;
        }
?>	
	</select> 


	<!--select id='meter_frame' name='meter_frame' class="input-small" onChange="javascript:changeMeter(this.value);">
	 
<?php /*
	    $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('info_id', 'location_id', 'meter_address') ) ); 
		$query->from( $db->quoteName("#__meter_info_server") );
		$query->where( $db->quoteName('location_id')." = ".$db->quote($location_id) );
		$query->order('meter_address ASC');
		$db->setQuery($query);
		$Inforows = $db->loadAssocList();

	    foreach($Inforows AS $InfoVaule){
			if($meter_address == $InfoVaule['meter_address']){
?>
		<option value="<?php echo $InfoVaule['meter_address']; ?>" selected>Meter <?php echo $InfoVaule['meter_address']; ?></option>
<?php	    }else{  ?>
	    <option value="<?php echo $InfoVaule['meter_address']; ?>" >Meter <?php echo $InfoVaule['meter_address']; ?></option>
<?php	
            } 
			
        }
		*/
  ?>	
	</select--> 
	
	<select  name='time_frame' class="input-small" onChange="javascript:changeTime(this.value);">
	<option value="<?php echo $expression; ?>" selected><?php echo $Time_interval; ?></option>
		<option value="5-y new">5 years</option>
		<option value="2-y new">2 years</option>
		<option value="1-y new">Year</option>
		<option value="1-q new">Quarter</option>
		<option value="1-m new">Month</option>
		<option value="1-w new">Week</option>
		<option value="1-d new">Day</option>
		<option value="1-h new">Hour</option>
		<option value="1-i new">Minute</option>
	</select> 
	
    <input type=radio id="live_data" name=live_data value='1' checked  onclick='changeLive()'>Live</input>
	<input type=radio id="history_data" name=live_data value='0'  onclick='changeLive()'>Historical</input>

</td>
</tr>

<tr align="left" >
    <td style="padding-left:2px;">
			
<?php 
	   
	    
	    for($met_s = 0; $met_s < $met; $met_s++){
		    $MeterName = $Meter[$met_s];
?>			
	<input name="<?php echo $MeterName;?>" id="<?php echo $MeterName;?>" type="checkbox"  value="1"  <?php  if( $MeterValue["$met_s"] == 1){ ?>checked ="checked" <?php } ?> onclick="javascript:changeMeter('<?php echo $MeterName;?>');"/>&nbsp;<?php echo $MeterName;?>&nbsp;&nbsp;
<?php	}  ?>      
        
		<!--input name="Meter01" id="M1" type="checkbox"  value="1"  <?php  //if($Meter01 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter01();"/>&nbsp;Meter 01&nbsp;&nbsp;
		<input name="Meter02" id="M2" type="checkbox"  value="1"  <?php  //if($Meter02 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter02();"/>&nbsp;Meter 02&nbsp;&nbsp;
		<input name="Meter03" id="M3" type="checkbox"  value="1"  <?php  //if($Meter03 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter03();"/>&nbsp;Meter 03&nbsp;&nbsp;
		<input name="Meter04" id="M4" type="checkbox"  value="1"  <?php  //if($Meter04 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter04();"/>&nbsp;Meter 04&nbsp;&nbsp;
		<input name="Meter05" id="M5" type="checkbox"  value="1"  <?php  //if($Meter05 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter05();"/>&nbsp;Meter 05&nbsp;&nbsp;
		
    </td>					
</tr>
 
<!--tr align="left" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:2px;">
			<input name="Phase1_Power" id="Phase1_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_A();" />&nbsp;Phase1_Power&nbsp;&nbsp;
			<input name="Phase2_Power" id="Phase2_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_B();"/>&nbsp;Phase2_Power&nbsp;&nbsp;
			<input name="Phase3_Power" id="Phase3_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_C();"/>&nbsp;Phase3_Power&nbsp;&nbsp;
			</td>
						
 </tr-->
<tr align="left" >
<td>
 <br><br><input type="submit" value=" 提  交 "  id="send-btn" /><br><br>
</td>
</tr>

</table>
</form>