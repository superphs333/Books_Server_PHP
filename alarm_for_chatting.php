<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');
include_once('./Function/Function_Group.php');

// 데이터 가져오기
$room_idx = $_POST['room_idx'];
$nickname = $_POST['nickname'];
$sort = $_POST['sort'];
$content = $_POST['content'];
$title = $_POST['title'];
$writer = $_POST['writer'];




// 데이터베이스(Join_Chatting_Room)에서 해당 room_idx에 참가하는 사용자 데이터를 불러온다 -> 배열에 저장
$temp = "SELECT sender_id FROM `Join_Chatting_Room` JOIN `members` ON Join_Chatting_Room.login_value=members.login_value where Join_Chatting_Room.room_idx={$room_idx}";
//echo $temp;
$sql = mq($temp); 
$registration_ids_array = array();
while($row=$sql->fetch_array()){
    array_push($registration_ids_array,$row['sender_id']);
}



// 알림보내기(데이터메세지 형식)
$data = json_encode(array(
    "registration_ids"=>$registration_ids_array,
    "data" => array(
        "sort"   => "For_Chatting",
        "my" => "{$writer}",
        "nickname" => "{$nickname}",
        "category" => "{$sort}",
        "title" => "채팅 메세지 알림",
        "room_idx" => "{$room_idx}",
        "room_title" => "{$title}",
        "message" => "{$nickname} : {$content}",
        "content" => "{$content}")
        ));
send_alarm($data);


?>