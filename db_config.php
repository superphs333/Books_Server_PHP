<?php
    $host = '127.0.0.1';
    $username = 'dingpong98'; # MySQL 계정 아이디
    $password = '41Asui!@'; # MySQL 계정 패스워드
    $dbname = 'website';  # DATABASE 
    //$dbname = 'hello_world_db';  # DATABASE 이름

    header('Content-Type: text/html; charset=utf-8');

    // mysql connect
    $db = new mysqli($host, $username, $password, $dbname);
    $db->set_charset("utf8");
    //var_dump($db);

    // if($db){
    //     echo "su";
    // }

    function mq($sql){
        // 매개변수 = sql문
        global $db;
            // global = 외부에서 선언된 sql을 함수내에서 쓸 수 있도록
        return $db->query($sql); // mysqli_result
    }

    // + 웹페이지 주소
    $website = "https://my3my3my.tk/website/";

    // + 구분자
    $separator = "§▼▩";

?>
