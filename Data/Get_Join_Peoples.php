<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];
$login_value = $_POST['login_value'];

// $idx = 12;
// $login_value = "dlthdus9431@naver.com";

// 객체
class Join_People{
    public $login_value,$nickname, $profile_url, $follow,$room_idx;
}

$temp = "SELECT nickname, profile_url, members.login_value, Join_Chatting_Room.room_idx as room_idx FROM Join_Chatting_Room JOIN members ON Join_Chatting_Room.login_value=members.login_value WHERE Join_Chatting_Room.room_idx={$idx} AND Join_Chatting_Room.status=1 ORDER BY date_time ASC";
$sql = mq($temp);
$list = array();
while($row=$sql->fetch_assoc()){
    $join_people = new Join_People();
    $join_people->nickname=$row['nickname'];
    $join_people->login_value=$row['login_value'];
    $join_people->profile_url=$row['profile_url'];
    $join_people->room_idx=$row['room_idx'];
  


     
    // follow 판별
    $temp_follow = "SELECT To_login_value FROM Follow WHERE From_login_value='{$login_value}' AND To_login_value='{$row['login_value']}'";
    $sql_follow = mq($temp_follow);
    $row_follow = $sql_follow->fetch_array();
    if($row_follow==true){ // 값이 있는 경우
        $join_people->follow=true;

    }else{ // 값이 없는 경우
        $join_people->follow=false;

        // 자신인 경우 : follow = true
        if($login_value==$row['login_value']){
            $join_people->follow=true;
        }
    }

    array_push($list,$join_people);
    

}
echo json_encode($list);








?>