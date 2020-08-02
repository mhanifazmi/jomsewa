<?php include('config.php');

session_start();

if (isset($_POST['username'])) 
{
  extract($_POST);

  $admin_id = md5($username);

  $sql = "INSERT INTO admin(username, fullname, matric_id, type, email, contact, password, status, admin_id) VALUES ('$username', '$fullname', '$matric_id', 1, '$email', '$contact', '$password', 1, '$admin_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "index.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "index.php?notif=failed";
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
<body style="background-image: url('img/index_bg.jpg'); background-repeat: no-repeat; background-size: cover; width: 100% height: 100%;">

  <form action="register.php" method="POST">
    <div class="container" style="height: 660px; margin-top: 70px; margin-bottom: 50px; width: 300px; background-color: #fff; box-shadow: 2px 5px 10px; ">

      <img style='width: 200px; height: 50px; display: block; margin: auto;' src='img/logo2.png'>

      <label for="uname"><b>Full Name</b></label>
      <input type="text" placeholder="Enter Full Name" name="fullname" required>

      <label for="uname"><b>Matric ID</b></label>
      <input type="text" placeholder="Enter Matric ID" name="matric_id" required>

      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="uname"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>

      <label for="uname"><b>Contact</b></label>
      <input type="text" placeholder="Enter Contact" name="contact" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>
  </form>
</div>

</body>
</html>
