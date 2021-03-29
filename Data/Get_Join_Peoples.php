<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];
$login_value = $_POST['login_value'];


// 객체
class Join_People{
    public $login_value,$nickname, $profile_url, $follow;
}

$temp = "SELECT nickname, profile_url, members.login_value FROM Join_Chatting_Room JOIN members ON Join_Chatting_Room.login_value=members.login_value WHERE Join_Chatting_Room.room_idx={$idx}";
$sql = mq($temp);
$list = array();
while($row=$sql->fetch_assoc()){
    $join_people = new Join_People();
    $join_people->nickname=$row['nickname'];
    $join_people->login_value=$row['login_value'];
    $join_people->profile_url=$row['profile_url'];
     
    // follow 판별
    $temp_follow = "SELECT To_login_value FROM Follow WHERE From_login_value='{$login_value}' AND To_login_value='{$row['login_value']}'";
    $sql_follow = mq($temp_follow);
    $row_follow = $sql_follow->fetch_array();
    if($row_follow==true){ // 값이 있는 경우
        $join_people->follow=true;
    }else{ // 값이 없는 경우
        $join_people->follow=false;
    }

    array_push($list,$join_people);
    

}
echo json_encode($list);








?>