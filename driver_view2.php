<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];
$pass = $_GET['pass'];

$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE driver_id='$pass'");
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
  <div class="row content" style="margin-right: 0px; margin-left: 0px;">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>

    <div class="container col-sm-10">

      <div class="well row" style="width: 50%; margin: auto;">
        <h4 class="uppercase">Driver Manager</h4>
        <div class="col-sm-12">
          <br>
            <label class="new-row" for="uname"><b>Licence Number :<pre><?=$row_driver['licence_number']?></pre></b></label><br>

            <label class="new-row" for="uname"><b>Licence Copy :<pre><a target="_blank" href="<?=$row_driver['licence_copy']?>"><?=str_replace("img/receipt/","", $row_driver['licence_copy'])?></a></pre></b></label><br>

            <label class="new-row" for="uname"><b>Expiry Date :<pre><?=date('d M Y', strtotime($row_driver['expiry']))?></pre></b></label><br>

            <label class="new-row" for="uname"><b>Nationality :<pre><?php if($row_driver['nationality'] == 1){echo 'Malaysian'; }else{echo "Foreigner";}?></pre></b></label><br>

            <input type="hidden" name="driver_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <a href="approval.php?status=1&pass=<?=$row_driver['driver_id']?>"><button class="btn btn-primary">APPROVE</button></a>
              <a href="approval.php?status=3&pass=<?=$row_driver['driver_id']?>"><button class="btn btn-primary">REJECT</button></a>
              <a href="home.php"><button type="button" class="btn btn-white">Cancel</button></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
