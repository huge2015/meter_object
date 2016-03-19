<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_model
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


<div id="electrical" style="padding-top:5px;">
<table width="1100px" align="center"  border="1px"">

<?php
    @$page = $_GET['page'];
    if($page==""){  
      $notepage=1; 
    }else{ 
      $notepage=$page; 
    } 
    $noterecs=0; 
    $pagesize=5;
	

    
    $sql = "select * from joomla3_metermodel order by meter_model_id desc";
	$rs = mysql_query($sql);
	$rsnum = mysql_num_rows($rs); 
	 
    $none_data = "<tr align=center><td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color=index.php/meter-modelff000f>数据库中暂时还没有录入数据！</font></a></td></tr><br><br>";
	
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
 <tr align="center" >
  <td width=50px><b>序号</font></td>
  <td width=120px><b>电表型号</font></td>
  <td width=100px><b>生产厂名</font></td> 
  <td width=100px><b>指令码A</font></td> 
  <td width=100px><b>指令码B</font></td>
  <td width=50px><b>长度</font></td>
  <td width=100px><b>功能码</font></td>
  <td width=140px><b>起始寄存器地址</font></td>
  <td width=110px><b>寄存器长度</font></td>
  <td width=600px><b>参数位置</font></td>
 </tr>

    <?php		
  
        while(($row=mysql_fetch_array($rs)) && ($noterecs <= ($pagesize - 1))){
		  $meter_model_id = $row['meter_model_id'];
          $meter_model = $row['meter_model'];
	      $meter_factory = $row['meter_factory'];
	      $command_code = $row['command_code'];
		  $command_code2 = $row['command_code2'];
	      $var_len = $row['var_len'];
	      //$address_code = $row['address_code'];
	      $function_code = $row['function_code'];
	      $storage_start_address = $row['storage_start_address'];
	      $storage_numbers = $row['storage_numbers'];
	      //$check_code = $row['check_code'];
		  $data_index = $row['data_index'];
		  
		 
    ?> 
 <tr  onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'" style="font-size:12px;color:#000035;">
 
   <td align="center" >
      <a href="index.php/meter-model-fix?meter_model_id=<?php echo $meter_model_id; ?>" title="记录序号：<?php echo $meter_model_id." &nbsp;&nbsp;&nbsp;&nbsp;电表型号：".$meter_model." &nbsp;&nbsp;&nbsp;&nbsp;指令码：".$command_code; ?>">
	  <?php echo $meter_model_id;?>
	  </a>
	  </td>
   <td align="center" ><?php echo $meter_model;?></td>
   <td align="center" ><?php echo $meter_factory;?></td>
   <td align="center" ><?php echo $command_code;?></td>
   <td align="center" ><?php echo $command_code2;?></td>
   <td align="center" ><?php echo $var_len;?></td>
   <td align="center" ><?php echo $function_code;?></td>
   <td align="center" ><?php echo $storage_start_address;?></td>
   <td align="center" ><?php echo $storage_numbers;?></td>
   <td align="center" ><?php echo $data_index;?></td>
  
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
        <a href="index.php/meter-model?page=1">首页</a>&nbsp;
		<a href="index.php/meter-model?page=
            <?php  if ($notepage>1) 
                    echo $notepage-1; 
                  else
                    echo $notepage; ?>" title=上一页>上一页</a>&nbsp;&nbsp;
            <?php echo $notepage; ?>
        <a href="index.php/meter-model?page=
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
            <option width=50px value="index.php/meter-model?page=<?php echo $i; ?>" selected>第<?php echo $i; ?>页</option>&nbsp;
	
            <?php  } else {  ?>

            <option width=50px value="index.php/meter-model?page=<?php echo $i; ?>">第<?php echo $i; ?>页</option>&nbsp;
	        <?php  
			       }
                }
			?>
        </select>

        <a href="index.php/meter-model?page=<?php echo $pagecount; ?>">尾页</a>
        
    </td>
  </tr>
</table>
</div>

    <?php
	}
    ?>
<!--循环体结束--> 

 

<br><br>
<form id=form  name="form"  method="post" action="index.php/meter-model-submit" onSubmit='return javacheck(this)'>
 <table width="900px" align=left  cellpadding="0" cellspacing="0" style="background-color:#F8F8FF;border-left:none;border-top:none;border-right:none;"> 
   <tr > 
    <td border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;"> 
           电表型号：&nbsp;
        <input id="meter_model" name="meter_model" type="text" size="10" value="" /><br>
           生产厂名：&nbsp;
        <input id="meter_factory" name="meter_factory" type="text" size="10" value="" /><br>
           指&nbsp;令&nbsp;码A：
        <input id="command_code" name="command_code" type="text" size="10" value="" /><br>
		   指&nbsp;令&nbsp;码B：
        <input id="command_code2" name="command_code2" type="text" size="10" value="" /><br>
           长&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;度：&nbsp;
        <input id="var_len" name="var_len" type="text" size="10" value="" /><br>
           功&nbsp;&nbsp;能&nbsp;&nbsp;码：
        <input id="function_code" name="function_code" type="text" size="10" value="" /><br>
           起始寄存器地址：
        <input id="storage_start_address" name="storage_start_address" type="text" size="10" value="" /><br>
           寄存器长度：
        <input id="storage_numbers" name="storage_numbers" type="text" size="10" value="" /><br>
		   参数位置：&nbsp;
        <textarea class="input-xxlarge" id="data_index" name="data_index" type="text"  value="" ></textarea><br>
          <font style="color:#5d5d5d;"> 
		    *参数位置的填写模式为：项目名:始位置-终位置<br>
			例： Ua:7-8, Ub:9-10, Uc:11-12, U_ab:13-14, U_bc:15-16, U_ca:17-18, Ia:19-20, Ib:21-22, Ic:23-24, Pa:25-26, Pb:27-28, Pc:29-30, Ps:31-32, FR:57-58, EPP:75-76-77-78, Qa:33-34, Qb:35-36, Qc:37-38, Qs:39-40, PFa:41-42, PFb:43-44, PFc:45-46, PFs:47-48, Sa:49-50, Sb:51-52, Sc:53-54, Ss:55-56, WPP:59-60-61-62, WPN:63-64-65-66, WQP:67-68-69-70, WQN:71-72-73-74, EPN:79-80-81-82, EQP:83-84-85-86,EQN:87-88
		  </font>
		<br><br>
		
		
		参数项取值设置：
		<table width="950px" align="left"  border="1px">
		
		 <tr align="center" bgcolor='#6CA6CD' height="30px">
			<td style="padding-left:10px;"><b>参数项</b></td>
		    <td style="padding-left:10px;"><input name='all_hexTodec' type='checkbox' value='' id="all_hexTodec"  onclick='change_hexTodec()'> <b>全选/反选</b>&nbsp;</td>
		    <td style="padding-left:10px;"><input name='all_Float' type='checkbox' value='' id="all_Float"  onclick='change_Float()'> <b>全选/反选</b>&nbsp; </td>
			<td style="padding-left:5px;"><b>取小数位个数<!--input name='all_formatNum' type='checkbox' value='' id="all_formatNum"  onclick='change_fill()' /--></b></td>
			<td style="padding-left:10px;" align="left"><b>代入公式(Ua值:2208>>220.8 则：$Ua=$Ua/pow(10, 4)*pow(10, $output[3]);)</b></td>			
		 </tr>
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ua：</td>
		    <td style="padding-left:10px;"><input name="Ua_hexTodec" id="Ua_hexTodec" type="checkbox"  value="1" <?php if($Ua_hexTodec == "1"){?> checked ="checked" <?php } ?>/>16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ua_Float" id="Ua_Float" type="checkbox"  value="1" <?php if($Ua_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ua_formatNum" id="Ua_formatNum" type="text"  class="input-small" value="<?php if($Ua_formatNum =="" || $Ua_formatNum == "0"){}else{echo $Ua_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ua_formula" id="Ua_formula" type="text"  class="input-xlarge"  value="<?php if($Ua_formula ==""){}else{echo $Ua_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ub：</td>
		    <td style="padding-left:10px;"><input name="Ub_hexTodec" id="Ub_hexTodec" type="checkbox"  value="1" <?php if($Ub_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ub_Float" id="Ub_Float" type="checkbox"  value="1" <?php if($Ub_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ub_formatNum" id="Ub_formatNum" type="text" class="input-small" value="<?php if($Ub_formatNum =="" || $Ub_formatNum == "0"){}else{echo $Ub_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ub_formula" id="Ub_formula" type="text"  class="input-xlarge"  value="<?php if($Ub_formula ==""){}else{echo $Ub_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Uc：</td>
		    <td style="padding-left:10px;"><input name="Uc_hexTodec" id="Uc_hexTodec" type="checkbox"  value="1" <?php if($Uc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Uc_Float" id="Uc_Float" type="checkbox"  value="1" <?php if($Uc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Uc_formatNum" id="Uc_formatNum" type="text"  class="input-small" value="<?php if($Uc_formatNum =="" || $Uc_formatNum == "0"){}else{echo $Uc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Uc_formula" id="Uc_formula" type="text"  class="input-xlarge"  value="<?php if($Uc_formula ==""){}else{echo $Uc_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">U_ab：</td>
		    <td style="padding-left:10px;"><input name="U_ab_hexTodec" id="U_ab_hexTodec" type="checkbox"  value="1" <?php if($U_ab_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="U_ab_Float" id="U_ab_Float" type="checkbox"  value="1" <?php if($U_ab_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="U_ab_formatNum" id="U_ab_formatNum" type="text"  class="input-small" value="<?php if($U_ab_formatNum =="" || $U_ab_formatNum == "0"){}else{echo $U_ab_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="U_ab_formula" id="U_ab_formula" type="text"  class="input-xlarge"  value="<?php if($U_ab_formula ==""){}else{echo $U_ab_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">U_bc：</td>
		    <td style="padding-left:10px;"><input name="U_bc_hexTodec" id="U_bc_hexTodec" type="checkbox"  value="1" <?php if($U_bc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="U_bc_Float" id="U_bc_Float" type="checkbox"  value="1" <?php if($U_bc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="U_bc_formatNum" id="U_bc_formatNum" type="text" class="input-small" value="<?php if($U_bc_formatNum =="" || $U_bc_formatNum == "0"){}else{echo $U_bc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="U_bc_formula" id="U_bc_formula" type="text"  class="input-xlarge"  value="<?php if($U_bc_formula ==""){}else{echo $U_bc_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">U_ca：</td>
		    <td style="padding-left:10px;"><input name="U_ca_hexTodec" id="U_ca_hexTodec" type="checkbox"  value="1" <?php if($U_ca_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="U_ca_Float" id="U_ca_Float" type="checkbox"  value="1" <?php if($U_ca_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="U_ca_formatNum" id="U_ca_formatNum" type="text"  class="input-small" value="<?php if($U_ca_formatNum =="" || $U_ca_formatNum == "0"){}else{echo $U_ca_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="U_ca_formula" id="U_ca_formula" type="text"  class="input-xlarge"  value="<?php if($U_ca_formula ==""){}else{echo $U_ca_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ia：</td>
		    <td style="padding-left:10px;"><input name="Ia_hexTodec" id="Ia_hexTodec" type="checkbox"  value="1" <?php if($Ia_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ia_Float" id="Ia_Float" type="checkbox"  value="1" <?php if($Ia_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ia_formatNum" id="Ia_formatNum" type="text"  class="input-small" value="<?php if($Ia_formatNum =="" || $Ia_formatNum == "0"){}else{echo $Ia_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ia_formula" id="Ia_formula" type="text"  class="input-xlarge"  value="<?php if($Ia_formula ==""){}else{echo $Ia_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ib：</td>
		    <td style="padding-left:10px;"><input name="Ib_hexTodec" id="Ib_hexTodec" type="checkbox"  value="1" <?php if($Ib_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ib_Float" id="Ib_Float" type="checkbox"  value="1" <?php if($Ib_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ib_formatNum" id="Ib_formatNum" type="text" class="input-small" value="<?php if($Ib_formatNum =="" || $Ib_formatNum == "0"){}else{echo $Ib_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ib_formula" id="Ib_formula" type="text"  class="input-xlarge"  value="<?php if($Ib_formula ==""){}else{echo $Ib_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ic：</td>
		    <td style="padding-left:10px;"><input name="Ic_hexTodec" id="Ic_hexTodec" type="checkbox"  value="1" <?php if($Ic_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ic_Float" id="Ic_Float" type="checkbox"  value="1" <?php if($Ic_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ic_formatNum" id="Ic_formatNum" type="text"  class="input-small" value="<?php if($Ic_formatNum =="" || $Ic_formatNum == "0"){}else{echo $Ic_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ic_formula" id="Ic_formula" type="text"  class="input-xlarge"  value="<?php if($Ic_formula ==""){}else{echo $Ic_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Pa：</td>
		    <td style="padding-left:10px;"><input name="Pa_hexTodec" id="Pa_hexTodec" type="checkbox"  value="1" <?php if($Pa_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Pa_Float" id="Pa_Float" type="checkbox"  value="1" <?php if($Pa_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Pa_formatNum" id="Pa_formatNum" type="text"  class="input-small" value="<?php if($Pa_formatNum =="" || $Pa_formatNum == "0"){}else{echo $Pa_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Pa_formula" id="Pa_formula" type="text"  class="input-xlarge"  value="<?php if($Pa_formula ==""){}else{echo $Pa_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Pb：</td>
		    <td style="padding-left:10px;"><input name="Pb_hexTodec" id="Pb_hexTodec" type="checkbox"  value="1" <?php if($Pb_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Pb_Float" id="Pb_Float" type="checkbox"  value="1" <?php if($Pb_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Pb_formatNum" id="Pb_formatNum" type="text" class="input-small" value="<?php if($Pb_formatNum =="" || $Pb_formatNum == "0"){}else{echo $Pb_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Pb_formula" id="Pb_formula" type="text"  class="input-xlarge"  value="<?php if($Pb_formula ==""){}else{echo $Pb_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Pc：</td>
		    <td style="padding-left:10px;"><input name="Pc_hexTodec" id="Pc_hexTodec" type="checkbox"  value="1" <?php if($Pc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Pc_Float" id="Pc_Float" type="checkbox"  value="1" <?php if($Pc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Pc_formatNum" id="Pc_formatNum" type="text"  class="input-small" value="<?php if($Pc_formatNum =="" || $Pc_formatNum == "0"){}else{echo $Pc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Pc_formula" id="Pc_formula" type="text"  class="input-xlarge"  value="<?php if($Pc_formula ==""){}else{echo $Pc_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ps：</td>
		    <td style="padding-left:10px;"><input name="Ps_hexTodec" id="Ps_hexTodec" type="checkbox"  value="1" <?php if($Ps_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ps_Float" id="Ps_Float" type="checkbox"  value="1" <?php if($Ps_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ps_formatNum" id="Ps_formatNum" type="text"  class="input-small" value="<?php if($Ps_formatNum =="" || $Ps_formatNum == "0"){}else{echo $Ps_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ps_formula" id="Ps_formula" type="text"  class="input-xlarge"  value="<?php if($Ps_formula ==""){}else{echo $Ps_formula;}?>" /></td>			
		 </tr> 		 
		 
        
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">FR：</td>
		    <td style="padding-left:10px;"><input name="FR_hexTodec" id="FR_hexTodec" type="checkbox"  value="1" <?php if($FR_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="FR_Float" id="FR_Float" type="checkbox"  value="1" <?php if($FR_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="FR_formatNum" id="FR_formatNum" type="text"  class="input-small" value="<?php if($FR_formatNum =="" || $FR_formatNum == "0"){}else{echo $FR_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="FR_formula" id="FR_formula" type="text"  class="input-xlarge"  value="<?php if($FR_formula ==""){}else{echo $FR_formula;}?>" /></td>			
		 </tr> 

		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Qa：</td>
		    <td style="padding-left:10px;"><input name="Qa_hexTodec" id="Qa_hexTodec" type="checkbox"  value="1" <?php if($Qa_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Qa_Float" id="Qa_Float" type="checkbox"  value="1" <?php if($Qa_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Qa_formatNum" id="Qa_formatNum" type="text"  class="input-small" value="<?php if($Qa_formatNum =="" || $Qa_formatNum == "0"){}else{echo $Qa_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Qa_formula" id="Qa_formula" type="text"  class="input-xlarge"  value="<?php if($Qa_formula ==""){}else{echo $Qa_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Qb：</td>
		    <td style="padding-left:10px;"><input name="Qb_hexTodec" id="Qb_hexTodec" type="checkbox"  value="1" <?php if($Qb_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Qb_Float" id="Qb_Float" type="checkbox"  value="1" <?php if($Qb_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Qb_formatNum" id="Qb_formatNum" type="text" class="input-small" value="<?php if($Qb_formatNum =="" || $Qb_formatNum == "0"){}else{echo $Qb_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Qb_formula" id="Qb_formula" type="text"  class="input-xlarge"  value="<?php if($Qb_formula ==""){}else{echo $Qb_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Qc：</td>
		    <td style="padding-left:10px;"><input name="Qc_hexTodec" id="Qc_hexTodec" type="checkbox"  value="1" <?php if($Qc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Qc_Float" id="Qc_Float" type="checkbox"  value="1" <?php if($Qc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Qc_formatNum" id="Qc_formatNum" type="text"  class="input-small" value="<?php if($Qc_formatNum =="" || $Qc_formatNum == "0"){}else{echo $Qc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Qc_formula" id="Qc_formula" type="text"  class="input-xlarge"  value="<?php if($Qc_formula ==""){}else{echo $Qc_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Qs：</td>
		    <td style="padding-left:10px;"><input name="Qs_hexTodec" id="Qs_hexTodec" type="checkbox"  value="1" <?php if($Qs_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Qs_Float" id="Qs_Float" type="checkbox"  value="1" <?php if($Qs_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Qs_formatNum" id="Qs_formatNum" type="text"  class="input-small" value="<?php if($Qs_formatNum =="" || $Qs_formatNum == "0"){}else{echo $Qs_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Qs_formula" id="Qs_formula" type="text"  class="input-xlarge"  value="<?php if($Qs_formula ==""){}else{echo $Qs_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">PFa：</td>
		    <td style="padding-left:10px;"><input name="PFa_hexTodec" id="PFa_hexTodec" type="checkbox"  value="1" <?php if($PFa_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="PFa_Float" id="PFa_Float" type="checkbox"  value="1" <?php if($PFa_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="PFa_formatNum" id="PFa_formatNum" type="text"  class="input-small" value="<?php if($PFa_formatNum =="" || $PFa_formatNum == "0"){}else{echo $PFa_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="PFa_formula" id="PFa_formula" type="text"  class="input-xlarge"  value="<?php if($PFa_formula ==""){}else{echo $PFa_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">PFb：</td>
		    <td style="padding-left:10px;"><input name="PFb_hexTodec" id="PFb_hexTodec" type="checkbox"  value="1" <?php if($PFb_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="PFb_Float" id="PFb_Float" type="checkbox"  value="1" <?php if($PFb_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="PFb_formatNum" id="PFb_formatNum" type="text" class="input-small" value="<?php if($PFb_formatNum =="" || $PFb_formatNum == "0"){}else{echo $PFb_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="PFb_formula" id="PFb_formula" type="text"  class="input-xlarge"  value="<?php if($PFb_formula ==""){}else{echo $PFb_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">PFc：</td>
		    <td style="padding-left:10px;"><input name="PFc_hexTodec" id="PFc_hexTodec" type="checkbox"  value="1" <?php if($PFc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="PFc_Float" id="PFc_Float" type="checkbox"  value="1" <?php if($PFc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="PFc_formatNum" id="PFc_formatNum" type="text"  class="input-small" value="<?php if($PFc_formatNum =="" || $PFc_formatNum == "0"){}else{echo $PFc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="PFc_formula" id="PFc_formula" type="text"  class="input-xlarge"  value="<?php if($PFc_formula ==""){}else{echo $PFc_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">PFs：</td>
		    <td style="padding-left:10px;"><input name="PFs_hexTodec" id="PFs_hexTodec" type="checkbox"  value="1" <?php if($PFs_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="PFs_Float" id="PFs_Float" type="checkbox"  value="1" <?php if($PFs_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="PFs_formatNum" id="PFs_formatNum" type="text"  class="input-small" value="<?php if($PFs_formatNum =="" || $PFs_formatNum == "0"){}else{echo $PFs_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="PFs_formula" id="PFs_formula" type="text"  class="input-xlarge"  value="<?php if($PFs_formula ==""){}else{echo $PFs_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Sa：</td>
		    <td style="padding-left:10px;"><input name="Sa_hexTodec" id="Sa_hexTodec" type="checkbox"  value="1" <?php if($Sa_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Sa_Float" id="Sa_Float" type="checkbox"  value="1" <?php if($Sa_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Sa_formatNum" id="Sa_formatNum" type="text"  class="input-small" value="<?php if($Sa_formatNum =="" || $Sa_formatNum == "0"){}else{echo $Sa_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Sa_formula" id="Sa_formula" type="text"  class="input-xlarge"  value="<?php if($Sa_formula ==""){}else{echo $Sa_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Sb：</td>
		    <td style="padding-left:10px;"><input name="Sb_hexTodec" id="Sb_hexTodec" type="checkbox"  value="1" <?php if($Sb_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Sb_Float" id="Sb_Float" type="checkbox"  value="1" <?php if($Sb_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Sb_formatNum" id="Sb_formatNum" type="text" class="input-small" value="<?php if($Sb_formatNum =="" || $Sb_formatNum == "0"){}else{echo $Sb_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Sb_formula" id="Sb_formula" type="text"  class="input-xlarge"  value="<?php if($Sb_formula ==""){}else{echo $Sb_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Sc：</td>
		    <td style="padding-left:10px;"><input name="Sc_hexTodec" id="Sc_hexTodec" type="checkbox"  value="1" <?php if($Sc_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Sc_Float" id="Sc_Float" type="checkbox"  value="1" <?php if($Sc_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Sc_formatNum" id="Sc_formatNum" type="text"  class="input-small" value="<?php if($Sc_formatNum =="" || $Sc_formatNum == "0"){}else{echo $Sc_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Sc_formula" id="Sc_formula" type="text"  class="input-xlarge"  value="<?php if($Sc_formula ==""){}else{echo $Sc_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">Ss：</td>
		    <td style="padding-left:10px;"><input name="Ss_hexTodec" id="Ss_hexTodec" type="checkbox"  value="1" <?php if($Ss_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="Ss_Float" id="Ss_Float" type="checkbox"  value="1" <?php if($Ss_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="Ss_formatNum" id="Ss_formatNum" type="text"  class="input-small" value="<?php if($Ss_formatNum =="" || $Ss_formatNum == "0"){}else{echo $Ss_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="Ss_formula" id="Ss_formula" type="text"  class="input-xlarge"  value="<?php if($Ss_formula ==""){}else{echo $Ss_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">WPP：</td>
		    <td style="padding-left:10px;"><input name="WPP_hexTodec" id="WPP_hexTodec" type="checkbox"  value="1" <?php if($WPP_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="WPP_Float" id="WPP_Float" type="checkbox"  value="1" <?php if($WPP_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="WPP_formatNum" id="WPP_formatNum" type="text"  class="input-small" value="<?php if($WPP_formatNum =="" || $WPP_formatNum == "0"){}else{echo $WPP_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="WPP_formula" id="WPP_formula" type="text"  class="input-xlarge"  value="<?php if($WPP_formula ==""){}else{echo $WPP_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">WPN：</td>
		    <td style="padding-left:10px;"><input name="WPN_hexTodec" id="WPN_hexTodec" type="checkbox"  value="1" <?php if($WPN_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="WPN_Float" id="WPN_Float" type="checkbox"  value="1" <?php if($WPN_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="WPN_formatNum" id="WPN_formatNum" type="text" class="input-small" value="<?php if($WPN_formatNum =="" || $WPN_formatNum == "0"){}else{echo $WPN_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="WPN_formula" id="WPN_formula" type="text"  class="input-xlarge"  value="<?php if($WPN_formula ==""){}else{echo $WPN_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">WQP：</td>
		    <td style="padding-left:10px;"><input name="WQP_hexTodec" id="WQP_hexTodec" type="checkbox"  value="1" <?php if($WQP_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="WQP_Float" id="WQP_Float" type="checkbox"  value="1" <?php if($WQP_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="WQP_formatNum" id="WQP_formatNum" type="text"  class="input-small" value="<?php if($WQP_formatNum =="" || $WQP_formatNum == "0"){}else{echo $WQP_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="WQP_formula" id="WQP_formula" type="text"  class="input-xlarge"  value="<?php if($WQP_formula ==""){}else{echo $WQP_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">WQN：</td>
		    <td style="padding-left:10px;"><input name="WQN_hexTodec" id="WQN_hexTodec" type="checkbox"  value="1" <?php if($WQN_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="WQN_Float" id="WQN_Float" type="checkbox"  value="1" <?php if($WQN_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="WQN_formatNum" id="WQN_formatNum" type="text"  class="input-small" value="<?php if($WQN_formatNum =="" || $WQN_formatNum == "0"){}else{echo $WQN_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="WQN_formula" id="WQN_formula" type="text"  class="input-xlarge"  value="<?php if($WQN_formula ==""){}else{echo $WQN_formula;}?>" /></td>			
		 </tr>
		 
		 
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">EPP：</td>
		    <td style="padding-left:10px;"><input name="EPP_hexTodec" id="EPP_hexTodec" type="checkbox"  value="1" <?php if($EPP_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="EPP_Float" id="EPP_Float" type="checkbox"  value="1" <?php if($EPP_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="EPP_formatNum" id="EPP_formatNum" type="text"  class="input-small" value="<?php if($EPP_formatNum =="" || $EPP_formatNum == "0"){}else{echo $EPP_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="EPP_formula" id="EPP_formula" type="text"  class="input-xlarge"  value="<?php if($EPP_formula ==""){}else{echo $EPP_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">EPN：</td>
		    <td style="padding-left:10px;"><input name="EPN_hexTodec" id="EPN_hexTodec" type="checkbox"  value="1" <?php if($EPN_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="EPN_Float" id="EPN_Float" type="checkbox"  value="1" <?php if($EPN_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="EPN_formatNum" id="EPN_formatNum" type="text" class="input-small" value="<?php if($EPN_formatNum =="" || $EPN_formatNum == "0"){}else{echo $EPN_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="EPN_formula" id="EPN_formula" type="text"  class="input-xlarge"  value="<?php if($EPN_formula ==""){}else{echo $EPN_formula;}?>" /></td>			
		 </tr>
		 <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">EQP：</td>
		    <td style="padding-left:10px;"><input name="EQP_hexTodec" id="EQP_hexTodec" type="checkbox"  value="1" <?php if($EQP_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="EQP_Float" id="EQP_Float" type="checkbox"  value="1" <?php if($EQP_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="EQP_formatNum" id="EQP_formatNum" type="text"  class="input-small" value="<?php if($EQP_formatNum =="" || $EQP_formatNum == "0"){}else{echo $EQP_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="EQP_formula" id="EQP_formula" type="text"  class="input-xlarge"  value="<?php if($EQP_formula ==""){}else{echo $EQP_formula;}?>" /></td>			
		 </tr>
         <tr align="center" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:10px;">EQN：</td>
		    <td style="padding-left:10px;"><input name="EQN_hexTodec" id="EQN_hexTodec" type="checkbox"  value="1" <?php if($EQN_hexTodec == "1"){?> checked ="checked" <?php } ?> />16进制转10进制&nbsp;&nbsp;</td>
		    <td style="padding-left:10px;"><input name="EQN_Float" id="EQN_Float" type="checkbox"  value="1" <?php if($EQN_Float == "1"){?> checked ="checked" <?php } ?> />浮点型转换&nbsp;&nbsp;</td>
			<td style="padding-left:10px;"><input name="EQN_formatNum" id="EQN_formatNum" type="text"  class="input-small" value="<?php if($EQN_formatNum =="" || $EQN_formatNum == "0"){}else{echo $EQN_formatNum;}?>" /></td>
			<td style="padding-left:10px;" align="left">代入公式：      <input name="EQN_formula" id="EQN_formula" type="text"  class="input-xlarge"  value="<?php if($EQN_formula ==""){}else{echo $EQN_formula;}?>" /></td>			
		 </tr>
		 
        </table>		 
       
    
	<table width="900px" align="left" >
	 <tr align="left">
	  <td><br>
	    <input type="submit" value=" 提  交 "  id="send-btn" />
		<br><br>
	  </td>
	 </tr>
	</table>
    
    
    </td>
   </tr>
 </table>
</form>



<script language=JavaScript1.2>
function change_hexTodec(){
	
var all_hexTodec = document.getElementById("all_hexTodec");

//-U-----------------
var Ua_hexTodec = document.getElementById("Ua_hexTodec");
var Ub_hexTodec = document.getElementById("Ub_hexTodec");
var Uc_hexTodec = document.getElementById("Uc_hexTodec");

//-U_xx-----------------
var U_ab_hexTodec = document.getElementById("U_ab_hexTodec");
var U_bc_hexTodec = document.getElementById("U_bc_hexTodec");
var U_ca_hexTodec = document.getElementById("U_ca_hexTodec");

//-I-----------------
var Ia_hexTodec = document.getElementById("Ia_hexTodec");
var Ib_hexTodec = document.getElementById("Ib_hexTodec");
var Ic_hexTodec = document.getElementById("Ic_hexTodec");

//-P-----------------
var Pa_hexTodec = document.getElementById("Pa_hexTodec");
var Pb_hexTodec = document.getElementById("Pb_hexTodec");
var Pc_hexTodec = document.getElementById("Pc_hexTodec");
var Ps_hexTodec = document.getElementById("Ps_hexTodec");

//-FR-----------------
var FR_hexTodec = document.getElementById("FR_hexTodec");

//-Q-----------------
var Qa_hexTodec = document.getElementById("Qa_hexTodec");
var Qb_hexTodec = document.getElementById("Qb_hexTodec");
var Qc_hexTodec = document.getElementById("Qc_hexTodec");
var Qs_hexTodec = document.getElementById("Qs_hexTodec");

//-PFx-----------------
var PFa_hexTodec = document.getElementById("PFa_hexTodec");
var PFb_hexTodec = document.getElementById("PFb_hexTodec");
var PFc_hexTodec = document.getElementById("PFc_hexTodec");
var PFs_hexTodec = document.getElementById("PFs_hexTodec");

//-S-----------------
var Sa_hexTodec = document.getElementById("Sa_hexTodec");
var Sb_hexTodec = document.getElementById("Sb_hexTodec");
var Sc_hexTodec = document.getElementById("Sc_hexTodec");
var Ss_hexTodec = document.getElementById("Ss_hexTodec");

//-Wxx-----------------	  	  
var WPP_hexTodec = document.getElementById("WPP_hexTodec");    
var WPN_hexTodec = document.getElementById("WPN_hexTodec");	
var WQP_hexTodec = document.getElementById("WQP_hexTodec");   
var WQN_hexTodec = document.getElementById("WQN_hexTodec");

//-Exx-----------------
var EPP_hexTodec = document.getElementById("EPP_hexTodec");
var EPN_hexTodec = document.getElementById("EPN_hexTodec");
var EQP_hexTodec = document.getElementById("EQP_hexTodec");
var EQN_hexTodec = document.getElementById("EQN_hexTodec");



  if(all_hexTodec.checked == true){  //change checked----------------------------
	  
	//-U-----------------
Ua_hexTodec.checked = true;
Ub_hexTodec.checked = true;
Uc_hexTodec.checked = true;

//-U_xx-----------------
U_ab_hexTodec.checked = true;
U_bc_hexTodec.checked = true;
U_ca_hexTodec.checked = true;

//-I-----------------
Ia_hexTodec.checked = true;
Ib_hexTodec.checked = true;
Ic_hexTodec.checked = true;

//-P-----------------
Pa_hexTodec.checked = true;
Pb_hexTodec.checked = true;
Pc_hexTodec.checked = true;
Ps_hexTodec.checked = true;

//-FR-----------------
FR_hexTodec.checked = true;

//-Q-----------------
Qa_hexTodec.checked = true;
Qb_hexTodec.checked = true;
Qc_hexTodec.checked = true;
Qs_hexTodec.checked = true;

//-PFx-----------------
PFa_hexTodec.checked = true;
PFb_hexTodec.checked = true;
PFc_hexTodec.checked = true;
PFs_hexTodec.checked = true;

//-S-----------------
Sa_hexTodec.checked = true;
Sb_hexTodec.checked = true;
Sc_hexTodec.checked = true;
Ss_hexTodec.checked = true; 

//-Wxx-----------------	
WPP_hexTodec.checked = true;
WPN_hexTodec.checked = true;
WQP_hexTodec.checked = true;
WQN_hexTodec.checked = true;  

//-Exx-----------------		
EPP_hexTodec.checked = true;
EPN_hexTodec.checked = true;
EQP_hexTodec.checked = true;
EQN_hexTodec.checked = true;

  }else{

   //-U-----------------
Ua_hexTodec.checked = false;
Ub_hexTodec.checked = false;
Uc_hexTodec.checked = false;

//-U_xx-----------------
U_ab_hexTodec.checked = false;
U_bc_hexTodec.checked = false;
U_ca_hexTodec.checked = false;

//-I-----------------
Ia_hexTodec.checked = false;
Ib_hexTodec.checked = false;
Ic_hexTodec.checked = false;

//-P-----------------
Pa_hexTodec.checked = false;
Pb_hexTodec.checked = false;
Pc_hexTodec.checked = false;
Ps_hexTodec.checked = false;

//-FR-----------------
FR_hexTodec.checked = false;

//-Q-----------------
Qa_hexTodec.checked = false;
Qb_hexTodec.checked = false;
Qc_hexTodec.checked = false;
Qs_hexTodec.checked = false;

//-PFx-----------------
PFa_hexTodec.checked = false;
PFb_hexTodec.checked = false;
PFc_hexTodec.checked = false;
PFs_hexTodec.checked = false;

//-S-----------------
Sa_hexTodec.checked = false;
Sb_hexTodec.checked = false;
Sc_hexTodec.checked = false;
Ss_hexTodec.checked = false; 

//-Wxx-----------------	
WPP_hexTodec.checked = false;
WPN_hexTodec.checked = false;
WQP_hexTodec.checked = false;
WQN_hexTodec.checked = false;  

//-Exx-----------------		
EPP_hexTodec.checked = false;
EPN_hexTodec.checked = false;
EQP_hexTodec.checked = false;
EQN_hexTodec.checked = false;
    
  }//if 

}

</script>



<script language=JavaScript1.2>
function change_Float(){
	
var all_Float = document.getElementById("all_Float");

//-U-----------------
var Ua_Float = document.getElementById("Ua_Float");
var Ub_Float = document.getElementById("Ub_Float");
var Uc_Float = document.getElementById("Uc_Float");

//-U_xx-----------------
var U_ab_Float = document.getElementById("U_ab_Float");
var U_bc_Float = document.getElementById("U_bc_Float");
var U_ca_Float = document.getElementById("U_ca_Float");

//-I-----------------
var Ia_Float = document.getElementById("Ia_Float");
var Ib_Float = document.getElementById("Ib_Float");
var Ic_Float = document.getElementById("Ic_Float");

//-P-----------------
var Pa_Float = document.getElementById("Pa_Float");
var Pb_Float = document.getElementById("Pb_Float");
var Pc_Float = document.getElementById("Pc_Float");
var Ps_Float = document.getElementById("Ps_Float");

//-FR-----------------
var FR_Float = document.getElementById("FR_Float");

//-Q-----------------
var Qa_Float = document.getElementById("Qa_Float");
var Qb_Float = document.getElementById("Qb_Float");
var Qc_Float = document.getElementById("Qc_Float");
var Qs_Float = document.getElementById("Qs_Float");

//-PFx-----------------
var PFa_Float = document.getElementById("PFa_Float");
var PFb_Float = document.getElementById("PFb_Float");
var PFc_Float = document.getElementById("PFc_Float");
var PFs_Float = document.getElementById("PFs_Float");

//-S-----------------
var Sa_Float = document.getElementById("Sa_Float");
var Sb_Float = document.getElementById("Sb_Float");
var Sc_Float = document.getElementById("Sc_Float");
var Ss_Float = document.getElementById("Ss_Float");

//-Wxx-----------------	  	  
var WPP_Float = document.getElementById("WPP_Float");    
var WPN_Float = document.getElementById("WPN_Float");	
var WQP_Float = document.getElementById("WQP_Float");   
var WQN_Float = document.getElementById("WQN_Float");

//-Exx-----------------
var EPP_Float = document.getElementById("EPP_Float");
var EPN_Float = document.getElementById("EPN_Float");
var EQP_Float = document.getElementById("EQP_Float");
var EQN_Float = document.getElementById("EQN_Float");



  if(all_Float.checked == true){  //change checked----------------------------
	  
	//-U-----------------
Ua_Float.checked = true;
Ub_Float.checked = true;
Uc_Float.checked = true;

//-U_xx-----------------
U_ab_Float.checked = true;
U_bc_Float.checked = true;
U_ca_Float.checked = true;

//-I-----------------
Ia_Float.checked = true;
Ib_Float.checked = true;
Ic_Float.checked = true;

//-P-----------------
Pa_Float.checked = true;
Pb_Float.checked = true;
Pc_Float.checked = true;
Ps_Float.checked = true;

//-FR-----------------
FR_Float.checked = true;

//-Q-----------------
Qa_Float.checked = true;
Qb_Float.checked = true;
Qc_Float.checked = true;
Qs_Float.checked = true;

//-PFx-----------------
PFa_Float.checked = true;
PFb_Float.checked = true;
PFc_Float.checked = true;
PFs_Float.checked = true;

//-S-----------------
Sa_Float.checked = true;
Sb_Float.checked = true;
Sc_Float.checked = true;
Ss_Float.checked = true; 

//-Wxx-----------------	
WPP_Float.checked = true;
WPN_Float.checked = true;
WQP_Float.checked = true;
WQN_Float.checked = true;  

//-Exx-----------------		
EPP_Float.checked = true;
EPN_Float.checked = true;
EQP_Float.checked = true;
EQN_Float.checked = true;

  }else{

   //-U-----------------
Ua_Float.checked = false;
Ub_Float.checked = false;
Uc_Float.checked = false;

//-U_xx-----------------
U_ab_Float.checked = false;
U_bc_Float.checked = false;
U_ca_Float.checked = false;

//-I-----------------
Ia_Float.checked = false;
Ib_Float.checked = false;
Ic_Float.checked = false;

//-P-----------------
Pa_Float.checked = false;
Pb_Float.checked = false;
Pc_Float.checked = false;
Ps_Float.checked = false;

//-FR-----------------
FR_Float.checked = false;

//-Q-----------------
Qa_Float.checked = false;
Qb_Float.checked = false;
Qc_Float.checked = false;
Qs_Float.checked = false;

//-PFx-----------------
PFa_Float.checked = false;
PFb_Float.checked = false;
PFc_Float.checked = false;
PFs_Float.checked = false;

//-S-----------------
Sa_Float.checked = false;
Sb_Float.checked = false;
Sc_Float.checked = false;
Ss_Float.checked = false; 

//-Wxx-----------------	
WPP_Float.checked = false;
WPN_Float.checked = false;
WQP_Float.checked = false;
WQN_Float.checked = false;  

//-Exx-----------------		
EPP_Float.checked = false;
EPN_Float.checked = false;
EQP_Float.checked = false;
EQN_Float.checked = false;
    
  }//if 

}

</script>

<script language=JavaScript1.2>
 
function javacheck(formct)
{
	
      
        
        if (formct.meter_model.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写电表型号！');
                 formct.meter_model.focus();
		return false; 
	} 
	
	    if (formct.command_code.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写指令码A！');
                 formct.command_code.focus();
		return false; 
	}
	
	    if (formct.command_code2.value.replace(/^\s|\s$/g,'') == '') 
	{
		alert('请填写指令码B!');
                 formct.command_code2.focus();
		return false; 
	}

    
       
}

</script>
