<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_param
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */


defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';

JHTML::stylesheet('style.css','modules/mod_param/css/');

@$fresh_time = ModMeterInfoHelper::getFreshTime($get_time);
@$wait_time = ModMeterInfoHelper::getWaitTime($wait_time);
@$record_num = ModMeterInfoHelper::getRecordNum($record_num);

//$result = ModMeterInfoHelper::getMeterStatus($location_id, $meter_address);

//
require(JModuleHelper::getLayoutPath('mod_param', 'default'));
?>


 

