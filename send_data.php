<?php
    $id = htmlspecialchars($_GET["id"]);
    $parentid = htmlspecialchars($_GET["parentid"]);
    $elementtype = htmlspecialchars($_GET["elementtype"]);
    $string = htmlspecialchars($_GET["string"]);
    $finish = htmlspecialchars($_GET["finish"]);
    $hide = htmlspecialchars($_GET["hide"]);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myDB";
    $port = 3306;

    $conn = new mysqli($servername, $username, $password,$dbname,$port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE TABLE IF NOT EXISTS list (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        parentid VARCHAR(30),
        elementtype VARCHAR(30) NOT NULL,
        string VARCHAR(30) NOT NULL,
        finish int(1) NOT NULL,
        hide int(1) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    if($id == "null"){
        $stmt = $conn->prepare("INSERT INTO list SET parentid=?, elementtype=?, string=?, finish=?, hide=?");
        $stmt->bind_param("sssss", $parentid,$elementtype,$string,$finish,$hide);
        $stmt->execute();
        $stmt->close();
    }else{
        $stmt = $conn->prepare("UPDATE list SET parentid=?, elementtype=?, string=?, finish=?, hide=? WHERE id=?");
        $stmt->bind_param("ssssss", $parentid,$elementtype,$string,$finish,$hide,$id);
        $stmt->execute();
        $stmt->close();
    }
    $conn->close();
    
    echo TRUE;
?>
