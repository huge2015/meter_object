<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_uploaddata
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
//jimport('joomla.log.log');
//JLog::addLogger(array());

 //JLog::add(JText::_("uploaddata init!"), JLog::ERROR, 'jerror');

defined('_JEXEC') or die;


// Include the functions only once
require_once __DIR__ . '/helper.php';

require(JModuleHelper::getLayoutPath('mod_uploaddata', 'default'));