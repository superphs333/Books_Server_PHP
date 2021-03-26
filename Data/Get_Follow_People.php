<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$sort = $_POST['sort'];
$login_value = $_POST['login_value'];




/*
requester의 팔로우 목록
*/
if($sort=="follower"){ // login_value = to
    $temp = "SELECT From_login_value as login_value, members.nickname, members.profile_url, visible FROM Follow JOIN members ON Follow.From_login_value = members.login_value WHERE To_login_value='{$login_value}' AND visible=1";
}else if($sort="following"){ // login_value = from
    $temp = "SELECT To_login_value as login_value, members.nickname, members.profile_url, visible FROM Follow JOIN members ON Follow.To_login_value = members.login_value WHERE From_login_value='{$login_value}'";
}

$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);


// $temp_for_request_follow = "SELECT To_login_value FROM Follow WHERE From_login_value='{$reqester}'";
// $sql_for_request_follow = mq($temp_for_request_follow);
// $list_request_follow = array();
// while($row=$sql_for_request_follow->fetch_array()){
//     array_push($list_request_follow,$row['To_login_value']);
// }






?>