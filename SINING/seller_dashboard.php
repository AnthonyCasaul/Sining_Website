<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$ToBeApproved = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$user_id' AND product_status = 'To be approved'");
$count1 = mysqli_num_rows($ToBeApproved);

$ToShip = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$user_id' AND product_status = 'To ship'");
$count2 = mysqli_num_rows($ToShip);

$ToReceive = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$user_id' AND product_status = 'To receive'");
$count3 = mysqli_num_rows($ToReceive);

$Completed = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$user_id' AND product_status = 'Completed'");
$count4 = mysqli_num_rows($Completed);

$Cancelled = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$user_id' AND product_status = 'Cancelled'");
$count5 = mysqli_num_rows($Cancelled);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="header">
  <h1>SELLER PAGE</h1>
  <h3>DASHBOARD</h3>
</div>
    <div>
        <table>
          <thead>
            <tr>
                <th><p><?php echo $count1; ?></p><br>To Be Approved</th>
                <th><p><?php echo $count2; ?></p><br>To Ship</th>
                <th><p><?php echo $count3; ?></p><br>To Receive</th>
            </tr>
          </thead>
          <thead>
            <tr>
                <th><p><?php echo $count4; ?></p><br>Completed</th>
                <th><p><?php echo $count5; ?></p><br>Cancelled</th>
                <th><p>0</p><br>Sold Artworks</th>
            </tr>
          </thead>
        </table>
    </div>
    <div class="header">
        <h3>POSTED ARTWORKS</h3>
        <table>
            <tr>
                <th><p> 0 </p><br> dummy</th>
                <th><p> 0 </p><br> dummy</th>
                <th><p> 0 </p><br> dummy</th></tr><tr>
                <th><p> 0 </p><br> dummy</th>
                <th><p> 0 </p><br> dummy</th>
                <th><p> 0 </p><br> dummy</th>
            </tr>
        </table>
    </div>
</body>
</html>