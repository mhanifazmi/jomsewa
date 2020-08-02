<?php include('config.php');

session_start();

if (isset($_POST['username'])) 
{
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
  $row_admin = $query_admin->fetch_assoc();
  $totalRows_admin = $query_admin->num_rows;

  if (isset($row_admin['id'])) 
  {
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password;
    $_SESSION["admin_id"] = $row_admin['admin_id'];

    header('Location: home.php');
  }
  else
  {
    header('Location: index.php');
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

  <form action="index.php" method="POST">
    <div class="container" style="height: 380px; margin-top: 150px; width: 300px; background-color: #fff; box-shadow: 2px 5px 10px;">
      <img style='width: 200px; height: 50px; display: block; margin: auto;' src='img/logo2.png'>
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>

      <a href="register.php"><button class="btn-success" type="button">Register</button></a>
    </div>
  </form>
</div>

</body>
</html>
