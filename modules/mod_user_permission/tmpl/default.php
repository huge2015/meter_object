<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_user_permission
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
<table width="100%" border="1px"  align=center >

<?php
    @$page = $_GET['page'];
    if($page==""){  
      $notepage=1; 
    }else{ 
      $notepage=$page; 
    } 
    $noterecs=0; 
    $pagesize=10;
	
    
    $sq = "select * from joomla3_electrical_user  order by id desc";
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
  <td width=50px ><b>SN</td>
  <td width=50px ><b>UserID</td>
  <td width=100px ><b>Name</td> 
  <td width=100px ><b>UserName</td>
  <td width=100px ><b>LocationID</td>
  <td width=100px ><b>Group</td> 
  <td width=100px ><b>Permission</td>   
  <td width=100px ><b>CreateTime</td>
  <td width=100px ><b>ChangeTime</td>
 </tr>

    <?php		
  
        while(($row=mysql_fetch_array($rs)) && ($noterecs <= ($pagesize - 1))){
		  $id = $row['id'];
          $user_id = $row['user_id'];
		  $location_id = $row['location_id'];
		  $create_time = $row['create_time'];
		  $change_time = $row['change_time'];
    ?> 
 <tr  onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'" style="font-size:12px;color:#000035;">
 
   <td align="center" >
      <a href="index.php/user-permission-fix?id=<?php echo $id; ?>
	  " title="<?php echo $id." &nbsp;&nbsp;&nbsp;&nbsp;UserID：".$user_id." &nbsp;&nbsp;&nbsp;&nbsp;UserName:".$name; ?>">
	  <?php echo $id;?>
	  </a>
	  </td>
   <td align="center" ><?php echo $user_id;?></td>
   <td align="center" ><?php echo $name;?></td>
   <td align="center" ><?php echo $username;?></td>
   <td align="center" ><?php echo $location_id;?></td>
   <td align="center" ><?php echo $create_time;?></td>
   <td align="center" ><?php echo $change_time;?></td>
   

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
<table width="100%" align=center  cellpadding="0" cellspacing="0" style="background-color:#F8F8FF;border-left:none;border-top:none;border-right:none;">
  <tr align=left>
    <td width=200px style="padding-left:5px;">
     共 <?php echo $rsnum; ?> 项&nbsp;&nbsp;&nbsp;每页 <?php echo $pagesize; ?> 项&nbsp;&nbsp;&nbsp;&nbsp;页次：<?php echo $notepage; ?>/<?php echo $pagecount; ?>
    </td>
    <td width=500px align=right>  
        <a href="index.php/user-permission?page=1">首页</a>&nbsp;
		<a href="index.php/user-permission?page=
            <?php  if ($notepage>1) 
                    echo $notepage-1; 
                  else
                    echo $notepage; ?>" title=上一页>上一页</a>&nbsp;&nbsp;
            <?php echo $notepage; ?>
        <a href="index.php/user-permission?page=
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
            <option width=50px value="index.php/user-permission?page=<?php echo $i; ?>" selected>第<?php echo $i; ?>页</option>&nbsp;
	
            <?php  } else {  ?>

            <option width=50px value="index.php/user-permission?page=<?php echo $i; ?>">第<?php echo $i; ?>页</option>&nbsp;
	        <?php  
			       }
                }
			?>
        </select>

        <a href="index.php/user-permission?page=<?php echo $pagecount; ?>">尾页</a>
        
    </td>
  </tr>
</table>
</div>


    <?php
	}
    ?>
<!--循环体结束-->



