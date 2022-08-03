<?php
$servername = "localhost";
//$username = "id18998038_dulan";
//$password = "+0hgmmnN/hw\Tm??";
//$database = "id18998038_weathergo";

$username = "dulan";
$password = "good";
$database = "weather_db";

$conn = mysqli_connect($servername,$username,$password,$database);

// Check connection
if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  exit();
}
?>