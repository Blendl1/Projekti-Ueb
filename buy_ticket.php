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
require_once "Concert.php";
require_once "Ticket.php";
require_once "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$concertObj = new Concert($db);
$ticketObj = new Ticket($db);

$concert_id = isset($_GET['concert_id']) ? (int)$_GET['concert_id'] : 0;
$concert = $concertObj->getConcertById($concert_id);

if (!$concert) {
    die("<p>Concert not found.</p>");
}

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = (int)$_POST['quantity'];
    if ($quantity < 1) {
        $error_msg = "Please enter a valid ticket quantity.";
    } else {
        $total_price = $quantity * $concert['price'];
        if ($ticketObj->buyTicket($concert_id, $_SESSION['user_id'], $quantity, $total_price)) {
            $success_msg = "Purchase successful! You bought $quantity ticket(s) for €$total_price.";
        } else {
            $error_msg = "Purchase failed. Try again.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Tickets | Vienna Classical Nights</title>
    <link rel="stylesheet" href="styles.css" />
</head>
<body>

<main class="concerts-section container">
    <h2>Buy Tickets</h2>


    <section class="concert-day-hero" style="background-image: url('<?php echo htmlspecialchars($concert['image_path']); ?>');">
        <div class="concert-day-hero-overlay">
            <div class="concert-day-info">
                <h3><?php echo date("l, F jS, Y", strtotime($concert['concert_date'])); ?></h3>
                <h2><?php echo htmlspecialchars($concert['title']); ?></h2>
                <p><?php echo htmlspecialchars($concert['venue']); ?> | <?php echo substr($concert['concert_time'],0,5); ?> | €<?php echo $concert['price']; ?></p>
            </div>
        </div>
    </section>

    
    <?php if($success_msg): ?>
        <p style="color:green; font-size:18px; margin-top:20px;"><?php echo $success_msg; ?></p>
        <a href="concerts.php" class="buy-button" style="margin-top:10px;">Back to Concerts</a>
    <?php else: ?>
        <?php if($error_msg): ?>
            <p style="color:red; font-size:16px;"><?php echo $error_msg; ?></p>
        <?php endif; ?>
        <form method="POST" style="margin-top:30px; max-width:400px;">
            <label for="quantity">Number of Tickets:</label>
            <input type="number" id="quantity" name="quantity" min="1" value="1" required
                   style="width:100%; padding:10px; margin:10px 0; border-radius:6px; border:1px solid #ccc;">
            <button type="submit" class="buy-button">Confirm Purchase</button>
        </form>
    <?php endif; ?>

</main>

</body>
</html>
