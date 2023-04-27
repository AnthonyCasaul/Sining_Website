<link rel="stylesheet" href="css/new-navbar.css">
<header id="navbar">
<a href="home.php" id="logo" class="head-navbar"><h1 id="logo">Sining</h1></a>
    <ul>
        <a href="#" class="nav-links">
            <li class="nav-item">Artworks</li>
        </a>
        <a href="ValidateSeller.php" class="nav-links">
            <li class="nav-item">Sell</li>
        </a>
        <a href="#" class="nav-links">
            <li class="nav-item">Newsfeed</li>
        </a>
        <a href="#" class="nav-links">
            <li class="nav-item">Artists</li>
        </a>
    </ul>
<!--     
    <div class="search-box1">
        <button onclick="searchFunction()" class="search-btn1">
            <img src="assets/img/search.png">
        </button>
        <input id="search" class="search-txt1" type="text" name="" placeholder="Type to search">
    </div> -->
    <div class="con-btn">
        <div class="account-btn">
            <img src="assets/img/account.png">
            <div class="submenu">
            <a href="userprofile.php" id="account-lbl">Manage Account</a><br><br>
            <a href="#" id="account-lbl">Purchased</a><br><br>
            <a href="logout.php" id="account-lbl">Logout</a>
            </div>
        </div>
        <div class="cart-btn">
            <img src="assets/img/shopping-cart.png">
        </div>
    </div>
    
<script>
    // When the user scrolls down 20px from the top of the document, slide down the navbar
    window.onscroll = function() {scrollFunction()};

    function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("navbar").style.background = "#212529";
    } else {
        document.getElementById("navbar").style.background = "none";
    }
    }
</script>
</header>