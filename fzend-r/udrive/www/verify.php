<?php
session_start();
if ($_SERVER['REMOTE_ADDR']=="127.0.0.1") {
  $_SESSION['server'] = 1;
  $_SESSION['skip'] = 0;
}
else {
  $_SESSION['server'] = 0;
  $Found = 0;
  $user=$_SERVER['REMOTE_ADDR'];
  $users = fopen("./user/user.txt", "r");
  while(!feof($users)) {
    $obj=json_decode(fgets($users));
    if ($obj->$user){
      $Found = 1;
      //echo "test";
    }
  }
  fclose($users);
  if ($Found == 0) {
    $_SESSION['new_user'] = 1;
    $_SESSION['ip'] = $user;
  }
  else if ( $Found == 1 ) {
    $_SESSION['new_user'] = 0;
  }
}

 ?>
