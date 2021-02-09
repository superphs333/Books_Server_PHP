<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 받은 값
$login_value = $_POST['login_value'];
$profile_url = $_POST['profile_url'];
$nickname = $_POST['nickname'];

//echo $login_value.", ".$profile_url.", ".$nickname;

// 유일키 
$time = date('yyyymmddh_i_s_u');
$Unique_Value = uniqid($time);

// 데이터베이스에 저장
$temp = "INSERT INTO members(platform_type, Unique_Value, login_value, nickname, profile_url) VALUES ('google','{$Unique_Value}', '{$login_value}', '{$nickname}', '{$profile_url}')";
$sql = mq($temp);
if($sql){
    echo "success";
}else{
    echo mysqli_error($db);
}
?>