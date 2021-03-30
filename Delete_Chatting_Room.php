<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];


$temp = "DELETE FROM `Chatting_Room` WHERE idx={$idx}";



$sql = mq($temp);
if($sql){
    echo "success§";

    // 이 채팅방에 포함되어 있는 사람 나가게 하기(마지막 남은 1인) - Delete
    $temp = "DELETE FROM Join_Chatting_Room WHERE room_idx={$idx}";
    $sql = mq($temp);
    if($sql){
        echo "success";
    }else{   
        echo mysqli_error($db);
    }
}else{   
    echo mysqli_error($db);
}






?>