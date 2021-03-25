<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('../db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];

$temp = "SELECT img_urls, memo, page, open FROM Book_Memo WHERE idx={$idx}";
$sql = mq($temp);
$dbdata = array();
while($row=$sql->fetch_assoc()){
    $dbdata[]=$row;
}
echo json_encode($dbdata);

?>