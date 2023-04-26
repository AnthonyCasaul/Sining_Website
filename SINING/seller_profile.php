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
    <link rel="stylesheet" href="css/seller_profile.css">
    <title>Seller</title>
</head>
<body>
<div>
  <img src="seller_file/profile/<?php echo $seller_profile; ?>" width=20% height=20%/>
  <h1><?php echo $seller_username;?></h1>
  <h3><?php echo $seller_name;?></h3>


    <button id="example-btn"><img src="assets/img/upload.png">Sell</button>
</div>
<script>
    const exampleBtn = document.getElementById('example-btn');

    exampleBtn.addEventListener('click', () => {
    window.open('seller_upload.php');
    });

</script>
</body>
</html>