<?php 
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_model_update
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */
 
 //header('Content-type:text/html;charset=utf8');

defined('_JEXEC') or die;

// Include the functions only once
require_once __DIR__ . '/helper.php';

$meter_model_id = trim(JRequest::getVar('meter_model_id', '-1')); 

if($meter_model_id == "-1"){
    mysql_close();
    echo "<script>alert('请先修改记录！');history.back(); </script>";
}else{
	  $meter_model = trim(JRequest::getVar('meter_model', '-1'));
	  //$meter_model = trim(JRequest::getVar('meter_model' '-1'));
	  $meter_factory = trim(JRequest::getVar('meter_factory', '-1'));
	  $command_code = trim(JRequest::getVar('command_code', '-1'));
	  $command_code2 = trim(JRequest::getVar('command_code2', '-1'));
	  $var_len = trim(JRequest::getVar('var_len', '-1'));
	  //$address_code = trim(JRequest::getVar('address_code', '-1'));
	  $function_code = trim(JRequest::getVar('function_code', '-1'));
	  $storage_start_address = trim(JRequest::getVar('storage_start_address', '-1'));
	  $storage_numbers = trim(JRequest::getVar('storage_numbers', '-1'));
	  //$check_code = trim(JRequest::getVar('check_code', '-1'));
	  $data_index = trim(JRequest::getVar('data_index', '-1'));
	  
	  
//-U-----------------
$Ua_hexTodec = trim(JRequest::getVar('Ua_hexTodec', '-1'));
$Ua_Float = trim(JRequest::getVar('Ua_Float', '-1'));
$Ua_formatNum = trim(JRequest::getVar('Ua_formatNum', '-1'));
$Ua_formula = trim(JRequest::getVar('Ua_formula', '-1'));

$Ub_hexTodec = trim(JRequest::getVar('Ub_hexTodec', '-1'));
$Ub_Float = trim(JRequest::getVar('Ub_Float', '-1'));
$Ub_formatNum = trim(JRequest::getVar('Ub_formatNum', '-1'));
$Ub_formula = trim(JRequest::getVar('Ub_formula', '-1'));

$Uc_hexTodec = trim(JRequest::getVar('Uc_hexTodec', '-1'));
$Uc_Float = trim(JRequest::getVar('Uc_Float', '-1'));
$Uc_formatNum = trim(JRequest::getVar('Uc_formatNum', '-1'));
$Uc_formula = trim(JRequest::getVar('Uc_formula', '-1'));

//-U_xx-----------------
$U_ab_hexTodec = trim(JRequest::getVar('U_ab_hexTodec', '-1'));
$U_ab_Float = trim(JRequest::getVar('U_ab_Float', '-1'));
$U_ab_formatNum = trim(JRequest::getVar('U_ab_formatNum', '-1'));
$U_ab_formula = trim(JRequest::getVar('U_ab_formula', '-1'));

$U_bc_hexTodec = trim(JRequest::getVar('U_bc_hexTodec', '-1'));
$U_bc_Float = trim(JRequest::getVar('U_bc_Float', '-1'));
$U_bc_formatNum = trim(JRequest::getVar('U_bc_formatNum', '-1'));
$U_bc_formula = trim(JRequest::getVar('U_bc_formula', '-1'));

$U_ca_hexTodec = trim(JRequest::getVar('U_ca_hexTodec', '-1'));
$U_ca_Float = trim(JRequest::getVar('U_ca_Float', '-1'));
$U_ca_formatNum = trim(JRequest::getVar('U_ca_formatNum', '-1'));
$U_ca_formula = trim(JRequest::getVar('U_ca_formula', '-1'));

//-I-----------------
$Ia_hexTodec = trim(JRequest::getVar('Ia_hexTodec', '-1'));
$Ia_Float = trim(JRequest::getVar('Ia_Float', '-1'));
$Ia_formatNum = trim(JRequest::getVar('Ia_formatNum', '-1'));
$Ia_formula = trim(JRequest::getVar('Ia_formula', '-1'));

$Ib_hexTodec = trim(JRequest::getVar('Ib_hexTodec', '-1'));
$Ib_Float = trim(JRequest::getVar('Ib_Float', '-1'));
$Ib_formatNum = trim(JRequest::getVar('Ib_formatNum', '-1'));
$Ib_formula = trim(JRequest::getVar('Ib_formula', '-1'));

$Ic_hexTodec = trim(JRequest::getVar('Ic_hexTodec', '-1'));
$Ic_Float = trim(JRequest::getVar('Ic_Float', '-1'));
$Ic_formatNum = trim(JRequest::getVar('Ic_formatNum', '-1'));
$Ic_formula = trim(JRequest::getVar('Ic_formula', '-1'));

//-P-----------------
$Pa_hexTodec = trim(JRequest::getVar('Pa_hexTodec', '-1'));
$Pa_Float = trim(JRequest::getVar('Pa_Float', '-1'));
$Pa_formatNum = trim(JRequest::getVar('Pa_formatNum', '-1'));
$Pa_formula = trim(JRequest::getVar('Pa_formula', '-1'));

$Pb_hexTodec = trim(JRequest::getVar('Pb_hexTodec', '-1'));
$Pb_Float = trim(JRequest::getVar('Pb_Float', '-1'));
$Pb_formatNum = trim(JRequest::getVar('Pb_formatNum', '-1'));
$Pb_formula = trim(JRequest::getVar('Pb_formula', '-1'));

$Pc_hexTodec = trim(JRequest::getVar('Pc_hexTodec', '-1'));
$Pc_Float = trim(JRequest::getVar('Pc_Float', '-1'));
$Pc_formatNum = trim(JRequest::getVar('Pc_formatNum', '-1'));
$Pc_formula = trim(JRequest::getVar('Pc_formula', '-1'));

$Ps_hexTodec = trim(JRequest::getVar('Ps_hexTodec', '-1'));
$Ps_Float = trim(JRequest::getVar('Ps_Float', '-1'));
$Ps_formatNum = trim(JRequest::getVar('Ps_formatNum', '-1'));
$Ps_formula = trim(JRequest::getVar('Ps_formula', '-1'));

//-FR-----------------
$FR_hexTodec = trim(JRequest::getVar('FR_hexTodec', '-1'));
$FR_Float = trim(JRequest::getVar('FR_Float', '-1'));
$FR_formatNum = trim(JRequest::getVar('FR_formatNum', '-1'));
$FR_formula = trim(JRequest::getVar('FR_formula', '-1'));

//-Q-----------------
$Qa_hexTodec = trim(JRequest::getVar('Qa_hexTodec', '-1'));
$Qa_Float = trim(JRequest::getVar('Qa_Float', '-1'));
$Qa_formatNum = trim(JRequest::getVar('Qa_formatNum', '-1'));
$Qa_formula = trim(JRequest::getVar('Qa_formula', '-1'));

$Qb_hexTodec = trim(JRequest::getVar('Qb_hexTodec', '-1'));
$Qb_Float = trim(JRequest::getVar('Qb_Float', '-1'));
$Qb_formatNum = trim(JRequest::getVar('Qb_formatNum', '-1'));
$Qb_formula = trim(JRequest::getVar('Qb_formula', '-1'));

$Qc_hexTodec = trim(JRequest::getVar('Qc_hexTodec', '-1'));
$Qc_Float = trim(JRequest::getVar('Qc_Float', '-1'));
$Qc_formatNum = trim(JRequest::getVar('Qc_formatNum', '-1'));
$Qc_formula = trim(JRequest::getVar('Qc_formula', '-1'));

$Qs_hexTodec = trim(JRequest::getVar('Qs_hexTodec', '-1'));
$Qs_Float = trim(JRequest::getVar('Qs_Float', '-1'));
$Qs_formatNum = trim(JRequest::getVar('Qs_formatNum', '-1'));
$Qs_formula = trim(JRequest::getVar('Qs_formula', '-1'));

//-PFx-----------------
$PFa_hexTodec = trim(JRequest::getVar('PFa_hexTodec', '-1'));
$PFa_Float = trim(JRequest::getVar('PFa_Float', '-1'));
$PFa_formatNum = trim(JRequest::getVar('PFa_formatNum', '-1'));
$PFa_formula = trim(JRequest::getVar('PFa_formula', '-1'));

$PFb_hexTodec = trim(JRequest::getVar('PFb_hexTodec', '-1'));
$PFb_Float = trim(JRequest::getVar('PFb_Float', '-1'));
$PFb_formatNum = trim(JRequest::getVar('PFb_formatNum', '-1'));
$PFb_formula = trim(JRequest::getVar('PFb_formula', '-1'));

$PFc_hexTodec = trim(JRequest::getVar('PFc_hexTodec', '-1'));
$PFc_Float = trim(JRequest::getVar('PFc_Float', '-1'));
$PFc_formatNum = trim(JRequest::getVar('PFc_formatNum', '-1'));
$PFc_formula = trim(JRequest::getVar('PFc_formula', '-1'));

$PFs_hexTodec = trim(JRequest::getVar('PFs_hexTodec', '-1'));
$PFs_Float = trim(JRequest::getVar('PFs_Float', '-1'));
$PFs_formatNum = trim(JRequest::getVar('PFs_formatNum', '-1'));
$PFs_formula = trim(JRequest::getVar('PFs_formula', '-1'));

//-S-----------------
$Sa_hexTodec = trim(JRequest::getVar('Sa_hexTodec', '-1'));
$Sa_Float = trim(JRequest::getVar('Sa_Float', '-1'));
$Sa_formatNum = trim(JRequest::getVar('Sa_formatNum', '-1'));
$Sa_formula = trim(JRequest::getVar('Sa_formula', '-1'));


$Sb_hexTodec = trim(JRequest::getVar('Sb_hexTodec', '-1'));
$Sb_Float = trim(JRequest::getVar('Sb_Float', '-1'));
$Sb_formatNum = trim(JRequest::getVar('Sb_formatNum', '-1'));
$Sb_formula = trim(JRequest::getVar('Sb_formula', '-1'));

$Sc_hexTodec = trim(JRequest::getVar('Sc_hexTodec', '-1'));
$Sc_Float = trim(JRequest::getVar('Sc_Float', '-1'));
$Sc_formatNum = trim(JRequest::getVar('Sc_formatNum', '-1'));
$Sc_formula = trim(JRequest::getVar('Sc_formula', '-1'));

$Ss_hexTodec = trim(JRequest::getVar('Ss_hexTodec', '-1'));
$Ss_Float = trim(JRequest::getVar('Ss_Float', '-1'));
$Ss_formatNum = trim(JRequest::getVar('Ss_formatNum', '-1'));
$Ss_formula = trim(JRequest::getVar('Ss_formula', '-1'));



//-Wxx-----------------
$WPP_hexTodec = trim(JRequest::getVar('WPP_hexTodec', '-1'));
$WPP_Float = trim(JRequest::getVar('WPP_Float', '-1'));
$WPP_formatNum = trim(JRequest::getVar('WPP_formatNum', '-1'));
$WPP_formula = trim(JRequest::getVar('WPP_formula', '-1'));


$WPN_hexTodec = trim(JRequest::getVar('WPN_hexTodec', '-1'));
$WPN_Float = trim(JRequest::getVar('WPN_Float', '-1'));
$WPN_formatNum = trim(JRequest::getVar('WPN_formatNum', '-1'));
$WPN_formula = trim(JRequest::getVar('WPN_formula', '-1'));


$WQP_hexTodec = trim(JRequest::getVar('WQP_hexTodec', '-1'));
$WQP_Float = trim(JRequest::getVar('WQP_Float', '-1'));
$WQP_formatNum = trim(JRequest::getVar('WQP_formatNum', '-1'));
$WQP_formula = trim(JRequest::getVar('WQP_formula', '-1'));



$WQN_hexTodec = trim(JRequest::getVar('WQN_hexTodec', '-1'));
$WQN_Float = trim(JRequest::getVar('WQN_Float', '-1'));
$WQN_formatNum = trim(JRequest::getVar('WQN_formatNum', '-1'));
$WQN_formula = trim(JRequest::getVar('WQN_formula', '-1'));


//-Exx-----------------
$EPP_hexTodec = trim(JRequest::getVar('EPP_hexTodec', '-1'));
$EPP_Float = trim(JRequest::getVar('EPP_Float', '-1'));
$EPP_formatNum = trim(JRequest::getVar('EPP_formatNum', '-1'));
$EPP_formula = trim(JRequest::getVar('EPP_formula', '-1'));

$EPN_hexTodec = trim(JRequest::getVar('EPN_hexTodec', '-1'));
$EPN_Float = trim(JRequest::getVar('EPN_Float', '-1'));
$EPN_formatNum = trim(JRequest::getVar('EPN_formatNum', '-1'));
$EPN_formula = trim(JRequest::getVar('EPN_formula', '-1'));

$EQP_hexTodec = trim(JRequest::getVar('EQP_hexTodec', '-1'));
$EQP_Float = trim(JRequest::getVar('EQP_Float', '-1'));
$EQP_formatNum = trim(JRequest::getVar('EQP_formatNum', '-1'));
$EQP_formula = trim(JRequest::getVar('EQP_formula', '-1'));

$EQN_hexTodec = trim(JRequest::getVar('EQN_hexTodec', '-1'));
$EQN_Float = trim(JRequest::getVar('EQN_Float', '-1'));
$EQN_formatNum = trim(JRequest::getVar('EQN_formatNum', '-1'));
$EQN_formula = trim(JRequest::getVar('EQN_formula', '-1'));
		
	  date_default_timezone_set('Asia/Singapore');
      $datetime = date('Y-m-d H:i:s');
      $datetime_change = $datetime;
	  
  ModMeterModelUpdateHelper::updateMetermodelValues($datetime_change, $meter_model_id, $meter_model, $meter_factory, $command_code, $command_code2, $var_len,  $function_code, $storage_start_address, $storage_numbers, $data_index, 

 $Ua_hexTodec, $Ua_Float, $Ua_formatNum, $Ua_formula,
 $Ub_hexTodec, $Ub_Float, $Ub_formatNum, $Ub_formula,
 $Uc_hexTodec, $Uc_Float, $Uc_formatNum, $Uc_formula,
 
 $U_ab_hexTodec, $U_ab_Float, $U_ab_formatNum, $U_ab_formula,
 $U_bc_hexTodec, $U_bc_Float, $U_bc_formatNum, $U_bc_formula,
 $U_ca_hexTodec, $U_ca_Float, $U_ca_formatNum, $U_ca_formula,

 $Ia_hexTodec, $Ia_Float, $Ia_formatNum, $Ia_formula,
 $Ib_hexTodec, $Ib_Float, $Ib_formatNum, $Ib_formula,
 $Ic_hexTodec, $Ic_Float, $Ic_formatNum, $Ic_formula,

 $Pa_hexTodec, $Pa_Float, $Pa_formatNum, $Pa_formula,
 $Pb_hexTodec, $Pb_Float, $Pb_formatNum, $Pb_formula,
 $Pc_hexTodec, $Pc_Float, $Pc_formatNum, $Pc_formula,
 $Ps_hexTodec, $Ps_Float, $Ps_formatNum, $Ps_formula,

 $FR_hexTodec, $FR_Float, $FR_formatNum, $FR_formula,
 
 $Qa_hexTodec, $Qa_Float, $Qa_formatNum, $Qa_formula,
 $Qb_hexTodec, $Qb_Float, $Qb_formatNum, $Qb_formula,
 $Qc_hexTodec, $Qc_Float, $Qc_formatNum, $Qc_formula,
 $Qs_hexTodec, $Qs_Float, $Qs_formatNum, $Qs_formula,

 $PFa_hexTodec, $PFa_Float, $PFa_formatNum, $PFa_formula,
 $PFb_hexTodec, $PFb_Float, $PFb_formatNum, $PFb_formula,
 $PFc_hexTodec, $PFc_Float, $PFc_formatNum, $PFc_formula,
 $PFs_hexTodec, $PFs_Float, $PFs_formatNum, $PFs_formula,
 
 $Sa_hexTodec, $Sa_Float, $Sa_formatNum, $Sa_formula,
 $Sb_hexTodec, $Sb_Float, $Sb_formatNum, $Sb_formula,
 $Sc_hexTodec, $Sc_Float, $Sc_formatNum, $Sc_formula,
 $Ss_hexTodec, $Ss_Float, $Ss_formatNum, $Ss_formula,

 $WPP_hexTodec, $WPP_Float, $WPP_formatNum, $WPP_formula,
 $WPN_hexTodec, $WPN_Float, $WPN_formatNum, $WPN_formula,
 $WQP_hexTodec, $WQP_Float, $WQP_formatNum, $WQP_formula,
 $WQN_hexTodec, $WQN_Float, $WQN_formatNum, $WQN_formula,
 
 $EPP_hexTodec, $EPP_Float, $EPP_formatNum, $EPP_formula,
 $EPN_hexTodec, $EPN_Float, $EPN_formatNum, $EPN_formula,
 $EQP_hexTodec, $EQP_Float, $EQP_formatNum, $EQP_formula,
 $EQN_hexTodec, $EQN_Float, $EQN_formatNum, $EQN_formula
);
	  

  
	require(JModuleHelper::getLayoutPath('mod_meter_model_update', 'default'));
	
}
?>