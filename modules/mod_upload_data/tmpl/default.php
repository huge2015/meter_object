<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_dianbiao
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<script type="text/javascript">
/*
var url = "index.php/meter-connect" //要跳转的地址
var obj = document.getElementById("timeClew"), time = -1;
function setTimeClew(){ 
  //time--;
 if(time < 0){ window.open(url,'newwindow','height=600,width=800,top=500,left=500,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no');}else{ setTimeout(setTimeClew, 1000) }
}
setTimeClew()
*/
</script>
<div id="timeClew" algin=center></div>
<?php sleep(1);?>
<div id="electrical">
    <h1>Upload Data to Server</h1>

	Datas：
	<table border="1">
		<tr>
			<th>Electrical_id</th>
			<th>Location_id</th>
			<th>Datetime</th>
			
			<th>Voltage 1</th>
			<th>Current 1</th>
			<th>Apparent Power 1</th>
			
			<th>Voltage 2</th>
			<th>Current 2</th>
			<th>Apparent Power 2</th>
			
			<th>Voltage 3</th>
			<th>Current 3</th>
			<th>Apparent Power 3</th>
			
			<th>Frequency </th>
			<th>Total Power</th>
			<th>Energy_kwh</th>
		</tr>
		<?php foreach ($electrical_data as $data) { ?>
		<tr>
			<td><?php echo "{$data['electrical_id']}"; ?></td>
			<td><?php echo "{$data['location_id']}"; ?></td>
			<td><?php echo "{$data['datetime']}"; ?></td>
			
			<td><?php echo "{$data['phase1_voltage']}"; ?></td>
			<td><?php echo "{$data['phase1_current']}"; ?></td>
			<td><?php echo "{$data['phase1_apparent_power']}"; ?></td>
			
			<td><?php echo "{$data['phase2_voltage']}"; ?></td>
			<td><?php echo "{$data['phase2_current']}"; ?></td>
			<td><?php echo "{$data['phase2_apparent_power']}"; ?></td>
			
			<td><?php echo "{$data['phase3_voltage']}"; ?></td>
			<td><?php echo "{$data['phase3_current']}"; ?></td>
			<td><?php echo "{$data['phase3_apparent_power']}"; ?></td>
			
			
			<td><?php echo "{$data['phase1_frequency']}"; ?></td>
			<td><?php echo "{$data['total_power']}"; ?></td>
			<td><?php echo "{$data['energy_kwh']}"; ?></td>
		</tr>	
		<?php }?>
	</table>

    <form action="index.php/submit-data" method="post" id="electrical_form" onsubmit="pushdata(<?php echo $num_records;?>);">

          <table border="1">
            <tr>
              <td>时间</td>  
              <td><?php echo "$time"; ?></td>
            </tr>
            <tr>
              <td>行动</td>  
              <td><input type="submit" value="提交数据"></td>
            </tr>
          </table>
    </form>
</div>

