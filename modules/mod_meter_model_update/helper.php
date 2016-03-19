<?php
/**
 * @package     electromonitor.com
 * @subpackage  mod_meter_model_update
 *
 * @copyright   Copyright (C) 2015 All rights reserved.
 */

defined('_JEXEC') or die;

class ModMeterModelUpdateHelper
{
    function updateMetermodelValues($datetime_change, $meter_model_id, $meter_model, $meter_factory, $command_code, $command_code2, $var_len, $function_code, $storage_start_address, $storage_numbers, $data_index, 

                                         $Ua_hexTodec, $Ua_Float, $Ua_formatNum,$Ua_formula,
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
                                        ) {
                // Create and populate an object.
                $profile = new stdClass();
				$profile->meter_model_id = $meter_model_id;
                $profile->meter_model = $meter_model;
				$profile->meter_factory = $meter_factory;
                $profile->command_code = $command_code;
				$profile->command_code2 = $command_code2;
                $profile->var_len = $var_len;
                //$profile->address_code = $address_code;
				$profile->function_code = $function_code;
				$profile->storage_start_address = $storage_start_address;
				$profile->storage_numbers = $storage_numbers;
				//$profile->check_code = $check_code;
				$profile->data_index = $data_index;
				$profile->datetime_change = $datetime_change;
				
				
				//--U------------------------------------
				$profile->Ua_hexTodec = $Ua_hexTodec;
				$profile->Ua_Float = $Ua_Float;
				$profile->Ua_formatNum = $Ua_formatNum;
				$profile->Ua_formula = $Ua_formula;
				
				$profile->Ub_hexTodec = $Ub_hexTodec;
				$profile->Ub_Float = $Ub_Float;
				$profile->Ub_formatNum = $Ub_formatNum;
				$profile->Ub_formula = $Ub_formula;
				
				$profile->Uc_hexTodec = $Uc_hexTodec;
				$profile->Uc_Float = $Uc_Float;
				$profile->Uc_formatNum = $Uc_formatNum;
				$profile->Uc_formula = $Uc_formula;
				
				//--Uxx------------------------------------
				$profile->U_ab_hexTodec = $U_ab_hexTodec;
				$profile->U_ab_Float = $U_ab_Float;
				$profile->U_ab_formatNum = $U_ab_formatNum;
				$profile->U_ab_formula = $U_ab_formula;
				
				$profile->U_bc_hexTodec = $U_bc_hexTodec;
				$profile->U_bc_Float = $U_bc_Float;
				$profile->U_bc_formatNum = $U_bc_formatNum;
				$profile->U_bc_formula = $U_bc_formula;
				
				$profile->U_ca_hexTodec = $U_ca_hexTodec;
				$profile->U_ca_Float = $U_ca_Float;
				$profile->U_ca_formatNum = $U_ca_formatNum;
				$profile->U_ca_formula = $U_ca_formula;
				
				//--I------------------------------------
				$profile->Ia_hexTodec = $Ia_hexTodec;
				$profile->Ia_Float = $Ia_Float;
				$profile->Ia_formatNum = $Ia_formatNum;
				$profile->Ia_formula = $Ia_formula;
				
				$profile->Ib_hexTodec = $Ib_hexTodec;
				$profile->Ib_Float = $Ib_Float;
				$profile->Ib_formatNum = $Ib_formatNum;
				$profile->Ib_formula = $Ib_formula;
				
				$profile->Ic_hexTodec = $Ic_hexTodec;
				$profile->Ic_Float = $Ic_Float;
				$profile->Ic_formatNum = $Ic_formatNum;
				$profile->Ic_formula = $Ic_formula;
				
				
				//--P------------------------------------
				$profile->Pa_hexTodec = $Pa_hexTodec;
				$profile->Pa_Float = $Pa_Float;
				$profile->Pa_formatNum = $Pa_formatNum;
				$profile->Pa_formula = $Pa_formula;
				
				$profile->Pb_hexTodec = $Pb_hexTodec;
				$profile->Pb_Float = $Pb_Float;
				$profile->Pb_formatNum = $Pb_formatNum;
				$profile->Pb_formula = $Pb_formula;
				
				$profile->Pc_hexTodec = $Pc_hexTodec;
				$profile->Pc_Float = $Pc_Float;
				$profile->Pc_formatNum = $Pc_formatNum;
				$profile->Pc_formula = $Pc_formula;
				
				$profile->Ps_hexTodec = $Ps_hexTodec;
				$profile->Ps_Float = $Ps_Float;
				$profile->Ps_formatNum = $Ps_formatNum;
				$profile->Ps_formula = $Ps_formula;
				
				//--FR------------------------------------
				$profile->FR_hexTodec = $FR_hexTodec;
				$profile->FR_Float = $FR_Float;
				$profile->FR_formatNum = $FR_formatNum;
				$profile->FR_formula = $FR_formula;
				
				
				//--Q------------------------------------
				$profile->Qa_hexTodec = $Qa_hexTodec;
				$profile->Qa_Float = $Qa_Float;
				$profile->Qa_formatNum = $Qa_formatNum;
				$profile->Qa_formula = $Qa_formula;
				
				$profile->Qb_hexTodec = $Qb_hexTodec;
				$profile->Qb_Float = $Qb_Float;
				$profile->Qb_formatNum = $Qb_formatNum;
				$profile->Qb_formula = $Qb_formula;
				
				$profile->Qc_hexTodec = $Qc_hexTodec;
				$profile->Qc_Float = $Qc_Float;
				$profile->Qc_formatNum = $Qc_formatNum;
				$profile->Qc_formula = $Qc_formula;
				
				$profile->Qs_hexTodec = $Qs_hexTodec;
				$profile->Qs_Float = $Qs_Float;
				$profile->Qs_formatNum = $Qs_formatNum;
				$profile->Qs_formula = $Qs_formula;
				
				//--PF------------------------------------
				$profile->PFa_hexTodec = $PFa_hexTodec;
				$profile->PFa_Float = $PFa_Float;
				$profile->PFa_formatNum = $PFa_formatNum;
				$profile->PFa_formula = $PFa_formula;
				
				$profile->PFb_hexTodec = $PFb_hexTodec;
				$profile->PFb_Float = $PFb_Float;
				$profile->PFb_formatNum = $PFb_formatNum;
				$profile->PFb_formula = $PFb_formula;
				
				$profile->PFc_hexTodec = $PFc_hexTodec;
				$profile->PFc_Float = $PFc_Float;
				$profile->PFc_formatNum = $PFc_formatNum;
				$profile->PFc_formula = $PFc_formula;
				
				$profile->PFs_hexTodec = $PFs_hexTodec;
				$profile->PFs_Float = $PFs_Float;
				$profile->PFs_formatNum = $PFs_formatNum;
				$profile->PFs_formula = $PFs_formula;
				
				//--S------------------------------------
				$profile->Sa_hexTodec = $Sa_hexTodec;
				$profile->Sa_Float = $Sa_Float;
				$profile->Sa_formatNum = $Sa_formatNum;
				$profile->Sa_formula = $Sa_formula;
				
				$profile->Sb_hexTodec = $Sb_hexTodec;
				$profile->Sb_Float = $Sb_Float;
				$profile->Sb_formatNum = $Sb_formatNum;
				$profile->Sb_formula = $Sb_formula;
				
				$profile->Sc_hexTodec = $Sc_hexTodec;
				$profile->Sc_Float = $Sc_Float;
				$profile->Sc_formatNum = $Sc_formatNum;
				$profile->Sc_formula = $Sc_formula;
				
				$profile->Ss_hexTodec = $Ss_hexTodec;
				$profile->Ss_Float = $Ss_Float;
				$profile->Ss_formatNum = $Ss_formatNum;
				$profile->Ss_formula = $Ss_formula;
				
				//--Wxx------------------------------------
				$profile->WPP_hexTodec = $WPP_hexTodec;
				$profile->WPP_Float = $WPP_Float;
				$profile->WPP_formatNum = $WPP_formatNum;
				$profile->WPP_formula = $WPP_formula;
				
				$profile->WPN_hexTodec = $WPN_hexTodec;
				$profile->WPN_Float = $WPN_Float;
				$profile->WPN_formatNum = $WPN_formatNum;
				$profile->WPN_formula = $WPN_formula;
				
				$profile->WQP_hexTodec = $WQP_hexTodec;
				$profile->WQP_Float = $WQP_Float;
				$profile->WQP_formatNum = $WQP_formatNum;
				$profile->WQP_formula = $WQP_formula;
				
				$profile->WQN_hexTodec = $WQN_hexTodec;
				$profile->WQN_Float = $WQN_Float;
				$profile->WQN_formatNum = $WQN_formatNum;
				$profile->WQN_formula = $WQN_formula;
				
				//--Exx------------------------------------
				$profile->EPP_hexTodec = $EPP_hexTodec;
				$profile->EPP_Float = $EPP_Float;
				$profile->EPP_formatNum = $EPP_formatNum;
				$profile->EPP_formula = $EPP_formula;
				
				$profile->EPN_hexTodec = $EPN_hexTodec;
				$profile->EPN_Float = $EPN_Float;
				$profile->EPN_formatNum = $EPN_formatNum;
				$profile->EPN_formula = $EPN_formula;
				
				$profile->EQP_hexTodec = $EQP_hexTodec;
				$profile->EQP_Float = $EQP_Float;
				$profile->EQP_formatNum = $EQP_formatNum;
				$profile->EQP_formula = $EQP_formula;
				
				$profile->EQN_hexTodec = $EQN_hexTodec;
				$profile->EQN_Float = $EQN_Float;
				$profile->EQN_formatNum = $EQN_formatNum;
				$profile->EQN_formula = $EQN_formula;

                // Update the object from the user profile table.
                $result = JFactory::getDbo()->updateObject('joomla3_metermodel', $profile, 'meter_model_id');
				if($result==true){
					echo "<script>alert('更新成功！');history.back(); </script>";
				}else{
					echo "<script>alert('更新失败，请重新修改！');history.back(); </script>";
				}

    }
}
