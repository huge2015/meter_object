<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_connect
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
//error_reporting( E_ALL&~E_NOTICE );
defined('_JEXEC') or die;
//sleep(0.5);
// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';
sleep(0.3);


JHTML::stylesheet('styles.css','modules/mod_meter_connect/css/');

$c_status = ModDianBiaoHelper::connectControl();
date_default_timezone_set('Asia/Singapore');
$c_status_time = date('Y-m-d H:i:s');

require(JModuleHelper::getLayoutPath('mod_meter_connect', 'control'));

//$info_id = JRequest::getVar('info_id', '-1');  //get info_id 
$get_time = JRequest::getVar('fresh_time', '-1');  //get fresh_time

$fresh_time = ModDianBiaoHelper::checkFreshTime($get_time);


//system("gpio")
$getCheckStatus = ModDianBiaoHelper::getCheckStatus();
if($getCheckStatus == ""){
	echo "<h3><font color=#FF2200 >全部电表状态为 ：OFF !  停止采集数据！</font></h3>";	
}
   
  $sql = "select * from joomla3_meter_info  order by info_id Asc";
  $rs = mysql_query($sql);
  while($row_loop=mysql_fetch_array($rs)){
	$info_id = $row_loop['info_id'];
	$location_id = $row_loop['location_id'];
	$meter_address = $row_loop['meter_address'];
	$meter_model = $row_loop['meter_model'];
	$data_select = $row_loop['data_select'];

	
	
	$data_status = ModDianBiaoHelper::getElectricalStatus($location_id, $meter_address);
	
	
	foreach($data_status as $row_status){
		$electrical_status = $row_status['electrical_status'];
		$switch = $electrical_status;  //The $switch For  default.php
	    
		 
	
		//$electrical_status = 1 or 0;
		if($electrical_status == "1"){  //check electrical_status 
  	      
		  $result = ModDianBiaoHelper::getMeterModelValus($meter_model);
	
		  if($result == ""){
		      echo "<script>alert('数据库中还没有此电表型号为：[  $meter_model ]  的记录！请检查！');history.back();</script>";
		  }else{
			
            //check Error Status every time 			
            $error_status = $row_status['error_status'];
		    $error_time = $row_status['error_time'];
			if ($error_status == "1"){
				echo "<br>  <font color=#ff2200>表 [$meter_address] 型号：[".$meter_model."]， 返回数据有误，暂停采集 表 [$meter_address] 数据，请检查！ [ $error_time ]</font>";
				
			}
			
			//get data of ElectricalValues
		    $showValues = ModDianBiaoHelper::getElectricalValues($meter_address);
	
			foreach($showValues as $row){
		        //echo ' id is '.$row['electrical_id'].' meter_address is ' . $row['meter_address'] .'<br/>';
          
        
		        $voltage1 = $row['phase1_voltage'];
		        $current1 = $row['phase1_current'];
		        $power1 = $row['phase1_apparent_power'];
		        $frequency1 = $row['phase1_frequency'];


/*
echo "<br>all_1:";
echo "<br>voltage1 : $voltage1 <br>";
echo " current1 : $current1 <br>";
echo " power1 : $power1 <br>";
echo " frequency1 : $frequency1 <br>";
*/

		        $voltage2 = $row['phase2_voltage'];
		        $current2 = $row['phase2_current'];
		        $power2 = $row['phase2_apparent_power'];
		        $frequency2 = $row['phase2_frequency'];

/*
echo "<br>all_2:";
echo "<br>voltage2 : $voltage2 <br>";
echo " current2 : $current2 <br>";
echo " power2 : $power2 <br>";
echo " frequency2 : $frequency2 <br>";
*/

		        $voltage3 = $row['phase3_voltage'];
		        $current3 = $row['phase3_current'];
		        $power3 = $row['phase3_apparent_power'];
		        $frequency3 = $row['phase3_frequency'];

/*
echo "<br>all_3:";
echo "<br>voltage3 : $voltage3 <br>";
echo " current3 : $current3 <br>";
echo " power3 : $power3 <br>";
echo " frequency3 : $frequency3 <br>";
*/

		        $Ps = $row['total_power'];
		        $EPP = $row['energy_kwh'];
		        $time = $row['datetime'];

//echo "<br>Ps: $Ps";
//echo "<br>Ep+ : $EPP";
 		    }//foreach($showValues as $row){
		  }//else check no meter_model	
		}// if check $electrical_status 
	}//foreach($data_status as $row_status)


require(JModuleHelper::getLayoutPath('mod_meter_connect', 'default'));
    //clear var every time while  done
    $voltage1 = "";
    $current1 = "";
    $power1 = "";
    $frequency1 = "";

    $voltage2 = "";
    $current2 = "";
    $power2 = "";
    $frequency2 = "";

    $voltage3 = "";
    $current3 = "";
    $power3 = "";
    $frequency3 = "";

    $Ps = "";
    $EPP = "";

    $time = "";
  
  }//while meter_info 


//sleep(5);
//$session = ModDianBiaoHelper::getSessionStatus();
//}while($session == "1");

	
// Fresh_page script----------------------------------------------*/	

$fresh_time = $fresh_time * 1000 ;
echo ("<script type=\"text/javascript\">");
echo ("function fresh_page()");    
echo ("{");
echo ("window.location.reload();");
echo ("}"); 
echo ("setTimeout('fresh_page()',".$fresh_time.");");      
echo ("</script>");



?>