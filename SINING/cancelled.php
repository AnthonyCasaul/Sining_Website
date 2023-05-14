<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$getsellerId = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row = mysqli_fetch_assoc($getsellerId);
$seller_id = $row['seller_id'];

$Cancelled = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'Cancelled'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>
    <link rel="stylesheet" href="css/adminPage.css">
</head>
<body>

<div class="header">
  <h1>SELLER PAGE</h1>
  <h3>PAYMENT APPROVAL</h2>
</div>
<div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head hide">ART ID</th>
              <th class="head">ART TITLE</th>
              <th class="head">ART PRICE</th>
              <th class="head">PAYMENT METHOD</th>
              <th class="head hide">ART QUANTITY</th>
              <th class="head">BUYER NAME</th>
              <th class="head hide">BUYER LOCATION</th>
            </tr>
          </thead>
<?php
      if(mysqli_num_rows($Cancelled) > 0){
			    while($row = mysqli_fetch_assoc($Cancelled)){
                $orderid = $row['product_id'];
                $artid = $row['product_id'];
                $artTitle = $row['product_name'];
                $artPrice = $row['product_price'];
                $qty = $row['product_quantity'];
                $fullname = ucfirst(strtolower($row['buyer_name']));
                $location = $row['buyer_address'];
                $paymentMethod = $row['payment_method'];
                echo '
          <thead>
            <tr>
              <th class="hide">'.$artid.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th>'.$paymentMethod.'</th>
              <th class="hide">'.$qty.'</th>
              <th class="author">'.$fullname.'</th>
              <th class="hide">'.$location.'</th>
            </tr>
          </thead>';
    ?>
<?php
   }    
  }
  else{
      echo "<div class='no_data' id='no_data'>No Data Found</div>";
  }

  ?>
  </table>
  <div></div>
</body>
</html>