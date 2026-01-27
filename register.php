<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vienna Classical Nights</title>
    <link rel="stylesheet" href="styles.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap"
        rel="stylesheet">
</head>
</head>

<body>
    <header class="header">
        <div class="logo">Vienna Classical Nights</div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="concerts.php">Concerts</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>



    <main class="register-section">
        <div class="register-container">
            <h2>Sign up</h2>
            <form action="#" method="post">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Type your name" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Type your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Type your password" minlength="6"
                    required>

                <button type="submit" class="signup-button">Sign up</button>
            </form>
            <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
        </div>
    </main>


</body>