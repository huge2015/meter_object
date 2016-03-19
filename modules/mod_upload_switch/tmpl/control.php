<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_switch
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
  <h3>上传数据开关：</h3>
  <table border="1" width="200px" style="border-bottom:0;">
  <tr align=center>
    <td align=center colspan="3"><b>上传状态：</b></td>
	<td align=center colspan="7">
<?php 
	switch($UploadStatus){
		
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
	<td align=center  colspan="7"><?php echo $Upload_Status_time; ?></td>
  </tr> 	
  </tr>
  </table>
  
  
  <table border="1" width="200px">	
  <tr align=center >
    <?php if($UploadStatus == "close" ){ ?>
    <td colspan="10">
      <form id=start  name="start"  method="post" action="upload-switch" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="start" />
	    <input type="submit" value=" 开&nbsp;&nbsp;启 "  id="start" >
      </form>
    </td>
    <?php } ?>
	
	
	
	<?php if($UploadStatus != "close" ){ ?>
    <td colspan="5">
      <form id=close  name="close"  method="post" action="upload-switch" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="close" />
	    <input type="submit" value=" 关&nbsp;&nbsp;闭 "  id="close" >
      </form>
    </td>
	<?php } ?>
	
   </tr> 
  </table> 


  <table border="0" width="200px">	
  <tr align=center >
    <td colspan="5">
      <form id=close  name="close"  method="post" action="curl-data" target="_blank" onSubmit='return javacheck(this)' style="padding-top:15px;">
        <input id="action_key" name="action_key" type="hidden" size="10" value="start" />
	    <input type="submit" value=" 提交数据 "  id="close" >
      </form>
    </td>
   </tr> 
  </table>    
</div>


</body>	
</html>