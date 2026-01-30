<?php
require_once "dbh.classes.php";

class LoginContr extends Dbh{
    private $uid;
    private $password;

    public function __construct($uid, $password) {
        $this->uid = $uid;
        $this->password = $password;
    }

    public function loginUser() {
        $uid = $this->uid;
        $pwd = $this->password;

        include_once "dbh.classes.php";

        $conn = (new Dbh())->connect();

        $stmt = $conn->prepare("SELECT * FROM users WHERE users_name=? OR users_email=?");
        $stmt->execute([$uid, $uid]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pwd, $user["users_password"])) {
            return $user;
        } else {
            return false;
        }
    }
}
