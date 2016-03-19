<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_curl_return
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

//jimport('joomla.log.log');
//JLog::addLogger(array());
 
defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

//JHTML::stylesheet('styles.css','modules/mod_curl_return/css/');

$num_records = JRequest::getVar('num_records', '-1');
echo "num_records is $num_records <br>";

if ($num_records>0) {
	for ($n=0; $n<$num_records; $n++){

		//check record is new
        $queue_id = JRequest::getVar("queue_id-$n");
		$electrical_id = JRequest::getVar("controller_electrical_id-$n");
		//$location_id = JRequest::getVar("location_id-$n");
		//$meter_address = JRequest::getVar("meter_address-$n");
		$datetime = JRequest::getVar("datetime-$n");
		
         JLog::add(JText::_("Before return queue_id: $queue_id || electrical_id : $electrical_id"), JLog::ERROR, 'jerror');
		 
		//delete queue table record
        if($queue_id !=""){
			ModCurlReturnHelper::delQueueData($queue_id);
		}else{
			ModCurlReturnHelper::setDataPos($electrical_id);
            ModCurlReturnHelper::setTimePos($datetime);
		}

	}// for
}//if ($num_records>0) 


require(JModuleHelper::getLayoutPath('mod_curl_return', 'default'));
