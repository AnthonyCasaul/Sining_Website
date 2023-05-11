<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$getsellerId = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row = mysqli_fetch_assoc($getsellerId);
$seller_id = $row['seller_id'];


$ToBeApproved = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'To be approved'");
$count1 = mysqli_num_rows($ToBeApproved);

$ToShip = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'To ship'");
$count2 = mysqli_num_rows($ToShip);

$ToReceive = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'To receive'");
$count3 = mysqli_num_rows($ToReceive);

$Completed = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'Completed'");
$count4 = mysqli_num_rows($Completed);

$Cancelled = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'Cancelled'");
$count5 = mysqli_num_rows($Cancelled);

$pickup = mysqli_query($conn, "SELECT * FROM product_status WHERE seller_id = '$seller_id' AND product_status = 'To be Approved' AND payment_method = 'Pick-up'");
$count6 = mysqli_num_rows($pickup);

$artworks = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE seller_id = '$seller_id' AND archive = 1 ORDER BY random ASC");

if(isset($_POST["sub"])){
  $title= $_POST["title"];
  $genre= $_POST["genre"];
  $price= $_POST["price"];
  $tags= $_POST["tags"];

$query = mysqli_query($conn, "UPDATE sining_artworks1 SET");
}

if(isset($_POST["arc"])){
  $artID = $_POST["artid"];

$query = mysqli_query($conn, "UPDATE sining_artworks1 SET archive = 0 WHERE artId = '$artID'");
$query1 = mysqli_query($conn, "UPDATE sining_artworks SET archive = 0 WHERE artId = '$artID'");

header("location: seller_dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/tagsInput.css" />
    <title>Document</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="header">
  <h1>SELLER PAGE</h1>
  <h3>DASHBOARD</h3>
</div>
    <div>
        <table>
          <thead>
            <tr>
                <th><p><?php echo $count1; ?></p><br>To Be Approved</th>
                <th><p><?php echo $count2; ?></p><br>To Ship</th>
                <th><p><?php echo $count3; ?></p><br>To Receive</th>
            </tr>
          </thead>
          <thead>
            <tr>
                <th><p><?php echo $count4; ?></p><br>Completed</th>
                <th><p><?php echo $count5; ?></p><br>Cancelled</th>
                <th><p><?php echo $count6; ?></p><br>For Pick-Up</th>
            </tr>
          </thead>
        </table>
    </div>
    <div class="header2">
        <h3>POSTED ARTWORKS</h3>
        <div class="rcrdPage">
        <table class="content-table">
          <thead>
            <tr>
              <th class="head">Image</th>
              <th class="head">Title</th>
              <th class="head">Price</th>
              <th class="head">Year</th>
              <th class="head">Archive</th>
              <th class="head">Edit</th>
            </tr>
          </thead> 
  <?php
      if(mysqli_num_rows($artworks) > 0){
        $count=0;
			    while($row = mysqli_fetch_assoc($artworks)){
                $artworkname = $row['artTitle'];
                $artistname = $row['artistName'];
                $artprice = $row['artPrice'];
                $artyear = $row['artYear'];
                $artimage = $row['artImage'];
                $sellerID = $row['seller_id'];
                $artId = $row['artId'];
           echo '
         <form action="" method="POST">
         <table class="posted-art-table">
         <tr>
         <td><img class="posted-art-img" src="seller_file/artworks/seller_'.$sellerID.'/'.$artimage.'" alt="My Image" onclick="showImage(this)"></td>
         <td>'.$artworkname.'</td>
         <td>₱'.$artprice.'</td>
         <td>'.$artyear.'</td>
         <td><input type="submit" name="arc" class="btn1" value="Archive"></td>
         </form>
         <td><a href="#divOne" id="edit-btn-'.$count.'"><img src="assets/img/edit-btn.png"></a></td>
         </tr>
         </table>
         
         ';       
         $count++;    
    ?>
<?php
   }    
  }
  else{
      echo "<div class='no_data' id='no_data'>No Data Found</div>";
  }
?>
    </div>
<div id="img-overlay"></div>
<div class="popup">
    <div class="close-btn"><h2>&times;</h2></div>
            <h1>Artwork Edit</h1>
            <form>
                <table>
                <td><label>Art Title</label></td>
                <td><input type="text" name="title"></td> 
                <tr>          
                <td><label>Genre</label></td>
                <td><select id="genre" name="genre">
                  <?php
                      $sql = "SELECT DISTINCT artGenre FROM sining_genre";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='".$row["artGenre"]."'>".$row["artGenre"]."</option>";
                        }
                      } else {
                      }              
                  ?>
                </select></td>
                </tr> 
                <tr>
                    <td><label for="price">Price: </label></td>
                    <td><input type="number" name="price" id = "price" required value=""></td>
                </tr>                               
            </table>
            <input type="submit" name="sub" value="Confirm">
            </form>
</div>

<script>
for (let i = 0; i < <?php echo mysqli_num_rows($artworks); ?>; i++) {
    document.querySelector("#edit-btn-" + i).addEventListener("click",function(){
        document.querySelector(".popup").classList.add("active");
    });
}


document.querySelector(".popup .close-btn").addEventListener("click",function(){
    document.querySelector(".popup").classList.remove("active");
});
</script>
<script>
 function showImage(img) {
  var overlay = document.getElementById("img-overlay");
  var modal = document.createElement("div");
  var modalImage = document.createElement("img");

  modalImage.src = img.src;
  modalImage.alt = img.alt;
  modalImage.style.maxWidth = "80%";
  modalImage.style.maxHeight = "80%";

  modal.id = "image-modal";
  modal.appendChild(modalImage);
  document.body.appendChild(modal);

  overlay.style.display = "block";
  modal.style.display = "block";
}

document.getElementById("img-overlay").addEventListener("click", function() {
  var overlay = document.getElementById("img-overlay");
  var modal = document.getElementById("image-modal");

  overlay.style.display = "none";
  modal.style.display = "none";
  modal.remove();
});

</script>
<script src="js/tagsinput.js"></script>  
<script>
      $(document ).ready(function() {
        $('#tags').tagsInput();
      });
</script>
</body>
</html>