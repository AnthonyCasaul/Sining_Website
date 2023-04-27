<?php
include 'condb.php';

$seller_id = $_POST['id'];

$approved = mysqli_query($conn, "SELECT * FROM sining_seller_approval WHERE seller_id ='$seller_id'");
 $row = $approved->fetch_assoc();
 $fullname = ucfirst(strtolower($row['seller_name']));
 $username = $row['seller_username'];
 $address= $row['seller_address'];
 $contact = $row['seller_contact'];
 $email = $row['seller_email'];
 $qr = $row['seller_gcash'];
 $user_id = $row['artistId'];

 $query = mysqli_query($conn, "INSERT INTO sining_sellers (artistId, seller_name, seller_username, seller_address,seller_contact,seller_email, seller_gcash) VALUES('$user_id', '$fullname', '$username', '$address', '$contact', '$email', '$qr')");

 $delete = mysqli_query($conn, "DELETE FROM sining_seller_approval WHERE seller_id ='$seller_id'");

 header ('location: adminSellerApproval.php');

 
?>