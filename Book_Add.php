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
$total_page = $_POST['total_page'];
$contents = $_POST['contents'];
$from_ = "add";
$login_value = $_POST['login_value'];

// 기본 프로필 사진 이미지
$thumbnail = $website."system_img/basic_book_cover.png";


// 파일받기(받은 파일이 있는 경우에만)
    // form태그를 이용해서 전송된 파일은 $_FILES를 통해 접근 가능
if(isset($_FILES['uploadedfile']['name'])){
    //echo "filename=".$_FILES['uploadedfile']['name'];

    if(!$_FILES['uploadedfile']['error']){
        
        // 경로지정
        $destination
            = './Img_Book_Cover/'.$_FILES['uploadedfile']['name'];
        //echo $destination;

        // 서버에 저장된 업로드된 파일의 임시 파일 이름
        $location = $_FILES['uploadedfile']['tmp_name'];
        //echo "임시 파일 이름=".$location;

        // 이동하기
        $move = move_uploaded_file($location,$destination);
        
        // 이동 성공/실패
        if($move){
            //echo "move_success";
            $thumbnail
            = $website."Img_Book_Cover/".$_FILES['uploadedfile']['name'];
            //echo $profile_url;
        }else{
            echo "move_fail=====>".$_FILES['uploadedfile']['error'];
        }


        
    }else{
        // 파일 에러
        echo "file error".$separator;
    }

}

/*
sql문 적용
: 책추가(Books) --(성공시)--> My_Books에 추가
*/
// 유일키 
$time = date('yyyymdHis');
$unique_book_value = $time.rand(1,70000);
$temp = "INSERT INTO Books(`unique_book_value`, `title`, `authors`, `publisher`, `isbn`, `thumbnail`, `contents`, `from_`) VALUES('{$unique_book_value}','{$title}','{$authors}','{$publisher}','{$isbn}','{$thumbnail}','{$contents}','{$from_}')";
$sql = mq($temp);
if($sql){
    echo "success".$separator;
    

    // 데이터 베이스에 My_Books에 해당 책 저장
    $rating = $_POST['rating'];
    $status = $_POST['status'];

    // sql문 
    $temp = "INSERT INTO My_Books(`login_value`, `unique_book_value`, `status`, `rating`) VALUES('{$login_value}','{$unique_book_value}','{$status}','{$rating}')";
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