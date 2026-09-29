<?php
include 'auth_check.php';
include 'db.php';

$user_id = (int)$_SESSION['user_id'];

// Count the user's own projects.
$project_count_result = $conn->query("SELECT COUNT(*) AS total FROM projects WHERE user_id=$user_id");
$project_count = $project_count_result->fetch_assoc()['total'];

// Count applications sent by the user.
$app_count_result = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE applicant_id=$user_id");
$app_count = $app_count_result->fetch_assoc()['total'];

// Count accepted applications.
$accepted_count_result = $conn->query("SELECT COUNT(*) AS total FROM applications WHERE applicant_id=$user_id AND status='Accepted'");
$accepted_count = $accepted_count_result->fetch_assoc()['total'];

$my_projects = $conn->query("SELECT * FROM projects WHERE user_id=$user_id ORDER BY project_id DESC");

$my_apps = $conn->query("SELECT applications.*, projects.title FROM applications
                         JOIN projects ON applications.project_id = projects.project_id
                         WHERE applications.applicant_id=$user_id
                         ORDER BY applications.application_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container">
    <h1>My Dashboard</h1>

    <?php if(isset($_GET['project']) && $_GET['project'] == 'created'){ ?>
        <p class="message success">Project posted successfully.</p>
    <?php } ?>

    <div class="stats-row">
        <div class="stat-card"><span><?= $project_count ?></span><p>My Projects</p></div>
        <div class="stat-card"><span><?= $app_count ?></span><p>Applications Sent</p></div>
        <div class="stat-card"><span><?= $accepted_count ?></span><p>Accepted</p></div>
    </div>

    <div class="dashboard-columns">
        <div class="form-card">
            <div class="section-title"><h2>My Projects</h2><a href="create_project.php">+ New</a></div>
            <?php if($my_projects && $my_projects->num_rows > 0){ ?>
                <?php while($row = $my_projects->fetch_assoc()){ ?>
                    <div class="list-item">
                        <div>
                            <strong><?= htmlspecialchars($row['title']) ?></strong>
                            <p class="muted"><?= htmlspecialchars($row['project_type']) ?> - <?= htmlspecialchars($row['status']) ?></p>
                        </div>
                        <div>
                            <a href="project_details.php?id=<?= $row['project_id'] ?>">View</a>
                            <a href="edit_project.php?id=<?= $row['project_id'] ?>">Edit</a>
                            <a href="manage_applications.php?project_id=<?= $row['project_id'] ?>">Applicants</a>
                            <a class="danger-link" href="delete_project.php?id=<?= $row['project_id'] ?>" onclick="return confirm('Delete this project?')">Delete</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="muted">You have not posted a project yet.</p>
            <?php } ?>
        </div>

        <div class="form-card">
            <h2>My Applications</h2>
            <?php if($my_apps && $my_apps->num_rows > 0){ ?>
                <?php while($row = $my_apps->fetch_assoc()){ ?>
                    <div class="list-item">
                        <div>
                            <strong><?= htmlspecialchars($row['title']) ?></strong>
                            <p><span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></p>
                        </div>
                        <a href="project_details.php?id=<?= $row['project_id'] ?>">View</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="muted">You have not applied to any project yet.</p>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
