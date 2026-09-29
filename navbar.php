<?php
// This file is included on student pages to keep the navbar the same.
?>
<div class="navbar">
    <a class="brand" href="home.php">UIU CollabHub</a>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="projects.php">Explore</a>
        <a href="create_project.php">Post Project</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="profile.php?id=<?= $_SESSION['user_id'] ?>">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</div>
