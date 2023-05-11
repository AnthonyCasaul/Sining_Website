<?php

@include 'condb.php';

/*if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};*/
session_start();
$user_id = $_SESSION['user_id'];

//$_SESSION['artID'] = $_POST['artId'];

if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

if(isset($_POST['dec'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_value--;
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_value==0){
      mysqli_query($conn, "DELETE FROM `cart` WHERE quantity = '0'");
   }

   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_POST['inc'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_value++;
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
   <title>Sining | Cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="viewportchecker.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

   <link rel="stylesheet" href="cart_style.css">
   <?php
      include("navbar.php");
   ?>
   <style>
   header{
      background-color: #212529;
   }
   </style>

</head>
<script type="text/javascript">
   function zoom() {
      document.body.style.zoom = "100%" 
   }
</script>

<body onload="zoom()">
<div class="container">

<section class="shopping-cart">

<h1 class="heading">Your cart</h1>
<div class="row headingText">
            <div class="col-sm-1"></div>
            <div class="col-sm-2"><p class=" hidden-xs">Product</div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2"><p>Price</p></div>
            <div class="col-sm-2"><p>Quantity</p></div>
            <div class="col-sm-1"><p>Seller</p></div>
</div>
         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT a.*, c.seller_name, c.seller_email, c.seller_id FROM `cart` AS a
                                   LEFT JOIN `sining_artworks1` AS b ON a.artId = b.artId
                                   LEFT JOIN `sining_sellers` AS c ON b.seller_id = c.seller_id
                                   WHERE a.artistId='$user_id'");
         $grand_total = 0;

         if(mysqli_num_rows($select_cart) < 1){
            echo "<h4>Your cart is empty. You can continue shopping in <a href='home.php' class='aLink'>here</a> or check your <a href='userhistory.php' class='aLink'>pendings</a>!</h4>";
         } 

         else if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>
         <div class="row deets">
            <div class="col-sm-1 col-2"><input type="checkbox" name="myCheckbox[]" value="<?php echo $fetch_cart['id']; ?>" required></div>            
            <div class="col-sm-2 col-10"><img src="seller_file/artworks/seller_<?php echo $fetch_cart['seller_id']; ?>/<?php echo $fetch_cart['image']; ?>" height="100" alt="" class="img-fluid cartImg"></div>
            <div class="col-sm-2"><h2><?php echo $fetch_cart['name']; ?></h2></div>
            <div class="col-sm-2"><h2>₱<?php echo number_format($fetch_cart['price'],2); ?></h2></div>
            <div class="col-sm-2">
               <form action="" method="post">
                  <input type="text" name="artId"  value="<?php echo $fetch_cart['artId']; ?>" hidden = "" >
                  <div class="quan">
                  <!-- <input type="submit" name="dec" value="-"> -->
                  <input type="number" name="update_quantity" value="<?php echo $fetch_cart['quantity']; ?>" placeholder="1" readonly>
                  <!-- <input type="submit" name="inc" value="+"> -->
                  <!-- <input type="submit" value="Update" name="update_update_btn"> -->
               </div>
               </form>
            </div>

            <div class="col-sm-2"><h2><?php echo $fetch_cart['seller_name']; ?></h2>
            </div>
            <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
            <div class="col-sm-1"><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove artwork(s) from cart?')" class="delete-btn"> <i class='fas'>&#xf2ed;</i></a></div>
            <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); 
            ?>
            <hr>
         </div>
         
         <?php
           $grand_total= $grand_total+ $sub_total;  
            };
         };
         ?>        
         <div class="ch">
         <?php 
         if(mysqli_num_rows($select_cart) < 1){
         echo "<a class='btn' disabled>Checkout</a>";
         } 
         else {
         echo "<a href='payment_method.php' class='btn' onclick='return validateCheckboxes();'>Checkout</a>";
         }
         ?> 
         </div>
</section>

</div>

<script type="text/javascript">
const myCheckboxes = document.querySelectorAll('input[name="myCheckbox[]"]');

 function validateCheckboxes() {
    const checkboxes = document.querySelectorAll('input[name="myCheckbox[]"]');
    let isChecked = false;
    checkboxes.forEach((checkbox) => {
      if (checkbox.checked) {
        isChecked = true;
      }
    });
    if (!isChecked) {
      alert('Select at least one artwork before proceeding to checkout.');
      return false;
    }
    return true;
  }

myCheckboxes.forEach(function(myCheckbox) {
  myCheckbox.addEventListener('change', function() {
      if (this.checked) {
        var checked = this.value; // Get the value of the clicked checkbox
        console.log("checked");
        $.ajax({
          type: "POST",
          url: "eh.php",
          data: {id: checked},
          success: function(result){
            console.log(result);
            $('#searchResults').html(result);
          }
        });   
      } 
      else {
        console.log("not checked");
        var unchecked = this.value;
        $.ajax({
          type: "POST",
          url: "uncheck.php",
          data: {id: unchecked},
          success: function(result){
            console.log(result);
            $('#searchResults').html(result);
          }
        }); 
      }
  });
});
</script>
</body>
</html>