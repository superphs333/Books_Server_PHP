<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
    // unique_book_value, login_value
$unique_book_value = $_POST['unique_book_value'];
$login_value = $_POST['login_value'];

// 임시
// $unique_book_value = '210316084357temp_book';
// $login_value = 'dlthdus943@naver.com';

// 객체 => Book_Memo
class Book_Memo{
    public $idx, $login_value, $nickname, $profile_url, $unique_book_value, $title, $thumbnail, $date_time, $img_urls, $memo, $page, $open, $count_heart, $count_comment,$check_heart;
}
    // check_heart = 내가 하트를 눌렀는지 체크(눌렀으면 1, 누르지 않았으면 0)
$list = array();

// 해당 데이터 
$temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value='{$unique_book_value}' AND members.login_value='{$login_value}' ORDER BY date_time DESC";

$sql = mq($temp);

while($row=$sql->fetch_array()){
    // 객체생성
    $data = new Book_Memo();

    /*
    값 대입하기
    */
    $data->idx=$row['idx'];
    $data->login_value=$row['login_value'];
    $data->nickname=$row['nickname'];
    $data->profile_url=$row['profile_url'];
    $data->unique_book_value=$row['unique_book_value'];
    $data->title=$row['title'];
    $data->thumbnail=$row['thumbnail'];
    $data->date_time=$row['date_time'];
    $data->img_urls=$row['img_urls'];
    $data->memo=$row['memo'];
    $data->page=$row['page'];
    $data->open=$row['open'];
    $data->count_heart=$row['count_heart'];
    $data->count_comment=$row['count_comment'];
    
    // 하트체크 확인
    $temp_heart = "select * from Heart_Memo where login_value='{$login_value}' and idx_memo={$row['idx']}";
    $sql_heart = mq($temp_heart);
    //echo $temp_heart;
    $count = mysqli_num_rows($sql_heart);
    if($count==0){
        $data->check_heart=false;
    }else{
        $data->check_heart=true;
    }

    // list에 대입하기
    array_push($list,$data);

}

echo json_encode($list)



?>