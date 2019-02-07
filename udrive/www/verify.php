<?php
include "./conn.php";
session_start();


if ($_SERVER['REMOTE_ADDR']=="127.0.0.1") {
  $_SESSION['server'] = 1;
  $_SESSION['skip'] = 0;
  $q_def = "SELECT default_pass as def FROM server ";
  $def = mysql_query($q_def);
  $time= date('Y-m-d H:i:s' ,time());
  $q_update_online_status = "UPDATE server SET online = '$time' ";
  $update = mysql_query($q_update_online_status);
  $default = $def_val['def'];
}
else {
  $_SESSION['server'] = 0;
  $u_ip=$_SERVER['REMOTE_ADDR'];
  $user = "SELECT * FROM user WHERE `ip` = '$u_ip'";
  $u = mysql_query($user);
  $u_r = mysql_fetch_assoc($u);
  $Found = 0;
  if($u_r) {
      $Found = 1;
  }
  if ($Found == 0) {
    $_SESSION['new_user'] = 1;
    $_SESSION['ip'] = $u_ip;
  }
  else if ( $Found == 1 ) {
    $_SESSION['new_user'] = 0;
    if ($u_r['auth'] == 0) {
      $_SESSION['new_pass']= 1;
    }
  }
}

?>
