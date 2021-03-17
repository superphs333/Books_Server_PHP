<?php

error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$unique_book_value = $_POST['unique_book_value'];


// 해당 데이터 
$temp = "SELECT Books.unique_book_value, title, authors, thumbnail, contents, My_Books.from_, isbn, status, rating, publisher, review FROM My_Books JOIN Books ON My_Books.unique_book_value=Books.unique_book_value WHERE Books.unique_book_value='{$unique_book_value}'";
$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);
?>