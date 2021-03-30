<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];


$temp = "DELETE FROM `Chatting_Room` WHERE idx={$idx}";

// + 이 채팅방에 포함되어 있는 사람 모두 나가기.

$sql = mq($temp);
if($sql){
    echo "success";

    // 이 채팅방에 포함되어 있는 사람 나가게 하기
}else{   
    echo mysqli_error($db);
}






?>