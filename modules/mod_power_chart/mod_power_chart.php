﻿<?php

$js = JURI::base().'modules/mod_power_chart/js/jsapi.js';  
$document = JFactory::getDocument($js);  
$document->addScript($js); 

$zh_CN = JURI::base().'modules/mod_power_chart/js/format+zh_CN,default+zh_CN,ui+zh_CN,corechart+zh_CN.I.js';  
$document2 = JFactory::getDocument($zh_CN);  
$document2->addScript($zh_CN); 

$corechart = JURI::base().'modules/mod_power_chart/js/corechart.js';  
$document3 = JFactory::getDocument($corechart);  
$document3->addScript($corechart);



$date = JURI::base().'modules/mod_power_chart/js/date.js';  
$document4 = JFactory::getDocument($date);  
$document4->addScript($date); 

$jq = JURI::base().'modules/mod_power_chart/js/jquery-1.9.1.js';  
$document5 = JFactory::getDocument($jq);  
$document5->addScript($jq);

date_default_timezone_set('ASIA/Singapore');


$location_id = trim(JRequest::getVar('location_id', '1')); 
$expression = trim(JRequest::getVar('time_frame', '1-i new')); 
$live_data = trim(JRequest::getVar('live_data', '1')); 
//$from_datetime = trim(JRequest::getVar('time_frame', '1-i new')); 
$to_datetime = $to_datetime = date('Y-m-d H:i:s');
 
  
    switch($expression){
		case "5-y new":
			    $Time_interval = '5 years';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 5*365*24*60*60) );
				break;
			case '2-y new':
			    $Time_interval = '2 years';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 2*365*24*60*60) );
				break;
			case '1-y new':
			    $Time_interval = 'Year';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 365*24*60*60) );
				break;
			case '1-q new':
			    $Time_interval = 'Quarter';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 3*30*7*24*60*60) );
				break;
            case "1-m new":
			    $Time_interval = 'Month';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 30*24*60*60) );
				break;
            case "1-w new":
			    $Time_interval = 'Week';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 7*24*60*60) ); 
				break;
			case '1-d new':
			   $Time_interval = 'Day';
			   $from_datetime = date('Y-m-d H:i:s', ( time() - 24*60*60) ); 
				break;
            case "1-h new":
			    $Time_interval = 'Hour';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 60*60) );
				break;
            case "1-i new":
			    $Time_interval = 'Minute';
				$from_datetime = date('Y-m-d H:i:s', ( time() - 10*60) ); 
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

	
	
	
	//Check max records which meter -----
	unset($meter_address);
	$real_mchk = 0;
	$M_address2 = "";
	for($s = 0; $s < $mchk; $s++){	
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select(  $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime') )  );
          
		$query->from( $db->quoteName("#__electrical") );		
		$query->where(
		              $db->quoteName('location_id')." = ".$db->quote($location_id) . 
					  " AND `meter_address` = " . $db->quote($meter_address_db[$s]) . 
				      " AND `datetime` >= " . $db->quote($from_datetime) . 
					  " AND `datetime` <= " . $db->quote($to_datetime)  
				);
		
		$query->order('datetime ASC');
		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
		//echo "<br>$s : $num_rows";
	     
		    if($num_rows > 10 ){
			    $meter_address[$real_mchk] = $meter_address_db[$s];
           	    $real_mchk++;			
		    }
	
	}//for
	
	
	if($count_Mvalue==0){
		$MeterValue[0] = "1";
	}
	
	for($x = 0; $x < $real_mchk; $x++){
		if($M_address2 == ""){
		    $M_address2 = $meter_address[$x];
	    }else{
		    $M_address2 = $M_address2."-".$meter_address[$x];
	    }
	}//for($x)
		
	
	if($M_address2 == ""){
        if(($M_address2 == "")&&($count_Mvalue > 0)){ //while all meter none cheched or recoders less then 10
	        echo "<script>alert('All Meters which selected, not enough records to draw chart! Change to show the first Meter Now!');</script>";   
	    }
		
	    $M_address2 = $meter_address_db[0];
	    $real_mchk++;
    }
 
	//echo "<br>M_address : $M_address";
	//echo "<br>M_address2 : $M_address2";
?>
 
<!--script src="https://www.google.com/jsapi" type="text/javascript"></script-->   
<script type="text/javascript">// <![CDATA[
    
	startLoading();
	
	chart = null; // global variable
	chartData = null; // global variable
	chartOptions = null; // global variable
	dataToLoad = ''; // global variable
	chartCol = []; //global variable
	chartCol[0] = {'db_col_name': 'datetime', 'chart_data_type' : 'datetime', 'chart_label' : 'Date Time' };
	
	chartCol[1] = {'db_col_name': 'phase1_apparent_power', 'chart_data_type' : 'number', 'chart_label' : 'Phase 1 Power'};
	chartCol[2] = {'db_col_name': 'phase2_apparent_power', 'chart_data_type' : 'number', 'chart_label' : 'Phase 2 Power'};
	chartCol[3] = {'db_col_name': 'phase3_apparent_power', 'chart_data_type' : 'number', 'chart_label' : 'Phase 3 Power'};
	
	var mchk = '<?php echo $real_mchk;?>';
	
	jsonCol = []; //global variable
	jsonCol[0] = {'db_col_name': 'datetime', 'chart_data_type' : 'datetime', 'chart_label' : 'Date Time' };
	var j = 1;	
	for( var m = 0; m < mchk; m++){
		var Mname = '<?php echo $M_address2;?>'
        var Ms = new Array(); 
            Ms = Mname.split("-");
			

			jsonCol[j] =  {'db_col_name':'Meter'+Ms[m]+'_phase1','chart_data_type' : 'number', 'chart_label':'Meter'+Ms[m]+'_phase1'};
			j++;
			jsonCol[j] =  {'db_col_name':'Meter'+Ms[m]+'_phase2','chart_data_type' : 'number', 'chart_label':'Meter'+Ms[m]+'_phase2'};
			j++;
			jsonCol[j] =  {'db_col_name':'Meter'+Ms[m]+'_phase3','chart_data_type' : 'number', 'chart_label':'Meter'+Ms[m]+'_phase3'};
			//alert(JSON.stringify(jsonCol[j]));
			j++;
    }
	
	dbColumns = ''; //global variable
	var first_time = 1;
	for (var k = 0; k < chartCol.length; k++){
		if (first_time) { first_time = 0;} else { dbColumns += ',';}
		dbColumns = dbColumns + chartCol[k]['db_col_name'];
	} // for k
   //alert(dbColumns);
   
   j_dbColumns = '';//global variable
   var first_jsonCol = 1;
   for (var jk = 0; jk < jsonCol.length; jk++){
		if (first_jsonCol) { first_jsonCol = 0;} else { j_dbColumns += ',';}
		j_dbColumns = j_dbColumns + jsonCol[jk]['db_col_name'];
	} // for jk
	
	datetimeColumnIndex = 0; // global variable
	vChartAxisMinValue = 240; // global
	vChartAxisMaxValue = 241; // global
	
	
	var bootTime = 0;
	var location_id = '<?php echo $location_id;?>';
	var meter_select = '<?php echo $M_address;?>'
	var meter_address = '<?php echo $M_address2;?>';
	var expression = '<?php echo $expression;?>';
	var Time_interval = '<?php echo $Time_interval;?>';
	//alert(meter_address);
	var live_data = <?php echo $live_data;?>;
	var control_redraw = 0; //while 0 allow ,while 1 redraw one time for show histroy chart
	
	
   
	dbTable = 'electrical'; // global variable
	lastRowIndex = 0; // global
	timeRefresh = 5000; // global, refreshes every 15 s
	refreshPeriod = '1-i'; // global, the case to call in changeHAxis
	removeTime = 180000; // global, time in seconds before current time to remove the data

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
		chartData.addColumn('datetime', 'Time');
        
		//var m = 0;
	    for( var m = 0; m < mchk; m++){
			 var Mname = '<?php echo $M_address2;?>'
             var Ms= new Array(); 
                 Ms=Mname.split("-"); 
		    chartData.addColumn('number', 'Meter'+ Ms[m] +'_phase1');
		    chartData.addColumn('number', 'Meter'+ Ms[m] +'_phase2');
		    chartData.addColumn('number', 'Meter'+ Ms[m] +'_phase3');	
	    }

		// Set chart options
		chartOptions = {'title':'Power against Time (Last updated time is ' + Date.now().toString('yyyy-MM-dd HH:mm:ss')+ ')  Meter Selected: [ '+ meter_select +' ]',
			'vAxis':{'title':'Power (W)', 'minValue':vChartAxisMinValue, 'maxValue':vChartAxisMaxValue},
			'hAxis':{'title':'Time', 'minValue': (10).minutes().ago(), 'maxValue':Date.now()},
			'width':800,
			'height':300};

		var table = dbTable;
		var columns = dbColumns;
		var from_datetime_string = (10).minutes().ago().toString('yyyy-MM-dd HH:mm:ss');
		var to_datetime_string = Date.now().toString('yyyy-MM-dd HH:mm:ss');
		var num_records = 180;
		var data_interval = '1-i';

		// getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
		// setTimeout( loadDataToChart('new'), 3000);
		
 
<?php /*
	echo "lastRowIndex = chartData.addRows([ ";
	
		$from_datetime = date('Y-m-d H:i:s', ( time() - 5*60) ); 
		
		//$firs_s = 0;
		unset($format_datetime);
		unset($phase1_apparent_power);
		unset($phase2_apparent_power);
		unset($phase3_apparent_power);
		unset($count_time);
		
		for($s = 0; $s < $mchk; $s++){
			// read electrical status
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime', 'phase1_apparent_power',  'phase2_apparent_power',  'phase3_apparent_power') ) );
			//$query->select('*');   
			$query->from( $db->quoteName('#__electrical') );
			$query->where( 
			            $db->quoteName('location_id')." = ".$db->quote($location_id) .
                        " AND `meter_address` = " . $db->quote($meter_address[$s]) . 					
				        " AND `datetime` >= " . $db->quote($from_datetime) 
					);
			$query->order('datetime DESC');
			$db->setQuery($query,0,180);
			$rows = $db->loadAssocList();

			sort($rows);


			//$firsttime = 0;
			$t = 0; //for get every $s loop time value of format_datetime
			foreach ($rows as $row){
				    $phase1_apparent_power[$s."_".$t] = $row['phase1_apparent_power'];
				    $phase2_apparent_power[$s."_".$t] = $row['phase2_apparent_power'];
				    $phase3_apparent_power[$s."_".$t] = $row['phase3_apparent_power'];
					$datetime = new DateTime($row['datetime']);
				    $format_datetime[$s."_".$t] = $datetime->format('Y,m-1,d,H,i,s'); // need to reduce month by 1 as JS month starts from 
				
			    $t++;	
			}// for each
			$count_time[$s] = $t ;
            //var_dump($count_time);
	    }//for(query)
		
	    $ArrO = 0;
        for ($s = 0; $s < $mchk; $s++){
			if (!$ArrO) { $ArrO = 1;}
			else {echo ",";}
			
			$ArrA = 0;
			for($t = 0; $t <$count_time[$s]; $t++){
				if (!$ArrA) { $ArrA = 1;}
			    else {echo ",";}
				if(sizeof($meter_address) == 1){
		            echo "[ new Date(".$format_datetime[$s."_".$t]."),".$phase1_apparent_power[$s."_".$t].",".$phase2_apparent_power[$s."_".$t].", ".$phase3_apparent_power[$s."_".$t]." ]";
				}else{
					echo "[ new Date(".$format_datetime[$s."_".$t]."),".$phase1_apparent_power[$s."_".$t].",".$phase2_apparent_power[$s."_".$t].", ".$phase3_apparent_power[$s."_".$t].", ";
					
					
					$ArrB = 0;
					for($i = 1; $i < $mchk; $i++){
						if (!$ArrB) { $ArrB = 1;}
			            else {echo ",";}
						echo $phase1_apparent_power[$i."_".$t].",".$phase2_apparent_power[$i."_".$t].", ".$phase3_apparent_power[$i."_".$t];	 
					}
					
					echo "]";
				}//if
			}//for($t)
				
		}//for($s)	
		
	echo " ]);";
	*/
?>
         
		// Instantiate and draw our chart, passing in some options.
		chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(chartData, chartOptions);
		redrawChart();
		
	} // drawChart()
	
	
	

	function redrawChart() {
//alert('in redrawchart()');
		timeoutFxn = setTimeout(function(){	
			chartOptions.title = 'Power against Time (Last updated time is '+ Date.now().toString('yyyy-MM-dd HH:mm:ss') +')  Meter Selected: [ '+ meter_select +' ]';
			
			google.visualization.events.addListener(chart, 'ready', clearLoading);
			if(live_data == 0){
			  control_redraw++;
			}
			if(control_redraw <= 1){
			 changeHAxis(expression);
			 redrawChart();	
		    }			
		}, timeRefresh);
	}

	function getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime, to_datetime, num_records, data_interval  )  {
		// after getting the data from server, the chart data is stored in dataToLoad
		jQuery.ajax({
			url: "index.php",
			data: {"option":"com_ajax", "module":"chart", "method":"getChartData","format":"json" ,
				"table" : table, "location_id" : location_id, "meter_address":meter_address, "columns": columns,
				"from_datetime" : from_datetime, "to_datetime" : to_datetime,
				"num_records" : num_records, "data_interval" : data_interval
				}
		})
		.done(function (obj) {
			//alert(obj);
			var data_text = obj.data; //skips over success, message, messages
			dataToLoadObj = JSON.parse(data_text); // dataToLoadObj is a JSON object, not an array
			dataToLoad = Object.keys(dataToLoadObj).map(  function(jk) { return dataToLoadObj[jk] }  ); //converts object to array of objects
//alert('dataToLoad length in getChartDataToDataToLoad should be 1st  is ' + dataToLoad.length);
 //alert('dataToLoad is ' + dataToLoad);
 //temp = JSON.stringify(dataToLoad, null, 4);
 //alert('dataToLoad JSON is ' + temp);

		})//done 
		.fail(function (request, status, error) {
			//alert('There are some errors. \nPlease try again later.\n' + JSON.stringify(request.responseText));
		});
	} // function getData

	
	function loadDataToChart(type)  {
		var j, number_of_rows, row, chart_datetime, number_of_columns, column_name, length, value, temp_value, rowObj;
		var lastDatetime, temp_datetime, firstDatetime;

		if (type == 'new') {
			// clear all the rows
			number_of_rows = chartData.getNumberOfRows();
			chartData.removeRows(0, number_of_rows);
			lastsRowIndex = 0;
		}
		
		// add rows
		length = dataToLoad.length;
 //alert('dataToLoad length in loadDataToChart should be second is :' + length);
		for (var j=0; j<length; j++) {
			rowObj = dataToLoad[j]; // rowObj is an object, not an array. need key to retrieve.
//alert('rowObj JSON is ' + JSON.stringify(rowObj, null, 4) );
			number_of_columns = Object.keys(rowObj).length;
//alert('number_of_columns is :'+number_of_columns);	
		

			temp_row = [];
			//var temp_row = new Array(); 
			for (var k=0;k<number_of_columns;k++){
				// base on the chart data type, convert the string to the chart data type
				column_name = jsonCol[k].db_col_name;
				temp_string = rowObj[column_name];
				if (jsonCol[k].chart_data_type == 'datetime') {
					value = Date.parse(temp_string);
					temp_datetime = value;
				} else if (jsonCol[k].chart_data_type == 'number') {
					value = Number(temp_string.replace(/, /g, ''));	
                    //value = temp_string;					
				} else {
					value = temp_string.replace(/, /g, '');					
				}
				temp_row[k] = value;
				
			} // for k
			

			if (type == 'new') {
				lastRowIndex = chartData.addRow(temp_row);
			} else if (type == 'add') {
				// type is add, need to compare the date of the last row with the new record before adding
				lastDatetime = chartData.getValue(lastRowIndex, datetimeColumnIndex); 
				if (lastDatetime.getTime() < temp_datetime.getTime()) {
					lastRowIndex = chartData.addRow(temp_row);

					// remove old rows if firstRow time more than now - x time
					firstDatetime = chartData.getValue(0, datetimeColumnIndex); 
					if ( firstDatetime.getTime() < (Date.now().getTime() - removeTime) ) {
						if (lastRowIndex > 10) { // do not remove if less than 10 points
							// remove first row
							chartData.removeRow(0);
							lastRowIndex = lastRowIndex - 1;
							if (lastRowIndex < 0) { lastRowIndex = 0;}
						} // if lastRowIndex
					} // if firstDatetime
				}// if lastDatetime
			} // else if type add
			
		} //for j
	} // function loadDataToChart



	function changeHAxis(expression)  {
///alert('in changeHAxis()');
//alert('expression:' + expression);
//alert('location_id:' + location_id);	
//alert('meter_address:' + meter_address);		
		var table = dbTable;
		var columns = dbColumns;
		var from_datetime, to_datetime, num_records, data_interval;

		// expression format in 'time type'. Type can be 'new' or 'add'. time in n-m format like 1-year.
		var expression_array = expression.split(' ');
		var expression_time = expression_array[0];
		var expression_type = expression_array[1];
		

		switch(expression_time) {
			case '5-y':
				refreshPeriod = '5-y'; // used in redrawChart()
				removeTime = 5*365*24*60*60*1000; // time is seconds (5 years) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (5).years().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 60;
				data_interval = '1-m'; // 1 month
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '2-y':
				refreshPeriod = '2-y'; // used in redrawChart()
				removeTime = 2*365*24*60*60*1000; // time is seconds (2 years) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (2).years().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 104;
				data_interval = '1-w'; // 1 week
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-y':
				refreshPeriod = '1-y'; // used in redrawChart()
				removeTime = 365*24*60*60*1000; // time is seconds (1 y) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (365).days().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 52;
				data_interval = '7-d'; // 1 week
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-q':
				refreshPeriod = '1-q'; // used in redrawChart()
				removeTime = 3*30*24*60*60*1000; // time is seconds (3 m) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (3).months().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 90;
				data_interval = '1-d'; // 1 day
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-m':
				refreshPeriod = '1-m'; // used in redrawChart()
				removeTime = 30*24*60*60*1000; // time is seconds (1 m) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (30).days().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 60;
				data_interval = '12-h'; // 12 hours
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-w':
				refreshPeriod = '1-w'; // used in redrawChart()
				removeTime = 7*24*60*60*1000; // time is seconds (1 w) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (7).days().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 84;
				data_interval = '2-h'; // 2 hours
				if ((timeRefresh != 7200000)&&(bootTime != 0)) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-d':
				refreshPeriod = '1-d'; // used in redrawChart()
				removeTime = 24*60*60*1000; // time is seconds (1 d) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (1).days().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 48;
				data_interval = '30-i'; // 30 mins
				if ((timeRefresh != 1800000)&&(bootTime != 0)) {
					timeRefresh = 1800000; // 30 mins
					clearTimeout(timeoutFxn);
					redrawChart();
				}
                
				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				
				break;
			case '1-h':
				refreshPeriod = '1-h'; // used in redrawChart()
				removeTime = 60*60*1000; // time is seconds (1 h) from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (1).hours().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 60;
				data_interval = '1-i'; // 1 min
				if ((timeRefresh != 60000)&&(bootTime != 0)) {
					timeRefresh = 60000; // 1 min
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					bootTime = 1;
					redrawChart();
				},timeRefresh);
				break;
			case '1-i':
				refreshPeriod = '1-i'; // used in redrawChart()
				removeTime = 3*60*1000; // time is seconds from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (10).minutes().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 180;
				data_interval = '1-s';
				if (timeRefresh != 5000) {
					timeRefresh = 5000;
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);	
				    bootTime = 1;
				},timeRefresh);
				
				break;
			default:
				// default code block
		} // switch
	} // changeHAxis

	function changeLocation(LocationId){
        location_id = LocationId ;
		//location.href="index.php/Power-Chart?location_id="+location_id+"&meter_address="+meter_address+"&expression="+expression+"&live_data="+live_data;
	}
	

	function changeMeter(MeterId){
        var Meter = document.getElementById(MeterId);
		if(Meter.checked == true){  
			Meter = 1;
			//alert(MeterId+"："+Meter);
		}else{
			Meter = 0;
			//alert(MeterId+"："+Meter);
		}
	}
	
	
	function changeTime(TimeKey){
        //expression = TimeKey ;
		//control_redraw = 0;
		//startLoading();
		//redrawChart();
	}
	
	function changeLive(){
        var live_checked = document.getElementById("live_data");
		var histroy_checked = document.getElementById("history_data");
		 if(live_checked.checked == true){
			 live_data = 1;
		 }else{
			 live_data = 0;
		 }
		//alert(live_data);
		startLoading();
		control_redraw = 0;
		redrawChart();
	}
	
	
	
    //---Loading chart code-----------
    function clearLoading2() {document.getElementById('chartcurtain').style.display="none"; }
	function clearLoading() {
		var i = 100; 
        function $(id) {return document.getElementById(id);} 
        function chang_display() { 
          i--;
          var div = $('chartcurtain'); 
          div.style.filter = "Alpha(Opacity="+i+")"; 
          div.style.opacity = i / 100; 
          if ( i== "0"){
			document.getElementById('chartcurtain').style.display="none";//隐藏 
            exit 
          } 
        } 
        setInterval(chang_display, 10);    
	}
	
	function startLoading() {
		var i = 99; 
        function $(id) {return document.getElementById(id);} 
        function chang_block() { 
          i++; 
          var div = $('chartcurtain'); 
          div.style.filter = "Alpha(Opacity="+i+")"; 
          div.style.opacity = i / 100; 
          if ( i== "100"){
			document.getElementById('chartcurtain').style.display="block";//显示
			exit
          }
        } 
        setInterval(chang_block, 0);   
	}	
	
// ]]></script>
<table >
<tr>
<td width=600px>
<div style="width: 400px; height: 300px; position: relative;">
<div id="chartcurtain"
     style="width: 400px;
          height: 300px;
          position: absolute;
          top: 0;
          left: 0;
          z-index: 100;
          text-align: center;
          line-height: 300px;
          font-size: 20px;
          filter:Alpha(Opacity=0); 
">
<font color=#5e5e5e >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loading chart ......</font>
</div>


<div id="chart_div"> </div>
</div>
</td >
</tr>
</table>

<form name=chart_form action="Power-Chart" method="POST">
<table >
<tr>
<td width=500px>
    
	
    <select id='location_frame' name='location_id' onChange="javascript:changeLocation(this.value);">
	    <option value="<?php echo $location_id; ?>" selected>Locat <?php echo $location_id; ?></option>
<?php 
	    $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('info_id', 'location_id') ) ); 
		$query->from( $db->quoteName("#__meter_info_server") );
		//$query->where( $db->quoteName('meter_address')." = ".$db->quote($meter_address) );
		$query->order('location_id ASC');
		$db->setQuery($query);
		$locrows = $db->loadAssocList();
		
        $l = 1;
        $l2 = $l - 1;		
        unset($location);		
	    foreach($locrows AS $LocVaule){
			
				$location["$l"] = $LocVaule['location_id'];
				$location_2 = $location["$l2"];
			    if(($location["$l"] != $location_2)&&($location["$l"] != $location_id)){
?>  
				
		<option value="<?php echo $LocVaule['location_id']; ?>" >Locat <?php echo $LocVaule['location_id']; ?></option>
		
<?php		}
        $l++;
		$l2++;
        }
?>	
	</select> 


	<!--select id='meter_frame' name='meter_frame' class="input-small" onChange="javascript:changeMeter(this.value);">
	 
<?php /*
	    $db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select( $db->quoteName(array('info_id', 'location_id', 'meter_address') ) ); 
		$query->from( $db->quoteName("#__meter_info_server") );
		$query->where( $db->quoteName('location_id')." = ".$db->quote($location_id) );
		$query->order('meter_address ASC');
		$db->setQuery($query);
		$Inforows = $db->loadAssocList();

	    foreach($Inforows AS $InfoVaule){
			if($meter_address == $InfoVaule['meter_address']){
?>
		<option value="<?php echo $InfoVaule['meter_address']; ?>" selected>Meter <?php echo $InfoVaule['meter_address']; ?></option>
<?php	    }else{  ?>
	    <option value="<?php echo $InfoVaule['meter_address']; ?>" >Meter <?php echo $InfoVaule['meter_address']; ?></option>
<?php	
            } 
			
        }
		*/
  ?>	
	</select--> 
	
	<select  name='time_frame'  onChange="javascript:changeTime(this.value);">
	<option value="<?php echo $expression; ?>" selected><?php echo $Time_interval; ?></option>
		<option value="5-y new">5 years</option>
		<option value="2-y new">2 years</option>
		<option value="1-y new">Year</option>
		<option value="1-q new">Quarter</option>
		<option value="1-m new">Month</option>
		<option value="1-w new">Week</option>
		<option value="1-d new">Day</option>
		<option value="1-h new">Hour</option>
		<option value="1-i new">Minute</option>
	</select> 
	
    <input type=radio id="live_data" name=live_data value='1' checked  onclick='changeLive()'>Live</input>
	<input type=radio id="history_data" name=live_data value='0'  onclick='changeLive()'>Historical</input>

</td>
</tr>

<tr align="left" >
    <td style="padding-left:2px;">
			
<?php 
	   
	    
	    for($met_s = 0; $met_s < $met; $met_s++){
		    $CheckName = $MeterName[$met_s];
?>			
	<input name="<?php echo $CheckName;?>" id="<?php echo $CheckName;?>" type="checkbox"  value="1"  <?php  if( $MeterValue["$met_s"] == 1){ ?>checked ="checked" <?php } ?> onclick="javascript:changeMeter('<?php echo $CheckName;?>');"/>&nbsp;<?php echo $CheckName;?>&nbsp;&nbsp;
<?php	}  ?>      
        
		<!--input name="Meter01" id="M1" type="checkbox"  value="1"  <?php  //if($Meter01 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter01();"/>&nbsp;Meter 01&nbsp;&nbsp;
		<input name="Meter02" id="M2" type="checkbox"  value="1"  <?php  //if($Meter02 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter02();"/>&nbsp;Meter 02&nbsp;&nbsp;
		<input name="Meter03" id="M3" type="checkbox"  value="1"  <?php  //if($Meter03 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter03();"/>&nbsp;Meter 03&nbsp;&nbsp;
		<input name="Meter04" id="M4" type="checkbox"  value="1"  <?php  //if($Meter04 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter04();"/>&nbsp;Meter 04&nbsp;&nbsp;
		<input name="Meter05" id="M5" type="checkbox"  value="1"  <?php  //if($Meter05 == 1){ ?>checked ="checked" <?php //} ?> onclick="javascript:change_Meter05();"/>&nbsp;Meter 05&nbsp;&nbsp;
		
    </td>					
</tr>
 
<!--tr align="left" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:2px;">
			<input name="Phase1_Power" id="Phase1_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_A();" />&nbsp;Phase1_Power&nbsp;&nbsp;
			<input name="Phase2_Power" id="Phase2_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_B();"/>&nbsp;Phase2_Power&nbsp;&nbsp;
			<input name="Phase3_Power" id="Phase3_Power" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Power_C();"/>&nbsp;Phase3_Power&nbsp;&nbsp;
			</td>
						
 </tr-->
<tr align="left" >
<td>
<br><input type="submit" value=" Submit "  id="send-btn" /><br><br>
</td>
</tr>

</table>
</form>
