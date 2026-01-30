<?php
require_once "dbh.classes.php";

class Signup extends Dbh {

    protected function setUser($name, $email, $password) {
        $stmt = $this->connect()->prepare(
            "INSERT INTO users (users_name, users_email, users_password)
             VALUES (?, ?, ?)"
        );

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$name, $email, $hashedPassword]);
    }

    protected function emailExists($email) {
        $stmt = $this->connect()->prepare(
            "SELECT users_email FROM users WHERE users_email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    protected function nameExists($name) {
        $stmt = $this->connect()->prepare(
            "SELECT users_name FROM users WHERE users_name = ?"
        );
        $stmt->execute([$name]);
        return $stmt->rowCount() > 0;
    }

    protected function getUser($email) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM users WHERE users_email = ?"
        );
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
