<?php
include 'condb.php';

$approval_id = $_POST['id'];

$approved = mysqli_query($conn, "SELECT * FROM sining_approval WHERE id ='$approval_id'");
 $row = $approved->fetch_assoc();
 $artTitle = ucfirst(strtolower($row['artTitle']));
 $artPrice = $row['artPrice'];
 $artGenre= $row['artGenre'];
 $artTags = $row['artTags'];
 $artImage = $row['artImage'];
 $artistId = $row['artistId'];

 $query = mysqli_query($conn, "INSERT INTO sining_artworks1 (artistId ,artTitle, artImage, artPrice, artGenre, artTags) VALUES('$artistId','$artTitle', '$artImage','$artPrice','$artGenre','$artTags')");

 $delete = mysqli_query($conn, "DELETE FROM sining_approval WHERE id ='$approval_id'");

 header ('location: adminPage.php');
?>