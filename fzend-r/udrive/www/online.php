<?php
include "./conn.php";
if (isset($_POST['confirm'])) {
  $ip = $_SERVER['REMOTE_ADDR'];
  $i = rand(100000,999999);
  //$data = json_decode(str_replace("\\","",$_POST['data']));

  $data = $_POST['data'];
  $resend = $_POST['resend'];
  if ($resend == 0) {
    $q_update_request = "UPDATE user SET request = 1, request_data = '$data' , request_time = CURRENT_TIMESTAMP, job_id = $i , job_error_code = -1 WHERE ip = '$ip' ";
  }
  else if ($resend == 1){
    $q_update_request = "UPDATE user SET request = 0 , job_id = 0 WHERE ip = '$ip' ";
  }

  $update = mysql_query($q_update_request);
  if ($update) {
    echo "1";
  }
  else{
    echo "0";
  }
}
elseif (isset($_POST['reply'])) {
  $u_ip=$_SERVER['REMOTE_ADDR'];
  $q_ok = "SELECT * FROM user WHERE ip = '$u_ip' ";
  $update = mysql_query($q_ok);
  $u_r = mysql_fetch_assoc($update);
  if ($u_r['request']==2) {
    echo "1";
  }
  if ($u_r['request']==0) {
    echo "0";
  }
}
else if (isset($_POST['cancel'])){
  $u_ip=$_SERVER['REMOTE_ADDR'];
  $q_cancel_request = "UPDATE user SET request = 0,job_id = 0  WHERE ip = '$u_ip' ";
  $update = mysql_query($q_cancel_request);
  if ($update) {
    echo "cancled";
  }
}
else if (isset($_POST['old'])){
  $q_request = "UPDATE user SET request = 1 WHERE request = 3 ";
  $update = mysql_query($q_request);
  if ($update) {
    echo "1";
  }
}
else if (isset($_POST['accept'])){
  $ip = $_POST['ip'];
  $job_id = $_POST['i'];
  $reset = '[{"speed":"0KB/s","percent":"0"}]';

  $q_request_verify = "SELECT * FROM user WHERE ip = '$ip' and  job_id = $job_id";
  $rows = mysql_query($q_request_verify);
  if ( mysql_fetch_assoc($rows)) {
    $q_request = "UPDATE user SET request = 2, progress = '$reset' WHERE request = 3 and ip= '$ip' and job_id = $job_id ";
    $update = mysql_query($q_request);
    if ($update) {
      echo "1";
    }
  }
  else {
    echo "0";
  }

}
else if (isset($_POST['status'])) {
  $ip = $_POST['ip'];
  $q_ok = "SELECT * FROM user WHERE ip = '$ip' ";
  $update = mysql_query($q_ok);
  $u_r = mysql_fetch_assoc($update);
  echo $u_r['progress'];
}
else if (isset($_POST['decline'])){
  $ip = $_POST['ip'];
  $q_request = "UPDATE user SET request = 0, job_id = 0  WHERE request = 3 and ip= '$ip' ";
  $update = mysql_query($q_request);
  if ($update) {
    echo "0";
  }
}
else if (isset($_POST['progress'])) {
  $u_ip=$_SERVER['REMOTE_ADDR'];
  $speed = $_POST['speed'];
  $percent = $_POST['percentComplete'];
  echo $speed.' '.$percent;
  $json = '[{"speed":"'.$speed.'","percent":"'.$percent.'"}]';
  $q_progress = "UPDATE user SET progress = '$json' WHERE request = 2 and ip= '$u_ip' ";
  $changed = mysql_query($q_progress);
}
else if (isset($_POST['error'])) {
  $ip = $_POST['ip'];
  $job_id = $_POST['i'];
  $q_ok = "SELECT * FROM user WHERE ip = '$ip' and job_id = $job_id ";
  $update = mysql_query($q_ok);
  $u_r = mysql_fetch_assoc($update);
  echo $u_r['job_error_code'];
}
else{
  if ($_SERVER['REMOTE_ADDR']=="127.0.0.1") {
    $time= date('Y-m-d H:i:s' ,time());
    $q_update_online_status = "UPDATE server SET online = '$time' ";
    $update = mysql_query($q_update_online_status);

    $q_request = "SELECT * FROM user WHERE request = 1 ";
    $requests = mysql_query($q_request);

    $q_request_r = "UPDATE user SET request = 3 WHERE request = 1 ";
    $changed = mysql_query($q_request_r);

    $i = 0 ;

    while ($row = mysql_fetch_assoc($requests)):
      $data = json_decode($row['request_data']);
      $i = $row['job_id'];
      ?>
      <div data-ip="<?php echo $row['ip']; ?>" class="request_body_sub grad_background" data-i="#detail<?php echo $i;?>">
        <div class="info">
          <?php echo $row['ip']; ?>
        </div>
        <div id="detail<?php echo $i;?>" class="detail collapse">
          <?php foreach ($data as $index => $d):?>
            <span class="size1"><?php echo $d->name; ?></span><span class="size2"><?php if ($d->size < 1024) { echo number_format($d->size,1,".",'')." Bytes";}elseif ($d->size>=1024 && $d->size<1048576) {echo number_format($d->size/1024,1,".",'')." KB";}elseif ($d->size>=1048576) {echo number_format($d->size/(1024*1024),1,'.','')." MB";} ?></span><span class="size3"><?php echo $d->type; ?></span>
          <?php endforeach; ?>
        </div>
        <span class="read_more" data-toggle="collapse" data-target="#detail<?php echo $i;?>" >Details</span>
        <div class="request_responce" style="position: relative;">
          <button data-ip="<?php echo $row['ip']; ?>" onclick="accept(this)" data-i="#detail<?php echo $i;?>" class="request_button" type="button" name="button">Accept</button>
          <button data-ip ="<?php echo $row['ip']; ?>" onclick="reject(this)" data-i="#detail<?php echo $i;?>" class="request_button" type="button" name="button">Decline</button>
          <!-- Progress Bar -->
          <div class="progress" data-ip="<?php echo $row['ip']; ?>" data-i="#detail<?php echo $i;?>" style="opacity:0;text-align:center;color:#ccc;">
          	<div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;background: #ff9d17;">
              <div class="progressSpeed" style="min-width: 100% !important;">
                0KB/s
              </div>
  				  </div>
  				</div>
          <!-- End of Progress Bar -->
        </div>
      </div>
    <?php endwhile;
  }else {
    $time= date('Y-m-d H:i:s' ,time());
    $u_ip=$_SERVER['REMOTE_ADDR'];
    $q_update_online_status = "UPDATE user SET online = '$time' WHERE ip = '$u_ip' ";
    $update = mysql_query($q_update_online_status);
    if ($update) {
       //echo 12;
    }
  }
}

?>
