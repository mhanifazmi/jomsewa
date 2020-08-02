<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

if ($row_admin['type'] == 1) 
{
  header('Location: user_view2.php');
}

$query_admin2 = $mysqli->query("SELECT * FROM `admin`");
$row_admin2 = $query_admin2->fetch_assoc();
$totalRows_admin2 = $query_admin2->num_rows;


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

    <div class="container col-sm-10">

      <div class="well">
        <h4 class="uppercase">User Manager</h4>
        <div class="table-responsive">          
          <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5px;">#</th>
                <th style="width: 20px;">Full Name</th>
                <th style="width: 40px;">Username</th>
                <th style="width: 10px;">Status</th>
                <th style="width: 25px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              do
              {
                $i++;
                ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_admin2['fullname']?></td>
                    <td><?=$row_admin2['username']?></td>
                    <td><?php if($row_admin2['status'] == 1){echo "Active";}else{ echo "Not Active";};?></td>
                    <td>
                      <a href="user_view.php?pass=<?=$row_admin2['admin_id']?>"><button class="btn btn-round btn-success"><i class="icon fas fa-eye"></i></button></a>
                      <a href="user_edit.php?pass=<?=$row_admin2['admin_id']?>"><button class="btn btn-round btn-warning"><i class="icon fas fa-edit"></i></button></a>
                      <a href="user_delete.php?pass=<?=$row_admin2['admin_id']?>"><button class="btn btn-round btn-danger"><i class="icon fas fa-trash"></i></button></a>
                    </td>
                  </tr>
                <?php

              }while($row_admin2 = $query_admin2->fetch_assoc());
              ?>
              
            </tbody>
          </table>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
