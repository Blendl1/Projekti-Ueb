<?php

class Login extends Dbh {

    protected function findUser($uid) {
        $stmt = $this->connect()->prepare(
            "SELECT users_id FROM users WHERE users_name = ? OR users_email = ?"
        );
        $stmt->execute([$uid, $uid]);
        return $stmt->rowCount() > 0;
    }

    protected function verifyPassword($uid, $password) {
        $stmt = $this->connect()->prepare(
            "SELECT users_password FROM users WHERE users_name = ? OR users_email = ?"
        );
        $stmt->execute([$uid, $uid]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return password_verify($password, $user["users_password"]);
    }

    protected function createSession($uid) {
        $stmt = $this->connect()->prepare(
            "SELECT * FROM users WHERE users_name = ? OR users_email = ?"
        );
        $stmt->execute([$uid, $uid]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $_SESSION["userid"] = $user["users_id"];
        $_SESSION["useruid"] = $user["users_name"];
    }
}

