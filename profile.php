<?php
include 'auth_check.php';
include 'db.php';

$profile_id = isset($_GET['id']) ? (int)$_GET['id'] : (int)$_SESSION['user_id'];

$user_result = $conn->query("SELECT * FROM users WHERE user_id=$profile_id");
if(!$user_result || $user_result->num_rows == 0){
    die('User not found.');
}
$user = $user_result->fetch_assoc();

$portfolio_result = $conn->query("SELECT * FROM portfolio WHERE user_id=$profile_id ORDER BY portfolio_id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['name']) ?> - Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container">
    <div class="profile-header">
        <div class="avatar-large"><?= htmlspecialchars(strtoupper(substr($user['name'], 0, 1))) ?></div>
        <div>
            <h1><?= htmlspecialchars($user['name']) ?></h1>
            <p><?= htmlspecialchars($user['department']) ?> | Student ID: <?= htmlspecialchars($user['student_id']) ?></p>
            <p><?= htmlspecialchars($user['email']) ?></p>
        </div>
        <?php if($profile_id == $_SESSION['user_id']){ ?>
            <a class="button-link" href="edit_profile.php">Edit Profile</a>
        <?php } ?>
    </div>

    <div class="dashboard-columns">
        <div class="form-card">
            <h2>About</h2>
            <p class="long-text"><?= nl2br(htmlspecialchars($user['bio'] ?: 'No bio added yet.')) ?></p>
            <h3>Skills</h3>
            <p><?= htmlspecialchars($user['skills'] ?: 'No skills added yet.') ?></p>
        </div>

        <div class="form-card">
            <div class="section-title">
                <h2>Portfolio</h2>
                <?php if($profile_id == $_SESSION['user_id']){ ?>
                    <a href="add_portfolio.php">+ Add Item</a>
                <?php } ?>
            </div>

            <?php if($portfolio_result && $portfolio_result->num_rows > 0){ ?>
                <?php while($item = $portfolio_result->fetch_assoc()){ ?>
                    <div class="portfolio-item">
                        <h3><?= htmlspecialchars($item['title']) ?></h3>
                        <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                        <p><strong>Skills:</strong> <?= htmlspecialchars($item['skills']) ?></p>
                        <?php if($profile_id == $_SESSION['user_id']){ ?>
                            <a class="danger-link" href="delete_portfolio.php?id=<?= $item['portfolio_id'] ?>" onclick="return confirm('Delete this portfolio item?')">Delete</a>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="muted">No portfolio items added yet.</p>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
