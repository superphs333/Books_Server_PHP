<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');
class Comment{
    public $idx_memo, $login_value, $nickname, $profile_url, $comment, $date_time, $group_idx, $idx, $depth, $target;
}

$temp = "SELECT idx_memo, Comment_Memo.login_value, nickname, profile_url, comment, date_time, group_idx, idx, depth, target FROM Comment_Memo LEFT JOIN members ON Comment_Memo.login_value=members.login_value WHERE idx_memo=3 ORDER BY group_idx ASC, idx ASC";
$sql = mq($temp);

// 객체를 담을 리스트
$list = array();

while($row=$sql->fetch_array()){
    // 객체 생성하기
    $data = new Comment();

    // 값 대입하기
    $data->idx_memo=$row['idx_memo'];
    $data->login_value=$row['login_value'];
    $data->nickname=$row['nickname'];
    $data->profile_url=$row['profile_url'];
    $data->comment=$row['comment'];
    $data->date_time=$row['date_time'];
    $data->group_idx=$row['group_idx'];
    $data->idx=$row['idx'];
    $data->depth=$row['depth'];

    // target의 닉네임 셋팅
    //echo $row['target'];
    $temp2 = "SELECT nickname FROM members WHERE login_value='{$row['target']}'";
    $sql2 = mq($temp2);
    $row2 = $sql2->fetch_array();
    $data->target=$row2['nickname'];

    // list에 대입하기
    array_push($list,$data);

} // end while

echo json_encode($list);
?>
