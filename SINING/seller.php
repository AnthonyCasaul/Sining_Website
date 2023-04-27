<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/admin.css">
<title>SINING | SELLER</title>
</head>
<body>

<div class="tab">
    <a href="home.php" class="seller-home"><img src="assets/img/return.png"></a>
<iframe src="seller_profile.php" frameborder="0" width="100%" height="5%"></iframe>

  <button class="tablinks active" onclick="openCity(event, 'dashboard')">Dashboard</button>
  <button class="tablinks" onclick="openCity(event, 'approval-list')">To Be Approve</button>
  <button class="tablinks" onclick="openCity(event, 'to-ship')">To Ship</button>
  <button class="tablinks" onclick="openCity(event, 'to-receive')">To Receive</button>
  <button class="tablinks" onclick="openCity(event, 'completed')">Completed</button>
  <button class="tablinks" onclick="openCity(event, 'cancelled')">Cancelled</button>
  <button class="tablinks" onclick="openCity(event, 'sold-artworks')">Sold Artworks</button>

</div>

<div id="dashboard" style="display:block;" class="tabcontent">
    <h3>no content</h3>
</div>

<div id="sold-artworks" class="tabcontent">
    <iframe src="sold_artwork.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="approval-list" class="tabcontent">
    <iframe src="seller_page.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="to-ship" class="tabcontent">
    <h3>no content</h3>
</div>

<div id="to-receive" class="tabcontent">
    <h3>no content</h3>
</div>

<div id="completed" class="tabcontent">
    <h3>no content</h3>
</div>

<div id="cancelled" class="tabcontent">
    <h3>no content</h3>
</div>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}
</script>
   
</body>
</html>