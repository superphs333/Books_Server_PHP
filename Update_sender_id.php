<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$login_value = $_POST['login_value'];
$sender_id = $_POST['sender_id'];

$temp = "UPDATE members SET  sender_id='{$sender_id}' WHERE login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}


?>