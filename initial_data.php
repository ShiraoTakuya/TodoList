<?php
    $set = json_decode(file_get_contents("SET.INI"));

    $conn = new mysqli($set->servername,$set->username,$set->password,$set->dbname,$set->port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "
        CREATE TABLE IF NOT EXISTS list (
        session_id VARCHAR(50) NOT NULL,
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
    $conn->close();
    
    echo TRUE;
?>
