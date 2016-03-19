<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_excute
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>

<div id="timeClew" algin=center></div>
<div id="electrical">
    <h1>Upload data Excute</h1>

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
		<?php   foreach ($queue_data AS $data) {

                    $electrical_id = $data['electrical_id'];
                    $location_id = $data['location_id'];
                    $meter_address = $data['meter_address'];
                    $datetime = $data['datetime'];
					
					unset($electrical_data);
    				$electrical_rows = ModUploadExcuteHelper::getElectricalData($electrical_id, $location_id, $meter_address, $datetime);
	
    				if($electrical_rows != ""){
		
        				foreach($electrical_rows AS $electrical_data){
				    
					


	    ?>
		<tr>
			<td><?php echo "{$electrical_data['electrical_id']}"; ?></td>
			<td><?php echo "{$electrical_data['location_id']}"; ?></td>
			<td><?php echo "{$electrical_data['datetime']}"; ?></td>
			
			<td><?php echo "{$electrical_data['phase1_voltage']}"; ?></td>
			<td><?php echo "{$electrical_data['phase1_current']}"; ?></td>
			<td><?php echo "{$electrical_data['phase1_apparent_power']}"; ?></td>
			
			<td><?php echo "{$electrical_data['phase2_voltage']}"; ?></td>
			<td><?php echo "{$electrical_data['phase2_current']}"; ?></td>
			<td><?php echo "{$electrical_data['phase2_apparent_power']}"; ?></td>
			
			<td><?php echo "{$electrical_data['phase3_voltage']}"; ?></td>
			<td><?php echo "{$electrical_data['phase3_current']}"; ?></td>
			<td><?php echo "{$electrical_data['phase3_apparent_power']}"; ?></td>
			
			
			<td><?php echo "{$electrical_data['phase1_frequency']}"; ?></td>
			<td><?php echo "{$electrical_data['total_power']}"; ?></td>
			<td><?php echo "{$electrical_data['energy_kwh']}"; ?></td>
		</tr>	
		<?php } } }?>
	</table>

    <!--form action="index.php/submit-electrical_data" method="post" id="electrical_form" onsubmit="pushelectrical_data(<?php echo $num_records;?>);">

          <table border="1">
            <tr>
              <td>时间</td>  
              <td><?php //echo "$time"; ?></td>
            </tr>
            <tr>
              <td>行动</td>  
              <td><input type="submit" value="提交数据"></td>
            </tr>
          </table>
    </form-->
</div>

