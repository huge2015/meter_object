<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_excute
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
//header("Expires: Thu, 01 Jan 1970 00:00:01 GMT");
//header("Cache-Control: no-cache, must-revalidate");
//header("Pragma: no-cache");
 
 
 
 
/* 
ignore_user_abort ();
set_time_limit (0);
$interval = 3;
$stop = 1;
do {
    if( $stop == 5 ) break;
*/
	
defined('_JEXEC') or die;


// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_upload_excute/css/');

$UploadStatus = ModUploadExcuteHelper::getUploadStatus();

if($UploadStatus == "start"){

  date_default_timezone_set('Asia/Singapore');
  $datetime = date('Y-m-d H:i:s');
  $time = $datetime;
  $server_datetime = date("Y-m-d H:i:s", strtotime("-60 seconds"));

  // number of records to Upload
  $limit = ModUploadExcuteHelper::getRecordNum();
  echo "limit : $limit <br>"; 
  if($limit == ""){$limit = 5;}
  
  $LQId = JRequest::getVar('LQId', '-1');
   echo "<br>LQId : $LQId <br><br>";
  
  //get last post data_post for update table varitely
  $data_pos = JRequest::getVar('data_pos', '-1');
  $time_pos = JRequest::getVar('time_pos', '-1');
  echo "Get data_pos : $data_pos <br>";
  echo "Get time_pos : $time_pos <br>";
  
    if(($data_pos != "-1")&&($time_pos != "-1")){
	    ModUploadExcuteHelper::setDataPos($data_pos);
        ModUploadExcuteHelper::setTimePos($time_pos);
        //ModUploadExcuteHelper::setTryTime();
	  
    }
  
 
   /*
    if($LQId != "-1"){
	    ModUploadExcuteHelper::delQueueData($LQId, $limit); //delete last time post records
    }
   */

 $n = 0;
  unset ($_POST_data);

  unset($queue_data);
  $queue_data = ModUploadExcuteHelper::getQueueData($limit);

  $data_size = count($queue_data);
  //echo "size of data is $data_size <br>";
  
 

 if($data_size == 0){ //while queue table is null then upload the electrical table's records order by Asc
	 
	$data_pos = ModUploadExcuteHelper::getDataPos();
	$time_pos = ModUploadExcuteHelper::getTimePos();

	$try_time = ModUploadExcuteHelper::getTryTime();
	//echo "<br>try_time : $try_time";

	unset($electrical_data);
	$electrical_data = ModUploadExcuteHelper::getDataRaw($server_datetime, $data_pos, $time_pos, $limit);
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
	 
	$data_pos = $_POST_data["controller_electrical_id-$Qn"];
	echo "data_pos : $data_pos <br>";
	
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
    $electrical_rows = ModUploadExcuteHelper::getElectricalData($electrical_id, $location_id, $meter_address, $datetime);
	
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
	
    $J_post = json_encode($_POST_data);
	
	
// make js script run by php echo----------------------------
echo "
<script src='//code.jquery.com/jquery-1.12.0.min.js'></script>
<!--script src='//code.jquery.com/jquery-migrate-1.2.1.min.js'></script-->
<script type='text/javascript'>

function uploaddata(){
	   
       var post = ". $J_post .";
	   var LQId = ". $queue_id .";
	   var data_pos = ". $data_pos .";
	   var time_pos = ".$time_pos .";
	   
		jQuery.ajax({
			//type : 'get',
            //async : false,
			cache:false,
			//crossdomain: true,
			//url: 'index.php',
			//url: 'http://192.168.0.201/joomla/index.php',
			url: 'http://www.electromonitor.com/monitor/index.php',
			
			dataType:'jsonp',  //return type  
			jsonp: 'callbackparam',    //send / revice param default is 'callback'
            jsonpCallback:'jsonpCallback',
            timeout:5000,
			data: {'option':'com_ajax', 'module':'uploaddata', 'method':'getUploadData','format':'jsonp', 
			       'allarr' : post,
		           'num_records' : ". $limit .",
		           'fields' : ". $fields ."
		    },
            success: function(data, status, XMLHttpRequest){
				//alert(JSON.stringify(XMLHttpRequest));"
				//. ModUploadExcuteHelper::delQueueData($_POST_data, $limit)
				."
				 
				
				//alert('Success!  Messages :'+JSON.stringify(XMLHttpRequest));
				
				//location.href='index.php/upload-excute?LQId='+LQId+'&data_pos='+data_pos+'&time_pos='+time_pos;;
             
             },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				         //result = JSON.stringify(XMLHttpRequest);
						 callText = XMLHttpRequest.statusText;
				       //alert('XMLHttpRequest : '+returnText);
						//alert('XMLHttpRequest : '+callText);
                        //alert('status : '+XMLHttpRequest.status);
                        //alert('readyState : '+ XMLHttpRequest.readyState);
                        //alert('textStatus : '+textStatus);
						//alert('errorThrown : '+XMLHttpRequest.errorThrown);
						
						if(callText == 'success'){
							alert('error -> Success!  Messages :'+callText);
							//location.href='index.php/updata-pos?data_pos='+data_pos+'&time_pos='+time_pos;
						}else{
							alert('Error! Messages : '+callText);
							//location.href='index.php/updata-error?&try_time=<?php echo $try_time;?>&error_msg='+callText;
						}
            },
            complete: function(XMLHttpRequest, textStatus) {
                         // call this time AJAX request options params
            }
        });
}			


uploaddata()  //Run Ajax functon uploadata()

</script>";



//require(JModuleHelper::getLayoutPath('mod_upload_excute', 'default'));


    //$lines = file("http://localhost/joomla/index.php/upload-excute");
	//$lines = file("http://127.0.0.1/joomla/index.php/upload-excute");
	 //sleep(3);
	 
	//$lines = file_get_contents("http://localhost/joomla/index.php/upload-excute"); 
	//$lines = file_get_contents("http://localhost/joomla/index.php/upload-excute", false, null); 
    //$lines = file_get_contents("http://127.0.0.1/joomla/index.php/upload-excute", false, null);
    //$lines = file_get_contents("http://127.0.0.1/joomla/index.php/upload-excute", false, null, 0 , 50);

	/*
	$opts = array(   
        'http'=>array(   
        'method'=>"GET",   
        'timeout'=>2,//单位秒  
        )   
    );   
    
	//$lines = file_get_contents("http://localhost/joomla/index.php/upload-excute", 1, stream_context_create($opts)); 	
    $lines = file_get_contents("http://127.0.0.1/joomla/index.php/upload-excute", 0, stream_context_create($opts)); 	
   */ 


  //$lines = fopen("http://127.0.0.1/joomla/index.php/upload-excute","rb"); 


}else{
	echo "<br><br><br><br><H1>请先开启上传数据开关！</H1><br><br><br><br>";
}//if($UploadStatus == "1")
	

/*
    $stop++;
    sleep ( $interval );
} while ( true );
*/
?>