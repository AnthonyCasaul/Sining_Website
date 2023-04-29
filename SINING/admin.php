<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/admin.css">
<title>SINING | ADMIN</title>
</head>
<body>

<div class="tab">
<a href="home.php" id="logo" class="head-navbar"><h1 id="logo" class="head-navbar-inner">Sining</h1><img src="assets/img/logo.jpg"></a>
  <button class="tablinks active" onclick="openCity(event, 'seller-approval-list')"><h4>Seller Approval List</h4><img src="assets/img/avatar.png"> <img class="approve-img" src="assets/img/approve.png"></button>
  <button class="tablinks" onclick="openCity(event, 'approval-list')"><h4>Art Approval List</h4><img src="assets/img/frame.png"> <img class="approve-img" src="assets/img/approve.png"></button>
  <button class="tablinks" onclick="openCity(event, 'user-list')"><h4>User List</h4><img src="assets/img/avatar.png"></button>
  <button class="tablinks" onclick="openCity(event, 'seller-list')"><h4>Seller List</h4><img src="assets/img/seller.png"></button>
  <button class="tablinks" onclick="openCity(event, 'artwork-list')"><h4>Artwork List</h4><img src="assets/img/frame.png"></button>

</div>

<div id="seller-approval-list" style="display:block;" class="tabcontent">
    <iframe src="adminSellerApproval.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="approval-list" class="tabcontent">
    <iframe src="adminArtApproval.php" frameborder="0" width="100%" height="100%"></iframe>
</div>
<div id="user-list" class="tabcontent">
    <iframe src="user_list.php" frameborder="0" width="100%" height="100%"></iframe>
</div>
<div id="artwork-list" class="tabcontent">
    <iframe src="artwork_list.php" frameborder="0" width="100%" height="100%"></iframe>
</div>
<div id="seller-list" class="tabcontent">
    <iframe src="seller_list.php" frameborder="0" width="100%" height="100%"></iframe>
</div>

<div id="nav-links" class="tabcontent">
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