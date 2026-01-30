<?php
session_start();
include "connect.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$adminName = $_SESSION['username'];

$query = "SELECT id, users_name, users_email, role FROM users";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Vienna Nights</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="sidebar">
    <h2>VIENNA CLASSICAL NIGHTS</h2>
    <a href="#" class="active">Dashboard</a>
    <a href="#">Manage Concerts</a>
    <a href="#">User Management</a>
    <a href="#">Booking Requests</a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <div class="header">
        <div>
            <h1>Dashboard Overview</h1>
            <p>Welcome back, <?php echo htmlspecialchars($adminName); ?></p>
        </div>
        <div class="date"><?php echo date("F d, Y"); ?></div>
    </div>

    <div class="stats-grid">
        <div class="card">
            <h3>Total Registered</h3>
            <p><?php echo $result->num_rows; ?></p>
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
        <br>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email Address</th>
                    <th>Access Level</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['users_name'] . "</td>";
                        echo "<td>" . $row['users_email'] . "</td>";
                        echo "<td><span class='badge'>" . strtoupper($row['role']) . "</span></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
