<?php

error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = $_SESSION['artistid'];
$artid = $_SESSION['artid'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

if(isset($_POST['selectedOption'])) {
  $selectedOption = $_POST['selectedOption'];
  $stmt = $conn->prepare("INSERT INTO `product_status` (payment_method) VALUES ('$selectedOption')");
  $stmt->bind_param("s", $selectedOption);
}

  if(isset($_GET['remove'])){
     $remove_id = $_GET['remove'];
     mysqli_query($conn, "UPDATE `product_status` SET `product_status`='Cancelled' WHERE product_id = '$remove_id'");
     header('location:userhistory.php');
  };
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>History</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/historystyle.css">
	<?php
		include("navbar.php");
	?>
</head>
<body>


<div class="container cont">
	<div class="opts">
  	<button class="tablinks" onclick="openCity(event, 'toPay')" id="defaultOpen">To be Approved</button>
  	<button class="tablinks" onclick="openCity(event, 'toShip')">To Ship</button>
  	<button class="tablinks" onclick="openCity(event, 'toReceive')">To Receive</button>
    <button class="tablinks" onclick="openCity(event, 'completed')">Completed</button>
    <button class="tablinks" onclick="openCity(event, 'cancelled')">Cancelled</button>
	</div>


<div id="toPay" class="tabcontent">
  <h1>To be approved</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'To be approved'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="uploaded_img/'.$fetch_cart['product_image'].'alt="Product image">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
    echo '<a href="userhistory.php?remove='.$fetch_artist['product_id'].'" class="dlt" onclick="myFunction()">Cancel Order</a>';
 		echo '<hr>';    
 		}
 	}
   ?>

</div>

<div id="toShip" class="tabcontent">
<h1>To be shipped</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id = '$user_id' AND product_status = 'To be shipped'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src='.$fetch_cart['product_image']. 'height="100" alt="">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';  
 		}
 	}
?>
</div>

<div id="toReceive" class="tabcontent">
 <h1>Shipped</h1>
 <?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'Shipped'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="uploaded_img/'.$fetch_cart['image'].'alt="Product image">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
 		}
 	}
?>
</div>

<div id="completed" class="tabcontent">
  <h1>Completed Purchases</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'Completed'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="uploaded_img/'.$fetch_cart['image'].'alt="Product image">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';   
 		}
 	}
?>
</div>

<div id="cancelled" class="tabcontent">
  <h1>Cancelled Orders</h1>
<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `product_status` WHERE buyer_id='$user_id' AND product_status = 'Cancelled'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<img src="uploaded_img/'.$fetch_cart['image'].'alt="Product image">';
 		echo '<h3>'.$fetch_artist['product_name'].'</h3>';
 		echo '<h3>x'.$fetch_artist['product_quantity'].'</h3>';
 		//echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['product_price'].'</h2>';
    echo '<hr>';
 		}
 	}
?>
</div>

</div>

<script>
function myFunction() {
  confirm("Are you sure you want to cancel?");
}

function openCity(evt, toAction) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(toAction).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();
</script>
<style>
	header{
		background: #212529
	}
</style>
</body>
</html>