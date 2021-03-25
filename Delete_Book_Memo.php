<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];

// 해당 데이터 삭제 
$temp = "DELETE FROM Book_Memo WHERE idx={$idx}";
$sql = mq($temp);
if($sql){
    echo "success";
}else{   
    echo mysqli_error($db);
}



?>