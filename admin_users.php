<?php
include 'admin_check.php';
include 'db.php';

$result = $conn->query("SELECT * FROM users ORDER BY user_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="page-container">
    <div class="section-title">
        <h1>Manage Users</h1>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>

    <?php if(isset($_GET['deleted'])){ ?>
        <p class="message success">User removed successfully.</p>
    <?php } ?>

    <div class="table-card">
        <table>
            <tr>
                <th>ID</th>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Skills</th>
                <th>Action</th>
            </tr>
            <?php if($result && $result->num_rows > 0){ ?>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['user_id'] ?></td>
                        <td><?= htmlspecialchars($row['student_id']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['skills'] ?: '-') ?></td>
                        <td>
                            <a class="mini-action" href="admin_edit_user.php?id=<?= $row['user_id'] ?>">Edit</a>
                            <a class="mini-action reject" href="admin_delete_user.php?id=<?= $row['user_id'] ?>" onclick="return confirm('Delete this user and related data?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="7">No student accounts yet.</td></tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
