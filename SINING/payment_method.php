<?php
// error_reporting(E_ERROR | E_PARSE);
include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];

$payment = $_POST['paymentMethod'];
$query = mysqli_query($conn, "UPDATE product_status SET payment_method = '$payment' WHERE buyer_id = '$user_id'");

?>
