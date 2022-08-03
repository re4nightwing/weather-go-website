<?php
if(isset($_POST['device_name'])){
  include_once 'conn.php';
  $query = "DELETE FROM `device_data` WHERE `device_id`='".$_POST['device_name']."'";
  if (mysqli_query($conn, $query)) {
    echo "{'code': 200, 'msg': 'Device Deleted from the database'}";
  } else{
    echo "{'code': 500, 'msg': 'Execution error'}";
  }
  mysqli_close($conn);
}