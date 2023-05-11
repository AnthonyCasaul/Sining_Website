<?php
include 'condb.php';

$approve = $_POST['approve'];
$ship = $_POST['ship'];
$decline = $_POST['decline'];
$orderReceive = $_POST['orderReceive'];

if(isset($_POST['approve'])){
    $approved = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'To pay' WHERE product_id = '$approve'");
}
if(isset($_POST['ship'])){
    $ship = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'To receive' WHERE product_id = '$ship'");
}
if(isset($_POST['decline'])){
    $ship = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'Cancelled' WHERE product_id = '$decline'");
}
if(isset($_POST['orderReceive'])){
    $ship = mysqli_query($conn, "UPDATE `product_status` SET product_status = 'Completed' WHERE product_id = '$orderReceive'");
}

?>