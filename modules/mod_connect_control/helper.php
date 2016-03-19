<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_connect_control
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

class ModConnectControlHelper
{
    function connectControl() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'connect_status'";
		$db->setQuery($query);
		$row = $db->loadAssoc();
		
        $c_status = $row['var_value'];
        return $c_status;		
    }
}
