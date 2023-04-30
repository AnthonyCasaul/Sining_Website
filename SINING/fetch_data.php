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
include ('condb.php');
include('database_connection.php');
session_start();
error_reporting(E_ERROR | E_PARSE);

$user_id = $_SESSION['user_id'];
include 'similarity.php';
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "jcra-sining";

	$sql = $conn -> query("SELECT * FROM sining_artists WHERE artistId= '$user_id' ORDER BY artistId DESC");

	$conn1 = new Mysqli($host, $user, $pass, $dbname);
	$sql1 = $conn1 -> query('SELECT * FROM sining_artworks1 ORDER BY artId ASC');
	$count = $sql1 -> num_rows;

	while($post = mysqli_fetch_assoc($sql)){
		
		$artistTarget= explode(",",$post['artistTarget']);
		}


		while($post = mysqli_fetch_assoc($sql1)){
					$title = $post['artTitle'];
					$exoTags= explode(",",$post['artGenre']);
					$articles[] = array(
						$tag1="article" => $title, 
						$tag2="tags" => $exoTags
					);	
			}

		$dot = Similarity::dot(call_user_func_array("array_merge", array_column($articles, "tags")));

		$target = $artistTarget;

		
if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM sining_artworks1 WHERE purchased = '1' 
	";

	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= ("
		 AND artPrice BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
		");
	}
	if(isset($_POST["category"]))
	{
		$category_filter = implode("','", $_POST["category"]);
		$query .= ("
		 AND artTags IN('".$category_filter."')
		");
	}
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		
			foreach($articles as $article) {
				$score[] = Similarity::cosine($target, $article['tags'], $dot);
				$sort[$article['article']] = Similarity::cosine($target, $article['tags'], $dot);
			}
			rsort($score);
			arsort($sort);
			$indices = array_keys($sort);
			$try = array();
			$count = count($sort);

			for($a=0;$a<=$count;$a++){
				array_push($try, $indices[$a]);
			}
			$i=0;

				foreach ($try as $sort_row) {
					foreach($result as $row ){
							if($sort[$sort_row]!=0){
								if($sort_row==$row['artTitle']){	
								$sam = $row['artImage'];
								$id = $row['artId'];
								$url = $sam;
     							$image = base64_encode(file_get_contents('assets/img/sample_image.png'));
								$output .= '
			<form action="view_art.php" method=post>
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

				<p class="text art-title" align="center">'. $row['artTitle'].'
				</p>
					<div class="text-box">
					<table>
						<tr>
							<td class="there">Artist</td>
							<td class="here">'.$row['artistName'] .'</td>
						</tr>
						<tr>
							<td class="there">Price</td>
							<td class="here">'.$row['artPrice'] .'</td>
						</tr>
						<tr>
							<td class="there">Style</td>
							<td class="here">'.$row['artGenre'] .'</td>
						</tr>	
					</table>
					</div>
				</div>
			</div>';
							}	
					$i++;
				}
				}
			}		
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
	}
?>
</div>