<?php include('config.php');
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

if (isset($_POST['date'])) 
{
  extract($_POST);

  $sewa_id = md5($date.microtime(true));

  $datetime = date('Y-m-d H:i:s', strtotime($date." ". $time));

  $day_start = date('Y-m-d 00:00:00', strtotime($date));

  $day_end = date('Y-m-d 23:59:59', strtotime($date));

  $start = $datetime;

  $end = date('Y-m-d H:i:s', strtotime($start.$hour.'hours'));

  $query_sewa = $mysqli->query("SELECT * FROM `sewa` WHERE car_id='$car_id' AND (datetime_start BETWEEN '$day_start' AND '$day_end')");
  $row_sewa = $query_sewa->fetch_assoc();
  $totalRows_sewa = $query_sewa->num_rows;

  $tt = 1;

  do
  {

    if (strtotime($datetime) > strtotime($row_sewa['datetime_start']) && strtotime($datetime) < strtotime($row_sewa['datetime_end']))
    {
      $tt = 0;
      break;
    }

    if (strtotime($row_sewa['datetime_start']) < strtotime($end) && strtotime($row_sewa['datetime_end']) > strtotime($end)) 
    {
      $tt = 0;
      break;
    }

  }while($row_sewa = $query_sewa->fetch_assoc());

  if ($tt == 1) 
  {
    $sql = "INSERT INTO `sewa`(`datetime_start`, `hour`, `datetime_end`, `car_id`, `status`, `customer_id`, `sewa_id`) VALUES ('$datetime', '$hour', '$end', '$car_id',0, '$admin_id', '$sewa_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "booking.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "booking.php?notif=failed";
      header(sprintf("Location: %s", $insertGoTo));
  }
  }
  else
  {
    $insertGoTo = "booking.php?notif=booked";
      header(sprintf("Location: %s", $insertGoTo));
  }

  
}


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
  <script src="vendor/jquery2.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link href="vendor/sweetalert2.css" rel="stylesheet">
</head>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="row content" style="margin-right: 0px; margin-left: 0px;">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well row" style="width: 50%; margin: auto;">
        <h4 class="uppercase">Sewa Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="sewa.php" method="POST" enctype="multipart/form-data">

            <label for="uname"><b>Date</b></label>
            <input name="date" placeholder="Enter Date" type="date" class="street" style="margin-bottom: 10px; border-radius: 0px;" />

            <label for="uname"><b>Start Time</b></label>
            <input name="time"  type="time" class="street" style="margin-bottom: 10px; border-radius: 0px;" />

            <label for="uname"><b>Hour(s)</b></label>
            <input name="hour" value="1" type="number" class="street" style="margin-bottom: 10px; border-radius: 0px;" />

            <select name="car_id">
              <?php

              $query_car = $mysqli->query("SELECT * FROM `car` WHERE status=1");
              $row_car = $query_car->fetch_assoc();
              $totalRows_car = $query_car->num_rows;

              do
              {

                ?>
                <option value="<?=$row_car['car_id']?>"><?=$row_car['car_model']?> ( <?=$row_car['transmission']?> - <?=$row_car['color']?> )</option>
                <?php

              }while($row_car = $query_car->fetch_assoc());
              ?>
            </select>
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">Rent</button>
              <a href="driver.php"><button type="button" class="btn btn-white">Cancel</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

<script src="vendor/sweetalert2.js"></script>

<?php if (isset($_GET['notif'])) { ?>
<?php $notif = $_GET['notif']; if ($notif == "booked") { ?>
    <script type="text/javascript">
      $(document).ready(function () {
      swal({
        type: 'error',
        title: 'Car and Date Already Booked!',
      });
      });
    </script>
  <?php } ?>

    <?php } ?>
</body>
</html>
