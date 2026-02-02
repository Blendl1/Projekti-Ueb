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
require_once "header.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$ticketObj = new Ticket($db);
$tickets = $ticketObj->getUserTickets($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Tickets | Vienna Classical Nights</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="concerts-section container">
    <h2>My Tickets</h2>

    <?php if ($tickets->num_rows > 0): ?>
        <?php while($ticket = $tickets->fetch_assoc()): ?>
            <section class="concert-card" style="background-image: url('<?php echo htmlspecialchars($ticket['image_path'] ?? 'images/default.jpg'); ?>');">
                <div class="concert-card-overlay">
                    <div class="concert-card-info">
                        <h3><?php echo date("l, F jS, Y", strtotime($ticket['concert_date'])); ?></h3>
                        <h2><?php echo htmlspecialchars($ticket['title']); ?></h2>
                        <p>
                            <?php echo htmlspecialchars($ticket['venue']); ?> | 
                            <?php echo substr($ticket['concert_time'], 0, 5); ?> | 
                            €<?php echo $ticket['price']; ?>
                        </p>
                        <p>Quantity: <?php echo $ticket['quantity']; ?></p>
                        <p>Total Price: €<?php echo $ticket['total_price']; ?></p>
                        <form method="POST" action="cancel_ticket.php">
                            <input type="hidden" name="ticket_id" value="<?php echo $ticket['ticket_id']; ?>">
                            <button type="submit" class="buy-button">Cancel Ticket</button>
                        </form>
                    </div>
                </div>
            </section>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; font-size:18px; margin-top:20px;">You have no tickets yet.</p>
    <?php endif; ?>
</main>

</body>
</html>
