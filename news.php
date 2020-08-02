<?php include('config.php');

$pass = $_GET['pass'];

$query_announcement = $mysqli->query("SELECT * FROM `announcement` WHERE announcement_id='$pass'");
$row_announcement = $query_announcement->fetch_assoc();
$totalRows_announcement = $query_announcement->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body style="background-color: #f2f8f9; margin: auto; text-align: center;">
	<img src="<?=$row_announcement['image']?>" style="width: 90%;">
	<?=$row_announcement['announcement']?>

</body>
</html>