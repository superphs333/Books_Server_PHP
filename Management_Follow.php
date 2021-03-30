<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

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
    echo "success";
}else{   
    echo mysqli_error($db);
}

?>