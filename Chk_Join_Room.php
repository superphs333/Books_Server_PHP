<?php
error_reporting(E_ALL); 
ini_set('display_errors',1);
include_once('./db_config.php');

// 데이터 받아오기
$idx = $_POST['idx'];
$state = $_POST['state'];
    // state = 0(참여중), 1(참여중x)

// 참여자수 받아오기 
$temp= "SELECT  COUNT(room_idx) as join_count FROM Join_Chatting_Room WHERE status=1 AND room_idx={$idx} GROUP BY room_idx";
//echo $temp;
$sql = mq($temp);
$row = $sql->fetch_array();
$count = $row['join_count'];
echo "count=".$count;

/*
나가는 경우 -> 현재 인원이 1명이면 
들어가는 경우 -> 꽉차있으면 들어갈 수 없음
*/
?>