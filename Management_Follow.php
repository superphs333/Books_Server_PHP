<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');
include_once('./Function/Function_Group.php');


// 데이터 받아오기
$management = $_POST['management'];
$From_login_value = $_POST['From_login_value'];
$To_login_value = $_POST['To_login_value'];


//echo "management=".$management.", From_login_value=".$From_login_value.", To_login_value=".$To_login_value;

if($management=="invisible"){

    $temp = "UPDATE Follow SET visible=0 WHERE From_login_value='{$From_login_value}' AND To_login_value='{$To_login_value}'";

}else if($management=="following"){
    
    // $temp = "INSERT INTO Follow(`To_login_value`, `From_login_value`) VALUES('{$From_login_value}','{$To_login_value}')";

    $temp = "INSERT INTO Follow(`From_login_value`, `To_login_value`) VALUES('{$From_login_value}','{$To_login_value}')";

    //echo $temp;
   
}else if($management=="delete_following"){

    $temp = "DELETE FROM Follow WHERE From_login_value='{$From_login_value}' AND To_login_value='{$To_login_value}'";

}

// echo $temp;

$sql = mq($temp);
if($sql){
    echo "success§";

    /*
    상대에게 알림 보내기
    */
    if($management=="following"){
        // 대상추출
        $temp = "SELECT nickname, sender_id FROM members WHERE login_value='{$To_login_value}'";
        $sql = mq($temp);
        if($sql){
            $row = $sql->fetch_array();
            $nickname = $row['nickname'];
            $sender_id = $row['sender_id'];

            // 알람에 보낼 것
            $data = json_encode(array(
                "to"=>$sender_id,
                "data" => array(
                    "sort"   => "For_Follow",
                    "title" => "알림",
                    "message" => "{$nickname}님이 회원님을 팔로우하였습니다!")
                    ));

            // 알림보내기(데이터메세지 형식)
            send_alarm($data);
        }else{   
            echo mysqli_error($db);
        }
    }

}else{   
    echo mysqli_error($db);
}

?>