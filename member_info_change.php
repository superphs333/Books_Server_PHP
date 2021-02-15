<?php
/*
멤버의 정보를 변경한다
받는값 : sort(pw/nickname), change(변경될 값), login_value(누구인지)

반환)
- 성공 : success
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 값받아오기
$sort = $_POST['sort'];
$change = $_POST['change'];
$login_value = $_POST['login_value'];

// 값변경하기
$temp = "UPDATE members SET {$sort}='{$change}' where login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{
    echo mysqli_error($db);
}
?>