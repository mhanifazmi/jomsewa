<?php require_once('config.php');
session_start();
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

  $query_admin2 = $mysqli->query("SELECT * FROM `admin`");
$row_admin2 = $query_admin2->fetch_assoc();
$totalRows_admin2 = $query_admin2->num_rows;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Campus Pantry CMS</title>
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="images/favicon.png" />
  <link rel="stylesheet" href="css/all.css">
</head>
<style>

  .table.table-bordered thead 
  {
    border: 1px solid #252525;
    background-color: #dcdcdc;
  }
  .table-bordered th, .table-bordered td {
    border: 1px solid #252525;
}
.table thead th, td {
    vertical-align: bottom;
    border-bottom: 1px solid #252525;
    height: 30px;
}
</style>

<body onload="window.print(); window.close();">
  <div style="padding-right: 100px;padding-left: 100px;">
<h3 style="text-align: center;">DRIVER REPORT</h3>


</html>
                    <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
            <thead>
              <tr class="text-centered">
                <th style="width: 5px;">#</th>
                <th style="width: 20px;">Full Name</th>
                <th style="width: 40px;">Username</th>
                <th style="width: 10px;">Status</th>
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
                  </tr>
                <?php

              }while($row_admin2 = $query_admin2->fetch_assoc());
              ?>
              
            </tbody>
          </table>
                    <br>
                    <br>

                    
                    </div>
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/all.js"></script>

</body>

</html>