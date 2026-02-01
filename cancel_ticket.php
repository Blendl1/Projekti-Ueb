<?php
session_start();
require_once "Database.php";
require_once "Ticket.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = (int)$_POST['ticket_id'];
    $db = new Database();
    $ticketObj = new Ticket($db);

    $ticketObj->cancelTicket($ticket_id, $_SESSION['user_id']);
}

header("Location: my_tickets.php");
exit;
