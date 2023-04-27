<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Privacy Settings</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
   <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" href=" css/updateprofile.css">
   <?php
        include("navbar.php");
    ?>
</head>
<?php  
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
   
if(isset($_POST['update_profile'])){

   $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
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
         mysqli_query($conn, "UPDATE `sining_artists` SET artistPassword = '$confirm_pass', artistEmail ='$update_email' WHERE artistId = '$user_id'") or die('query failed');
         $message[] = 'Password updated successfully!';
      }
   }
}
?>
<body>
<div class="container cont">

   <?php
      $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

<form action="" method="post" enctype="multipart/form-data">

   <span>Email :</span><br>
   <input type="email" name="update_email" value="<?php echo $fetch['artistEmail']; ?>" class="box"><br><br>
   <input type="hidden" name="old_pass" value="<?php echo $fetch['artistPassword']; ?>">
   <span>Old Password :</span><br>
   <input type="password" name="update_pass" placeholder="enter previous password" class="box"><br><br>
   <span>New Password :</span><br>
   <input type="password" name="new_pass" placeholder="enter new password" class="box"><br><br>
   <span>Confirm Password :</span><br>
   <input type="password" name="confirm_pass" placeholder="confirm new password" class="box"><br><br>
   <div class="buttons">
         <input type="submit" value="UPDATE" name="update_profile" class="btn">
         <a href="userprofile.php" class="btn">BACK</a>
   </div>      
</form>
</div>
<style>
   header{
      background-color: #212529;
   }
</style>
</body>
</html>