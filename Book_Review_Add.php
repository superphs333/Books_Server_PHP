<?php

error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$login_value = $_POST['login_value'];
$unique_book_value = $_POST['unique_book_value'];
$review = $_POST['review'];

// 데이터 수정
$temp = "UPDATE My_Books SET review='{$review}' WHERE login_value='{$login_value}' and unique_book_value='{$unique_book_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{
    echo mysqli_error($db);
}

?>