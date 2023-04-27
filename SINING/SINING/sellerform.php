<?php
// Initialize variables
session_start();
$user_id = $_SESSION['user_id'];

$fullname = "";
$username = "";
$address = "";
$contact = "";
$email = "";
$profile = "";
$qr = "";
$success = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $fullname = test_input($_POST["fullname"]);
  $username = test_input($_POST["username"]);
  $address = test_input($_POST["address"]);
  $contact = test_input($_POST["contact"]);
  $email = test_input($_POST["email"]);
  $profile = $_FILES["profile"];
  $qr = $_FILES["qr"];


  //profile
  if ($profile["error"] > 0) {
    echo "Error uploading file: " . $profile["error"];
  } else {
    $new_name_profile = $username . ".jpg";
    $target_dir = "seller_file/profile/";
    $target_file = $target_dir . basename($profile["name"]);

    if (move_uploaded_file($profile["tmp_name"], $target_dir . $new_name_profile)) {
      echo "File uploaded and renamed successfully.";
    } else {
      echo "Error uploading file.";
    }
  }


  //qr
  if ($qr["error"] > 0) {
    echo "Error uploading file: " . $qr["error"];
  } else {
    $new_name = $username . ".jpg";
    $target_dir = "seller_file/gcash_qr/";
    $target_file = $target_dir . basename($qr["name"]);

    if (move_uploaded_file($qr["tmp_name"], $target_dir . $new_name)) {
      echo "File uploaded and renamed successfully.";
    } else {
      echo "Error uploading file.";
    }
  }

  // Validate form data
  if (!empty($user_id) && !empty($fullname) && !empty($username) && !empty($address) && !empty($contact) && !empty($email) && !empty($profile) && !empty($qr)) {
    // Connect to the database
    include "condb.php";

    // Insert data into database
    $sql = "INSERT INTO sining_seller_approval (artistId, seller_name, seller_username, seller_address, seller_contact, seller_email, seller_profile, seller_gcash) VALUES ('$user_id', '$fullname', '$username', '$address', '$contact', '$email', '$new_name_profile', '$new_name')";

    if (mysqli_query($conn, $sql)) {
      $success = "Data inserted successfully";
      $user_id = "";
      $fullname = "";
      $username = "";
      $address = "";
      $contact = "";
      $email = "";
      $profile = "";
      $qr = "";
    } else {
      $success = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
  } else {
    $success = "Please fill in all fields";
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>SINING | SELLER FORM</title>
  <link rel="stylesheet" href="css/sellerform.css">
  <?php
      include("navbar.php");
  ?>
</head>
<body>
  <?php if (!empty($success)) { echo $success; } ?>
  <div class="seller-con">
    <table>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
    
  <tr>
    <td><label for="fullname">Fullname:</label></td>
    <td><input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" required></td>
  </tr>
  <tr>
    <td><label for="username">Username:</label></td>
    <td><input type="text" name="username" id="username" value="<?php echo $username; ?>" required></td>
    </tr>
    <tr>
    <td><label for="address">Address:</label></td>
    <td><input type="text" name="address" id="address" value="<?php echo $address; ?>" required></td>
    </tr>
    <tr>
    <td><label for="contact">Contact:</label></td>
    <td><input type="text" name="contact" id="contact" value="<?php echo $contact; ?>" required></td>
    </tr>
    <tr>
    <td><label for="email">Email:</label></td>
    <td><input type="email" name="email" id="email" value="<?php echo $email; ?>" required></td>
    </tr>
    <tr>
    <td><label for="profile">Profile:</label></td>
    <td><input type="file" name="profile" id="profile" required></td>
    </tr>
    <tr>
    <td><label for="qr">Gcash:</label></td>
    <td><input type="file" name="qr" id="qr" required></td>
    </tr>
    <tr>
    <td colspan="2"><button type="submit">Submit</button></td>
    </tr></form></table>
  </div>
  <style>
   header{
      background-color: #212529;
   }
</style>
</body>
</html>