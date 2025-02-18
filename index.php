<?php
    session_start();
    include 'dbconnect.php';
    include 'user_fetch.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TABLE</title>
</head>
<body>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table td, th {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: black;
        }

        .update-btn {
            background-color: green;
        }

        .update-btn a {
            color: white;
        }

        .delete-btn {
            background-color: red;
        }

        .delete-btn a {
            color: white;
        }
    </style>

    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Time Created</th>
            <th>Action</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                <td><?php echo htmlspecialchars($row['username']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['timecreated']); ?></td>
                <td>
                    <a href="updateform.php?id<?=$row['user_id'] ?>" name="update">Update</a>
                    <a href="delete.php?id=<?$row['user_id'] ?>" onclick="return confirm('Are you sure you want to delete this info?')"></a>
                </td>
            </tr>
        <?php } ?>

    </table>

</body>
</html>
