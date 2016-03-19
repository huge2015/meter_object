<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_receive
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_curl_receive/css/');

$num_records = JRequest::getVar('num_records', '-1');

echo "num_records is $num_records <br>";

if ($num_records>0) {
	
	//unset($ArrReturn);
	
	for ($n=0; $n<$num_records; $n++){//check record is new
       
		$controller_electrical_id = JRequest::getVar("controller_electrical_id-$n");
		$location_id = JRequest::getVar("location_id-$n");
		$meter_address = JRequest::getVar("meter_address-$n");

		
		//put into  Array  for curl return
		$ArrReturn["num_records"] = $num_records;
        $ArrReturn["queue_id-$n"] = JRequest::getVar("queue_id-$n"); 
		$ArrReturn["controller_electrical_id-$n"] = $controller_electrical_id; 
		$ArrReturn["location_id-$n"] = $location_id; 
		$ArrReturn["meter_address-$n"] = $meter_address;
		$ArrReturn["datetime-$n"] = JRequest::getVar("datetime-$n"); 
		

		if ( ($controller_electrical_id >0) && ($location_id > 0) ) {
			$new = ModCurlReceiveHelper::isDataNew($controller_electrical_id, $location_id, $meter_address);

			if ( $new ) {
				
				//check location_id meter_address from meter_info_srever table
			    $db = JFactory::getDbo();
			    $query = $db->getQuery(true);
			    $query->select( $db->quoteName(array('info_id', 'location_id', 'meter_address') ) );
			     //$query->select('*');   
			    $query->from( $db->quoteName('#__meter_info_server') );
			    $query->where( 
			           	         $db->quoteName('location_id')." = ".$db->quote($location_id) .
                      	         	         " AND `meter_address` = " . $db->quote($meter_address)
			        	);
			    $query->order('info_id DESC');
			    $db->setQuery($query);
			    $db->execute();
			    $num_rows = $db->getNumRows();

			    if ($num_rows == 0) {
			        	date_default_timezone_set('Asia/Singapore');
           	        	        $datetime_create = date('Y-m-d H:i:s');	
			        	$checkmeter = new stdClass();
			        	$checkmeter->location_id = $location_id;
			        	$checkmeter->meter_address = $meter_address;
			        	$checkmeter->datetime_create = $datetime_create;
				        $checkresult = JFactory::getDbo()->insertObject('#__meter_info_server', $checkmeter);
			    }
             
				// Create and populate an object.
				$electrical = new stdClass();
				$electrical->controller_electrical_id = $controller_electrical_id;
				$electrical->location_id = $location_id;
				$electrical->meter_address = $meter_address;
				$electrical->datetime = JRequest::getVar("datetime-$n");
				
				$electrical->total_power = JRequest::getVar("total_power-$n");
				$electrical->energy_kwh = JRequest::getVar("energy_kwh-$n");
				$electrical->phase1_power_factor = JRequest::getVar("phase1_power_factor-$n");
				
				$electrical->phase1_real_power = JRequest::getVar("phase1_real_power-$n");
				$electrical->phase2_real_power = JRequest::getVar("phase2_real_power-$n");
				$electrical->phase3_real_power = JRequest::getVar("phase3_real_power-$n");
				
				
				$electrical->phase1_frequency = JRequest::getVar("phase1_frequency-$n");
				$electrical->phase1_apparent_power = JRequest::getVar("phase1_apparent_power-$n");
				$electrical->phase1_voltage = JRequest::getVar("phase1_voltage-$n");
				$electrical->phase1_current = JRequest::getVar("phase1_current-$n");
				
				//$electrical->phase2_frequency = JRequest::getVar("phase2_frequency-$n");
				$electrical->phase2_apparent_power = JRequest::getVar("phase2_apparent_power-$n");
				$electrical->phase2_voltage = JRequest::getVar("phase2_voltage-$n");
				$electrical->phase2_current = JRequest::getVar("phase2_current-$n");
				
				//$electrical->phase3_frequency = JRequest::getVar("phase3_frequency-$n");
				$electrical->phase3_apparent_power = JRequest::getVar("phase3_apparent_power-$n");
				$electrical->phase3_voltage = JRequest::getVar("phase3_voltage-$n");
				$electrical->phase3_current = JRequest::getVar("phase3_current-$n");
				
				
				$electrical->Uab = JRequest::getVar("Uab-$n");
				$electrical->Ubc = JRequest::getVar("Ubc-$n");
				$electrical->Uca = JRequest::getVar("Uca-$n");
				
				$electrical->Qa = JRequest::getVar("Qa-$n");
				$electrical->Qb = JRequest::getVar("Qb-$n");
				$electrical->Qc = JRequest::getVar("Qc-$n");
				$electrical->Qs = JRequest::getVar("Qs-$n");
				
				$electrical->PFa = JRequest::getVar("PFa-$n");
				$electrical->PFb = JRequest::getVar("PFb-$n");
				$electrical->PFc = JRequest::getVar("PFc-$n");
				$electrical->PFs = JRequest::getVar("PFs-$n");
				
				$electrical->Sa = JRequest::getVar("Sa-$n");
				$electrical->Sb = JRequest::getVar("Sb-$n");
				$electrical->Sc = JRequest::getVar("Sc-$n");
				$electrical->Ss = JRequest::getVar("Ss-$n");
				
				$electrical->WPP = JRequest::getVar("WPP-$n");
				$electrical->WPN = JRequest::getVar("WPN-$n");
				$electrical->WQP = JRequest::getVar("WQP-$n");
				$electrical->WQN = JRequest::getVar("WQN-$n");
				
				$electrical->EPN = JRequest::getVar("EPN-$n");
				$electrical->EQP = JRequest::getVar("EQP-$n");
				$electrical->EQN = JRequest::getVar("EQN-$n");
		
				// Insert the object into the user profile table.
				$result = JFactory::getDbo()->insertObject('joomla3_electrical3', $electrical);
				//$result = JFactory::getDbo()->insertObject('y3u_electrical', $electrical);
				
				
			} //if
		} // if
	}// for
	
	
	
	/*
	  $ip_address = $meter_address = JRequest::getVar("ip_address", "-1");
	  
	  // send data to electrom server
	  $url = "http://". $ip_address ."/joomla/index.php/curl-return";
	  
      $fields_string = '';
      $fields_string = http_build_query($ArrReturn); // $ArrQid is array of queue_id 

      $ch = curl_init(); // open connection

      // set the url, number of POS vars, POST data
      curl_setopt($ch, CURLOPT_URL, $url);//用PHP取回的URL地址。你也可以在用curl_init()函数初始化时设置这个选项
      curl_setopt($ch, CURLOPT_POST, count($ArrReturn)); //做一个正规的HTTP POST，设置这个选项为一个非零值
      curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);  //post 参数 数据
      curl_setopt($ch, CURLOPT_FORBID_REUSE,1); //当进程处理完毕后强制关闭会话，不再缓存供重用
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//设定是否显示头信息,返回字符串，而不是调用curl_exec()后直接输出
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10); // time to connect
      curl_setopt($ch, CURLOPT_TIMEOUT,10); // time for reply

      //$result = curl_exec($ch); // execture post
      $run_curl = curl_exec($ch); // execture post
	  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //返回的http状态码
	  curl_close($ch); // close connection
	*/
	  
}//if ($num_records>0) 


require(JModuleHelper::getLayoutPath('mod_curl_receive', 'default'));
