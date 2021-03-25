<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$size = $_POST['size'];
$idx = $_POST['idx'];
$memo = $_POST['memo']; 
$page = $_POST['page'];
$open = $_POST['open'];
$img_order_string = $_POST['img_order_string'];


// 파일 경로를 저장할 배열
$img_array = array();

// var_dump($_FILES);
for($i=0; $i<$size; $i++){

    $temp_name = "uploaded_file".(string)$i;

    if(isset($_FILES[$temp_name]['name'])){ // 파일이름 존재
        if(!$_FILES[$temp_name]['error']){ // 파일 에러x

            // 경로지정
            $destination = './Img_Book_Memo/'.$_FILES[$temp_name]['name'];

            // 서버에 저장된 업로드된 파일의 임시 파일 이름
            $location = $_FILES[$temp_name]['tmp_name'];

            // 이동하기
            $move = move_uploaded_file($location,$destination);

            // if($move){
            //     echo "이동성공";
            // }else{
            //     echo "이동에러=====>".$_FILES[$tempname]['error'];
            // }

            $destination =  $website."Img_Book_Memo/".$_FILES[$temp_name]['name'];
        }
    }
} // end for

/*
이미지 배열 -> 문자열
*/
$imgs = explode(',',$img_order_string); // 배열로 전환
$imgs = implode('§',$imgs); // string으로 변환




/*
데이터베이스에 해당 데이터 수정
*/
$temp = "UPDATE Book_Memo SET img_urls='{$imgs}', memo='{$memo}', page={$page}, open='{$open}' WHERE idx={$idx}";
echo $temp;
$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}














?>