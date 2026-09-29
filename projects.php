<?php
include 'auth_check.php';
include 'db.php';

$search = '';
$type = '';

// Optional simple search and type filter.
if(isset($_GET['search'])){
    $search = $conn->real_escape_string(trim($_GET['search']));
}
if(isset($_GET['type'])){
    $type = $conn->real_escape_string(trim($_GET['type']));
}

$sql = "SELECT projects.*, users.name FROM projects
        JOIN users ON projects.user_id = users.user_id WHERE 1=1";

if($search != ''){
    $sql .= " AND (projects.title LIKE '%$search%' OR projects.skills_needed LIKE '%$search%')";
}
if($type != ''){
    $sql .= " AND projects.project_type='$type'";
}

$sql .= " ORDER BY projects.project_id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="page-container">
    <div class="section-title">
        <h1>Explore Projects & Gigs</h1>
        <a class="button-link" href="create_project.php">Post Project</a>
    </div>

    <form class="filter-form" method="get">
        <input type="text" name="search" placeholder="Search title or skill" value="<?= htmlspecialchars($search) ?>">
        <select name="type">
            <option value="">All Types</option>
            <option <?= $type == 'Personal Project' ? 'selected' : '' ?>>Personal Project</option>
            <option <?= $type == 'Research' ? 'selected' : '' ?>>Research</option>
            <option <?= $type == 'Freelance Gig' ? 'selected' : '' ?>>Freelance Gig</option>
            <option <?= $type == 'Academic Project' ? 'selected' : '' ?>>Academic Project</option>
            <option <?= $type == 'Other' ? 'selected' : '' ?>>Other</option>
        </select>
        <button type="submit">Search</button>
        <a class="clear-link" href="projects.php">Clear</a>
    </form>

    <div class="card-list">
        <?php if($result && $result->num_rows > 0){ ?>
            <?php while($row = $result->fetch_assoc()){ ?>
                <div class="project-card">
                    <div class="card-top">
                        <span class="tag type-tag"><?= htmlspecialchars($row['project_type']) ?></span>
                        <span class="status <?= strtolower($row['status']) == 'open' ? 'open' : 'closed' ?>"><?= htmlspecialchars($row['status']) ?></span>
                    </div>
                    <h3><?= htmlspecialchars($row['title']) ?></h3>
                    <p class="muted">Posted by <?= htmlspecialchars($row['name']) ?></p>
                    <p><?= htmlspecialchars(substr($row['description'], 0, 160)) ?>...</p>
                    <p><strong>Skills:</strong> <?= htmlspecialchars($row['skills_needed']) ?></p>
                    <a class="small-button" href="project_details.php?id=<?= $row['project_id'] ?>">View Details</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="empty-box">No matching projects found.</div>
        <?php } ?>
    </div>
</div>
</body>
</html>
