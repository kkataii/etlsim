<!DOCTYPE html>
<html>
<title>my.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./css/style - Copy.css">
<link rel="stylesheet" href="./css/theme.css">
<link rel="stylesheet" href="./css/font.css">
<link rel="stylesheet" href="./font-awesome-4.7.0/css/font-awesome.min.css"><style>
body {
  font-family: "Roboto", sans-serif}
  .my-bar-block .my-bar-item {
  padding: 16px;
  font-weight: bold;
}
</style>
<body>

<nav class="my-sidebar my-bar-block my-collapse my-animate-left my-card" style="z-index:3;width:250px;" id="mySidebar">
  <a class="my-bar-item my-button my-border-bottom my-large" href="#"><img src="./images/w3schools.png" style="width:80%;"></a>
  <a class="my-bar-item my-button my-hide-large my-large" href="javascript:void(0)" onclick="my_close()">Close <i class="fa fa-remove"></i></a>
  <a class="my-bar-item my-button my-teal" href="#">Home</a>
  <a class="my-bar-item my-button" href="#">Management</a>
  <a class="my-bar-item my-button" href="#">Register</a>
  <a class="my-bar-item my-button" href="#">Manage Users</a>
  <a class="my-bar-item my-button" href="#">Reports</a>
  <div>
    <a class="my-bar-item my-button" onclick="myAccordion('demo')" href="javascript:void(0)">Setting <i class="fa fa-caret-down"></i></a>
    <div id="demo" class="my-hide">
      <a class="my-bar-item my-button" href="#">Change Password</a>
      <a class="my-bar-item my-button" href="#">Manage Menu</a>
      <a class="my-bar-item my-button" href="#">Logout</a>
    </div>
  </div>
</nav>

<div class="my-overlay my-hide-large my-animate-opacity" onclick="my_close()" style="cursor:pointer" id="myOverlay"></div>

<div class="my-main" style="margin-left:250px;">

  <div id="myTop" class="my-container my-top my-theme my-large">
    <p><i class="fa fa-bars my-button my-teal my-hide-large my-xlarge" onclick="my_open()"></i>
    <span id="myIntro" class="my-hide">my.CSS: Introduction</span></p>
  </div>

  <header class="my-container my-theme" style="padding:64px 32px">
    <h1 class="my-xxxlarge">my.CSS</h1>
  </header>

  <div class="my-container" style="padding:32px">

    <h2>What is my.CSS?</h2>

    <p>my.CSS is a modern CSS framework with built-in responsiveness:</p>

    <ul class="my-leftbar my-theme-border" style="list-style:none">
     <li>Smaller and faster than other CSS frameworks.</li>
     <li>Easier to learn, and easier to use than other CSS frameworks.</li>
     <li>Uses standard CSS only (No jQuery or JavaScript library).</li>
     <li>Speeds up mobile HTML apps.</li>
     <li>Provides CSS equality for all devices. PC, laptop, tablet, and mobile:</li>
    </ul>
    <br>
    <img src="img_responsive.png" style="width:100%" alt="Responsive">

    <hr>
    <h2>my.CSS is Free</h2>
    <p>my.CSS is free to use. No license is necessary.</p>

    <hr>
    <h2>Easy to Use</h2>
    <div class="my-container my-sand my-leftbar">
      <p><i>Make it as simple as possible, but not simpler.</i><br>Albert Einstein</p>
    </div>

    <hr>
    <h2>my.CSS Web Site Templates</h2>

    <p>We have created some responsive myCSS templates for you to use.</p>
    <p>You are free to modify, save, share, use or do whatever you want with them:</p>


    <div class="my-panel my-light-grey my-padding-16 my-card">
      <h3 class="my-center">Band Template</h3>
      <div class="my-content" style="max-width:800px">
        <a href="trymycss_templates_band.htm" target="_blank"  title="Band Demo"><img src="img_temp_band.jpg" style="width:98%;margin:20px 0" alt="Band Template"></a><br>
        <div class="my-row">
          <div class="my-col m6">
            <a href="trymycss_templates_band.htm" target="_blank" class="my-button my-padding-large my-dark-grey" style="width:98.5%">Demo</a>
          </div>
          <div class="my-col m6">
            <a href="mycss_templates.asp" class="my-button my-padding-large my-dark-grey" style="width:98.5%">More Templates &raquo;</a>
          </div>
        </div>
      </div>
    </div>

    <div class="my-container my-padding-16 my-card" style="background-color:#eee">
      <h3 class="my-center">Blog Template</h3>
      <div class="my-content" style="max-width:800px">
        <img src="img_temp_blog.jpg" style="width:98%;margin:20px 0" alt="Blog Template"><br>
        <div class="my-row">
          <div class="my-col m6">
            <a href="trymycss_templates_blog.htm" target="_blank" class="my-button my-padding-large my-dark-grey" style="width:98.5%">Demo</a>
          </div>
          <div class="my-col m6">
            <a href="mycss_templates.asp" class="my-button my-padding-large my-dark-grey" style="width:98.5%">More Templates &raquo;</a>
          </div>
        </div>
      </div>
    </div>

  </div>

  <footer class="my-container my-theme" style="padding:32px">
    <p>Footer information goes here</p>
  </footer>
     
</div>

<script>
// Open and close the sidebar on medium and small screens
function my_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}

function my_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}

// Change style of top container on scroll
window.onscroll = function() {myFunction()};
function myFunction() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    document.getElementById("myTop").classList.add("my-card-4", "my-animate-opacity");
    document.getElementById("myIntro").classList.add("my-show-inline-block");
  } else {
    document.getElementById("myIntro").classList.remove("my-show-inline-block");
    document.getElementById("myTop").classList.remove("my-card-4", "my-animate-opacity");
  }
}

// Accordions
function myAccordion(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("my-show") == -1) {
    x.className += " my-show";
    x.previousElementSibling.className += " my-theme";
  } else { 
    x.className = x.className.replace("my-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" my-theme", "");
  }
}
</script>
     
</body>
</html> 