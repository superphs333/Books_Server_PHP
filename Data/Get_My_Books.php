<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$login_value = $_POST['login_value'];
//$login_value = "dlthdus943@naver.com";
$status = $_POST['status'];
//$status = 0;
$search = $_POST['search'];
//$search = "F";

// sql문
    // status -> 값이 없는 경우에는 모두(status=0, 1, 2)
if($status=="0" || $status=="1" || $status=="2"){ // 값이 있는 경우
    $temp = "SELECT Books.unique_book_value, title, authors, thumbnail, contents, from_, isbn, status, rating FROM My_Books JOIN Books ON My_Books.unique_book_value=Books.unique_book_value WHERE login_value='{$login_value}' and status={$status} and (title LIKE '%{$search}%' OR authors LIKE '%{$search}%')";
}else{ // status가 값이 없는 경우
    $temp = "SELECT Books.unique_book_value, title, authors, thumbnail, contents, from_, isbn, status, rating FROM My_Books JOIN Books ON My_Books.unique_book_value=Books.unique_book_value WHERE login_value='{$login_value}' and (title LIKE '%{$search}%' OR authors LIKE '%{$search}%')";
}

//echo $temp;
$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);


?>