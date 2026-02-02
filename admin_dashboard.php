<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "Database.php";
require_once "Admin.php";

$db = new Database();
$admin = new Admin($db);

if (!$admin->checkAdmin()) {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['username'];
$users = $admin->getAllUsers();
$totalUsers = $users->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Vienna Nights</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<?php require_once "admin_sidebar.php"; ?>

<div class="main-content">
    <div class="header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back, <?= htmlspecialchars($adminName) ?></p>
        </div>
        <div class="date"><?= date("F d, Y") ?></div>
    </div>

    <div class="stats-grid">
        <div class="card">
            <h3>Total Registered Users</h3>
            <p><?= $totalUsers ?></p>
        </div>
        <div class="card">
            <h3>System Status</h3>
            <p>Online</p>
        </div>
        <div class="card">
            <h3>Current Role</h3>
            <p>Administrator</p>
        </div>
    </div>

    <div class="table-container">
        <h3>Registered Users</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php if($users->num_rows > 0): ?>
                    <?php while($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['users_name']) ?></td>
                            <td><?= htmlspecialchars($row['users_email']) ?></td>
                            <td><?= strtoupper($row['role']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No users found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
                    