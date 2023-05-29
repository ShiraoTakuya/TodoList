<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myDB";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password,$dbname,$port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
        SELECT * FROM list
    ";
    $result = $conn->query($sql);
    
    $ar = [];
    while ($row = $result->fetch_assoc()) {
        array_push($ar, $row);
    }

    echo json_encode($ar);
?>
