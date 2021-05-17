<?php

error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];

// 해당 채팅방 존재여부 확인
$temp = "select idx from Chatting_Room where idx={$idx}";
$sql = mq($temp);
$count = mysqli_num_rows($sql);
if($count==0){
    echo "false";
}else{
    echo "true";
}
?>