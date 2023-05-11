<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$getsellerId = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row = mysqli_fetch_assoc($getsellerId);
$seller_id = $row['seller_id'];

$artworks = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE seller_id = '$seller_id' AND archive = 0 ORDER BY random ASC");

if(isset($_POST["arc"])){
    $artID = $_POST["artid"];
  
  $query = mysqli_query($conn, "UPDATE sining_artworks1 SET archive = 1 WHERE artId = '$artID'");
  $query1 = mysqli_query($conn, "UPDATE sining_artworks SET archive = 1 WHERE artId = '$artID'");
  
  header("location: archivearts.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tagsInput.css" />
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">
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
              <th class="head">Image</th>
              <th class="head">Title</th>
              <th class="head">Price</th>
              <th class="head">Genre</th>
              <th class="head">Year</th>
              <th class="head">Unarchive</th>
            </tr>
          </thead>    
          <?php
      if(mysqli_num_rows($artworks) > 0){
			    while($row = mysqli_fetch_assoc($artworks)){
                $artworkname = $row['artTitle'];
                $artistname = $row['artistName'];
                $artprice = $row['artPrice'];
                $artyear = $row['artYear'];
                $artimage = $row['artImage'];
                $artgenre = $row['artGenre'];
                $sellerID = $row['seller_id'];
                $artId = $row['artId'];
           echo '
         <form action="" method="POST">
         <table class="posted-art-table">
         <tr>
         <td><img class="posted-art-img" src="seller_file/artworks/seller_'.$sellerID.'/'.$artimage.'" onclick="showImage(this)"></td>
         <td>'.$artworkname.'</td>
         <td>₱'.$artprice.'</td>
         <td>'.$artgenre.'</td>
         <td>'.$artyear.'</td>
         <td><input type="hidden" name="artid" value='.$artId.'>
         <button type="submit" name="arc" class="btn1" value=""><img src="assets/img/download-file.png"></td>
         </tr>
         </table>
         </form>
         ';           
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