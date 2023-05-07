<?php
@include 'condb.php';

$id=$_POST['product_id'];
$query = mysqli_query($conn, "UPDATE product_status SET product_status = 'To ship' WHERE id='$id'");
echo $id;
?>