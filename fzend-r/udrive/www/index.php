<?php
include "./password/password.php";
require_once('./res/pclzip.lib.php');
include "verify.php";


  if (isset($_FILES['file']['name'])) {
    if ($_SESSION['server']==1) {
        if ($_POST['zip'] == "zip") {
          rename('./fZend/1.e','./fZend/0.e');
          rename('./fZend/2.e','./fZend/0.e');
        }
        else {
          rename('./fZend/0.e','./fZend/1.e');
          rename('./fZend/2.e','./fZend/1.e');
        }
        $tempLocation = "./fZend/";

        $dir = "./fZend/";
        if (is_dir($dir)){
          if ($dh = opendir($dir)){
            while (($file = readdir($dh)) !== false){
              if ($file !== "0.e" && $file !== "1.e" && $file !== "2.e") {
                unlink($dir.$file);
              }
            }
            closedir($dh);
          }
        }

        $total = count($_FILES['file']['name']);
        $check = 0;
        for ($i=0; $i <$total ; $i++) {
        if (!empty($_FILES['file']['name'])) {
            $name = $_FILES['file']['name'][$i];
            $size = $_FILES['file']['size'][$i];
            $type = $_FILES['file']['type'][$i];
            $extension = strtolower(substr($name , strrpos($name, '.') + 1));
            $temp_name = $_FILES['file']['tmp_name'][$i];
            if(move_uploaded_file($temp_name,$tempLocation.$name)){
              $check = 1;
            }
            else {
              $check = 0;
            }
          }
        }
        if($check == 1){
          echo "ok";
          if ($_POST['zip'] != "zip") {
            rename('./fZend/1.e','./fZend/2.e');
          }
        }
        else {
          echo "failed";
        }
        if ($_POST['zip'] == "zip") {
          unlink('./fZend/0.e');
          $dir = "./fZend/";
          $zip = new PclZip('./temp/temp.zip');
          $files_archive =   $zip->create($dir);
          if ($files_archive == 0) {
              die("Error : ".$archive->errorInfo(true));
          }
          else{
              unlink('./temp/fZend.zip');
              rename('./temp/temp.zip','./temp/fZend.zip');
              rename('./temp/0.e','./temp/1.e');
          }
          $dir = "./fZend/";
          if (is_dir($dir)){
            if ($dh = opendir($dir)){
              while (($file = readdir($dh)) !== false){
                if ($file !== "0.e" && $file !== "1.e" && $file !== "2.e") {
                  unlink($dir.$file);
                }
              }
              closedir($dh);
            }
          }
          $myfile = fopen("./fZend/0.e", "w");
          fclose($myfile);
      }
    }

    else{
    $baseLocation = "./received/";
    $total = count($_FILES['file']['name']);
    $check = 0;
    for ($i=0; $i <$total ; $i++) {
    if (!empty($_FILES['file']['name'])) {
      $img =array("jpg", "jpeg", "png", "gif", "svg", "bmp", "tiff", "webp", "exif","psd","tga","tif","dds","yuv","ps","eps","ai");
      $vid =array("mp4", "3gp", "mov", "avi", "mwv", "mpeg", "mpg", "flv", "ogg" ,"vob" ,"mkv","webm","asf", "mpv", "m4p","qt","mxf","webm","m4v","swf","srt");
      $comp = array("arc","arj","as","b64","btoa","bz","cab","cpt","gz","hqx","iso","mim","mme","pak","pf","rar","rmp","sea","sit","sitx","tbz","tbz2","tgz","uu","uue","z","zip","zipx","zoo");
      $doc = array("ppt","pptx","pdf","txt","rtf","odt","xls","xlsx","ods","doc","docx","log","msg","tex","csv","dat","key","xml","sdf","xlr");
      $music = array("aif","iff","m3u","m4a","mid","mp3","mpa","wav","wma");
      $exclude = array("php","html","css","js","sql");

        $name = $_FILES['file']['name'][$i];
        $size = $_FILES['file']['size'][$i];
        $type = $_FILES['file']['type'][$i];
        $extension = strtolower(substr($name , strrpos($name, '.') + 1));
        $temp_name = $_FILES['file']['tmp_name'][$i];
        if(in_array($extension, $img)){
          if(move_uploaded_file($temp_name,$baseLocation."images/".$name)){
          $check = 1;
          }
          else {
            $check = 0;
          }
        }
        else if (in_array($extension, $vid) ) {
          if(move_uploaded_file($temp_name,$baseLocation."videos/".$name)){
            $check = 1;
            }
            else {
              $check = 0;
            }
        }
        else if (in_array($extension, $music) ) {
          if(move_uploaded_file($temp_name,$baseLocation."music/".$name)){
            $check = 1;
            }
            else {
              $check = 0;
            }
        }
        else if (in_array($extension, $comp) ) {
          if(move_uploaded_file($temp_name,$baseLocation."compressed/".$name)){
            $check = 1;
            }
            else {
              $check = 0;
            }
        }
        else if (in_array($extension, $doc) ) {
          if(move_uploaded_file($temp_name,$baseLocation."documents/".$name)){
            $check = 1;
            }
            else {
              $check = 0;
            }
        }
        else if (in_array($extension, $exclude) == false ) {
          if(move_uploaded_file($temp_name,$baseLocation."others/".$name)){
            $check = 1;
            }
            else {
              $check = 0;
            }
        }
      }
    }
    if($check == 1){
      echo "ok";
    }
    else {
      echo "failed";
    }
  }
  }
  else if ($_POST['verify']) {
    $code = $_POST['auth'];
    $_SESSION['new_user'] = 0;
    $ip = $_SESSION['ip'];

    // $dir = "./password/";
    // if (is_dir($dir)){
    //   if ($dh = opendir($dir)){
    //     while (($file = readdir($dh)) !== false){
    //       if($file != "." && $file != ".."){$auth = $file;
    //         // echo $file;
    //       }
    //     }
    //     closedir($dh);
    //   }
    // }

    if ($code === $auth) {
      $file = fopen("./user/user.txt", "a");
      $Arr = array($ip=>"1");
      $userJSON = json_encode($Arr);
      fwrite($file, $userJSON."\n");
      fclose($file);
      ob_start();
      header('Location: '.$_SERVER['PHP_SELF']);
      ob_end_flush();
      die();
    }
    else {
      ob_start();
      header('Location: '.$_SERVER['PHP_SELF']);
      ob_end_flush();
      die();
    }
  }
  else if ($_POST['change']) {
    if (isset($_POST['pass']) && $_POST['pass'] != "") {
    $file = fopen("./password/password.php", "w");
    $pass = $_POST['pass'];
    $set = "<?php \$default = 0; \$skip = 0; \$auth = '".$pass."'; ?>";
    fwrite($file, $set);
    fclose($file);
    ob_start();
    header('Location: '.$_SERVER['PHP_SELF']);
    ob_end_flush();
    die();
    }
    else{
      ob_start();
      header('Location: '.$_SERVER['PHP_SELF']."?required=false");
      ob_end_flush();
      die();
    }
  }
  else {
    if ($_SESSION['new_user'] == 1) {
      ?>
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
      </head>
      <body>
        <div class="container-fluid" style="background:#111">
          <div  style="overflow: hidden;width:100%;height:100%; display:flex;justify-content:center;align-items: center;flex-direction: column;align-content: space-around;">
            <div style="text-align:center;height:200px;color:#dcffd3;font-size:20px;">
              <img src="./images/icon.png" style="width:30%;"><br>
              fZend<br>
              <span style="font-size:14px;">Please authenticate to continue . . .</span>
            </div>
            <div>
              <form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-top:0px;">
                <span style="color:#888">Password : </span>
                <input type="password" name="auth" style="width: 60%;text-align: center;" required><br>
                <input type="submit" name="verify" value="Verify" id="auth">
              </form>
            </div>
          </div>
        </div>
      </body>
    </html>
      <?php
    }
    else if ($default == 1 && $_SESSION['server'] == 1 && $_SESSION['skip'] == 0 && !$_POST['skip']) {
      ?>
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
      </head>
      <body>
        <div class="container-fluid" style="background:#111">
          <div  style="overflow: hidden;width:100%;height:100%; display:flex;justify-content:center;align-items: center;flex-direction: column;align-content: space-around;">
            <div style="text-align:center;height:200px;color:#dcffd3;font-size:20px;">
              <img src="./images/icon.png" style="width:30%;"><br>
              fZend<br>
              <span style="font-size:14px;">Please change you default password</span>
            </div>
            <div>
              <form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-top:0px;">
                <span style="color:#888">New password : </span>
                <input type="password" name="pass" style="width: 60%;text-align: center;" placeholder="<?php if($_GET['required']=="false"){echo "Required Field..";}?>"><br>
                <input type="submit" class="button" name="change" value="Change" id="change">
                <input type="submit" class="button" name="skip" value="Skip" id="skip" style="margin:0px;">
              </form>
            </div>
          </div>
        </div>
      </body>
    </html>

      <?php
    }
    else {
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
  <body>
    <?php if($_SESSION['server'] == 0):?>
      <div class="container-fluid selector-container" >
        <div class="selector" >
          <div class="select" id="send">
            SEND
          </div>
          <div class="select" id="receive" style="transition:transform 0.3s;">
            RECEIVE
          </div>
          <div  id="back" style="transition:transform 0.3s;color:#white;display:none">
            <a href="./" style="text-decoration:none;color: beige;">Back</a>;
          </div>
        </div>
      </div>
      <script >
      $(document).ready(function(){
        $("#send").click(function(){
          //$(".selector-container").css("display","none");
          $(".selector-container").animate({opacity : "0"},200,function(){
            $(".selector-container").css("display","none");
          });
        });
        $("#receive").click(function(){
          $("#send").animate({opacity : "0"},300);
          $("#receive").css({"transform":"translateY(-110px)"});
          $("#back").css({"transform":"translateY(-90px)"});
          $("#receive").html("Waiting . . .");
          $("#back").css("display","block");
          var i=1;
          var e=0;
          var ready=0;
          var check = setInterval(function(){

            if( $("a[id='l"+i+"']").length == 1 ){
                $("#receive").html("Downloading . . .");
                $("a[id='l"+i+"']")[0].click();
                i++;
              }
            else if($("a[id='l"+i+"']").length == 0 && i>1) {
                console.log($("a[id='l"+i+"']").length);
                clearInterval(check);
             }
             else {
               if (ready == 1) {

                   if (e == 0) {
                     $("#receive").html("Getting your file ready .&nbsp;&nbsp;&nbsp;&nbsp;");
                      e++;
                   }
                   else if (e == 1) {
                     $("#receive").html("Getting your file ready . .&nbsp;&nbsp;");
                     e++;
                   }
                   else if (e == 2) {
                     $("#receive").html("Getting your file ready . . .");
                     e=0;
                   }

               }
               else{
               if (e == 0) {
                 $("#receive").html("Waiting .&nbsp;&nbsp;&nbsp;&nbsp;");
                  e++;
               }
               else if (e == 1) {
                 $("#receive").html("Waiting . .&nbsp;&nbsp;");
                 e++;
               }
               else if (e == 2) {
                 $("#receive").html("Waiting . . .");
                 e=0;
               }
             }

             $.ajax({url: "recieve.php", success: function(result){
                console.log(result);
               if (result!="ok") {
                 $(".frame").html(result);
               }
               else if (result=="ok") {
                 ready=1;
               }
            }});
            }

            },1000);
        });
      });

      </script>
    <?php endif; ?>
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
            <a href="help.pph" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-help-web-button font-s pad" ></i>Help</div></a>
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
      <div class="wide" id="container-vid" style="overflow: hidden;">
        <!-- Progress Bar -->
        <div class="progress" style="opacity:0;text-align:center;color:#ccc;">
        	<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;background: #ff9d17;">
            <div class="progressSpeed">
              0KB/s
            </div>
				  </div>

				</div>
        <!-- End of Progress Bar -->
        <!-- Upload Form -->
        <div class="body">
          <div class="container vid-row" style="margin-top: 20px;display: flex;justify-content: center;flex-direction: column;flex-wrap: wrap;align-items: center;" >
          <div class="upperheader">
            <h1 style="color: #666;font-weight:400;">Send files</h1>
          </div>
          <div>
            <div class="bodymaincontainer">
              <div class="bodymainleft bodymain">
              </div>
              <div class="bodymainright bodymain" action="index.php" style="display:block;margin: 10px;">
                <form id="myForm" method="post" enctype="multipart/form-data" >
                  <input type="file" name="file[]" style="margin-top: 60px;border: 10px solid beige;width: 80%;" multiple><br>
                  <?php if ($_SESSION['server'] == 1):?>
                    <div style="line-height:16px;padding:10px;">
                      <span style="font-size:12px;color:#777;margin:10px;">Compress all files in zip
                        <input type="checkbox" name="zip" value="zip" checked style="position:relative;top:4px;">
                      </span>
                    </div>
                  <?php endif; ?>
                    <br>
                  <input type="submit" value="Send" id="start">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- End of Upload Form -->
        <!-- frame -->
      <div class="frame" style="display:none"></div>
    </div>
  </div>
</div>
  <!-- End of Main Body -->

  <script type="text/javascript">
    var progress;
    var progressbar;
    var progressSpeed;
    var send;
    var d;
    var oldTime;
    var oldpercentComplete;
    var c;

       $("#myForm").ajaxForm(
         {
          type : "POST",
          beforeSend: function() {
            progress = $(".progress");
            progressbar     = $('.progress-bar');
            progressSpeed     = $('.progressSpeed');
            send = 0;
            d = new Date();
            oldTime = d.getTime();
            oldpercentComplete =0;
            c = 0;
            progress.css("opacity","1");
            progressSpeed.css("color","#555");
            progressbar.css("background","#ff9d17");
            progressbar.width('0%');
            progressSpeed.text('0%');
          },
          uploadProgress: function (event, position, total, percentComplete) {
            var time = new Date();
            var n = time.getTime();
            if ((position - send )> 0 && c % 2 ==0) {
              var speed = (((1*(position - send))/1024)/((n-oldTime)/1000)).toFixed(1) ;
              oldTime = n;
              send = position;
              if ( speed < 1024) {
               progressSpeed.text(speed + 'KB/s');
              }
              else if(speed >= 1024) {
               progressSpeed.text((speed/(1024)).toFixed(1) + 'MB/s');
              }
            }
            if (percentComplete > oldpercentComplete){
              progressbar.width(percentComplete + '%');
              oldpercentComplete = percentComplete;
             }
             c++;
           },
           resetForm :true,
           forceSync :true,
           url : 'index.php',
           success:function(responseText) {
            console.log(responseText);
            if (responseText== "ok"){
              progressSpeed.text("Sent");
              progressSpeed.css("color","#fff");
              progressbar.css("background","#70ca6b");
            }
            else if(responseText== "ok"){
              progressSpeed.text("Failed");
              progressSpeed.css("color","#fff");
              progressbar.css("background","#ff5b29");
            }
            else {
              progressSpeed.text("Please select a file.");
              progressSpeed.css("color","#fff");
              progressbar.css("background","#ff5b29");
            }
          }
        });
    </script>
  </body>
</html>
<?php } }?>
