<?php
session_start();
if(isset($_POST['reg_submit'])){
  include_once 'conn.php';
  $reg_username = $_POST['reg_username'];
  $reg_email = $_POST['reg_email'];
  $reg_password = $_POST['reg_password'];
  $hased_pswd = password_hash($reg_password, PASSWORD_DEFAULT);

  $query = "INSERT INTO `user_data`(`username`, `user_email`, `password`) VALUES ('".$reg_username."','".$reg_email."','".$hased_pswd."')";
  if (mysqli_query($conn, $query)) {
    ?>
    <script>
      alert("New user added successfully!");
    </script>
    <?php
  } else {
    ?>
    <script>
      alert("An error occured while creating a new user. Please try again.");
    </script>
    <?php
  }
  mysqli_close($conn);
}
if(isset($_POST['login_submit'])){
  include_once 'conn.php';
  $login_username = $_POST['login_username'];
  $login_password = $_POST['login_password'];

  $query = "SELECT * FROM `user_data` WHERE `username`='".$login_username."' ";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result)>0){
    $row = mysqli_fetch_assoc($result);
    if(password_verify($login_password, $row['password'])){
      $_SESSION['username'] = $row['username'];
      header("Location:dashboard.php");
    } else{
      ?>
      <script>
        alert("Invalid login credentials please try again.");
      </script>
      <?php
    }
  } else{
    ?>
    <script>
      alert("Invalid login credentials please try again.");
    </script>
    <?php
  }
  
  mysqli_close($conn);
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
  <title>Welcome | Weather Go</title>
  <link rel="icon" type="image/png" href="img/weather-logo.png" />
</head>
<body>
  <nav class="relative container mx-auto p-6">
    <div class="flex items-center justify-between">
      <div class="pt-2">
        <img src="img/weather-logo.png" alt="Weather Go" height="52px">
      </div>
      <div class="hidden md:flex space-x-6">
        <a href="#Top" class="hover:text-darkGrayishBlue">Home</a>
        <a href="#product" class="hover:text-darkGrayishBlue">Product</a>
        <a href="#howto" class="hover:text-darkGrayishBlue">How to</a>
        <a href="#about" class="hover:text-darkGrayishBlue">About</a>
      </div>
      <div class="flex justify-center">
        <?php
        if(isset($_SESSION['username']) && $_SESSION['username']!=''){
          echo '<a href="dashboard.php" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-amber-600 rounded-md shadow baseline hover:bg-amber-500">Dashboard</a>';
          echo '<a href="logout.php" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600">Log Out</a>';
        } else{
          echo '<a href="" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600"  id="login-btn">Sign In</a>';
        }
        ?>
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
      <a href="#top" class="hover:text-darkGrayishBlue">Home</a>
      <a href="#product" class="hover:text-darkGrayishBlue">Product</a>
      <a href="#howto" class="hover:text-darkGrayishBlue">How to</a>
      <a href="#about" class="hover:text-darkGrayishBlue">About</a>
      <div class="flex justify-center">
        <?php
        if(isset($_SESSION['username']) && $_SESSION['username']!=''){
          echo '<a href="dashboard.php" class="p-3 mx-2 px-6 pt-3 text-white bg-amber-600 rounded-md shadow baseline hover:bg-amber-500">Dashboard</a>';
          echo '<a href="logout.php" class="p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600">Log Out</a>';
        } else{
          echo '<a href="" class="p-3 mx-2 px-6 pt-3 text-white bg-cyan-700 rounded-md shadow baseline hover:bg-cyan-600"  id="mobile-login-btn">Sign In</a>';
        }
        ?>
      </div>
    </div>
  </div>
  <section id="hero" class="relative">
    <div class="container mx-auto items-center h-56 bg-cyan-900"></div>
    <div class="container mx-auto items-center h-36 bg-cyan-800"></div>
    <div class="absolute py-4 px-6 rounded-lg top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white backdrop-blur-sm bg-cyan-50/20 outline-offset-2 outline-2 shadow-lg shadow-cyan-500/50">
      <h1 class="text-5xl font-bold">Weather Go</h1>
      <p class="text-base font-light">Your weather report on the go. Easy. Fast. Reliable.</p>
    </div>
  </section>

  <section class="container mx-auto mt-32">
    <h2 class="text-4xl font-bold text-center">
      Product 3D View
    </h2>
    <iframe style="width: 100%;" class="mt-10" height="640" allowfullscreen src="https://v3d.net/9nm"></iframe>
  </section>

  <section class="container mx-auto mt-32" id="product">
    <h2 class="text-4xl font-bold text-center">
      Product Types
    </h2>
    <div class="flex flex-col mt-24 md:flex-row md:space-x-6">
      <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/2">
        <img src="img/kit1.jpg" class="w-auto rounded-lg" alt="Plug-N-Use Kit">
        <h5 class="text-lg font-bold before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-sky-500 relative px-4"><span class="relative text-white">Plug-N-Use</span></h5>
        <p class="text-sm text-darkGrayishBlue">This Product can be used directly without any calibarations or configurations. User only has to create a account and register the device. As the name suggests, get the product, plug it in and use it. As easy as that.</p>
        <ul class="list-inside list-disc text-darkGrayishBlue marker:text-sky-400">
          <li>Plug-N-Use</li>
          <li>No Coding</li>
          <li>No Configurations</li>
        </ul>
        <h5 class="text-xl font-bold">Rs. --.--</h5>
        <a href="" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-green-600 rounded-md shadow baseline hover:bg-green-500">Pre-Order Now</a>
      </div>
      <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/2">
        <img src="img/kit0.jpg" class="w-auto rounded-lg" alt="Learner Kit">
        <h5 class="text-lg font-bold before:block before:absolute before:-inset-1 before:-skew-y-3 before:bg-sky-500 relative px-4"><span class="relative text-white">Learn-N-Use</span></h5>
        <p class="text-sm text-darkGrayishBlue">This is the educational product created by WeatherGo Team. User will recieve all the electronic components and the 3D printed enclosure. The way to connect and monitor device will be provided as an manual or can refer our "How to?" Section.</p>
        <ul class="list-inside list-disc text-darkGrayishBlue marker:text-sky-400">
          <li>Learn-N-Use</li>
          <li>Highly recommended for students</li>
          <li>User can code and configure the device as they want to.</li>
        </ul>
        <h5 class="text-xl font-bold">Rs. --.--</h5>
        <a href="" class="hidden md:block p-3 mx-2 px-6 pt-3 text-white bg-green-600 rounded-md shadow baseline hover:bg-green-500">Pre-Order Now</a>
      </div>
    </div>
  </section>

  <section class="p-4 mt-32" id="howto">
    <h2 class="text-4xl font-bold text-center">
      How to?
    </h2>
    <div class="container mx-auto mt-10">
      <h2 id="accordion-example-heading-1">
        <button type="button" class="flex justify-between items-center p-5 w-full font-medium text-left text-gray-500 rounded-t-xl border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="true" aria-controls="accordion-example-body-1">
          <span>What is Weather Go?</span>
          <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-example-body-1" class="hidden" aria-labelledby="accordion-example-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">Weather Go allows users to connect their weather devices and monitor the weather data in real-time. Once registered, access your weather data in any time range you need. Quickly visualise your data in the way you want in a set weather timeline with graphs and charts to derive insight from your device's weather reports. With Weather Go, users can access the data sent by their devices at any time and anywhere, literally on the go. </p>
        </div>
      </div>
      <h2 id="accordion-example-heading-2">
        <button type="button" class="flex justify-between items-center p-5 w-full font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false" aria-controls="accordion-example-body-2">
          <span>What is Plug-N-Use Product?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-example-body-2" class="hidden" aria-labelledby="accordion-example-heading-2">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">Manage all your weather devices in one place with Weather Go. No calibration or configurations are needed, simply create an account and register your device. Allows you to add any number of devices with our simple interface. Quick and easy to monitor, change, and track your weather reporting.</p>
        </div>
      </div>
      <h2 id="accordion-example-heading-3">
        <button type="button" class="flex justify-between items-center p-5 w-full font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false" aria-controls="accordion-example-body-3">
          <span>What is Learn-N-Use Product?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-example-body-3" class="hidden" aria-labelledby="accordion-example-heading-3">
        <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">This exclusive educational setup is designed especially for the students. Every Learn-N-Use customer receives their package with all electronic components and the 3D printed enclosure. </p>
          <p class="mb-2 text-gray-500 dark:text-gray-400">Components include:</p>
          <ul class="pl-5 list-disc text-gray-500 dark:text-gray-400">
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">ESP32 Lolin32 Module</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">BMP280 Module (Temperature, Barometric Pressure, Altitude)</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">Raindrops Detection Sensor Module</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">Voltage Step Up Converter</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">3.7V Battery 3200mAh X 2</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">Weather Go Casing</a></li>
            <li><a href="" class="text-blue-600 dark:text-blue-500 hover:underline">USB Cable</a></li>
          </ul>
          <br>
          GitHub: <a href="https://github.com/re4nightwing/Weather-Go-IoT-code" class="text-blue-600 dark:text-blue-500 hover:underline">Default Code</a>
        </div>
      </div>
      <h2 id="accordion-example-heading-4">
        <button type="button" class="flex justify-between items-center p-5 w-full font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-expanded="false" aria-controls="accordion-example-body-4">
          <span>How to register?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-example-body-4" class="hidden" aria-labelledby="accordion-example-heading-4">
        <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">Visit our Sign-up page and complete the user information form. Once you create the account, you can sign in and begin adding your weather devices. A Weather Go account is required to view your data from the devices.</p>
        </div>
      </div>
    </div>
  </section>

  <section id="about">
    <div class="max-w-6xl px-5 mx-auto mt-32 text-center">
      <h2 class="text-4xl font-bold text-center">
        Meet the Team
      </h2>
      <div class="flex flex-col mt-24 md:flex-row md:space-x-6">
        <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/3">
          <img src="img/man.png" class="w-16 -mt-14 rounded-full" alt="">
          <h5 class="text-lg font-bold">Dulan Pabasara</h5>
          <p class="text-sm text-darkGrayishBlue">IoT Developer, Web Backend Developer</p>
        </div>
        <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/3">
          <img src="img/man.png" class="w-16 -mt-14 rounded-full" alt="">
          <h5 class="text-lg font-bold">Wageesga Isira</h5>
          <p class="text-sm text-darkGrayishBlue">Web Designer</p>
        </div>
        <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/3">
          <img src="img/man.png" class="w-16 -mt-14 rounded-full" alt="">
          <h5 class="text-lg font-bold">Devindi Gamlath</h5>
          <p class="text-sm text-darkGrayishBlue">UI/UX designer, Content Creator</p>
        </div>
      </div>
      <div class="flex flex-col justify-around md:flex-row md:space-x-6">
        <div class="flex flex-col items-center p-6 mb-10 space-y-6 rounded-lg bg-veryLightGray md:w-1/3">
          <img src="img/man.png" class="w-16 -mt-14 rounded-full" alt="">
          <h5 class="text-lg font-bold">Hiran Hettiarachchi</h5>
          <p class="text-sm text-darkGrayishBlue">Android App Developer</p>
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
          <a href="#top" class="hover:text-cyan-900">Home</a>
          <a href="#product" class="hover:text-cyan-900">Product</a>
          <a href="#howto" class="hover:text-cyan-900">How to</a>
          <a href="#about" class="hover:text-cyan-900">About</a>
          <p class="hidden text-sm md:block">Copyright &copy; 2022, All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>
  <!-- This example requires Tailwind CSS v2.0+ -->
<div class="relative z-10 hidden" id="login-modal" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="fixed inset-0 bg-gray-500 opacity-75 transition-opacity"></div>

  <div class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
      <div class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full">
        <div class="flex flex-col justify-around md:flex-row">
          <div class="register-form">
            <h2 class="text-2xl font-bold text-center pt-6">
              Sign Up
            </h2>
            <form action="" method="POST" class="bg-white px-8 pt-6 pb-8 mb-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                  Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="reg_username" placeholder="Username" required>
              </div>
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                  Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="email" name="reg_email" placeholder="E-Mail" required>
              </div>
              <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                  Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="reg_password" placeholder="******************" required>
              </div>
              <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" name="reg_submit" type="submit">
                  Sign Up
                </button>
              </div>
            </form>
          </div>
          <div class="login-form">
            <h2 class="text-2xl font-bold text-center pt-6">
              Sign In
            </h2>
            <form action="" method="POST" class="bg-white px-8 pt-6 pb-8 mb-4">
              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                  Username
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" name="login_username" placeholder="Username" required>
              </div>
              <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                  Password
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" name="login_password" placeholder="******************" required>
              </div>
              <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" name="login_submit" type="submit">
                  Sign In
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <button type="button" id="close-modal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</div>
  <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
  <script src="js/script.js"></script>
  <script>
    const login_modal = document.getElementById('login-modal');
    const login_btn = document.getElementById('login-btn');
    const mob_login_btn = document.getElementById('mobile-login-btn');
    const close_modal_btn = document.getElementById('close-modal');

    login_btn.addEventListener('click', (e) =>{
      e.preventDefault();
      login_modal.classList.toggle('hidden');
    })

    close_modal_btn.addEventListener('click', (e) =>{
      e.preventDefault();
      login_modal.classList.toggle('hidden');
    })

    // create an array of objects with the id, trigger element (eg. button), and the content element
const accordionItems = [
    {
        id: 'accordion-example-heading-1',
        triggerEl: document.querySelector('#accordion-example-heading-1'),
        targetEl: document.querySelector('#accordion-example-body-1'),
        active: true
    },
    {
        id: 'accordion-example-heading-2',
        triggerEl: document.querySelector('#accordion-example-heading-2'),
        targetEl: document.querySelector('#accordion-example-body-2'),
        active: false
    },
    {
        id: 'accordion-example-heading-3',
        triggerEl: document.querySelector('#accordion-example-heading-3'),
        targetEl: document.querySelector('#accordion-example-body-3'),
        active: false
    },
    {
        id: 'accordion-example-heading-4',
        triggerEl: document.querySelector('#accordion-example-heading-4'),
        targetEl: document.querySelector('#accordion-example-body-4'),
        active: false
    }
];

// options with default values
const options = {
    alwaysOpen: true,
    activeClasses: 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white',
    inactiveClasses: 'text-gray-500 dark:text-gray-400',
    onOpen: (item) => {
        console.log('accordion item has been shown');
        console.log(item);
    },
    onClose: (item) => {
        console.log('accordion item has been hidden');
        console.log(item);
    },
    onToggle: (item) => {
        console.log('accordion item has been toggled');
        console.log(item);
    },
};

const accordion = new Accordion(accordionItems, options);

  </script>
</body>
</html>