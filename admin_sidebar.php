<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>

<div class="sidebar">
    <h2>VIENNA CLASSICAL NIGHTS</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_concerts.php">Manage Concerts</a>
    <a href="manage_users.php">User Management</a>
    <a href="booking_requests.php">Booking Requests</a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>
