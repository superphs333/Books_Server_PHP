<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];
$title = $_POST['title'];
$room_explain = $_POST['room_explain'];
$total_count = $_POST['total_count'];

$temp = "UPDATE `Chatting_Room` SET `title`='{$title}',`room_explain`='{$room_explain}',`total_count`={$total_count} WHERE idx={$idx}";

$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}






?>