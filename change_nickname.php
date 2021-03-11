<?php
/*
닉네임 변경

post)
login_value -> 멤버 특정값
change_nickname -> 변경 닉네임

echo)
success -> 성공
그외 -> 실패
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 받은값
$login_value = $_POST['login_value'];
$change_nickname = $_POST['change_nickname'];

// 닉네임 변경
$temp = "UPDATE members SET nickname='{$change_nickname}' WHERE login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{    
   echo mysqli_error($db);
}

?>