<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$approval_id = $_POST['id'];

$approved = mysqli_query($conn, "SELECT a.*, b.seller_name FROM `sining_approval` AS a LEFT JOIN `sining_sellers` AS b ON a.seller_id = b.seller_id WHERE id ='$approval_id'");
 $row = $approved->fetch_assoc();
 $artTitle = ucfirst(strtolower($row['artTitle']));
 $artPrice = $row['artPrice'];
 $artGenre= $row['artGenre'];
 $artTags = $row['artTags'];
 $artImage = $row['artImage'];
 $seller_id = $row['seller_id'];
 $artistId = $user_id;
 $artistName = $row['seller_name'];
 $artYear = $row['artYear'];
 $artRate = $row['artRate'];
 $purchased = $row['purchased'];

 $random = mt_rand(1, 1000);

 $query = mysqli_query($conn, "INSERT INTO sining_artworks (artistId , seller_id, artistName, artTitle, artImage, artPrice, artGenre, artTags, artYear, artRate, purchased, random) VALUES ('$artistId', '$seller_id', '$artistName', '$artTitle', '$artImage','$artPrice','$artGenre','$artTags', '$artYear', '$artRate', '$purchased', '$random')");

 $query2 = mysqli_query($conn, "INSERT INTO sining_artworks1 (artistId , seller_id, artistName, artTitle, artImage, artPrice, artGenre, artTags, artYear, artRate, purchased, random) VALUES ('$artistId', '$seller_id', '$artistName', '$artTitle', '$artImage','$artPrice','$artGenre','$artTags', '$artYear', '$artRate', '$purchased', '$random')");

 $delete = mysqli_query($conn, "DELETE FROM sining_approval WHERE id ='$approval_id'");

header ('location: adminArtApproval.php');
?>