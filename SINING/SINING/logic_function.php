<?php

$function = $_POST["function"];
$function();
function checkout()
{
    $input = $_POST;
    @include "condb.php";
    $id = $input["id"];
    $gcash_ref = $input["gcash_ref"];

    $update_gcash = $_FILES['gcash']['name'];
    $update_gcash_size = $_FILES['gcash']['size'];
    $update_gcash_tmp_name = $_FILES['gcash']['tmp_name'];
    //$update_gcash_folder = 'uploaded_img/'.$update_gcash;

    if(!empty($update_gcash)){
        if($update_gcash_size > 2000000){
           $message[] = 'image is too large';
        }else{
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE artistId='".$input["id"]."'");
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                $artistId = $fetch_cart["artistId"];
                $name = $fetch_cart["name"];
                $price = $fetch_cart["price"];
                $image = $fetch_cart["image"];
                $quantity = $fetch_cart["quantity"];
                mysqli_query($conn, "insert into artist_history values( null, $artistId, '$name', $price, '$image', $quantity, '$update_gcash', $id, 0, ".time().", '', '$gcash_ref')");
            
                move_uploaded_file($update_gcash_tmp_name, 'uploaded_img/' . $update_gcash);
            }
           mysqli_query($conn, "delete FROM `cart` WHERE artistId='".$input["id"]."'");
           
           /*if($image_update_query){
              //move_uploaded_file($update_gcash_tmp_name, $update_gcash_folder);
              move_uploaded_file($update_gcash_tmp_name, 'uploaded_img/' . $update_gcash);
           }*/
           $message[] = 'image updated successfully!';
        }
     }
}

function cancel()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $message = $_POST["message"];

    mysqli_query($conn, "update artist_history set cancel_message = '$message', status = -1 where id = $id");
    echo "Success";
}

function cancelSeller()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $message = $_POST["message"];

    mysqli_query($conn, "update artist_history set cancel_message = '$message', status = -2 where id = $id");
    echo "Success";
}
function updateStatus()
{
    $input = $_POST;
    @include "condb.php";
    $id = $_POST["id"];
    $status = $_POST["status"];

    
    mysqli_query($conn, "update artist_history set status = $status where id = $id");
    echo "Success";
}