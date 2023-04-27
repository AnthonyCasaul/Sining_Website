<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "jcra-sining";
    $artTitle = $_POST['artTitle'];
    
    $conn = new Mysqli($server, $user, $pass, $database);
    
    $result = "SELECT * FROM input";
        if ($rows = mysqli_query($conn,$result)) {
            $row = mysqli_num_rows($rows);
                    
            if ($total != 0) {
                $sql = "DELETE FROM input;";
                if (mysqli_query($conn,$sql)) {
                    # code...
                }
            }
        }


    //Creating an sql query
    $sql = "INSERT INTO input (artTitle) VALUES ('$artTitle')";
    
    //Executing query to database
    if(mysqli_query($conn,$sql)){
        header("Location: newpy.py");
    }else{
        echo("Error");
    }
 
 //Closing the data
    
    if (!$conn) {
        die("<script>alert('Connection Failed.')</script>");
    }
    
?>