<?php
include 'condb.php';

$artwork_id = $_POST['artworkId'];

$viewart = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE artid = '$artwork_id'");
    
if(mysqli_num_rows($viewart) > 0){
	
    while($row = mysqli_fetch_assoc($viewart)){
                $artwork_id = $row['artId'];
                $artwork_image = $row['artImage'];
                $artwork_artist = $row['artistName'];
                $artwork_title = $row['artTitle'];
                $artwork_price= $row['artPrice'];
                $artwork_genre = $row['artGenre'];
                $artwork_tag = $row['artTags'];
                $artwork_year = $row['artYear'];
            }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/admin-artwork-list.css">
    <title>Artwork</title>
</head>
<body>
    <a href="artwork_list.php"><button><img src="assets/img/return.png"></button></a><br>
    
    <table>
        <tr>
            <td class="artwork-img" colspan="2" style="border-radius: 10px; padding-left: 20px;"><img src="<?php echo $artwork_image; ?>"/></td>
        </tr>
        <tr>
            <td>Title</td>
            <td><?php echo $artwork_title; ?></td>
        </tr>
        <tr>
            <td>By</td>
            <td><?php echo $artwork_artist; ?></td>
        </tr>
        <tr>
            <td>Price</td>
            <td><?php echo $artwork_price; ?></td>
        </tr>
        <tr>
            <td>Year</td>
            <td><?php echo $artwork_year; ?></td>
        </tr>
        <tr>
            <td>Genre</td>
            <td><?php echo $artwork_genre; ?></td>
        </tr>
        <tr>
            <td>Tags</td>
            <td><?php echo $artwork_tag; ?></td>
        </tr>
    </table>
</body>
</html>




