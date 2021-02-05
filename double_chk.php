<?php

/*
기능 : 이메일, 닉네임을 중복 체크해주는 기능..
*/


error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 분류
$sort = $_POST['sort'];

if($sort=="email"){// 이메일 체크
    $temp = "select email from members where email='{$_POST['input']}'";
}else if($sort=="nickname"){// 닉네임 체크
    $temp = "select email from members where nickname='{$_POST['input']}'";
}

// 결과값 갯수 가져오기
$sql = mq($temp);
$count = mysqli_num_rows($sql);

// 만약, 결과값이 1보다 크면 -> 이미 존재
if($count>0){
    echo "unable";
}else{
    echo "able";
}




?>