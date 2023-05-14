<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];


$getbuyernotif = mysqli_query($conn, "SELECT * FROM notifications WHERE buyer_id = '$user_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/notification_style.css">
    <title>Buyer Notification</title>
    <?php
      include("navbar.php");
   ?>
   <style>
   header{
      background-color: #212529;
   }
   </style>
</head>
<body>
    <br>
    <br>
    <div class="container cont">
    <br>
    <h1>Notification</h1>
    <br><br>
    <?php
    if(mysqli_num_rows($getbuyernotif) > 0){
			      while($row = mysqli_fetch_assoc($getbuyernotif)){
                    $buyernotif = $row['notificationBuyer'];
                    $date = $row['date'];

                    echo '<div class="row">
                    <div class="col-md-6"><p>'.$buyernotif.'</p></div>
                    <div class="col-md-6"><p>'.$date.'</p></div>
                    <hr>
                    </div>';
                    
                  }
                }
    else{
        echo '<div>
            <p>No notification</p>
        </div>';
    }
    ?>
    </div>

</body>
</html>