<?php
include('condb.php');

if(isset($_POST["action"]))
{
    $query = "SELECT * FROM sining_artworks1 WHERE purchased = '1'";
    if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
    {
        $query .= ("
		 AND artPrice BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		");
    }
    if(isset( $_POST["category"]))
	{
        $category_filter = implode("','", $_POST["category"]);
		$query .= ("
		 AND artGenre IN '$category_filter'
		");
	}
    
    $result = $conn->query($query);
    $total_row = mysqli_num_rows($result);
    $output = '';
    if($total_row > 0){
        while ($row = $result->fetch_object()) {
            $sam = $row->artImage;
			$url = $sam;
     		$image = base64_encode(file_get_contents('assets/img/sample_image.png'));
            $output .= '
            <div class="col-sm-4 col-lg-3 col-md-3">
                <div style="border:1px solid #ccc; border-radius:5px; padding:16px; margin-bottom:16px; height:320px;">
                    <img src="data:image/jpeg;base64,'. $image .'" alt="" class="img-responsive" >
                    <p align="center"><strong><a href="#">'. $row->artTitle .'</a></strong></p>
                    <h4 style="text-align:center;" class="text-danger" >'. $row->artPrice .'</h4>
                    <h2 style="text-align:center;" class="text-danger" >'. $row->artGenre .'</h2>
                </div>
            </div>';
        }
    }else{
        $output = '<h3>No Data Found</h3>';
    }
    echo $output;
}
?>