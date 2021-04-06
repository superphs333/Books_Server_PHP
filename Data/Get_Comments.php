<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 받아오는 데이터에 따라 분기
/*
idx_memo -> 메모에 따른 분기
login_value -> 나의 댓글 가져오기
*/
if(isset($_POST['idx_memo'])){ // 메모에 따른 분기
    $temp = "SELECT idx_memo, Comment_Memo.login_value, nickname, profile_url, comment, date_time, group_idx, idx, depth FROM Comment_Memo LEFT JOIN members ON Comment_Memo.login_value=members.login_value WHERE idx_memo={$_POST['idx_memo']} ORDER BY group_idx ASC, idx ASC";
}else if(isset($_POST['login_value'])){ // 나의 댓글
    // 아직
}

// 데이터베이스에서 가져오기
$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);

?>