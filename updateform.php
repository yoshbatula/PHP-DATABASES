<?php
    session_start();
    include 'fetchupdate.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update form</title>
</head>
<body>
    <form action="updateform.php" method="POST">
        <label for="username">Username: </label><br>
        <input type="text" name="username" value="<?php $_SESSION['username'] ?>"><br>
        <label for="role">Role: </label><br>
        <input type="text" name="role" value="<?php $_SESSION['role'] ?>"><br>
        <label for="fullname">Fullname: </label><br>
        <input type="text" name="fullname" value="<?php $_SESSION['full_name']?>"><br>
        <label for="email">Email: </label><br>
        <input type="email" name="email" value="<?php $_SESSION['email'] ?>"><br>
        
        <input type="submit" value="submit" name="submit">
    </form>
</body>
</html>