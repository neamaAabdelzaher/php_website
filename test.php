<?php 

include_once('./admin/includes/dbconnect.php');
$sql= "SELECT username FROM users where username = 'neama4'";
$data=$conn->query($sql);
 echo $data->rowCount()

?>