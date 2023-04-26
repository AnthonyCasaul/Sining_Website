<?php
    include "condb.php";
    session_start();
    $user_id = $_SESSION['user_id'];

    // echo $user_id;
    
    $sql = "SELECT * FROM sining_seller_approval WHERE artistId = '$user_id'";
    $result = mysqli_query($conn, $sql);

    $sql1 = "SELECT * FROM sining_sellers WHERE artistId = '$user_id'";
    $result1 = mysqli_query($conn, $sql1);

    if(mysqli_num_rows($result) > 0) {
        // The user ID exists needs to be approved
        echo '<script>
            alert("Your Application in being approved");
            window.location.href = "home.php";
        </script>';
        //header('location: home.php');
    }

    else if(mysqli_num_rows($result1) > 0){
        // The user ID can sell
        header('location: seller.php');
    }
    
    else {
        // The user ID can apply to be a seller
        header('location: sellerform.php');
    }

?>