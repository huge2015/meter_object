<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_data
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
ini_set('max_execution_time', '0'); //单位秒，设置为0，那么就是不限制执行的时间。

 
defined('_JEXEC') or die;



// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_curl_data/css/');

$UploadStatus = ModCurlDataHelper::getUploadStatus();

if($UploadStatus == "start"){

  date_default_timezone_set('Asia/Singapore');
  $datetime = date('Y-m-d H:i:s');
  $time = $datetime;
  $server_datetime = date("Y-m-d H:i:s", strtotime("-60 seconds"));

  // number of records to Upload
  $limit = ModCurlDataHelper::getRecordNum();
  echo "limit : $limit <br>"; 
  if($limit == ""){$limit = 5;}

  
  $n = 0;
  unset ($_POST_data);
  $_POST_data["num_records"] = $limit;

  unset($queue_data);
  $queue_data = ModCurlDataHelper::getQueueData($limit);

  $data_size = count($queue_data);
  //echo "size of data is $data_size <br>";
  

 if($data_size == 0){ //while queue table is null then upload the electrical table's records order by Asc
	 
	$data_pos = ModCurlDataHelper::getDataPos();
	$time_pos = ModCurlDataHelper::getTimePos();

	$try_time = ModCurlDataHelper::getTryTime();
	//echo "<br>try_time : $try_time";

	unset($electrical_data);
	$electrical_data = ModCurlDataHelper::getDataRaw($server_datetime, $data_pos, $time_pos, $limit);
	$size = count($electrical_data);
	// echo "size of data is $size";

	// set up _POST_data array of key value pairs
	$data_rows = $electrical_data;

	foreach ($data_rows AS $data) {

  	    $_POST_data["controller_electrical_id-$n"]  = $data['electrical_id'];
  	    $_POST_data["location_id-$n"]  = $data['location_id'];
  	    $_POST_data["meter_address-$n"]  = $data['meter_address'];
  	    $_POST_data["datetime-$n"]  = $data['datetime'];
  
  	 
 	    $_POST_data["total_power-$n"]  = $data['total_power'];
 	    $_POST_data["energy_kwh-$n"]  = $data['energy_kwh'];
 	    $_POST_data["phase1_power_factor-$n"]  = $data['power_factor'];
 	  
 	    $_POST_data["phase1_real_power-$n"]  = $data['phase1_real_power'];
  	    $_POST_data["phase2_real_power-$n"]  = $data['phase2_real_power'];
  	    $_POST_data["phase3_real_power-$n"]  = $data['phase3_real_power'];
   
   
        $_POST_data["phase1_voltage-$n"]  = $data['phase1_voltage'];
        $_POST_data["phase1_current-$n"]  = $data['phase1_current'];
        $_POST_data["phase1_apparent_power-$n"]  = $data['phase1_apparent_power'];
        $_POST_data["phase1_frequency-$n"]  = $data['phase1_frequency'];
  
        $_POST_data["phase2_voltage-$n"]  = $data['phase2_voltage'];
        $_POST_data["phase2_current-$n"]  = $data['phase2_current'];
        $_POST_data["phase2_apparent_power-$n"]  = $data['phase2_apparent_power'];
        $_POST_data["phase2_frequency-$n"]  = $data['phase2_frequency'];
  
        $_POST_data["phase3_voltage-$n"]  = $data['phase3_voltage'];
        $_POST_data["phase3_current-$n"]  = $data['phase3_current'];
        $_POST_data["phase3_apparent_power-$n"]  = $data['phase3_apparent_power'];
        $_POST_data["phase3_frequency-$n"]  = $data['phase3_frequency'];
  
  
        $_POST_data["Uab-$n"]  = $data['Uab'];
        $_POST_data["Ubc-$n"]  = $data['Ubc'];
        $_POST_data["Uca-$n"]  = $data['Uca'];
  
        $_POST_data["Qa-$n"]  = $data['Qa'];
        $_POST_data["Qb-$n"]  = $data['Qb'];
        $_POST_data["Qc-$n"]  = $data['Qc'];
        $_POST_data["Qs-$n"]  = $data['Qs'];
  
        $_POST_data["PFa-$n"]  = $data['PFa'];
        $_POST_data["PFb-$n"]  = $data['PFb'];
        $_POST_data["PFc-$n"]  = $data['PFc'];
        $_POST_data["PFs-$n"]  = $data['PFs'];
  
        $_POST_data["Sa-$n"]  = $data['Sa'];
        $_POST_data["Sb-$n"]  = $data['Sb'];
        $_POST_data["Sc-$n"]  = $data['Sc'];
        $_POST_data["Ss-$n"]  = $data['Ss'];
  
        $_POST_data["WPP-$n"]  = $data['WPP'];
        $_POST_data["WPN-$n"]  = $data['WPN'];
        $_POST_data["WQP-$n"]  = $data['WQP'];
        $_POST_data["WQN-$n"]  = $data['WQN'];
  
        $_POST_data["EPN-$n"]  = $data['EPN'];
        $_POST_data["EQP-$n"]  = $data['EQP'];
        $_POST_data["EQN-$n"]  = $data['EQN'];
  
  
      $n++;
    }//foreach ($data_rows AS $data)
	
	 
	$Qn = $n - 1; //For the last Array Element number
    echo "<br>Qn : $Qn <br><br> ";
	 
	$data_pos = "";
	$data_pos = $_POST_data["controller_electrical_id-$Qn"];
	echo "data_pos : $data_pos <br>";
	
	$time_pos = "";
	$time_pos = $_POST_data["datetime-$Qn"];
	echo "time_pos : $time_pos <br>";
	
}else{
	
   // set up _POST_data array of key value pairs
  $queue_rows = $queue_data;

	
  foreach ($queue_rows AS $data) {

    $electrical_id = $data['electrical_id'];
    $location_id = $data['location_id'];
    $meter_address = $data['meter_address'];
    $datetime = $data['datetime'];
	//echo "<br> $electrical_id + $location_id + $meter_address + $datetime";

	unset($electrical_data);
    $electrical_rows = ModCurlDataHelper::getElectricalData($electrical_id, $location_id, $meter_address, $datetime);
	
    if($electrical_rows != ""){
		
        foreach($electrical_rows AS $electrical_data){
        
		    $_POST_data["queue_id-$n"]  = $data['queue_id']; //for delete queue data while upload successed
		
		    //echo "<br>electrical_data = $electrical_data[electrical_id] ";
		
            $_POST_data["controller_electrical_id-$n"]  = $electrical_data['electrical_id'];
            $_POST_data["location_id-$n"]  = $electrical_data['location_id'];
            $_POST_data["meter_address-$n"]  = $electrical_data['meter_address'];
            $_POST_data["datetime-$n"]  = $electrical_data['datetime'];  
   
             $_POST_data["total_power-$n"]  = $electrical_data['total_power'];
             $_POST_data["energy_kwh-$n"]  = $electrical_data['energy_kwh'];
             $_POST_data["phase1_power_factor-$n"]  = $electrical_data['power_factor'];
       
             $_POST_data["phase1_real_power-$n"]  = $electrical_data['phase1_real_power'];
             $_POST_data["phase2_real_power-$n"]  = $electrical_data['phase2_real_power'];
             $_POST_data["phase3_real_power-$n"]  = $electrical_data['phase3_real_power'];
             
            $_POST_data["phase1_voltage-$n"]  = $electrical_data['phase1_voltage'];
            $_POST_data["phase1_current-$n"]  = $electrical_data['phase1_current'];
            $_POST_data["phase1_apparent_power-$n"]  = $electrical_data['phase1_apparent_power'];
            $_POST_data["phase1_frequency-$n"]  = $electrical_data['phase1_frequency'];
      
            $_POST_data["phase2_voltage-$n"]  = $electrical_data['phase2_voltage'];
            $_POST_data["phase2_current-$n"]  = $electrical_data['phase2_current'];
            $_POST_data["phase2_apparent_power-$n"]  = $electrical_data['phase2_apparent_power'];
            $_POST_data["phase2_frequency-$n"]  = $electrical_data['phase2_frequency'];
  
            $_POST_data["phase3_voltage-$n"]  = $electrical_data['phase3_voltage'];
            $_POST_data["phase3_current-$n"]  = $electrical_data['phase3_current'];
            $_POST_data["phase3_apparent_power-$n"]  = $electrical_data['phase3_apparent_power'];
            $_POST_data["phase3_frequency-$n"]  = $electrical_data['phase3_frequency'];
       
            $_POST_data["Uab-$n"]  = $electrical_data['Uab'];
            $_POST_data["Ubc-$n"]  = $electrical_data['Ubc'];
            $_POST_data["Uca-$n"]  = $electrical_data['Uca'];
  
            $_POST_data["Qa-$n"]  = $electrical_data['Qa'];
            $_POST_data["Qb-$n"]  = $electrical_data['Qb'];
            $_POST_data["Qc-$n"]  = $electrical_data['Qc'];
            $_POST_data["Qs-$n"]  = $electrical_data['Qs'];
  
            $_POST_data["PFa-$n"]  = $electrical_data['PFa'];
            $_POST_data["PFb-$n"]  = $electrical_data['PFb'];
            $_POST_data["PFc-$n"]  = $electrical_data['PFc'];
            $_POST_data["PFs-$n"]  = $electrical_data['PFs'];
  
            $_POST_data["Sa-$n"]  = $electrical_data['Sa'];
            $_POST_data["Sb-$n"]  = $electrical_data['Sb'];
            $_POST_data["Sc-$n"]  = $electrical_data['Sc'];
            $_POST_data["Ss-$n"]  = $electrical_data['Ss'];
  
            $_POST_data["WPP-$n"]  = $electrical_data['WPP'];
            $_POST_data["WPN-$n"]  = $electrical_data['WPN'];
            $_POST_data["WQP-$n"]  = $electrical_data['WQP'];
            $_POST_data["WQN-$n"]  = $electrical_data['WQN'];
  
            $_POST_data["EPN-$n"]  = $electrical_data['EPN'];
            $_POST_data["EQP-$n"]  = $electrical_data['EQP'];
            $_POST_data["EQN-$n"]  = $electrical_data['EQN'];
		
        }//foreach($electrical_rows AS $electrical_data)
		
	}else{echo "electrical_data == null ";}//if($electrical_rows != "")
    
	
    $n++;
  }//foreach ($queue_rows AS $data)
  
   $Qn = $data_size - 1; //For the last Array Element number
   $queue_id = $_POST_data["queue_id-$Qn"] ; //the last $queue_id
   echo "<br> queue_id : $queue_id <br>";

}//if($data_size == 0)

    

  @$fields = sizeof($_POST_data)/$n;
  
  //$ip_address = "127.0.0.1";
  //$ip_address = "192.168.0.201";
  //$ip_address = "219.135.114.154:7070";
  //$ip_address = '118.201.43.78:8080';
  //$_POST_data['ip_address'] = $ip_address;
  
  // send data to electrom server
  //$url = 'http://www.electromonitor.com/monitor/index.php/curl-receive';
  //$url = 'http://138.128.170.245/monitor/index.php/curl-receive';
  $url = "http://127.0.0.1/joomla/index.php/curl-receive";
  //$url = "http://192.168.0.107/joomla/index.php/curl-receive";


  $fields_string = '';
  $fields_string = http_build_query($_POST_data); // $_POST_data is array of key value pairs

  $ch = curl_init(); // open connection

  // set the url, number of POS vars, POST data
  curl_setopt($ch, CURLOPT_URL, $url);//用PHP取回的URL地址。你也可以在用curl_init()函数初始化时设置这个选项
  curl_setopt($ch, CURLOPT_POST, count($_POST_data)); //做一个正规的HTTP POST，设置这个选项为一个非零值
  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);  //post 参数 数据
  curl_setopt($ch, CURLOPT_FORBID_REUSE,1); //当进程处理完毕后强制关闭会话，不再缓存供重用
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//设定是否显示头信息,返回字符串，而不是调用curl_exec()后直接输出
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10); // time to connect
  curl_setopt($ch, CURLOPT_TIMEOUT,30); // time for reply

  //$result = curl_exec($ch); // execture post
  $run_curl = curl_exec($ch); // execture post
  $res = curl_getinfo($ch);
  $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  echo "<br>statusCode : $statusCode";
  $CURLINFO_EFFECTIVE_URL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
  $connect_time = curl_getinfo($ch, CURLINFO_CONNECT_TIME );
  $CURLINFO_CONTENT_LENGTH_UPLOAD  = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_UPLOAD);
  $CURLINFO_SIZE_UPLOAD  = curl_getinfo($ch, CURLINFO_SIZE_UPLOAD);
  $CURLINFO_CONTENT_TYPE  = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
  
  echo "<br>CURLINFO_CONTENT_LENGTH_UPLOAD  : $CURLINFO_CONTENT_LENGTH_UPLOAD ";
  echo "<br>connect_time : $connect_time";
  echo "<br>CURLINFO_EFFECTIVE_URL : $CURLINFO_EFFECTIVE_URL";
  echo "<br>CURLINFO_SIZE_UPLOAD : $CURLINFO_SIZE_UPLOAD";
  echo "<br>CURLINFO_CONTENT_TYPE : $CURLINFO_CONTENT_TYPE";
  
  //var_dump($res);
    if($statusCode == 200){
	    if($queue_id !=""){
			ModCurlDataHelper::delQueueData($_POST_data, $limit);
		}else{
			ModCurlDataHelper::setDataPos($data_pos);
            ModCurlDataHelper::setTimePos($time_pos);
		}  
    }
  
  curl_close($ch); // close connection

  
  sleep(1);
  $lines = file("http://127.0.0.1/joomla/index.php/curl-data");

require(JModuleHelper::getLayoutPath('mod_curl_data', 'default'));


}else{
	echo "<br><br><br><br><H1>请先开启上传数据开关！</H1><br><br><br><br>";
}//if($UploadStatus == "1")
?>