<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info
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
<div id="timeClew" algin=center></div>
<div id="timeClew2" algin=center></div>

<div id="electrical" style="padding-top:5px;">
<table width="710px" border="1px"  align=center >

<?php
    @$page = $_GET['page'];
    if($page==""){  
      $notepage=1; 
    }else{ 
      $notepage=$page; 
    } 
    $noterecs=0; 
    $pagesize=10;
	
    
    $sq = "select * from joomla3_meter_info  order by info_id desc";
	$rs = mysql_query($sq);
	$rsnum = mysql_num_rows($rs); 
	 
    $none_data = "<tr align=center><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=#ff000f>数据库中暂时还没有录入数据！</font></a><br><br></td></tr>";
	
	if($rsnum == ""){
		echo $none_data;}
    else{
		$pagecount=ceil($rsnum/$pagesize); 
        mysql_data_seek($rs,($notepage-1)*$pagesize); 	

        if ($notepage == 1){
	      $i=1;
        }else{
	      $i=$notepage*$pagesize-$pagesize+1;
        }
		
?>
 
 <tr align=center >
  <td width=50px ><b>序号</td>
  <td width=50px ><b>位置码</td>
  <td width=100px ><b>表地址</td> 
  <td width=100px ><b>电表型号</td>
  <td width=100px ><b>采集参数项</td>  
  <td width=100px ><b>电表状态</td>
  <td width=100px style="background-color:#F8F8FF;border-left:1px;border-top:1px;border-right:1px;"><b>行动</td>
 </tr>

    <?php		
  
        while(($row=mysql_fetch_array($rs)) && ($noterecs <= ($pagesize - 1))){
		  $info_id = $row['info_id'];
          $location_id = $row['location_id'];
	      $meter_address = $row['meter_address'];
		  $meter_model = $row['meter_model'];
		  $data_select = $row['data_select'];
		  
		  $switch = ModMeterInfoHelper::getMeterStatus($location_id, $meter_address);
    ?> 
 <tr  onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'" style="font-size:12px;color:#000035;">
 
   <td align="center" >
      <a href="index.php/meter-info-fix?info_id=<?php echo $info_id; ?>
	  " title="点击修改：<?php echo $info_id." &nbsp;&nbsp;&nbsp;&nbsp;位置码：".$location_id." &nbsp;&nbsp;&nbsp;&nbsp;电表地址：".$meter_address." &nbsp;&nbsp;&nbsp;&nbsp;电表型号：".$meter_model; ?>">
	  <?php echo $info_id;?>
	  </a>
	  </td>
   <td align="center" ><?php echo $location_id;?></td>
   <td align="center" ><?php echo $meter_address;?></td>
   <td align="center" ><?php echo $meter_model;?></td>
   <td align="center" ><?php echo $data_select;?></td>
   <td align="center" >
     <?php if($switch=="0"){echo "<b>OFF</b>";}else{echo "<B><font color=#green >ON</font></b>";}?>
   </td>
   <td align="center" >
   <?php if($switch == "0"){?>
      <form id=goswitch style="padding-top:15px;" name="goswitch"  method="post" action="index.php/meter-switch" onSubmit='return javacheck(this)'>
        <input id="location_id" name="location_id" type="hidden" size="10" value="<?php echo $location_id; ?>" />
		<input id="meter_address" name="meter_address" type="hidden" size="10" value="<?php echo $meter_address; ?>" />
		<input id="switch" name="switch" type="hidden" size="10" value="<?php echo $switch; ?>" />
		<input id="key" name="key" type="hidden" size="10" value="info" />
	    <input type="submit" value=" ON "  id="get_data" title="start get data status">
      </form>
   <?php }else{?>
	  <form id=goswitch style="padding-top:15px;" name="goswitch"  method="post" action="index.php/meter-switch" onSubmit='return javacheck(this)'>
        <input id="location_id" name="location_id" type="hidden" size="10" value="<?php echo $location_id; ?>" />
		<input id="meter_address" name="meter_address" type="hidden" size="10" value="<?php echo $meter_address; ?>" />
		<input id="switch" name="switch" type="hidden" size="10" value="<?php echo $switch; ?>" />
		<input id="key" name="key" type="hidden" size="10" value="info" />
	    <input type="submit" value=" OFF "  id="get_data" title="stop get data status">
      </form>
	<?php }?>   
	</td>

 </tr>


    <?php  
       
        $noterecs = $noterecs+1; 
        $i = $i+1;
        }//while 
    ?> 
</table>
</div>

<br>

<div id="table2" style="padding-top:5px;">
<table width="700px" align=center  cellpadding="0" cellspacing="0" style="background-color:#F8F8FF;border-left:none;border-top:none;border-right:none;">
  <tr align=left>
    <td width=200px style="padding-left:5px;">
     共 <?php echo $rsnum; ?> 项&nbsp;&nbsp;&nbsp;每页 <?php echo $pagesize; ?> 项&nbsp;&nbsp;&nbsp;&nbsp;页次：<?php echo $notepage; ?>/<?php echo $pagecount; ?>
    </td>
    <td width=500px align=right>  
        <a href="index.php/meter-info?page=1">首页</a>&nbsp;
		<a href="index.php/meter-info?page=
            <?php  if ($notepage>1) 
                    echo $notepage-1; 
                  else
                    echo $notepage; ?>" title=上一页>上一页</a>&nbsp;&nbsp;
            <?php echo $notepage; ?>
        <a href="index.php/meter-info?page=
            <?php if ($notepage==$pagecount) 
                   echo $notepage; 
                 else
                   echo $notepage+1 ;?>" title=下一页>&nbsp;下一页</a>&nbsp;
          
        <select class="input-small" onChange="window.location=this.options[this.selectedIndex].value">
            <?php 
                for($i=1;$i<=$pagecount;$i++) 
                { 
                   if ( $i == $notepage )
	               {
            ?>
            <option width=50px value="index.php/meter-info?page=<?php echo $i; ?>" selected>第<?php echo $i; ?>页</option>&nbsp;
	
            <?php  } else {  ?>

            <option width=50px value="index.php/meter-info?page=<?php echo $i; ?>">第<?php echo $i; ?>页</option>&nbsp;
	        <?php  
			       }
                }
			?>
        </select>

        <a href="index.php/meter-info?page=<?php echo $pagecount; ?>">尾页</a>
        
    </td>
  </tr>
</table>
</div>


    <?php
	}
    ?>
<!--循环体结束-->


<br>

<form id=getform  name="getform"  method="post" action="index.php/meter-connect" onSubmit='form_time()'>
<table width="700px" align=left  cellpadding="0" cellspacing="0" >
  <tr align=left>
    <td width=200px style="padding-left:5px;">
	 设置采集间隔：
	<input class="input-small" id="fresh_time" name="fresh_time" type="text" size="10" value="<?php if(($fresh_time=="")||($fresh_time==0)){echo "5";}else{echo $fresh_time;} ?>" 
    onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" 
	
	maxlength="10" /> 秒/次 
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
	 &nbsp;&nbsp;&nbsp;&nbsp;
	 电表反应时间：
	 <input class="input-small" id="wait_time" name="wait_time" type="text" size="10" value="<?php if($wait_time==""){echo "1.04";}else{echo $wait_time;} ?>"  
      onkeypress="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onkeyup="if(!this.value.match(/^[\+\-]?\d*?\.?\d*?$/))this.value=this.t_value;else this.t_value=this.value;if(this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?)?$/))this.o_value=this.value" onblur="if(!this.value.match(/^(?:[\+\-]?\d+(?:\.\d+)?|\.\d*?)?$/))this.value=this.o_value;else{if(this.value.match(/^\.\d+$/))this.value=0+this.value;if(this.value.match(/^\.$/))this.value=0;this.o_value=this.value}" 

	 onblur="change_wait()" maxlength="10" /> 秒/次 
	<!--"this.value=this.value.replace(/\D/g,'')"  onafterpaste="this.value=this.value.replace(/\D/g,'')" -->
	 &nbsp;&nbsp;&nbsp;&nbsp;
	<input   type="submit" value=" 开始采集数据 "  id="get_data" >
    </td>
	
  </tr>
</table>		
</form>
<br><br><br>

<?php
    $sql = "select meter_model_id, meter_model from joomla3_metermodel  order by meter_model_id Asc";
	$rsl = mysql_query($sql);
?>
<br><br>
<form id=form  name="form"  method="post" action="index.php/meter-info-submit" onSubmit='return javacheck(this)'>
 <table width="900px" align=left  cellpadding="0" cellspacing="0" style="background-color:#F8F8FF;border-left:none;border-top:none;border-right:none;"> 
<h4>&nbsp;增加电表信息：</h4>
   <tr><td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 
           电表位置码&nbsp;：
        <input id="location_id" name="location_id" type="text" size="10" value="" /><br>
           电表地址码&nbsp;：
        <input id="meter_address" name="meter_address" type="text" size="10" value="" /><br>
	</td></tr >
      
	<tr> <td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 	
           电&nbsp;表&nbsp;型&nbsp;号&nbsp;：
		  <select id="select_model" name="meter_model" > 
		   <?php while($row_sel=mysql_fetch_array($rsl)){ ?>
		    <option width=50px  value="<?php echo $row_sel['meter_model'];?>"><?php echo $row_sel['meter_model'];?></option>
		   <?php } ?>
		  </select>
	</td></tr>	  
	<tr><td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 	  
		   采集参数项&nbsp;：
        <input id="data_select" name="data_select" type="text" size="10" value=" Ua, Ub, Uc, Ia, Ib, Ic, Pa, Pb, Pc, Ps, FR, EPP" class="input-xxlarge"/>  (空为采集全部)<br>
		<!--input name="u1" type="checkbox" value="u1" />&nbsp;u1&nbsp;&nbsp;
		<input name="u2" type="checkbox" value="u2" />&nbsp;u2&nbsp;&nbsp;
		<input name="u3" type="checkbox" value="u3" />&nbsp;u3&nbsp;&nbsp;
		
		<input name="i1" type="checkbox" value="i1" />&nbsp;i1&nbsp;&nbsp;
		<input name="i2" type="checkbox" value="i2" />&nbsp;i2&nbsp;&nbsp;
		<input name="i3" type="checkbox" value="i3" />&nbsp;i3&nbsp;&nbsp;
		
		<input name="s1" type="checkbox" value="s1" />&nbsp;s1&nbsp;&nbsp;
		<input name="s2" type="checkbox" value="s2" />&nbsp;s2&nbsp;&nbsp;
		<input name="s3" type="checkbox" value="s3" />&nbsp;s3&nbsp;&nbsp;
		
		<input name="f1" type="checkbox" value="f1" />&nbsp;f1&nbsp;&nbsp;
		<input name="f2" type="checkbox" value="f2" />&nbsp;f2&nbsp;&nbsp;
		<input name="f3" type="checkbox" value="f3" />&nbsp;f3&nbsp;&nbsp;
		
		<br-->
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

<script language=JavaScript1.2>
 
function javacheck(formct)
{
	
      
        
        if (formct.location_id.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写电表位置码！');
                 formct.location_id.focus();
		return false; 
	} 

        if (formct.meter_address.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写电表地址码！');
                 formct.meter_address.focus();
		return false; 
	} 
	
	    if (formct.meter_model.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写电表型号！');
                 formct.meter_model.focus();
		return false; 
	} 
	
 
}



</script>

