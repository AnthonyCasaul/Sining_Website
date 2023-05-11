<?php
include 'condb.php';

$approval = mysqli_query($conn, "SELECT * FROM sining_approval");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/adminPage.css">
</head>
<body>
<div class="header">
  <h1>ADMIN PAGE</h1>
  <h3>ART APPROVAL LIST</h2>
</div>
<div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head">ARTIST ID</th>
              <th class="head">ART TITLE</th>
              <th class="head">ART PRICE</th>
              <th class="head">ART GENRE</th>
              <th class="head">ART TAGS</th>
              <th class="head">ART IMAGE</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>    
    <?php
        if(mysqli_num_rows($approval) > 0){
			while($row = mysqli_fetch_assoc($approval)){
                $id = $row['id'];
                $artTitle = ucfirst(strtolower($row['artTitle']));
                $artPrice = $row['artPrice'];
                $artGenre= $row['artGenre'];
                $artTags = $row['artTags'];
                $artImage = $row['artImage'];
                
                 
                echo '
          <thead>
            <tr>
              <th>'.$id.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th>'.$artGenre.'</th>
              <th>'.$artTags.'</th>
              <th>'.$artImage.'</th>
              <th>
              <form method="post" action="insertNewArtwork.php">
                  <input type="hidden" name="id" value="'.$id.'">
                  <button type="submit" class="showact_button"><img class="buttons" src="assets/img/check.png"></button>
                  </form>
                </th>
                <th>
                  <form method="post" action="reject.php">
                  <input type="hidden" name="id" value="'.$id.'">
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
</body>
</html>