<?php
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

/*
데이터 받아오기
- 기본적으로 sort(분류) : email, nickname
*/
// 안드로이드 코드의 postParameters변수에 적어둔 
// 이름을 가지고 값을 전달받는다
$email = $_POST['email'];
$pw = $_POST['pw'];
$nickname = $_POST['nickname'];

// 기본 프로필 사진 이미지
$profile_url = $website."system_img/basic_profile_img.png";

// 파일받기
    // form태그를 이용해서 전송된 파일은 $_FILES를 통해 접근 가능
if(isset($_FILES['uploadedfile']['name'])){
    //echo "filename=".$_FILES['uploadedfile']['name'];

    if(!$_FILES['uploadedfile']['error']){
        
        // 경로지정
        $destination
            = './Img_Profile/'.$_FILES['uploadedfile']['name'];
        //echo $destination;

        // 서버에 저장된 업로드된 파일의 임시 파일 이름
        $location = $_FILES['uploadedfile']['tmp_name'];
        //echo "임시 파일 이름=".$location;

        // 이동하기
        $move = move_uploaded_file($location,$destination);
            /* bool move_uploaded_file(String $from, String $to)
            - 매개변수
                - from : 업로드 된 파일이름
                - to : 이동 된 파일의 대상
            - 반환값
                - true 
                - false
                    - 유효한 업로드 파일이 아님
                    - 유효한 파일이지만, 어떤 이유가 있을 때
            */
        
        // 이동 성공/실패
        if($move){
            //echo "move_success";
        }else{
            echo "move_fail=====>".$_FILES['uploadedfile']['error'];
        }

        $profile_url
            = $website."Img_Profile/".$_FILES['uploadedfile']['name'];
        //echo $destination;
        
    }else{
        // 파일 에러
        echo "file error".$separator;
    }

}else{
    // 파일이 정의되어 있지 않음 -> default 이미지
    echo "Undefined file".$separator;
}

/*
sql문 적용
: email, pw, nickname, profile_url
*/
$temp = "insert into members(email, pw, nickname, profile_url) values('{$email}','{$pw}','{$nickname}','{$profile_url}')";
$sql = mq($temp);
if($sql){
    echo "success";
}else{
    echo mysqli_error($db).$separator."error";
}
?>