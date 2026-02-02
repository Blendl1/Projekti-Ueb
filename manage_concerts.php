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
require_once "admin.php";
require_once "concert.php";
require_once "admin_sidebar.php";

$db = new Database();
$admin = new Admin($db);
$concertObj = new Concert($db);

if (!$admin->checkAdmin()) {
    header("Location: login.php");
    exit;
}

$activePage = 'manage_concerts';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['concert_id']) && $_POST['concert_id'] != '') {
        $concertObj->updateConcert(
            $_POST['concert_id'],
            $_POST['title'],
            $_POST['concert_date'],
            $_POST['concert_time'],
            $_POST['venue'],
            $_POST['price'],
            $_POST['image_path']
        );
    } else {
        $concertObj->addConcert(
            $_POST['title'],
            $_POST['concert_date'],
            $_POST['concert_time'],
            $_POST['venue'],
            $_POST['price'],
            $_POST['image_path'],
            $_SESSION['user_id']
        );
    }
}

if (isset($_GET['delete'])) {
    $concertObj->deleteConcert((int)$_GET['delete']);
}

$concerts = $concertObj->getAllConcerts();
$editConcert = null;

if (isset($_GET['edit'])) {
    $editConcert = $concertObj->getConcertById((int)$_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Concerts | Vienna Nights</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

<?php include "admin_sidebar.php"; ?>

<div class="main-content">
    <h1>Manage Concerts</h1>

    <form method="POST" class="form-box">
        <input type="hidden" name="concert_id" value="<?= $editConcert['id'] ?? '' ?>">
        <input type="text" name="title" placeholder="Concert title" required value="<?= $editConcert['title'] ?? '' ?>">
        <input type="date" name="concert_date" required value="<?= $editConcert['concert_date'] ?? '' ?>">
        <input type="time" name="concert_time" required value="<?= $editConcert['concert_time'] ?? '' ?>">
        <input type="text" name="venue" placeholder="Venue" required value="<?= $editConcert['venue'] ?? '' ?>">
        <input type="number" step="0.01" name="price" placeholder="Price (€)" required value="<?= $editConcert['price'] ?? '' ?>">
        <input type="text" name="image_path" placeholder="Image path" required value="<?= $editConcert['image_path'] ?? '' ?>">
        <button type="submit"><?= $editConcert ? 'Update Concert' : 'Add Concert' ?></button>
        <?php if ($editConcert): ?>
            <a href="manage_concerts.php" class="cancel-edit">Cancel</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $concerts->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= $row['concert_date'] ?></td>
                <td><?= substr($row['concert_time'],0,5) ?></td>
                <td><?= htmlspecialchars($row['venue']) ?></td>
                <td>€<?= $row['price'] ?></td>
                <td>
                    <a href="manage_concerts.php?edit=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="manage_concerts.php?delete=<?= $row['id'] ?>" class="danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
