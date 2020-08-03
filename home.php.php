<?php include('config.php');?>
<?php

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

$currentPage = $_SERVER["PHP_SELF"];

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

$query_driver = $mysqli->query("SELECT * FROM `driver` WHERE status=2");
$row_driver = $query_driver->fetch_assoc();
$totalRows_driver = $query_driver->num_rows;

$query_announcement = $mysqli->query("SELECT * FROM `announcement` ORDER BY datetime DESC");
$totalRows_announcement = $query_announcement->num_rows;

$query_driver2 = $mysqli->query("SELECT * FROM `driver` WHERE driver_id='$admin_id'");
$row_driver2 = $query_driver2->fetch_assoc();
$totalRows_driver2 = $query_driver2->num_rows;

$query_car = $mysqli->query("SELECT * FROM `car` WHERE admin_id='$admin_id'");
$row_car = $query_car->fetch_assoc();
$totalRows_car = $query_car->num_rows;

$query_taxi = $mysqli->query("SELECT * FROM `taxi` WHERE status = 0 AND customer_id<>'$admin_id'");
$totalRows_taxi = $query_taxi->num_rows;

$query_taxi2 = $mysqli->query("SELECT * FROM `taxi` WHERE driver_id = '$admin_id' AND status = 1");
$totalRows_taxi2 = $query_taxi2->num_rows;

$query_taxi3 = $mysqli->query("SELECT * FROM `taxi` WHERE customer_id = '$admin_id' AND status = 1");
$row_taxi3 = $query_taxi3->fetch_assoc();
$totalRows_taxi3 = $query_taxi3->num_rows;

$query_sewa = $mysqli->query("SELECT * FROM `sewa` WHERE owner_id = '$admin_id' AND status = 0");
$totalRows_sewa = $query_sewa->num_rows;

if (isset($_GET['accept'])) 
{
  $taxi_id = $_GET['accept'];
   $sql = "UPDATE `taxi` SET `status`=1, `driver_id`='$admin_id' WHERE taxi_id='$taxi_id'";

    if (mysqli_query($mysqli, $sql)) {
        $insertGoTo = "home.php?notif=success";
        header(sprintf("Location: %s", $insertGoTo));
    } else {
        $insertGoTo = "home.php?notif=failed";
        header(sprintf("Location: %s", $insertGoTo));
    }
}

if (isset($_GET['check'])) 
{

  $driver_id = $_GET['driver_id'];
  $check = $_GET['check'];
  $taxi_id = $_GET['taxi_id'];
  $rating_id = md5($driver_id.microtime());

  $sql = "INSERT INTO `rating`(`star`, `admin_id`, `rating_id`) VALUES ('$check','$driver_id','$rating_id')";

  if (mysqli_query($mysqli, $sql)) 
  {
    $insertGoTo = "home.php?notif=success";
    header(sprintf("Location: %s", $insertGoTo));
  } 
  else 
  {
    $insertGoTo = "home.php?notif=failed";
    header(sprintf("Location: %s", $insertGoTo));
  }

   $sql = "UPDATE `taxi` SET `status`=2 WHERE taxi_id='$taxi_id'";

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
  <link rel="stylesheet" href="vendor/modalcss.css">
  <script src="vendor/jquery.js"></script>
  <script src="vendor/bootstrap.js"></script>
  <script src="vendor/fontawesome.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>
<style type="text/css">
  .rating {
    float:left;
    text-align: center;
    margin: auto;
}
.rating span { float:right; position:relative; }
.rating span input {
    position:relative;
    top:0px;
    left:0px;
    opacity:0;
}
.rating span label {
    display:inline-block;
    text-align:center;
    color:#333333;
    background:#fff;
    -webkit-border-radius:50%;
}
.rating span:hover ~ span label,
.rating span:hover label,
.rating span.checked label,
.rating span.checked ~ span label {
    background:#fff;
    color:#F90;
}
</style>
<body>
<?php include('sidenav_mobile.php'); ?>
<div class="container-fluid">
  <div class="content">
<?php include('sidenav.php'); ?>

<?php include('topnav.php'); ?>


  <div class="container col-sm-10">
<?php
if ($row_admin['type'] == 0) 
{
  ?>
      <div class="well">
        <h4>Requested Driver</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 20%;">User</th>
                <th style="width: 20%;">Expiry</th>
                <th style="width: 25%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_driver = $query_driver->fetch_assoc())
              {
                $i++;

                $driver_id = $row_driver['driver_id'];
                $query_user = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$driver_id'");
                $row_user = $query_user->fetch_assoc();
                $totalRows_user = $query_user->num_rows;  
                ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_user['fullname']?></td>
                    <td><?=date('d M Y', strtotime($row_driver['expiry']))?></td>
                    <td>
                      <a href="driver_view2.php?pass=<?=$row_driver['driver_id']?>"><button class="btn btn-round btn-primary"><i class="icon fas fa-eye"></i></button></a>
                    </td>
                  </tr>
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>
    <?php
}
?>
      <div class="well">
        <h4>Announcement</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 95%; text-align: left;">Title</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_announcement = $query_announcement->fetch_assoc())
              {
              
                if (strtotime(date('Y-m-d H:i:s')) > strtotime($row_announcement['datetime']."+ 7 days")) 
                {
                  
                }
                else
                {
                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td style="text-align: left;"><a rel="noopener noreferrer" target="_blank" href="" onClick="window.open('news.php?pass=<?=$row_announcement['announcement_id']?>','pagename',',height=500,width=500'); return false;"><?=$row_announcement['title']?></a></td>
                  </tr>
                  <?php
                }
                ?>
                  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>

      <?php
if (isset($row_taxi3['id'])) 
{


  ?>
  <div class="well">
        <h4>Service Taxi List</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 20%; text-align: center;">Driver</th>
                <th style="width: 30%; text-align: center;">From</th>
                <th style="width: 30%; text-align: center;">To</th>
                <th style="width: 20%; text-align: center;">Done</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              do
              {
                $cust = $row_taxi3['driver_id'];
                $query_admin4 = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$cust'");
                $row_admin4 = $query_admin4->fetch_assoc();
                $totalRows_admin4 = $query_admin4->num_rows;  

                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_admin4['username']?> ( <?=$row_admin4['contact']?> )</td>
                    <td><?=$row_taxi3['pickup']?></td>
                    <td><?=$row_taxi3['destination']?></td>
                    <td style="text-align: center;">
                      <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-success">Done</button>
                    </td>
                  </tr>
                  <div id="id01" class="w3-modal">
                    <div class="w3-modal-content w3-animate-top w3-card-4">
                      <header class="w3-container w3-teal"> 
                        <span onclick="document.getElementById('id01').style.display='none'" 
                        class="w3-button w3-display-topright">&times;</span>
                        <h2>Rating</h2>
                      </header>
                      <div class="w3-container">
                        <div class="rating">
                            <span><input type="radio" name="rating" id="str5" value="5"><label for="str5"><span class="fa fa-star"></span></label></span>
                            <span><input type="radio" name="rating" id="str4" value="4"><label for="str4"><span class="fa fa-star"></span></label></span>
                            <span><input type="radio" name="rating" id="str3" value="3"><label for="str3"><span class="fa fa-star"></span></label></span>
                            <span><input type="radio" name="rating" id="str2" value="2"><label for="str2"><span class="fa fa-star"></span></label></span>
                            <span><input type="radio" name="rating" id="str1" value="1"><label for="str1"><span class="fa fa-star"></span></label></span>
                        </div>
                      </div>
                      <input type="hidden" id="driver_id" name="driver_id" value="<?=$row_admin4['admin_id']?>">
                      <input type="hidden" id="taxi_id"  name="taxi_id" value="<?=$row_taxi3['taxi_id']?>">
                      <footer class="w3-container w3-teal">
                        <p>Modal Footer</p>
                      </footer>
                    </div>
                  </div>
                <?php

              }while($row_taxi3 = $query_taxi3->fetch_assoc());
              ?>
              
            </tbody>
          </table>
      </div>
      <?php
}
?>


<?php
if (isset($row_driver2['id'])) 
{


  ?>
  <div class="well">
        <h4>Taxi List</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 20%; text-align: center;">Customer</th>
                <th style="width: 30%; text-align: center;">From</th>
                <th style="width: 30%; text-align: center;">To</th>
                <th style="width: 20%; text-align: center;">Accept</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_taxi = $query_taxi->fetch_assoc())
              {
                
                $cust = $row_taxi['customer_id'];
                $query_admin4 = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$cust'");
                $row_admin4 = $query_admin4->fetch_assoc();
                $totalRows_admin4 = $query_admin4->num_rows;  

                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_admin4['username']?></td>
                    <td><?=$row_taxi['pickup']?></td>
                    <td><?=$row_taxi['destination']?></td>
                    <td style="text-align: center;"><a href="home.php?accept=<?=$row_taxi['taxi_id']?>">Accept Job</a></td>
                  </tr>
                  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>
      <?php
}
?>

<?php
if (isset($row_driver2['id'])) 
{


  ?>
  <div class="well">
        <h4>Taxi Job List</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 20%; text-align: center;">Customer</th>
                <th style="width: 30%; text-align: center;">From</th>
                <th style="width: 30%; text-align: center;">To</th>
                <th style="width: 20%; text-align: center;">Accept</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_taxi2 = $query_taxi2->fetch_assoc())
              {
                
                $cust = $row_taxi2['customer_id'];
                $query_admin4 = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$cust'");
                $row_admin4 = $query_admin4->fetch_assoc();
                $totalRows_admin4 = $query_admin4->num_rows;  
                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td><?=$row_admin4['username']?></td>
                    <td><?=$row_taxi2['pickup']?></td>
                    <td><?=$row_taxi2['destination']?></td>
                    <td style="text-align: center;"><a href="home.php?check=1">Done</a></td>
                  </tr>
                  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>
      <?php
}
?>
      
<?php
if (isset($row_car['id'])) 
{
  ?>
      <div class="well">
        <h4>Sewa</h4>

        <table class="table table-bordered">
            <thead>
              <tr class="text-centered">
                <th style="width: 5%;">#</th>
                <th style="width: 45%; text-align: left;">Renter Name</th>
                <th style="width: 25%; text-align: left;">From</th>
                <th style="width: 25%; text-align: left;">To</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 0;
              while($row_sewa = $query_sewa->fetch_assoc())
              {
                $customer_id = $row_sewa['customer_id'];
                $query_customer = $mysqli->query("SELECT * FROM `admin` WHERE admin_id='$customer_id'");
                $row_customer = $query_customer->fetch_assoc();
                $totalRows_customer = $query_customer->num_rows;

                if (strtotime(date('Y-m-d H:i:s')) > strtotime($row_sewa['datetime_start']."+ 7 days")) 
                {
                  
                }
                else
                {
                  $i++;
                  ?>
                  <tr>
                    <td><?=$i?></td>
                    <td style="text-align: left;"><?=$row_customer['fullname']?></td>
                    <td style="text-align: left;"><?=date('h:i A d M Y', strtotime($row_sewa['datetime_start']))?></td>
                    <td style="text-align: left;"><?=date('h:i A d M Y', strtotime($row_sewa['datetime_end']))?></td>
                  </tr>
                  <?php
                }
                ?>
                  
                <?php

              };
              ?>
              
            </tbody>
          </table>
      </div>

            <?php
}
?>

    </div>

    
</div>


    </div>
    
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    // Check Radio-box
    $(".rating input:radio").attr("checked", false);

    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    $('input:radio').change(
      function(){
        var userRating = this.value;
        var driver_id =document.getElementById("driver_id").value;
        var taxi_id =document.getElementById("taxi_id").value;
        window.location.href = 'home.php?check=' + userRating + '&driver_id=' + driver_id + '&taxi_id=' + taxi_id;
    }); 
});
</script>
</body>
</html>
