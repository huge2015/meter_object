<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--Load the AJAX API-->
    <script type="text/javascript" src="api.js"></script>
    <script type="text/javascript">
 
      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});
 
      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
 
      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {
 
        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Mushrooms', 3],
          ['Onions', 1],
          ['Olives', 1],
          ['Zucchini', 1],
          ['Pepperoni', 2]
        ]);
        // Set chart options
        var options = {
          'title':'How Much Pizza I Ate Last Night - 饼图 3D',
          'is3D':true,
          'width':500,
          'height':300
        };
        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div01'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Age', 'Weight'],
          [ 8,      12],
          [ 4,      5.5],
          [ 11,     14],
          [ 4,      5],
          [ 3,      3.5],
          [ 6.5,    7]
        ]);
        options = {
          title: 'Age vs. Weight comparison - 散点图',
          hAxis: {title: 'Age', minValue: 0, maxValue: 15},
          vAxis: {title: 'Weight', minValue: 0, maxValue: 15},
          legend: 'none'
        };
        chart = new google.visualization.ScatterChart(document.getElementById('chart_div02'));
        chart.draw(data, options);
 
        // Some raw data (not necessarily accurate)
        data = google.visualization.arrayToDataTable([
          ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Average'],
          ['2004/05',  165,      938,         522,             998,           450,      614.6],
          ['2005/06',  135,      1120,        599,             1268,          288,      682],
          ['2006/07',  157,      1167,        587,             807,           397,      623],
          ['2007/08',  139,      1110,        615,             968,           215,      609.4],
          ['2008/09',  136,      691,         629,             1026,          366,      569.6]
        ]);
        options = {
          title : 'Monthly Coffee Production by Country - 组合图',
          vAxis: {title: "Cups"},
          hAxis: {title: "Month"},
          seriesType: "bars",
          series: {5: {type: "line"}}
        };
        chart = new google.visualization.ComboChart(document.getElementById('chart_div03'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);
        options = {
          title: 'Company Performance - 折线图'
        };
        chart = new google.visualization.LineChart(document.getElementById('chart_div04'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);
        options = {
          title: 'Company Performance - 条图',
          vAxis: {title: 'Year',  titleTextStyle: {color: 'red'}}
        };
        chart = new google.visualization.BarChart(document.getElementById('chart_div05'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);
        options = {
          title: 'Company Performance - 柱状图',
          hAxis: {title: 'Year',titleTextStyle: {color: 'red'}}
        };
        chart = new google.visualization.ColumnChart(document.getElementById('chart_div06'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Year', 'Sales', 'Expenses'],
          ['2004',  1000,      400],
          ['2005',  1170,      460],
          ['2006',  660,       1120],
          ['2007',  1030,      540]
        ]);
        options = {
          title: 'Company Performance - 面积图',
          hAxis: {title: 'Year',  titleTextStyle: {color: 'red'}}
        };
        chart = new google.visualization.AreaChart(document.getElementById('chart_div07'));
        chart.draw(data, options);
 
        data = google.visualization.arrayToDataTable([
          ['Mon', 20, 28, 38, 45],
          ['Tue', 31, 38, 55, 66],
          ['Wed', 50, 55, 77, 80],
          ['Thu', 77, 77, 66, 50],
          ['Fri', 68, 66, 22, 15]
          // Treat first row as data as well.
        ], true);
        options = {
          title: '蜡烛图',
          legend:'none'
        };
        chart = new google.visualization.CandlestickChart(document.getElementById('chart_div08'));
        chart.draw(data, options);
      }
    </script>
  </head>
 
  <body>
    <table>
      <tr>
        <td>
          <div id="chart_div01"></div>
        </td>
        <td>
          <div id="chart_div02"></div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="chart_div03"></div>
        </td>
        <td>
          <div id="chart_div04"></div>
        </td>
        <td>
          <div id="chart_div05"></div>
        </td>
      </tr>
      <tr>
        <td>
          <div id="chart_div06"></div>
        </td>
        <td>
          <div id="chart_div07"></div>
        </td>
        <td>
          <div id="chart_div08"></div>
        </td>
      </tr>
    </table>
  </body>
</html>