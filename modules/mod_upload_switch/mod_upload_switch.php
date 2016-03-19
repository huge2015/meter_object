<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_switch
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
//error_reporting( E_ALL&~E_NOTICE );
defined('_JEXEC') or die;
//sleep(0.5);
// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';
sleep(0.3);


JHTML::stylesheet('styles.css','modules/mod_upload_switch/css/');


    $action_key = JRequest::getVar('action_key', '-1');
    if($action_key == "-1"){

       $UploadStatus = ModUploadSwitchHelper::getUploadStatus();
    }else{
	
	   $UploadStatus = ModUploadSwitchHelper::setUploadStatus($action_key);
    }


    if($UploadStatus == ""){$UploadStatus = "close";}
	//if($UploadStatus == "start"){$lines = file("http://127.0.0.1/joomla/index.php/upload-excute");}
   
    date_default_timezone_set('Asia/Singapore');
    $Upload_Status_time = date('Y-m-d H:i:s');

require(JModuleHelper::getLayoutPath('mod_upload_switch', 'control'));




//require(JModuleHelper::getLayoutPath('mod_upload_switch', 'default'));
    
  



//sleep(5);
//$session = ModUploadSwitchHelper::getSessionStatus();
//}while($session == "1");

	
// Fresh_page script----------------------------------------------*/	
/*
$fresh_time = $fresh_time * 1000 ;
echo ("<script type=\"text/javascript\">");
echo ("function fresh_page()");    
echo ("{");
echo ("window.location.reload();");
echo ("}"); 
echo ("setTimeout('fresh_page()',".$fresh_time.");");      
echo ("</script>");
*/


?>