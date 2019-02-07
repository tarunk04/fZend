<?php
//<!-- fZend Beta 1.0.1 -->
require_once('./res/pclzip.lib.php');
include "./verify.php";

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

      $q_request = "UPDATE user SET job_error_code = 0 WHERE ip = '$u_ip' ";
      $update = mysql_query($q_request);
      if ($update) {
        echo "ok";
      }
    }
    else if (check == 0) {
      $u_ip=$_SERVER['REMOTE_ADDR'];
      $q_request = "UPDATE user SET job_error_code = 1 WHERE ip = '$u_ip' ";
      $update = mysql_query($q_request);
      if ($update) {
        echo "failed";
      }
    }
    else{
      echo "unknown error";
    }
  }
  }
  else if ($_POST['verify']) {
    $code = $_POST['auth'];
    $ip = $_SESSION['ip'];

    $q = "SELECT * FROM server";
    $server = mysql_query($q);
    $auth = mysql_fetch_assoc($server);
    $auth = $auth['password'];
    if (sha1($code) === $auth) {

      if ($_SESSION['new_pass'] == 1) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $q_update_user = "UPDATE  `user` SET auth = 1 WHERE ip = '$ip' ";
        $server = mysql_query($q_update_user);
      }
      else{
        $q_insert_user = "INSERT INTO `user` (`ip`, `name`, `auth`, `online`) VALUES ( '$ip' , '', '1', CURRENT_TIMESTAMP) ";
        $server = mysql_query($q_insert_user);
      }

      if ($server) {
        $_SESSION['new_user'] = 0;
        $_SESSION['new_pass']= 0;
        ob_start();
        header('Location: '.$_SERVER['PHP_SELF']);
        ob_end_flush();
        die();
      }
    }
    else {
      ob_start();
      header('Location: '.$_SERVER['PHP_SELF']);
      ob_end_flush();
      die();
    }
  }
  // change password ......
  else if ($_POST['change']) {
    if (isset($_POST['pass']) && $_POST['pass'] != "") {
      $pass = $_POST['pass'];
      // $file = fopen("./password/password.php", "w");
      //
      // $set = "<?php \$default = 0; \$skip = 0; \$auth = '".$pass."'; ";
      // fwrite($file, $set);
      // fclose($file);
      $q_update_pass = "UPDATE server SET password = '".sha1($pass)."', default_pass= 0 WHERE name = 'user'";
      $update = mysql_query($q_update_pass);
      $q_user_auth = "UPDATE user SET auth = 0";
      $update1 = mysql_query($q_user_auth);
      if ($update && $update1) {
        ob_start();
        header('Location: '.$_SERVER['PHP_SELF']);
        ob_end_flush();
        die();
      }
    }
    else{
      ob_start();
      header('Location: '.$_SERVER['PHP_SELF']."?required=false");
      ob_end_flush();
      die();
    }
  }
  // end change password ......
  else {
    if ($_SESSION['new_user'] == 1 || ($_SESSION['new_user'] == 0 && $_SESSION['new_pass']== 1)) {
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
    else if (($default == 1 && $_SESSION['server'] == 1 && $_SESSION['skip'] == 0 && !$_POST['skip']) || $_GET['request']=='change_password') {
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
              <?php if (isset($_GET['request']) && $_GET['request'] == 'change_password'): ?>
                <span style="font-size:14px;">Change your password</span>
              <?php else: ?>
              <span style="font-size:14px;">Please change your default password</span>
            <?php endif; ?>
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
      });

      setInterval(function(){
          $.ajax({url: "online.php", success: function(result){
            //console.log(result);
            if ( result != "") {
              //var html =$("#request_body_noti").html();
              //var newhtml = result;
              //newhtml += html;
              //console.log(newhtml);
              $("#request_body_noti").prepend(result);
              $(".request").css("display","flex");
            }
         }});
      },1000);
      </script>
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
            <a class="navbar-brand" id="brand-title" href="./" style="font-family: cursive;"s>fZend</a>
          </li>
          <!-- End of fZend Tilte -->
        </ul>
      </div>
      <!-- Links -->
        <div class="  col-md-4 col-7" style="padding: 0px;">
          <ul class="navbar-nav " id="links" style="float:right; flex-direction: row;" >
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
          </div>-->
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
            <a href="about.php" class="no-style"><div class="col-12 menu-list-item"><i class="flaticon-group font-s pad" ></i>About Us</div></a>
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
          <div class="main_con">
            <div class="bodymaincontainer">
              <div class="bodymainleft bodymain">
              </div>
              <div class="bodymainright bodymain" action="index.php" style="display:block;margin: 10px;">
                <form id="myForm" method="post" enctype="multipart/form-data">
                  <input id="file_select" type="file" name="file[]" style="margin-top: 60px;border: 10px solid beige;width: 80%;" multiple><br>
                  <?php if ($_SESSION['server'] == 1):?>
                    <div style="line-height:16px;padding:10px;">
                      <span style="font-size:12px;color:#777;margin:10px;">Compress all files in zip
                        <input type="checkbox" name="zip" value="zip" checked style="position:relative;top:4px;">
                      </span>
                    </div>
                  <?php endif; ?>
                    <br>
                    <?php if ($_SESSION['server'] == 0): ?>
                      <button class="start" type="button" id="confirm">Send</button>
                    <?php endif; ?>
                      <input <?php if ($_SESSION['server'] == 0){echo 'style="opacity:0; z-index:-10000;"';}?> type="submit" value="Send" id="start">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- End of Upload Form -->
        <!-- frame -->
      <div class="frame" style="display:none;"></div>
    </div>
  </div>
</div>
  <!-- End of Main Body -->
  <!-- SENDING REQUEST TO SERVER-->
  <?php if ($_SESSION['server'] == 0): ?>
  <div class="confirm" >
    <div class="confirm_body">
      <div id="confirm_text" class="confirm_body_sub">
        File is ready to Send<br>
        Waiting for confirmation...
      </div>
      <div class="confirm_body_sub">
        <button type="" id="confirm_button" class="start" name="button" onclick="confirm(this)">Cancel</button>
      </div>
    </div>
  </div>
  <?php endif; ?>
  <!-- SERVER INCOMING REQUEST -->
  <?php if ($_SESSION['server'] == 1): ?>
  <div class="request" >
    <div class="request_body">
      <div class="close_x" onclick="close(this)">
        X
      </div>
      <div  class="request_body_sub font-m" style="text-align:center;margin-top:10px;">
        Incoming Request
      </div>
      <div id="request_body_noti">

      </div>
    </div>
  </div>
  <?php endif; ?>
  <script type="text/javascript">
  //Update progress Bar
    function progressBarUpdate(e , speed , currentPercent){
      e.css("opacity","1");
      e.children('.progress-bar').width(currentPercent+'%');
      e.children('.progress-bar').children('.progressSpeed').text(speed);
    }
  //End of Update progress bar
    function accept(e){
      var ip = $(e).attr("data-ip");
      var i = $(e).attr("data-i");
      var job_id = i[7]+i[8]+i[9]+i[10]+i[11]+i[12];
      //console.log(job_id);
      $.ajax({
        url: "online.php",
        type: "POST",
        data : "accept=1&ip="+ip+"&i="+job_id,
        success : function(result){
          //console.log(result);
          var progressbar = $(".progress[data-ip='"+ip+"'][data-i='"+i+"']");
          //console.log(result);
          progressbar.siblings('button').css("display","none");
          if (result == 1 ) {
            var status = setInterval(function(){
              $.ajax({
                url : "online.php",
                type: "POST",
                data: "status=1&ip="+ip,
                success: function(result){
                  stat = JSON.parse(result)[0];
                  if (stat.percent == 100) {
                    $.ajax({
                      url : "online.php",
                      type: "POST",
                      data: "error=1&ip="+ip+"&i="+job_id,
                      success: function(result){
                        //console.log(result);
                        if (result == 0) {
                          progressbar.children('.progress-bar').css("background","#70ca6b");
                          progressbar.children('.progress-bar').children('.progressSpeed').text("Received Successfuly.");
                          progressbar.children('.progress-bar').children('.progressSpeed').css("color","white");
                          clearInterval(status);
                        }
                        if (result == 1) {
                          progressbar.children('.progress-bar').css("background","#e63030");
                          progressbar.children('.progress-bar').children('.progressSpeed').text("Transfer Unsuccessful. File rejected by server. Please read more in help.");
                          progressbar.children('.progress-bar').children('.progressSpeed').css("color","white");
                          clearInterval(status);
                        }


                      }
                    });

                  }
                  progressBarUpdate(progressbar,stat.speed,stat.percent);

                }
              });
            },400);
          }
          else if( result == 0){
            progressbar.css("opacity","1");
            progressbar.children('.progress-bar').css("background","#e63030");
            progressbar.children('.progress-bar').width('100%');
            progressbar.children('.progress-bar').children('.progressSpeed').text("Request Expired.");
            progressbar.children('.progress-bar').children('.progressSpeed').css("color","white");
          }

          //$(".request_body_sub[data-ip='"+ip+"']").css({"display":"none"});
          //progressbar = $(".progress[data-ip='"+ip+"']");
        }
      });
    }
    function reject(e){
      var ip = $(e).attr("data-ip");
      var i = $(e).attr("data-i");
      $.ajax({
        url: "online.php",
        type: "POST",
        data : "decline=1&ip="+ip,
        success : function(result){
          //console.log(result);
          if (result == 0) {
            //console.log("work");
            $(".request_body_sub[data-ip='"+ip+"'][data-i='"+i+"']").css({"display":"none"});
          }
        }
      });
    }
    var set;
    function confirm(e){
      if(e.innerHTML == "Cancel"){
        $("#file_select").val("");
        $(".confirm").css("display","none");
        $.ajax({
          url: "online.php",
          type: "POST",
          data : "cancel=1",
          success : function(result){
            console.log(result);
          }
        });
        clearInterval(set);
      }
      if (e.innerHTML == "Resend"){
        console.log("ok");
        $("#confirm").click();
      }
      if (e.innerHTML == "Close"){
        $(".confirm").css("display","none");
      }
    }
    //close button function
    $(".close_x").click(function(){
      $(".request").css("display","none");
      //$("#request_body_noti").html("");
    });
    //end of close function
    //show_request
    $("#show_request").click(function(){
      if ($(".request").css("display") != 'flex') {
        $.ajax({url: "online.php",
        type: "POST",
        data : "old=1",
         success: function(result){
           console.log(result);
          if ( result == 1) {
            //$("#request_body_noti").html("");
            $("#side-menu").fadeToggle(20);
            $(".request").css("display","flex");
          }
       }});
      }
    });
    //end of show_request
    var progress;
    var progressbar;
    var progressSpeed;
    var send;
    var d;
    var oldTime;
    var oldpercentComplete;
    var c;
      $("#confirm").click(function(){
        var fp = $("#file_select");
        var lg = fp[0].files.length; // get length
        var items = fp[0].files;
        var json = '[';
        for(var i = 0 ; i < lg ; i++ ){
          var fileName = items[i].name; // get file name
          var fileSize = items[i].size; // get file size
          var fileType = items[i].type; // get file type
          json += '{"name":"'+fileName+'","size":"'+fileSize+'","type":"'+fileType+'"}';
          if (i < lg-1) {
            json+= ',';
          }
        }
        json+=']';
        json = JSON.stringify(JSON.parse(json));
        //console.log(json);
        if ($('#file_select').val() != "") {
          $.ajax({
            url: "online.php",
            type: 'POST',
            data: 'confirm=1&resend=0&data='+json,
            success: function(result){
              if (result == 1) {
                $(".confirm").css("display","flex");
                $("#confirm_text").html("File is ready to Send<br>Waiting for confirmation from receiver...");
                $("#confirm_button").html("Cancel");
                var check = 0;
                set = setInterval(function(){
                  $.ajax({
                    url : "online.php" ,
                    type: "POST",
                    data : "reply=1",
                    success : function(result){
                      console.log(result);
                      if (result == 1) {
                        $(".confirm").css("display","none");
                        $("#myForm").submit();
                        clearInterval(set);
                      }
                      else if (result.trim() == '0') {
                        console.log(result);
                        $("#confirm_text").html("REQUEST REJECTED<br>Request has been declined from receiver side.");
                        $("#confirm_button").html("Close");
                        clearInterval(set);
                      }
                      else {

                      }
                    }
                  });
                  check++;
                  if (check == 600) {
                    $.ajax({
                      url : "online.php" ,
                      type: "POST",
                      data : "confirm=1&resend=1",
                      success : function(result){
                        $("#confirm_text").html("NO RESPONCE<br>No responce from receiver side. Please retry...");
                        $("#confirm_button").html("Resend");
                        clearInterval(set);
                      }
                    });
                  }
                },200);

              }
          }});
        }
        else{
          //console.log("not");
        }
      });
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
            var s;
            if ((position - send )> 0) {
              var speed = (((1*(position - send))/1024)/((n-oldTime)/1000)).toFixed(1) ;
              oldTime = n;
              send = position;
              if ( speed < 1024) {
                s = speed + 'KB/s';
                progressSpeed.text(s);
              }
              else if(speed >= 1024) {
                s = (speed/(1024)).toFixed(1) + 'MB/s';
                progressSpeed.text(s);
              }
            }
            if (percentComplete > oldpercentComplete){
              progressbar.width(percentComplete + '%');
              oldpercentComplete = percentComplete;
              $.ajax({
                url : "online.php" ,
                type: "POST",
                data : "progress=1&speed="+s+"&percentComplete="+oldpercentComplete,
                success : function(result){
                  //console.log(result);
                }
              });
             }
             //console.log("speed="+s+" Percent = "+percentComplete);
           },
           resetForm :true,
           forceSync :true,
           url : 'index.php',
           success:function(responseText) {
            //console.log(responseText);
            if (responseText== "ok"){
              progressSpeed.text("Sent");
              progressSpeed.css("color","#fff");
              progressbar.css("background","#70ca6b");
            }
            else if(responseText== "failed"){
              progressSpeed.text("Failed. File type is not Supported. Please read more in help");
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
