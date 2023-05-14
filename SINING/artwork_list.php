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
              <th class="head hide">Art ID</th>
              <th class="head hide">Image</th>
              <th class="head">Title</th>
              <th class="head">Artist Name</th>
              <th class="head">Price</th>
              <th class="head hide">Genre</th>
              <th class="head hide">Year</th>
              <th class="head">Archive</th>
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
                $artwork_sellerId = $row['seller_id'];
                echo '
        <thead>
            <tr>
              <th class="hide">'.$artwork_id.'</th>
              <th class="artwork-img-col hide"><img src="seller_file/artworks/seller_'.$artwork_sellerId.'/'.$artwork_image.'" class="posted-art-img" onclick="showImage(this.src)"></th>
              <th>'.$artwork_title.'</th>
              <th class="author">'.$artwork_artist.'</th>
              <th>'.$artwork_price.'</th>
              <th class="hide">'.$artwork_genre.'</th>
              <th class="hide">'.$artwork_year.'</th>
              <th>
              <form method="post" action="admin_artwork_list.php">
                  <input type="hidden" name="artworkId" value="'.$artwork_id.'">
                <input type="hidden" name="artworkId" value="'.$artwork_id.'">
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
  <script>
  function showImage(src) {
  var img = document.createElement("img");
  img.src = src;
  img.style.position = "fixed";
  img.style.top = "50%";
  img.style.left = "50%";
  img.style.transform = "translate(-50%, -50%)";
  img.style.maxWidth = "90%";
  img.style.maxHeight = "90%";
  img.style.borderRadius = "10px";
  img.style.boxShadow = "0 0 20px rgba(0, 0, 0, 0.3)";
  img.style.zIndex = "9999";
  img.style.cursor = "pointer";
  img.onclick = function() {
    document.body.removeChild(this);
  };
  document.body.appendChild(img);
}
</script>
  <script>
    for (let i = 0; i < <?php echo mysqli_num_rows($artworks); ?>; i++) {
    document.querySelector("#edit-btn-" + i).addEventListener("click",function(){
        document.querySelector(".popup").classList.add("active");
    });
}


document.querySelector(".popup .close-btn").addEventListener("click",function(){
    document.querySelector(".popup").classList.remove("active");
});
</script>

</body>
</html>