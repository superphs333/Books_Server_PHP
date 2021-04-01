<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

$idx = 16;
/*
state=true -> 대기자들에게 알림 전송
*/
// 세션을 초기화하고 다른 Curl함수에 전달 할 수 있는 Curl핸들을 반환한다
$ch = curl_init("https://fcm.googleapis.com/fcm/send");


// 대상추출
$temp = "SELECT members.sender_id FROM Join_Chatting_Room LEFT JOIN members ON members.login_value=Join_Chatting_Room.login_value WHERE room_idx={$idx} AND status=0";
$sql = mq($temp);
$registration_ids_array = array(); // sender_id를 담을 리스트
while($row=$sql->fetch_array()){
    array_push($registration_ids_array,$row['sender_id']);
}

// title
$temp = "SELECT title FROM Chatting_Room WHERE idx={$idx}";
$sql = mq($temp);
$row = $sql->fetch_array();
$title = $row['title'];
echo $title;


// 알람 보내기(여기서는 데이터메세지 형식으로 보냄)
    /* 형식
    제목 - 알림
    내용 - {title}
    */
$header = array("Content-Type:application/json", "Authorization:key=AAAAaJ1uhgs:APA91bFFrgsrQi45vdeFlLseuEqlOH-tSnplk7kcgl6-gpFZfmvDvjc7cC_yXY9nFthWCCwQol5fR9qFZQBpHNT2ilTGI8-4SjgPGl_gzDBmVdu7YfS7xCRhoDi8VHQzC_Im_CnA9Jom");
$data = json_encode(array(
    "registration_ids"=>$registration_ids_array,
    "data" => array(
        "sort"   => "For_chatting_room_waiting_list",
        "idx" => "{$idx}",
        "title" => "알림",
        "message" => "채팅방 : {$title}에 방금 자리가 났습니다!")
        ));

// curl 옵션
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// curl 세션 시작
curl_exec($ch);

// curl 세션 종료
curl_close($ch);
?>