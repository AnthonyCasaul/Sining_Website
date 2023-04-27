<?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};  

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
  a:link {
  text-decoration: none;
  
   }
   </style>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>sellerprofile</title>

    <!-- custom css file link  -->
    <link rel="stylesheet" href=" css/sellerprofile.css">

</head>
<body>
   
<div class="wrapper">
<div class="container2">

<div class="update_art">
<?php
//start
error_reporting(E_ERROR | E_PARSE);
?>

    <table cellspacing = 0 cellpadding = 10 class="table3">

    <tr><td colspan="2" class="header"><h1>Archived Artworks</h1></td></tr>
    <tr>
      <td colspan="2" class="spacer"></td>
    </tr>
    

<?php
$genre= $_POST["genre"];
$i = 1;

$rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN artworks_archive ON sining_artists.artistId = artworks_archive.artistid WHERE artworks_archive.artistid='$user_id' ORDER BY artworks_archive.title ASC");  
?>

      
</div>
      <?php foreach ($rows as $row) : ?>
      <tr>
        <td class="title">Title</td>
        <td class="title1">"<?php echo $row["title"]; ?>"</td>
        </tr>
        <tr>
          <td class="price">Price</td>
        <td class="price1"><?php 
        $price=$row["price"];
        $formattedNum = number_format($price, 2);
        echo $formattedNum;
        ?></td>
        </tr>
        <tr>
          <td class="price">Genre</td>
        <td class="location1"><?php echo $row["genre"]; ?></td>
        </tr>
        <tr>
        <td class="image" colspan="2"> <img src=" uploaded_img/<?php echo $row["image"]; ?>" width = 200> </td>
        </tr><tr>
      <td class="show-box" colspan="2">
       <a href="archive_back.php? archiveid=<?php echo $row["artid"]; ?>"><button>Show</button></a>
      </td>
      </tr><tr>
        <td class="spacer" colspan="2"></td>
        </tr>
      <?php endforeach; ?>
    </table>
    <a href="sellerprofile.php"><button class="arc-back-btn">back</button></a>
</div>    
</div>

</body>
</html>