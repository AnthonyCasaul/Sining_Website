   <?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

   <script>
      var full_url = '';

      function getImage(photo){
         var url_splits = photo.split('\\');
         var last = url_splits.length - 1;
         var real_url = url_splits[last];
         full_url = "http://localhost/jcra-sining/img/" + real_url;
         var preview = document.getElementById('preview');
         preview.style.display = "block";
         preview.src = full_url;
         alert(full_url);
      }

      function upload(){
         var ajax = new XMLHttpRequest();
         ajax.onreadystatechange = function(){
            if(ajax.readyState === 4 && ajax.status === 200){
               var mess = ajax.responseText;
               var preview = document.getElementById('preview');
               preview.style.display = "none";
               preview.src = "";
               getFeed();
            }
         };
         ajax.open('POST', 'upload.php', true);
         ajax.setRequestHeader('Content-type', 'application/x-www-form-urlcoded');
         ajax.send("imageName" + full_url);
      }

      function getFeed(){
         var cont = document.getElementById('main');
         var ajax = new XMLHttpRequest();
         ajax.onreadystatechange = function(){
            if(ajax.readyState === 4 && ajax.status === 200){
               main.innerHTML = ajax.response;
            }
         };
         ajax.open('GET', 'user_get_feed.php', true);
         ajax.send();
      }

      function zoom(){
         document.body.style.zoom = "80%"
      }
      function start(){
         getFeed();
         zoom();
      }
   </script>
   
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>
   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/userprofile.css">
   <!-- <link rel="stylesheet" href="css/style2.css">-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
   <?php
      include("navbar.php");
   ?>
</head>
<style>
   .user-profile-con{
      margin-top: 200px;
   }
</style>

<body onload="start()">
<div class="container user-profile-con">
   <div class="cvr">
   <?php
         $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['artistCover'] == ''){
            echo '<img src="images/default-avatar.png">';
         }else{
            echo '<img src="cover/'.$fetch['artistCover'].'" height=400 width=100% style="max-height: 100%;">';
         }
      ?>
      </div>

   <div class="profile">
      <?php
         $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
         if(mysqli_num_rows($select) > 0){
            $fetch = mysqli_fetch_assoc($select);
         }
         if($fetch['artistProfile'] == ''){
            echo '<img src="img/default-avatar.png">';
         }else{
            echo '<img src="img/'.$fetch['artistProfile'].'">';
         }
      ?>
      <h3><?php echo $fetch['artistName']; ?></h3>
      <h2><?php echo $fetch['artistBio']; ?></h2><br>
      <a href="update_userprofile.php" class="btn">Edit Profile<i class="fa fa-cogs" style="color: #2f3640; margin-left: 2%;"></i></a><br><br>
      <!--<a href="home.php?logout=<?php echo $user_id; ?>" class="delete-btn">Logout</a>-->
      <table>
      <tr>
         <td>followers <br>
            num
         </td>
         <td>POSTS <br>
            num
         </td>
      </tr>
   </table>
   </div>
</div>


<article>
      <div>
         <div>
            <img src="" id="preview" width="100%" height="100%" style="display: none;">
         </div>

         <label class="upload" for="uploadDialog"><i class="fa fa-file-image-o"></i></label>
         <form action="upload.php" method="post" enctype="multipart/form-data">
         <input type="text" name="caption" placeholder="Write Caption">
         <input type="file" id="uploadDialog" style="display: none;" name="my_image" onchange="getImage(this.value)"/>
         <input type="submit" name="submit" value="Upload Image" >
      </div>
   </form>
   </article>
   <main id="main">
      
   </main>
</body>
</html>