<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_fix
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
    $sql = "select meter_model_id, meter_model from joomla3_metermodel  order by meter_model_id Asc";
	$rsl = mysql_query($sql);
?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>


<div id="meter_info">
    <br><br>

<form id=form  name="form"  method="post" action="index.php/meter-info-update" onSubmit='return javacheck(this)'>
 <table width="900px" align=left  cellpadding="0" cellspacing="0" style="background-color:#F8F8FF;border-left:none;border-top:none;border-right:none;"> 
  
   <tr><td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 
           <font style="color:#00a0e8">序&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;号：&nbsp;&nbsp&nbsp;&nbsp&nbsp;<?php echo $info_id; ?></font>
		   <input id="info_id" name="info_id" type="hidden" size="10" value="<?php echo $info_id; ?>" />
		   <br><br>
           电表位置码&nbsp;：
        <input id="location_id" name="location_id" type="text" size="10" value="<?php echo $location_id; ?>" /><br>
           电表地址码&nbsp;：
        <input id="meter_address" name="meter_address" type="text" size="10" value="<?php echo $meter_address; ?>" /><br>
	</td></tr >
      
	<tr> <td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 	
           电&nbsp;表&nbsp;型&nbsp;号&nbsp;：
		  <select id="select_model" name="meter_model" > 
		    <option width=50px  value="<?php echo $meter_model; ?>" selected><?php echo $meter_model; ?></option>
		   <?php while($row_sel=mysql_fetch_array($rsl)){ ?>
		    <option width=50px  value="<?php echo $row_sel['meter_model'];?>"><?php echo $row_sel['meter_model'];?></option>
		   <?php } ?>
		  </select>
	</td></tr>	  
	<tr><td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 	  
		   采集参数项&nbsp;：
        <input id="data_select" name="data_select" type="text" size="10" value="<?php echo $data_select; ?>" class="input-xxlarge"/> (空为采集全部)<br>
		  <font style="color:#5d5d5d;"> 
		   * 填写模式、包含采集的参数项为：  Ua, Ub, Uc, U_ab, U_bc, U_ca, Ia, Ib, Ic, Pa, Pb, Pc, Ps, FR, Qa, Qb, Qc, Qs, PFa, PFb, PFc, PFs, Sa, Sb, Sc, Ss, WPP, WPN, WQP, WQN, EPP, EPN, EQP,EQN 
		  </font>
	</td></tr>	  
    <tr><td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 	
	<br>
	    <input type="submit" value=" 提  交 "  id="send-btn"><br><br><br><br>
    </td></tr>
	

 </table>
</form>


<script language=JavaScript1.2>
 
function javacheck(formct)
{
	
      
        
        if (formct.meter_model.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写电表型号！');
                 formct.meter_model.focus();
		return false; 
	} 

    
       
}

</script>
          
   
</div>
