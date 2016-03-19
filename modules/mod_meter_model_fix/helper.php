<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_model_fix
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterModelFixHelper
{
        function getMetermodel($meter_model_id){
                // read electrical status
                $db = JFactory::getDbo();
				$query = "select * from joomla3_metermodel where meter_model_id = '$meter_model_id'";
                /*$query = $db->getQuery(true);
                $query->select('*');
                $query->from($db->quoteName('joomla3_metermodel'));
                $query->where($db->quoteName('meter_model_id')." = ".$meter_model_id);*/

                $db->setQuery($query);
                $result = $db->loadAssocList();
                return $result;
        }
		
		
}
