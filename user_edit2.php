<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$pass = $_GET["pass"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$pass'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

if (isset($_POST['fullname'])) 
{
  extract($_POST);

  $sql = "UPDATE `admin` SET `fullname`='$fullname',`matric_id`='$matric_id',`username`='$username',`email`='$email',`contact`='$contact',`password`='$password' WHERE `admin_id`='$admin_id'";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "home.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "home.php?notif=failed";
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
        <h4 class="uppercase">User Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="user_edit.php" method="POST">
            <label for="uname"><b>Full Name</b></label>
            <input type="text" placeholder="Enter Full Name" name="fullname" required value="<?=$row_admin['fullname']?>">

            <label for="uname"><b>Matric ID</b></label>
            <input type="text" placeholder="Enter Matric ID" name="matric_id" required value="<?=$row_admin['matric_id']?>">

            <label for="uname"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="username" required value="<?=$row_admin['username']?>">

            <label for="uname"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required value="<?=$row_admin['email']?>">

            <label for="uname"><b>Contact</b></label>
            <input type="text" placeholder="Enter Contact" name="contact" required value="<?=$row_admin['contact']?>">

            <label for="psw"><b>New Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required value="<?=$row_admin['password']?>">

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">SAVE</button>
              <a href="home.php"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
