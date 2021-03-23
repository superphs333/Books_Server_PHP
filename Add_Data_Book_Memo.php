<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$size = $_POST['size'];
$unique_book_value = $_POST['unique_book_value'];
$memo = $_POST['memo']; 
$page = $_POST['page'];
$open = $_POST['open'];
$login_value = $_POST['login_value'];

// 파일 경로를 저장할 배열
$img_array = array();

for($i=0; $i<$size; $i++){
    $tempname = "uploaded_file".(string)$i;

    if($_FILES[$tempname]['name']){ // 해당 파일 네임 존재
        
        if(!$_FILES[$tempname]['error']){ // 파일에러
            $destination = '/var/www/html/town/place/'.$_FILES[$tempname]['name'];

            // 경로지정
            $destination = './Img_Book_Memo/'.$_FILES[$tempname]['name'];

            // 서버에 저장된 업로드된 파일의 임시 파일 이름
            $location = $_FILES[$tempname]['tmp_name'];
            
            // 이동하기
            $move = move_uploaded_file($location,$destination);

            // if($move){
            //     echo "이동성공";
            // }else{
            //     echo "이동에러=====>".$_FILES['uploadedfile']['error'];
            // }

            // 이미지 주소
            $photo_url = $website."Img_Book_Memo/".$_FILES[$tempname]['name'];

            // array에 저장
            array_push($img_array,$photo_url);

        }
    }
}// end for


/*
이미지 배열 -> 문자열
*/
$imgs = implode('§',$img_array);
// echo $imgs;

/*
날짜, 시간
*/
$date_time = date("Y-m-d H:i:s");
//echo $date_time;

/*
데이터베이스에 저장
*/
$temp = "INSERT INTO Book_Memo(`login_value`, `unique_book_value`, `date_time`, `img_urls`, `memo`, `page`, `open`) VALUES('{$login_value}','{$unique_book_value}','{$date_time}','{$imgs}','{$memo}',{$page},'{$open}')";
$sql = mq($temp);
if($sql){  
    echo "success";
}else{   
    echo mysqli_error($db);
}




?>