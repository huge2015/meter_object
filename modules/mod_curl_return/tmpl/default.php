<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_return
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<div id="electrical">
    <h1>Curl Return data, then change local data!</h1>

    <form action="" method="post" id="electrical_form">

		<table border="1">
			<tr>
				<td width="20">Number of records</td>
				<td><input type="text" name="num_records" value="0"/></td>
			</tr>
		</table> 


		<table border="1">
			<tr>
			    <th>Queue ID</th>
				<th>Electrical ID</th>
				<th>Location ID</th>
				<th>Datetime</th>
			</tr>
			<?php for ($x=0; $x<$num_records; $x++) { ?>
			<tr>
                <td><input type="text" name="controller_electrical_id-<?php echo "$x" ?>" value=""/></td>			
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