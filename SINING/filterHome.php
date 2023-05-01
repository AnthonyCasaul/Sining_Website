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
<title>FILTER PAGE</title>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
    <br />
    <h2 align="center">FILTER PAGE</h2>
    <br />
        <div class="col-md-3">                                
            <div class="list-group">
                <h3>Price</h3>
                <input type="hidden" id="hidden_minimum_price" value="0" />
                <input type="hidden" id="hidden_maximum_price" value="100000" />
                <p id="price_show">0 - 100000</p>
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
                    </div>
                </div>
        </div>
        <div class="col-md-9">
            <br />
           <div class="row filter_data">
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
        console.log(category);
        $.ajax({
            url:"fetch_fiter.php",
            method:"POST",
            data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price}, category:category,
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

    $('.common_selector').click(function(){
        filter_data();
    });
    $('#price_range').slider({
        range:true,
        min:0,
        max:100000,
        values:[0, 100000],
        step:50,
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
</body>
</html>