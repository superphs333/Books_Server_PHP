<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 객체 => Book_Memo
class Book_Memo{
    public $idx, $login_value, $nickname, $profile_url, $unique_book_value, $title, $thumbnail, $date_time, $img_urls, $memo, $page, $open, $count_heart, $count_comment,$check_heart;
}
    // check_heart = 내가 하트를 눌렀는지 체크(눌렀으면 1, 누르지 않았으면 0)

// 객체를 담을 리스트
$list = array();


// 팔로우 목록은 -> 2군데서 받아야 한다(requester, memo의 작성자)


// 데이터 받아오기
$unique_book_value = $_POST['unique_book_value'];
$requester = $_POST['requester'];
$view = $_POST['view']; 


// 임시
// $unique_book_value = '895461180X';
// $requester = 'dlthdus9413@naver.com';
// $view = '팔로우';


// view 분기 -> 전체, 팔로우, 내메모
if($view=="전체"){
    // 팔로우 상관없이
    $temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value LIKE '%{$unique_book_value}%'";
}else if($view=="팔로우"){
    /*
    requester의 팔로우 목록
    */
    $temp_for_request_follow = "SELECT To_login_value FROM Follow WHERE From_login_value='{$requester}'";
    $sql_for_request_follow = mq($temp_for_request_follow);
    $list_request_follow = array(); 
    while($row=$sql_for_request_follow->fetch_array()){
        array_push($list_request_follow,$row['To_login_value']);
    }
    if($list_request_follow!=0){
        // int에 넣을 string
        $for_in = null;
        for($i=0; $i<count($list_request_follow); $i++){
            $for_in = $for_in.$list_request_follow[$i];
            $for_in = $for_in."','";
        }
        // 문자열 더하기(맨 앞에 작은 따옴표)
        $for_in = "'".$for_in;
        // 맨 마지막 문자 제거(,'제거)
        $for_in = mb_substr($for_in,0,-2,'utf-8');
        //echo $for_in;

        $temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value LIKE '%{$unique_book_value}%' AND members.login_value in ({$for_in})";
    }else{
        $temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value LIKE '%{$unique_book_value}%'";
    }
    
}else if($view=="내메모"){
    $temp = "SELECT Book_Memo.idx, Book_Memo.login_value, members.nickname, members.profile_url, Book_Memo.unique_book_value, Books.title, Books.thumbnail, Book_Memo.date_time,img_urls, Book_Memo.memo, Book_Memo.page, Book_Memo.open, Book_Memo.count_heart, Book_Memo.count_comment From Book_Memo JOIN members ON Book_Memo.login_value=members.login_value JOIN Books ON Books.unique_book_value=Book_Memo.unique_book_value WHERE Books.unique_book_value LIKE '%{$unique_book_value}%' AND members.login_value='{$requester}'";
}


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
    $temp_heart = "select * from Heart_Memo where login_value='{$requester}' and idx_memo={$row['idx']}";
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
    //echo $row['idx'].$row['open'].$row['nickname'];
    if($row['open']=="all" || $row['login_value']==$requester){ // 전체공개 & 내글
        // 모든 사람에게 보임
        array_push($list,$data);
    }else if($row['open']=="follow"){ // 팔로우에게만 공개
        // 이 메모의 작성자의 팔로우에게만 보임 
        
        /*
        작성자가 request를 팔로우했는지 확인
        */
        $temp_for_follow = "SELECT * FROM Follow WHERE From_login_value='{$row['login_value']}' AND To_login_value='{$requester}'";
        $sql_for_follow = mq($temp_for_follow);
        $count = mysqli_num_rows($sql_for_follow);
        // 결과행갯수가 1인경우에만 -> 배열에 추가한다
        if($count==1){
            array_push($list,$data);
        }
    
    }else if($row['open']=="no"){ // 비공개
        // 포함x
    }
    // 

    //echo "</br>";

    // // list에 대입하기
    // array_push($list,$data);

}
//echo "</br>".count($list);
echo json_encode($list)



?>