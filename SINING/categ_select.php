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
      while($row = $result->fetch_assoc()) {
        echo "<input type='checkbox' name='cate[]' value='" . $row["artGenre"] . "'>" . $row["artGenre"] . "<br>";
      }
      echo "<input type='submit' name='submit' value='Submit'>";
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
<style>
   body,
html {
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: #1d1d1d;

}

.container {
    max-width: 640px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    font-size: 13px;
}

ul.ks-cboxtags {
    list-style: none;
    padding: 20px;
}
ul.ks-cboxtags li{
  display: inline;
}
ul.ks-cboxtags li label{
    display: inline-block;
    background-color: rgba(255, 255, 255, .9);
    border: 2px solid rgba(139, 139, 139, .3);
    color: #adadad;
    border-radius: 25px;
    white-space: nowrap;
    margin: 3px 0px;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-tap-highlight-color: transparent;
    transition: all .2s;
}

ul.ks-cboxtags li label {
    padding: 8px 12px;
    cursor: pointer;
}

ul.ks-cboxtags li label::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    font-size: 12px;
    padding: 2px 6px 2px 2px;
    content: "\f067";
    transition: transform .3s ease-in-out;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label::before {
    content: "\f00c";
    transform: rotate(-360deg);
    transition: transform .3s ease-in-out;
}

ul.ks-cboxtags li input[type="checkbox"]:checked + label {
    border: 2px solid #1bdbf8;
    background-color: #12bbd4;
    color: #fff;
    transition: all .2s;
}

ul.ks-cboxtags li input[type="checkbox"] {
  display: absolute;
}
ul.ks-cboxtags li input[type="checkbox"] {
  position: absolute;
  opacity: 0;
}
ul.ks-cboxtags li input[type="checkbox"]:focus + label {
  border: 2px solid #e9a1ff;
}
input{
    border-style: none;
    background: #fff;
    border-radius: 50px;
    border: 2px solid lightgray;
    padding: 10px;
    width: 150px;
}
input:hover{
    cursor: pointer;

}
</style> 
</html>