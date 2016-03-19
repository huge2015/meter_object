<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_data
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;
?>

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>


<div id="electrical">
    <h1>提交数据</h1>

	Datas：
	<table border="1">
		<tr>
			<th>Electrical_id</th>
			<th>Location_id</th>
			<th>Datetime</th>
		</tr>
		<?php   foreach ($queue_data AS $data) {

                    $electrical_id = $data['electrical_id'];
                    $location_id = $data['location_id'];
                    $meter_address = $data['meter_address'];
                    $datetime = $data['datetime'];
					
					unset($electrical_data);
    				$electrical_rows = ModCurlDataHelper::getElectricalData($electrical_id, $location_id, $meter_address, $datetime);
	
    				if($electrical_rows != ""){
		
        				foreach($electrical_rows AS $electrical_data){
				    
					


	    ?>
		<tr>
			<td><?php echo "{$electrical_data['electrical_id']}"; ?></td>
			<td><?php echo "{$electrical_data['location_id']}"; ?></td>
			<td><?php echo "{$electrical_data['datetime']}"; ?></td>
			
		</tr>	
		<?php } } }?>
	</table>

    <!--form action="index.php/submit-data" method="post" id="electrical_form">

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
    </form-->
</div>
