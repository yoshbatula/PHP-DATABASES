
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User Page</title>
</head>
<body>
<style>
    body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f4f4f4;
    margin: 0;
}

.container {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 500px;  
    text-align: center;
}

h2 {
    margin-bottom: 15px;
    font-size: 22px;
}

form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    text-align: left;
}

.full-width {
    grid-column: span 2; 
}

label {
    font-weight: bold;
    font-size: 14px;
}

input, button {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
}

button {
    background: #28a745;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 16px;
    padding: 10px;
}

button:hover {
    background: #218838;
}

img {
    max-width: 100px;
    display: none;
    margin: 10px auto;
}

    </style>
    <div class="container">
        <h2>Add User</h2>
    <form action="adduser.php" method="POST" enctype="multipart/form-data">
        
        <div class="profile-section">
            <label for="profile">Profile: </label>
            <img id="preview" src="" alt="Image Preview" style="display: none;">
            <input type="file" name="profile" id="profile" accept="image/*" required onchange="previewImage(event)">
        </div>

        <div class="input-section">
            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="role">Role:</label>
            <input type="text" name="role" required>

            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="timecreated">Account Time Created:</label>
            <input type="datetime-local" name="timecreated" required>
        </div>

        <div class="full-width">
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
</div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = "block";
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

<?php
session_start();
include 'dbconnect.php';

if(isset($_POST['submit'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $timecreated = $_POST['timecreated'];

   
    if(isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
        $targetDir = "/upload/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES["profile"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');

        
        if(in_array($fileType, $allowedTypes)) {
            if(move_uploaded_file($_FILES["profile"]["tmp_name"], $targetFilePath)) {
                
                $query = "INSERT INTO users (username, password, role, full_name, email, timecreated, profile) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("sssssss", $username, $password, $role, $fullname, $email, $timecreated, $fileName);

                if($stmt->execute()) {
                    echo "<script>alert('User added successfully!'); window.location.href='index.php';</script>";
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
        echo "No file uploaded!";
    }

    $conn->close();
}
?>

</body>
</html>