<?php
include 'admin_check.php';
include 'db.php';

// Count information for the admin dashboard.
$user_result = $conn->query("SELECT COUNT(*) AS total FROM users");
$total_users = $user_result->fetch_assoc()['total'];

$project_result = $conn->query("SELECT COUNT(*) AS total FROM projects");
$total_projects = $project_result->fetch_assoc()['total'];

$app_result = $conn->query("SELECT COUNT(*) AS total FROM applications");
$total_applications = $app_result->fetch_assoc()['total'];

$portfolio_result = $conn->query("SELECT COUNT(*) AS total FROM portfolio");
$total_portfolio = $portfolio_result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'admin_navbar.php'; ?>
<div class="page-container">
    <div class="hero admin-hero">
        <div>
            <h1>Welcome, Admin</h1>
            <p>Manage student profiles and projects from this panel.</p>
        </div>
    </div>

    <div class="stats-row">
        <div class="stat-card"><span><?= $total_users ?></span><p>Users</p></div>
        <div class="stat-card"><span><?= $total_projects ?></span><p>Projects</p></div>
        <div class="stat-card"><span><?= $total_applications ?></span><p>Applications</p></div>
        <div class="stat-card"><span><?= $total_portfolio ?></span><p>Portfolio Items</p></div>
    </div>

    <div class="dashboard-columns">
        <div class="form-card">
            <h2>Manage Users</h2>
            <p>View student accounts, edit profile information or remove an account.</p>
            <a class="button-link" href="admin_users.php">Open User Manager</a>
        </div>

        <div class="form-card">
            <h2>Manage Projects</h2>
            <p>Edit or remove project posts and freelance gigs.</p>
            <a class="button-link" href="admin_projects.php">Open Project Manager</a>
        </div>
    </div>

    <div class="demo-note admin-note">
        <strong>Demo login:</strong> username <code>admin</code> and password <code>1234</code>.
        This hard-coded admin login is only for the class project.
    </div>
</div>
</body>
</html>
