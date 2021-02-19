<?php
/*
회원 정보를 삭제한다

반환)
success = 성공
fail = 실패
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 받은 값
$login_value = $_POST['login_value'];

// sql -> 회원정보 삭제
$temp = "DELETE FROM members WHERE login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}

?>