<?php
include 'admin_check.php';
include 'db.php';

$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';

if(isset($_POST['saveBtn'])){
    $title = $conn->real_escape_string(trim($_POST['title']));
    $project_type = $conn->real_escape_string($_POST['project_type']);
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills_needed']));
    $team_size = (int)$_POST['team_size'];
    $deadline = $conn->real_escape_string($_POST['deadline']);
    $status = $conn->real_escape_string($_POST['status']);

    $sql = "UPDATE projects SET title='$title', project_type='$project_type', description='$description',
            skills_needed='$skills', team_size=$team_size, deadline='$deadline', status='$status'
            WHERE project_id=$project_id";
    $conn->query($sql);
    $message = 'Project updated successfully.';
}

$result = $conn->query("SELECT * FROM projects WHERE project_id=$project_id");
if(!$result || $result->num_rows == 0){
    die('Project not found.');
}
$project = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="page-container narrow-page">
    <div class="form-card">
        <div class="section-title">
            <h1>Edit Project</h1>
            <a href="admin_projects.php">Back</a>
        </div>

        <?php if($message != ''){ ?><p class="message success"><?= htmlspecialchars($message) ?></p><?php } ?>

        <form method="post">
            <label>Title</label>
            <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required>

            <label>Project Type</label>
            <select name="project_type" required>
                <?php
                $types = ['Personal Project', 'Research', 'Freelance Gig', 'Academic Project', 'Other'];
                foreach($types as $type){
                    $selected = $project['project_type'] == $type ? 'selected' : '';
                    echo "<option $selected>$type</option>";
                }
                ?>
            </select>

            <label>Description</label>
            <textarea name="description" rows="6" required><?= htmlspecialchars($project['description']) ?></textarea>

            <label>Skills Needed</label>
            <input type="text" name="skills_needed" value="<?= htmlspecialchars($project['skills_needed']) ?>" required>

            <label>Team Size</label>
            <input type="number" name="team_size" min="1" value="<?= $project['team_size'] ?>" required>

            <label>Deadline</label>
            <input type="date" name="deadline" value="<?= htmlspecialchars($project['deadline']) ?>" required>

            <label>Status</label>
            <select name="status">
                <option <?= $project['status'] == 'Open' ? 'selected' : '' ?>>Open</option>
                <option <?= $project['status'] == 'Closed' ? 'selected' : '' ?>>Closed</option>
            </select>

            <button type="submit" name="saveBtn">Save Changes</button>
        </form>
    </div>
</div>
</body>
</html>
