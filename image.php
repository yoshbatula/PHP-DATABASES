<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMAGE VIEWER</title>
</head>
<body>
    <form action="image.php" method="POST" enctype="multipart/form-data">
        <label for="profile">Profile</label><br>
        <input type="file" name="profile"><br>

        <label for="name">Name: </label><br>
        <input type="text" name="name"><br>

        <label for="email">Email: </label><br>
        <input type="email" name="email"><br><br>

        <input type="submit" value="submit" name="submit">
    </form>
    <?php

include 'dbconnect.php';

if(isset($_POST['submit'])) {
    if(isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $name = $_POST['name'];
        $email = $_POST['email'];

       
        $targetDir = __DIR__ . "/upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["profile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');

        if(in_array(strtolower($fileType), $allowedTypes)) {
            if(move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFilePath)) {
                $query = "INSERT INTO user (name, email, image) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sss", $name, $email, $fileName);

                if($stmt->execute()) {
                    echo "Data inserted successfully!";
                    $_SESSION['profile'] = $fileName;
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "File upload failed!";
            }
        } else {
            echo "Invalid file format!";
        }
    } else {
        echo "No file uploaded or an error occurred!";
    }

    $conn->close();
}
?>
</body>
</html>