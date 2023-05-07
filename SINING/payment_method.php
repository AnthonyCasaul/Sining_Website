<?php
error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$paymentMethod = $_POST['paymentMethod'];
$address = $_POST['update_address'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

if (isset($_POST['con'])){
$updateInfo = mysqli_query($conn, "UPDATE `cart` SET `payment_method` = '$paymentMethod', `buyer_address` = '$address' WHERE artistId='$user_id' AND ifChecked=1");
header('location:checkout.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Payment Information</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update profile</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <link rel="stylesheet" href=" css/payment_style.css">
   <?php
        include("navbar.php");
    ?>
</head>

<body>
   
<div class="container cont">
   <form action="" method="POST" enctype="multipart/form-data">      
         <br>
         <h3>Before you proceed, please check your delivery info!</h3>
               		    	
    		<label>Payment Method:</label><br>
			<input type="radio" name="paymentMethod" id="option1" value="Bank Transfer" required> Bank Transfer    			
   		<input type="radio" name="paymentMethod" id="option2" value="Pick-up" required> Pick-up
         <br>
         <label for="option1">Address :</label><br>
         <input type="text" name="update_address" class="box" required>
         <br>
         <input type="submit" name="con" value="Confirm" />
        
   </form>
   
</div>
<script>
  const option1 = document.getElementById('option1');
  const option2 = document.getElementById('option2');
  const addressLabel = document.querySelector('label[for="option1"]');
  const addressInput = document.querySelector('input[name="update_address"]');
  
  option1.addEventListener('change', () => {
    if (option1.checked) {
      addressLabel.textContent = 'Address :';
      addressInput.type = 'text';
    }
  });
  
  option2.addEventListener('change', () => {
    if (option2.checked) {
      addressLabel.textContent = 'Phone Number :'; 
      addressInput.type = 'number';
    }
  });
</script>

</body>
</html>