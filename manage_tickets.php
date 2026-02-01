<?php
require_once "Database.php";

class Ticket {
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->conn;
    }

    public function getAllTickets() {
        $stmt = $this->conn->prepare("
            SELECT t.id AS ticket_id, u.users_name, u.users_email, c.title AS concert_title, t.quantity, t.total_price, c.concert_date 
            FROM tickets t
            JOIN users u ON t.user_id = u.id
            JOIN concerts c ON t.concert_id = c.id
            ORDER BY c.concert_date DESC
        ");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTicketsByUser($user_id) {
        $stmt = $this->conn->prepare("
            SELECT t.id AS ticket_id, c.title AS concert_title, t.quantity, t.total_price, c.concert_date 
            FROM tickets t
            JOIN concerts c ON t.concert_id = c.id
            WHERE t.user_id=?
        ");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTicketCount($user_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM tickets WHERE user_id=?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['count'];
    }
}
