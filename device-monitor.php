<?php
if(isset($_GET['id'])){
  include_once 'conn.php';
  $sql = "SELECT * FROM `weather_data` WHERE `device_id`='".$_GET['id']."' ORDER BY `read_time` ASC";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result)>0){
    $no_data = false;
  } else{
    $no_data = true;
  }
} else{
  echo "Invalid URL.";
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" />
  <link rel="icon" type="image/png" href="img/weather-logo.png" />
  <title>Monitor Device | Weather Go</title>
  <style>
    .datepicker-dropdown{
      z-index: 100;
    }
    .google-chart-div{
      width: 100%;
      min-height: 450px;
    }
  </style>
</head>
<body>
  <div class="container mx-auto my-12 text-center">
    <div class="text-center my-4">
      <a href="dashboard.php"><img src="img/weather-logo-long-small.png" class="mx-auto" alt=""></a>
    </div>
    <div class="compare-sec my-4">
      <button type="button" id="date-range-btn" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        Custom Date Range
      </button>
    </div>
  </div>

  <div id="chart_temp" class="container my-5 mx-auto"></div>
  <div class="container mx-auto text-center mb-8">
    <div class="inline-flex rounded-md shadow-sm" role="group">
      <button type="button" id="temp_year" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Year
      </button>
      <button type="button" id="temp_month" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Month
      </button>
      <button type="button" id="temp_week" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-l border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Week
      </button>
      <button type="button" id="temp_today" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        Today
      </button>
    </div>
  </div>

  <div id="chart_altitude" class="container my-5 mx-auto"></div>
  <div class="container mx-auto text-center mb-8">
    <div class="inline-flex rounded-md shadow-sm" role="group">
      <button type="button" id="alt_year" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Year
      </button>
      <button type="button" id="alt_month" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Month
      </button>
      <button type="button" id="alt_week" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-l border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Week
      </button>
      <button type="button" id="alt_today" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        Today
      </button>
    </div>
  </div>
  
  <div id="chart_atm_pressure" class="container my-5 mx-auto"></div>
  <div class="container mx-auto text-center mb-8">
    <div class="inline-flex rounded-md shadow-sm" role="group">
      <button type="button" id="atm_year" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Year
      </button>
      <button type="button" id="atm_month" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Month
      </button>
      <button type="button" id="atm_week" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-l border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Week
      </button>
      <button type="button" id="atm_today" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        Today
      </button>
    </div>
  </div>
  
  <div id="chart_rain" class="container my-5 mx-auto"></div>
  <div class="container mx-auto text-center mb-8">
    <div class="inline-flex rounded-md shadow-sm" role="group">
      <button type="button" id="rain_year" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Year
      </button>
      <button type="button" id="rain_month" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Month
      </button>
      <button type="button" id="rain_week" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white border-t border-b border-l border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        This Week
      </button>
      <button type="button" id="rain_today" class="py-2 px-4 text-sm font-medium text-gray-900 bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
        Today
      </button>
    </div>
  </div>
  
  <footer class="mt-10 p-4 text-center bg-gray-100">
    <p>Weather Go &copy;2022</p>
  </footer>

  <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40">
    <div class="relative p-4 w-full mx-auto max-w-md h-full md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" id="modal-top-close" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
            </button>
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>

                <h2 class="text-left text-md mt-3">Start Date:</h2>
                <div class="relative">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                  </div>
                  <input datepicker type="text" id="custom_start_date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                </div>

                <h2 class="text-left text-md mt-3">End Date:</h2>
                <div class="relative mb-3">
                  <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                  </div>
                  <input datepicker type="text" id="custom_end_date" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                </div>
                <button type="button" id="date_range_submit" class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Get Custom Range
                </button>
                <button type="button" id="date-range-modal-close" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
            </div>
        </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script>
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);

    var currweek = new Date(); // get current date
    var weekdaynum = currweek.getDay();
    if(weekdaynum == 0){
      weekdaynum = 6;
    } else{
      weekdaynum = weekdaynum-1;
    }
    var firstweek = currweek.getDate() - weekdaynum;
    var lastweek = firstweek + 6; // last day is the first day + 6

    if((currweek.getDate()-weekdaynum) <= 0){
      var firstweek_lasmonth_lastdate = new Date(currweek.getFullYear(),currweek.getMonth(), 0);
      var firstweek_diff = firstweek_lasmonth_lastdate.getDate()-Math.abs(firstweek);
      var firstweekday = new Date(currweek.getFullYear(),currweek.getMonth()-1,firstweek_lasmonth_lastdate.getDate()+firstweek_diff);
      var lastweekday = new Date(currweek.getFullYear(),currweek.getMonth()-1,firstweek_lasmonth_lastdate.getDate()+firstweek_diff+7);
    } else{
      var firstweekday = new Date(currweek.setDate(firstweek));
      var lastweekday = new Date(currweek.setDate(lastweek));
    }

    
    /* console.log(firstweekday);
    console.log(lastweekday);
    console.log("setdate: "+currweek);
    console.log(firstweek);
    console.log(lastweek);
    console.log(weekdaynum); */


    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart1);
    google.charts.setOnLoadCallback(drawChart2);
    google.charts.setOnLoadCallback(drawChart3);
    google.charts.setOnLoadCallback(drawChart4);

    function drawChart1(customStartDate,customEndDate) {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date of Reading');
      data.addColumn('number', 'Temperature');

      data.addRows([
        <?php
          if (mysqli_num_rows($result) > 0) {
            $temp = $result;
            while($row = mysqli_fetch_assoc($temp)) {
              $read_time = strtotime($row['read_time']. ' - 1 months');
              echo "[new Date(".date('Y', $read_time).", ".date('m', $read_time).", ".date('d', $read_time).",".date('H', $read_time).",".date('i', $read_time).",".date('s', $read_time)."), ".$row['temp']."],";
            }
          }  
        ?>
      ]);


      var options = {
        chart: {
          title: 'August Month Temperature Readings',
          subtitle: 'Temperature Readings for August month of 2022' 
        },
        legend: {
          position: 'top'
        },
        hAxis: {
          viewWindow: {
            min: new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate()),
            max: new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate())
          },
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm', 'ha']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['hh:mm:ss a', 'ha']},
              minutes: {format: ['HH:mm a Z', ':mm']}
            }
          }
        },
        vAxis: {
          gridlines: {color: 'none'},
          minValue: 0
        },
        is3D:true
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_temp'));

      chart.draw(data, options);

      if(customStartDate !== undefined && customEndDate !== undefined){
        options.hAxis.viewWindow.min = customStartDate;
        options.hAxis.viewWindow.max = customEndDate;
        chart.draw(data, options);
      }

      var temp_button_year = document.getElementById('temp_year');
      var temp_button_month = document.getElementById('temp_month');
      var temp_button_week = document.getElementById('temp_week');
      var temp_button_today = document.getElementById('temp_today');

      temp_button_year.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), 01, 01);
        options.hAxis.viewWindow.max = new Date(firstDay.getFullYear(), 12, 31);
        chart.draw(data, options);
      };
      temp_button_month.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate());
        chart.draw(data, options);
      };
      temp_button_week.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstweekday.getFullYear(), firstweekday.getMonth(), firstweekday.getDate());
        options.hAxis.viewWindow.max = new Date(lastweekday.getFullYear(), lastweekday.getMonth(), lastweekday.getDate());
        chart.draw(data, options);
      };
      temp_button_today.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), date.getMonth(), date.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), date.getMonth(), date.getDate()+1);
        chart.draw(data, options);
      };
    }

    function drawChart2(customStartDate,customEndDate) {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Altitude');

      data.addRows([
        <?php
          if (mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while($row = mysqli_fetch_assoc($result)) {
              $read_time = strtotime($row['read_time']. ' - 1 months');
              echo "[new Date(".date('Y', $read_time).", ".date('m', $read_time).", ".date('d', $read_time).",".date('H', $read_time).",".date('i', $read_time).",".date('s', $read_time)."), ".$row['altitude']."],";
            }
          }  
        ?>
      ]);


      var options = {
        chart: {
          title: 'August Month Altitude Readings',
          subtitle: 'Altitude Readings for August month of 2022' 
        },
        colors: ['#F0A500'],
        legend: {
          position: 'top'
        },
        hAxis: {
          viewWindow: {
            min: new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate()),
            max: new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate())
          },
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm', 'ha']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['hh:mm:ss a', 'ha']},
              minutes: {format: ['HH:mm a Z', ':mm']}
            }
          }
        },
        vAxis: {
          gridlines: {color: 'none'},
          minValue: 0
        },
        is3D:true
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_altitude'));

      chart.draw(data, options);

      if(customStartDate !== undefined && customEndDate !== undefined){
        options.hAxis.viewWindow.min = customStartDate;
        options.hAxis.viewWindow.max = customEndDate;
        chart.draw(data, options);
      }

      var alt_button_year = document.getElementById('alt_year');
      var alt_button_month = document.getElementById('alt_month');
      var alt_button_week = document.getElementById('alt_week');
      var alt_button_today = document.getElementById('alt_today');
    
      alt_button_year.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), 01, 01);
        options.hAxis.viewWindow.max = new Date(firstDay.getFullYear(), 12, 31);
        chart.draw(data, options);
      };
      alt_button_month.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate());
        chart.draw(data, options);
      };
      alt_button_week.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstweekday.getFullYear(), firstweekday.getMonth(), firstweekday.getDate());
        options.hAxis.viewWindow.max = new Date(lastweekday.getFullYear(), lastweekday.getMonth(), lastweekday.getDate());
        chart.draw(data, options);
      };
      alt_button_today.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), date.getMonth(), date.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), date.getMonth(), date.getDate()+1);
        chart.draw(data, options);
      };
    }

    function drawChart3(customStartDate,customEndDate) {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Atmospheric pressure');

      data.addRows([
        <?php
          if (mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while($row = mysqli_fetch_assoc($result)) {
              $read_time = strtotime($row['read_time']. ' - 1 months');
              echo "[new Date(".date('Y', $read_time).", ".date('m', $read_time).", ".date('d', $read_time).",".date('H', $read_time).",".date('i', $read_time).",".date('s', $read_time)."), ".$row['atm_pressure']."],";
            }
          }  
        ?>
      ]);


      var options = {
        chart: {
          title: 'August Month Atmospheric pressure Readings',
          subtitle: 'Atmospheric pressure Readings for August month of 2022' 
        },
        colors: ['#DB4437'],
        legend: {
          position: 'top'
        },
        hAxis: {
          viewWindow: {
            min: new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate()),
            max: new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate())
          },
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm', 'ha']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['hh:mm:ss a', 'ha']},
              minutes: {format: ['HH:mm a Z', ':mm']}
            }
          }
        },
        vAxis: {
          gridlines: {color: 'none'},
          minValue: 0
        },
        is3D:true
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_atm_pressure'));

      chart.draw(data, options);

      if(customStartDate !== undefined && customEndDate !== undefined){
        options.hAxis.viewWindow.min = customStartDate;
        options.hAxis.viewWindow.max = customEndDate;
        chart.draw(data, options);
      }

      var atm_button_year = document.getElementById('atm_year');
      var atm_button_month = document.getElementById('atm_month');
      var atm_button_week = document.getElementById('atm_week');
      var atm_button_today = document.getElementById('atm_today');
    
      atm_button_year.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), 01, 01);
        options.hAxis.viewWindow.max = new Date(firstDay.getFullYear(), 12, 31);
        chart.draw(data, options);
      };
      atm_button_month.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate());
        chart.draw(data, options);
      };
      atm_button_week.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstweekday.getFullYear(), firstweekday.getMonth(), firstweekday.getDate());
        options.hAxis.viewWindow.max = new Date(lastweekday.getFullYear(), lastweekday.getMonth(), lastweekday.getDate());
        chart.draw(data, options);
      };
      atm_button_today.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), date.getMonth(), date.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), date.getMonth(), date.getDate()+1);
        chart.draw(data, options);
      };
    }

    function drawChart4(customStartDate,customEndDate) {

      var data = new google.visualization.DataTable();
      data.addColumn('date', 'Date');
      data.addColumn('number', 'Rain Data');

      data.addRows([
        <?php
          if (mysqli_num_rows($result) > 0) {
            mysqli_data_seek($result, 0);
            while($row = mysqli_fetch_assoc($result)) {
              $read_time = strtotime($row['read_time']. ' - 1 months');
              $rain_value = $row['rain_data']-4095;
              echo "[new Date(".date('Y', $read_time).", ".date('m', $read_time).", ".date('d', $read_time).",".date('H', $read_time).",".date('i', $read_time).",".date('s', $read_time)."), ".abs($rain_value)."],";
            }
          }  
        ?>
      ]);


      var options = {
        chart: {
          title: 'August Month Rain Data Readings',
          subtitle: 'Rain Data Readings for August month of 2022' 
        },
        colors: ['#0F9D58'],
        legend: {
          position: 'top'
        },
        hAxis: {
          viewWindow: {
            min: new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate()),
            max: new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate())
          },
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm', 'ha']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['hh:mm:ss a', 'ha']},
              minutes: {format: ['HH:mm a Z', ':mm']}
            }
          }
        },
        vAxis: {
          gridlines: {color: 'none'},
          minValue: 0
        },
        is3D:true
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_rain'));

      chart.draw(data, options);

      if(customStartDate !== undefined && customEndDate !== undefined){
        options.hAxis.viewWindow.min = customStartDate;
        options.hAxis.viewWindow.max = customEndDate;
        chart.draw(data, options);
      }

      var rain_button_year = document.getElementById('rain_year');
      var rain_button_month = document.getElementById('rain_month');
      var rain_button_week = document.getElementById('rain_week');
      var rain_button_today = document.getElementById('rain_today');
    
      rain_button_year.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), 01, 01);
        options.hAxis.viewWindow.max = new Date(firstDay.getFullYear(), 12, 31);
        chart.draw(data, options);
      };
      rain_button_month.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), firstDay.getMonth(), firstDay.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), lastDay.getMonth(), lastDay.getDate());
        chart.draw(data, options);
      };
      rain_button_week.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstweekday.getFullYear(), firstweekday.getMonth(), firstweekday.getDate());
        options.hAxis.viewWindow.max = new Date(lastweekday.getFullYear(), lastweekday.getMonth(), lastweekday.getDate());
        chart.draw(data, options);
      };
      rain_button_today.onclick = function () {
        options.hAxis.viewWindow.min = new Date(firstDay.getFullYear(), date.getMonth(), date.getDate());
        options.hAxis.viewWindow.max = new Date(lastDay.getFullYear(), date.getMonth(), date.getDate()+1);
        chart.draw(data, options);
      };
    }

    $(window).resize(function(){
      drawChart1();
      drawChart2();
      drawChart3();
      drawChart4();
    });
  </script>
  <script>
    const dateRange_modal = document.getElementById('popup-modal');
    const dateRange_btn = document.getElementById('date-range-btn');
    const dateRange_modal_close = document.getElementById('date-range-modal-close');
    const dateRange_modal_top_close = document.getElementById('modal-top-close');
    const custome_date_btn = document.getElementById('date_range_submit');

    custome_date_btn.onclick = function(){
      if($('#custom_start_date').val() && $('#custom_end_date').val()){
        var start_date = $('#custom_start_date').val();
        var end_date = $('#custom_end_date').val();
        if(moment(start_date, "MM/DD/YYYY", true).isValid() && moment(end_date, "MM/DD/YYYY", true).isValid()){
          dateRange_modal.classList.toggle('hidden');
          start_date = moment(start_date, 'MM/DD/YYYY').toDate();
          end_date = moment(end_date, 'MM/DD/YYYY').toDate();
          drawChart1(start_date, end_date);
          drawChart2(start_date, end_date);
          drawChart3(start_date, end_date);
          drawChart4(start_date, end_date);
        }
      }
    }

    dateRange_btn.addEventListener('click', (e) =>{
      e.preventDefault();
      dateRange_modal.classList.toggle('hidden');
    })
    dateRange_modal_close.addEventListener('click', (e) =>{
      e.preventDefault();
      dateRange_modal.classList.toggle('hidden');
    })
    dateRange_modal_top_close.addEventListener('click', (e) =>{
      e.preventDefault();
      dateRange_modal.classList.toggle('hidden');
    })

  </script>
</body>
</html>