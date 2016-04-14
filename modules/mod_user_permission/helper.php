<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_user_permission
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModUserPermissionHelper
{
    function getjoomlaUsers() {
		  // read meter_model values
		   $db = JFactory::getDBO();

          $query = "SELECT id, name, username FROM #__users  where username !=  'admin' order by id desc";
          $db->setQuery($query);
          $Jresult = $db->loadAssocList();
          return $Jresult;
	}
	
	
	public function checkUsers($user_id, $name, $username) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'user_id')));
		$query->from($db->quoteName('#__electrical_user'));
		$query->where("user_id = " . $db->quote($user_id) );
		$query->order('id ASC');
		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
		
		if($num_rows == 0){
			date_default_timezone_set('Asia/Singapore');
            $datetime = date('Y-m-d H:i:s');
            $create_time = $datetime;
			// Create and populate an object.
			$checkUser = new stdClass();
			$checkUser->user_id = $user_id;
			//$checkUser->name = $name;
			//$checkUser->username = $username;
			$checkUser->create_time = $create_time;
				
			$AddUser = JFactory::getDbo()->insertObject('#__electrical_user', $checkUser);
		}
	}
	
/*	
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('`chr`.`characteristic_id`,`chr`.`characteristic_value`,`prc`.`price_value`');
$query->from('`#___hikashop_product` AS `pdt`');
$query->join('inner', '`#__hikashop_variant` AS `vari` ON `pdt`.`product_id` = `vari`.`variant_characteristic_id`');
$query->join('inner', '`#__hikashop_characteristic` AS `chr` ON `vari`.`variant_characteristic_id` = `chr`.`characteristic_id`');
$query->join('inner', '`#__hikashop_price` AS `prc` ON `pdt`.`product_id` = `prc`.`price_product_id`');
$query->where('`pdt`.`product_id` = 68');
$db->setQuery($query);

SELECT Persons.LastName, Persons.FirstName, Orders.OrderNo
FROM Persons
INNER JOIN Orders
ON Persons.Id_P = Orders.Id_P
ORDER BY Persons.LastName
*/	
	 public function getUserValues() {
		 
		// read meter_model values
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('`#__users`.`id`,`#__users`.`name`, `#__users`.`username`, `#__electrical_user`.`user_id`, `#__electrical_user`.`location_id`, `#__electrical_user`.`group_id`, `#__electrical_user`.`create_time`, `#__electrical_user`.`change_time`');
        $query->from('`#__users`');
		$query->join('inner','`#__electrical_user`  ON `#__users`.`id` = `#__electrical_user`.`user_id`');
		$query->order('`#__users`.`id` DESC');
        $db->setQuery($query);
        $result = $db->loadAssocList();
        return $result;
	}
	
	/*
    public function getUser() {
		// read meter_model values
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('id', 'user_id', 'name', 'username', 'location_id', 'create_time', 'change_time', )));
        $query->from($db->quoteName('#__user_permission'));
		$query->order('id DESC');
        $db->setQuery($query);
        $result = $db->loadAssocList();
        return $result;
	}
	*/
	
	

	
	
	public function getFreshTime() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'fresh_time'";
		$db->setQuery($query);
		$row_fresh = $db->loadAssoc();
		
		if($row_fresh == ""){
			
			$fresh_time = 5 ;
		    return $fresh_time ;
	
		}else {
			
			$fresh_time = $row_fresh['var_value'];
		    return $fresh_time ;		
	    }
    }
	public function getWaitTime() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'wait_time'";
		$db->setQuery($query);
		$row_wait = $db->loadAssoc();
		
		if($row_wait == ""){
			
			$wait_time = 1.5 ;
		    return $wait_time ;
	
		}else {
			
			$wait_time = $row_wait['var_value'];
		    return $wait_time ;		
	    }
    }
	
}
