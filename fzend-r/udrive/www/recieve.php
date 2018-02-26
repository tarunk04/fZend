<?php
$dir_f = "fZend";
$dir_t = "temp";
$id = 1;
// Open a directory, and read its contents
if (file_exists ( "./fZend/2.e" )) {
    if (is_dir($dir_f)){
      if ($dh = opendir($dir_f)){
        while (($file = readdir($dh)) !== false)  :
          
        if($file != "." && $file != ".."  && $file !=="0.e" && $file !=="1.e" && $file !=="2.e"){?>
          <a id= "<?php echo "l".$id;?>" href="./fZend/<?php echo $file;?>" download>dsfd</a>
          <?php $id++;}
    endwhile;
        }
        closedir($dh);
      }
}
else{
  if (file_exists ( "./temp/1.e" )) {
    if (is_dir($dir_t)){
      if ($dh = opendir($dir_t)){
        while (($file = readdir($dh)) !== false)  :
          ?><?php
        if($file != "." && $file != ".." && $file !=="temp.zip" && $file !=="0.e" && $file !=="1.e"){?>
          <a id= "<?php echo "l".$id;?>" href="./temp/<?php echo $file;?>" download>eee</a>
          <?php $id++;} ?>
    <?php
    endwhile;
        }
        closedir($dh);
      }
  }
  else{
    if (is_dir($dir_t)){
      if ($dh = opendir($dir_t)){
        while (($file = readdir($dh)) !== false)  :
    ?><?php if($file != "." && $file != ".." && $file !=="0.e" && $file !=="1.e"){
      if ($file==="temp.zip") {
        echo "ok";
      }

       $id++;}

    endwhile;
        }
        closedir($dh);
      }
  }
}
rename('./temp/1.e','./temp/0.e');
rename('./fZend/2.e','./fZend/0.e');

?>
