<?php
session_start();
include 'dbconnect.php';
include 'user_fetch.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $user_id = $_POST['user_id'];

        $deleteQuery = "DELETE FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "User deleted successfully!";
        } else {
            $_SESSION['message'] = "Error deleting user.";
        }
        $stmt->close();
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TABLE</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
</head>
<body>

    <div class="container mt-4">
        <h2 class="text-center">User Table</h2>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-info"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>

        <div class="add-btn">
            <input type="submit" value="Add User" class="btn btn-primary" onclick="window.location.href='adduser.php'">
        </div>

        <table id="myTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Time Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['timecreated']); ?></td>
                            <td>
                                <a href="updateform.php?user_id=<?php echo htmlspecialchars($row['user_id']); ?>" class="btn btn-primary btn-sm">Update</a>
                                <form action="index.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                    <button class="btn btn-danger btn-sm" type="submit" name="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>  
                            </td>
                        </tr>
                    <?php } ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No records found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#myTable').DataTable({
                "paging": true,  
                "searching": true, 
                "ordering": true,  
                "info": true,  
                "lengthMenu": [5, 10, 15, 20] 
            });
        });
    </script>

</body>
</html>
