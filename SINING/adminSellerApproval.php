<?php
include 'condb.php';

session_start();


$approval = mysqli_query($conn, "SELECT * FROM sining_seller_approval");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SINING | ADMIN</title>
    <link rel="stylesheet" href="css/adminPage.css">
</head>
<body>
<div class="header">
  <h1>ADMIN PAGE</h1>
<h3>SELLER APPROVAL LIST</h3>
</div>
<div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head hide">ARTIST ID</th>
              <th class="head">FULLNAME</th>
              <th class="head hide">USERNAME</th>
              <th class="head hide">ADDRESS</th>
              <th class="head hide">CONTACT</th>
              <th class="head">EMAIL</th>
              <th class="head">APPROVE</th>
              <th class="head">REJECT</th>
            </tr>
          </thead>    
    <?php
        if(mysqli_num_rows($approval) > 0){
			while($row = mysqli_fetch_assoc($approval)){
                $id = $row['artistId'];
                $sellerid = $row['seller_id'];
                $fullname = ucfirst(strtolower($row['seller_name']));
                $username = $row['seller_username'];
                $address= $row['seller_address'];
                $contact = $row['seller_contact'];
                $email = $row['seller_email'];
                
                 
                echo '
          <thead>
            <tr>
              <th class="hide">'.$id.'</th>
              <th>'.$fullname.'</th>
              <th class="hide">'.$username.'</th>
              <th class="hide">'.$address.'</th>
              <th class="hide">'.$contact.'</th>
              <th>'.$email.'</th>
              <th>
              <form method="post" action="insertNewSeller.php">
                  <input type="hidden" name="id" value="'.$sellerid.'">
                  <button type="submit" class="showact_button"><img class="buttons" src="assets/img/check.png"></button>
                  </form>
                </th>
                <th>
                  <form method="post" action="seller_reject.php">
                  <input type="hidden" name="id" value="'.$sellerid.'">
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
</html>