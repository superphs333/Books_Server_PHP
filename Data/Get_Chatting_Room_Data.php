<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
    // idx가 있는 경우 -> 특정방에 대한 데이터
    // idx가 없는 경우 -> 
        // sort없는 경우 -> 전체
        // sort 있는 경우
            // login_value 있는 경우 -> login_value가 속해있는 채팅방 

        
if(isset($_POST['idx'])){ // idx가 있는 경우 -> 특정방에 대한 데이터


    $idx = $_POST['idx'];
    $temp = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, leader , COUNT(Join_Chatting_Room.room_idx) as join_count FROM Chatting_Room JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE idx={$idx} GROUP BY Chatting_Room.idx ";
    $sql = mq($temp);
    
    $dbdata = array();
    while($row=$sql->fetch_assoc()){
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);

}else{

    //sort가 있는 경우
    if(!isset($_POST['sort'])){ // 전체

                          
        $temp = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, COUNT(Join_Chatting_Room.room_idx) as join_count FROM Chatting_Room JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx GROUP BY Chatting_Room.idx";
        
        $sql = mq($temp);
    
        $dbdata = array();
        while($row=$sql->fetch_assoc()){
            $dbdata[]=$row;
        }
        echo json_encode($dbdata);

    }else{ // login_value가 있는 경우 -> login_value가 속해있는 채팅방
        // login_value가 있는 경우 -> login_value가 속해있는 채팅방
        if(isset($_POST['login_value'])){
            $sort = $_POST['sort'];
            if($sort=="waiting"){
                echo "wating";
            }else if($sort=="join"){
                 echo "join";
            }
        }
    }



}




/*
가져올 데이터 : title, room_explain, total_count, leader, count(현재 참여 인원)
*/



?>