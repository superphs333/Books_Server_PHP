<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');
include_once('./Function/Function_Group.php');


// 데이터 받아오기
$sort = $_POST['sort']; // add,add_comment, edit, delete




// sort에 따라 mysql문 분기
if($sort=="add"){
    $temp = "INSERT INTO Comment_Memo(login_value, idx_memo, comment,date_time) VALUES('{$_POST['login_value']}','{$_POST['idx_memo']}','{$_POST['comment']}','{$_POST['date_time']}')";
}else if($sort=="edit"){
    $temp = "UPDATE Comment_Memo SET comment='{$_POST['comment']}' WHERE idx={$_POST['idx']}";
}else if($sort=="delete"){
    $temp = "DELETE FROM Comment_Memo WHERE idx={$_POST['idx']}";
}else if($sort=="add_comment"){
    $temp = "INSERT INTO Comment_Memo(login_value, idx_memo, comment, date_time, group_idx, depth, target) VALUES('{$_POST['login_value']}','{$_POST['idx_memo']}','{$_POST['comment']}','{$_POST['date_time']}','{$_POST['group_idx']}',1,'{$_POST['target']}')";
}

// 데이터베이스 반영
$sql = mq($temp);
if($sql){
    echo "success§";

    // idx값 가져오기
    $last_uid = mysqli_insert_id($db);
    echo $last_uid."§";

    // Book_Memo의 count_comment값 셋팅
    $temp = "SELECT COUNT(*) as count FROM Comment_Memo WHERE idx_memo={$_POST['idx_memo']}";
    $sql = mq($temp);
    $result = $sql->fetch_array();
    $count = $result['count'];
    $temp = "UPDATE Book_Memo SET count_comment={$count} WHERE idx={$_POST['idx_memo']}";
    $sql = mq($temp);
    if($sql){
        echo "success(count_comment)셋팅§";
    }else{   
        echo mysqli_error($db)."§";
    }

    // sort=add인 경우 상대방에게 알림 전송
    if($sort=="add"){

        // group_idx값 셋팅
        $temp = "UPDATE Comment_Memo SET group_idx={$last_uid} WHERE idx={$last_uid}";
        $sql = mq($temp);
        if($sql){
            echo "group_idx값 셋팅§";
        }else{   
            echo mysqli_error($db)."§";
        }

        // idx_memo작성자 
        $temp = "SELECT sender_id, nickname FROM Book_Memo JOIN members ON Book_Memo.login_value=members.login_value WHERE Book_Memo.idx={$_POST['idx_memo']}";
        $sql = mq($temp);
        $result = $sql->fetch_array();
        $nickname = $result['nickname'];
        $to = $result['sender_id'];

        // 알람에 보낼 것
        $data = json_encode(array(
            "to"=>$to,
            "data" => array(
                "sort"   => "For_Comment",
                "title" => "알림",
                "message" => "{$nickname}님이 댓글을 달았습니다")
                ));

        // 알림보내기(데이터메세지 형식)
        send_alarm($data);
    } // end if
    
}else{   
    echo mysqli_error($db);
}




?>