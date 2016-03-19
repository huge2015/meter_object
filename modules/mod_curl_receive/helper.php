<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_electrical
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModCurlReceiveHelper
{
	public static function isDataNew($controller_electrical_id, $location_id, $meter_address) {
		// check if data is new based on controller_electrical_id and location_id
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('electrical_id', 'controller_electrical_id', 'meter_address')));
		$query->from($db->quoteName('joomla3_electrical3'));
		//$query->from($db->quoteName('y3u_electrical'));
		$query->where("controller_electrical_id = " . $db->quote($controller_electrical_id) . " AND "
		      . "location_id =  " . $db->quote($location_id). " AND "
		      . "meter_address =  " . $db->quote($meter_address) );
			  
	    //$query = "SELECT * FROM y3u_electrical WHERE controller_electrical_id = $controller_electrical_id  AND location_id =  $location_id ";		  

		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
	    //$row = $db->loadAssoc();

		if ($num_rows == 0) {
			return 1; // new
		} else {
			return 0; // not new
		}
	}
}
