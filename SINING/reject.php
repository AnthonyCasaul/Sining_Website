<?php
include 'condb.php';
$rejected = $_POST['id'];
$delete = mysqli_query($conn, "DELETE FROM sining_approval WHERE id ='$rejected'");

 header ('location: adminArtApproval.php');
?>