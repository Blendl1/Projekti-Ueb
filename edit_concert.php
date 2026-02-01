<?php
session_start();
require_once "Database.php";
require_once "Concert.php";
require_once "Admin.php";
require_once "header.php";

$db = new Database();
$concertObj = new Concert($db);
$admin = new Admin($db);

if (!$admin->checkAdmin()) {
    header("Location: login.php");
    exit();
}

$concert_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$concert = $concertObj->getConcertById($concert_id);

if (!$concert) {
    die("Concert not found.");
}

$success_msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $image_path = !empty($_POST['image_path']) ? $_POST['image_path'] : $concert['image_path'];

    $concertObj->updateConcert(
        $concert_id,
        $_POST['title'],
        $_POST['concert_date'],
        $_POST['concert_time'],
        $_POST['venue'],
        $_POST['price'],
        $image_path
    );
    $success_msg = "Concert updated successfully!";
    $concert = $concertObj->getConcertById($concert_id); // Refresh data
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Concert | Vienna Nights</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="sidebar">
    <h2>VIENNA CLASSICAL NIGHTS</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_concerts.php">Manage Concerts</a>
    <a href="logout.php" class="logout-btn">Sign Out</a>
</div>

<div class="main-content">
    <h1>Edit Concert</h1>

    <?php if($success_msg): ?>
        <p style="color:green;"><?= $success_msg ?></p>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <input type="text" name="title" value="<?= htmlspecialchars($concert['title']) ?>" required>
        <input type="date" name="concert_date" value="<?= $concert['concert_date'] ?>" required>
        <input type="time" name="concert_time" value="<?= substr($concert['concert_time'],0,5) ?>" required>
        <input type="text" name="venue" value="<?= htmlspecialchars($concert['venue']) ?>" required>
        <input type="number" step="0.01" name="price" value="<?= $concert['price'] ?>" required>
        <input type="text" name="image_path" value="<?= htmlspecialchars($concert['image_path']) ?>" required>
        <button type="submit">Update Concert</button>
    </form>
</div>
</body>
</html>
