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
</head>
<style>
    *{
        color: white;
    }

</style>
<body>
    <div>
        <h2>Artwork Status</h2>
        <table>
          <thead>
            <tr>
                <th><?php echo $count1; ?></th>
                <th><?php echo $count2; ?></th>
                <th><?php echo $count3; ?></th>
            </tr>
            <tr>
                <th>To Be Approved</th>
                <th>To Ship</th>
                <th>To Receive</th>
            </tr>
          </thead>
          <thead>
            <tr>
                <th><?php echo $count4; ?></th>
                <th><?php echo $count5; ?></th>
                <th>0</th>
            </tr>
            <tr>
                <th>Completed</th>
                <th>Cancelled</th>
                <th>Sold Artworks</th>
            </tr>
          </thead>
        </table>
    </div>
    <div>
        <h3>POSTED ARTWORKS</h3>
    </div>
</body>
</html>