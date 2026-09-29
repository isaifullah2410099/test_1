<?php
include 'db.php';

$message = '';
$message_type = '';

// Register a new student when the form is submitted.
if(isset($_POST['registerBtn'])){
    $student_id = $conn->real_escape_string(trim($_POST['student_id']));
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $department = $conn->real_escape_string(trim($_POST['department']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $security_question = $conn->real_escape_string($_POST['security_question']);
    $security_answer = trim($_POST['security_answer']);

    // First check if the student ID already exists.
    $check_sql = "SELECT * FROM users WHERE student_id='$student_id'";
    $check_result = $conn->query($check_sql);

    if($check_result && $check_result->num_rows > 0){
        $message = 'This Student ID is already registered.';
        $message_type = 'error';
    }
    else if($password != $confirm_password){
        $message = 'Passwords do not match.';
        $message_type = 'error';
    }
    else if(strlen($password) < 6){
        $message = 'Password must be at least 6 characters.';
        $message_type = 'error';
    }
    else{
        // Passwords are hashed before saving them in the database.
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $answer_hash = password_hash(strtolower($security_answer), PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(student_id, name, email, department, password, security_question, security_answer)
                VALUES('$student_id', '$name', '$email', '$department', '$password_hash', '$security_question', '$answer_hash')";

        if($conn->query($sql) === TRUE){
            $message = 'Registration successful. You can login now.';
            $message_type = 'success';
        }
        else{
            $message = 'Registration failed.';
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - UIU CollabHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <div class="auth-box wide">
        <h1>Create Student Account</h1>
        <p class="subtitle">Register before using the collaboration website</p>

        <?php if($message != ''){ ?>
            <p class="message <?= $message_type ?>"><?= htmlspecialchars($message) ?></p>
        <?php } ?>

        <form method="post" action="register.php">
            <label>Student ID</label>
            <input type="text" name="student_id" required>

            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Department</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <option>CSE</option>
                <option>EEE</option>
                <option>BBA</option>
                <option>Economics</option>
                <option>English</option>
                <option>Other</option>
            </select>

            <label>Password</label>
            <input type="password" name="password" id="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" required>
            <p id="passwordMessage" class="small-text"></p>

            <label>Security Question</label>
            <select name="security_question" required>
                <option value="">Select a question</option>
                <option>What is the name of your first school?</option>
                <option>What is your favourite teacher's name?</option>
                <option>What is your favourite food?</option>
                <option>What is the name of your childhood friend?</option>
            </select>

            <label>Security Answer</label>
            <input type="text" name="security_answer" required>

            <button type="submit" name="registerBtn">Register</button>
        </form>

        <p>Already registered? <a href="index.php">Back to Login</a></p>
    </div>
    <script src="script.js"></script>
</body>
</html>
