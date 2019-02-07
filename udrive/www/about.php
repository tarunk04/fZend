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
            <a href="share.php" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-share-connection-sing font-s pad" ></i>Share Hub</div></a>
          </div>
          <?php if ($_SESSION['server'] == 1):?>
          <div class="row">
            <a href="./index.php?request=change_password" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-key font-s pad" ></i>Change password</div></a>
          </div>
          <div class="row">
            <a id="show_request" class="no-style" style="cursor:pointer;" ><div class="col-12 menu-list-item"><i class="flaticon-computer font-s pad" ></i>Incoming Request</div></a>
          </div>
          <?php endif; ?>
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
            <h2>About The Project</h2>
          </div>
        <p>This project is a simple real-time chat-box. It serves the general need of chatting with people of a specific group. It is easy-to-use. It is based on AJAX and jQuery.
        </p><br>
        <p>Basically, the present form of chat-box is available for the students of IIT(ISM) Dhanbad. They can register with their admission
        number and email-id to join the chat going on. The best thing about this chat-box is that  it's interface is very simple and attractive.
         Besides that, there is no room for the
         ads which seem irritating to anybody. In near future, you will also be able to share pictures and videos in the chat-box.</p> <br>

        <p>It has been developed through GitHub. And if someone is interested in designing, development and content management, he can contact the developers or he can look for <a href = "https://github.com/Accidental-Engineer">Accidental-Engineer</a> on GitHub.
        </p><br>
        <p>Our organization, Accidental Engineer, works on various real-world projects based on programming, development and designing skills. Anybody interested to contribute can contact us on Facebook and GitHub.
        </p><br></div>
        <div id="dev">
          <div class="">
            <h2>About The Developers</h2>
          </div>


        <div class="d1"><div class="img"><img src="tarun.jpg" width="100px"></div><div class="d2"><span class="contact">Tarun Kumar</span>, pursuing B.Tech in Petroleum Engineering from IIT(ISM) Dhanbad, is passionate about Web Development and designing. He has good hands at CSS3, PHP and jQuery. His programming skills include C, C++, Python and Java.<br><span class="contact">Contact: tarun12.tarunkr@gmail.com</span></div>
        <br></div>
        <div class="d1"><div class="img"><img src="shivam.jpg" width="100px"></div><div class="d2"><span class="contact">Shivam Kumar</span>, pursuing Integrated M. Tech in Mathematics & Computing from IIT(ISM) Dhanbad, has keen interest in Web Development. He has good hands at JavaScript, PHP and MySQL and programming expertise in C and C++.<br><span class="contact">Contact: skshivam64@gmail.com</span></div>
        </div>
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
