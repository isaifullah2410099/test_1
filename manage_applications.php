<?php
include 'auth_check.php';
include 'db.php';

$project_id = isset($_GET['project_id']) ? (int)$_GET['project_id'] : 0;
$user_id = (int)$_SESSION['user_id'];

// Check that the logged in user owns this project.
$project_sql = "SELECT * FROM projects WHERE project_id=$project_id AND user_id=$user_id";
$project_result = $conn->query($project_sql);
if(!$project_result || $project_result->num_rows == 0){
    die('You cannot manage this project.');
}
$project = $project_result->fetch_assoc();

// Get all applications with the applicant information.
$sql = "SELECT applications.*, users.name, users.student_id, users.department, users.skills
        FROM applications
        JOIN users ON applications.applicant_id = users.user_id
        WHERE applications.project_id=$project_id
        ORDER BY applications.application_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applicants</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container">
    <div class="section-title">
        <div>
            <h1>Applicants</h1>
            <p class="muted"><?= htmlspecialchars($project['title']) ?></p>
        </div>
        <a href="project_details.php?id=<?= $project_id ?>">Back to Project</a>
    </div>

    <div class="table-card">
        <table>
            <tr>
                <th>Student</th>
                <th>Skills</th>
                <th>Proposal</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php if($result && $result->num_rows > 0){ ?>
                <?php while($row = $result->fetch_assoc()){ ?>
                    <tr>
                        <td>
                            <a href="profile.php?id=<?= $row['applicant_id'] ?>"><strong><?= htmlspecialchars($row['name']) ?></strong></a><br>
                            <span class="muted"><?= htmlspecialchars($row['student_id']) ?>, <?= htmlspecialchars($row['department']) ?></span>
                        </td>
                        <td><?= htmlspecialchars($row['skills'] ?: 'Not added') ?></td>
                        <td><?= nl2br(htmlspecialchars($row['proposal'])) ?></td>
                        <td><span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                        <td>
                            <a class="mini-action accept" href="update_application.php?id=<?= $row['application_id'] ?>&project_id=<?= $project_id ?>&status=Accepted">Accept</a>
                            <a class="mini-action reject" href="update_application.php?id=<?= $row['application_id'] ?>&project_id=<?= $project_id ?>&status=Rejected">Reject</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="5">No applications yet.</td></tr>
            <?php } ?>
        </table>
    </div>
</div>
</body>
</html>
