<?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];


if(isset($_POST['update_profile'])){

   $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
   $update_contact = mysqli_real_escape_string($conn, $_POST['update_contact']);
   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
   $update_location = mysqli_real_escape_string($conn, $_POST['update_location']);
   $update_bio = mysqli_real_escape_string($conn, $_POST['update_bio']);

   mysqli_query($conn, "UPDATE `sining_artists` SET artistName = '$update_name', artistContact ='$update_contact', artistEmail = '$update_email', artistLocation = '$update_location', artistBio = '$update_bio' WHERE artistId = '$user_id'") or die('query failed');

   /* 
   $old_pass = $_POST['old_pass'];
   $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
   $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
   $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

   if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
      if($update_pass != $old_pass){
         $message[] = 'old password not matched!';
      }elseif($new_pass != $confirm_pass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "UPDATE `sining_artists` SET artistPassword = '$confirm_pass' WHERE artistId = '$user_id'") or die('query failed');
         $message[] = 'password updated successfully!';
      }
   } */

   $update_image = $_FILES['update_image']['name'];
   $update_image_size = $_FILES['update_image']['size'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $update_image_folder = 'uploaded_img/'.$update_image;

   if(!empty($update_image)){
      if($update_image_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `sining_artists` SET artistProfile = '$update_image' WHERE artistId = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_image_tmp_name, $update_image_folder);
         }
         $message[] = 'image updated successfully!';
      }
   }

   $update_gcash = $_FILES['update_gcash']['name'];
   $update_gcash_size = $_FILES['update_gcash']['size'];
   $update_gcash_tmp_name = $_FILES['update_gcash']['tmp_name'];
   $update_gcash_folder = 'uploaded_img/'.$update_gcash;

   
   if(!empty($update_gcash)){
      if($update_gcash_size > 2000000){
         $message[] = 'image is too large';
      }else{
         $image_update_query = mysqli_query($conn, "UPDATE `sining_artists` SET artistgcash = '$update_gcash' WHERE artistId = '$user_id'") or die('query failed');
         if($image_update_query){
            move_uploaded_file($update_gcash_tmp_name, $update_gcash_folder);
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
   <link rel="stylesheet" href=" css/updateprofile1.css">
</head>

<body>
   
<div class="update-profile">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="post" enctype="multipart/form-data">
      <?php
         if($fetch['artistProfile'] == ''){
            echo '<img src="uploaded_image/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img/'.$fetch['artistProfile'].'">';
         }
         if(isset($message)){
            foreach($message as $message){
               echo '<div class="message">'.$message.'</div>';
            }
         }
      ?>
      <div class="flex">
         <div class="inputBox">
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box"><br><br><br>
            <span>Shop Name :</span>
            <input type="text" name="update_name" value="<?php echo $fetch['artistName']; ?>" class="box"><br>
            <span>Contact :</span>
            <input type="text" name="update_contact" value="<?php echo $fetch['artistContact']; ?>" class="box"><br>
            <span>Email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['artistEmail']; ?>" class="box"><br>
            <span>Address :</span>
            <input type="text" name="update_location" value="<?php echo $fetch['artistLocation']; ?>" class="box"><br>
            
         </div>
         <div class="inputBox">
         <span>Shop Description :</span>
            <input type="text" name="update_bio" value="<?php echo $fetch['artistBio']; ?>" class="box"><br>
            <input type="hidden" name="old_pass" value="<?php echo $fetch['artistPassword']; ?>">
            
            <span>Gcash :</span>
            <input type="file" name="update_gcash" accept="image/jpg, image/jpeg, image/png" class="box"><br><br><br>
            <?php
               if($fetch['artistgcash'] == ''){
                  echo '<img src="uploaded_image/default-avatar.png">';
               }else{
                  echo '<img src="uploaded_img/'.$fetch['artistgcash'].'">';
               }
            ?>
            
            <!--<span>Old Password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box"><br>
            <span>New Password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box"><br>
            <span>Confirm Password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box"><br><br>-->
         </div>
         
      </div>
      <div class="buttons">
         <input type="submit" value="UPDATE" name="update_profile" class="btn">
         <a href="sellerprofile.php" class="btn">BACK</a>
      </div>
      
   </form>
   

</div>

</body>
</html>