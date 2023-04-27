<?php

error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = 3;
$fetchart = $_SESSION['fetchartid'];
$artid = $_POST['artid'];

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}




?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Checkout</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/checkout_style.css">
   <?php
        include("navbar.php");
    ?>
</head>
<body>
 <input type="hidden" id="id" value="<?= $user_id ?>">
 <div class="container deets">
 	<h1>Confirmation</h1>
 	<hr>
 	<div class="user_info">
 		<h2>User Information</h2>
 		<?php
 		$user_info = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId='$user_id'");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
 		echo '<h3>Name: '.$fetch_artist['artistName'].'</h3>';
 		echo '<h3>Email: '.$fetch_artist['artistEmail'].'</h3>';
 		echo '<h3>Address: '.$fetch_artist['artistLocation'].'</h3>';
 		}
 	}
   ?>
 	</div>


 	<div class="row head">
            <div class="col-sm-1"><h2>Product</h2></div>
            <div class="col-sm-5"></div>
            <div class="col-sm-2"><p>Price</p></div>
            <div class="col-sm-2"><p>Quantity</p></div>
            <div class="col-sm-1"><p>Total</p></div>
	</div>
 	<?php          
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE artistId='$user_id'");
         $grand_total = 0;

         if(mysqli_num_rows($select_cart) < 1){
            echo "<h4>no records</h4>";
         }

         else if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
   ?>

         <div class="row">
            <div class="col-sm-1"><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt="Product image"></div>
            <div class="col-sm-5"><h2><?php echo $fetch_cart['name']; ?></h2></div>
            <div class="col-sm-2"><h2>₱<?php echo number_format($fetch_cart['price'],2); ?></h2></div>
            <div class="col-sm-2"><h2><?php echo $fetch_cart['quantity']; ?></h2></div>
            <div class="col-sm-1"><h2>₱<?php echo $sub = number_format($fetch_cart['price'] * $fetch_cart['quantity'],2); ?></h2></div>
            <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
            <hr>
         </div>
         <?php
           $grand_total= $grand_total+ $sub_total; 
            };
         };
    ?>
    <div class="tot">
        <h3>Total: ₱<?php echo number_format($grand_total,2); ?></h3>           
    </div>
    
 	<div class="user_info">
 		<h2>Payment</h2>
      <div style="text-align: center">
       <?php	$user_info = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId='$artist'");
 		if(mysqli_num_rows($user_info) > 0){
         while($fetch_artist = mysqli_fetch_assoc($user_info)){
               echo '<img src="uploaded_img/'.$fetch_artist['artistgcash'].'">';
 		   }
      }
      ?><br><br><br>
      <div class="row">
         <div class="col" style="text-align: right">
            <span>Upload Receipt :</span>
         </div>
         <div class="col" style="width: 100%; text-align: left">
            <input type="file"  id="update_gcash" accept="image/jpg, image/jpeg, image/png" class="box"><BR>
         </div>
      </div>
      <BR>
      

      <div class="row">
         <div class="col" style="text-align: right">
            <span>Reference No.:</span>
            </div>
            <div class="col" style="width: 100%; text-align: left;">
            <input type="text"  style="width: 50%; color: black" id="gcash_ref" class="box" placeholder="Enter Reference Number" maxlength="13">
         
         </div>
      </div>

      </div>
   </div>
    <!-- confirmation -->
   <div class="ch">
	<button class="btn" onclick="myFunction()">Confirm</button>
   </div>

   <!-- insert history -->
   <?php
   if (isset($_GET['myAction']) && $_GET['myAction'] == 'doSomething') {
      $art_move = mysqli_query($conn, "INSERT INTO `artist_history`(artistId,artistTitle, artPrice, artImage, artQuantity)
                                       SELECT artistId, name, price, image, quantity FROM `cart` WHERE artistId='$user_id'");
      $cart_delete = mysqli_query($conn, "DELETE FROM `cart` WHERE artistId='$user_id'");
      header('Location: userhistory.php');
   }
   echo "";
   ?>

</div>

<script>
function myFunction() {
  if(confirm("Are you sure you want to proceed?"))
  {
         var id = $("#id").val();
         var gcash_ref = $("#gcash_ref").val();
         var formData = new FormData();
         formData.append('gcash', $('#update_gcash')[0].files[0]);
         formData.append('function', "checkout");
         formData.append('gcash_ref', gcash_ref);
         formData.append('id', id);
         $.ajax({
            url:"logic_function.php",
            method:"POST",
            processData: false,
            contentType: false,
            data:formData,

            success:function(data){
               alert("Success")
               location.href = "userhistory.php"
            }
        });
  }


  
}
</script>
<style>
   header{
      background-color: #212529;
   }
</style>
</body>
</html>