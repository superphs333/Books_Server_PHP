<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$room_idx = $_POST['room_idx'];



// sql
$temp = "SELECT idx, Chatting.login_value, sort, room_idx, content, date, order_tag, members.nickname, members.profile_url FROM Chatting LEFT JOIN members ON Chatting.login_value=members.login_value WHERE room_idx={$room_idx} order by idx asc";
// echo $temp;
$sql = mq($temp);

$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);








?>