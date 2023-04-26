<?php
include 'condb.php';

$user = $_POST['id'];
$select = mysqli_query($conn, "SELECT * FROM sining_artists WHERE artistId = '$user'");
$row = mysqli_fetch_assoc($select);
$user_name = $row['artistName'];

if(isset($_POST['activate'])){
$update = mysqli_query($conn, "UPDATE sining_artists SET isActivated = 1 WHERE artistId = '$user'");
echo '<script>alert("User '.$user_name.' is Activated");</script>';
header ('location: user_list.php');
}
if(isset($_POST['deactivate'])){
$update = mysqli_query($conn, "UPDATE sining_artists SET isActivated = 0 WHERE artistId = '$user'");
echo '<script>alert("User '.$user_name.' is Deactivated");</script>';
header ('location: user_list.php');
}
?>