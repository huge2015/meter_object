<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_model_fix
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
 
 //header('Content-type:text/html;charset=utf8');

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

$meter_model_id = trim(JRequest::getVar('meter_model_id', "-1")); 

if($meter_model_id == "-1"){
    echo "<script>alert('请先选择要更新的记录！');history.back(); </script>";
}else{
	
	$result = ModMeterModelFixHelper::getMetermodel($meter_model_id);
	
    /*$sq = "select * from joomla3_metermodel where meter_model_id = '$meter_model_id' ";
	$rst = mysql_query($sq);
	//$rsnum = mysql_num_rows($rst);
    $row = mysql_fetch_array($rst);*/
   
    
	  foreach ($result as $row){	
	  $meter_model = $row['meter_model'];
	  $meter_factory = $row['meter_factory'];
	  $command_code = $row['command_code'];
	  $command_code2 = $row['command_code2'];
	  $var_len = $row['var_len'];
	  //$address_code = $row['address_code'];
	  $function_code = $row['function_code'];
	  $storage_start_address = $row['storage_start_address'];
	  $storage_numbers = $row['storage_numbers'];
	  //$check_code = $row['check_code'];
	  $data_index = $row['data_index'];
	  
	 //-U-----------------
$Ua_hexTodec = $row['Ua_hexTodec'];
$Ua_Float = $row['Ua_Float'];
$Ua_formatNum = $row['Ua_formatNum'];
$Ua_formula = $row['Ua_formula'];

$Ub_hexTodec = $row['Ub_hexTodec'];
$Ub_Float = $row['Ub_Float'];
$Ub_formatNum = $row['Ub_formatNum'];
$Ub_formula = $row['Ub_formula'];

$Uc_hexTodec = $row['Uc_hexTodec'];
$Uc_Float = $row['Uc_Float'];
$Uc_formatNum = $row['Uc_formatNum'];
$Uc_formula = $row['Uc_formula'];

//-U_xx-----------------
$U_ab_hexTodec = $row['U_ab_hexTodec'];
$U_ab_Float = $row['U_ab_Float'];
$U_ab_formatNum = $row['U_ab_formatNum'];
$U_ab_formula = $row['U_ab_formula'];

$U_bc_hexTodec = $row['U_bc_hexTodec'];
$U_bc_Float = $row['U_bc_Float'];
$U_bc_formatNum = $row['U_bc_formatNum'];
$U_bc_formula = $row['U_bc_formula'];

$U_ca_hexTodec = $row['U_ca_hexTodec'];
$U_ca_Float = $row['U_ca_Float'];
$U_ca_formatNum = $row['U_ca_formatNum'];
$U_ca_formula = $row['U_ca_formula'];

//-I-----------------
$Ia_hexTodec = $row['Ia_hexTodec'];
$Ia_Float = $row['Ia_Float'];
$Ia_formatNum = $row['Ia_formatNum'];
$Ia_formula = $row['Ia_formula'];

$Ib_hexTodec = $row['Ib_hexTodec'];
$Ib_Float = $row['Ib_Float'];
$Ib_formatNum = $row['Ib_formatNum'];
$Ib_formula = $row['Ib_formula'];

$Ic_hexTodec = $row['Ic_hexTodec'];
$Ic_Float = $row['Ic_Float'];
$Ic_formatNum = $row['Ic_formatNum'];
$Ic_formula = $row['Ic_formula'];

//-P-----------------
$Pa_hexTodec = $row['Pa_hexTodec'];
$Pa_Float = $row['Pa_Float'];
$Pa_formatNum = $row['Pa_formatNum'];
$Pa_formula = $row['Pa_formula'];

$Pb_hexTodec = $row['Pb_hexTodec'];
$Pb_Float = $row['Pb_Float'];
$Pb_formatNum = $row['Pb_formatNum'];
$Pb_formula = $row['Pb_formula'];

$Pc_hexTodec = $row['Pc_hexTodec'];
$Pc_Float = $row['Pc_Float'];
$Pc_formatNum = $row['Pc_formatNum'];
$Pc_formula = $row['Pc_formula'];

$Ps_hexTodec = $row['Ps_hexTodec'];
$Ps_Float = $row['Ps_Float'];
$Ps_formatNum = $row['Ps_formatNum'];
$Ps_formula = $row['Ps_formula'];

//-FR-----------------
$FR_hexTodec = $row['FR_hexTodec'];
$FR_Float = $row['FR_Float'];
$FR_formatNum = $row['FR_formatNum'];
$FR_formula = $row['FR_formula'];

//-Q-----------------
$Qa_hexTodec = $row['Qa_hexTodec'];
$Qa_Float = $row['Qa_Float'];
$Qa_formatNum = $row['Qa_formatNum'];
$Qa_formula = $row['Qa_formula'];

$Qb_hexTodec = $row['Qb_hexTodec'];
$Qb_Float = $row['Qb_Float'];
$Qb_formatNum = $row['Qb_formatNum'];
$Qb_formula = $row['Qb_formula'];

$Qc_hexTodec = $row['Qc_hexTodec'];
$Qc_Float = $row['Qc_Float'];
$Qc_formatNum = $row['Qc_formatNum'];
$Qc_formula = $row['Qc_formula'];

$Qs_hexTodec = $row['Qs_hexTodec'];
$Qs_Float = $row['Qs_Float'];
$Qs_formatNum = $row['Qs_formatNum'];
$Qs_formula = $row['Qs_formula'];

//-PFx-----------------
$PFa_hexTodec = $row['PFa_hexTodec'];
$PFa_Float = $row['PFa_Float'];
$PFa_formatNum = $row['PFa_formatNum'];
$PFa_formula = $row['PFa_formula'];

$PFb_hexTodec = $row['PFb_hexTodec'];
$PFb_Float = $row['PFb_Float'];
$PFb_formatNum = $row['PFb_formatNum'];
$PFb_formula = $row['PFb_formula'];

$PFc_hexTodec = $row['PFc_hexTodec'];
$PFc_Float = $row['PFc_Float'];
$PFc_formatNum = $row['PFc_formatNum'];
$PFc_formula = $row['PFc_formula'];

$PFs_hexTodec = $row['PFs_hexTodec'];
$PFs_Float = $row['PFs_Float'];
$PFs_formatNum = $row['PFs_formatNum'];
$PFs_formula = $row['PFs_formula'];

//-S-----------------
$Sa_hexTodec = $row['Sa_hexTodec'];
$Sa_Float = $row['Sa_Float'];
$Sa_formatNum = $row['Sa_formatNum'];
$Sa_formula = $row['Sa_formula'];


$Sb_hexTodec = $row['Sb_hexTodec'];
$Sb_Float = $row['Sb_Float'];
$Sb_formatNum = $row['Sb_formatNum'];
$Sb_formula = $row['Sb_formula'];

$Sc_hexTodec = $row['Sc_hexTodec'];
$Sc_Float = $row['Sc_Float'];
$Sc_formatNum = $row['Sc_formatNum'];
$Sc_formula = $row['Sc_formula'];

$Ss_hexTodec = $row['Ss_hexTodec'];
$Ss_Float = $row['Ss_Float'];
$Ss_formatNum = $row['Ss_formatNum'];
$Ss_formula = $row['Ss_formula'];



//-Wxx-----------------
$WPP_hexTodec = $row['WPP_hexTodec'];
$WPP_Float = $row['WPP_Float'];
$WPP_formatNum = $row['WPP_formatNum'];
$WPP_formula = $row['WPP_formula'];


$WPN_hexTodec = $row['WPN_hexTodec'];
$WPN_Float = $row['WPN_Float'];
$WPN_formatNum = $row['WPN_formatNum'];
$WPN_formula = $row['WPN_formula'];


$WQP_hexTodec = $row['WQP_hexTodec'];
$WQP_Float = $row['WQP_Float'];
$WQP_formatNum = $row['WQP_formatNum'];
$WQP_formula = $row['WQP_formula'];



$WQN_hexTodec = $row['WQN_hexTodec'];
$WQN_Float = $row['WQN_Float'];
$WQN_formatNum = $row['WQN_formatNum'];
$WQN_formula = $row['WQN_formula'];


//-Exx-----------------
$EPP_hexTodec = $row['EPP_hexTodec'];
$EPP_Float = $row['EPP_Float'];
$EPP_formatNum = $row['EPP_formatNum'];
$EPP_formula = $row['EPP_formula'];

$EPN_hexTodec = $row['EPN_hexTodec'];
$EPN_Float = $row['EPN_Float'];
$EPN_formatNum = $row['EPN_formatNum'];
$EPN_formula = $row['EPN_formula'];

$EQP_hexTodec = $row['EQP_hexTodec'];
$EQP_Float = $row['EQP_Float'];
$EQP_formatNum = $row['EQP_formatNum'];
$EQP_formula = $row['EQP_formula'];

$EQN_hexTodec = $row['EQN_hexTodec'];
$EQN_Float = $row['EQN_Float'];
$EQN_formatNum = $row['EQN_formatNum'];
$EQN_formula = $row['EQN_formula'];
	  
	  
	  
	  }
	  
	  date_default_timezone_set('Asia/Singapore');
      $datetime = date('Y-m-d H:i:s');
      $datetime_change = $datetime;
 
	 
	   
	   
	require(JModuleHelper::getLayoutPath('mod_meter_model_fix', 'default'));
	
}
?>
