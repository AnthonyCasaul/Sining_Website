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
   <title>shopping cart</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <link rel="stylesheet" href="css/cart_style.css">
   <?php
      include("navbar.php");
   ?>
   
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
<div class="row">
            <div class="col-sm-1"><p class=" hidden-xs">Product</div>
            <div class="col-sm-3"></div>
            <div class="col-sm-2"><p>Price</p></div>
            <div class="col-sm-2"><p>Quantity</p></div>
            <div class="col-sm-2"><p>Total</p></div>
</div>
         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE artistId='$user_id'");
         $grand_total = 0;

         if(mysqli_num_rows($select_cart) < 1){
            echo "<h4>Your cart is empty. You can shop in <a href='home.php'>here</a> or check your <a href='userhistory.php'>pendings</a>!</h4>";
         } 

         else if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <div class="row deets">
            <div class="col-sm-1"><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></div>
            <div class="col-sm-3"><h2><?php echo $fetch_cart['name']; ?></h2></div>
            <div class="col-sm-2"><h2>₱<?php echo number_format($fetch_cart['price'],2); ?></h2></div>
            <div class="col-sm-2">
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                  <div class="quan">
                  <input type="submit" name="dec" value="-">
                  <input type="number" name="update_quantity" value="<?php echo $fetch_cart['quantity']; ?>" placeholder="1" readonly>
                  <input type="submit" name="inc" value="+">
                  <!--<input type="submit" value="Update" name="update_update_btn">-->
               </div>
               </form>   
            </div>

            <div class="col-sm-2"><h2>₱<?php echo $sub = number_format($fetch_cart['price'] * $fetch_cart['quantity'],2); ?></h2></div>
            <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>
            <div class="col-sm-2"><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i></a></div>
            <hr>
         </div>
         <?php
           $grand_total= $grand_total+ $sub_total;  
            };
         };
         ?>
         <div class="tot">
            <h3>Total: ₱<?php echo number_format($grand_total,2); ?></h3>
            <!--<td><a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>-->
            
         </div>
         <div class="ch">
         <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Checkout</a>
         </div>
</section>

</div>
<style>
   header{
      background-color: #212529;
   }
</style>
</body>
</html>