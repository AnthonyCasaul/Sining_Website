<?php

error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = $_SESSION['artistid'];
$fetchart = $_SESSION['fetchartid'];
$_SESSION['artid'] = $_POST['artid'];


if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}

   use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

        

if(isset($_POST['con'])){
   $stat = "To be approved";
      $art_move = mysqli_query($conn, "INSERT INTO `product_status`(product_id, product_name, product_price, product_image, product_quantity, payment_method, buyer_address, seller_id)
                                       SELECT a.artId, a.name, a.price, a.image, a.quantity, a.payment_method, a.buyer_address, b.artistId 
                                       FROM `cart` AS a
                                       LEFT JOIN `sining_artworks1` AS b 
                                       ON a.artId = b.artId
                                       WHERE a.artistId='$user_id' AND a.ifChecked=1");
      $sql = mysqli_query($conn, "UPDATE `product_status` SET `product_status` = '$stat', `buyer_id` = '$user_id' WHERE `product_status` = '' AND `buyer_id` = '0'");
      
      $cart_delete = mysqli_query($conn, "DELETE FROM `cart` WHERE artistId='$user_id' AND ifChecked=1");
      

      $mail = new PHPMailer(true);

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
        $mail -> Password = 'ubagorbqalazafob';
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port = 465;

        $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

        $mail -> addAddress($_POST["email"]);

        $mail -> isHTML(true);

        $mail -> Subject = $_POST["subject"];
        $message = $_POST["message"];
      
         $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
         $mail->Body = "<p>$message</p>$signature";

        $mail -> send();
//--------------------------------------------------------------------
        $mail = new PHPMailer(true);

        $mail -> isSMTP();
        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
        $mail -> Password = 'ubagorbqalazafob';
        $mail -> SMTPSecure = 'ssl';
        $mail -> Port = 465;

        $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

        $mail -> addAddress($_POST["Semail"]);

        $mail -> isHTML(true);

        $mail -> Subject = $_POST["Ssubject"];
        $message = $_POST["Smessage"];
      
         
         $mail->Body = "<p>$message</p>$signature";

        $mail -> send();

        $sql1 = $sql = mysqli_query($conn, "UPDATE `sining_artworks1` SET `purchased` = '0' WHERE `artId` = '$orderId'");
        $result1 = mysqli_query($conn, $sql);

      header('location:userhistory.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Checkout</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/checkout_style.css">
   <?php
        include("navbar.php");
    ?>
</head>
<body>
 
 <div class="container deets">
 	<h1>Confirmation</h1>
 	<hr>
 	<div class="user_info">
 		<h2>User Information</h2>
 		<?php
 		$user_info = mysqli_query($conn, "SELECT DISTINCT a.artistName, a.artistEmail, b.payment_method, b.buyer_address 
                                 FROM `sining_artists` AS a LEFT JOIN
                                 `cart` AS b ON a.artistId = b.artistId
                                 WHERE a.artistId='$user_id'");
      
   if($user_info === false) {
        // Handle the error here
        echo "Error executing query: " . mysqli_error($conn);
    } else if(mysqli_num_rows($user_info) > 0){
        while($fetch_artist = mysqli_fetch_assoc($user_info)){
            echo '<h3>Name: '.$fetch_artist['artistName'].'</h3>';
            echo '<h3>Email: '.$fetch_artist['artistEmail'].'</h3>';
            echo '<h3>Payment Method: '.$fetch_artist['payment_method'].'</h3>';
            if (is_numeric($fetch_artist['buyer_address'])) {
            echo '<h3>Phone Number: '.$fetch_artist['buyer_address'].'</h3>';
            } 
            else {
            echo '<h3>Home Address: '.$fetch_artist['buyer_address'].'</h3>';
            }            

            $toemail = $fetch_artist['artistEmail'];
            $toadd = $fetch_artist['buyer_address'];
            $toname = $fetch_artist['artistName'];
        }
    }

   ?>   
 	</div>


 	<div class="row head">
            <div class="col-sm-1"><p class=" hidden-xs">Product</div>
            <div class="col-sm-5"></div>
            <div class="col-sm-2"><p>Price</p></div>
            <div class="col-sm-2"><p>Quantity</p></div>
            <div class="col-sm-1"><p>Total</p></div>
	</div>
 	<?php          
        // $select_cart = mysqli_query($conn, "SELECT a.*, b.*, c.* FROM `cart` AS a
        //                            LEFT JOIN `sining_artworks1` AS b ON a.artId = b.artId
        //                            LEFT JOIN `sining_sellers` AS c ON b.seller_id = c.seller_id
        //                            WHERE a.artistId='$user_id' AND a.ifChecked= 1");

        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE artistId='$user_id' AND ifChecked= 1");
        $grand_total = 0;

         if(mysqli_num_rows($select_cart) < 1){
            echo "<h4>There are no records at the moment!</h4>";
         }

         else if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
   ?>

         <div class="row orderDeets">
            <div class="col-sm-2"><img src="<?php echo $fetch_cart['image']; ?>" height="100" alt="Product image"></div>
            <div class="col-sm-4"><h2><?php echo $fetch_cart['name']; ?></h2></div>
            <div class="col-sm-2"><h2>₱<?php echo number_format($fetch_cart['price'],2); ?></h2></div>
            <div class="col-sm-2"><h2><?php echo $fetch_cart['quantity']; ?></h2></div>
            <div class="col-sm-1"><h2>₱<?php echo $sub = number_format($fetch_cart['price'] * $fetch_cart['quantity'],2); ?></h2></div>
            
            <?php $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); 

                  $ordername = $fetch_cart['name'];
                  $orderprice = $fetch_cart['price'];
                  $orderquantity = $fetch_cart['quantity'];
                  $orderseller = $fetch_cart['seller_name'];
                  $orderselleremail = $fetch_cart['seller_email'];
                  $orderId = $fetch_cart['artId'];

            ?>
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
    <!-- CONFIMARTION -->
   <div class="ch">
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="email" value="<?php echo $toemail;?>"><br>
      <input type="hidden" name="subject" value="Thank you for your order!"><br>
      <input type="hidden" name="message" value="<pre>
      Dear <?php echo $toname;?>,

      Thank you for placing an order with SINING. We are thrilled to have you as our customer and are grateful for your business.

      We are writing to let you know that your order has been confirmed and is being processed.

      As a reminder, here are the details of your order from <?php echo $orderseller;?>:

      Product(s): <?php echo $ordername;?><br>

      Quantity: <?php echo $orderquantity;?><br>

      Price: <?php echo $orderprice;?><br>

      Shipping Address: <?php echo $toadd;?><br>

      If you have any questions about your order, please feel free to reply to this email, and we will get back to you as soon as possible.

      Thank you again for choosing SINING. We appreciate your business and look forward to serving you again in the future.

      Best regards,

      JCRA Studio
      SINING Team.
      </pre>"><br>

      <input type="hidden" name="Semail" value="<?php echo $orderselleremail;?>"><br>
      <input type="hidden" name="Ssubject" value="New Order from <?php echo $toname;?>"><br>
      <input type="hidden" name="Smessage" value="<pre>
      Dear <?php echo $orderseller;?>,

      We are writing to inform you that a new order has been placed for your item, <?php echo $ordername;?>.
      The order details are as follows:

      Product(s): <?php echo $ordername;?><br>

      Quantity: <?php echo $orderquantity;?><br>

      Price: <?php echo $orderprice;?><br>

      Shipping Address: <?php echo $toadd;?><br>

      Please log in to your seller dashboard to view the order details and fulfill the order as soon as possible. If you have any questions or concerns, please don't hesitate to contact us.

      Thank you for your continued partnership with us.

      Best regards,

      JCRA Studio
      SINING Team.
      </pre>"><br>

	   <input type="submit" name="con" value="Confirm" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="myFunction()" />

   </form>
   </div>

</div>



<script>
function myFunction() {
  confirm("Are you sure you want to proceed?");
  windows.location.href="userhistory.php";
$(document).ready(function() {
  $('input[name=paymentMethod]').change(function() {
    var selectedValue = $('input[name=paymentMethod]:checked').val();
    $.ajax({
      type: 'POST',
      url: 'payment_method.php',
      data: {paymentMethod:selectedValue},
      success: function(response) {
        console.log('Payment method saved successfully.',selectedValue);
      },
      error: function() {
        console.log('Error saving payment method.',selectedValue);
      }
    });
  });
});
console.log(selectedValue);
}
</script>
<style>
   header{
      background-color: #212529;
   }
</style>
</body>
</html>