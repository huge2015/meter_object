<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_updata_error
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
 
JHTML::stylesheet('styles.css','modules/mod_updata_error/css/');



$try_time = JRequest::getVar('try_time', '-1');
$error_msg = JRequest::getVar('error_msg', '-1');

$next_time = "";
switch($try_time){
	case "3":
	  $next_time = 30 ; //next try again after 30's 
	  $try_time = 2;  //Set try time for loop by more time
	  break;
    case "2":
	  $next_time = 600 ;//The thrid try again after 10'm
	  $try_time = 1;
	  break;
    case "1":
	  $next_time = 7200 ;//The last try again after 2'h
	  $try_time = 3;     //End loop , set loop again
	  break;
    default:
      break;	
}


$set_time = ModUploadDataErrorHelper::setTryTime($try_time);
//echo "<br>set_time : $set_time";

$get_time = ModUploadDataErrorHelper::getTryTime();
//echo "<br>get_time : $get_time";

  
require(JModuleHelper::getLayoutPath('mod_updata_error', 'default'));
