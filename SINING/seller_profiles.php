<?php
include 'condb.php';

$getSeller = mysqli_query($conn, "SELECT * FROM getsellerid");
$row1 = mysqli_fetch_assoc($getSeller);
$seller_id = $row1['seller_id'];

$select = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE seller_id = '$seller_id'");
if(mysqli_num_rows($select) > 0){
			      while($row = mysqli_fetch_assoc($select)){
                    $seller_name = $row["seller_name"];
                    $seller_username = $row["seller_username"];
                    $seller_email = $row["seller_email"];
                    $seller_profile = $row["seller_profile"];
                  }
}
$select1 = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE seller_id = '$seller_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
	<link rel="stylesheet" href="css/seller_profiles.css">
    <title>Seller Profile</title>
</head>
<body>
<?php
	include("navbar.php");
?>
	<div class="wrapper">
    <div class="profile-con">
		<img class="seller-profile" src="seller_file/profile/<?php echo $seller_profile; ?>"/>
		<h1><?php echo $seller_username;?></h1>
		<h3><?php echo $seller_name;?></h3>
		<h3><?php echo $seller_email;?></h3>
	</div>
	<h2>POSTED ARTWORKS</h2>
	<div class="column">
    
    <?php
    if(mysqli_num_rows($select1) > 0){
			      while($row = mysqli_fetch_assoc($select1)){
                    $id = $row["artId"];
                    $artTitle = $row["artTitle"];
                    $artPrice = $row["artPrice"];
                    $artPrice = number_format($artPrice, 2);
                    $artGenre = $row["artGenre"];
                    $artTags = $row["artTags"];
                    $artYear = $row["artYear"];
                    $artImage = $row["artImage"];
                    $sellerID = $row["seller_id"];
                    $image = base64_encode(file_get_contents('seller_file/artworks/seller_'.$sellerID.'/'.$artImage));


                  echo '
				<div class=image-box>
				<button onclick="getId('.$id.')" class="img-btn">
					<img src="data:image/jpeg;base64,'.$image.'">
				</button><br><br>

				<p class="text art-title">'.$artTitle.'
				</p>
					<table>
						<tr>
							<td>Price</td>
							<td>PH₱ '.$artPrice .'</td>
						</tr>
						<tr>
							<td>Style</td>
							<td>'.$artGenre .'</td>
						</tr>	
                        <tr>
							<td>Year</td>
							<td>'.$artYear.'</td>
						</tr>
                        <tr>
							<td>Tags</td>
							<td>'.$artTags .'</td>
						</tr>
					</table>
				</div>
                  ';  

                  }
    }
    ?>
<script>
     function getId(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	    window.location.href = "view_art.php";
    }
});	

    }
</script>
</div>
</div>
<iframe src="footer.php" frameborder="0" width="100%"></iframe>
</body>
</html>