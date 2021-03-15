<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

/*
데이터 받아오기
*/
// 안드로이드 코드의 postParameters변수에 적어둔 
// 이름을 가지고 값을 전달받는다
$title = $_POST['title'];
$authors = $_POST['authors'];
$publisher = $_POST['publisher'];
$isbn = $_POST['isbn'];
$total_page = "0";
$contents = $_POST['contents'];
$contents = mysqli_real_escape_string($db,$contents);
$from_ = "search";
$login_value = $_POST['login_value'];


// 기본 프로필 사진 이미지
$thumbnail = $_POST['thumbnail'];
if($thumbnail==""){ // 가져온 정보가 없다면 -> 기본이미지
    $thumbnail = $website."system_img/basic_book_cover.png";
}


/*
sql문 적용
: 책추가(Books) --(성공시)--> My_Books에 추가
*/
$unique_book_value = $isbn;
$temp = "INSERT INTO Books(`unique_book_value`, `title`, `authors`, `publisher`, `isbn`, `thumbnail`, `contents`, `from_`) VALUES('{$unique_book_value}','{$title}','{$authors}','{$publisher}','{$isbn}','{$thumbnail}','{$contents}','{$from_}')";
//echo $temp;
$sql = mq($temp);
if($sql){
    echo "success".$separator;
    

    // 데이터 베이스에 My_Books에 해당 책 저장
    $rating = $_POST['rating_'];
    $status = $_POST['status'];

    // sql문 
    $temp = "INSERT INTO My_Books(`login_value`, `unique_book_value`, `status`, `rating`,`from_`) VALUES('{$login_value}','{$unique_book_value}','{$status}','{$rating}','search')";
    $sql = mq($temp);
    if($sql){
        echo "success";
    }else{    
        echo mysqli_error($db);
    }

}else{
   echo mysqli_error($db);
}
?>