<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_upload_set
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */


defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';
require_once __DIR__ . '/conn.php';

JHTML::stylesheet('style.css','modules/mod_upload_set/css/');

$data_pos = trim(JRequest::getVar('data_pos', '-1'));
$time_pos = trim(JRequest::getVar('time_pos', '-1'));

$try_time = trim(JRequest::getVar('try_time', '-1'));
$error_msg = trim(JRequest::getVar('error_msg', '-1'));

    date_default_timezone_set('Asia/Singapore');
     $now_time = date('Y-m-d H:i:s');	   
//
require(JModuleHelper::getLayoutPath('mod_upload_set', 'default'));
?>


 

