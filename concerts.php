<?php
session_start();
require_once "Database.php";
require_once "concert.php";
require_once "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$concertObj = new Concert($db);
$concerts = $concertObj->getUpcomingConcerts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vienna Classical Nights | Concerts</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet" />
</head>
<body>

<main class="concerts-section container">

    <!-- Slideshow -->
    <section class="slideshow-container">
        <div class="slides">
            <div class="slide-fade">
                <img src="images/slideshow1.jpg" alt="Vienna Concert Hall">
                <div class="slide-caption">Elegant Venues</div>
            </div>
            <div class="slide-fade">
                <img src="images/slideshow2.jpg" alt="Orchestra Performance">
                <div class="slide-caption">World-Class Orchestras</div>
            </div>
            <div class="slide-fade">
                <img src="images/slideshow3.jpg" alt="Classical Piano">
                <div class="slide-caption">Timeless Masterpieces</div>
            </div>
        </div>
        <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
        <a class="next" onclick="changeSlide(1)">&#10095;</a>
    </section>

    <h2>Upcoming Concerts</h2>

    <?php if ($concerts->num_rows > 0): ?>
        <?php while ($concert = $concerts->fetch_assoc()): ?>
            <section class="concert-day-hero" style="background-image: url('<?= htmlspecialchars($concert['image_path']) ?>');">
                <div class="concert-day-hero-overlay">
                    <div class="concert-day-info">
                        <h3><?= date("l, F jS, Y", strtotime($concert['concert_date'])) ?></h3>
                        <h2><?= htmlspecialchars($concert['title']) ?></h2>
                        <p>
                            <?= htmlspecialchars($concert['venue']) ?> |
                            <?= substr($concert['concert_time'], 0, 5) ?> |
                            €<?= $concert['price'] ?>
                        </p>
                        <a href="buy_ticket.php?concert_id=<?= $concert['id'] ?>" class="buy-button">Buy Tickets</a>
                    </div>
                </div>
            </section>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:18px; margin-top:20px;">No upcoming concerts.</p>
    <?php endif; ?>

</main>

<footer>
    <p>© Vienna Classical Nights | Vienna, Austria</p>
    <ul class="footer-links">
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Contact</a></li>
    </ul>
</footer>

<script src="script.js"></script>
</body>
</html>
