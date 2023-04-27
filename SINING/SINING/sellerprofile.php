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
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sining | Seller Profile</title>
   <link rel="icon" type="image/x-icon" href=" assets/logo.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/sellerprofile.css">
   <link rel="stylesheet" href="css/style2.css">
</head>

<script type="text/javascript">
        function zoom() {
            document.body.style.zoom = "80%" 
        }
    </script>

    <body onload="zoom()" id="page-top">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <!-- <a class="navbar-brand" href="#page-top"><img src="assets/img/navbar-logo.svg" alt="..." /></a> -->
                <a class="navbar-brand" href=" ../homepage.php"><h1 class="ti-logo"><img class="logo" src=" assets/img/logos/logo1.png"> Sining</h1></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="search collapse navbar-collapse" id="navbarResponsive">
                    <ul class="menu-bar navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#portfolio">Artworks</a>
                        <ul class="submenu1">
                                        <li><a href="#">Photography</a></li>
                                        <li><a href="#">Portrait</a></li>
                                        <li><a href="#">Anime</a></li>
                                        <li><a href="#">Traditional</a></li>
                                    </ul></li>
                        <li class="nav-item"><a class="nav-link" href="sellerprofile.php">Sell</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Editorial</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">Artists</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    </ul>
                    <div class="search-box">
                        <a class="search-btn" href="#">
                            <img src="assets/img/search.png">
                        </a>
                        <input class="search-txt" type="text" name="" placeholder="Type to search">
                    </div>
                </div>
                &nbsp&nbsp
                <div class="account-btn">
                        <img src="assets/img/account.png">
                        <div class="submenu">
                        <a href="#" id="account-lbl">Manage Account</a><br><br>
                        <a href="sellerprofile.php?logout=<?php echo $user_id; ?>" id="account-lbl">Logout</a>
                        </div>
                    </div>
            </div>
        </nav>
<div class="wrapper">
<div class="inner-wrapper">
<!-- <a href="#" class="">Back</a>   -->

<div class="upper-con">
   <div class="container1">
      <div class="inner-con">
      <div class="profile">
         <?php
            $select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
               $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['artistProfile'] == ''){
               echo '<img src="images/default-avatar.png">';
            }else{
               echo '<img src="uploaded_img/'.$fetch['artistProfile'].'">';
            }
         ?>
         <h3 class="p1 seller-name"><?php echo $fetch['artistName']; ?>
         
         <a class="setting-btn" href="update_profile.php">
               <img class="setting-img" src="assets/img/edit-btn.png">
         </a></h3>
      </div> 
      </div>
   </div>
</div>

<div class="lower-con">
<div class="update_art">
<?php
//start
error_reporting(E_ERROR | E_PARSE);
?>

<!-- SEARCH -->


    <table class="table1">
    <tr>
      <td colspan="2" class="search-col">
      <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
      <!-- <label for="title">Title : </label> -->
      <div class="search-box">
      <input type="text" name="title" id = "title" required value="" placeholder="Search Product" class="search-bar">
      <button type = "submit" name = "submit" class="search-btn"><img src="assets/img/search1.png"></button>
      </div>
    </form>
      </td>
    </tr>
    <tr>
      <td class="gray-box add"><a href="seller_upload.php" class="btn"><button><img src="assets/img/add-btn.png">Add Products</button></a></td>
    
         <td class="gray-box arc"><a href="archive_page.php" class="btn"><button><img src="assets/img/arc-btn.png">Archived Products</button></a></td>
      </tr>
    </table>
    
   <table cellspacing = 0 cellpadding = 10 class="table2 table-top">
   <?php
      $title= $_POST["title"];
      $i = 1;
      if(isset($_POST['submit'])){
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.artistId = sining_artworks.artistId WHERE sining_artworks.artistId='$user_id' AND artTitle LIKE '%$title%' ORDER BY sining_artworks.artTitle DESC");
      ?>
         searched "<?php echo $title= $_POST["title"];?>"
      <?php
      } 
?>

      <?php foreach ($rows as $row) : ?>
         <tr>
         <td class="title-con1">Title</td>
        <td class="title-con2"><?php echo $row["artTitle"]; ?></td>
        </tr>
    <tr>
    <td class="loc-con1">Year</td>
        <td class="loc-con2"><?php echo $row["artYear"]; ?></td>
        </tr>
    <tr>
    <td class="price-con1">Price</td>
        <td class="price-con2">₱ <?php 
        $price=$row["artPrice"];
        $formattedNum = number_format($price, 2);
         echo $formattedNum;
        ?></td>
        </tr>
        <td colspan="2" class="image"> <img src="uploaded_img/<?php echo $row["artImage"]; ?>" width = 300> </td>
        </tr>
    <tr>
<!-- START UPDATE-->
      <td class="gray-box add">
            <a href="update_artworks.php? updateid=<?php echo $row["artId"]; ?>"><button><img src="assets/img/edit-btn.png">Edit</button></a>
      </td>
        
<!-- END UPDATE-->
      <td class="gray-box arc">
            <a href="archive_artworks.php? archiveid=<?php echo $row["artId"]; ?>"><button><img src=" assets/img/arc2-btn.png">Archive</button></a>
      </td>
      </tr>
      <?php endforeach;?>
    </table>

    <table class="table2">
    <!-- <td style="font-size:5vw" colspan="2"> Artworks</td> -->

<?php
      $genre= $_POST["genre"];
      $i = 1;
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.artistId = sining_artworks.artistId WHERE sining_artworks.artistId='$user_id' ORDER BY sining_artworks.artTitle ASC");  
?>   
</div>
      <tr >
        <td style="font-size:3vw" colspan="2" class="space-top"><?php echo $genre= $_POST["genre"];?></td>
      </tr>
      <?php foreach ($rows as $row) : ?>
   
      <tr class="title-box">
         <td class="title-con1">Title</td>
        <td class="title-con2"><?php echo $row["artTitle"]; ?></td>
        </tr>
    
    <tr class="price-box">
    <td class="price-con1">Price</td>
        <td class="price-con2">₱ <?php 
        $price=$row["artPrice"];
        $formattedNum = number_format($price, 2);
         echo $formattedNum;
        ?></td>
        </tr>

    <tr class="loc-box">

    <!-- TAGS 
    <td class="loc-con1">Tags</td>
        <td class="loc-con2"><?php $split = explode(",", $row["artTags"]." "); ?>
        <div class="title-box"> 
               <?php 
               foreach($split as $tag)
                  {
               ?>
               <span class="title-box" style="color: black;"><?php echo $tag; ?></span>
               <?php } ?>
            
            </div>-->
    <tr class="title-box">
        <td class="loc-con1">Genre</td>
        <td class="loc-con2"><?php echo $row["artGenre"]; ?>
    </tr>
        </tr>
        <td colspan="2" class="image"> <img src=" uploaded_img/<?php echo $row["artImage"]; ?>" width = 300> </td>
        </tr>
    
    <tr>
<!-- START UPDATE-->
      <td class="gray-box add">
         
            <a href="update_artworks.php? updateid=<?php echo $row["artId"]; ?>"><button><img src=" assets/img/edit-btn.png">Edit</button></a>
      </td>
        
<!-- END UPDATE-->
      <td class="gray-box arc">
            <a href="archive_artworks.php? archiveid=<?php echo $row["artId"]; ?>"><button><img src=" assets/img/arc2-btn.png">Archive</button></a>
      </td>
      </tr>
    <tr>
      <td colspan="2" class="space"></td>
      </tr>
      <?php endforeach; ?>
    </table>
    <br>
    <!-- <a href="home.php">back</a> -->
</div>

</div><!-- inner wrapper -->

</div><!-- wrapper -->
<script src=" js/scripts.js"></script>
   </body>
</html>