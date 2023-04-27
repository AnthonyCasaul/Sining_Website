<?php

include 'condb.php';
session_start();

$user_id = $_SESSION['user_id'];


if(isset($_POST['update_artworks'])){


  

   $update_title = mysqli_real_escape_string($conn, $_POST['update_title']);
   $update_genre = mysqli_real_escape_string($conn, $_POST['update_genre']);
   $update_price = mysqli_real_escape_string($conn, $_POST['update_price']);

   mysqli_query($conn, "UPDATE `sining_artworks` SET artTitle ='$update_title', artGenre ='$update_genre', artPrice = '$update_price' WHERE artId =' ". $_GET['updateid']." ' ") or die('query failed');


   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `sining_artworks` SET artImage = '$update_image' WHERE artId ='". $_GET['updateid']."'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated successfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/updateprofile1.css">
</head>
<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `sining_artworks` WHERE artId ='". $_GET['updateid']."'   ") or die('query failed');
      
      
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
      
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['artImage'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="../uploaded_img/'.$fetch['artImage'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            <span>Title :</span>
            <input type="text" name="update_title" value="<?php echo $fetch['artTitle']; ?>" class="box">
            <span>Genre :</span>
            <input type="text" name="update_genre" value="<?php echo $fetch['artGenre']; ?>" class="box">
            <span>Price :</span>
            <input type="number" name="update_price" value="<?php echo $fetch['artPrice']; ?>" class="box">
         </div>
      </div>
      <div class="button">
      <input type="submit" value="UPDATE" name="update_artworks" class="btn">
      
      </form>
      <button class="btn"><a href="sellerprofile.php">BACK</a></button>
      </div>

</div>

</body>
</html>