<?php
$conn_error='Error Occured';
$conn=mysql_connect('localhost:3313','root','root');
$db_selected = mysql_select_db('records', $conn);
//$connect = new mysqli('localhost', 'root', 'root', 'records','3313');

if(!$conn ){
  echo "Error : Mysql error , Concact fZend Author or E-mail at engineeraccidental@gmail.com<br>";
}
?>
