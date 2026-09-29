<?php
include 'auth_check.php';
include 'db.php';

$user_id = (int)$_SESSION['user_id'];
$message = '';

if(isset($_POST['saveBtn'])){
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $department = $conn->real_escape_string(trim($_POST['department']));
    $skills = $conn->real_escape_string(trim($_POST['skills']));
    $bio = $conn->real_escape_string(trim($_POST['bio']));

    $sql = "UPDATE users SET name='$name', email='$email', department='$department', skills='$skills', bio='$bio'
            WHERE user_id=$user_id";

    if($conn->query($sql) === TRUE){
        $_SESSION['name'] = $name;
        $message = 'Profile updated successfully.';
    }
}

$result = $conn->query("SELECT * FROM users WHERE user_id=$user_id");
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container narrow-page">
    <div class="form-card">
        <h1>Edit Profile</h1>
        <?php if($message != ''){ ?><p class="message success"><?= htmlspecialchars($message) ?></p><?php } ?>

        <form method="post">
            <label>Student ID</label>
            <input type="text" value="<?= htmlspecialchars($user['student_id']) ?>" disabled>

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Department</label>
            <input type="text" name="department" value="<?= htmlspecialchars($user['department']) ?>" required>

            <label>Skills</label>
            <input type="text" name="skills" value="<?= htmlspecialchars($user['skills']) ?>" placeholder="HTML, CSS, PHP, MySQL">

            <label>Bio</label>
            <textarea name="bio" rows="6" placeholder="Tell other students about yourself..."><?= htmlspecialchars($user['bio']) ?></textarea>

            <button type="submit" name="saveBtn">Save Changes</button>
        </form>
    </div>
</div>
</body>
</html>
