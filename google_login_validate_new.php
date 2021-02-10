<?php
/*
구글 로그인으로 가져온 회원정보가 
이미 등록되어 있었는지, 아닌지를 확인
- 등록 -> 1
- 미등록 -> 0
*/

error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 데이터 가져오기
$login_value = $_POST['login_value'];

// sql
$temp = "select Unique_Value from members where login_value='{$login_value}'";
$sql = mq($temp);
$count = $sql->num_rows;
echo $count;
?>