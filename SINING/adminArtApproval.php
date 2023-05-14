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
              <th class="head hide">ARTIST ID</th>
              <th class="head">ART TITLE</th>
              <th class="head">ART PRICE</th>
              <th class="head hide">ART GENRE</th>
              <th class="head hide">ART TAGS</th>
              <th class="head hide">ART IMAGE</th>
              <th class="head">APPROVE</th>
              <th class="head">REJECT</th>
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
                $seller_id = $row['seller_id'];
                
                 
                echo '
          <thead>
            <tr>
              <th class="hide">'.$id.'</th>
              <th>'.$artTitle.'</th>
              <th>'.$artPrice.'</th>
              <th class="hide">'.$artGenre.'</th>
              <th class="hide">'.$artTags.'</th>
              <th class="hide">
                <img src="seller_file/artworks/seller_'.$seller_id.'/'.$artImage.'" class="posted-art-img"  alt="My Image" onclick="showImage(this)">
              </th>
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
  <div id="img-overlay"></div>
  <script>
    function showImage(img) {
  var overlay = document.getElementById("img-overlay");
  var modal = document.createElement("div");
  var modalImage = document.createElement("img");

  modalImage.src = img.src;
  modalImage.alt = img.alt;
  modalImage.style.maxWidth = "80%";
  modalImage.style.maxHeight = "80%";

  modal.id = "image-modal";
  modal.appendChild(modalImage);
  document.body.appendChild(modal);

  overlay.style.display = "block";
  modal.style.display = "block";
}

document.getElementById("img-overlay").addEventListener("click", function() {
  var overlay = document.getElementById("img-overlay");
  var modal = document.getElementById("image-modal");

  overlay.style.display = "none";
  modal.style.display = "none";
  modal.remove();
});
  </script>
</body>
</html>