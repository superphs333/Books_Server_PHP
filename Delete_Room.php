<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');
include_once('./Function/Function_Group.php');


// 데이터 받아오기
$room_idx = $_POST['room_idx'];

// 데이터 삭제
$temp = "DELETE FROM Chatting_Room WHERE idx={$room_idx}";
$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}




?>