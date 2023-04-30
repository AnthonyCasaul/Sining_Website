<?php 
include('database_connection.php');
include('condb.php')
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sining | Homepage</title>
    <link rel="icon" type="image/x-icon" href="assets/logo.ico" />
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> -->
    <!-- <script src="viewportchecker.js"></script> -->
    <link rel="stylesheet" href="home.css">
    <!-- <link rel="stylesheet" href="css/header.css"> -->
</head>

<body onload="myFunction()">
<div id="loader">
    <iframe src="preloader.php" frameborder="0" width="300px" height="300px"></iframe>
</div>
<div class="preload-cover" id="wrapper" style="display: none;">
<div class="wrapper">
<?php
    include("navbar.php");
?>
    <h1 class="some-txt" style="z-index: 2;">
    <iframe src="header.php" frameborder="0" width="500" height="100%"></iframe>
    <br><button><a href="home.php">Browse</a></button></h1>

    <section class="bg-image" id="new-bg-image"></section>
    <!-- Page Content -->
    
    <div  id="searchResults" class="container art-categ-con">
        <div class="row">
        	<br />
        	<!-- <h2 align="center">Sining</h2> -->
        	<br />
            <div class="col-md-3 ano-to">
                <div class="list-group search-box1">
                    <input onkeydown="searchFunction()" id="search" class="search-txt1" type="text" name="search" placeholder="Type to search">
                    <button onclick="searchFunction()" class="search-btn1">
                        <!-- <img src="assets/img/search.png"> -->
                    </button>
                    
                </div>                  				
				<div class="list-group">
					<h3>Price</h3><br>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="100000" />
                    <p id="price_show">1000 - 100000</p><br>
                    <div id="price_range"></div>
                </div>	
                  			
                <div class="list-group">
					<h3>Genre</h3>
                    <div style="height: 100%; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = $conn->query("SELECT DISTINCT(artGenre) FROM sining_artworks WHERE purchased = '1' ORDER BY artId DESC");
                    
                    foreach($query as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector category" value="<?php echo $row['artGenre']; ?>"/> <?php echo $row['artGenre']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div>
                </div>

            </div>

            <div class="col-md-9">
            	<br />
                <div class="row filter_data" class="container art-categ-con">

                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');
        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, category:category},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider({
        range:true,
        min:1000,
        max:100000,
        values:[1000, 100000],
        step:500,
        stop:function(event, ui)
        {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });

});
</script>

<script>
    function getId(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	     Swal.fire({title: 'Error!', text: 'Do you want to continue', icon: 'error', confirmButtonText: 'Cool'
                    })
    	    window.location.href = "view_art.php";
    }
});	

    }
</script>
<script src="js/scripts.js"></script>
<script>
        function searchFunction() {
    const searchInput = $('#search').val();
    const searchResults = document.getElementById('searchResults');
    console.log(searchInput);

    $.ajax({
        type: "POST",
        url: "searchTitle.php",
        data: {"search": searchInput},
        success: function(result){
        console.log(result);
        $('.filter_data').html(result);
    }
});	
}
</script>

<script>
    const animateMe = document.querySelector('.row');

const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      animateMe.classList.add('animate');
      observer.unobserve(entry.target);
    }
  });
});

observer.observe(animateMe);

</script>

<script>
var myVar;

function myFunction() {
  myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("wrapper").style.display = "block";
}
</script>

</body>
</html>
