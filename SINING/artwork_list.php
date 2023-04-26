<?php
include 'condb.php';
$artwork_list = mysqli_query($conn, "SELECT * FROM sining_artworks1");
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
  <h3>ARTWORK LIST</h2>
</div>
    <div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head">Art ID</th>
              <th class="head">Image</th>
              <th class="head">Title</th>
              <th class="head">Artist Name</th>
              <th class="head">Price</th>
              <th class="head">Genre</th>
              <th class="head">Year</th>
              <th class="head"></th>
              <th class="head"></th>
            </tr>
          </thead>    
    <?php
        if(mysqli_num_rows($artwork_list) > 0){
			while($row = mysqli_fetch_assoc($artwork_list)){
                $artwork_id = $row['artId'];
                $artwork_image = $row['artImage'];
                $artwork_artist = $row['artistName'];
                $artwork_title = $row['artTitle'];
                $artwork_price= $row['artPrice'];
                $artwork_genre = $row['artGenre'];
                $artwork_year = $row['artYear'];
                echo '
        <thead>
            <tr>
              <th>'.$artwork_id.'</th>
              <th class=artwork-img-col><img id=artwork-img class=artwork-img src="'.$artwork_image.'" /></th>
              <th>'.$artwork_title.'</th>
              <th>'.$artwork_artist.'</th>
              <th>'.$artwork_price.'</th>
              <th>'.$artwork_genre.'</th>
              <th>'.$artwork_year.'</th>
              <th>
              <form method="post" action="admin_artwork_list.php">
                  <input type="hidden" name="artworkId" value="'.$artwork_id.'">
                  <button type="submit" name="view" class="showact_button"><img src=assets/img/zoom-in.png /></button>
                </th>
                <th>
                  <button type="submit" name="archive" class="showact_button"><img src=assets/img/download-file.png /></button>
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