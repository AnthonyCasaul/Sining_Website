<?php
    include("../condb.php");
    $result = mysqli_query($conn, "SELECT * FROM `sining_artworks`") or die('query failed');
    $str = "";
    while($row = mysqli_fetch_array($result))
    {
        $temp = $row['artTags'];
        $str .= $temp.",";
    }

    $arr = explode(",",$str);
    $arr = array_unique($arr);
    $arr = array_filter($arr, fn($value) => !is_null($value) && $value !== '');
    foreach($arr as $tag){
        echo("<button style='height:50px;width:250px;font-size:25px;'>".$tag."</button>");
    }
?>
