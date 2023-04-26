<!DOCTYPE html>
<html lang="en">
  <head>
    <title>bobbyhadz.com</title>
    <meta charset="UTF-8" />
  </head>

  <body>
  <a href="home.php" id="logo" class="head-navbar"><h1 id="logo">Sining</h1></a>
    <img id="drop-down" src="assets/img/arrow.png" onclick="openDiv()">
    <div class="hidden" id="myDiv">
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
    </div>
</div>
  <style>
    .hidden {
      display: none;
    }

  </style>

  <script>
    function openDiv() {
        var x = document.getElementById("myDiv");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
  </script>

  

  </body>
</html>
