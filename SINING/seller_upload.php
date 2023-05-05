<?php
require 'condb.php';
error_reporting(E_ERROR | E_PARSE);
session_start();
$user_id = $_SESSION['user_id'];

if(isset($_POST["submit"])){
  $title= $_POST["title"];
  $genre= $_POST["genre"];
  $price= $_POST["price"];
  $tags= $_POST["tags"];



  #upload image#
  if($_FILES["image"]["error"] == 4){
    echo
    "<script> alert('Image Does Not Exist'); </script>"
    ;
  }
  else{
    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if ( !in_array($imageExtension, $validImageExtension) ){
      echo
      "
      <script>
        alert('Invalid Image Extension');
      </script>
      ";
    }
    else if($fileSize > 20000000){
      echo
      "
      <script>
        alert('Image Size Is Too Large');
      </script>
      ";
    }
    else{
      $newImageName = uniqid();
      $newImageName .= '.' . $imageExtension;
      
      $select = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
      $row = mysqli_fetch_assoc($select);
      $seller_id = $row['seller_id'];
      $seller_name = $row['seller_name'];

      
      move_uploaded_file($tmpName, 'uploaded_img/' . $newImageName);
      #Insert data#
      $query = "INSERT INTO sining_approval (artistId, artId, artistName, artTitle, artImage, artPrice, artGenre, artTags, artYear, artRate, purchased)    VALUES ('$seller_id', ' ', '$seller_name', '$title', '$newImageName','$price','$genre', '$tags', '2023', '10', '1')";

      mysqli_query($conn, $query);
      echo
      "
      <script>
        alert('Successfully Added');
        document.location.href= 'data.php';
      </script>
      ";
    }
  }
  header('location: seller.php');
}
#upload image#

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/upload.css">
    <!-- Tags -->
   <link rel="stylesheet" type="text/css" href="css/tagsInput.css" /> 
   <script src="http://code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script> 
  
  <body>
   <?php
      include("navbar.php");
   ?>
  <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">

  <div class="wrapper">
   <div class="container">
   <table class="outer-tab">
      <td>

            <table class="inner-tab">
            <tr>
         <td>
            <label for="title">Title : </label>
         </td>
         <td>
            <input type="text" name="title" id = "title" required value="">
         </td>
         </tr>
      <tr>
         <td> 
            <label for="genre">genre : </label>
         </td>
         <td>
            <input type="text" name="genre" id = "genre" required value="">
         </td>
         </tr>
      <tr>
         <td>
            <label for="price">Price: </label>
         </td>
         <td>
            <input type="number" name="price" id = "price" required value="">
         </td>
      </tr>
      <tr>
         <td>
            <label for="image">Image : </label>
         </td>
         <td>
            <input type="file" name="image" id ="image" accept=".jpg, .jpeg, .png" value="">
         </td>
      </tr>
      <tr>
         <td>
            <label for="tags">Tags: </label>
         </td>
         <td>
            <input name="tags" id="tags" />
         </td>
      </tr>
      <tr>
         <td colspan="2" class="button">
            <button type = "submit" name = "submit">Submit</button>
            </form>
            <a href="sellerprofile.php"><button>Cancel</button></a>
         </td>
      </tr>
            </table>
         </td>
   </table>
   </tr>
   </div>
  </div>
  <!-- Tags -->
  <script src="js/tagsinput.js"></script>  
   <script>
         $(document ).ready(function() {
            $('#tags').tagsInput();
         });
   </script>
  </body>
</html>