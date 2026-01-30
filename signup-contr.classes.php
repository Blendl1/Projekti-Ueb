<?php
require_once "signup.classes.php";

class SignupContr extends Signup {

    private $name;
    private $email;
    private $password;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function signupUser() {
        if (!$this->invalidName()) {
            $_SESSION["error_message"] = "Invalid username!";
            header("location: register.php");
            exit();
        }

        if (!$this->invalidEmail()) {
            $_SESSION["error_message"] = "Invalid email address!";
            header("location: register.php");
            exit();
        }

        if ($this->emailTaken()) {
            $_SESSION["error_message"] = "The email is already used!";
            header("location: register.php");
            exit();
        }

        if ($this->nameTaken()) {
            $_SESSION["error_message"] = "The username is already taken!";
            header("location: register.php");
            exit();
        }


        $this->setUser($this->name, $this->email, $this->password);

        $user = $this->getUser($this->email);
        if ($user) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["users_name"];
        }

        header("location: index.php");
        exit();
    }

    private function invalidName() {
        return preg_match("/^[a-zA-Z0-9]{3,20}$/", $this->name);
    }

    private function invalidEmail() {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL);
    }

    private function emailTaken() {
        return $this->emailExists($this->email);
    }

    private function nameTaken() {
        return $this->nameExists($this->name);
    }
}
