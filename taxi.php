<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;

$admin_id = $row_admin['admin_id'];

if (isset($_POST['expiry'])) 
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
  
  $logotemp = md5($_POST['expiry']);
  $dir="img/receipt/";
  $temp = explode(".", $_FILES["image"]["name"]);
  $newfilename = $admin_id.".pdf";
  $dir2=$dir.$newfilename;
  $dir3="img/receipt/".$newfilename;  //display at frontend
  
  if(move_uploaded_file($_FILES["image"]["tmp_name"], $dir2)){ 
    
  }
}
    
  $maintenance_id = md5($air_filter.microtime(true));

  $date2 = date('Y-m-d', strtotime($date));

  $sql = "INSERT INTO `driver`(`driver_id`, `expiry`, `nationality`, `licence_number`, `status`, `licence_copy`) VALUES ('$admin_id', '$expiry', '$nationality', '$licence_number', 2, '$dir3')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "driver.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "driver.php?notif=failed";
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
  <script src="vendor/jquery2.js"></script>
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
        <h4 class="uppercase">Taxi Manager</h4>
        <div class="col-sm-12">
          <br>
          <form action="taxi2.php" method="POST" enctype="multipart/form-data">

            <label for="uname"><b>Date</b></label>
            <input name="date" placeholder="Enter Date" type="date" class="street" style="margin-bottom: 10px; border-radius: 0px;" />

            <label for="uname"><b>Time</b></label>
            <input name="time"  type="time" class="street" style="margin-bottom: 10px; border-radius: 0px;" />

            <label for="uname"><b>Pickup</b></label>
            <input placeholder="Enter Pickup" type="text" class="street" name="pickup" />

            <label for="uname"><b>Destination</b></label>
            <input placeholder="Enter Destination" type="text" class="to_street" name="destination" />

            <input type="hidden" name="driver_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">Book</button>
              <a href="driver.php"><button type="button" class="btn btn-white">Cancel</button></a>
            </div>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

<script>
      var placeSearch, autocomplete, geocoder;

function initAutocomplete() {
  geocoder = new google.maps.Geocoder();
  autocomplete = new google.maps.places.Autocomplete(
      (document.getElementById('autocomplete'))
      );

  autocomplete.setComponentRestrictions(
            {'country': ['my']});

  autocomplete.addListener('place_changed', fillInAddress);

  autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('autocomplete2'));
google.maps.event.addListener(autocomplete2, 'place_changed', function() {
  fillInAddress();
});
}

function codeAddress(address) {
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        alert(results[0].geometry.location);
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

function fillInAddress() {
  var place = autocomplete.getPlace();
  
}
    </script>
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsSCQtzMCTYTsN6KzWYpgpt3gsEO7qnC8&libraries=places&types=establishment&types=address&callback=initAutocomplete&locality=my" async defer></script>

   <script type="text/javascript">
      $("#from_button").click(function(){
        var building = $('.building').val(); 
        var unit = $('.unit').val();
        var street = $('.street').val();
      $("#from_building").val(building);
       $("#from_unit").val(unit);
       $("#from_street").val(street);
       $("#from").val(street);
    });

    </script>

    <script type="text/javascript">
      $("#to_button").click(function(){
        var building = $('.to_building').val(); 
        var unit = $('.to_unit').val();
        var street = $('.to_street').val();
      $("#to_building").val(building);
       $("#to_unit").val(unit);
       $("#to_street").val(street);
       $("#to").val(street);
    });

    </script>


</body>
</html>
