<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_updata_pos
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
 
JHTML::stylesheet('styles.css','modules/mod_updata_pos/css/');


$data_pos = JRequest::getVar('data_pos', '-1');
$time_pos = JRequest::getVar('time_pos', '-1');

  ModUpdataHelper::setDataPos($data_pos);
  ModUpdataHelper::setTimePos($time_pos);
  ModUpdataHelper::setTryTime();
  
require(JModuleHelper::getLayoutPath('mod_updata_pos', 'default'));
