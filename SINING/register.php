<?php

include 'condb.php';

   use PHPMailer\PHPMailer\PHPMailer;
   use PHPMailer\PHPMailer\Exception;
   require 'phpmailer/src/Exception.php';
   require 'phpmailer/src/PHPMailer.php';
   require 'phpmailer/src/SMTP.php';

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'img/'.$image;
   $time = time();

   $otp = rand(1111, 9999);

   $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistEmail = '$email' AND artistPassword = '$pass'") or die('query failed');

   if(mysqli_num_rows($select) > 0){
      $message[] = 'user already exist'; 
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }elseif($image_size > 20000000){
         $message[] = 'image size is too large!';
      }else{
         $insert = mysqli_query($conn, "INSERT INTO `sining_artists`(artistName, artistPassword,  artistEmail, artistProfile, otp_code, regAtime) VALUES('$name', '$pass', '$email', '$image', '$otp', '$time')") or die('query failed');

         if($insert){
            $select = mysqli_query($conn, "SELECT artistId FROM `sining_artists` WHERE artistEmail = '$email' AND artistPassword = '$pass'") or die('query failed');
            while($row = mysqli_fetch_assoc($select)){
               $_SESSION['user_id'] = $row['artistId'];
            }
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'registered successfully!';

            $mail = new PHPMailer(true);

            $mail -> isSMTP();
            $mail -> Host = 'smtp.gmail.com';
            $mail -> SMTPAuth = true;
            $mail -> Username = 'sugaxxminyoongixxagustd@gmail.com';
            $mail -> Password = 'ubagorbqalazafob';
            $mail -> SMTPSecure = 'ssl';
            $mail -> Port = 465;

            $mail -> setFrom('sugaxxminyoongixxagustd@gmail.com');

            $mail -> addAddress($email);

            $mail -> isHTML(true);

            $mail -> Subject = "Account Verification Code";
            $message = "Here's the code to activate your account: " . $otp;
      
            $signature = "<html><body><br><img src='https://siningecommercewebsite.000webhostapp.com/img/Siningesign.jpg' alt='' class='img-responsive'></body></html>";
            $mail->Body = "<p>$message</p>$signature";

            $mail -> send();

            header('location:otpCheck.php');
         }else{
            $message[] = 'registration failed!';
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
<body background="assets/img/loginbg.jpg">
   
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