<?php
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'];

$select = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE artId = '$product_id'");
$row = mysqli_fetch_assoc($select);
$product_id = $row['artId'];
$product_name = $row['artTitle'];
$product_price = $row['artPrice'];
$product_image = $row['artImage'];

$product_quantity = 1;

$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id ='". $_GET['archiveid']."' ");

$insert_product = mysqli_query($conn, "INSERT INTO `cart`( artId, name, artistId, price, image, quantity) VALUES('$product_id','$product_name','$user_id' ,'$product_price', '$product_image', '$product_quantity')");
?>