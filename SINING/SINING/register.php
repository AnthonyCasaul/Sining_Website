<?php

include 'condb.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $contact = mysqli_real_escape_string($conn, $_POST['contact']);
   $location = mysqli_real_escape_string($conn, $_POST['location']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'img/'.$image;

   $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistEmail = '$email' AND artistPassword = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 20000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `sining_artists`(artistName, artistPassword, artistContact, artistEmail, artistLocation, artistProfile) VALUES('$name', '$pass', '$contact', '$email', '$location', '$image')") or die('query failed');

         if($insert){
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';
            header('location:index.php');
         }else{
            $message[] = 'registeration failed!';
         }
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
   <title>SINING Register</title>
   <link rel="stylesheet" href="css/loginregister.css">
</head>
<body background="loginbg.jpg">
   
<div class="container reg">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>Register</h3>
      <?php
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
      ?>
      <input type="text" name="name" placeholder="Enter Username" class="box" required><br>
      <input type="email" name="email" placeholder="Enter Email" class="box" required><br>
      <input type="text" placeholder="Contact No." name="contact" required><br>
      <input type="text" placeholder="Location" name="location" required><br>
      <input type="password" name="password" placeholder="Enter Password" class="box" required><br>
      <input type="password" name="cpassword" placeholder="Confirm Password" class="box" required><br>
      <p>Profile Picture</p>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png"><br>
      <input type="submit" name="submit" value="Register" class="btn">
      <p>Already have an account? <a href="index.php">Login here</a></p>
   </form>

</div>

</body>
</html>