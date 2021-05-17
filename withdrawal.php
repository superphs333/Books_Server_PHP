<?php
/*
회원 정보를 삭제한다

반환)
success = 성공
fail = 실패
*/
error_reporting(E_ALL); // 에러 표시
ini_set('display_errors',1);
    // php 설정 변경
// 데이터베이스 관련 파일 추가
include_once('db_config.php');

// 받은 값
$login_value = $_POST['login_value'];

// sql -> 회원정보 삭제
$temp = "DELETE FROM members WHERE login_value='{$login_value}'";
$sql = mq($temp);
if($sql){
    echo "success";

    /*
    데이터베이스중에서 해당 회원에 해당하는 정보는 삭제한다
    : Book_Memo, Chatting, Chatting_Room, Follow, Heart_Memo, Join_Chatting_ROOM, My_Books
    */
    // Book_Memo
    $sql = mq("DELETE FROM Book_Memo WHERE login_value='{$login_value}'");
    // Chatting
    $sql = mq("DELETE FROM Chatting WHERE login_value='{$login_value}'");
    // Follow
    $sql = mq("DELETE FROM Follow WHERE From_login_value='{$login_value}' OR To_login_value='{$login_value}'");
    // Heart_Memo
    $sql = mq("DELETE FROM Heart_Memo WHERE login_value='{$login_value}'");
    // Join_Chatting_ROOM
    $sql = mq("DELETE FROM Join_Chatting_ROOM WHERE login_value='{$login_value}'");
    // My_Books
    $sql = mq("DELETE FROM My_Books WHERE login_value='{$login_value}'");

    


}else{   
    echo mysqli_error($db);
}

?>