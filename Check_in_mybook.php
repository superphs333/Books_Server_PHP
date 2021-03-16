<?php

/*
리턴값
- duplicate
- duplicate_no
- mysqli_error
*/

error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$login_value = $_POST['login_value'];
$unique_book_value = $_POST['unique_book_value'];

// sql문
$temp = "SELECT * FROM My_Books WHERE login_value='{$login_value}' AND unique_book_value='{$unique_book_value}'";
$sql = mq($temp);
if($sql){
    // 결과값 갯수
    $count = mysqli_num_rows($sql);

    // 결과값=0이 아닌 경우 -> duplicate
    if($count!=0){
        echo "duplicate";
    }else{
        echo "duplicate_no";
    }
}else{
    echo mysqli_error($db);
}

?>