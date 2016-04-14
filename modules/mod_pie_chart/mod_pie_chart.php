﻿<?php

//jimport('joomla.log.log');
//JLog::addLogger(array());
 
//ini_set('date.timezone','Asia/Singapore');
date_default_timezone_set('Asia/Singapore');

$js = JURI::base().'modules/mod_pie_chart/js/jsapi.js';  
$document = JFactory::getDocument($js);  
$document->addScript($js); 

$zh_CN = JURI::base().'modules/mod_pie_chart/js/format+zh_CN,default+zh_CN,ui+zh_CN,corechart+zh_CN.I.js';  
$document2 = JFactory::getDocument($zh_CN);  
$document2->addScript($zh_CN); 

$corechart = JURI::base().'modules/mod_pie_chart/js/corechart.js';  
$document3 = JFactory::getDocument($corechart);  
$document3->addScript($corechart);



$date = JURI::base().'modules/mod_pie_chart/js/date.js';  
$document4 = JFactory::getDocument($date);  
$document4->addScript($date); 

$jq = JURI::base().'modules/mod_pie_chart/js/jquery-1.9.1.js';  
$document5 = JFactory::getDocument($jq);  
$document5->addScript($jq);




$location_id = trim(JRequest::getVar('location_id', '1')); 
$expression = trim(JRequest::getVar('time_frame', '1-i new')); 
$live_data = trim(JRequest::getVar('live_data', '1')); 
//$from_datetime = trim(JRequest::getVar('time_frame', '1-i new')); 
$to_datetime =  date('Y-m-d H:i:s', (time() + 8*60*60));
 
  
    switch($expression){
		case "5-y new":
			    $Time_interval = '5 years';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 5*365*24*60*60 + 8*60*60) );
				break;
			case '2-y new':
			    $Time_interval = '2 years';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 2*365*24*60*60 + 8*60*60) );
				break;
			case '1-y new':
			    $Time_interval = 'Year';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 365*24*60*60 + 8*60*60) );
				break;
			case '1-q new':
			    $Time_interval = 'Quarter';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 3*30*7*24*60*60 + 8*60*60) );
				break;
            case "1-m new":
			    $Time_interval = 'Month';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 30*24*60*60 + 8*60*60) );
				break;
            case "1-w new":
			    $Time_interval = 'Week';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 7*24*60*60 + 8*60*60) ); 
				break;
			case '1-d new':
			   $Time_interval = 'Day';
			   $from_datetime = date('Y-m-d H:i:s', ( time() - 24*60*60 + 8*60*60) ); 
				break;
            case "1-h new":
			    $Time_interval = 'Hour';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 60*60 + 8*60*60) );
				break;
            case "1-i new":
			    $Time_interval = 'Minute';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 10*60 + 8*60*60) ); 
				break;
            default:
                break;	 
	}

    $db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select( $db->quoteName(array('info_id', 'location_id', 'meter_address') ) ); 
	$query->from( $db->quoteName("#__meter_info_server") );
	$query->where( $db->quoteName('location_id')." = ".$db->quote($location_id) );
	$query->order('meter_address ASC');
	$db->setQuery($query);
	$Inforows = $db->loadAssocList();
        
	$met = 0;
	$mchk = 0;
	$count_Mvalue = 0; //for check Array meter_address is empty
	$M_address = "";  //Format Array [meter_address] ,for upload meter_address by ajax data style, while element jump the next one follow "," 
	unset($Meter);
	unset($MeterName);
	unset($MeterValue);
	unset($meter_address_db);
    foreach($Inforows AS $InfoVaule){
		$Meter[$met] = $InfoVaule['meter_address'];	
		$MeterName[$met] = "Meter".$InfoVaule['meter_address'];
        $MeterValue[$met] = trim(JRequest::getVar("$MeterName[$met]", '-1'));
	    //echo "<br>$MeterName[$met] : $MeterValue[$met]";
		$count_Mvalue = $count_Mvalue + $MeterValue[$met] + 1;  //if $count_Mvalue = 0 Array meter_address is empty
		
		if($MeterValue[$met] == "1"){
			
		    $meter_address_db[$mchk] = $InfoVaule['meter_address'];
			
			if($M_address == ""){
				$M_address = $meter_address_db[$mchk];
			}else{
				$M_address = $M_address."-".$meter_address_db[$mchk];
			}
			
			$mchk++;
		}
		
    $met++;
    }
	
	

	//echo "<br>$count_Mvalue"; 
	if($count_Mvalue == 0){ //while all meter none cheched
		$meter_address_db[0] = $Meter[0];
		$M_address = $Meter[0];
		$mchk++;
	}

	
	
	//var_dump($Meter);
	
?>
 


 
<script type="text/javascript">// <![CDATA[
	chart = null; // global variable
	chartData = null; // global variable
	chartOptions = null; // global variable
	

	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table, 
	// instantiates the pie chart, passes in the data and
	// draws it.
	

	function drawChart() {
		
		// Create the data table.
		chartData = new google.visualization.DataTable(); 
		chartData.addColumn('string', 'Topping');
        chartData.addColumn('number', 'Slices');
  
		
        
		
<?php

    echo "lastRowIndex = chartData.addRows([ ";
	
        unset($energy_kwh);
        for($s = 1; $s < $met; $s++){
			// read electrical status
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime', 'energy_kwh') ) );
			//$query->select('*');   
			$query->from( $db->quoteName('#__electrical') );
			$query->where( 
			            $db->quoteName('location_id')." = ".$db->quote($location_id) .
                        " AND `meter_address` = " . $db->quote($Meter[$s]) 
					);
			$query->order('datetime DESC');
			$db->setQuery($query);
			$rows = $db->loadAssoc();


			
			$energy_kwh[$s] = $rows['energy_kwh']; 
		
	    }//for(query)
		
        
	    $ArrO = 0;
        for ($s = 1; $s < $met; $s++){
			if (!$ArrO) { $ArrO = 1;}
			else {echo  ",";}
			
			echo "[ '".$MeterName[$s]."', ".$energy_kwh[$s]." ]";	
				
		}//for($s)	
	
	echo " ]);";
?>
        
		 
       //alert(JSON.stringify(chartData));
	   
	   // Set chart options
		chartOptions = {'title':'Power of Merters  -  Pie Chart ',
                        'is3D':false,
                        'width':600,
                        'height':500
						};
						
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(chartData, chartOptions);
		//redrawChart();

	} // drawChart()

	

// ]]></script>
<div id="chart_div"> </div>

