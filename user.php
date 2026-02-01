<?php
require_once "Database.php";

class User {
    private $conn;

    public function __construct(Database $db) {
        $this->conn = $db->conn;
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, users_name, users_email, role FROM users");
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT id, users_name, users_email, role FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addUser($name, $email, $password, $role="user") {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO users (users_name, users_email, users_password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed, $role);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET users_name=?, users_email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $email, $role, $id);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
