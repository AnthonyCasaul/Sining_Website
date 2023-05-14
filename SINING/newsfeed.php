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
    <link rel="stylesheet" href="css/newsfeed.css">
    <link rel="stylesheet" href="home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
    <title>Newsfeed</title>
</head>
<body>
<!-- <iframe src="https://gifer.com/embed/yB" width=480 height=283.200 frameBorder="0" allowFullScreen></iframe><p><a href="https://gifer.com"></a></p>
    <iframe src="https://gifer.com/embed/xw" width=480 height=480.000 frameBorder="0" allowFullScreen></iframe><p><a href="https://gifer.com"></a></p> -->
    <?php
        include("navbar.php");
    ?>
    <div class="wrapper">
    <h1 id="header">NEWSFEED</h1>
    <section class="bg-image" id="new-bg-image"></section>
    
<?php
$date = time();
    if(mysqli_num_rows($getPost) > 0){
			      while($row = mysqli_fetch_assoc($getPost)){
                    $blog_id = $row["blog_id"];
                    $author_id = $row["author_id"];
                    $author = $row['author'];
                    $title = $row['Title'];
                    $content = $row['content'];
                    $image = $row['image'];
                    $post_time = $row['postAtime'];
					$post_date = $row['postAdate'];
                    $curr_time = time();
					$real_time = $curr_time - $post_time;
					$real_min = $real_time / 60;
					if($real_min < 1){
						$time_string = $real_time." seconds ago";
					}else if($real_min >= 1 && $real_min < 60){
						$time_string = round($real_min)." minutes ago";
					}else if($real_min >= 60 && $real_min < 1440){
						$hrs = $real_min / 60;
						if(round($hrs == 1)){
							$time_string = round($hrs)." hour ago";
						}else{
							$time_string = round($hrs)." hours ago";	
						}
					}else if($real_min >=1440 && $real_min < 4320){
						$days = $real_min / 1440;
						if(round($days == 1)){	
							$time_string = round($days)." day ago";
						}else{
							$time_string = round($days)." days ago";
						}	
					}else{
						$time_string=date_create($post_date);
						$time_string=date_format($time_string,"F d h:ia");
					}
                    $image1 = base64_encode(file_get_contents('blogpost/blogs/author_'.$author_id.'/'.$image));

                    $getsellerprofile = mysqli_query($conn, "SELECT * FROM sining_sellers WHERE seller_id = '$author_id'");
                         while($row1 = mysqli_fetch_assoc($getsellerprofile)){
                            $seller_id = $row1['seller_id'];
                            $seller_profile = $row1['seller_profile'];
                            $image2 = base64_encode(file_get_contents('seller_file/profile/'.$seller_profile));

                            echo '
				<table>
                
                <tr>
                    <input type="hidden" name="seller_id" id="seller_id" value="'.$seller_id.'"/>
                    <td class="profile-col pad"><img class="profile-img" src="data:image/jpeg;base64,'.$image2.'"></td>    
                    <td class="pad author"><a onclick="selectUser()" href=""><h3>'.$author.'</h3></a><p>'.$time_string.'</td>
                </tr>
                <tr>
                    <td colspan="2" class="pad"><h2 class="text art-title">'.$title.'</h2></td>
                </tr>
                <tr>
                    <td colspan="2" class="pad">'.$content .'</td>
                </tr>
                <tr>
                    <td colspan="2" class="blog-col">
                        <button onclick="getId('.$blog_id.')">
                            <img class="blog-img" src="data:image/jpeg;base64,'.$image1.'">
                        </button>
                    </td>
                </tr>
                </table>
                  ';
                         }
                        }
    }
    ?>
    </div>
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
    function selectUser(){
      const sellerId = $('#seller_id').val();
      console.log(sellerId);
      $.ajax({
    type: "POST",
    url: "getsellerid.php",
    data: {"seller_id": sellerId},
    success: function(result){
    //   window.location.href = "seller_profiles.php";
    }
   });
   }
</script>
<iframe src="footer.php" frameborder="0" width="100%"></iframe>
</body>
</html>