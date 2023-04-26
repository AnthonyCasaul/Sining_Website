<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<?php
include 'condb.php';
$search = $_POST['search'];
echo ("<link rel=stylesheet href=homepagev2.css>");

$select = mysqli_query($conn, "SELECT * FROM sining_artworks1 WHERE artTitle LIKE '%$search%' OR artGenre LIKE '%$search%' OR artTags LIKE '%$search%' OR artYear LIKE '%$search%'");
$count = 0;
$tick = 0;
if ($select->num_rows > 0) {
    echo ("<div class=search-result><h2 class=search-head>Results for: </h2><h3 class=search-head>&nbsp".$search."</h3></div>");
    echo ("<div class=art-box-wrapper>");
    echo ("<div class=art-box-con>");
    // output data of each row
    while($row = $select->fetch_assoc()) {
        echo '
            <form action="view_art.php" method=post>
                <table class="art-box">
                    <tr>
                        <td class="art-img">
                            <img src="'.$row['artImage'].'" onclick="getId('.$row['artId'].')">
                        </td>
                    </tr>
                    <tr>
                        <td class="art-title">'.$row['artTitle'].'</td>
                    </tr>
                </table><br><br>
        ';
    }
} else {
    echo "0 results"."</div></div>";
}
?>
<script>
    function getId(id){
        console.log(id);
		    $.ajax({
            type: "POST",
            url: "getid.php",
            data: {"id": id},
            success: function(result){
    	    //  Swal.fire({title: 'Error!', text: 'Do you want to continue', icon: 'error', confirmButtonText: 'Cool'
            //         })
    	    window.location.href = "view_art.php";
    }
});	
    }
</script>