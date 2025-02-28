<?php
    $host = "localhost";
    $dbname = "laboratory-exam";
    $user = "root";
    $pass = "";

    $conn = new mysqli($host, $user, $pass, $dbname);
        if ($conn->connect_error) {
            echo "Failed to connect" . $conn->connect_error;
        }
?>