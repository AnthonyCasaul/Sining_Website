<?php
include 'condb.php';

$getPost = mysqli_query($conn, "SELECT * FROM blog_post");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsfeed</title>
</head>
<body>
    <h1>NEWSFEED</h1>
<?php
    if(mysqli_num_rows($getPost) > 0){
			      while($row = mysqli_fetch_assoc($getPost)){
                    $blog_id = $row["blog_id"];
                    $author_id = $row["author_id"];
                    $author = $row['author'];
                    $title = $row['Title'];
                    $content = $row['content'];
                    $image = $row['image'];
                    $image1 = base64_encode(file_get_contents('blogpost/blogs/author_'.$author_id.'/'.$image));

                    $getsellerprofile = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE seller_id = '$author_id'");
                         while($row1 = mysqli_fetch_assoc($getsellerprofile)){
                            $seller_profile = $row1['seller_profile'];
                            $image2 = base64_encode(file_get_contents('seller_file/profile/'.$seller_profile));

                            echo '
				<div class=image-box>
                <img src="data:image/jpeg;base64,'.$image2.'" height="100" width="100">
                <h2 class="text art-title">'.$title.'</h2>
				<button onclick="getId('.$blog_id.')" class="img-btn">
					<img src="data:image/jpeg;base64,'.$image1.'" height="100" width="100">
				</button><br><br>
					<table>
						<tr>
							<td>Author: </td>
							<td>'.$author.'</td>
						</tr>
						<tr>
							<td>'.$content .'</td>
						</tr>	
					</table>
				</div>
                  ';
                         }  

                  }
    }
    ?>
<script>
     function getId(id){
        console.log(id);
// 		    $.ajax({
//             type: "POST",
//             url: "getid.php",
//             data: {"id": id},
//             success: function(result){
//     	    window.location.href = "view_art.php";
//     }
// });	

    }
</script>
</div>
</div>
<iframe src="footer.php" frameborder="0" width="100%"></iframe>
</body>
</html>