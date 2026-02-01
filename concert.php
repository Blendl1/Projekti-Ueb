<?php
require_once "Database.php";

class Concert {
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->conn;
    }

    public function getUpcomingConcerts() {
        $stmt = $this->conn->prepare("SELECT * FROM concerts WHERE concert_date >= CURDATE() ORDER BY concert_date ASC");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getConcertById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM concerts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllConcerts() {
        $stmt = $this->conn->prepare("SELECT * FROM concerts ORDER BY concert_date ASC");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addConcert($title, $date, $time, $venue, $price, $image, $created_by) {
        $stmt = $this->conn->prepare(
            "INSERT INTO concerts (title, concert_date, concert_time, venue, price, image_path, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssdsi", $title, $date, $time, $venue, $price, $image, $created_by);
        return $stmt->execute();
    }

    public function updateConcert($id, $title, $date, $time, $venue, $price, $image) {
        $stmt = $this->conn->prepare(
            "UPDATE concerts SET title=?, concert_date=?, concert_time=?, venue=?, price=?, image_path=? WHERE id=?"
        );
        $stmt->bind_param("ssssdsi", $title, $date, $time, $venue, $price, $image, $id);
        return $stmt->execute();
    }

    public function deleteConcert($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS cnt FROM tickets WHERE concert_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['cnt'] > 0) {
            return false;
        }

        $stmt = $this->conn->prepare("DELETE FROM concerts WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
