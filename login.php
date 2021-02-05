<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 이메일, 비밀번호 받아오기
$email = $_POST['email'];
$pw = $_POST['pw'];
$input = "email={$email}, pw={$pw}";
//echo $input;

// 받아온 이메일, 비밀번호 셋트가 있는지 확인한다
$temp = "select count(*) from members where email='{$email}' and pw='{$pw}'";
//echo $temp;
$sql = mq($temp);

if($sql){
    print_r($sql);
    /*
    [사용법] - http://106.255.249.194:19180/detail.html?no=1003
    */
    
}else{
    echo mysqli_error($db);
}

?>