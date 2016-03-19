<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_connect
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;


?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
	
	
<!--form id=go  name="go"  method="post" action="meter-info" onSubmit='return javacheck(this)'>
    <input id="location_id" name="location_id" type="hidden" size="10" value="<?php echo $location_id; ?>" />
	<input id="meter_address" name="meter_address" type="hidden" size="10" value="<?php echo $meter_address; ?>" />
	    <input type="submit" value=" 退出采集 "  id="stop">
</form-->
<div id="electrical">
    <h3>位置 [ <?php echo $location_id; ?> ] &nbsp;&nbsp; 电表 [ <?php echo $meter_address; ?> ] </h3>

          <table border="1" >
            <tr >
              <td>行动</td>         
             
			  
			    <?php if($switch == "0"){?><?php //echo $location_id.$meter_address.$switch; ?>
     			<form id=goswitch  name="goswitch"  method="post" action="index.php/meter-switch" >
        			<input id="location_id" name="location_id" type="hidden" size="10" value="<?php echo $location_id; ?>" />
					<input id="meter_address" name="meter_address" type="hidden" size="10" value="<?php echo $meter_address; ?>" />
					<input id="switch" name="switch" type="hidden" size="10" value="<?php echo $switch; ?>" />
					<input id="key" name="key" type="hidden" size="10" value="connect" />
					 <td colspan="6" style="padding-left:20px;height:30px;">
	    			<input type="submit" value=" 开启采集 "  id="get_data" title="start get data status">
					</td>
      			</form>
   			     <?php }else{?><?php //echo $location_id.$meter_address.$switch; ?>
	  			 <form id=goswitch  name="goswitch"  method="post" action="index.php/meter-switch" >
        			<input id="location_id" name="location_id" type="hidden" size="10" value="<?php echo $location_id; ?>" />
					<input id="meter_address" name="meter_address" type="hidden" size="10" value="<?php echo $meter_address; ?>" />
				  	<input id="switch" name="switch" type="hidden" size="10" value="<?php echo $switch; ?>" />
					<input id="key" name="key" type="hidden" size="10" value="connect" />
					<td colspan="6" style="padding-left:20px;height:30px;">
	  			    <input type="submit" value=" 停止采集 "  id="get_data" title="stop get data status">
					</td>
    			 </form>
				 <?php }?>
			  
               <td align=center colspan="4" >状态:
			   <?php if($switch=="0"){echo "<b>OFF</b>";}else{echo "<B><font color=#green >ON</font></b>";}?>
			   </td>			   
            </tr>
            <tr align=center>
              <td>时间</td>  
              <td colspan="8" align="left"><?php if($error_status == "1"){echo "<font color=#FF0000>$time</font>";}else{echo $time;} ?></td>
            </tr>
            <tr align=center>
              <td>电压1</td>  
              <td><?php echo $voltage1; ?></td>
              <td>V</td>
			  <td>电压2</td>  
              <td><?php echo $voltage2; ?></td>
              <td>V</td>
			  <td>电压3</td>  
              <td><?php echo $voltage3; ?></td>
              <td>V</td>
            </tr>
            <tr align=center>
              <td>电流1</td>
              <td><?php echo $current1; ?></td>
              <td>A</td>
			  <td>电流2</td>
              <td><?php echo $current2; ?></td>
              <td>A</td>
			  <td>电流3</td>
              <td><?php echo $current3; ?></td>
              <td>A</td>
            </tr>
            <tr align=center>
              <td>功率1</td>
              <td><?php echo $power1; ?></td>
              <td>W</td>
			  <td>功率2</td>
              <td><?php echo $power2; ?></td>
              <td>W</td>
			  <td>功率3</td>
              <td><?php echo $power3; ?></td>
              <td>W</td>
            </tr>
            <tr align=center>
              <td>频率</td>
              <td><?php echo $frequency1; ?></td>
              <td>Hz</td>
			  <td>总功率</td>
              <td><?php echo $Ps; ?></td>
              <td>W</td>
			  <td>电能</td>
              <td><?php echo $EPP; ?></td>
              <td>kWh</td>
            </tr>
           </table>
		   	
</div>

</html>