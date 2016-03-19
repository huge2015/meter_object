<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_info_fix
 *
 * @copyright   Copyright (C) 2016 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterInfoHelper
{

        function hexStringTo32Float($strHex) {
            $v = hexdec($strHex);
            $x = ($v & ((1 << 23) - 1)) + (1 << 23) * ($v >> 31 | 1);
            $exp = ($v >> 23 & 0xFF) - 127;
            return $x * pow(2, $exp - 23);
        }

        public function String2Hex($string){
            $hex='';
            for ($i=0; $i < strlen($string); $i++){
                $hex .= dechex(ord($string[$i]));
            }
            return $hex;
        }


        public function Hex2String($hex){
            $string='';
            for ($i=0; $i < strlen($hex)-1; $i+=2){
                $string .= chr(hexdec($hex[$i].$hex[$i+1]));
            }
		}
		
		public function getElectricalStatus() {
		  // read electrical status
		    $db = JFactory::getDbo();
		    $query = $db->getQuery(true);
		    $query->select('electrical_status');
		    $query->from($db->quoteName('joomla3_electrical_status'));
		    $query->where($db->quoteName('location_id')." = ".$db->quote(1));

		    $db->setQuery($query);
		    $row = $db->loadAssoc();

		    $electrical_status = $row['electrical_status'];
		    return $electrical_status;
	    }
		
        public function getMeterInfoValues($info_id){
			// read meter_model values
			$db = JFactory::getDBO();
			$query = $db -> getQuery(true);
			$query -> select('*');
			$query -> from($db->quoteName('joomla3_meter_info'));
			$query -> where($db->quoteName('info_id')." = ".$info_id );
			$db -> setQuery($query);
			$result = $db->loadAssocList();  
            return $result;
		}
		
}
