<?php
//<!-- fZend Beta 1.0.1 -->
require_once('./res/pclzip.lib.php');
include "./verify.php";

$dir = "./share/";
$files = array();
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    $img =array("jpg", "jpeg", "png", "gif", "svg", "bmp", "tiff", "webp", "exif","psd","tga","tif","dds","yuv","ps","eps","ai");
    $vid =array("mp4", "3gp", "mov", "avi", "mwv", "mpeg", "mpg", "flv", "ogg" ,"vob" ,"mkv","webm","asf", "mpv", "m4p","qt","mxf","webm","m4v","swf","srt");
    $comp = array("arc","arj","as","b64","btoa","bz","cab","cpt","gz","hqx","iso","mim","mme","pak","pf","rar","rmp","sea","sit","sitx","tbz","tbz2","tgz","uu","uue","z","zip","zipx","zoo");
    $doc = array("ppt","pptx","pdf","txt","rtf","odt","xls","xlsx","ods","doc","docx","log","msg","tex","csv","dat","key","xml","sdf","xlr");
    $music = array("aif","iff","m3u","m4a","mid","mp3","mpa","wav","wma");
    $exclude = array("php","html","css","js","sql");
    while (($file = readdir($dh)) !== false){

      if ($file != "." && $file != ".." ) {
        //echo "filename:" . $file . "<br>";
        //$files .= '{"name":"'.$file.'","size":"';
        $size = filesize($dir.$file);
        //echo $size."<br>";
        if ($size < 1024) {
          $size = number_format($size,1,".",'')." Bytes";
        }else if($size>=1024 && $size<1048576){
          $size = number_format($size/1024,1,".",'')." KB";
        }else if($size>1048576){
          $size = number_format($size/(1024*1024),1,".",'')." MB";
        }
        //$files .= $size.'","ext":"';
        $extension = strtolower(substr($file , strrpos($file, '.') + 1));
        //$files .= $extension.'"},';

        $file_o->name = $file;
        $file_o->size = $size;
        $file_o->ext = $extension;
        if (in_array($extension, $img)){
          //echo "nj";
          $file_o->loc = $dir.$file;
        }
        else{
          $file_o->loc = "images/doc.png";
        }
        $json = json_encode($file_o);
        array_push($files,$json);
      }
    }
    closedir($dh);
  }
  $files = json_encode($files);
  $files = json_decode($files);
  // print_r($files);
  //$files .= ']';

}

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
      <title>fZend: Share Hub</title>
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
      <link rel="stylesheet" href="./css/share.css">
    <!-- End of Color Theme -->
    <!-- Script -->
    <script>
      $(document).ready(function(){
          $("#menu").click(function(){
            $("#side-menu").fadeToggle(20);
          });
      });

      </script>
  </head>
  <body>
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
              <a class="navbar-brand" id="brand-title" href="./" style="font-family: cursive;">fZend</a>
            </li>
            <!-- End of fZend Tilte -->
          </ul>
        </div>
        <!-- Links -->
          <div class="  col-md-4 col-7" style="padding: 0px;">
            <ul class="navbar-nav " id="links" style="float:right; flex-direction: row;" >
              <li class="nav-item">
                <a class="nav-link" id="brand-title" href="./" style="color: #555;"><i class="flaticon-arrow font-xs"></i>Upload</a>
              </li>
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
        <div class="wide" id="container-vid" style="display: flex;flex-wrap: wrap;align-content: baseline;">
            <!-- <?php $i=1;
            foreach ($files as $file) : $file = json_decode($file);?>
          <a href="./share/<?php// echo $file->name;?>" download>
            <article class="card">
            <header class="card__thumb" style="background-image:url('<?php// echo $file->loc ;?>')">
              <div class="card__category"><?php //echo $file->ext;?></div>
            </header>
            <div class="card__body">

            </div>
            <div class="footer-container">
              <footer class="card__footer">
                <span class="icon ion-clock"></span><div class="marquee"><?php //echo $file->name;?></div>
               </footer>
            </div>

            </article>
          </a>
         <?php endforeach; ?> -->
         <div class="coming_soon">
           <div class="">
             Coming Soon
           </div>
         </div>
        </div>
      </div>
    </div>
    <!-- End of Main Body -->
  </body>
</html>
