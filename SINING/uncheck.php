<?php
@include 'condb.php';

$id=$_POST['id'];
$query = mysqli_query($conn, "UPDATE cart SET ifChecked = 0 WHERE id='$id'");
echo $id;
?>