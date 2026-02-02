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
require_once "Ticket.php";

$db = new Database();
$ticketObj = new Ticket($db);
$bookings = $ticketObj->getAllBookings();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking Requests | Vienna Classical Nights</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<div class="sidebar">
    <h2>VIENNA CLASSICAL NIGHTS</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_concerts.php">Manage Concerts</a>
    <a href="manage_users.php">User Management</a>
    <a href="booking_requests.php" class="active">Booking Requests</a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <h1>Booking Requests</h1>

    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ticket ID</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>Concert Title</th>
                    <th>Concert Date</th>
                    <th>Concert Time</th>
                    <th>Venue</th>
                    <th>Quantity</th>
                    <th>Total Price (€)</th>
                    <th>Purchased At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $bookings->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ticket_id'] ?></td>
                        <td><?= htmlspecialchars($row['users_name']) ?></td>
                        <td><?= htmlspecialchars($row['users_email']) ?></td>
                        <td><?= htmlspecialchars($row['concert_title']) ?></td>
                        <td><?= $row['concert_date'] ?></td>
                        <td><?= substr($row['concert_time'], 0, 5) ?></td>
                        <td><?= htmlspecialchars($row['venue']) ?></td>
                        <td><?= $row['quantity'] ?></td>
                        <td>€<?= $row['total_price'] ?></td>
                        <td><?= $row['created_at'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
