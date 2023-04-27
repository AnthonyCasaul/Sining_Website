<?php
include 'condb.php';

$id = $_POST['id'];
$select = mysqli_query($conn, "DELETE FROM `input`") or die('query failed');

$insert = mysqli_query($conn, "INSERT INTO `input`(artId) VALUES ('$id')") or die('query failed');
echo ($id);
?>