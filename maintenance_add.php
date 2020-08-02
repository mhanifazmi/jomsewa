<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];
$pass = $_GET['pass'];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$air_filter = 0;
$windshield_wiper = 0;
$spark_plug = 0;
$oil_filter = 0;
$battery = 0;
$radiator_flush = 0;
$brake_pads = 0;
$fuel_filter = 0;

if (isset($_POST['date'])) 
{
  extract($_POST);

  // A list of permitted file extensions
  $allowed = array('png', 'jpg', 'gif', 'pdf');


if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){
  
  $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

  if(!in_array(strtolower($extension), $allowed)){
    echo '{"status":"error"}';
    exit;
  }
  
  $logotemp = md5($_POST['air_filter']);
  $dir="img/receipt/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = $_FILES["image"]["name"];
  $dir2=$dir.$newfilename;
  $dir3="img/receipt/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}
    
  $maintenance_id = md5($air_filter.microtime(true));

  $date2 = date('Y-m-d', strtotime($date));

  $sql = "INSERT INTO maintenance(`file`, `air_filter`, `windshield_wiper`, `spark_plug`, `oil_filter`, `battery`, `radiator_flush`, `brake_pads`, `fuel_filter`, `date`, `maintenance_id`, `admin_id`, car_id) VALUES ('$dir3', '$air_filter', '$windshield_wiper', '$spark_plug', '$oil_filter', '$battery', '$radiator_flush', '$brake_pads', '$fuel_filter', '$date2', '$maintenance_id', '$admin_id', '$pass')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "maintenance.php?pass=".$pass."&notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "maintenance.php?pass=".$pass."&notif=failed";
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
          <form action="maintenance_add.php" method="POST" enctype="multipart/form-data">
            <label for="uname"><b>Date</b></label>
            <input type="date" placeholder="Enter Car Model" name="date" required value="">

            <label for="uname"><b>Receipt</b></label>
            <input type="file" placeholder="Enter Receipt" name="image" required value="">

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Air Filter</b></label>
                  <label class="switch" style=" text-align: center; margin: auto;">
                    <input type="checkbox" value="1" name="air_filter" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Windshield Wiper</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="windshield_wiper" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                  <label for="uname" style="display: block; text-align: center;"><b>Oil Filter</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="oil_filter" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Battery</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="battery" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              
            </div>
            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Radiator Flush</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="radiator_flush" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Spark Plug</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="spark_plug" checked>
                    <span class="slider round"></span>
                  </label>
            </div>
            </div>

            <div class="col-sm-12">
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Brake Pads</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="brake_pads" checked>
                    <span class="slider round"></span>
                  </label>
              </div>
              <div class="col-sm-6" style="text-align: center;">
                <label for="uname" style="display: block; text-align: center;"><b>Fuel Filter</b></label>
                  <label class="switch" style=" text-align: center;">
                    <input type="checkbox" value="1" name="fuel_filter" checked>
                    <span class="slider round"></span>
                  </label>
            </div>
            </div>
            

            <input type="hidden" name="admin_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">SAVE</button>
              <a href="maintenance.php?pass=<?=$_GET['pass']?>"><button type="button" class="btn btn-white">BACK</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
