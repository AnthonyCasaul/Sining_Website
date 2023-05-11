<?php
// Start the session
session_start();
include ("condb.php");
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: index.php");
  exit();
}

// Connect to the database
//$db = new mysqli('localhost', 'username', 'password', 'database_name');

// Query the database for the user's information
$user_id = $_SESSION['user_id'];
$user_query = "SELECT * FROM sining_artists WHERE artistId = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Get the updated profile picture and name from the form
  $name = $_POST['name'];
  $contact = $_POST['contact'];
  $loc = $_POST['loc'];
  $pass = $_POST['pass'];
  $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'img/'.$image;

   if($image_size > 20000000){
       $message[] = 'image size is too large!';
    }
    else{
        $update_query = "UPDATE sining_artists SET artistProfile = '$image', artistName = '$name', artistContact = '$contact', artistLocation = '$loc', artistPassword = '$pass' WHERE artistId = $user_id";
        mysqli_query($conn, $update_query);
       if($update_query){
          move_uploaded_file($image_tmp_name, $image_folder);
          $message[] = 'registered successfully!';
       }else{
          $message[] = 'registration failed!';
       }
    }
  // Update the user's information in the database
  //$update_query = "UPDATE sining_artists SET artistProfile = '$image', artistName = '$name', artistContact = '$contact', artistLocation = '$loc', artistPassword = '$pass' WHERE artistId = $user_id";
  //mysqli_query($conn, $update_query);

  // Redirect the user back to the profile page
  header("Location: manageprofile.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
  <link rel="stylesheet" href="manageprofile.css">
  <title>Sining | Profile</title>
</head>
<body>
<?php
    include("navbar.php");
?>

<!-- Display the user's profile information -->
<table>
  <tr>
    <td colspan="2">
      <img src="img/<?php echo $user['artistProfile'];?>" alt="Profile Picture">
    </td>
  </tr>
  <tr>
    <td colspan="2">
      <h1><?php echo $user['artistName']; ?></h1>
    </td>
  </tr>
  <tr>
    <td>
      <form action="manageprofile.php" method="post" enctype="multipart/form-data">
      <label for="image">Profile Picture:</label>
    </td>
    <td>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png">
    </td>
  </tr>
  <tr>
    <td><label for="name">Name:</label></td>
    <td><input type="text" name="name" value="<?php echo $user['artistName']; ?>"></td>
  </tr>
  <tr>
    <td><label for="contact">Contact:</label></td>
    <td><input type="text" name="contact" value="<?php echo $user['artistContact']; ?>"></td>
  </tr>
  <tr>
    <td><label for="loc">Location:</label></td>
    <td><input type="text" name="loc" value="<?php echo $user['artistLocation']; ?>"></td>
  </tr>
  <tr>
    <td><label for="pass">Password:</label></td>
    <td><input type="password" name="pass" value="<?php echo $user['artistPassword']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2">
    <input type="submit" name="submit" value="Update">
    </form>
    </td>
  </tr>
</table>

<?php mysqli_close($conn); ?>

</body>
</html>