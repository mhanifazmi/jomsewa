<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

if (isset($_POST['car_plat'])) 
{
  extract($_POST);

  $car_id = md5($car_model.microtime(true));

  $sql = "INSERT INTO car(car_plat, car_model, transmission, color, status, car_id, admin_id) VALUES ('$car_plat', '$car_model', '$transmission', '$color',  1, '$car_id', '$admin_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "car.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "car.php?notif=failed";
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
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="row content" style="margin-right: 0px; margin-left: 0px;">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well row" style="width: 50%; margin: auto;">
        <h4 class="uppercase">Car Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="car_add.php" method="POST">
            <label for="uname"><b>Car Model</b></label>
            <input type="text" placeholder="Enter Car Model" name="car_model" required value="">

            <label for="uname"><b>Plat Number</b></label>
            <input type="text" placeholder="Enter Plat Number" name="car_plat" required value="">

            <label for="uname"><b>Colour</b></label>
            <input type="text" placeholder="Enter Colour" name="color" required value="">

            <label for="uname"><b>Transmission</b></label>
            <select name="transmission">
              <option value="auto">Auto</option>
              <option value="manual">Manual</option>
            </select>

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">SAVE</button>
              <a href="car.php"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
