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
    $temp = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, leader , COUNT(Join_Chatting_Room.room_idx) as join_count FROM Chatting_Room JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE idx={$idx} AND Join_Chatting_Room.status=1 GROUP BY Chatting_Room.idx ";
    $sql = mq($temp);
    
    $dbdata = array();
    while($row=$sql->fetch_assoc()){
        $dbdata[]=$row;
    }
    echo json_encode($dbdata);

}else{ // 특정방x, 전체 데이터

    // login_value 유무
        // x -> 전체
        // o -> 참여중 or 대기중
    if(!isset($_POST['login_value'])){ // 전체

                          
        $temp = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx,leader, COUNT(Chatting_Room.idx) as join_count FROM Chatting_Room LEFT JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx AND Join_Chatting_Room.status=1 GROUP BY Chatting_Room.idx";
        
        $sql = mq($temp);
        
        $dbdata = array();
        while($row=$sql->fetch_assoc()){
            $dbdata[]=$row;
        }
        echo json_encode($dbdata);


    }else{ // login_value가 있는 경우 -> 참여중(sort=1) or 대기중(sort=2)

        $state = $_POST['state'];
        $login_value = $_POST['login_value'];

        class Chatting_Room{
            public $title, $room_idx, $leader, $total_count, $join_count, $idx;
        }

        $temp = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, leader FROM Chatting_Room LEFT JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE login_value='{$login_value}' AND status={$state}";

        $sql = mq($temp);

        $list = array();

        while($row = $sql->fetch_array()){
            $chatting_room = new Chatting_Room();
        
            $chatting_room->title=$row['title'];
            $chatting_room->room_explain=$row['room_explain'];
            $chatting_room->total_count=$row['total_count'];
            $chatting_room->idx=$row['idx'];
        
        
            // count
            $temp_count = "SELECT COUNT(*) as join_count FROM Join_Chatting_Room WHERE room_idx={$row['idx']} AND status=1";
            $sql_count = mq($temp_count);
            $count = $sql_count->fetch_array();
            $chatting_room->join_count=$count['join_count'];
        
            array_push($list,$chatting_room);
        } // end while

        echo json_encode($list);
    }




}







?>