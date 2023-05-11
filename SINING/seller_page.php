<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$getsellerId = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row = mysqli_fetch_assoc($getsellerId);
$seller_id = $row['seller_id'];

$ToBeApproved = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'To be approved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller</title>
    <link rel="stylesheet" href="css/adminPage.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
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
              <th class="head">PAYMENT METHOD</th>
              <th class="head">ART QUANTITY</th>
              <th class="head">BUYER NAME</th>
              <th class="head">BUYER LOCATION</th>
              <th class="head">ORDER STATUS</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>
<?php
      if(mysqli_num_rows($ToBeApproved) > 0){
			    while($row = mysqli_fetch_assoc($ToBeApproved)){
                $orderid = $row['product_id'];
                $artid = $row['product_id'];
                $artTitle = $row['product_name'];
                $artPrice = $row['product_price'];
                $qty = $row['product_quantity'];
                $fullname = ucfirst(strtolower($row['buyer_name']));
                $location = $row['buyer_address'];
                $orderStat = $row['product_status'];
                $paymentMethod = $row['payment_method'];
                echo '
          <thead>
            <tr>
              <th>'.$artid.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th>'.$paymentMethod.'</th>
              <th>'.$qty.'</th>
              <th>'.$fullname.'</th>
              <th>'.$location.'</th>
              <th>'.$orderStat.'</th>
              <th>
              
                  <input type="hidden" name="approve" id="approve" value="'.$orderid.'">
                  <button type="submit" onclick="toApprove()" class="showact_button"><img class="buttons" src="assets/img/check.png"></button>
                </th>
              <th>
                  <input type="hidden" name="decline" id="decline" value="'.$orderid.'">
                  <button type="submit" onclick="toDecline()" class="showact_button"><img class="buttons" src="assets/img/remove.png"></button>
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
<script>
  function toReload() {
    console.log("reload");
  window.location.reload();
  }
  function toApprove(){
    const approve = $('#approve').val();
    console.log(approve);

    $.ajax({
    type: "POST",
    url: "update_status.php",
    data: {"approve": approve},
    success: function(result){
      alert("Order Approved");
      window.location.reload();
    }
});
  }
  function toDecline(){
    const decline = $('#decline').val();
    console.log(decline);

    $.ajax({
    type: "POST",
    url: "update_status.php",
    data: {"decline": decline},
    success: function(result){
      alert("Order Declined");
      window.location.reload();
    }
});
  }
</script>
</body>
</html>