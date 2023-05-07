<link rel="stylesheet" href="css/categ_select.css">

<?php session_start();
include 'condb.php';
$user_id = $_SESSION['user_id'];
$select = mysqli_query($conn, "SELECT * FROM `sining_artists` WHERE artistId = '$user_id'") or die('query failed');
   if(mysqli_num_rows($select) > 0){
      $row = mysqli_fetch_assoc($select);
      $catecheck = $row['isFirstTimeUser'];
      if($catecheck == 1 ){
         header('location:home.php');
      }
   }
   $sql = "SELECT DISTINCT artGenre FROM sining_artworks1";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      echo "<form method='post' action=''>";
      echo "<h2>What are you interested in?</h2><p>This will customize your new home feed</p>";
      while($row = $result->fetch_assoc()) {
         echo "<div class='container'><div><label><input type='checkbox' name='cate[]' value='".$row["artGenre"]."'><span>".$row["artGenre"]."</span></label></div></div>";
      }
      echo "<br><input type='submit' name='submit' value=''>";
      echo "</form>";
    } else {
      echo "No results found.";
    }
?> 
<?php
if(isset($_POST['submit']))  
{  
$checkbox1=$_POST['cate'];
// $checkbox=$_POST['tags'];
$chk="";
// $chktags="";
foreach($checkbox1 as $chk1)  
   {  
      $chk .= $chk1.",";  
   }
// foreach($checkbox as $chktags1)  
//    {  
//       $chktags .= $chktags1.",";  
//    } 
         $insert = mysqli_query($conn, "UPDATE sining_artists SET artistTarget = '$chk' WHERE artistId = '$user_id'") or die('query failed');
         //$insert1 = mysqli_query($conn, "UPDATE sining_artists SET artistSearch = '$chktags' WHERE artistId = '$user_id'") or die('query failed');
         $insert = mysqli_query($conn, "UPDATE sining_artists SET isFirstTimeUser = 1 WHERE artistId = '$user_id'") or die('query failed');
         header('location:home.php');
}

?>  
</body> 

</html>