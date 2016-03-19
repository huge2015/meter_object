<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_control
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_upload_control/css/');

$start_time = trim(JRequest::getVar('start_time', '-1'));
$end_time = trim(JRequest::getVar('end_time', '-1'));

if(($start_time == "-1")&&($end_time == "-1")){

   date_default_timezone_set('Asia/Singapore');
   $end_time = date('Y-m-d H:i:s');
   $start_time = date("Y-m-d H:i:s", strtotime("-60 seconds"));
	
}else{
	
}

$limit = 5; // number of records to retrieve


unset($electrical_data);
$electrical_data = ModUploadControlHelper::getElectricalData($start_time, $end_time);
$data_size = count($electrical_data);
 echo "size of data is $data_size <br>";

// set up _POST array of key value pairs
$data_rows = $electrical_data;


$num_records = $limit;
//$fields = 16;
foreach ($data_rows AS $data) {
   
  $electrical_id = $data['electrical_id'];
  $location_id = $data['location_id'];
  $meter_address = $data['meter_address'];
  $datetime = $data['datetime'];
  
  ModUploadControlHelper::insertQueueId($electrical_id, $location_id, $meter_address, $datetime);
}
 
 
    $data_pos = $data['electrical_id'];
    $time_pos = $data['datetime'];


?>
<div id="setTimejump" algin=center></div>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<!--script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script-->
<script type="text/javascript">

function uploaddata(){
	//alert(" inside getpushdata");
	   '<?php echo $peek = queue_peek($myqueue); //Front element of the queue ?>'
	   
       var post = '<?php echo json_encode($peek);?>';
	   var size = '<?php echo queue_size($myqueue);?>';
	   alert('上传数据！Now queue size : '+ size);
	   //alert('上传数据！Now post : '+ post);
	    if (post == ""){
		   alert('上传数据完成！');
		   return false;//跳出循环
		}
	   var data_pos = '<?php echo $data_pos ;?> ';
	   var time_pos = '<?php echo $time_pos ;?> ';
	   
		jQuery.ajax({
			//type : "get",
            //async : false,
			//cache:false,
			//crossdomain: true,
			url: "index.php",
			//url: "http://www.electromonitor.com/monitor/index.php",
			
			//dataType:'jsonp',  //return type  
			jsonp: "callbackparam",    //send / revice param default is "callback"
            jsonpCallback:"jsonpCallback",
            timeout:5000,
			data: {"option":"com_ajax", "module":"uploaddata", "method":"getUploadData","format":"jsonp", 
			       "allarr" : post,
		           "num_records" : "<?php echo $limit;?>",
		           "fields" : "<?php echo $fields;?>"
		    },
            success: function(){
				//alert('Success!');
				//location.href="index.php/upload-set?data_pos="+data_pos+"&time_pos="+time_pos;
				
				'<?php 
				    echo queue_dequeue($myqueue); // Removed the element at the front of the queue		
				?>'
				var size2 = '<?php echo queue_size($myqueue);?>';
				alert('上传数据:'+ size2);
				//uploaddata()  //Run Ajax functon uploadata()
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
						
						if(callText == "success"){
							//alert('Success!');
							location.href="index.php/upload-set?data_pos="+data_pos+"&time_pos="+time_pos;
							'<?php 
				                queue_dequeue($myqueue); // Removed the element at the front of the queue
				            ?>'
							//uploaddata()  //Run Ajax functon uploadata()
						}else{
							'<?php 
				                 queue_rotate($myqueue);  //rotate the queue put the font element to the last
				            ?>'
							alert(callText);
							uploaddata()  //Run Ajax functon uploadata()
							//location.href="index.php/upload-set?&try_time=<?php echo $try_time;?>&error_msg="+callText;
						}
            },
            complete: function(XMLHttpRequest, textStatus) {
                         // call this time AJAX request options params
            }
        });
}			

//uploaddata()  //Run Ajax functon uploadata()

</script>

<?php 

require(JModuleHelper::getLayoutPath('mod_upload_control', 'default'));
//sleep(5);







// A library to implement queues in PHP via arrays  
// The Initialize function creates a new queue:  
function queue_initialize() {  
    // In this case, just return a new array  
    $new = array();  
    return $new;  
}  
// The destroy function will get rid of a queue  
function queue_destroy(&$queue) {  
    // Since PHP is nice to us, we can just use unset  
    unset($queue);  
}  
// The enqueue operation adds a new value unto the back of the queue  
function queue_enqueue(&$queue, $value) {  
    // We are just adding a value to the end of the array, so can use the  
    //  [] PHP Shortcut for this.  It's faster than using array_push  
    $queue[] = $value;  
}  
// Dequeue removes the front of the queue and returns it to you  
function queue_dequeue(&$queue) {  
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
function queue_size(&$queue) {  
    // Just using count will give the proper number:  
    return count($queue);  
}  
// Rotate takes the item on the front and sends it to the back of the queue.  
function queue_rotate(&$queue) {  
    // Remove the first item and insert it at the rear.  
    $queue[] = array_shift($queue);  
}  

?>