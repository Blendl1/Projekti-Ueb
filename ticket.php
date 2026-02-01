<?php
require_once "Database.php";

class Ticket {
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->conn;
    }

    public function buyTicket($concert_id, $user_id, $quantity, $total_price) {
        $stmt = $this->conn->prepare(
            "INSERT INTO tickets (concert_id, user_id, quantity, total_price, created_at) VALUES (?, ?, ?, ?, NOW())"
        );
        $stmt->bind_param("iiid", $concert_id, $user_id, $quantity, $total_price);
        return $stmt->execute();
    }

    public function getUserTickets($user_id) {
        $stmt = $this->conn->prepare(
            "SELECT t.id AS ticket_id, c.title, c.venue, c.concert_date, c.concert_time, c.price, t.quantity, t.total_price
             FROM tickets t
             JOIN concerts c ON t.concert_id = c.id
             WHERE t.user_id = ?
             ORDER BY t.created_at DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function cancelTicket($ticket_id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM tickets WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $ticket_id, $user_id);
        return $stmt->execute();
    }

    public function getTicketCount($user_id) {
        $stmt = $this->conn->prepare("SELECT SUM(quantity) AS total FROM tickets WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function getAllBookings() {
        $query = "
            SELECT t.id AS ticket_id, u.users_name, u.users_email, 
                   c.title AS concert_title, c.concert_date, c.concert_time, c.venue,
                   t.quantity, t.total_price, t.created_at
            FROM tickets t
            JOIN users u ON t.user_id = u.id
            JOIN concerts c ON t.concert_id = c.id
            ORDER BY t.created_at DESC
        ";
        return $this->conn->query($query);
    }
}
?>
