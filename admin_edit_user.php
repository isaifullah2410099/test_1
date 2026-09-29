<?php
include 'admin_check.php';
include 'db.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$message = '';
$message_type = '';

// Save edited user information.
if(isset($_POST['saveBtn'])){
    $student_id = $conn->real_escape_string(trim($_POST['student_id']));
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $department = $conn->real_escape_string(trim($_POST['department']));
    $skills = $conn->real_escape_string(trim($_POST['skills']));
    $bio = $conn->real_escape_string(trim($_POST['bio']));

    // Check if another account already uses the new student ID.
    $check_sql = "SELECT user_id FROM users WHERE student_id='$student_id' AND user_id!=$user_id";
    $check_result = $conn->query($check_sql);

    if($check_result && $check_result->num_rows > 0){
        $message = 'Another user already has that Student ID.';
        $message_type = 'error';
    }
    else{
        $sql = "UPDATE users SET student_id='$student_id', name='$name', email='$email', department='$department', skills='$skills', bio='$bio'
                WHERE user_id=$user_id";
        $conn->query($sql);
        $message = 'User profile updated.';
        $message_type = 'success';
    }
}

$result = $conn->query("SELECT * FROM users WHERE user_id=$user_id");
if(!$result || $result->num_rows == 0){
    die('User not found.');
}
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="page-container narrow-page">
    <div class="form-card">
        <div class="section-title">
            <h1>Edit User</h1>
            <a href="admin_users.php">Back</a>
        </div>

        <?php if($message != ''){ ?>
            <p class="message <?= $message_type ?>"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="post">
            <label>Student ID</label>
            <input type="text" name="student_id" value="<?= htmlspecialchars($user['student_id']) ?>" required>

            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Department</label>
            <input type="text" name="department" value="<?= htmlspecialchars($user['department']) ?>" required>

            <label>Skills</label>
            <input type="text" name="skills" value="<?= htmlspecialchars($user['skills']) ?>">

            <label>Bio</label>
            <textarea name="bio" rows="6"><?= htmlspecialchars($user['bio']) ?></textarea>

            <button type="submit" name="saveBtn">Save Changes</button>
        </form>
    </div>
</div>
</body>
</html>
