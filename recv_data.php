<?php

    ini_set('session.gc_maxlifetime', 365*24*3600);
    ini_set('session.cookie_lifetime', 365*24*3600);
    session_start();
    //setcookie(session_name(),session_id(),time()+365*24*3600); 
    setcookie(session_id());

    $set = json_decode(file_get_contents("SET.INI"));
    $conn = new mysqli($set->servername, $set->username, $set->password,$set->dbname,$set->port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $session_id = session_id();
    $result = $conn->query("
        SELECT * FROM list
        WHERE session_id='".$session_id."'
        "
    );
    
    $ar = [];
    if($result){
        while ($row = $result->fetch_assoc()) {
            array_push($ar, $row);
        }
    }

    echo json_encode($ar);
?>
