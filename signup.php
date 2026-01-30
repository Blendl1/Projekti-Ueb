<?php
session_start();
require_once "signup-contr.classes.php";

if(isset($_POST["submit"])) {
    $name = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $signup = new SignupContr($name, $email, $password);
    $signup->signupUser();
}
