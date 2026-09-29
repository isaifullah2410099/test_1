<?php
include 'auth_check.php';
include 'db.php';

$message = '';

if(isset($_POST['postBtn'])){
    $user_id = (int)$_SESSION['user_id'];
    $title = $conn->real_escape_string(trim($_POST['title']));
    $project_type = $conn->real_escape_string($_POST['project_type']);
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills_needed']));
    $team_size = (int)$_POST['team_size'];
    $deadline = $conn->real_escape_string($_POST['deadline']);

    $sql = "INSERT INTO projects(user_id, title, project_type, description, skills_needed, team_size, deadline)
            VALUES($user_id, '$title', '$project_type', '$description', '$skills', $team_size, '$deadline')";

    if($conn->query($sql) === TRUE){
        header('Location: dashboard.php?project=created');
        exit();
    }
    else{
        $message = 'Project could not be posted.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container narrow-page">
    <div class="form-card">
        <h1>Post a Project / Gig</h1>
        <p class="muted">Tell other students what you are working on and what skills you need.</p>

        <?php if($message != ''){ ?>
            <p class="message error"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="post">
            <label>Project Title</label>
            <input type="text" name="title" required>

            <label>Project Type</label>
            <select name="project_type" required>
                <option value="">Select Type</option>
                <option>Personal Project</option>
                <option>Research</option>
                <option>Freelance Gig</option>
                <option>Academic Project</option>
                <option>Other</option>
            </select>

            <label>Description</label>
            <textarea name="description" rows="6" required></textarea>

            <label>Skills Needed</label>
            <input type="text" name="skills_needed" placeholder="Example: HTML, CSS, PHP, MySQL" required>

            <label>Team Size</label>
            <input type="number" name="team_size" min="1" max="20" required>

            <label>Deadline</label>
            <input type="date" name="deadline" required>

            <button type="submit" name="postBtn">Post Project</button>
        </form>
    </div>
</div>
</body>
</html>
