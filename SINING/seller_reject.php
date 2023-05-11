<?php
include 'condb.php';
$rejected = $_POST['id'];
$delete = mysqli_query($conn, "DELETE FROM sining_seller_approval WHERE id ='$rejected'");

 header ('location: adminSellerApproval.php');
?>