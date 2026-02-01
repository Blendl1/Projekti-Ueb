<?php
session_start();
require_once "Database.php";
require_once "Admin.php";
require_once "header.php";

$db = new Database();
$admin = new Admin($db);

if (!$admin->checkAdmin()) {
    header("Location: login.php");
    exit;
}

$tickets = $admin->getAllTickets();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Requests | Vienna Nights</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="sidebar">
    <h2>VIENNA CLASSICAL NIGHTS</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_concerts.php">Manage Concerts</a>
    <a href="manage_users.php">User Management</a>
    <a href="manage_bookings.php" class="active">Booking Requests</a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <h1>Booking Requests</h1>
    <table>
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>User Name</th>
                <th>User Email</th>
                <th>Concert</th>
                <th>Quantity</th>
                <th>Total Price (€)</th>
            </tr>
        </thead>
        <tbody>
            <?php if($tickets->num_rows > 0): ?>
                <?php while($row = $tickets->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ticket_id'] ?></td>
                        <td><?= htmlspecialchars($row['users_name']) ?></td>
                        <td><?= htmlspecialchars($row['users_email']) ?></td>
                        <td><?= htmlspecialchars($row['concert_title']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td>€<?= $row['total_price'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align:center;">No bookings found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
