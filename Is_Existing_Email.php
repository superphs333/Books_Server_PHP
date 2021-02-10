<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 이메일 받아오기
$email = $_POST['email'];

// 받아온 이메일, 비밀번호 셋트가 있는지 확인한다
$temp = "select login_value from members where login_value='{$email}'";
$sql = mq($temp);
$count = $sql->num_rows;
echo $count;
    // count = 1(값존재)
    // count = 0(값없음)
?>