﻿<?php

$js = JURI::base().'modules/Voltage-Time/js/jsapi.js';  
$document = JFactory::getDocument($js);  
$document->addScript($js); 

$zh_CN = JURI::base().'modules/Voltage-Time/js/format+zh_CN,default+zh_CN,ui+zh_CN,corechart+zh_CN.I.js';  
$document2 = JFactory::getDocument($zh_CN);  
$document2->addScript($zh_CN); 

$corechart = JURI::base().'modules/Voltage-Time/js/corechart.js';  
$document3 = JFactory::getDocument($corechart);  
$document3->addScript($corechart);



$date = JURI::base().'modules/Voltage-Time/js/date.js';  
$document4 = JFactory::getDocument($date);  
$document4->addScript($date); 

$jq = JURI::base().'modules/Voltage-Time/js/jquery-1.11.1.min.js';  
$document5 = JFactory::getDocument($jq);  
$document5->addScript($jq);

date_default_timezone_set('ASIA/Singapore');



$location_id = trim(JRequest::getVar('location_id', '1')); 
$meter_address = trim(JRequest::getVar('meter_address', '01')); 
$expression = trim(JRequest::getVar('expression', '1-i new')); 
$live_data = trim(JRequest::getVar('live_data', '1')); 

switch($expression){//change value of Time_interval while change TimeFrame
			case '5-y new':
			    $Time_interval = '5 years';
				break;
			case '2-y new':
			    $Time_interval = '2 years';
				break;
			case '1-y new':
			    $Time_interval = 'Year';
				break;
			case '1-q new':
			    $Time_interval = 'Quarter';
				break;
            case '1-m new':
			    $Time_interval = 'Month';
				break;
            case '1-w new':
			    $Time_interval = 'Week';
				break;
			case '1-d new':
			   $Time_interval = 'Day';
				break;
            case '1-h new':
			    $Time_interval = 'Hour';
				break;
            case '1-i new':
			    $Time_interval = 'Minute';
				break;
            default:
                break;			
		}

?>
    <!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
    <!--<script type="text/javascript" src="coreChart.js"></script> -->
   <!--script type="text/javascript" src="jsapi.js"></script> 
   <script src="js/corechart.js" type="text/javascript"></script>
   <link href="js/ui+zh_CN.css" type="text/css" rel="stylesheet">
   <script src="js/format+zh_CN,default+zh_CN,ui+zh_CN,corechart+zh_CN.I.js" type="text/javascript"></script>
  <link href="js/tooltip.css" rel="stylesheet" type="text/css"-->
<!--script src="jquery-1.11.1.min.js" type="text/javascript"></script-->
<script type="text/javascript">// <![CDATA[
	chart = null; // global variable
	chartData = null; // global variable
	chartOptions = null; // global variable
	dataToLoad = ''; // global variable
	chartCol = []; //global variable
	chartCol[0] = {'db_col_name': 'datetime', 'chart_data_type' : 'datetime', 'chart_label' : 'Date Time' };
	datetimeColumnIndex = 0; // global variable
	chartCol[1] = {'db_col_name': 'phase1_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 1 Apparent Voltage'};
	chartCol[2] = {'db_col_name': 'phase2_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 2 Apparent Voltage'};
	chartCol[3] = {'db_col_name': 'phase3_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 3 Apparent Voltage'};
	vChartAxisMinValue = 240; // global
	vChartAxisMaxValue = 242; // global
	
	
	var Phase1_Voltage = 1;
	var Phase2_Voltage = 1;
	var Phase3_Voltage = 1;
	
	var location_id = '<?php echo $location_id;?>';
	var meter_address = '<?php echo $meter_address;?>';
	var expression = '<?php echo $expression;?>';
	var Time_interval = '<?php echo $Time_interval;?>';
	
	var live_data = <?php echo $live_data;?>;
	var control_redraw = 0; //while 0 allow ,while 1 redraw one time for show histroy chart
	
	dbColumns = ''; //global variable
	var first_time = 1;
	for (var k = 0; k < chartCol.length; k++){
		if (first_time) { first_time = 0;} else { dbColumns += ',';}
		dbColumns = dbColumns + chartCol[k]['db_col_name'];
	} // for k

	dbTable = 'electrical'; // global variable
	lastRowIndex = 0; // global
	timeRefresh = 3000; // global, refreshes every 15 s
	refreshPeriod = '1-i'; // global, the case to call in changeHAxis
	removeTime = 3000; // global, time in seconds before current time to remove the data

	// Load the Visualization API and the piechart package.
	google.load('visualization', '1.0', {'packages':['corechart']});

	// Set a callback to run when the Google Visualization API is loaded.
	google.setOnLoadCallback(drawChart);

	// Callback that creates and populates a data table, 
	// instantiates the pie chart, passes in the data and
	// draws it.

	//
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
			document.getElementById('chartcurtain').style.display="block";//隐藏 
			exit
          }
        } 
        setInterval(chang_block, 0);   
	}
	
	
	function drawChart() {
		// Create the data table.
		chartData = new google.visualization.DataTable(); 
		chartData.addColumn('datetime', 'Time');
		chartData.addColumn('number', 'Phase1_Voltage');
		chartData.addColumn('number', 'Phase2_Voltage');
		chartData.addColumn('number', 'Phase3_Voltage');

		// Set chart options
		chartOptions = {'title':'Voltage against Time (Last updated time is '+'<?php "<font clolr=#blue>"; ?>' + Date.now().toString('yyyy-MM-dd HH:mm:ss') + '<?php "</font>"; ?>'+ ')  Meter: ['+ meter_address +']    Time interval:['+ Time_interval +']',
			'vAxis':{'title':'Voltage (V)', 'minValue':vChartAxisMinValue, 'maxValue':vChartAxisMaxValue},
			'hAxis':{'title':'Time', 'minValue': (5).minutes().ago(), 'maxValue':Date.now()},
			'width':700,
			'height':300};

		var table = dbTable;
		//var location_id = '<?php echo $location_id; ?>';
		//var meter_address = '01';
		var columns = dbColumns;
		var from_datetime_string = (1).minutes().ago().toString('yyyy-MM-dd HH:mm:ss');
		var to_datetime_string = Date.now().toString('yyyy-MM-dd HH:mm:ss');
		var num_records = 60;
		var data_interval = '1-i';

		// getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);

		// setTimeout( loadDataToChart('new'), 3000);
		
       
<?php
			// read electrical status
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select( $db->quoteName(array('electrical_id', 'location_id', 'meter_address', 'datetime', 'phase1_voltage',  'phase2_voltage',  'phase3_voltage') ) );
			//$query->select('*');   
			$query->from( $db->quoteName('#__electrical') );
			$from_datetime = date('Y-m-d H:i:s', ( time() - 5*60) ); 
			$query->where( 
			            $db->quoteName('location_id')." = ".$db->quote($location_id) .
                        " AND `meter_address` = " . $db->quote($meter_address) . 					
				        " AND `datetime` >= " . $db->quote($from_datetime) 
					);
			$query->order('datetime DESC');
			$db->setQuery($query,0,180);
			$rows = $db->loadAssocList();

			sort($rows);

			echo "	lastRowIndex = chartData.addRows([
";
			$firsttime = 0;
			foreach ($rows as $row){
				if (!$firsttime) { $firsttime = 1;}
				else {echo ",
";}
				$phase1_voltage = $row['phase1_voltage'];
				$phase2_voltage = $row['phase2_voltage'];
				$phase3_voltage = $row['phase3_voltage'];
				$datetime = new DateTime($row['datetime']);
				$format_datetime = $datetime->format('Y,m-1,d,H,i,s'); // need to reduce month by 1 as JS month starts from 0
				echo "[ new Date($format_datetime),$phase1_voltage,$phase2_voltage, $phase3_voltage  ]";
			}// for each
		echo "
]);";
?>

		// Instantiate and draw our chart, passing in some options.
		chart = new google.visualization.LineChart(document.getElementById('chart_div'));
		chart.draw(chartData, chartOptions);
		redrawChart();
		
	} // drawChart()
	
	
	

	function redrawChart() {

		timeoutFxn = setTimeout(function(){	
			chartOptions.title = 'Voltage against Time (Last updated time is '+'<?php "<font clolr=#blue>"; ?>' + Date.now().toString('yyyy-MM-dd HH:mm:ss') + '<?php "</font>"; ?>'+')  Meter: ['+ meter_address +']    Time interval:['+ Time_interval +']';
			
			changeHAxis();
			google.visualization.events.addListener(chart, 'ready', clearLoading);
			if(live_data == 0){
			  control_redraw++;
			}
			if(control_redraw <= 1){
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
			var data_text = obj.data; //skips over success, message, messages
			dataToLoadObj = JSON.parse(data_text); // dataToLoadObj is a JSON object, not an array
			dataToLoad = Object.keys(dataToLoadObj).map(  function(k) { return dataToLoadObj[k] }  ); //converts object to array of objects
// alert('dataToLoad length in getChartDataToDataToLoad should be 1st  is ' + dataToLoad.length);
// alert('dataToLoad is ' + dataToLoad);
 temp = JSON.stringify(dataToLoad, null, 4);
 alert('dataToLoad JSON is ' + temp);

		})//done 
		.fail(function (request, status, error) {
			alert('There are some errors. \nPlease try again later.\n' + request.responseText);
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
//		for (var j=0; j<2; j++) {
		length = dataToLoad.length;
// alert('dataToLoad length in loadDataToChart should be second is ' + length);
		for (var j=0; j<length; j++) {
			rowObj = dataToLoad[j]; // rowObj is an object, not an array. need key to retrieve.
//alert('rowObj JSON is ' + JSON.stringify(rowObj, null, 4) );
			number_of_columns = Object.keys(rowObj).length;
			temp_row = [];
			for (var k=0;k<number_of_columns;k++){
				// base on the chart data type, convert the string to the chart data type
				column_name = chartCol[k].db_col_name;
				temp_string = rowObj[column_name];
				 if (chartCol[k].chart_data_type == 'datetime') {
					value = Date.parse(temp_string);
					temp_datetime = value;
				} else if  (chartCol[k].chart_data_type == 'number') {
					value = Number(temp_string.replace(/, /g, ''));					
				} else {
					value = temp_string;					
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



	function changeHAxis()  {
		var table = dbTable;
		//var location_id = '<?php echo $location_id; ?>';
		//var meter_address = '<?php echo $meter_address; ?>';
		var columns = dbColumns;
		var from_datetime, to_datetime, num_records, data_interval;
		
		///alert(location_id);
		//alert(meter_address);

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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 7200000) {
					//timeRefresh = 7200000; // 2 hours
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 1800000) {
					//timeRefresh = 1800000; // 30 mins
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					
					chart.draw(chartData,chartOptions);
					
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
				//if (timeRefresh != 60000) {
					//timeRefresh = 60000; // 1 min
					//clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					
					chart.draw(chartData,chartOptions);
					
				},timeRefresh);
				break;
			case '1-i':
				refreshPeriod = '1-i'; // used in redrawChart()
				removeTime = 3*60*1000; // time is seconds from current time to remove old data
				// getChartData(table, location_id, meter_address, columns, from_date, to_date, num_records, data_interval  )
				from_datetime = (5).minutes().ago();
				to_datetime = Date.now();
				from_datetime_string = from_datetime.toString('yyyy-MM-dd HH:mm:ss');
				to_datetime_string = to_datetime.toString('yyyy-MM-dd HH:mm:ss');
				num_records = 180;
				data_interval = '1-s';
				//if (timeRefresh != 3000) {
					//timeRefresh = 3000;
					clearTimeout(timeoutFxn);
					//redrawChart();
				//}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);	
				    
				},timeRefresh);
				
				break;
			default:
				// default code block
		} // switch
	} // changeHAxis

	function changeLocation(LocationId){
	
        location_id = LocationId ;
		location.href="index.php/Voltage-time?location_id="+location_id+"&meter_address="+meter_address+"&expression="+expression+"&live_data="+live_data;
	}
	
	function changeMeter(MeterId){
	
        meter_address = MeterId ;
		control_redraw = 0;
		startLoading();
		redrawChart();
	}
	
	function changeTime(TimeKey){
	
        expression = TimeKey ;
		control_redraw = 0;
		startLoading();
		redrawChart();
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
	
	
	function change_Voltage_A(){
	
        var Phase1_Voltage = document.getElementById("Phase1_Voltage");
        
		if(Phase1_Voltage.checked == true){  
			Phase1_Voltage = 1;
			alert("Phase1_Voltage："+Phase1_Voltage);
		}else{
			Phase1_Voltage = 0;
			alert("Phase1_Voltage："+Phase1_Voltage);
		}
	}

    function change_Voltage_B(){
	
		var Phase3_Voltage = document.getElementById("Phase3_Voltage");
        
		if(Phase2_Voltage.checked == true){  
			Phase2_Voltage = 1;
			alert("Phase2_Voltage："+Phase2_Voltage);
		}else{
			Phase2_Voltage = 0;
			alert("Phase2_Voltage："+Phase2_Voltage);
		}
	}

	function change_Voltage_C(){
	
		var Phase3_Voltage = document.getElementById("Phase3_Voltage");
        
		if(Phase3_Voltage.checked == true){
			Phase3_Voltage = 1;
			alert("Phase3_Voltage："+Phase3_Voltage);
		}else{
			Phase3_Voltage = 0;
			alert("Phase3_Voltage："+Phase3_Voltage);
		}
	}
		
	
// ]]></script>
<table >
<tr>
<td>
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
<font color=#5e5e5e >Loading chart ......</font>
</div>


<div id="chart_div"> </div>
</div>
</td>
</tr>

<tr>
<td>
<div id="time_setting">
    
	
    <select id='location_frame' name='location_frame' class="input-small" onChange="javascript:changeLocation(this.value);">
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


	<select id='meter_frame' name='meter_frame' class="input-small" onChange="javascript:changeMeter(this.value);">
	 
<?php 
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
  ?>	
	</select> 
	
	<select  name='time_frame' class="input-small" onChange="javascript:changeTime(this.value);">
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
</div>
</td>
</tr>
<!--tr align="left" onmouseover="this.style.backgroundColor='#e5ff00'" onmouseout="this.style.backgroundColor='#ffffff'">
            <td style="padding-left:2px;">
			<input name="Phase1_Voltage" id="Phase1_Voltage" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Voltage_A();" />&nbsp;Phase1_Voltage&nbsp;&nbsp;
			<input name="Phase2_Voltage" id="Phase2_Voltage" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Voltage_B();"/>&nbsp;Phase2_Voltage&nbsp;&nbsp;
			<input name="Phase3_Voltage" id="Phase3_Voltage" type="checkbox"  value="1"  checked ="checked" onclick="javascript:change_Voltage_C();"/>&nbsp;Phase3_Voltage&nbsp;&nbsp;
			</td>
						
</tr-->
</table>





