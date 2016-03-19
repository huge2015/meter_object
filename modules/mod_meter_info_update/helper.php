<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_update
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterInfoUpdateHelper
{
    function updateMeterInfolValues($datetime_change, $info_id, $location_id, $meter_address, $meter_model, $data_select) {
                
				// read meter_model values
		        $db = JFactory::getDBO();
                $query = $db->getQuery(true);
		        $query->select('*');
		        $query->from($db->quoteName('joomla3_meter_info'));
		        $query->where($db->quoteName('info_id')." != ".$info_id." and ".
				              $db->quoteName('location_id')." = ".$location_id." and ".
				              $db->quoteName('meter_address')." = ".$meter_address);

                      //$query = 'SELECT * FROM joomla3_meter_info WHERE location_id ='.$location_id.' and location_id ='.$location_id;
				
                $db->setQuery($query);
                //$result = $db->loadResult();
				$row = $db->loadAssoc();      
				
            if($row != ""){
					echo " <script>alert('数据库中已存在位置、表地址码相同的记录！ 记录序号：".$result."');history.back(); </script>";
			}else{

				  // Get data source Meter_model ---------------------------------------- 
		          $db = JFactory::getDBO();
                  $query = "SELECT * FROM joomla3_meter_info WHERE info_id = '$info_id' ";
                  $db->setQuery($query);
				  $row_change = $db->loadAssoc();
				  $location_id_old = $row_change['location_id'];
				  $meter_address_old = $row_change['meter_address'];
		          $meter_model_old = $row_change['meter_model'];
				  //echo "<script>alert('原来的型号为：$meter_model_old ');history.back(); </script>";
				  
				  
				  
				if(($meter_model_old != $meter_model) || ($location_id_old != $location_id) || ($meter_address_old != $meter_address)){
				      // Get $status_id ---------------------------------------- 
		              $db = JFactory::getDBO();
					  $query = "SELECT * FROM joomla3_electrical_status WHERE location_id = '$location_id_old' and meter_address = '$meter_address_old'";
                      $db->setQuery($query);
				      $row_status = $db->loadAssoc();
		              $status_id = $row_status['status_id'];
				  
				      if($row_status == ""){ 
				          echo "<script>alert('警告：数据库中没有此电表状态信息！');history.back(); </script>";
				      }else{
                     
					 
					 
				        // if meter_model change set electrical_status  init 0
                        $profile_status = new stdClass();
				        $profile_status->status_id = $status_id;
						$profile_status->location_id = $location_id;
						$profile_status->meter_address = $meter_address;
                        $profile_status->electrical_status = 0 ;
               
                        // Update the object from the user profile table.
                        $status_update = JFactory::getDbo()->updateObject('joomla3_electrical_status', $profile_status, 'status_id');
				      }
				   
				} //if($meter_model_old != $meter_model
				
	
				
			 //Update Create and populate an object-------------------------
                $profile = new stdClass();
				$profile->info_id = $info_id;
                $profile->location_id = $location_id;
				$profile->meter_address = $meter_address;
                $profile->meter_model = $meter_model;
				$profile->data_select = $data_select;
				$profile->datetime_change = $datetime_change;
               
                // Update the object from the user profile table.
                $result = JFactory::getDbo()->updateObject('joomla3_meter_info', $profile, 'info_id');	  
				  
			if($result==true){
				echo "<script>alert('更新成功！');history.back(); </script>";
			}else{
				echo "<script>alert('更新失败，请重新修改！');history.back(); </script>";
			}
				
			}

    }
}
?>