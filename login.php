<?php
// Start session first
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include navbar/header
require_once "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Vienna Classical Nights</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<main class="login-section">
    <div class="login-container">
        <h2>Login</h2>

        <?php
        // Display any error messages from signin.php
        if (!empty($_SESSION["error_message"])) {
            echo '<p class="error-message">' . $_SESSION["error_message"] . '</p>';
            unset($_SESSION["error_message"]); // clear it so it doesn’t repeat
        }
        ?>

        <form action="signin.php" method="post">
            <label for="name">Name or Email</label>
            <input type="text" id="name" name="fullname" placeholder="Enter name or email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit" name="submit" class="login-button">Login</button>
        </form>

        <p class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </p>
    </div>
</main>

<footer>
    <p>© Vienna Classical Nights | Vienna, Austria</p>
</footer>

</body>
</html>
