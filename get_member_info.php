<?php
/*
회원의 유일값을 받아오고, 
요청한 정보를 echo
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 값 받아오기
$login_value = $_POST['login_value']; // 회원정보 유일값
$sort = $_POST['sort']; // 가져올 정보

$temp = "select {$sort} from members where login_value='{$login_value}'";
$sql = mq($temp);
$output = $sql->fetch_array();
$result = $output[$sort];
echo $result;
?>