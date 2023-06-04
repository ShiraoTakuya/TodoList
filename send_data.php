<?php
    ini_set('session.gc_maxlifetime', 365*24*3600);
    ini_set('session.cookie_lifetime', 365*24*3600);
    session_start();
    //setcookie(session_name(),session_id(),time()+365*24*3600); 
    setcookie(session_id());

    $id = htmlspecialchars($_GET["id"]);
    $parentid = htmlspecialchars($_GET["parentid"]);
    $elementtype = htmlspecialchars($_GET["elementtype"]);
    $string = htmlspecialchars($_GET["string"]);
    $finish = htmlspecialchars($_GET["finish"]);
    $hide = htmlspecialchars($_GET["hide"]);

    $set = json_decode(file_get_contents("SET.INI"));
    $conn = new mysqli($set->servername, $set->username, $set->password,$set->dbname,$set->port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $session_id = session_id();
    if($id == "null"){
        $stmt = $conn->prepare("INSERT INTO list SET session_id=?, parentid=?, elementtype=?, string=?, finish=?, hide=?");
        $stmt->bind_param("ssssss", $session_id,$parentid,$elementtype,$string,$finish,$hide);
        $stmt->execute();
        $stmt->close();
    }else{
        $stmt = $conn->prepare("UPDATE list SET session_id=?, parentid=?, elementtype=?, string=?, finish=?, hide=? WHERE id=?");
        $stmt->bind_param("sssssss", $session_id,$parentid,$elementtype,$string,$finish,$hide,$id);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    
    echo TRUE;
?>
