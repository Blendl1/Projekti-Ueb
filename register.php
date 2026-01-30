<?php
session_start();
require_once "header.php"; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vienna Classical Nights - Sign Up</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<?php
if (isset($_SESSION["error_message"])) {
    echo '<p style="color:red;">' . $_SESSION["error_message"] . '</p>';
    unset($_SESSION["error_message"]); // clear it so it doesn’t show again
}
?>

<main class="register-section">
    <div class="register-container">
        <h2>Sign up</h2>
        <form action="signup.php" method="post">
            <label for="name">Name</label>
            <input type="text" id="name" name="fullname" placeholder="Type your name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Type your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Type your password" minlength="3" required>

            <button type="submit" name ="submit" class="signup-button">Sign up</button>
        </form>
        <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
    </div>
</main>


</body>

</html>
