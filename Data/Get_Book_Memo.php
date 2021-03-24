<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
    // unique_book_value, login_value
$unique_book_value = $_POST['unique_book_value'];
$login_value = $_POST['login_value'];

// 임시
$unique_book_value = '210316084357temp_book';
$login_value = 'dlthdus943@naver.com';

// 객체 => Book_Memo
// class Book_Memo{
//     public $idx, $login_value, $nickanme, $profile_url, $unique_book_value, $title, $thumbnail, $date_time, $img_urls, $memo, $page, $open;
// }

// 해당 데이터 
$temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value='{$unique_book_value}' AND members.login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    //echo "su";
    $dbdata = array();
    while($row=$sql->fetch_assoc()){
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);
}else{
    echo mysqli_error($db);
}
?>