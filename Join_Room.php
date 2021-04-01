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

    // $_POST['leader_change']가 존재하면 -> 리더변경
    if(isset($_POST['leader_change'])){
        $temp2 = "UPDATE Chatting_Room SET leader='{$_POST['leader']}' WHERE idx={$idx}";
        $sql2 = mq($temp2);
        if($sql){
            
        }else{
            //echo mysqli_error($db);
        }
    }

    // 현재 참여자 수
    $temp_count2 = "SELECT title, room_explain, total_count, Chatting_Room.idx as idx, COUNT(Chatting_Room.idx) as join_count FROM Chatting_Room LEFT JOIN Join_Chatting_Room ON Chatting_Room.idx=Join_Chatting_Room.room_idx WHERE Join_Chatting_Room.status=1 AND idx={$idx} GROUP BY Chatting_Room.idx";
    $sql_count2 = mq($temp_count2);
    $row2 = $sql_count2->fetch_array();
    $count2 = $row2['join_count'];
    echo $count2."§";

    
    /*
    state=true -> 대기자 첫번째에게 알림 전송
    */
    if($state=="true"){
        // 세션을 초기화하고 다른 Curl함수에 전달 할 수 있는 Curl핸들을 반환한다
        $ch = curl_init("https://fcm.googleapis.com/fcm/send");


        // 대상추출
        $temp = "SELECT members.sender_id, members.login_value FROM Join_Chatting_Room LEFT JOIN members ON members.login_value=Join_Chatting_Room.login_value WHERE room_idx={$idx} AND status=0 ORDER BY date_time ASC";
        $sql = mq($temp);
        // $registration_ids_array = array(); // sender_id를 담을 리스트
        // while($row=$sql->fetch_array()){
        //     array_push($registration_ids_array,$row['sender_id']);
        // }
        $row = $sql->fetch_array();
        $to = $row['sender_id']; // 보낼 대상의 sender_id
        $to_login_value = $row['login_value']; //  보낼 대상
        $counts = mysqli_num_rows($sql); // 숫자

        if($counts>=1){
            // 데이터베이스 업데이트(Join_Chatting_Room => status=1)
            $temp = "UPDATE Join_Chatting_Room SET status=1 WHERE login_value='{$to_login_value}' AND room_idx={$idx}";
            $sql = mq($temp);
            if($sql){
                echo "success";
            }else{   
                echo mysqli_error($db);
            }
            
            // title
            $temp = "SELECT title FROM Chatting_Room WHERE idx={$idx}";
            $sql = mq($temp);
            $row = $sql->fetch_array();
            $title = $row['title'];


            // 알람 보내기(여기서는 데이터메세지 형식으로 보냄)
                /* 형식
                제목 - 알림
                내용 - {title}
                */
            $header = array("Content-Type:application/json", "Authorization:key=AAAAaJ1uhgs:APA91bFFrgsrQi45vdeFlLseuEqlOH-tSnplk7kcgl6-gpFZfmvDvjc7cC_yXY9nFthWCCwQol5fR9qFZQBpHNT2ilTGI8-4SjgPGl_gzDBmVdu7YfS7xCRhoDi8VHQzC_Im_CnA9Jom");
            $data = json_encode(array(
                "to"=>$to,
                "data" => array(
                    "sort"   => "For_chatting_room_waiting_list",
                    "idx" => "{$idx}",
                    "title" => "알림",
                    "message" => "대기중이셨던 채팅방 {$title}에 입장되셨습니다!")
                    ));
            // curl 옵션
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

            // curl 세션 시작
            curl_exec($ch);

            // curl 세션 종료
            curl_close($ch);
        }
    } // end $state=="true"

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