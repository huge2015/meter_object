
<?php
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

$jq = JURI::base().'modules/Voltage-Time/js/jquery-1.9.1.js';  
$document5 = JFactory::getDocument($jq);  
$document5->addScript($jq);


date_default_timezone_set('ASIA/Singapore');


$location_id = "1";
$meter_address = "01";

?>


    <!--<script type="text/javascript" src="https://www.google.com/jsapi"></script>-->
    <!--<script type="text/javascript" src="coreChart.js"></script> -->
   <!--script type="text/javascript" src="jsapi.js"></script> 
   <script src="js/corechart.js" type="text/javascript"></script>
   <link href="js/ui+zh_CN.css" type="text/css" rel="stylesheet">
   <script src="js/format+zh_CN,default+zh_CN,ui+zh_CN,corechart+zh_CN.I.js" type="text/javascript"></script>
  <link href="js/tooltip.css" rel="stylesheet" type="text/css"-->

   <script type="text/javascript">// <![CDATA[
	chart = null; // global variable
	chartData = null; // global variable
	chartOptions = null; // global variable
	dataToLoad = ''; // global variable
	chartCol = []; //global variable
	chartCol[0] = {'db_col_name': 'datetime', 'chart_data_type' : 'datetime', 'chart_label' : 'Date Time' };
	datetimeColumnIndex = 0; // global variable
	chartCol[1] = {'db_col_name': 'phase1_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 1 Voltage'};
	chartCol[2] = {'db_col_name': 'phase2_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 2 Voltage'};
	chartCol[3] = {'db_col_name': 'phase3_voltage', 'chart_data_type' : 'number', 'chart_label' : 'Phase 3 Voltage'};
	vChartAxisMinValue = 230; // global
	vChartAxisMaxValue =250; // global

	dbColumns = ''; //global variable
	var first_time = 1;
	for (var k = 0; k < chartCol.length; k++){
		if (first_time) { first_time = 0;} else { dbColumns += ',';}
		dbColumns = dbColumns + chartCol[k]['db_col_name'];
	} // for k

	dbTable = 'electrical3'; // global variable
	lastRowIndex = 0; // global
	timeRefresh = 3000; // global, refreshes every 15 s
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
		chartData.addColumn('number', 'Voltage-1');
        chartData.addColumn('number', 'Voltage-2');
		chartData.addColumn('number', 'Voltage-3');
		// Set chart options
		chartOptions = {'title':'Voltage against Time (Last updated time is ' + Date.now().toString('yyyy-MM-dd HH:mm:ss') + ')',
			'vAxis':{'title':'Voltage (V)', 'minValue':vChartAxisMinValue, 'maxValue':vChartAxisMaxValue},
			'hAxis':{'title':'Time', 'minValue': (5).minutes().ago(), 'maxValue':Date.now()},
			'width':700,
			'height':300};

		var table = dbTable;
		var location_id = '<?php echo $location_id; ?>';
		var meter_address = '<?php echo $meter_address; ?>';
		var columns = dbColumns;
		var from_datetime_string = (1).minutes().ago().toString('yyyy-MM-dd HH:mm:ss');
		var to_datetime_string = Date.now().toString('yyyy-MM-dd HH:mm:ss');
		var num_records = 180;
		var data_interval = '1-s';

		// getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);

		// setTimeout( loadDataToChart('new'), 3000);

<?php
			// read electrical status
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			//$query->select( $db->quoteName(array('electrical_id', 'location_id', 'datetime', 'phase1_voltage',
			   //'phase1_voltage', 'phase1_current', 'phase1_frequency') ) );
			$query->select('*');   
			$query->from( $db->quoteName('#__electrical3') );
			$from_datetime = date('Y-m-d H:i:s', ( time() - 5*60) ); 
			$query->where( $db->quoteName('location_id')." = ".$db->quote(2)  . " AND `datetime` >= '$from_datetime'  " );
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
				echo "[ new Date($format_datetime),$phase1_voltage ,$phase2_voltage ,$phase3_voltage ]";
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
			chartOptions.title = 'Voltage against Time (Last updated time is ' + Date.now().toString('yyyy-MM-dd HH:mm:ss') + ')';
			changeHAxis(refreshPeriod + ' add');
			redrawChart();
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
// temp = JSON.stringify(dataToLoad, null, 4);
// alert('dataToLoad JSON is ' + temp);

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

	function callAjax()  {
		var new_data;
		jQuery.ajax({
			url: "index.php",
			data: {"option":"com_ajax", "module":"chart", "method":"getData","format":"json"}
		})
		.done(function (obj) {
			// inside obj has keys "success", "message", "messages", and "data"
			// get data_text, convert to object, loop through rows, add to chart data (data.addRow(...))
			// remove old row (data.removeRow(r))
			new_data_text = obj.data; 
			new_data = JSON.parse(new_data_text);

			for (var j=0; j<2; j++) {
//			for (var j=0; j<new_data.length; j++) {
				row = new_data[j];
				phase1_voltage = row.phase1_voltage;
				datetime = row.datetime; // row.datetime is a string "2015-12-03 15:12:59". Use Date.parse from date.js
				chart_datetime = Date.parse(datetime);
				lastRowIndex = data.addRow([chart_datetime, phase1_voltage]);

				options = {'title':'Voltage Update against Time ' + datetime,
		                     'vAxis':{'title':'Voltage (V)', 'minValue': vChartAxisMinValue, 'maxValue':vChartAxisMaxValue},
		                     'hAxis':{'title':'Time', 'minValue': (1).minutes().ago(), 'maxValue':Date.now()},
        		             'width':700,
                		     'height':300};

				chart.draw(data,options);
			} // for
		})
		.fail(function (request, status, error) {
			alert(request.responseText);
		});
	} // callAjax

	function changeHAxis(expression)  {
		var table = dbTable;
		var location_id = '<?php echo $location_id; ?>';
		var meter_address = '<?php echo $meter_address; ?>';
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 7200000) {
					timeRefresh = 7200000; // 2 hours
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 1800000) {
					timeRefresh = 1800000; // 30 mins
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 60000) {
					timeRefresh = 60000; // 1 min
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
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
				if (timeRefresh != 3000) {
					timeRefresh = 3000;
					clearTimeout(timeoutFxn);
					redrawChart();
				}

				getChartDataToDataToLoad(table, location_id, meter_address, columns, from_datetime_string, to_datetime_string, num_records, data_interval);
				setTimeout(function() {
					loadDataToChart(expression_type);
					chartOptions.hAxis = {'title':'Time', 'minValue': from_datetime, 'maxValue':to_datetime};
					chart.draw(chartData,chartOptions);
				},3000);
				break;
			default:
				// default code block
		} // switch
	} // changeHAxis

// ]]></script>  


<div id="chart_div"></div>
<div id="time_setting">
	Time Frame
	<select name='time_frame' onChange="javascript:changeHAxis(this.value);">>
		<option value="5-y new">5 years</option>
		<option value="2-y new">2 years</option>
		<option value="1-y new">Year</option>
		<option value="1-q new">Quarter</option>
		<option value="1-m new">Month</option>
		<option value="1-w new">Week</option>
		<option value="1-d new">Day</option>
		<option value="1-h new">Hour</option>
		<option value="1-i new" selected>Minute</option>
	</select> 

	<input type=radio name=live_data value='1' checked>Live</input>
	<input type=radio name=live_data value='0'>Historical</input>

</div>

