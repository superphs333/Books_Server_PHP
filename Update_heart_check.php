<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');
include_once('./Function/Function_Group.php');

// 데이터 받아오기
$idx_memo = $_POST['idx_memo'];
$login_value = $_POST['login_value'];
$check_heart = $_POST['check_heart']; // 현재상태


// 데이터 수정
if($check_heart=="true"){ // 데이터 삭제
    $temp = "DELETE FROM Heart_Memo WHERE idx_memo={$idx_memo} AND login_value='{$login_value}'";
}else if($check_heart=="false"){ // 데이터 삽입
    $temp = "INSERT INTO Heart_Memo(idx_memo, login_value) VALUES({$idx_memo},'{$login_value}')";
}
$sql = mq($temp); // 하트반영
if($sql){
    echo "success".$separator;

    if($check_heart=="true"){
        $temp_bookmemo = "UPDATE Book_Memo SET count_heart=count_heart-1 WHERE idx={$idx_memo}";
    }else if($check_heart=="false"){
        $temp_bookmemo = "UPDATE Book_Memo SET count_heart=count_heart+1 WHERE idx={$idx_memo}";
    }

    // 메모의 하트수 반영
    $sql_bookmemo = mq($temp_bookmemo); 
    if($sql_bookmemo){
        echo "success".$separator;

        // 메모의 하트수 
        $temp_count = "SELECT count_heart FROM Book_Memo WHERE idx={$idx_memo}";
        $sql_count = mq($temp_count);
        $row=$sql_count->fetch_array();
        $count = $row['count_heart'];
        echo $count.$separator;;

        /*
        알림
        */
        if($check_heart=="false"){
            // nickname 받아오기
            $temp = "SELECT nickname FROM members WHERE login_value='{$login_value}'";
            $sql = mq($temp);
            $row = $sql->fetch_array();
            $nickname = $row['nickname'];

            // fcm에 보낼 데이터
            $data = json_encode(array(
                "to"=>$to,
                "data" => array(
                    "sort"   => "For_memo_like",
                    "idx" => "{$idx_memo}",
                    "title" => "알림",
                    "message" => "{$nickname}님이 회원님의 게시글에 좋아요를 눌렀습니다!")
                    ));
                    
            // 알림보내기(데이터메세지 형식)
            send_alarm($data);
        } // end if
    }else{   
        echo mysqli_error($db);
    }
}else{   
    echo mysqli_error($db);
}




?>