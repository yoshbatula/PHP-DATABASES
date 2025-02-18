<?php

    include 'dbconnect.php';

    $query = "SELECT user_id, username, role, full_name, email, timecreated FROM users";
    $result = mysqli_query($conn, $query);
?>