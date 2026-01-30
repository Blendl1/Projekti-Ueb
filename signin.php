<?php
session_start();
require_once "login-contr.classes.php";

if (isset($_POST["submit"])) {
    $uid = $_POST["fullname"];
    $pwd = $_POST["password"];

    $login = new LoginContr($uid, $pwd);
    $user = $login->loginUser();

    if ($user) {
      
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["users_name"];
        $_SESSION["role"] = $user["role"]; 

      
        if ($user["role"] === "admin") {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $_SESSION["error_message"] = "Invalid username or password.";
        header("Location: login.php");
        exit();
    }
}
