<?php

error_reporting(E_ERROR | E_PARSE);
@include 'condb.php';
session_start();
$user_id = $_SESSION['user_id'];
$artist = $_SESSION['artistid'];
$fetchart = $_SESSION['fetchartid'];
$artid = $_POST['artid'];

$user_id = $_SESSION['user_id'];


if(!isset($user_id)){
   header('location:index.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>History</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/historystyle.css">
</head>
<body>
<div class="container cont">
	<div class="row">
	<div class="col">
		<button class="tablinks" onclick="openCity(event, 'toPay')" id="defaultOpen">To be Confirmed</button>
		<button class="tablinks" onclick="openCity(event, 'toReceive')">Receiving</button>
		<button class="tablinks" onclick="openCity(event, 'history')">Received</button>
	</div>

	<div class="col" style="text-align: right">
		<button class="tablinks" onclick="openCity(event, 'toRefundProcess')" id="defaultOpen">Cancel Processing</button>
		<button class="tablinks" onclick="openCity(event, 'toRefund')">Refunded</button>
	</div>
	</div>

	<div id="history" class="tabcontent text-center">
  <h1>Received</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, b.artistName as aname FROM `artist_history` a left join sining_artists b on b.artistId = a.artistId  WHERE a.userId='$user_id' and a.status = 2");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
		echo '<h3 style="text-align: left; padding-left: 150px">Order # '.$fetch_artist['id'].'</h3>';
 		echo '<img src="uploaded_img/'.$fetch_artist['artImage'].'">';
 		echo '<h3>'.$fetch_artist['artistTitle'].'</h3>';
 		echo '<h3>x'.$fetch_artist['artQuantity'].'</h3>';
 		echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['artPrice'].'</h2>';
 		echo '<h3 style="text-align: left; padding-left: 150px">Seller Name: '.$fetch_artist['aname'].'</h3>';
		echo '<button class="btn btn-info elevation-1 btn-xs" data-image="'.$fetch_artist['artGcash'].'" data-ref="'.$fetch_artist['artGcash_ref'].'" onclick="showReceipt(this)"><i class="fa fa-eye" ></i> View Receipt</button>';
 		echo '<hr>';
 		}
 	}
   ?>
   
</div>



<div id="toPay" class="tabcontent text-center">
  <h1>To be approved by the seller</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, b.artistName as aname FROM `artist_history` a left join sining_artists b on b.artistId = a.artistId  WHERE a.userId='$user_id' and a.status = 0");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
		echo '<h3 style="text-align: left; padding-left: 150px">Order # '.$fetch_artist['id'].'</h3>';
 		echo '<img src="uploaded_img/'.$fetch_artist['artImage'].'"  >';
 		echo '<h3>'.$fetch_artist['artistTitle'].'</h3>';
 		echo '<h3>x'.$fetch_artist['artQuantity'].'</h3>';
 		echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['artPrice'].'</h2>';
 		echo '<h3 style="text-align: left; padding-left: 150px">Seller Name: '.$fetch_artist['aname'].'</h3>';
		//refund time
		if(time() >= strtotime('+ 1 day', $time))
		echo '';
			  echo '<button class="btn btn-danger" data-id="'.$fetch_artist['id'].'" onclick="cancel(this)">Cancel</button>';

			  echo '';
			  echo '<button class="btn btn-info elevation-1 btn-xs" data-image="'.$fetch_artist['artGcash'].'" data-ref="'.$fetch_artist['artGcash_ref'].'" onclick="showReceipt(this)"><i class="fa fa-eye" ></i> View Receipt</button>';
 		echo '<hr>';
 		}
 	}
   ?>
   
</div>

<div id="toReceive" class="tabcontent text-center">
  <h1>To Receiving</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, b.artistName as aname FROM `artist_history` a left join sining_artists b on b.artistId = a.artistId  WHERE a.userId='$user_id' and a.status = 1");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
 		
		echo '<h3 style="text-align: left; padding-left: 150px">Order # '.$fetch_artist['id'].'</h3>';
 		echo '<img src="uploaded_img/'.$fetch_artist['artImage'].'"  >';
 		echo '<h3>'.$fetch_artist['artistTitle'].'</h3>';
 		echo '<h3>x'.$fetch_artist['artQuantity'].'</h3>';
 		echo '<h3>'.$fetch_artist['date'].'</h3>';
 		echo '<h2>₱'.$fetch_artist['artPrice'].'</h2>';
 		echo '<h3 style="text-align: left; padding-left: 150px">Seller Name: '.$fetch_artist['aname'].'</h3>';
 		echo '<button class="btn btn-success" data-id="'.$fetch_artist['id'].'" onclick="received(this)">Received</button>';
		echo '<button class="btn btn-info elevation-1 btn-xs" data-image="'.$fetch_artist['artGcash'].'" data-ref="'.$fetch_artist['artGcash_ref'].'" onclick="showReceipt(this)"><i class="fa fa-eye" ></i> View Receipt</button>';
 		echo '<hr>';
 		}
 	}
   ?>
</div>

<div id="toRefundProcess" class="tabcontent text-center">
  <h1>Cancel Processing</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, b.artistName as aname FROM `artist_history` a left join sining_artists b on b.artistId = a.artistId  WHERE a.userId='$user_id' and a.status = -1");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
				
			echo '<h3 style="text-align: left; padding-left: 150px">Order # '.$fetch_artist['id'].'</h3>';
			echo '<div class="alert alert-danger" role="alert">'.$fetch_artist['cancel_message'].'</div>';
			echo '<img src="uploaded_img/'.$fetch_artist['artImage'].'"  >';
			echo '<h3>'.$fetch_artist['artistTitle'].'</h3>';
			echo '<h3>x'.$fetch_artist['artQuantity'].'</h3>';
			echo '<h3>'.$fetch_artist['date'].'</h3>';
			echo '<h2>₱'.$fetch_artist['artPrice'].'</h2>';
			echo '<h3 style="text-align: left; padding-left: 150px">Seller Name: '.$fetch_artist['aname'].'</h3>';
			echo '<button class="btn btn-info elevation-1 btn-xs" data-image="'.$fetch_artist['artGcash'].'" data-ref="'.$fetch_artist['artGcash_ref'].'" onclick="showReceipt(this)"><i class="fa fa-eye" ></i> View Receipt</button>';
		
			echo '<hr>';
 		}
 	}
   ?>
</div>

<div class="modal fade" id="myModal">
			<div class="modal-dialog modal-md">
				<form method="post" class="form-horizontal">
			  <div class="modal-content">
				<div class="modal-body text-center">
					
                <img id="imageReceipt" class="img" style="width:100%;">
				<b>Reference No.:</b> <span id="imageRef"><span>
				</div>
				<div class="modal-footer justify-content-between">
				  <button type="button" class="btn elevation-1 btn-sm btn-default " onclick="$('#myModal').modal('hide')">Close</button>
				</div>
			  </div>
				</form>
			  <!-- /.modal-content -->
			</div>
			<!-- /.modal-dialog -->
</div>


<div id="toRefund" class="tabcontent text-center">
  <h1>Refunded</h1>
  <?php
 		$user_info = mysqli_query($conn, "SELECT a.*, b.artistName as aname FROM `artist_history` a left join sining_artists b on b.artistId = a.artistId  WHERE a.userId='$user_id' and a.status = -2");
 		if(mysqli_num_rows($user_info) > 0){
            while($fetch_artist = mysqli_fetch_assoc($user_info)){
			
			echo '<h3 style="text-align: left; padding-left: 150px">Order # '.$fetch_artist['id'].'</h3>';
			echo '<div class="alert alert-danger" role="alert">'.$fetch_artist['cancel_message'].'</div>';
			echo '<img src="uploaded_img/'.$fetch_artist['artImage'].'"  >';
			echo '<h3>'.$fetch_artist['artistTitle'].'</h3>';
			echo '<h3>x'.$fetch_artist['artQuantity'].'</h3>';
			echo '<h3>'.$fetch_artist['date'].'</h3>';
			echo '<h2>₱'.$fetch_artist['artPrice'].'</h2>';
			echo '<h3 style="text-align: left; padding-left: 150px">Seller Name: '.$fetch_artist['aname'].'</h3>';
			echo '<button class="btn btn-info elevation-1 btn-xs" data-image="'.$fetch_artist['artGcash'].'" data-ref="'.$fetch_artist['artGcash_ref'].'" onclick="showReceipt(this)"><i class="fa fa-eye" ></i> View Receipt</button>';
			echo '<hr>';
 		}
 	}
   ?>
</div>

<div id="history" class="tabcontent">
  
</div>
</div>

<script>
function openCity(evt, toAction) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(toAction).style.display = "block";
  evt.currentTarget.className += " active";
}
document.getElementById("defaultOpen").click();

function received(event)
{
	var id = $(event).attr("data-id")
	if(confirm("Are you sure you want to proceed?"))
	{
			$.ajax({
				url:"logic_function.php",
				method:"POST",
				data:{function: "updatestatus", id, status: 2},
				success:function(data){
				alert("Success")
				location.reload();
				}
			});
	}
}
function showReceipt(event)
{
	var filename = $(event).attr("data-image");
	var ref = $(event).attr("data-ref");
	$("#imageRef").html(ref);
	$("#imageReceipt").attr("src","uploaded_img/"+filename);
	$('#myModal').modal('show'); 
	
}
function cancel(event)
{
	var id = $(event).attr("data-id")
	var cancel = prompt("Please Enter reason of cancelation:", "");
	if(cancel)
	{
		$.ajax({
            url:"logic_function.php",
            method:"POST",
            data:{function: "cancel", id, message: cancel},
            success:function(data){
               alert("Success")
			   location.reload();
            }
        });
	}
}
</script>

</body>
</html>