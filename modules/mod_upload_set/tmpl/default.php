<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_set
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<html>
  <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
  <head>
  </head>
<body>


<br>

<form id=controlform  name="controlform"  method="post" action="upload-control" onSubmit="change_time()">
<table width="700px" align=left  cellpadding="0" cellspacing="0" >
  <tr align=left>
    <td style="padding-left:5px;">
	<?php
 	if($data_pos == "-1"){
		
		//echo "try_time: $try_time <br>";
	    //echo "error_msg: $error_msg <br>";
	}else{
        echo "data_pos: $data_pos <br>";
	    echo "time_pos: $time_pos <br>";
	} 
	?>
    <br><br> 
	</td>
  </tr>
  
  
  
  <tr align=left>
    <td style="padding-left:5px;">
	 请填入需要上传数据的时间段：
    <br><br> 
	</td>
  </tr>
  
  <tr align=left>
    <td style="padding-left:5px;">
	 起始时间：
	<input  id="start_time" name="start_time" type="text" size="10" value="2016-03-02 17:08:58" 
	onkeypress="" 
	onkeyup="change_time()" 
	onblur="change_time()" 
	/>  
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
	</td>
  </tr>
  
	 
	 
  <tr align=left>
    <td style="padding-left:5px;">
	 终止时间：
	 <input  id="end_time" name="end_time" type="text" size="10" value="2016-03-02 17:23:58<?php //echo $now_time;?>" 
	 onkeypress="" 
	onkeyup="change_time()" 
	onblur="change_time()" 
	/> 
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
    </td>
  </tr>
  
  
  
  <tr>
    <td><br><input   type="submit" value=" 提  交 "  id="submit" ><br><br>
	</td>
  </tr>	
</table>
		
</form>
<br><br><br>

<script>
function change_time(){

    var start_time = document.getElementById("start_time");
	var end_time = document.getElementById("end_time");

     if (controlform.end_time.value < controlform.start_time.value ) 
	{
		alert('‘终止时间’不能早于‘起始时间’！');
                 controlform.start_time.focus();
		return false; 
	} 

}

function change_wait(){

    var wait_time = document.getElementById("wait_time");

    if((wait_time.value < 0.5) || (wait_time.value == "")){
		
		alert('最小反应时间为 0.5 秒/次，时间越短取回的数据越容易出错！建议 1.5 秒');
		wait_time.value = 1.5;
		return false; 
    }

}

function form_time(){

    var fresh_time = document.getElementById("fresh_time");

    if((fresh_time.value < 5) || (fresh_time.value == "")){
		
		alert('最小刷新时间为 5 秒/次，将设置时间为 ：5 秒/次！');
		fresh_time.value = 5;
		return false; 
    }
	
	var wait_time = document.getElementById("wait_time");

    if((wait_time.value < 0.5) || (wait_time.value == "")){
		
		alert('最小反应时间为 0.5 秒/次，时间越短取回的数据越容易出错！建议 1.5 秒');
		wait_time.value = 1.5;
		return false; 
    }

}
</script>



