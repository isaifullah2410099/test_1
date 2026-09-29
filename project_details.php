<?php
include 'auth_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$user_id = (int)$_SESSION['user_id'];

$sql = "SELECT projects.*, users.name, users.department FROM projects
        JOIN users ON projects.user_id = users.user_id
        WHERE projects.project_id=$project_id";
$result = $conn->query($sql);

if(!$result || $result->num_rows == 0){
    die('Project not found.');
}

$project = $result->fetch_assoc();

// Check if the logged in student already applied.
$application = null;
$app_sql = "SELECT * FROM applications WHERE project_id=$project_id AND applicant_id=$user_id";
$app_result = $conn->query($app_sql);
if($app_result && $app_result->num_rows > 0){
    $application = $app_result->fetch_assoc();
}

// Get accepted team members.
$team_sql = "SELECT users.user_id, users.name, users.department FROM applications
             JOIN users ON applications.applicant_id = users.user_id
             WHERE applications.project_id=$project_id AND applications.status='Accepted'";
$team_result = $conn->query($team_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($project['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container">
    <div class="details-layout">
        <div class="details-main">
            <div class="form-card">
                <div class="card-top">
                    <span class="tag type-tag"><?= htmlspecialchars($project['project_type']) ?></span>
                    <span class="status <?= strtolower($project['status']) == 'open' ? 'open' : 'closed' ?>"><?= htmlspecialchars($project['status']) ?></span>
                </div>
                <h1><?= htmlspecialchars($project['title']) ?></h1>
                <p class="muted">Posted by <a href="profile.php?id=<?= $project['user_id'] ?>"><?= htmlspecialchars($project['name']) ?></a> (<?= htmlspecialchars($project['department']) ?>)</p>

                <h3>About this project</h3>
                <p class="long-text"><?= nl2br(htmlspecialchars($project['description'])) ?></p>

                <h3>Skills Needed</h3>
                <p><?= htmlspecialchars($project['skills_needed']) ?></p>

                <div class="info-row">
                    <p><strong>Team Size:</strong> <?= (int)$project['team_size'] ?></p>
                    <p><strong>Deadline:</strong> <?= htmlspecialchars($project['deadline']) ?></p>
                </div>
            </div>
        </div>

        <div class="details-side">
            <div class="form-card">
                <?php if($project['user_id'] == $user_id){ ?>
                    <h3>This is your project</h3>
                    <p>Open the applicant list to form your team.</p>
                    <a class="button-link full" href="manage_applications.php?project_id=<?= $project_id ?>">Manage Applicants</a>
                <?php } else if($project['status'] != 'Open'){ ?>
                    <h3>Applications Closed</h3>
                    <p>This project is not accepting new proposals.</p>
                <?php } else if($application){ ?>
                    <h3>Your Application</h3>
                    <p>Status: <span class="status <?= strtolower($application['status']) ?>"><?= htmlspecialchars($application['status']) ?></span></p>
                    <p><?= nl2br(htmlspecialchars($application['proposal'])) ?></p>
                <?php } else { ?>
                    <h3>Want to join?</h3>
                    <form method="post" action="apply.php">
                        <input type="hidden" name="project_id" value="<?= $project_id ?>">
                        <label>Your Proposal</label>
                        <textarea name="proposal" rows="6" placeholder="Explain how you can help the project..." required></textarea>
                        <button type="submit" name="applyBtn">Send Proposal</button>
                    </form>
                <?php } ?>
            </div>

            <div class="form-card">
                <h3>Accepted Team Members</h3>
                <?php if($team_result && $team_result->num_rows > 0){ ?>
                    <?php while($member = $team_result->fetch_assoc()){ ?>
                        <p><a href="profile.php?id=<?= $member['user_id'] ?>"><?= htmlspecialchars($member['name']) ?></a> - <?= htmlspecialchars($member['department']) ?></p>
                    <?php } ?>
                <?php } else { ?>
                    <p class="muted">No members accepted yet.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
