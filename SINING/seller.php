<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];


$select = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
 if(mysqli_num_rows($select) > 0){
			      while($row = mysqli_fetch_assoc($select)){
                $seller_name     = $row['seller_name'];   
                $seller_username = $row['seller_username'];
                $seller_address  = $row['seller_address'];
                $seller_contact  = $row['seller_contact']; 
                $seller_email    = $row['seller_email'];
                $seller_profile  = $row['seller_profile']; 
                $seller_gcash    = $row['seller_gcash'];
            }
  }
  else {
    echo '<script>alert("There is no data found!!");</script>';
  }
$approval = mysqli_query($conn, "SELECT a.product_id, a.seller_id, a.product_name, a.product_price, a.product_quantity, b.artistName, b.artistLocation, a.product_status
                                    FROM `product_status` a
                                  LEFT JOIN `sining_artists` b ON a.buyer_id = b.artistId
                                        WHERE seller_id = '$user_id'");
?>

<?php
require 'condb.php';
error_reporting(E_ERROR | E_PARSE);
session_start();
$user_id = $_SESSION['user_id'];

$getSeller = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
$row1 = mysqli_fetch_assoc($getSeller);
$author_id = $row1['seller_id'];
$author_name = $row1['seller_name'];

$sql = "SELECT seller_id FROM sining_sellers WHERE artistId = $user_id";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
   $seller_id = $row["seller_id"];
}

if(isset($_POST["submit"])){
  $title= $_POST["title"];
  $genre= $_POST["genre"];
  $price= $_POST["price"];
  $tags= $_POST["tags"];

  #upload image#
  if($_FILES["image"]["error"] == 4){
    echo
    "<script> alert('Image Does Not Exist'); </script>"
    ;
  }
  else{
   //seller folder
   $folder_name = "seller_" . $seller_id;
   $folder_path = "seller_file/artworks/" . $folder_name;
   if (!file_exists($folder_path)) {
      mkdir($folder_path, 0777, true);
   }

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if ( !in_array($imageExtension, $validImageExtension) ){
      echo
      "
      <script>
        alert('Invalid Image Extension');
      </script>
      ";
    }
    else if($fileSize > 20000000){
      echo
      "
      <script>
        alert('Image Size Is Too Large');
      </script>
      ";
    }
    else{
      $newImageName = uniqid() . '.' . $imageExtension;
      $new_file_path = $folder_path . '/' . $newImageName;
      
      $select = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE artistId = '$user_id'");
      $row = mysqli_fetch_assoc($select);
      $seller_id = $row['seller_id'];
      $seller_name = $row['seller_name'];

      
      move_uploaded_file($tmpName, $new_file_path);
      #Insert data#
      $query = "INSERT INTO sining_approval (seller_id, artistName, artTitle, artImage, artPrice, artGenre, artTags, artYear, artRate, purchased)    VALUES ('$seller_id', '$seller_name', '$title', '$newImageName','$price','$genre', '$tags', '2023', '10', '1')";

      mysqli_query($conn, $query);
      echo
      "
      <script>
        alert('Successfully Added');
        document.location.href= 'data.php';
      </script>
      ";
    }
  }
  header('location: seller.php');
}
#upload image#

if(isset($_POST["blog"])){

$title = ($_POST["title"]);
$content = ($_POST["content"]);

if($_FILES["image"]["error"] == 4){
    echo
    "<script> alert('Image Does Not Exist'); </script>"
    ;
  }
  else{
   //seller folder
   $folder_name = "author_" . $author_id;
   $folder_path = "blogpost/blogs/" . $folder_name;
   if (!file_exists($folder_path)) {
      mkdir($folder_path, 0777, true);
   }

    $fileName = $_FILES["image"]["name"];
    $fileSize = $_FILES["image"]["size"];
    $tmpName = $_FILES["image"]["tmp_name"];

    $validImageExtension = ['jpg', 'jpeg', 'png'];
    $imageExtension = explode('.', $fileName);
    $imageExtension = strtolower(end($imageExtension));
    if ( !in_array($imageExtension, $validImageExtension) ){
    //   echo
    //   "
    // //   <script>
    // //     alert('Invalid Image Extension');
    // //   </script>
    //   ";
    }
    else if($fileSize > 20000000){
      echo
      "
      <script>
        alert('Image Size Is Too Large');
      </script>
      ";
    }
    else{
      $newImageName = uniqid() . '.' . $imageExtension;
      $new_file_path = $folder_path . '/' . $newImageName;
      
      move_uploaded_file($tmpName, $new_file_path);
      #Insert data#
      $query = "INSERT INTO blog_post (blog_id, author_id, author, Title, content, image) VALUES ('', '$author_id', '$author_name', '$title', '$content', '$newImageName')";

      mysqli_query($conn, $query);
    //   echo
    //   "
    //   <script>
    //     alert('Successfully Added');
    //     document.location.href= 'data.php';
    //   </script>
    //   ";
    }
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="assets/logo.ico" />
<link rel="stylesheet" href="css/admin.css">
<link rel="stylesheet" href="css/seller_profile.css">
<!-- <link rel="stylesheet" href="css/upload.css"> -->
<!-- Tags -->
<link rel="stylesheet" type="text/css" href="css/tagsInput.css" />
<script src="http://code.jquery.com/jquery-1.11.2.min.js" type="text/javascript"></script>  
<title>SINING | SELLER</title>
</head>
<body>

<div class="tab">
    <a href="home.php" class="seller-home"><img src="assets/img/return.png"></a>
<!-- <iframe src="seller_profile.php" frameborder="0" width="100%" height="fit-content"></iframe> -->


<div id="seller-profile-con">
  <img class="seller-profile" src="seller_file/profile/<?php echo $seller_profile; ?>"/>
  <h1><?php echo $seller_username;?></h1>
  <h3><?php echo $seller_name;?></h3>


    <button data-open-modal><img src="assets/img/upload.png"><span>Sell<span></button>
    <button data-open-modals><img src="assets/img/upload.png"><span>Post Blog<span></button>
    <dialog data-modal>
        <form action="" method="post" autocomplete="off" enctype="multipart/form-data">
            <table class="inner-tab">
              <tr>
                <th colspan="2">Upload Artwork</th>
              </tr>
            <tr>
                <td><label for="title">Title : </label></td>
                <td><input type="text" name="title" id = "title" required value=""></td>
            </tr>
            <tr>
                <td><label for="genre">genre : </label></td>
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
            <tr>
                <td><label for="image">Image : </label></td>
                <td>
                  <input type="file" name="image" id ="image" accept=".jpg, .jpeg, .png" value="">
            </td>
            <tr>
              <td></td>
              <td>
                <div id="imagePreviewContainer2">
                  <img id="imagePreview2" src="assets/img/image4.png" alt="Preview">
              </div>
              </td>
            </tr>
            </tr>
            <tr>
                <td><label for="tags">Tags: </label></td>
                <td><input name="tags" id="tags"/></td>
            </tr>
            <tr>
                <td colspan="2" ><button type="submit" name="submit" class="button">Submit</button>
                  </form>
                  <button class="cancel" onclick="cancelClose()" formmethod="dialog">Cancel</button>
                </td>
          </tr>
          </table>
        </form>
    </dialog>
    
    <dialog data-modals>

    <table id=blog-post>
      <tr>
        <th colspan="2"><h1>Write a Blog Post</h1></th>
      </tr>
      <tr>
        <td colspan="2">
          <form class="" action="" method="post" id="blogform" autocomplete="off" enctype="multipart/form-data">
          <label for="title">Title:</label>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="text" id="title" name="title" required>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label for="content">Content:</label>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <textarea id="content" name="content" rows="6" required></textarea>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label for="image">Upload Picture:</label>
        </td>
      </tr>
      <tr>
        <td colspan="2">
              <input type="file" name="image" id ="images" accept=".jpg, .jpeg, .png" value="" required/>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="imagePreviewContainer">
              <img id="imagePreview" src="assets/img/image4.png" alt="Preview">
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <button type="submit" name="blog" value="Submit">Submit</button>
        </td>
        <td>
        <button class="cancel" onclick="cancelClose()">Cancel</button>
        </form>
        </td>
      </tr>
    </table>
  </dialog>


</div>

  <button class="seller-btn tablinks active" onclick="openCity(event, 'dashboard')"><h4>Dashboard</h4><img src="assets/img/dashboard.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'approval-list')"><h4>To Be Approve</h4><img src="assets/img/approved.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'pending-payment')"><h4>Pending Payment</h4><img src="assets/img/package-box.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'to-ship')"><h4>To Ship</h4><img src="assets/img/package-box.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'to-receive')"><h4>To Receive</h4><img src="assets/img/delivery-van.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'completed')"><h4>Completed</h4><img src="assets/img/complete.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'cancelled')"><h4>Cancelled</h4><img src="assets/img/cancelled.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'sold-artworks')"><h4>Sold Artworks</h4><img src="assets/img/sold.png"></button>
  <button class="seller-btn tablinks" onclick="openCity(event, 'archived-artworks')"><h4>Archived Artworks</h4><img src="assets/img/sold.png"></button>

</div>

<div id="dashboard" style="display:block;" class="tabcontent">
    <iframe src="seller_dashboard.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="approval-list" class="tabcontent">
    <iframe src="seller_page.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="pending-payment" class="tabcontent">
    <iframe src="pending_payment.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="to-ship" class="tabcontent">
    <iframe src="toship.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="to-receive" class="tabcontent">
    <iframe src="toReceive.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="completed" class="tabcontent">
    <iframe src="completed.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="cancelled" class="tabcontent">
   <iframe src="cancelled.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="sold-artworks" class="tabcontent">
    <iframe src="sold_artwork.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="archived-artworks" class="tabcontent">
    <iframe src="archivearts.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

document.getElementById("images").addEventListener("change", function(event) {
    var input = event.target;
    var previewContainer = document.getElementById("imagePreviewContainer");
    var preview = document.getElementById("imagePreview");

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function() {
            preview.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
        previewContainer.style.display = "block";
    } else {
        preview.src = "assets/img/image4.png";
        previewContainer.style.display = "none";
    }
});

document.getElementById("image").addEventListener("change", function(event) {
    var input = event.target;
    var previewContainer = document.getElementById("imagePreviewContainer2");
    var preview = document.getElementById("imagePreview2");

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function() {
            preview.src = reader.result;
        };
        reader.readAsDataURL(input.files[0]);
        previewContainer.style.display = "block";
    } else {
        preview.src = "assets/img/image4.png";
        previewContainer.style.display = "none";
    }
});

function cancelClose(){
  window.location.href = "seller.php";
}
</script> 
<script>
    const openButton = document.querySelector("[data-open-modal]")
    const modal = document.querySelector("[data-modal]")

    const openButton1 = document.querySelector("[data-open-modals]")
    const modal1 = document.querySelector("[data-modals]")

    openButton.addEventListener("click", () => {
        modal.showModal()
    })
    openButton1.addEventListener("click", () => {
        modal1.showModal()
    })
</script>
<script src="js/tagsinput.js"></script>  
<script>
      $(document ).ready(function() {
        $('#tags').tagsInput();
      });
</script>
</body>
</html>