<?php
require_once "Database.php";

class Admin {
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->conn;
    }

    public function checkAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, users_name, users_email, role FROM users");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function addUser($name, $email, $password, $role) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (users_name, users_email, users_password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hash, $role);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email, $password, $role) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE users SET users_name=?, users_email=?, users_password=?, role=? WHERE id=?");
            $stmt->bind_param("ssssi", $name, $email, $hash, $role, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET users_name=?, users_email=?, role=? WHERE id=?");
            $stmt->bind_param("sssi", $name, $email, $role, $id);
        }
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS cnt FROM tickets WHERE user_id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result['cnt'] > 0) {
            return false; 
        }

        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
