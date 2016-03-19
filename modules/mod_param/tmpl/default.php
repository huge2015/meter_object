<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_param
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

<form id=paramform  name="paramform"  method="post" action="param-update" onSubmit='form_time()'>
<table width="700px" align=left  cellpadding="0" cellspacing="0" >
  <tr align=left>
    <td style="padding-left:5px;">
	 设置采集间隔：
	<input class="input-small" id="fresh_time" name="fresh_time" type="text" size="10" value="<?php if(($fresh_time=="")||($fresh_time==0)){echo "5";}else{echo $fresh_time;} ?>" 
    onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" 
	
	maxlength="10" /> 秒/次 
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
	</td>
  </tr>
  
	 
	 
  <tr align=left>
    <td style="padding-left:5px;">
	 电表反应时间：
	 <input class="input-small" id="wait_time" name="wait_time" type="text" size="10" value="<?php if($wait_time==""){echo "1.5";}else{echo $wait_time;} ?>"  
      onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" 

	 onblur="change_wait()" maxlength="10" /> 秒/次 
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
    </td>
  </tr>
  
  <tr align=left>
    <td style="padding-left:5px;">
	 上传记录条数：
	 <input class="input-small" id="record_num" name="record_num" type="text" size="10" value="<?php if($record_num==""){echo "5";}else{echo $record_num;} ?>"  
      onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" 
	  onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" 
	  onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" 

	 onblur="change_record()" maxlength="10" /> 条/次 
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

    var fresh_time = document.getElementById("fresh_time");

    if((fresh_time.value < 5) || (fresh_time.value == "")){
		
		alert('最小刷新时间为 5 秒/次，间隔时间太短取回的数据容易发生错误！');
		fresh_time.value = 5;
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

function change_record(){

    var record_num = document.getElementById("record_num");

    if((record_num.value > 25) || (record_num.value <= 0) || (record_num.value == "")){
		
		alert('每次上传记录数最多为 25 条/次，默认为5条，最少为 1 条！ 将设置为5条。');
		record_num.value = 5;
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
	
	var record_num = document.getElementById("record_num");

    if((record_num.value > 25) || (record_num.value <= 0) || (record_num.value == "")){
		
		alert('每次上传记录数最多为 25 条/次，默认为5条，最少为 1 条！ 将设置为5条。');
		record_num.value = 5;
		return false; 
    }

}
</script>



