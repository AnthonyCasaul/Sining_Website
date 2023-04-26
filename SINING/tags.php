<?php
include 'condb.php';
error_reporting(E_ERROR | E_PARSE);
session_start();
$user_id = $_SESSION['user_id'];

	include 'similarity.php';
	$host = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "jcra-sining";
	
	$sql = $conn -> query("SELECT * FROM sining_artists WHERE artistId= '$user_id' ORDER BY artistId DESC");

	$conn1 = new Mysqli($host, $user, $pass, $dbname);
	$sql1 = $conn1 -> query('SELECT * FROM sining_artworks ORDER BY artId ASC');
	$count = $sql1 -> num_rows;
	
	
		while($post = mysqli_fetch_assoc($sql)){
		
		$artistTarget= explode(",",$post['artistTarget']);
		}


		while($post = mysqli_fetch_assoc($sql1)){
					$title = $post['artTitle'];
					$exoTags= explode(",",$post['artTags']);
					$articles[] = array(
						$tag1="article" => $title, 
						$tag2="tags" => $exoTags
					);	
			}

		$dot = Similarity::dot(call_user_func_array("array_merge", array_column($articles, "tags")));

		$target = $artistTarget;
		echo "example articles:<br/>";
		//print_r($articles);
		echo "<br/>target article:<br/>";
		print_r($target);

		foreach($articles as $article) {
			$score[$article['article']] = Similarity::cosine($target, $article['tags'], $dot);
		}
		$i=3;
		arsort($score);
		echo "</br></br>Sorted result similarity:<br/>";
		print_r($score);
?> 