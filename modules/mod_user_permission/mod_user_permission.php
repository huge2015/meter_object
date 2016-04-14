<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_user_permission
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */


defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';

JHTML::stylesheet('style.css','modules/mod_user_permission/css/');

$Jresult = ModUserPermissionHelper::getjoomlaUsers();
    foreach($Jresult AS $Jrows){
	    $user_id = $Jrows['id'];
		$name = $Jrows['name'];
		$username = $Jrows['username'];
		
		$Chkres = ModUserPermissionHelper::checkUsers($user_id, $name, $username);
		
    }

    $result = ModUserPermissionHelper::getUserValues();
//
require(JModuleHelper::getLayoutPath('mod_user_permission', 'default'));
?>


 

