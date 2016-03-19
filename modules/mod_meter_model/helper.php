<?php
/**
 * @package     electromonitor.com
 * @subpackage  module="mod_meter_model"
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;
//echo "h1--";
class ModMeterModelHelper
{   
    function getMeterModelValues(){
        $db = JFactory::getDBO();
        $query = 'SELECT * FROM joomla3_metermodel order by meter_model_id desc';
        $db->setQuery($query);
        $result = $db->loadAssocList();
		return $result;
		
		//echo "h2--";       
		 
    } 	
} 

?>
