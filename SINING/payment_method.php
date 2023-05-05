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
   <link rel="stylesheet" href=" css/sellerform.css">
   <?php
        include("navbar.php");
    ?>
    <style type="text/css">
   input{
      margin-bottom: 13px;
      margin-right: 15px;
   }

   label{
      margin-left: 15px;
   }

   input[type=submit]{
    width: 20%;
    margin-left: 13px;
    background-color: #4d4d4d;
    border-style: none;
    font-size: 15px;
    cursor: pointer;
    transition: .2s;
    border-radius: 10px;
	}

	input[type=submit]:hover{
    background-color: #ffc800;
    color: #000;
	}
   input[type=radio]{
   	width: 5%;
   }
   input[type=text]{
   	width: 550px;
   }
    </style>
</head>

<body>
   
<div class="seller-con">

   <br>
   <table>
   <form action="" method="POST" enctype="multipart/form-data">      
            <tr>
            <h3>Before you proceed, please check your delivery info!</h3>
            </tr>    		    	
    		<label>Payment Method:</label>
			<input type="radio" name="paymentMethod" id="bankTransfer" value="Bank Transfer"> Bank Transfer    			
   			<input type="radio" name="paymentMethod" id="pickUp" value="Pick-up"> Pick-up

            <tr>
            <td><label>Address :</label></td>
            <td><input type="text" name="update_address" class="box"></td>
            </tr>                                             
            </table>
         <input type="submit" name="con" value="Confirm" />
        
   </form>
   
</div>
</body>
</html>