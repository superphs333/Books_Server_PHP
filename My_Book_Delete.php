<?php

/*
리턴값
- success
- 그외(오류)
*/

error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$login_value = $_POST['login_value'];
$unique_book_value = $_POST['unique_book_value'];

// sql문
$temp = "DELETE FROM My_Books WHERE login_value='{$login_value}' AND unique_book_value='{$unique_book_value}'";
$sql = mq($temp);
if($sql){
    echo "success";
}else{  
    echo mysqli_error($db);
}

?>