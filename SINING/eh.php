<?php
@include 'condb.php';

$id=$_POST['id'];
$query = mysqli_query($conn, "UPDATE cart SET ifChecked = 1 WHERE id='$id'");
?>