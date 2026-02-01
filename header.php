<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "Database.php";
require_once "Ticket.php";

$ticket_count = 0;
if (!empty($_SESSION["user_id"])) {
    $db = new Database();
    $ticketObj = new Ticket($db);
    $ticket_count = $ticketObj->getTicketCount($_SESSION["user_id"]);
}
?>

<header class="header">
    <div class="logo">Vienna Classical Nights</div>
    <nav>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="concerts.php">Concerts</a></li>

            <?php if (!empty($_SESSION["user_id"])): ?>
                <li>
                    <a href="my_tickets.php">
                        My Tickets <?php if($ticket_count > 0) echo "($ticket_count)"; ?>
                    </a>
                </li>
                <li><a href="#"><?php echo htmlspecialchars($_SESSION["username"]); ?></a></li>
                <li><a href="logout.php" class="header-login-a">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
