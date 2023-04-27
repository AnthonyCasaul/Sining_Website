<?php

	include 'condb.php';
 
	$query = mysqli_query($conn, "SELECT * FROM `sining_artworks` WHERE artId ='". $_GET['archiveid']."'   ") or die('query failed');

	while($fetch = mysqli_fetch_array($query)){
		if(($fetch['artId'])> 0){
			mysqli_query($conn, "INSERT INTO `artworks_archive` (artid, image, title, genre, price, artistid, tags, year, rate, product_status)
			 VALUES('$fetch[artId]', '$fetch[artImage]', '$fetch[artTitle]', '$fetch[artGenre]', '$fetch[artPrice]', '$fetch[artistId]', '$fetch[artTags]', '$fetch[artYear]', '$fetch[artRate]', '$fetch[product_status]')") or die(mysqli_error($conn));
            mysqli_query($conn, "DELETE FROM `sining_artworks` WHERE artId ='". $_GET['archiveid']."' ") or die(mysqli_error($conn));
			
        }
        header('location:archive_page.php');
	}
?>