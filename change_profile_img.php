<?php
/*
프로필


echo)
success -> 성공
그외 -> 실패
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 받은값
$login_value = $_POST['login_value'];
//echo $login_value;

// 기본 프로필 사진 이미지
$profile_url = $website."system_img/basic_profile_img.png";

// 파일받기
if(isset($_FILES['uploadedfile']['name'])){

    if(!$_FILES['uploadedfile']['error']){
        // 경로지정
        $destination
                = './Img_Profile/'.$_FILES['uploadedfile']['name'];

        // 서버에 저장된 업로드된 파일의 임시 이름
        $location = $_FILES['uploadedfile']['tmp_name'];
        //echo "임시 파일 이름=".$location;

        // 이동하기
        $move = move_uploaded_file($location,$destination);
        if($move){
            //echo "move_success";
        }else{
            echo "move_fail=====>".$_FILES['uploadedfile']['error'];
        }

        $profile_url
                = $website."Img_Profile/".$_FILES['uploadedfile']['name'];
        
    }else{
        // 파일 에러
        echo "file error".$separator;
    }

}
// 프로필 이미지
echo $profile_url.$separator;
/*
sql문 적용
*/
$temp = "update members set profile_url='{$profile_url}' where login_value='{$login_value}'";
//echo $temp;
$sql = mq($temp);
if($sql){
    echo "success";
}else{
    echo mysqli_error($db).$separator."error";
}




?>