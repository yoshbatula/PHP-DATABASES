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
    <form action="image.php" method="POST">
        <label for="profile">Profile</label><br>
        <input type="file" name="profile"><br>

        <label for="name">Name: </label><br>
        <input type="text" name="name"><br>

        <label for="email">Email: </label><br>
        <input type="email" name="email"><br><br>

        <input type="submit" value="submit" name="submit">
    </form>
    <?php
        if(isset($_POST['submit'])) {
            $_SESSION['profile'];
            $_SESSION['name'];
            $_SESSION['email'];
            
            if($_FILES ['profile']) {
                
            }
        }
    ?>
</body>
</html>