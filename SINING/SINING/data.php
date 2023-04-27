<?php

include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
//start
error_reporting(E_ERROR | E_PARSE);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Data</title>
  </head>
  <body>
    <table cellspacing = 0 cellpadding = 10>

    <td style="font-size:5vw"> Artworks</td>
    <!--search-->

    <form class="" action="" method="post" autocomplete="off" enctype="multipart/form-data">
      <label for="title">Title : </label>
      <input type="text" name="title" id = "title" required value="">
      <button type = "submit" name = "submit">Submit</button>
    </form>
<?php
      $title= $_POST["title"];
      $i = 1;
      if(isset($_POST['submit'])){
      //$rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.id = sining_artworks.artistid WHERE sining_artworks.artistid='$user_id' ORDER BY sining_artworks.title ASC");  
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.artistId = sining_artworks.artistid WHERE sining_artworks.artistid='$user_id' AND artTitle='$title' ORDER BY sining_artworks.artTitle DESC");  
      }
      
?>

      <tr >
        <td style="font-size:3vw"><?php echo $title= $_POST["title"];?> </td>
      </tr>
      <?php foreach ($rows as $row) : ?>
      <tr>
        
      <td><?php echo $row["artCategory"]; ?></td>
        <td> <img src="uploaded_img/<?php echo $row["artImage"]; ?>" width = 200> </td>
        <td><?php echo $row["artTitle"]; ?></td>
        <td><?php echo $row["artistLocation"]; ?></td>
        <td><?php 
        $price=$row["artPrice"];
        $formattedNum = number_format($price, 2);
        
        
        echo $formattedNum;
        ?></td>
<!-- START UPDATE-->
<td>
   <button>
<a href="update_artworks.php? updateid=<?php echo $row["artId"]; ?>">Edit</a></button>
              
      </td>
        
         <!-- END UPDATE-->
      <td>
      <button> <a href="archive_artworks.php? archiveid=<?php echo $row["artId"]; ?>">Archive</a></button>
      </td>
      </tr>



      <?php endforeach; ?>
    </table>

    <table cellspacing = 0 cellpadding = 10>
    <td style="font-size:5vw"> Artworks</td>

<?php
      $title= $_POST["title"];
      $i = 1;
     
      $rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.artistId = sining_artworks.artistid WHERE sining_artworks.artistid='$user_id' ORDER BY sining_artworks.artTitle ASC");  
      //$rows = mysqli_query($conn, "SELECT * FROM sining_artists INNER JOIN sining_artworks ON sining_artists.id = sining_artworks.artistid WHERE sining_artworks.artistid='$user_id' AND title='$title' ORDER BY sining_artworks.title DESC");  
      
      
?>

      <tr >
        <td style="font-size:3vw"><?php echo $title= $_POST["title"];?> </td>
      </tr>
      <?php foreach ($rows as $row) : ?>
      <tr>
        
      <td><?php echo $row["artCategory"]; ?></td>
        <td> <img src="uploaded_img/<?php echo $row["artImage"]; ?>" width = 200> </td>
        <td><?php echo $row["artTitle"]; ?></td>
        <td><?php echo $row["artistLocation"]; ?></td>
        <td><?php 
        $price=$row["artPrice"];
        $formattedNum = number_format($price, 2);
        
        
        echo $formattedNum;
        ?></td>
<!-- START UPDATE-->
<td>
   <button>
<a href="update_artworks.php? updateid=<?php echo $row["artId"]; ?>">Edit</a></button>
              
      </td>
        
         <!-- END UPDATE-->
      <td>
      <button> <a href="archive_artworks.php? archiveid=<?php echo $row["artId"]; ?>">Archive</a></button>
      </td>
      </tr>



      <?php endforeach; ?>
      </table>
    <br>
    <a href="sellerprofile.php">back</a>



</body>
</html>