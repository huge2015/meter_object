<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_submit
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterInfoSubmitHelper
{

        function insertMeterInfoValues($datetime_create, $location_id, $meter_address, $meter_model, $data_select) {
               
                // read meter_model values
		        $db = JFactory::getDBO();
                $query = $db->getQuery(true);
		        $query->select('info_id, location_id, meter_address');
		        $query->from($db->quoteName('joomla3_meter_info'));
		        $query->where($db->quoteName('location_id')." = ".$location_id." and ".
				              $db->quoteName('meter_address')." = ".$meter_address);

                //$query = 'SELECT * FROM joomla3_meter_info WHERE location_id ='.$location_id.' and location_id ='.$location_id;
				
                $db->setQuery($query);
                $result = $db->loadResult();
                if($result != ""){
					echo " <script>alert('数据库中已存在相同的电表地址！ 记录序号：".$result."');history.back(); </script>";
				}else{

			   // Create and populate an object joomla3_meter_info.
                $profile = new stdClass();
                $profile->location_id = $location_id;
				$profile->meter_address = $meter_address;
                $profile->meter_model = $meter_model;
				$profile->data_select = $data_select;
                $profile->datetime_create = $datetime_create;
                // Insert the object into the user profile table.
                $result2 = JFactory::getDbo()->insertObject('joomla3_meter_info', $profile);
				
				
				// Create and populate an object  joomla3_electrical_status.
                $profile2 = new stdClass();
                $profile2->location_id = $location_id;
				$profile2->meter_address = $meter_address;
                //$profile2->electrical_status = 1;
                // Insert the object into the user profile table.
                $status = JFactory::getDbo()->insertObject('joomla3_electrical_status', $profile2);

				  if(($result2==true)&&($status==true)){
					  echo "<script>alert('录入电表信息成功！');history.back(); </script>";
				  }else if(($result2==true)&&($status==false)){
					  echo "<script>alert('录入电表状态失败！');history.back(); </script>";
				  }else if(($result2==false)&&($status==true)){
					  echo "<script>alert('录入电表信息失败！');history.back(); </script>";
				  }else if(($result2==false)&&($status==false)){
					  echo "<script>alert('录入电表信息和状态失败！');history.back(); </script>";
				  }else{}
				
				}//EDN IF($result != "")

        }
}
