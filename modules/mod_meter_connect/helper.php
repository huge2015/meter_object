<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_connect
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModDianbiaoHelper
{
    function crc16($string) {
      $crc = 0xFFFF;
      for ($x = 0; $x < strlen ($string); $x++) {
          $crc = $crc ^ ord($string[$x]);
        for ($y = 0; $y < 8; $y++) {
            if (($crc & 0x0001) == 0x0001) {
              $crc = (($crc >> 1) ^ 0xA001);
            } else { $crc = $crc >> 1; }
        }
      }
      return $crc;
    }
    //$s = pack('H*', '010300090002');
    //$t = crc16($s);
    //printf('=%02x%02x', $t%256, floor($t/256));  //14 09
	//$cs=sprintf('%02x%02x', $t%256, floor($t/256));
    //echo $cs;
	
	public function trimall($str)//删除空格
    {
        $qian=array(" ","　","\t","\n","\r");
		$hou=array("","","","","");
        return str_replace($qian,$hou,$str);    
    }
	
	public function convert_code($str){
      $str1 = substr($str,0,2);
      $str2 = substr($str,2,2);
	  $allstr = $str1." ".$str2;
	  return $allstr;
    }
	
	public function hexStringTo32Float($strHex) {
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
	    return $string;
	}
	
	public function getCheckStatus() {
		// read electrical status
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_electrical_status WHERE  electrical_status = 1 ";
		$db->setQuery($query);
		$row = $db->loadResult();
		return $row;
	}
	
	public function getSessionStatus() {
		  // read MeterModelValus
		  $db = JFactory::getDBO();
          $query = "SELECT * FROM joomla3_session_status  ";
          $db->setQuery($query);
          $row_session = $db->loadAssoc();
		  $session = $row_session['session'];
		  return $session;
      
	}

	public function getElectricalStatus($location_id, $meter_address) {
		// read electrical status
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_electrical_status WHERE location_id = '$location_id' and meter_address = '$meter_address' ";
		$db->setQuery($query);
		//$row = $db->loadAssoc();
        $row = $db->loadAssocList();
		
		//$electrical_status = $row['electrical_status'];
		//return $electrical_status;
		return $row;
	}
	
	public function getMeterModelValus($meter_model) {
		  // read MeterModelValus
		  $db = JFactory::getDBO();
          $query = "SELECT meter_model, function_code, command_code, command_code2, data_index FROM joomla3_metermodel where meter_model = '$meter_model'";
          $db->setQuery($query);
          $result = $db->loadAssocList(); 
		  
		  return $result;
          /*foreach($result as $row)
          {
            // echo ' id is '.$row->meter_model_id.' meter_model is ' . $row->meter_model .'<br/>';
          }*/
	}
	
	public function getMeterInfoValus($info_id) {
		  // read MeterModelValus
		  $db = JFactory::getDBO();
          $query = "SELECT * FROM joomla3_meter_info where info_id = '$info_id' ";
          $db->setQuery($query);
          $rs_info = $db->loadAssocList(); 
		  
		  return $rs_info;
          
	}
	
	
	public function getElectricalValues($meter_address) {
		  // read MeterModelValus
		  $db = JFactory::getDBO();
          $query = "SELECT * FROM joomla3_electrical WHERE meter_address = $meter_address order by electrical_id Desc limit 1";
          $db->setQuery($query);
          $result = $db->loadAssocList(); 
		  
		  return $result;
          /*foreach($result as $row)
          {
            // echo ' id is '.$row->meter_model_id.' meter_model is ' . $row->meter_model .'<br/>';
          }*/
	}
	
	public function insertElectricalValues($datetime, $location_id, $meter_address, $u1, $i1, $p1, $f1, $u2, $i2, $p2, $f2, $u3, $i3, $p3, $f3, $pE, $Ep1) {
		// Create and populate an object.
		$profile = new stdClass();
		$profile->location_id = $location_id;
		$profile->meter_address = $meter_address;
		$profile->datetime = $datetime;
		
		$profile->phase1_voltage = $u1;
		$profile->phase1_current = $i1;
		$profile->phase1_apparent_power = $p1;
		$profile->phase1_frequency = $f1;
		
		$profile->phase2_voltage = $u2;
		$profile->phase2_current = $i2;
		$profile->phase2_apparent_power = $p2;
		$profile->phase2_frequency = $f2;
		
		$profile->phase3_voltage = $u3;
		$profile->phase3_current = $i3;
		$profile->phase3_apparent_power = $p3;
		$profile->phase3_frequency = $f3;
		
		$profile->total_power = $pE;
		$profile->energy_kwh = $Ep1;

		// Insert the object into the user profile table.
		$result = JFactory::getDbo()->insertObject('joomla3_electrical', $profile);

	}
	
	public function checkFreshTime($time) {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'fresh_time'";
		$db->setQuery($query);
		$row_fresh = $db->loadAssoc();
		

		if($row_fresh == ""){
			
            $var_name = "fresh_time";
			
			if ($time == "-1"){ $var_value = 5 ;}else{ $var_value = $time ;}
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if fresh_time is  null
            $profile_fresh = new stdClass();
			$profile_fresh->var_name = $var_name;
			$profile_fresh->var_value = $var_value;
			$profile_fresh->create_time = $create_time;
               
            // Update the object from the user profile table.
            $fresh_update = JFactory::getDbo()->insertObject('joomla3_varitely', $profile_fresh);
			
			//return the insert  var_value
			return $var_value;
			
		}else if(($row_fresh != "")&&($time == "-1")){
			
			$fresh_time = $row_fresh['var_value'];
		    return $fresh_time ;
			
		}else{
			
			$var_name = "fresh_time";
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
			
			// Put var  fresh_time into table 
            $profile_fresh = new stdClass();
			$profile_fresh->var_name = $var_name;
			$profile_fresh->var_value = $time;
			$profile_fresh->change_time = $change_time;
               
            // Update the object from the user profile table.
            $fresh_update = JFactory::getDbo()->updateObject('joomla3_varitely', $profile_fresh, 'var_name');
			return $time;
		}
	}
	
	public function checkWaitTime($wait_time) {
		// read wait_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'wait_time'";
		$db->setQuery($query);
		$row_wait = $db->loadAssoc();
		

		if($row_wait == ""){
			
            $var_name = "wait_time";
			
			if ($wait_time == "-1"){ $var_value = 1.5 ;}else{ $var_value = $wait_time ;}
			
            date_default_timezone_set('Asia/Singapore');
            $create_time = date('Y-m-d H:i:s');	
			
			// if wait_time is  null
            $profile_wait = new stdClass();
			$profile_wait->var_name = $var_name;
			$profile_wait->var_value = $var_value;
			$profile_wait->create_time = $create_time;
               
            // Update the object from the user profile table.
            $wait_update = JFactory::getDbo()->insertObject('joomla3_varitely', $profile_wait);
			
			//return the insert  var_value
			return $var_value;
			
		}else if(($row_wait != "")&&($wait_time == "-1")){
			
			$wait_time = $row_wait['var_value'];
		    return $wait_time ;
			
		}else{
			
			$var_name = "wait_time";
			
            date_default_timezone_set('Asia/Singapore');
            $change_time = date('Y-m-d H:i:s');	
			
			// Put var  wait_time into table 
            $profile_wait = new stdClass();
			$profile_wait->var_name = $var_name;
			$profile_wait->var_value = $wait_time;
			$profile_wait->change_time = $change_time;
               
            // Update the object from the user profile table.
            $wait_update = JFactory::getDbo()->updateObject('joomla3_varitely', $profile_wait, 'var_name');
			return $wait_time;
		}
	}
	
	
	public function connectControl() {
		// read fresh_time value
		$db = JFactory::getDbo();
		$query = "SELECT * FROM joomla3_varitely WHERE var_name = 'connect_status'";
		$db->setQuery($query);
		$row = $db->loadAssoc();
		
        $c_status = $row['var_value'];
        return $c_status;		
    }
	
	
	
	
	public function getDataSelectValues($data_select) {
		//echo "start get getMeterInfoValus:<br>";
        if ($data_select == ""){
			$data_select = "Ua, Ub, Uc, U_ab, U_bc, U_ca, Ia, Ib, Ic, Pa, Pb, Pc, Ps, F, Qa, Qb, Qc, Qs, PFa, PFb, PFc, PFs, Sa, Sb, Sc, Ss, WPP, WPN, WQP, WQN, EPP, EPN, EQP,EQN";
		};
		unset ($returnArr);
	  	//explode $data_select    //example :$data_select = "u1,u2,u3,i1"; 
	  	$selArr=explode(',',$data_select); 
	  	$sel_num = sizeof($selArr); //cout array numbers or // $sel_num = count(selArr);
	  	$sel_var = "";
	  	for($l = 0; $l<$sel_num ; $l++){
       	 	//echo $l.':'.$selArr[$l].'<br/>';
			$sel_var = $sel_var.$selArr[$l];
			//return $sel_var;
	  	}
       
	    //U -------------------------------------------- 
    	$sel_Ua =  strstr($sel_var, 'Ua');  
    	if( ($sel_Ua != "") && ($data_select != "") ){
			   $sel_Ua = 1 ;
			   $returnArr["sel_Ua"] = $sel_Ua;
		} 
		$sel_Ub =  strstr($sel_var, 'Ub');
    	if( ($sel_Ub != "") && ($data_select != "") ){
			   $sel_Ub = 1 ;
			   $returnArr["sel_Ub"] = $sel_Ub;
		} 
    	$sel_Uc =  strstr($sel_var, 'Uc');
    	if( ($sel_Uc != "") && ($data_select != "") ){
			   $sel_Uc = 1 ;
			   $returnArr["sel_Uc"] = $sel_Uc;
		} 
		
		
		//Uxx -------------------------------------------- 
    	$sel_U_ab =  strstr($sel_var, 'U_ab');  
    	if( ($sel_U_ab != "") && ($data_select != "") ){
			   $sel_U_ab = 1 ;
			   $returnArr["sel_U_ab"] = $sel_U_ab;
		} 
		$sel_U_bc =  strstr($sel_var, 'U_bc');
    	if( ($sel_U_bc != "") && ($data_select != "") ){
			   $sel_U_bc = 1 ;
			   $returnArr["sel_U_bc"] = $sel_U_bc;
		} 
    	$sel_U_ca =  strstr($sel_var, 'U_ca');
    	if( ($sel_U_ca != "") && ($data_select != "") ){
			   $sel_U_ca = 1 ;
			   $returnArr["sel_U_ca"] = $sel_U_ca;
		} 
		
		
		//i --------------------------------------------- 
		$sel_Ia =  strstr($sel_var, 'Ia');   
    	if( ($sel_Ia != "") && ($data_select != "") ){
			   $sel_Ia = 1 ;
			   $returnArr["sel_Ia"] = $sel_Ia;
		} 
		$sel_Ib =  strstr($sel_var, 'Ib');
    	if( ($sel_Ib != "") && ($data_select != "") ){
			   $sel_Ib = 1 ;
			   $returnArr["sel_Ib"] = $sel_Ib;
		} 
    	$sel_Ic =  strstr($sel_var, 'Ic');
    	if( ($sel_Ic != "") && ($data_select != "") ){
			   $sel_Ic = 1 ;
			   $returnArr["sel_Ic"] = $sel_Ic;
		} 
	
	    //P -------------------------------------------- 
		$sel_Pa =  strstr($sel_var, 'Pa');  
    	if( ($sel_Pa != "") && ($data_select != "") ){ 
			   $sel_Pa = 1 ;
			   $returnArr["sel_Pa"] = $sel_Pa;
		} 
		$sel_Pb =  strstr($sel_var, 'Pb');
    	if( ($sel_Pb != "") && ($data_select != "") ){
			   $sel_Pb = 1 ;
			   $returnArr["sel_Pb"] = $sel_Pb;
		} 
    	$sel_Pc =  strstr($sel_var, 'Pc');
    	if( ($sel_Pc != "") && ($data_select != "") ){ 
			   $sel_Pc = 1 ;
			   $returnArr["sel_Pc"] = $sel_Pc;
		}	
		$sel_Ps =  strstr($sel_var, 'Ps');    //pE /Ps
    	if( ($sel_Ps != "") && ($data_select != "") ){
			   $sel_Ps = 1 ;
			   $returnArr["sel_Ps"] = $sel_Ps;
		} 
		
		
		//F ----------------------------------------------
		$sel_F =  strstr($sel_var, 'F');   
    	if( ($sel_F != "") && ($data_select != "") ){
			   $sel_F = 1 ;
			   $returnArr["sel_F"] = $sel_F;
		} 
		
		
		//Q ----------------------------------------------
		$sel_Qa =  strstr($sel_var, 'Qa');   
    	if( ($sel_Qa != "") && ($data_select != "") ){
			   $sel_Qa = 1 ;
			   $returnArr["sel_Qa"] = $sel_Qa;
		} 
		$sel_Qb =  strstr($sel_var, 'Qb');
    	if( ($sel_Qb != "") && ($data_select != "") ){
			   $sel_Qb = 1 ;
			   $returnArr["sel_Qb"] = $sel_Qb;
		} 
    	$sel_Qc =  strstr($sel_var, 'Qc');
    	if( ($sel_Qc != "") && ($data_select != "") ){
			   $sel_Qc = 1 ;
			   $returnArr["sel_Qc"] = $sel_Qc;
		}
		$sel_Qs =  strstr($sel_var, 'Qs');
    	if( ($sel_Qs != "") && ($data_select != "") ){
			   $sel_Qs = 1 ;
			   $returnArr["sel_Qs"] = $sel_Qs;
		}
		
		
		//PF ----------------------------------------------
		$sel_PFa =  strstr($sel_var, 'PFa');   
    	if( ($sel_PFa != "") && ($data_select != "") ){
			   $sel_PFa = 1 ;
			   $returnArr["sel_PFa"] = $sel_PFa;
		} 
		$sel_PFb =  strstr($sel_var, 'PFb');
    	if( ($sel_PFb != "") && ($data_select != "") ){
			   $sel_PFb = 1 ;
			   $returnArr["sel_PFb"] = $sel_PFb;
		} 
    	$sel_PFc =  strstr($sel_var, 'PFc');
    	if( ($sel_PFc != "") && ($data_select != "") ){
			   $sel_PFc = 1 ;
			   $returnArr["sel_PFc"] = $sel_PFc;
		}
		$sel_PFs =  strstr($sel_var, 'PFs');
    	if( ($sel_PFs != "") && ($data_select != "") ){
			   $sel_PFs = 1 ;
			   $returnArr["sel_PFs"] = $sel_PFs;
		}
		
		
		//S ----------------------------------------------
		$sel_Sa =  strstr($sel_var, 'Sa');   
    	if( ($sel_Sa != "") && ($data_select != "") ){
			   $sel_Sa = 1 ;
			   $returnArr["sel_Sa"] = $sel_Sa;
		} 
		$sel_Sb =  strstr($sel_var, 'Sb');
    	if( ($sel_Sb != "") && ($data_select != "") ){
			   $sel_Sb = 1 ;
			   $returnArr["sel_Sb"] = $sel_Sb;
		} 
    	$sel_Sc =  strstr($sel_var, 'Sc');
    	if( ($sel_Sc != "") && ($data_select != "") ){
			   $sel_Sc = 1 ;
			   $returnArr["sel_Sc"] = $sel_Sc;
		}
		$sel_Ss =  strstr($sel_var, 'Ss');
    	if( ($sel_Ss != "") && ($data_select != "") ){
			   $sel_Ss = 1 ;
			   $returnArr["sel_Ss"] = $sel_Ss;
		}
		
		
		//Wxx ----------------------------------------------
		$sel_WPP =  strstr($sel_var, 'WPP');   
    	if( ($sel_WPP != "") && ($data_select != "") ){
			   $sel_WPP = 1 ;
			   $returnArr["sel_WPP"] = $sel_WPP;
		} 
		$sel_WPN =  strstr($sel_var, 'WPN');
    	if( ($sel_WPN != "") && ($data_select != "") ){
			   $sel_WPN = 1 ;
			   $returnArr["sel_WPN"] = $sel_WPN;
		} 
    	$sel_WQP =  strstr($sel_var, 'WQP');
    	if( ($sel_WQP != "") && ($data_select != "") ){
			   $sel_WQP = 1 ;
			   $returnArr["sel_WQP"] = $sel_WQP;
		}
		$sel_WQN =  strstr($sel_var, 'WQN');
    	if( ($sel_WQN != "") && ($data_select != "") ){
			   $sel_WQN = 1 ;
			   $returnArr["sel_WQN"] = $sel_WQN;
		}
		
		
		//Exx ----------------------------------------------
		$sel_EPP =  strstr($sel_var, 'EPP');   
    	if( ($sel_EPP != "") && ($data_select != "") ){
			   $sel_EPP = 1 ;
			   $returnArr["sel_EPP"] = $sel_EPP;
		} 
		$sel_EPN =  strstr($sel_var, 'EPN');
    	if( ($sel_EPN != "") && ($data_select != "") ){
			   $sel_EPN = 1 ;
			   $returnArr["sel_EPN"] = $sel_EPN;
		} 
    	$sel_EQP =  strstr($sel_var, 'EQP');
    	if( ($sel_EQP != "") && ($data_select != "") ){
			   $sel_EQP = 1 ;
			   $returnArr["sel_EQP"] = $sel_EQP;
		}
		$sel_EQN =  strstr($sel_var, 'EQN');
    	if( ($sel_EQN != "") && ($data_select != "") ){
			   $sel_EQN = 1 ;
			   $returnArr["sel_EQN"] = $sel_EQN;
		}
		
		//if (in_array("u1", $selArr, true)) {
         	//echo "Got u1";
		//}
		
		return $returnArr;
	}
	
	
	
	public function getModelKeyCode_2($all_output) {
		
		// get YG194E-3SY return code  model_key == 2
		
		$p_u =  $all_output[3];  //Power of U
		$p_i =  $all_output[4];  //Power of I
		$p_s =  $all_output[5];  //Power of P
		$p_E =  $all_output[6];  //Power of E

		$hex_u1 =  $all_output[7] . $all_output[8];      //Ua
		$hex_u2 =  $all_output[9] . $all_output[10];     //Ub
		$hex_u3 =  $all_output[11] . $all_output[12];  //Uc

		$hex_Uab =  $all_output[13] . $all_output[14];  //Uab
		$hex_Ubc =  $all_output[15] . $all_output[16];  //Ubc
		$hex_Uca =  $all_output[17] . $all_output[18];  //Uca

		$hex_i1 =  $all_output[19] . $all_output[20];  //Ia
		$hex_i2 =  $all_output[21] . $all_output[22];  //Ib
		$hex_i3 =  $all_output[23] . $all_output[24];  //Ic

		$hex_p1 = $all_output[25] . $all_output[26];  //Pa
		$hex_p2 = $all_output[27] . $all_output[28];  //Pb
		$hex_p3 = $all_output[29] . $all_output[30];  //Pc

		$hex_pE = $all_output[31] . $all_output[32];  //Ps\pE

		$hex_Qa = $all_output[33] . $all_output[34];  //Qa
		$hex_Qb = $all_output[35] . $all_output[36];  //Qb
		$hex_Qc = $all_output[37] . $all_output[38];  //Qc

		$hex_Qs = $all_output[39] . $all_output[40];  //Qs

		$hex_PFa = $all_output[41] . $all_output[42];  //PFa
		$hex_PFb = $all_output[43] . $all_output[44];  //PFb
		$hex_PFc = $all_output[45] . $all_output[46];  //PFc

		$hex_PFs = $all_output[47] . $all_output[48];  //PFs

		$hex_Sa = $all_output[49] . $all_output[50];  //Sa
		$hex_Sb = $all_output[51] . $all_output[52];  //Sb
		$hex_Sc = $all_output[53] . $all_output[54];  //Sc

		$hex_Ss = $all_output[55] . $all_output[56];  //Ss

		$hex_FR = $all_output[57] . $all_output[58];  //FR

		$hex_WPP = $all_output[59] . $all_output[60] . $all_output[61] . $all_output[62];  //WPP
		$hex_WPN = $all_output[63] . $all_output[64] . $all_output[65] . $all_output[66];  //WPN
		$hex_WQP = $all_output[67] . $all_output[68] . $all_output[69] . $all_output[70] ;  //WQP
		$hex_WQN = $all_output[71] . $all_output[72] . $all_output[73] . $all_output[74] ;  //WQN

		$hex_Ep1 = $all_output[75] . $all_output[76] . $all_output[77] . $all_output[78];  //EPP \ Ep+
		$hex_Ep2 = $all_output[79] . $all_output[80] . $all_output[81] . $all_output[82];  //EPN \ Ep-
		$hex_EQP = $all_output[83] . $all_output[84] . $all_output[85] . $all_output[86];  //EQP
		$hex_EQN = $all_output[87] . $all_output[88] . $all_output[89] . $all_output[90];  //EQN
 
	

	}
	
	
	
	
}//class
