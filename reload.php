<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

if (isset($_POST['idd'])) 
{
  extract($_POST);

  $query_admin2 = $mysqli->query("SELECT * FROM `admin` WHERE matric_id='$idd'");
  $row_admin2 = $query_admin2->fetch_assoc();
  $totalRows_admin2 = $query_admin2->num_rows;

  $user_id = $row_admin2['admin_id'];

  $wallet_id = md5($user_id.microtime(true));

  if (isset($row_admin2['id'])) 
  {
     $sql = "INSERT INTO wallet(`balance`, `user_id`, `type`, `wallet_id`) VALUES ('$amount', '$user_id', 1, '$wallet_id')";

    if (mysqli_query($mysqli, $sql)) {
        $insertGoTo = "reload.php?notif=success";
        header(sprintf("Location: %s", $insertGoTo));
    } else {
        $insertGoTo = "reload.php?notif=failed";
        header(sprintf("Location: %s", $insertGoTo));
    }
  }
  else
  {
    $insertGoTo = "reload.php?notif=failed";
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
          <form action="reload.php" method="POST">

            <label for="uname"><b>Matric/Staff ID</b></label>
            <input type="text" placeholder="Enter Matric/Staff ID" name="idd" required value="">

            <label for="uname"><b>Reload Amount (RM)</b></label>
            <input type="text" placeholder="Enter Reload Amount" name="amount" required value="">

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
