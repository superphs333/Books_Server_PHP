<?php
/*
Function
*/
// 알림 전송
function send_alarm($data){
    global $data;

    // 세션을 초기화하고 다른 Curl함수에 전달 할 수 있는 Curl핸들을 반환한다
    $ch = curl_init("https://fcm.googleapis.com/fcm/send");

    $header = array("Content-Type:application/json", "Authorization:key=AAAAaJ1uhgs:APA91bFFrgsrQi45vdeFlLseuEqlOH-tSnplk7kcgl6-gpFZfmvDvjc7cC_yXY9nFthWCCwQol5fR9qFZQBpHNT2ilTGI8-4SjgPGl_gzDBmVdu7YfS7xCRhoDi8VHQzC_Im_CnA9Jom");

    // curl 옵션
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // curl 세션 시작
    curl_exec($ch);

    // curl 세션 종료
    curl_close($ch);
}

?>


