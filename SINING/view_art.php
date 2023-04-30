<?php
//error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$art = mysqli_query($conn, "SELECT * FROM input");
$row_art=mysqli_fetch_assoc($art);
$artid = $row_art['artId'];

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
   <title>Artwork</title>
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- <script src="sweetalert2.min.js"></script> -->
<link rel="stylesheet" href="sweetalert2.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/view_art.css">
   <?php
      include("navbar.php");
   ?>

</head>
<script type="text/javascript">
   var htmlstring = "";
        $( document ).ready(function() {
                $.ajax({
                type: "GET",
                url: "KNN_ALGO/newpy.py",
                success: function(result){
                    let json_result = JSON.parse(result);
                    console.log(json_result.Recommended);
                    htmlstring+="<table class='recommended-art-table'><tr>";
                    for(let i = 1; i < json_result.Recommended.length; i++) {
                     let PHpeso = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'PHP',
                     }); 

                         htmlstring+="<td class='recommended-art-inner-box' style='margin-left: 100px;'><img src=\""+ json_result.Recommended[i].image_url+"\" onclick='getReco("+json_result.Recommended[i].id+")'/><br><h5>"+json_result.Recommended[i].name+"</h5><p>"+PHpeso.format(json_result.Recommended[i].price)+"</p></td></tr>";

                    }
                    $("#recommended_arts").append(htmlstring);
                    htmlstring+="</table>";
                }
            });
        });
    </script>

<body>

<nav class="row">
   
</nav>



<section class="products">
   <div class="box-container">

      <?php
      
      //$select_products = mysqli_query($conn, "SELECT * FROM `sining_artworks` WHERE artid ='". $_GET['archiveid']."'");
      $select_products = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks1 
      ON sining_artists.artistId = sining_artworks1.artistId WHERE sining_artworks1.artId = '$artid'") or die('query failed');  
      
      
      if(mysqli_num_rows($select_products) > 0){
         while($fetch_product = mysqli_fetch_assoc($select_products)){
            $ID = $fetch_product['artId'];
            $Title = $fetch_product['artTitle'];
            $artistid = $fetch_product['artistId'];
            $follow = $fetch_product['artistFollow'];
            $image = $fetch_product['artImage'];
            $email = $fetch_product['artistEmail'];
            $artist = $fetch_product['artistName'];
            $price = $fetch_product['artPrice'];
            $genres = $fetch_product['artGenre'];
           $tags = $fetch_product['artTags'];
         }
      }
      ?>
      <form action="?" method="post">
         <div class="container prodview">
            <div class="row">
               <div class="col-md-7">
               <img src="<?php echo $image; ?>" alt="" >
               </div>
               <div class="col-md-5">
            <h3><?php echo $Title; ?></h3>
            <?php echo $email; ?>
            <a href="artistProfile.php"><h2><?php echo $artist;?></h2></a>
            <hr>

            <div class="price">PH₱ <?php echo number_format($price, 2);; ?></div>
            <div class="genre"><?php echo $genres; ?></div>
            <div class="tags"><?php echo $tags;?></div>

            <input type="hidden" id="product_id" name="product_id" value="<?php echo $ID; ?>">
            <button onclick="addTocart()" class="cart_btn">ADD TO CART</button>
            <button onclick="buyNow()" class="cart_btn">BUY NOW</button>
         </div></div></div>
            <br><br>
            <h4 class="other-works-header" style="text-align: center;"> Other works by <?php echo $artist; ?></h4>

            <!-- Other Artworks -->
            <div class="other-art-box">
<table class="other-works-table" cellspacing = 0 cellpadding = 10>

<?php
      $i = 1; 
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks1 
      ON sining_artists.artistId = sining_artworks1.artistid WHERE sining_artworks1.artistid ='$artistid' 
      AND sining_artworks1.artId <> '$artid' ");  
?>
      <tr>
      <?php 
      $i=0;
      foreach ($rows as $i=>$row) : ?>
      <div class="row others">
      <!--Images -->
      <div class="col-md-2">
      <?php 
      $match=$row["artId"];
      $prices = $row["artPrice"];
      ?>
      </div>
      </div>

      <td class="other-art-inner-box" ><img src="<?php echo $row["artImage"];?>" onclick = "getArt(<?php echo $row['artId']; ?>)">
      <h5>
         <?php echo $row["artTitle"]; ?>            
      </h5>
        <p>
        <?php 
        $formattedNum = number_format($prices, 2);
        echo "PH₱ ".$formattedNum;
      if ($i > 3) break;?></p>
      </td><td style="width: 100px;"></td>
   
      <?php endforeach;?>
       <!-- <a href="">See more</a> -->
       </tr>
       </div>
    </table>
    <br><br>
    <h4 class="other-works-header" style="text-align: center;">Recommended Artworks</h4>
    <br>
    
    </div>
    <br>
         </div>
      </form>
   <table id="recommended_arts"></table>

   </div>

</section>

</div>
<!-- custom js file link  -->
<script src="js/scripts.js"></script>
<script>
   function addTocart() {
       const productId = $('#product_id').val();
       console.log(productId);

       $.ajax({
    type: "POST",
    url: "add_Tocart.php",
    data: {"product_id": productId},
    success: function(result){
    Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Added to Cart',
  showConfirmButton: false,
  timer: 1500
})
    }
});	

   }
   function buyNow() {
       const productId = $('#product_id').val();
       console.log(productId);
       $.ajax({
    type: "POST",
    url: "add_Tocart.php",
    data: {"product_id": productId},
    success: function(result){
    console.log(result);
    window.location.href = "view_art.php";
    }
});	

   }
   function getArt(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	   //   Swal.fire({title: 'Error!', text: 'Do you want to continue', icon: 'error', confirmButtonText: 'Cool'
         //            })
              window.location.href = "view_art.php";
    }
});	

    }
    function getReco(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	   //   Swal.fire({title: 'Error!', text: 'Do you want to continue', icon: 'error', confirmButtonText: 'Cool'
         //            })
              window.location.href = "view_art.php";
    }
});	

    }
</script>

</body>
</html>