<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$title = $_POST['title'];
$room_explain = $_POST['room_explain'];
$total_count = $_POST['total_count'];
$leader = $_POST['leader'];


// 받아온 데이터 토대로 저장
$temp = "INSERT INTO Chatting_Room(title, room_explain, total_count, leader) VALUES('{$title}','{$room_explain}',{$total_count},'{$leader}')";
$sql = mq($temp);
if($sql){

    echo "success§";
    // 저장한 데이터의 idx가져오기

    $temp = "select idx from Chatting_Room ORDER BY idx DESC limit 1";
    $sql = mq($temp);
    $row = $sql->fetch_array();
    $idx = $row['idx'];
    echo $idx."§";

    // Join_Chatting_Room에 저장
    $temp = "INSERT INTO Join_Chatting_Room(login_value,room_idx,status) VALUES('{$leader}',{$idx},'1')";
    $sql = mq($temp);
    if($sql){ // 성공
    }else{   // 실패
        echo mysqli_error($db);
    }
}else{   
    echo mysqli_error($db);
}





?>