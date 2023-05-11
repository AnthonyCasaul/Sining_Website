<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<style>
	.image-box img{
		width: 100%;
		height: auto;
	}
	.image-box .text-danger{
		color: #000;
	}
	.image-box a{
		text-decoration: none;
		font-size: larger;
	}
	h4{
		color: #000;
	}
</style>
<div class="img-con">
<link rel="stylesheet" href="home.css">
<?php
include('condb.php');

if(isset($_POST["action"]))
{
    $query = "SELECT * FROM sining_artworks1 WHERE 1+1";

if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
{
    $query .= " AND artPrice BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'";
}

if(isset($_POST["category"]) && !empty($_POST["category"]))
{
    $category_filter = implode("','", $_POST["category"]);
    $query .= " AND artGenre IN ('$category_filter')";
}
if(isset($_POST["artYear"]) && !empty($_POST["artYear"]))
{
    $category_year = implode("','", $_POST["artYear"]);
    $query .= " AND artYear IN ('$category_year')";
}
if(isset($_POST["artistName"]) && !empty($_POST["artistName"]))
{
    $category_artist = implode("','", $_POST["artistName"]);
    $query .= " AND artistName IN ('$category_artist')";
}
$query .= " ORDER BY random ASC";
    
    $result = $conn->query($query);
    $total_row = mysqli_num_rows($result);
    $output = '';
    if($total_row > 0){
        while ($row = $result->fetch_object()) {
        //     $sam = $row->artImage;
		// 	$url = $sam;
     	// 	$image = base64_encode(file_get_contents('assets/img/sample_image.png'));
             $id = $row->artId;
             $seller = $row->seller_id;	
             $img = $row->artImage;
             $image = base64_encode(file_get_contents('seller_file/artworks/seller_'.$seller.'/'.$img));

            $output .= '
            <div class="img-con-inner col-sm-4 col-lg-3 col-md-3">
                <div class=image-box style="
                    border:none; 
                    border-radius:5px; 
                    padding:20px; 
                    margin-bottom:16px;
                    width: 300px;
                    position: relative;
                    left: 50%;
                    transform: translateX(-50%);
                ">
                <button onclick="getId('.$id.')" class="img-btn">
                    <img src="data:image/jpeg;base64,'.$image.'" alt="" class="img-responsive">
                </button><br><br>

                    <p class="text art-title" align="center">'. $row->artTitle .'</p>
                    <div class="text-box">
                    <table>
                        <tr>
                            <td class="there">Artist</td>
							<td class="here">'.$row->artistName .'</td>
                        </tr>
                        <tr>
                            <td class="there">Price</td>
							<td class="here">'.$row->artPrice .'</td>
                        </tr>
                        <tr>
                            <td class="there">Genre</td>
							<td class="here">'.$row->artGenre .'</td>
                        </tr>
                    </table>
                    </div>
                </div>
            </div>';
        }
    }else{
        $output = '<h3>No Data Found</h3>';
    }
    echo $output;
}
?>
</div>
<script>
    function getId(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	    window.location.href = "view_art.php";
    }
});	

    }
</script>