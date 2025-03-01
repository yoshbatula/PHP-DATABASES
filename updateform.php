<?php
session_start();
include 'dbconnect.php';

if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    die("Invalid request. User ID is missing.");
}

$user_id = intval($_GET['user_id']);

$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("User not found.");
}

$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
        die("Invalid request. User ID is missing.");
    }

    $user_id = intval($_POST['user_id']);
    $username = $_POST['username'];
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];

    $updateQuery = "UPDATE users SET username=?, role=?, full_name=? WHERE user_id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $username, $role, $full_name, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "User updated successfully!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['message'] = "Error updating user.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit User</h2>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <form action="updateform.php?user_id=<?php echo $user_id; ?>" method="POST">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['user_id']); ?>">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Role</label>
                <input type="text" name="role" class="form-control" value="<?php echo htmlspecialchars($user['role']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>