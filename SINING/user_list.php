<?php
include 'condb.php';
$user_list = mysqli_query($conn, "SELECT * FROM sining_artists");
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
  <h3>USER LIST</h2>
</div>
    <div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head">USER ID</th>
              <th class="head">FULLNAME</th>
              <th class="head">EMAIL</th>
              <th class="head">LOCATION</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>    
    <?php
        if(mysqli_num_rows($user_list) > 0){
			while($row = mysqli_fetch_assoc($user_list)){
                $user_id = $row['artistId'];
                $user_name = $row['artistName'];
                $user_email = $row['artistEmail'];
                $user_location = $row['artistLocation'];

                echo '
        <thead>
            <tr>
              <th>'.$user_id.'</th>
              <th>'.$user_name.'</th>
              <th>'.$user_email.'</th>
              <th>'.$user_location.'</th>
              <th>
              <form method="post" action="useractivation.php">
                  <input type="hidden" name="id" value="'.$user_id.'">
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
</html>