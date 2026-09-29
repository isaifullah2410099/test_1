<?php
include 'auth_check.php';
include 'db.php';

// Show the newest open projects on the home page.
$sql = "SELECT projects.*, users.name FROM projects
        JOIN users ON projects.user_id = users.user_id
        WHERE projects.status='Open'
        ORDER BY projects.project_id DESC LIMIT 6";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="page-container">
    <div class="hero">
        <div>
            <h1>Welcome, <?= htmlspecialchars($_SESSION['name']) ?>!</h1>
            <p>Find teammates, join student projects, research work and freelance gigs.</p>
        </div>
        <a class="button-link" href="create_project.php">+ Post a Project</a>
    </div>

    <div class="section-title">
        <h2>Recent Open Projects</h2>
        <a href="projects.php">View All</a>
    </div>

    <div class="card-list">
        <?php if($result && $result->num_rows > 0){ ?>
            <?php while($row = $result->fetch_assoc()){ ?>
                <div class="project-card">
                    <div class="card-top">
                        <span class="tag type-tag"><?= htmlspecialchars($row['project_type']) ?></span>
                        <span class="status open"><?= htmlspecialchars($row['status']) ?></span>
                    </div>
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="muted">Posted by <?= htmlspecialchars($row['name']) ?></p>
                    <p><?= htmlspecialchars(substr($row['description'], 0, 150)) ?>...</p>
                    <p><strong>Skills:</strong> <?= htmlspecialchars($row['skills_needed']) ?></p>
                    <p><strong>Team size:</strong> <?= (int)$row['team_size'] ?></p>
                    <a class="small-button" href="project_details.php?id=<?= $row['project_id'] ?>">View Project</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="empty-box">
                <p>No projects have been posted yet.</p>
                <a href="create_project.php">Post the first project</a>
            </div>
        <?php } ?>
    </div>
</div>

<footer>UIU CollabHub - Student class project, not an official UIU website.</footer>
</body>
</html>
