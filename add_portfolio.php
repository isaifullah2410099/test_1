<?php
include 'auth_check.php';
include 'db.php';

if(isset($_POST['addBtn'])){
    $user_id = (int)$_SESSION['user_id'];
    $title = $conn->real_escape_string(trim($_POST['title']));
    $description = $conn->real_escape_string(trim($_POST['description']));
    $skills = $conn->real_escape_string(trim($_POST['skills']));

    $sql = "INSERT INTO portfolio(user_id, title, description, skills)
            VALUES($user_id, '$title', '$description', '$skills')";
    $conn->query($sql);

    header("Location: profile.php?id=$user_id");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container narrow-page">
    <div class="form-card">
        <h1>Add Portfolio Item</h1>
        <form method="post">
            <label>Project Title</label>
            <input type="text" name="title" required>

            <label>Description</label>
            <textarea name="description" rows="6" required></textarea>

            <label>Skills Used</label>
            <input type="text" name="skills" placeholder="PHP, MySQL, HTML">

            <button type="submit" name="addBtn">Add to Portfolio</button>
        </form>
    </div>
</div>
</body>
</html>
