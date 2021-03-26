<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 객체 => Book_Memo
class Book_Memo{
    public $idx, $login_value, $nickname, $profile_url, $unique_book_value, $title, $thumbnail, $date_time, $img_urls, $memo, $page, $open, $count_heart, $count_comment,$check_heart;
}
    // check_heart = 내가 하트를 눌렀는지 체크(눌렀으면 1, 누르지 않았으면 0)

// 팔로우 목록은 -> 2군데서 받아야 한다(requester, memo의 작성자)


// 데이터 받아오기
    // unique_book_value, login_value
// $unique_book_value = $_POST['unique_book_value'];
// $reqester = $_POST['reqester'];
// $open = $_POST['open']; 


// 임시
$unique_book_value = '';
$reqester = 'dlthdus943@naver.com';
$login_value = "";
$open = 'all'

/*
requester의 팔로우 목록
*/
$temp_for_request_follow = "SELECT To_login_value FROM Follow WHERE From_login_value='{$reqester}'";
$sql_for_request_follow = mq($temp_for_request_follow);
$list_request_follow = array();
while($row=$sql_for_request_follow->fetch_array()){
    array_push($list_request_follow,$row['To_login_value']);
}




$list = array();

// 해당 데이터 

$temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value LIKE '%{$unique_book_value}%' AND members.login_value LIKE '%{$login_value}%'";


/*
경우 -> 6가지
*/

$sql = mq($temp);

while($row=$sql->fetch_array()){
    // 객체생성
    $data = new Book_Memo();

    /*
    값 대입하기
    */
    $data->idx=$row['idx'];
    $data->login_valuedx=$row['login_value'];
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

    /*
    open -> follow(이 게시물의 작성자가 나를 팔로우했을 경우에만 보이기), no(나 외에는 아무에게도 보이지 않기)
    - follow -> 이 작성자가 팔로우한 목록 알아야 함
    - no -> reqester와  게시물(idx)의 작성자가 동일한지 확인

    보이는 경우) 
        open = 
    내 글, 해당 글의 작성자가 나를 팔로우 한 경우, 전체공개
    보이지 않는 경우) 
    */
    if($row['open']=="all"){ // 전체공개
        // 모든 사람에게 보임
        array_push($list,$data);
    }else if($row['open']=="follow"){ // 팔로우에게만 공개
        // 이 메모의 작성자의 팔로우에게만 보임 
            // 메모 작성자의 팔로우 목록에게만 보임
    }else if($row['open']=="no"){ // 비공개

    }
    // 보이는 경우 -> 내 글, 해당 글의 작성자가 


    // list에 대입하기
    array_push($list,$data);

}

echo json_encode($list)



?>