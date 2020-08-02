<?php include('config.php');
session_start();

$username = $_SESSION["username"];
$password = $_SESSION["password"];
$password = $_SESSION["password"];

$query_admin = $mysqli->query("SELECT * FROM `admin` WHERE username='$username' AND password='$password'");
$row_admin = $query_admin->fetch_assoc();
$totalRows_admin = $query_admin->num_rows;


$date = date('d M Y', strtotime($_POST['date']));
$time = date('h:i A', strtotime($_POST['time']));

$admin_id = $row_admin['admin_id'];

            $address1 = str_replace(' ', '+', $_POST['pickup']);

            $address2 =  str_replace(' ', '+', $_POST['destination']);

            $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.$address1.'&destinations='.$address2.'&key=AIzaSyBWvh5pfufmUVx2V1G_0dJBp3LIftqqE64';
            $json = file_get_contents($url); // get the data from Google Maps API
            $result = json_decode($json, true); // convert it from JSON to php array
            $miles = $result['rows'][0]['elements'][0]['distance']['text'];



            $kilometers = ceil(str_replace(" mi", "", $miles) * 1.609344);

            $subprice = $kilometers;



if (isset($_POST['distance'])) 
{
  extract($_POST);

  $taxi_id = md5($car_model.microtime(true));

  $datetime = date('Y-m-d H:i:s', strtotime($date." ".$time));

  $point = 0 ;
  if ($distance >= 5) 
  {
    $point = 2;
  }

  $sql = "INSERT INTO taxi(`datetime`, `pickup`, `destination`, `status`, `customer_id`, `distance`, `amount`, `point`, `driver_id`, `payment_type`, `taxi_id`) VALUES ('$datetime', '$pickup', '$destination', 0, '$customer_id', '$distance', '$amount', '$point', '', 0, '$taxi_id')";

  if (mysqli_query($mysqli, $sql)) {
      $insertGoTo = "booking.php?notif=success";
      header(sprintf("Location: %s", $insertGoTo));
  } else {
      $insertGoTo = "booking.php?notif=failed";
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

      <div class="well row" style="width: 60%; margin: auto;">
        <h4 class="uppercase">Taxi Manager</h4>
        <div class="col-sm-12">
          <form action="taxi2.php" method="POST">
            <iframe height="400" frameborder="0" style="border:0; width: 100%;" src="https://www.google.com/maps/embed/v1/directions?key=AIzaSyD5nxSL7zWQjwsqJnKJ7cSRQT7xxMHiPbs&origin=<?=$address1?>&destination=<?=$address2?>" allowfullscreen></iframe>
            <br>
            <label class="new-row" for="uname"><b>Date :<pre><?=$date?></pre></b></label>

            <label class="new-row" for="uname"><b>Time :<pre><?=$time?></pre></b></label>

            <label class="new-row" for="uname"><b>Distance :<pre><?=$kilometers?> km</pre></b></label>

            <label class="new-row" for="uname"><b>Price :<pre>RM <?=number_format($subprice, 2)?></pre></b></label>

            <input type="hidden" name="driver_id" value="<?=$row_admin['admin_id']?>">
            <input type="hidden" name="pass" value="<?=$pass?>">
            <div style="margin: auto; display: inline-block; text-align: center; width: 100%;">
              <button class="btn btn-primary">Confirm</button>
              <a href="driver.php"><button type="button" class="btn btn-white">Cancel</button></a>
            </div>
            <input type="hidden" name="date" value="<?=$_POST['date']?>">
            <input type="hidden" name="time" value="<?=$_POST['time']?>">
            <input type="hidden" name="distance" value="<?=$kilometers?>">
            <input type="hidden" name="amount" value="<?=$subprice?>">
            <input type="hidden" name="pickup" value="<?=$_POST['pickup']?>">
            <input type="hidden" name="destination" value="<?=$_POST['destination']?>">
            <input type="hidden" name="customer_id" value="<?=$admin_id?>">
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
</body>
</html>
