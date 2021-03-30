<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];
$login_value = $_POST['login_value'];
$state = $_POST['state'];
    // state = 0(참여중), 1(참여중x)

if($state=="true"){ // 참여중상태 -> 데이터베이스 DELETE
   $temp = "DELETE FROM Join_Chatting_Room WHERE room_idx={$idx} AND login_value='{$login_value}'";
  
}else if($state=="false"){ 
    // 비참여중 -> 데이터베이스 INSERT 
    // and Join_Chatting_Room stats = 1(자리가 남았을 때), stauts=0(자리가 남지 않았을 때)
    
    // 현재 참여자 수
    $temp_count = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, COUNT(Chatting_Room.idx) as join_count FROM Chatting_Room LEFT JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE Join_Chatting_Room.status=1 AND idx={$idx} GROUP BY Chatting_Room.idx";
    $sql_count = mq($temp_count);
    $row = $sql_count->fetch_array();
    $count = $row['join_count'];


    // 현재 참여자수 = total_count -> status=0
    // 그외 -> status=1
    if($count==$row['total_count']){
        $temp = "INSERT INTO Join_Chatting_Room(login_value, room_idx, status) VALUES('{$login_value}',{$idx},0)";
    }else{
        $temp = "INSERT INTO Join_Chatting_Room(login_value, room_idx, status) VALUES('{$login_value}',{$idx},1)";
    }
}

$sql = mq($temp);
if($sql){
    echo "success§";

    // 

    // 현재 참여자 수
    $temp_count2 = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, COUNT(Chatting_Room.idx) as join_count FROM Chatting_Room LEFT JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE Join_Chatting_Room.status=1 AND idx={$idx} GROUP BY Chatting_Room.idx";
    $sql_count2 = mq($temp_count2);
    $row2 = $sql_count2->fetch_array();
    $count2 = $row2['join_count'];
    echo $count2;
}else{   
    //echo mysqli_error($db);

    if(substr(mysqli_error($db),0,9)=="Duplicate"){
        echo "Duplicate";
    }else{
        echo mysqli_error($db);
    }
    // if(mysqli_error($db).substr=="Duplicate"){

    // }
}


?>