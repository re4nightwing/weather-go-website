<?php
session_start();
include_once 'conn.php';

if(isset($_POST['delete_submit'])){
  $user_key = $_POST['user_email'];
  $del_query = "DELETE FROM `user_data` WHERE `user_email`='".$user_key."'";
  if (!mysqli_query($conn, $del_query)) {
    ?>
    <script>
      alert("An error occured while deleting your account.");
    </script>
    <?php
  }
}
if(isset($_SESSION['username']) && $_SESSION['username']!=''){
  $query = "SELECT * FROM `user_data` WHERE `username`='".$_SESSION['username']."' LIMIT 1";
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result)>0){
    $user_data = mysqli_fetch_assoc($result);
    $query = "SELECT * FROM `device_data` WHERE `device_owner_email`='".$user_data['user_email']."'";
    $device_result = mysqli_query($conn, $query);
    if(mysqli_num_rows($device_result)>0){
      $no_devices = false;
      $number_of_devices = mysqli_num_rows($device_result);
    } else{
      $no_devices = true;
      $number_of_devices = 0;
    }
  } else{
    header('Location:logout.php');
  }
} else{
  header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
  <!-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" /> -->
  <link rel="icon" type="image/png" href="img/weather-logo.png" />
  <title>Dashboard | Weather Go</title>
</head>
<body>
  <nav class="relative container mx-auto p-6">
    <div class="flex items-center justify-between">
      <div class="pt-2">
        <img src="img/weather-logo.png" alt="Weather Go" height="52px">
      </div>
      <div class="hidden md:flex space-x-6">
        <p>Hello, <b><?php echo $_SESSION['username'];?></b></p>
      </div>
      <div class="flex justify-center">
        <a href="" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-emerald-700 rounded-md shadow baseline hover:bg-emerald-600 add-btn">Add Device</a>
        <a href="logout.php" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600">Log Out</a>
      </div>
      <button id="menu-btn" class="block hamburger md:hidden focus:outline-none">
        <span class="hamburger-top"></span>
        <span class="hamburger-middle"></span>
        <span class="hamburger-bottom"></span>
      </button>
    </div>
  </nav>
  <div class="md:hidden">
    <div id="menu" class="absolute flex-col items-center z-10 hidden self-end py-8 space-y-6 font-bold bg-white sm:w-auto sm:self-center left-6 right-6 drop-shadow-md">
      <p>Hello, <?php echo $_SESSION['username'];?></p>
      <div class="flex justify-center">
        <a href="" class="p-3 mx-2 px-6 pt-3 text-white bg-emerald-700 rounded-md shadow baseline hover:bg-emerald-600 add-btn">Add Device</a>
        <a href="logout.php" class="p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600">Log Out</a>
      </div>
    </div>
  </div>
  
  <section class="dash-content container mx-auto my-6" style="min-height: 70vh;">
    <div class="flex flex-col justify-around md:flex-row">
      <div class="rounded-lg shadow-lg backdrop-opacity-10 bg-veryLightGray p-6 m-4 md:w-1/3">
        <h2 class="text-2xl font-bold text-center text-slate-800">
          User Details
        </h2>
        <p class="mt-5"><b>Username: </b><?php echo $_SESSION['username'];?></p>
        <p class="mt-4"><b>Email: </b><?php echo $user_data['user_email'];?></p>
        <p class="mt-4"><b>Created on: </b><?php echo $user_data['created'];?></p>
        <p class="mt-4"><b>Active Devices: </b><?php echo "0".$number_of_devices;?></p>
        <form action="" method="post" class="mt-6" onsubmit="return confirm('This action is irreversible and all devices and the user account will be deleted. Are you sure ?');">
          <input type="hidden" name="user_email" value="<?php echo $user_data['user_email'];?>">
          <button type="submit" name="delete_submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
            Delete Account
          </button>
        </form>
      </div>
      <div class="rounded-lg shadow-lg backdrop-opacity-10 bg-veryLightGray p-6 m-4 md:w-2/3">
        <h2 class="text-2xl font-bold text-center text-slate-800">
          User Devices
        </h2>
        <?php
        if($no_devices){
          ?>
          <div class="border-dashed border-2 border-slate-300 text-slate-400 text-center p-6 rounded-lg mt-5">
            There are no registered devices under this user. Add new devices to monitor weather.
          </div>
          <?php
        } else{
          while($registered_device = mysqli_fetch_assoc($device_result)){
            ?>
            <div class="flex flex-col items-center justify-between md:flex-row rounded-lg shadow-md bg-white p-4 mt-4">
              <div class="device">
                <p><b><?php echo $registered_device['device_name'];?></b></p>
                <p class="text-sm"><b>Device ID:</b> <?php echo $registered_device['device_id'];?></p>
                <p class="text-sm"><b>Created:</b> <?php echo $registered_device['created'];?></p>
                <p class="text-sm"><?php echo "@".$registered_device['location'];?></p>
              </div>
              <div class="device-monitor">
                <button type="button" id="<?php echo $registered_device['device_id'];?>" onclick="getMonitor(this.id)" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-amber-500 text-base font-medium text-white hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-400 sm:ml-3 sm:w-auto sm:text-sm">Monitor Device</button>
                <button type="button" id="<?php echo $registered_device['device_id'];?>" onclick="deleteDevice(this.id)" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-2 py-2 bg-red-500 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 sm:ml-3 sm:w-auto sm:text-sm"><i class='bx bx-x'></i></button>
              </div>
            </div>
            <?php
          }
        }
        ?>
        <div class="text-center m-6">
          <a href="" class="p-3 px-6 pt-3 text-white bg-emerald-700 rounded-md shadow baseline hover:bg-emerald-600 add-btn">Add Device</a>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-amber-600">
    <div class="container flex flex-col-reverse justify-between px-6 py-10 mx-auto space-y-8 md:flex-row md:space-y-0">
      <div class="flex flex-col-reverse items-center justify-between space-y-12 md:flex-col md:space-y-0 md:items-start">
        <div class="mx-auto my-4 text-center text-white md:hidden">
          <p class="text-sm">Copyright &copy; 2022, All Rights Reserved.</p>
        </div>
        <div>
          <img src="img/weather-logo.png" class="h-8" alt="">
        </div>
        <div class="flex justify-center space-x-4">
          <a href="#">
            <img src="img/facebook.png" class="h-8" alt="">
          </a>
          <a href="#">
            <img src="img/instagram.png" class="h-8" alt="">
          </a>
          <a href="#">
            <img src="img/twitter.png" class="h-8" alt="">
          </a>
        </div>
      </div>
      <div class="flex justify-around space-x-32">
        <div class="flex flex-col space-y-3 text-white text-center md:text-left">
          <a href="index.php#top" class="hover:text-cyan-900">Home</a>
          <a href="index.php#product" class="hover:text-cyan-900">Product</a>
          <a href="index.php#howto" class="hover:text-cyan-900">How to</a>
          <a href="index.php#about" class="hover:text-cyan-900">About</a>
          <p class="hidden text-sm md:block">Copyright &copy; 2022, All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

<div class="relative z-10 hidden" id="login-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 opacity-75 transition-opacity"></div>
  <div class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
      <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
        <div class="register-form">
          <h2 class="text-2xl font-bold text-center pt-6">
            Add New Device
          </h2>
          <form action="" method="POST" class="bg-white px-8 pt-6 pb-8 mb-4">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="device-name">
                Device Name: <span class="font-medium">(A unique name to identify your device)</span>
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="device-name" type="text" name="device-name" placeholder="Unique Name" required>
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="loc-name">
                Location:
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="loc-name" type="text" name="loc-name" placeholder="Device General Location" required>
            </div>
            <div class="flex items-center justify-between">
              <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" name="device_submit" type="submit">
                Register Device
              </button>
            </div>
          </form>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  if(isset($_POST['device_submit'])){
    $device_name = $_POST['device-name'];
    $device_loc = $_POST['loc-name'];
    $device_id = uniqid('device_');
    $device_key = uniqid('device_key_');
    $new_device_query = "INSERT INTO `device_data`(`device_id`, `device_name`, `device_key`, `device_owner_email`, `location`) VALUES ('".$device_id."','".$device_name."','".$device_key."','".$user_data['user_email']."','".$device_loc."')";
    if (!mysqli_query($conn, $new_device_query)) {
      ?>
      <script>
        alert("An error occured while adding new device.");
      </script>
      <?php
    } else{
    ?>
<div class="relative z-10" id="device-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 opacity-75 transition-opacity"></div>
  <div class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
      <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
        <div class="device-form p-4">
          <h2 class="text-2xl font-bold text-center pt-6">
            New Device Details
          </h2>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="device-name">
              New Device Name:
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" value="<?php echo $device_name; ?>" readonly>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="device-name">
              New Device Location:
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" value="<?php echo $device_loc; ?>" readonly>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="device-name">
              New Device ID:
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" value="<?php echo $device_id; ?>" readonly>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="device-name">
              New Device Secret Key: (Do not share this key with anyone.)
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" value="<?php echo $device_key; ?>" readonly>
          </div>
          <p><b class="text-red-500">Caution:</b> Copy and save <b>New Device ID</b> value and <b>New Device Secret Key</b> value somewhere safe before closing this window!</p>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="close-new-device-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  const device_modal = document.getElementById('device-modal');
  const close_device_btn = document.getElementById('close-new-device-modal');
  close_device_btn.addEventListener('click', (e) =>{
    e.preventDefault();
    device_modal.classList.toggle('hidden');
    window.location.href = "dashboard.php";
  })
</script>
    <?php
    }
  }
  mysqli_close($conn);
?>

  <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
  <script>
    const login_modal = document.getElementById('login-modal');
    const close_modal_btn = document.getElementById('close-modal');
    const add_device_btn = document.querySelectorAll('.add-btn');

    add_device_btn.forEach(el => el.addEventListener('click', event => {
      event.preventDefault();
      login_modal.classList.toggle('hidden');
    }));

    close_modal_btn.addEventListener('click', (e) =>{
      e.preventDefault();
      login_modal.classList.toggle('hidden');
    })

    function getMonitor(device){
      window.location.href = "device-monitor.php?id="+device;
    }

    function deleteDevice(device){
      if(confirm("Are you sure?")){
        request = $.ajax({
          url: "delete-device.php",
          type: "post",
          data: {
            'device_name':device
          }
        });

        request.done(function (response, textStatus, jqXHR){
          console.log("Hooray, it worked!");
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
          console.error(
            "The following error occurred: "+
            textStatus, errorThrown
          );
        });

        request.always(function () {
          window.location.href = 'dashboard.php';
        });
      }
    }

  </script>
</body>
</html>