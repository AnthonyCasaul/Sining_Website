<?php
    include "condb.php";

    $sql = "SELECT * FROM sining_artworks1";
    $result = mysqli_query($conn, $sql);

    $sqlCate = "SELECT DISTINCT artGenre FROM sining_artworks1";
    $resultCate = mysqli_query($conn, $sqlCate);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sining | Buy</title>
<link rel="icon" type="image/x-icon" href="assets/logo.ico" />
<!-- <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
<link rel="icon" type="image/x-icon" href="assets/logo.ico" />
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href = "css/jquery-ui.css" rel = "stylesheet">
<link rel="stylesheet" href="home.css">
<link rel="stylesheet" href="filterHome.css">
</head>
<body>
<div class="wrapper">
<?php
    include("navbar.php");
?>
    <h1 class="some-txt" style="z-index:2;">
    <!-- <iframe src="header.php" frameborder="0" width="500" height="100%"></iframe> -->
    <!-- <br><a href="home.php"><button>Get Started</button></a> -->
</h1>
<section class="bg-image" id="new-bg-image"></section>
<div id="searchResults" class="container art-categ-con">
    <div class="row">
    <br />
    <br />
        <div class="col-md-3 ano-to">                                
            <div class="list-group">
                <h3>Price</h3>
                <input type="hidden" id="hidden_minimum_price" value="0" />
                <input type="hidden" id="hidden_maximum_price" value="100000" />
                <p id="price_show">100 - 100,000</p><br>
                <div id="price_range"></div>
            </div> 
           <div class="list-group">
					<h3>Genre</h3>
                    <div style="height: 100%; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = $conn->query("SELECT DISTINCT(artGenre) FROM sining_artworks1 WHERE purchased = '1'");
                    
                    foreach($query as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector category" value="<?php echo $row['artGenre']; ?>"  > <?php echo $row['artGenre']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div><br>

                    <h3>Year</h3>
                    <div style="height: 100%; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = $conn->query("SELECT DISTINCT(artYear) FROM sining_artworks1 WHERE purchased = '1'");
                    
                    foreach($query as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector artyear" value="<?php echo $row['artYear']; ?>"  > <?php echo $row['artYear']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div><br>

                    <h3>Artist</h3>
                    <div style="height: 100%; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = $conn->query("SELECT DISTINCT(artistName) FROM sining_artworks1 WHERE purchased = '1'");
                    
                    foreach($query as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector artist" value="<?php echo $row['artistName']; ?>"  > <?php echo $row['artistName']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div>

                </div>
        </div>
        <div class="col-md-9">
            <br />
           <div id="filter_data" class="row filter_data container art-categ-con">
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    filter_data();
    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_fiter';
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var category = get_filter('category');
        var artYear = get_year('artyear');
        var artistname = get_artist('artist');
        console.log(category);
        $.ajax({
            url:"fetch_fiter.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, category:category, artYear:artYear, artistName:artistname},
            success:function(data){
                // console.log(data);
                $('.filter_data').html(data);
            }
        });
    }
    function get_filter(categ)
    {
        var filter = [];
        $('.'+categ+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }
    function get_year(year)
    {
        var filter = [];
        $('.'+year+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }
    function get_artist(artist)
    {
        var filter = [];
        $('.'+artist+':checked').each(function(){
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
<iframe src="footer.php" frameborder="0" width="100%"></iframe>
</body>
</html>