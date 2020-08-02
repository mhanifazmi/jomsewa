<?php require_once('config.php');
session_start();
$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

if (isset($_POST['date_from'])) 
{
  $from = $_POST['date_from'];
  $to = $_POST['date_to'];

  $query_taxi = $mysqli->query("SELECT * FROM `taxi` WHERE driver_id = '$admin_id' AND status = 2");
  $row_taxi = $query_taxi->fetch_assoc();
  $totalRows_taxi = $query_taxi->num_rows;


}



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
<h3 style="text-align: center;">INCOME REPORT</h3>


                    <table class="table table-bordered" style="border: 1px solid #252525; width: 100%;border-collapse: collapse;">
                      <thead>
                        <tr>
                          <th class="color" colspan="3" style="background-color: #dcdcdc; text-align: center; width: 10%; text-transform: uppercase; font-weight:bold;">
                            <?php echo date('d-m-Y', strtotime($from)); ?> TO <?php echo date('d-m-Y', strtotime($to)); ?>
                          </th>
                        </tr>
                        <tr>
                          <th class="color" style="text-align: center; width: 10%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            #
                          </th>
                          <th class="color" style="text-align: center; width: 40%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            Date
                          </th>
                          <th class="color" style="text-align: center; width: 25%; text-transform: uppercase; font-weight:bold;background-color: #dcdcdc;">
                            Amount
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $i = 0;
                        $total = 0;
                        do
                        {
                          $i++;
                          ?>
                          <tr>
                          <td style="text-align: center; width: 10%; text-transform: uppercase;">
                            <?=$i?>
                          </td>
                          <td style="text-align: center; width: 40%; text-transform: uppercase;">
                            <?=date('d M Y', strtotime($row_taxi['datetime']))?>
                          </td>
                          <td style="text-align: center; width: 25%; text-transform: uppercase;">
                            RM <?=number_format($row_taxi['amount'], 2)?>
                            <?php
                            $total = $total + $row_taxi['amount'];
                            ?>
                          </td>
                        </tr>
                          <?php

                        }while($row_taxi = $query_taxi->fetch_assoc());
                        ?>

                        <tr>
                          <td colspan="2" style="text-align: center; width: 40%; text-transform: uppercase;">
                            TOTAL
                          </td>
                          <td style="text-align: center; width: 25%; text-transform: uppercase;">
                            RM <?=number_format($total, 2)?>
                          </td>
                        </tr>
                        
                        
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