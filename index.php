<?php
require_once ('indexCode.php');
?>
<!DOCTYPE html>
<htm>
<head>
<?php function htmltage($title){ ?><title><?php echo $title; ?></title><?php } ?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css" >
<link rel="stylesheet" href="./css/jquery-ui.css">
<link rel="stylesheet" href="./fontawesome/css/all.css">
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/theme.css">
<link rel="stylesheet" href="./font/style.css">
<link rel="stylesheet" href="./font/NotoSansLao/noto-font.css">
<link rel="stylesheet" href="./css/submenu_style.css">
<link rel="stylesheet" href="./css/form-style.css">
<link rel="stylesheet" href="./css/pagination.css">
<link rel="stylesheet" href="./datepicker/gijgo.min.css">
<link rel="stylesheet" href="./css/MonthPicker.min.css">
<link rel="stylesheet" href="./libscrop/cropper.css">
<link rel="stylesheet" href="./css/customize_modal.css">
<link rel="stylesheet" href="./css/cropper.css">
 <link rel="stylesheet" href="http://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css">

<style>
  @import url("../font/style.css");
body {
  /*font-family: 'Phetsarath_OT', sans-serif*/
  font-family: 'Noto Regular', Verdana, Arial, sans-serif;
}
  .my-bar-block .my-bar-item {
  padding: 16px;
  font-weight: bold;
}
.fa-calendar{
  padding-top: 8px;
}
.comment {
      float: left;
      width: 100%;
      height: auto;
  }

  .comment-text-area {
      float: left;
      width: 100%;
      height: auto;
  }

  .textinput {
      float: left;
      width: 100%;
      min-height: 75px;
      padding: 4px;
      outline: none;
      resize: none;
      border: 1px solid grey;
  }
  .disEditUser {
        cursor: not-allowed;
    }
   .pointer-events-none{
      pointer-events: none;
    }
</style>

</head>
<body>

<nav class="my-sidebar my-bar-block my-collapse my-animate-left my-card" style="z-index:3;width:250px;" id="mySidebar">
  <a class="my-bar-item my-button my-border-bottom my-large" href="?d=index">
    <!-- <img src="./images/w3schools.png" style="width:80%;"> -->
    <!-- <img src="./images/etllogo.png" width="75%" height="5%"> -->
  </a>
  <a class="my-bar-item my-button my-hide-large my-large" href="javascript:void(0)" onclick="my_close()">Close <i class="fa fa-remove"></i></a>
  <a class="my-bar-item my-button" href="?d=index"  style="background: #0099cc;text-align:center" >ໜ້າຫຼັກ</a>
  <?php if (isset($_SESSION["user_kyc_id"]) && isset($_SESSION['user_kyc_name'])){?>
  <a class="my-bar-item my-button" href="?d=import_SIM/import_list" style="text-align:center">ເພີ່ມເບີ</a>
  <a class="my-bar-item my-button" href="?d=report/rp_list" style="text-align:center" >ລາຍງານ</a>
  <?php }else{ ?>  
  <a class="my-bar-item my-button" href="./authorize/index.php" style="text-align:center" >ເຂົ້າສູ່ລະບົບ</a>
  <?php } if (isset($_SESSION["user_kyc_id"]) && isset($_SESSION['user_kyc_name'])){?>

  <div>
    <a class="my-bar-item my-button" onclick="myAccordion('demo')" href="javascript:void(0)" style="text-align:center">ຕັ້ງຄ່າ <i class="fa fa-caret-down"></i></a>
    <div id="demo" class="my-hide">
      <a class="my-bar-item my-button" href="?d=management/change_password" style="text-align:center">ປ່ຽນລະຫັດຜ່ານ</a>
      <a class="my-bar-item my-button" href="./authorize/logout.php?logout_id=<?=$_SESSION['user_kyc_id']?>" onclick="return confirm('Do you want to exit?');" style="text-align:center">ອອກຈາກລະບົບ</a>
    </div>
  </div>
  <?php } ?>  
</nav>
<div class="my-overlay my-hide-large my-animate-opacity" onclick="my_close()" style="cursor:pointer" id="myOverlay"></div>
<div class="my-main" style="margin-left:250px;">
  <div id="myTop" class="my-container my-top my-large">
    <p>
      <i class="fa fa-bars my-button my-teal my-hide-large my-xlarge" onclick="my_open()"></i>
      <span id="myIntro" class="my-hide" style="padding-top: 10px; padding-left: 30px; font-size: calc(0.6rem + 0.8vw);">
        Store.etllao.com
      </span>


    </p>

  </div>
<!--     <section class="content-banner">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-12">
            <div class="banner-con text-center">
              <p class="first-title">Welcome To Register ETL Subscriber</p>
              <p class="banner-des">Manage All Subscriber By ETL Provider</p>
            </div>
          </div>
        </div>
      </div>
    </section> -->
  <div class="main-container my-container">
    <div class="my-panel my-light-grey my-padding-16 my-card">
      <div class="my-content" style="width:100%;">
        <!--navbar menu-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Menu:</a>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item active">
            <a class="nav-link" href="?d=nav_main/sim">sim<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?d=nav_main/packet">packet</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">product</a>
          </li>
        </ul>

      </div>
    </nav>
        <?php
         
               if (file_exists($vfilename)) include ($vfilename); 
        ?>
      </div>
    </div>
  </div>
  <div class="b-example-divider"></div>
  <!-- ======= Footer ======= -->
  <footer id="footer" class="my-container" style="background: #0099cc;">
    <div class="footer-top my-container">
      <div class="my-container">
        <div class="my-row d-flex justify-content-center py-2 my-2">
          <p class="text-left"><?php echo date('Y-m-d'); ?>. ETL Store - By ETL Campany Ltd.</p>
          
          <!-- <a href="https://www.facebook.com/etllaopubliccompany?mibextid=ZbWKwL "><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
          <a href="https://instagram.com/etl_company_limited?igshid=YmMyMTA2M2Y= "><i class="fa fa-instagram w3-hover-opacity"></i></a>     
          <a href="http://store.etllao.com/"><i class="fa fa-envelope"></i></a> -->

        </div>
      </div>
    </div>
  </footer>
</div>

<!-- preview image in modal -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">     
      <div class="modal-header">
        <i class="fas fa-sync-alt" id="rotateme" style="cursor:pointer"></i>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>         
      <div class="modal-body" id="divshowimg">
        <img src="" class="imagepreview" id="imagepreview" style="width: 100%; height: 100%;">
      </div>
    </div>
  </div>
</div>

<!-- The Camera Modal -->
<div class="modal" id="cameraModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Take a picture</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
            <div id="my_camera"></div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn upload" data-dismiss="modal">Close</button>
        <button type="button" class="btn camera" onclick="take_snapshot()">Take a picture</button>
      </div>
    </div>
  </div>
</div>
<script src="./libscrop/jquery.v3.4.1.js"></script> <!-- for crop image -->
<script src="./js/jquery-3.5.1.js"></script>
<script src="./js/popper.min.js"></script>
<script src="./bootstrap/js/bootstrap.min.js"></script>
<script src="./js/jquery-ui.js"></script>
<!-- <script src="./js/bootstrap.bundle.min.js"></script>-->
<script src="./datepicker/gijgo.min.js"></script>
<script src="./js/sweetalert2.all.min.js"></script>
<script src="./js/bootstrap-session-timeout.js"></script>

<script src="./js/sim.js"></script>
<script src="./js/MonthPicker.min.js"></script>
<!-- Camera cam capture -->
<script src="./webcamjs/webcam.min.js"></script>
<script src="./libscrop/cropper.js"></script>
<script type="text/javascript" src="http://cdn.sobekrepository.org/includes/jquery-rotate/2.2/jquery-rotate.min.js"></script>
<!-- mytable -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
$('#myTable').DataTable();
} );
</script>
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
  if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
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
