<?php
class Database {
    private $host = "localhost";
    private $user = "useri";
    private $pass = "password";
    private $db_name = "database";
    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}
