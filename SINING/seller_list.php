<?php
include 'condb.php';
$seller_list = mysqli_query($conn, "SELECT * FROM sining_sellers");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminPage.css">
    <title></title>
</head>
<body>
<div class="header">
  <h1>ADMIN PAGE</h1>
  <h3>SELLER LIST</h2>
</div>
    <div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head">PROFILE</th>
              <th class="head">SELLER NAME</th>
              <th class="head">USERNAME</th>
              <th class="head">ADDRESS</th>
              <th class="head">CONTACT</th>
              <th class="head">EMAIL</th>
              <th class="head">QR CODE</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>    
    <?php
        if(mysqli_num_rows($seller_list) > 0){
			while($row = mysqli_fetch_assoc($seller_list)){
                $seller_id = $row['seller_id'];
                $seller_profile = $row['seller_profile'];
                $seller_name = $row['seller_name'];
                $seller_username = $row['seller_username'];
                $seller_address = $row['seller_address'];
                $seller_contact = $row['seller_contact'];
                $seller_email = $row['seller_email'];
                $seller_gcash = $row['seller_gcash'];
                

                echo '
        <thead>
            <tr>
              <th><img class=seller-profile src="seller_file/profile/'.$seller_profile.'"/></th>
              <th>'.$seller_name.'</th>
              <th>'.$seller_username.'</th>
              <th>'.$seller_address.'</th>
              <th>'.$seller_contact.'</th>
              <th>'.$seller_email.'</th>
              <th><img id=seller-qr class=seller-qr src="seller_file/gcash_qr/'.$seller_gcash.'" onclick="openImg()"/></th>
              <th>
              <form method="post" action="useractivation.php">
                  <input type="hidden" name="id" value="'.$seller_id.'">
                  <button type="submit" name="activate" class="showact_button"><img class="buttons" src="assets/img/check.png"></button>
                </th>
                <th>
                <button type="submit" name="deactivate" class="showact_button"><img class="buttons" src="assets/img/remove.png"></button>
                  </form>
              </th>
            </tr>
          </thead>';
    ?>
    <?php
   }    
  }
  else{
       echo "<div class='no_data'>No Data Found</div>";
  }
  ?>
  </table>
</body>
<script>
 function openImg(){
    var image = document.getElementById('seller-qr');
    var source = image.src;
    window.open(source); 
}
</script>
</html>