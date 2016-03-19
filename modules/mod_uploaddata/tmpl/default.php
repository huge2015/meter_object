<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_uploaddata
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<div id="electrical">
    <h1>Electrical Values Submission Form!</h1>

    <form action="http://www.electromonitor.com/monitor/index.php/upload-data" method="post" id="electrical_form">

		<table border="1">
			<tr>
				<td width="20">Number of records</td>
				<td><input type="text" name="num_records" value="0"/></td>
			</tr>
		</table> 


		<table border="1">
			<tr>
				<th>Electrical ID</th>
				<th>Location ID</th>
				<th>Datetime</th>
				<th>Phase 1 real power</th>
				<th>Phase 1 apparent power</th>
				<th>Phase 1 power factor</th>
				<th>Phase 1 frequency</th>
				<th>Phase 1 voltage</th>
				<th>Phase 1 current</th>
			</tr>
			<?php for ($x=0; $x<1; $x++) { ?>
			<tr>				
				<td><input type="text" name="controller_electrical_id-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="location_id-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="datetime-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="phase1_real_power-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="phase1_apparent_power-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="phase1_power_factor-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="frequency-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="phase1_voltage-<?php echo "$x" ?>" value=""/></td>
				<td><input type="text" name="phase1_current-<?php echo "$x" ?>" value=""/></td>
			</tr>
			<?php } ?>
			
			<tr>
				<td><input type="submit" name="send" value="Send" /></td>
			</tr>
		</table> 
    </form>
</div>