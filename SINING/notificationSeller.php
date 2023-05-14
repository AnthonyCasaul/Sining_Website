<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$getsellerid = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row2 = mysqli_fetch_assoc($getsellerid);
$seller_id = $row2['seller_id'];

$getsellernotif = mysqli_query($conn, "SELECT * FROM notifications WHERE seller_id = '$seller_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Notification</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="css/adminPage.css">
</head>
<body>
<div class="header">
  <h1>SELLER PAGE</h1>
  <h3>SELLER NOTIFICATION</h2>
</div>
    <br>
    <br>
    <div class="rcrdPage">
    <br>
    <br><br>
    <table class="content-table" style="border: 1px solid red">
                    <thead>
                        <tr>
                        <th class="head sel-head">SELLER NOTIFICATION</th>
                        <th class="head sel-head">DATE</th>
                        </tr>
                    </thead>
    <?php
    if(mysqli_num_rows($getsellernotif) > 0){
			      while($row = mysqli_fetch_assoc($getsellernotif)){
                    $sellernotif = $row['notificationSeller'];
                    $date = $row['date'];

                    echo '
                    <tr>
                        <th class="sel-bod"><p>'.$sellernotif.'</p></th>
                        <th class="sel-bod"><p>'.$date.'</p></th>
                    </tr>
                    ';
                    
                  }
                }
    else{
        echo '<div>
            <p>No notification</p>
        </div>';
    }
    ?>
    </table>
    </div>
</body>
</html>