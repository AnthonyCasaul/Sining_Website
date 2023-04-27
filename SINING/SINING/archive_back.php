<?php

	include 'condb.php';
 
	$query = mysqli_query($conn, "SELECT * FROM `artworks_archive` WHERE artid ='". $_GET['archiveid']."'   ") or die('query failed');

	while($fetch = mysqli_fetch_array($query)){
		if(($fetch['artid'])> 0){
			mysqli_query($conn, "INSERT INTO `sining_artworks` (artistId, artId, artTitle, artImage, artPrice, artGenre, artTags, artYear, artRate, product_status)
			 VALUES('$fetch[artistid]', '$fetch[artid]', '$fetch[title]', '$fetch[image]', '$fetch[price]', '$fetch[genre]', '$fetch[tags]', '$fetch[year]', '$fetch[rate]', '$fetch[product_status]')") or die(mysqli_error($conn));
            mysqli_query($conn, "DELETE FROM `artworks_archive` WHERE artid ='". $_GET['archiveid']."' ") or die(mysqli_error($conn));
	
        }
        header('location:sellerprofile.php');
	}
?>