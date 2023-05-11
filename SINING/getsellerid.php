<?php
include 'condb.php';

$seller_id = $_POST['seller_id'];
$select = mysqli_query($conn, "DELETE FROM `getsellerid`") or die('query failed');

$insert = mysqli_query($conn, "INSERT INTO `getsellerid`(seller_id) VALUES ('$seller_id')") or die('query failed');
?>