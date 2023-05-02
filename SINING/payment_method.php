<?php
@include 'condb.php';
session_start();

$id=$_SESSION['id'];
$payment = $_POST['paymentMethod'];

$query = mysqli_query($conn, "UPDATE cart SET payment_method = '$payment' WHERE id='$id'");
?>
