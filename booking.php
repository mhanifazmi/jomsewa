<?php include('config.php');?>
<?php

session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE status=2");
$row_driver = $query_driver->fetch_assoc();
$totalRows_driver = $query_driver->num_rows;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>JOM SEWA</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  if ($row_setting['style'] == 1) {
    echo "<link rel='stylesheet' href='vendor/style2.css'>";
  }
  else
  {
     echo "<link rel='stylesheet' href='vendor/style.css'>";
  };
  ?>
  
  <link rel="stylesheet" href="vendor/fontawesome.css">
  <link rel="stylesheet" href="vendor/style3.css">
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="content">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>


    <div class="title-box col-sm-10">

      <div class="well">
        <h4>Title</h4>
      </div>
    </div>

  <div class="container col-sm-10">

      <div class="well" style="display: inline-block; margin: auto;text-align: center; width: 100%;">
        <h4>Booking Manager</h4>
        <a href="sewa.php"><button class="hov"> SEWA</button></a>

        <a href="taxi.php"><button class="hov"> TAXI</button></a>
      </div>
    </div>
    
  </div>
</div>

</body>
</html>
