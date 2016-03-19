<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_connect
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
	
	

<body>
<div id="electrical">
  <h3>数据采集控制：</h3>
  <table border="1" width="300px" style="border-bottom:0;">
  <tr align=center>
    <td align=center colspan="3"><b>采集状态：</b></td>
	<td align=center colspan="7">
<?php 
	switch($c_status){
		
		case "start":
		  echo "<b><font color=#green >ON</font></b>";
		  break;
					  
		case "stop":
		  echo "<b><font color=#ff0000 >STOP</font></b>";
		  break;
					    
		case "close":
		  echo "<b>OFF</b>";
		  break;
                    
        default:
          break;					
	}
			    
?>
	</td>
  </tr>
  
  
  <tr >
    <td  align=center colspan="3"><b>时&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;间：</b></td>
	<td align=center  colspan="7"><?php echo $c_status_time; ?></td>
  </tr> 	
  </tr>
  </table>
  
  
  <table border="1" width="300px">	
  <tr align=center >
    <?php if($c_status == "close" ){ ?>
    <td colspan="10">
      <form id=start  name="start"  method="post" action="connect-control" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="start" />
	    <input type="submit" value=" 开&nbsp;&nbsp;启 "  id="start" >
      </form>
    </td>
    <?php } ?>
	
	<?php if($c_status == "start" ){ ?>
	<td  colspan="5">
      <form id=stop  name="stop"  method="post" action="connect-control" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="stop" />
	    <input type="submit" value=" 暂&nbsp;&nbsp;停 "  id="stop">
      </form>
	</td>
    <?php } ?>	
	 
    <?php if($c_status == "stop" ){ ?>	 
    <td colspan="5">
      <form id=restart  name="restart"  method="post" action="connect-control" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="restart" />
	    <input type="submit" value=" 恢&nbsp;&nbsp;复 "  id="restart">
      </form>
	</td>  
	<?php } ?>
	
	<?php if($c_status != "close" ){ ?>
    <td colspan="5">
      <form id=close  name="close"  method="post" action="connect-control" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="close" />
	    <input type="submit" value=" 关&nbsp;&nbsp;闭 "  id="close" >
      </form>
    </td>
	<?php } ?>
	
   </tr> 
  </table>   
</div>


</body>	
</html>