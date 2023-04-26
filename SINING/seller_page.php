<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$select = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
 if(mysqli_num_rows($select) > 0){
			      while($row = mysqli_fetch_assoc($select)){
                $seller_name     = $row['seller_name'];   
                $seller_username = $row['seller_username'];
                $seller_address  = $row['seller_address'];
                $seller_contact  = $row['seller_contact']; 
                $seller_email    = $row['seller_email'];
                $seller_profile  = $row['seller_profile']; 
                $seller_gcash    = $row['seller_gcash'];
            }
  }
  else {
    echo '<script>alert("There is no data found!!");</script>';
  }
$approval = mysqli_query($conn, "SELECT a.product_id, a.seller_id, a.product_name, a.product_price, a.product_quantity, b.artistName, b.artistLocation, a.product_status
                                    FROM `product_status` a
                                  LEFT JOIN `sining_artists` b ON a.buyer_id = b.artistId
                                        WHERE seller_id = '$user_id'");
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
              <th class="head">ART ID</th>
              <th class="head">ART TITLE</th>
              <th class="head">ART PRICE</th>
              <th class="head">ART QUANTITY</th>
              <th class="head">BUYER NAME</th>
              <th class="head">BUYER LOCATION</th>
              <th class="head">ORDER STATUS</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>
<?php
      if(mysqli_num_rows($approval) > 0){
			    while($row = mysqli_fetch_assoc($approval)){
                $orderid = $row['product_id'];
                $artid = $row['product_id'];
                $artTitle = $row['product_name'];
                $artPrice = $row['product_price'];
                $qty = $row['product_quantity'];
                $fullname = ucfirst(strtolower($row['artistName']));
                $location = $row['artistLocation'];
                $orderStat = $row['product_status'];
                echo '
          <thead>
            <tr>
              <th>'.$artid.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th>'.$qty.'</th>
              <th>'.$fullname.'</th>
              <th>'.$location.'</th>
              <th>'.$orderStat.'</th>
              <th>
              <form method="post" action="insertNewSeller.php">
                  <input type="hidden" name="id" value="'.$orderid.'">
                  <button type="submit" class="showact_button"><img class="buttons" src="assets/img/check.png"></button>
                  </form>
                </th>
                <th>
                  <form method="post" action="reject.php">
                  <input type="hidden" name="id" value="'.$orderid.'">
                  <button type="submit" class="showact_button"><img class="buttons" src="assets/img/remove.png"></button>
                  </form>
              </th>
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