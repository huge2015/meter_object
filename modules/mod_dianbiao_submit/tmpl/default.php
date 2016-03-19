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
<div id="setTimejump" algin=center></div>

<div id="electrical">
    <h1>提交数据</h1>

	提交的数据：
	<table border="1">
		<tr>
			<th>Electrical_id</th>
			<th>Location_id</th>
			<th>Datetime</th>
			<th>Voltage 1</th>
			<th>Current 1</th>
			<th>Frequency 1</th>
			<th>Apparent Power 1</th>
		</tr>
		<?php foreach ($electrical_data as $data) { ?>
		<tr>
			<td><?php echo "{$data['electrical_id']}"; ?></td>
			<td><?php echo "{$data['location_id']}"; ?></td>
			<td><?php echo "{$data['datetime']}"; ?></td>
			<td><?php echo "{$data['phase1_voltage']}"; ?></td>
			<td><?php echo "{$data['phase1_current']}"; ?></td>
			<td><?php echo "{$data['phase1_frequency']}"; ?></td>
			<td><?php echo "{$data['phase1_apparent_power']}"; ?></td>
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

