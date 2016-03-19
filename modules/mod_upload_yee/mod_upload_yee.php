<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_yee
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

header('Content-type: text/html; charset=utf8');
defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

JHTML::stylesheet('styles.css','modules/mod_dianbiao_submit/css/');


date_default_timezone_set('Asia/Singapore');
$datetime = date('Y-m-d H:i:s');
$time = $datetime;
$server_datetime = date("Y-m-d H:i:s", strtotime("-60 seconds"));

$limit = 1; // number of records to retrieve


$data_pos = ModDianBiaoSubmitHelper::getDataPos();
if($data_pos == ""){$data_pos = 0;}

$time_pos = ModDianBiaoSubmitHelper::getTimePos();
$time_pos = date("Y-m-d H:i:s", strtotime($time_pos));

//$controller_electrical_id = $data_pos;
//$datatime = $time_pos;

$try_time = ModDianBiaoSubmitHelper::getTryTime();
//echo "<br>try_time : $try_time";


unset($electrical_data);
$electrical_data = ModDianBiaoSubmitHelper::getElectricalData($server_datetime, $data_pos, $time_pos, $limit);
$size = count($electrical_data);
// echo "size of data is $size";


// set up _POST array of key value pairs
$data_rows = $electrical_data;

$n = 0;
unset ($_POST);
//$_POST["num_records"] = $limit;
$num_records = $limit;
//$fields = 16;
foreach ($data_rows AS $data) {
  $datetime  = $data['datetime'];
  $phase1_voltage  = $data['phase1_voltage'];
  $n++;
   //echo "n= $n ...";
   echo "datetime : $datetime <br>";
   echo "phase1_voltage : $phase1_voltage <br>";

} //foreach

  $fields = sizeof($_POST)/$n;
  //echo "<br>fields : $fields ";
  
  /*
  $json_post = json_encode($_POST);
  $arr_len = strlen($json_post);
  $allarr = substr($json_post , 1, $arr_len-2);
  $data_index = str_replace('"' , '', $allarr);
  echo  $data_index ;
  */
//echo "fields_string: $fields_string" ;

    $data_pos = $data['electrical_id'];
    $time_pos = $data['datetime'];
/*
// send data to electrom server
//$url = 'http://api.yeelink.net/v1.0/device/345161/sensor/384054/datapoints';	
	
	
	
// var_dump($_POST);
$fields_string = '';
$fields_string = http_build_query($_POST); // $_POST is array of key value pairs

$ch = curl_init(); // open connection

// set the url, number of POS vars, POST data
curl_setopt($ch, CURLOPT_URL, $url);//用PHP取回的URL地址。你也可以在用curl_init()函数初始化时设置这个选项
curl_setopt($ch, CURLOPT_POST, count($_POST)); //做一个正规的HTTP POST，设置这个选项为一个非零值
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);  //post 参数 数据
curl_setopt($ch, CURLOPT_FORBID_REUSE,1); //当进程处理完毕后强制关闭会话，不再缓存供重用
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//设定是否显示头信息,返回字符串，而不是调用curl_exec()后直接输出

curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10); // time to connect
curl_setopt($ch, CURLOPT_TIMEOUT,30); // time for reply


//$result = curl_exec($ch); // execture post
curl_exec($ch); // execture post

curl_close($ch); // close connection

} // for k	
	
*/	
	

?>
<div id="setTimejump" algin=center></div>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<!--script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script-->
<script type="text/javascript">



function uploaddata(){
	//alert(" inside getpushdata");
	   var datetime = '<?php echo $datetime;?>';
       var phase1_voltage = '<?php $phase1_voltage;?>';
	   var data_pos = '<?php echo $data_pos ;?> ';
	   var time_pos = '<?php echo $time_pos ;?> ';
	   
	   
	   
		jQuery.ajax({
			//type : "get",
            //async : false,
			//cache:false,
			//crossdomain: true,
			//url: "index.php",
			//url: "http://www.electromonitor.com/monitor/index.php",
			url: 'http://api.yeelink.net/v1.0/device/345161/sensor/384054/datapoints',
			
			dataType:'jsonp',  //return type  
			jsonp: "callbackparam",    //send / revice param default is "callback"
            jsonpCallback:"jsonpCallback",
            timeout:5000,
			data: {
                   "timestamp" : datetime,
                    "value" : phase1_voltage
            },
			
			beforeSend: function(request) {
                        request.setRequestHeader("U-ApiKey", "ff8043f023a8d5d9f4e088a5223e3845");
                    },
            success: function(){
				//alert('Success!');
				location.href="index.php/updata-pos?data_pos="+data_pos+"&time_pos="+time_pos;
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
							location.href="index.php/updata-pos?data_pos="+data_pos+"&time_pos="+time_pos;
						}else{
							location.href="index.php/updata-error?&try_time=<?php echo $try_time;?>&error_msg="+callText;
						}
            },
            complete: function(XMLHttpRequest, textStatus) {
                         // call this time AJAX request options params
            }
        });
		
		
		/*
		jQuery.ajax({
		//提交数据的类型 POST GET
            type:"POST",
            //提交的网址
            url:"http://api.yeelink.net/v1.0/device/345161/sensor/384054/datapoints",
            //提交的数据
            data:{  "timestamp" : datetime,
                    "value" : phase1_voltage
            },
            //返回数据的格式
            datatype:  "json", 
            //在请求之前调用的函数
            beforeSend:function(){$("#msg").html("logining");},
            //成功返回之后调用的函数             
           success: function(){
				//alert('Success!');
				location.href="index.php/updata-pos?data_pos="+data_pos+"&time_pos="+time_pos;
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
							location.href="index.php/updata-pos?data_pos="+data_pos+"&time_pos="+time_pos;
						}else{
							location.href="index.php/updata-error?&try_time=<?php echo $try_time;?>&error_msg="+callText;
						}
            },
            complete: function(XMLHttpRequest, textStatus) {
                         // call this time AJAX request options params
            }  
         
         });
        */

			
}			



/*
function uploaddata(){
	//alert(" inside getpushdata");
	   
       var post = '<?php echo json_encode($_POST);?>';
	   var data_pos = '<?php echo $data_pos ;?> ';
	   var time_pos = '<?php echo $time_pos ;?> ';
	   
		jQuery.ajax({
			//url: "index.php",
			url: "http://www.electromonitor.com/monitor/index.php",
			
			//async: false,
			data: {"option":"com_ajax", "module":"uploaddata", "method":"getUploadData","format":"json", 
			       "allarr" : post,
		           "num_records" : "<?php echo $limit;?>",
		           "fields" : "<?php echo $fields;?>"
		    }
			 
			
		})
		.done(function (data, status) {

			//alert(" Updata to server succeed! \n Last record controller_electrical_id is : "+data_pos+"\n Last record datetime is : "+time_pos);
			location.href="index.php/updata-pos?data_pos="+data_pos+"&time_pos="+time_pos;
		})
		.fail(function (request, status, error) {
			alert(request.error);
			location.href="index.php/updata-error?&try_time=<?php echo $try_time;?>&error_msg="+request.responseText;
		});
		
	//alert(" end jquery");
}
*/


uploaddata()  //Run Ajax functon uploadata()

</script>

<?php 

//$lines = file("http://localhost/joomla/index.php/submit-data");

require(JModuleHelper::getLayoutPath('mod_upload_yee', 'default'));
//sleep(5);

?>