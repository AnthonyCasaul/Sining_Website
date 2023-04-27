<?php
error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = $_SESSION['artistid'];
$fetchart = $_SESSION['fetchartid'];
//$artid = $_SESSION['fetchartid'];

//sample 
$artid = 865;

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}



if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id ='". $_GET['archiveid']."' ");
   $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, artistId, price, image, quantity) VALUES('$product_name','$user_id' ,'$product_price', '$product_image', '$product_quantity')");

   header('location: cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Artwork</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/view_art.css">
   <?php
      include("navbar.php");
   ?>

</head>
<script type="text/javascript">
        $( document ).ready(function() {
                $.ajax({
                type: "GET",
                url: "KNN_ALGO/newpy.py",
                success: function(result){
                    let json_result = JSON.parse(result);
                    console.log(json_result.Recommended);
                    for(let i = 0; i < json_result.Recommended.length; i++) {

                        $( "#recommended_arts" ).append( "<td><img src=\""+ json_result.Recommended[i].image_url+"\"/></td>");
                        $( "#recommended_arts" ).append( "<td><b>"+json_result.Recommended[i].name+"</b></td>");
                    }
                }
            });
        });
    </script>

<body>

<nav class="row">
   <div class="col-sm-1">
         <a href="home.php"><i class="fas fa-arrow-left" style='font-size:20px'></i>Back</a>
      </div>
      <div class="col-sm-1">
      <?php
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      ?>
         <a href="cart.php" class="cart">Cart</a>
      </div>
</nav>



<section class="products">
   <div class="box-container">

      <?php
      
      //$select_products = mysqli_query($conn, "SELECT * FROM `sining_artworks` WHERE artid ='". $_GET['archiveid']."'");
      $select_products = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks 
      ON sining_artists.artistId = sining_artworks.artistId WHERE sining_artworks.artId = '$artid'") or die('query failed');  
      
      
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
      ?>

      <form action="?" method="post">
         <div class="container prodview">
            <div class="row">
               <div class="col-md-7">
               <img src="<?php echo $fetch_product['artImage']; ?>" alt="" >
               </div>
               <div class="col-md-5">
            <h3><?php echo $fetch_product['artTitle']; ?>

            <?php 
            $ID=$fetch_product['artId'];
            $artistid=$fetch_product['artistId'];
            $follow=$fetch_product['artistFollow'];

            if($ID!=$user_id){

               if ($ID==$artistid && $follow<=0)
                  {
                     echo "<a href='#'>FOLLOW</a>"; 
                  }
            }

            else {
               echo "User's profile";  
            }
            ?></h3>
            <?php echo $fetch_product['artistEmail']; ?>
            <a href="artistProfile.php"><h2><?php echo $fetch_product['artistName']; 
            $_SESSION["artistid"] = $fetch_product['artistId'];
            $_SESSION["artid"] = $fetch_product['artId'];
            //tags
            $split = explode(",", $fetch_product['artTags']);

            ?></h2></a>
            <hr>
            <div class="price">PH₱<?php echo $fetch_product['artPrice']; ?></div>
            <div class="genre"><?php echo $fetch_product['artGenre']; ?></div>
            <div class="tags"> 
               <?php 
               foreach($split as $tag)
                  {
               ?>
               <span class="badge badge-secondary" style="background-color: cadetblue;"><?php echo $tag; ?></span>
               <?php } ?>
            
            </div>

            <input type="hidden" name="product_name" value="<?php echo $fetch_product['artTitle']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['artPrice']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['artImage']; ?>">
            <input type="submit" class="btn" value="Add to cart" name="add_to_cart">
         </div></div></div>
            <br><br>
            <h4 class="other-works-header" style="text-align: center;"> Other works by <?php echo $fetch_product['artistName']; ?></h4>

            <!-- Other Artworks -->
            <div class="other-art-box">
<table class="other-works-table" cellspacing = 0 cellpadding = 10>

<?php
      $category= $_POST["artGenre"];
      $archive= $_GET['artId'];
      $fetch=$fetch_product['artistId'];
      $i = 1; 
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks 
      ON sining_artists.artistId = sining_artworks.artistid WHERE sining_artworks.artistid ='$fetch' 
      AND sining_artworks.artId <> '$artid' ");  
?>
      
      <tr >       
        <td class="art-category" style="font-size:3vw"><?php echo $category= $fetch_product["artCategory"];?> </td>
      </tr>
      <tr>
      <?php 
      $i=0;
      foreach ($rows as $i=>$row) : ?>
      <div class="row others">
      <!--Images -->
      <div class="col-md-2">
      <?php 

      $archive= $_GET['archiveid'];
      $match=$row["artId"];
      ?>
      </div>
      <!--Data -->
        <td>
        <?php 
        $archive= $_GET['archiveid'];
        ?> </td>
      </div>
      
      <td class="other-art-inner-box" ><img src="<?php echo $row["artImage"];?>" width = 100>
      <h3 style="margin-left:5px;">
         <?php echo $row["artTitle"]; ?>            
      </h3>
        <p style="margin-left:5px;">
        <?php 
        $price=$row["artPrice"];
        $formattedNum = number_format($price, 2);
        echo $formattedNum;
      if ($i > 3) break;?></p>
      </td><td style="width: 100px;"></td>
      

      
      <?php endforeach;?>
       <!-- <a href="">See more</a> -->
       </tr>
       </div>
    </table>
    <div id="recommended_arts"></div>
    </div>
    <br>
         </div>
      </form>

      <?php

         };
      };
      ?>


   </div>

</section>

</div>
<!-- custom js file link  -->
<script src="js/scripts.js"></script>
<style>
   header{
      background-color: #212529;
   }
</style>


</body>
</html>