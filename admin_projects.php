<?php
include 'admin_check.php';
include 'db.php';

$sql = "SELECT projects.*, users.name, users.student_id FROM projects
        LEFT JOIN users ON projects.user_id = users.user_id
        ORDER BY projects.project_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="page-container">
    <div class="section-title">
        <h1>Manage Projects & Gigs</h1>
        <a href="admin_dashboard.php">Back to Dashboard</a>
    </div>

    <?php if(isset($_GET['deleted'])){ ?>
        <p class="message success">Project removed successfully.</p>
    <?php } ?>

    <div class="table-card">
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Owner</th>
                <th>Type</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
            <?php if($result && $result->num_rows > 0){ ?>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td><?= $row['project_id'] ?></td>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['name'] ?: 'Unknown') ?><br><span class="muted"><?= htmlspecialchars($row['student_id'] ?: '') ?></span></td>
                        <td><?= htmlspecialchars($row['project_type']) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td><?= htmlspecialchars($row['deadline']) ?></td>
                        <td>
                            <a class="mini-action" href="admin_edit_project.php?id=<?= $row['project_id'] ?>">Edit</a>
                            <a class="mini-action reject" href="admin_delete_project.php?id=<?= $row['project_id'] ?>" onclick="return confirm('Delete this project?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="7">No projects have been posted.</td></tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
