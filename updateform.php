<?php
session_start();
include 'dbconnect.php';

if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['email'] = $user['email'];
    } else {
        echo "User not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if (isset($_POST['save'])) {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    $query = "UPDATE users SET username = ?, role = ?, full_name = ?, email = ? WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $role, $full_name, $email, $user_id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Successfully updated');</script>";
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Update failed');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
</head>
<body>
    <form action="updateform.php" method="POST">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <label>Username:</label>
        <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>"><br>

        <label>Role:</label>
        <input type="text" name="role" value="<?php echo $_SESSION['role']; ?>"><br>

        <label>Full Name:</label>
        <input type="text" name="full_name" value="<?php echo $_SESSION['full_name']; ?>"><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>"><br><br>

        <button type="submit" name="save">Save Changes</button>
    </form>
</body>
</html>
