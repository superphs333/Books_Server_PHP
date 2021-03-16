<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

/*
데이터 받아오기
*/
$unique_book_value = $_POST['unique_book_value'];
$title = $_POST['title'];
$authors = $_POST['authors'];
$publisher = $_POST['publisher'];
$isbn = $_POST['isbn'];
$total_page = $_POST['total_page'];
$contents = $_POST['contents'];
$login_value = $_POST['login_value'];
$img_change = $_POST['img_change'];


// img_change=false -> 기존 프로필 사진 이미지  
if($img_change=="false"){
    $thumbnail = $_POST['thumbnail'];
}else{ // 이미지가 없는 경우 -> 기본 이미지
    $thumbnail = $website."system_img/basic_book_cover.png";
}



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
: 책수정(Books) --(성공시)--> My_Books에 추가
*/
$temp = "UPDATE Books SET title='{$title}', authors='{$authors}', publisher='{$publisher}', isbn='{$isbn}', thumbnail='{$thumbnail}', contents='{$contents}' WHERE unique_book_value='{$unique_book_value}'";
$sql = mq($temp);
if($sql){
    echo "success".$separator;
    
    // 데이터 베이스에 My_Books에 해당 책 수정
    $rating = $_POST['rating'];
    $status = $_POST['status'];

    // sql문 
    $temp = "UPDATE My_Books SET status='{$status}', rating='{$rating}' WHERE unique_book_value='{$unique_book_value}' and login_value='{$login_value}'";
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