<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_switch
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterSwitchUpdateHelper
{
    function updateMeterSwitchValues($datetime_change, $location_id, $meter_address, $switch, $key ) {
                
				// read meter_model values
		        $db = JFactory::getDBO();
                $query = $db->getQuery(true);
		        $query->select('*');
		        $query->from($db->quoteName('joomla3_electrical_status'));
		        $query->where($db->quoteName('location_id')." = ".$location_id." and ".
				              $db->quoteName('meter_address')." = ".$meter_address);

                //$query = "SELECT * FROM joomla3_electrical_status WHERE location_id = '$location_id' and meter_address = '$meter_address'";
				
                $db->setQuery($query);
                $status_id = $db->loadResult();
                if($status_id == ""){
					echo " <script>alert('警告：数据库中不存在表状态记录！');history.back(); </script>";
				}else{
				   
				   
				  if($switch=="0"){$electrical_status = 1;}else{$electrical_status = 0;}
				  
				  // Create and populate an object.
                  $profile = new stdClass();
				  $profile->status_id = $status_id;
                  $profile->electrical_status = $electrical_status;
               
                  // Update the object from the user profile table.
                  $result = JFactory::getDbo()->updateObject('joomla3_electrical_status', $profile, 'status_id');
				  
				  if($result == true){
					  if($key == "info"){
					      echo "<script>alert('更新成功！');location.href='meter-info'; </script>";
				      }else{
						  echo "<script>alert('更新成功！');location.href='meter-connect'; </script>";
					  }
				  }else{
					  echo "<script>alert('更新失败，请重新修改！');history.back(); </script>";
				  }
				
				}

    }
}
