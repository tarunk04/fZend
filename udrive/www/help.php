<?php
  include "verify.php";
  if ($_SESSION['new_user'] == 0) {
 ?>
<!DOCTYPE html>
<html>
  <head>
    <!-- CSS -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- End of CSS -->

    <!-- Icon -->
      <link rel="icon" href="./images/icon.png">
    <!-- End of Icon -->

    <!-- Title -->
      <title>fZend</title>
    <!-- End of Title -->

    <!-- CSS -->
      <link rel="stylesheet" href="./css/bootstrap.css">
      <link rel="stylesheet" type="text/css" href="./res/font/icon/flaticon.css">
    <!-- End of CSS -->

    <!-- JavaScript -->
      <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
      <script src="./js/popper.min.js"></script>
      <script src="./js/jquery.form.js"></script>
      <script src="./js/bootstrap.min.js"></script>
    <!-- End of JavaScript -->

    <!-- Color theme -->
      <link rel="stylesheet" href="./css/style.css">
    <!-- End of Color Theme -->
    <!-- Script -->
    <script>
      $(document).ready(function(){
          $("#menu").click(function(){
            $("#side-menu").fadeToggle(20);
          });
          //console.log($(".vid-slide"));
          var vid_body = $(".vid").width()+30;
          var max_vid_width = $(".vid-slide").width();
          if(max_vid_width < vid_body){
            $(".vid-slide-right").css("display","none");
            $(".vid-slide-left").css("display","none");
          }
          else {
            $(".vid-slide-right").css("display","block");
          }
      });
    </script>
    <!-- End of Script-->
  </head>
  <body style="overflow: hidden;">
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top" style="box-shadow: 0 0 8px rgba(0,0,0,0.5);">
    <div class="container-fluid" style="height: 46px;">
      <div class="  col-md-8 col-12">
        <ul class="navbar-nav" style="flex-direction: row;">
          <li class="nav-item">
            <!-- fZend MENU -->
            <a class="navbar-brand dark-icon" id="menu">
              <i class="flaticon-line-menu font-xs"></i>
            </a>
          </li>
          <!-- End of fZend MENU -->
          <!-- fZend LOGO -->
          <li class="nav-item">
            <a class="navbar-brand" href="./" style="margin-right:5px;">
              <img src="./images/icon.png" alt="Logo" style="width:1.8em;margin-left:1em;">
            </a>
          </li>
          <!-- End of fZend LOGO -->
          <!-- fZend Title -->
          <li class="nav-item">
            <a class="navbar-brand" id="brand-title" href="./">fZend</a>
          </li>
          <!-- End of fZend Tilte -->
          <!-- Search Bar -->
          <!-- <li class="nav-item" style="width:50%;line-height: 46px;" >
            <form class="form-inline  show-search" id="search" action="/action_page.php" >
              <div class="input-group" style="width:100%;">
                <input type="text" class="form-control" placeholder="Search"/>
                <button class="input-group-addon" type="submit" style="cursor:pointer;padding: 5px;"> <i class="flaticon-search font-xxs" style="position:relative;left:10px;color:#777;"></i></button>
              </div>
            </form>
          </li> -->
          <!-- End of Search Bar -->
        </ul>
      </div>
      <!-- Links -->
        <div class="  col-md-4 col-7" style="padding: 0px;">
          <ul class="navbar-nav " id="links" style="float:right; flex-direction: row;" >
            <!-- Search Button -->
            <!-- <li class="nav-item search-icon">
              <a class="navbar-brand dark-icon no-pad-l no-pad-r" href="#">
                <i class="flaticon-search font-xs"></i>
              </a>
            </li> -->
            <!-- End of Search Button -->
            <!-- <li class="nav-item btn-group">
              <a class="navbar-brand dark-icon dropdown-toggle-split no-pad-l no-pad-r" data-toggle="dropdown">
                <i class="flaticon-shapes font-xs" ></i>
              </a>
                <div class="dropdown-menu dropdown-menu-right " style="top:49px;">
                  <h5 class="dropdown-header font-m">Categories</h5>
                  <a class="dropdown-item" href="#">Cardiology</a>
                  <a class="dropdown-item" href="#">Endocrinology</a>
                  <a class="dropdown-item" href="#">Gastroenterology</a>
                  <a class="dropdown-item" href="#">Geriatrics</a>
                  <a class="dropdown-item" href="#">Hematology</a>
                  <a class="dropdown-item" href="#">Microbiology </a>
                  <a class="dropdown-item" href="#">neurology</a>
                  <a class="dropdown-item" href="#">Radiobiology</a>
                </div>

            </li> -->
            <!-- <li class="nav-item">
              <a id="upload" class="navbar-brand dark-icon no-pad-l no-pad-r" href="#">
                <i class="flaticon-arrow font-xs"></i>Upload
              </a>
            </li> -->
            <!-- <li class="nav-item btn-group">
              <a class="navbar-brand dark-icon dropdown-toggle-split no-pad-l no-pad-r" data-toggle="dropdown">
                <i class="flaticon-button-of-three-vertical-squares font-xs" ></i>
              </a>
                <div class="dropdown-menu dropdown-menu-right" style="top:49px;">
                  <a class="dropdown-item" href="#">Update Profile</a>
                  <a class="dropdown-item" href="#">Add Family Member</a>
                  <a class="dropdown-item" href="#">Clinical Record</a>
                  <a class="dropdown-item" href="#">Subscriptions</a>
                  <a class="dropdown-item" href="#">Privacy Policy</a>
                  <a class="dropdown-item" href="#">Terms and Conditions</a>
                  <a class="dropdown-item" href="#">Support</a>
                  <a class="dropdown-item" href="#">FAQs</a>
                  <a class="dropdown-item" href="#">Sign Out</a>
                </div>

            </li> -->
            <!-- <li class="nav-item active no-pad-l no-pad-r">
              <a class="nav-link" href="#" style="padding-left: 5px  !important;">SIGN IN</a>
            </li> -->
          </ul>
        </div>
      <!-- End of Links -->
    </div>
  </nav>
  <!-- End of Navigation Bar -->
  <!-- Main Body -->
  <div class="container-fluid" style="height: calc(100vh - 62px);">
    <div class="row" style="height:100%">
      <!-- Side Menu -->
      <div class="hide" id="side-menu" >
        <div class="container-fluid" style="overflow-x: hidden;">
          <div class="row">
            <a href="./" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-home font-s pad" ></i>Home</div></a>
          </div>
          <!-- <div class="row">
            <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-increasing-chart font-s pad" ></i>Uploaded</div></a>
          </div>
          <div class="row">
            <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-open-book font-s pad" ></i>Send</div></a>
          </div>
          <div class="row">
            <div class="col-12 menu-separator"></div>
          </div>
          <div class="row">
            <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-history font-s pad" ></i>History</div></a>
          </div>
          <div class="row">
            <a href="#" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-mail font-s pad" ></i>Connect</div></a>
          </div>
          <div class="row">
            <a href="download.php" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-computer font-s pad" ></i>Browse Files</div></a>
          </div> -->
          <div class="row">
            <div class="col-12 menu-separator"></div>
          </div>
          <div class="row">
            <a href="about.php" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-settings-gears font-s pad" ></i>About Us</div></a>
          </div>
          <div class="row">
            <a href="help.php" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-help-web-button font-s pad" ></i>Help</div></a>
          </div>
          <div class="row">
            <a href="mailto:engineeraccidental@gmail.com?Subject=fZend:%20Feedback" target="_blank" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-speech-bubble-with-text-lines font-s pad" ></i>Feedback</div></a>
          </div>
          <div class="row">
            <div class="col-12 menu-separator"></div>
          </div>
          <div class="row">
            <div class="col-12 font-xs" style="line-height:50px;min-width:240px;text-align:center;color:rgba(100,100,100,0.3);">&copy; 2018 AE(fZend) </div>
          </div>
        </div>
      </div>
      <!-- End of Side Menu -->
      <div class="wide" id="container-vid" style="overflow-x: hidden;">
        <div id="body">
          <div>
            <h2>fZend : To get started</h2>
          </div>
        <p>
          fZend is a free product and is the created by Accidental Engineer.
To start transfer of files run the fZend.exe as Aministrator and enter "start" to create server.
Server will be hosted at http://localhost:8088, you can check it by opening the
address in your web browser. If you are opening http://localhost:8088 for first time, you will be asked for password change, if you want to change password then change it or Skip
to use default password "000000".
        </p>
        <p>**MAKE SURE THAT THAT YOU FIREWALL IS OFF**<br>
Then connect your device with other device on network (either WIFI or LAN).
Check out your IP address of your device on which the server is running. In fZend command line type "show-ip" to get the ip address of your device.
Assume that IP address is 192.168.XXX.XXX then type http://192.168.XXX.XXX:8088 in the
browser. To send multiple files select all files you want to send using clt or shift key and then click on send.</p>
        <p>It has been developed through GitHub. And if someone is interested in designing, development and content management, he can contact the developers or he can look for <a href = "https://github.com/Accidental-Engineer">Accidental-Engineer</a> on GitHub.
        </p>
        <div>
          <h3>Shutting down the server</h3>
        </div>
        <p>To shut down the server run the fZend.exe as Aministrator and press 2.
        </p>

        <div>
        </div>
        <p>The authors were trying to make the best product so they
cannot be held responsible for any type of damage or
problems caused by using this or another software.
        </p>
        <p style="width:100%;font-size:12px;color:#888;text-align:center;">Copyright 2018-2019 Accidental Engineer
All rights reserved.</p>

      </div>

      </div>
  </body>
</html>
<?php }
else {
  ob_start();
  header('Location: ./');
  ob_end_flush();
  die();
}
 ?>
