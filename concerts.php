<?php
    session_start();
    require_once "header.php"; 
    require_once "connect.php";

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Vienna Classical Nights | Concerts</title>
    <link rel="stylesheet" href="styles.css" />
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap"
        rel="stylesheet" />
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

        <!-- CONCERT 1 -->
        <section class="concert-day-hero"
            style="background-image: url('images/image11.jpg');">
            <div class="concert-day-hero-overlay">
                <div class="concert-day-info">
                    <h3>Saturday, January 10th, 2026</h3>
                    <h2>The Genius of Mozart</h2>
                    <p>Musikverein Golden Hall | 19:30 | Featuring Vienna Residence Orchestra</p>
                    <a href="#" class="buy-button">Buy Tickets</a>
                </div>
            </div>
        </section>

        <!-- CONCERT 2 -->
        <section class="concert-day-hero"
            style="background-image: url('images/image22.jpg');">
            <div class="concert-day-hero-overlay">
                <div class="concert-day-info">
                    <h3>Sunday, January 18th, 2026</h3>
                    <h2>Strauss Waltz Gala</h2>
                    <p>Vienna State Opera | 20:00 | Featuring Wiener Philharmoniker</p>
                    <a href="#" class="buy-button">Buy Tickets</a>
                </div>
            </div>
        </section>

        <!-- CONCERT 3 -->
        <section class="concert-day-hero"
            style="background-image: url('images/image33.jpg');">
            <div class="concert-day-hero-overlay">
                <div class="concert-day-info">
                    <h3>Friday, January 30th, 2026</h3>
                    <h2>Beethoven's 5th Symphony</h2>
                    <p>Konzerthaus | 18:00 | Featuring Various International Artists</p>
                    <a href="#" class="buy-button">Buy Tickets</a>
                </div>
            </div>
        </section>

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
