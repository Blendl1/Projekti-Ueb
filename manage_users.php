<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");

require_once "Database.php";
require_once "admin.php";
require_once "admin_sidebar.php";

$db = new Database();
$admin = new Admin($db);

if (!$admin->checkAdmin()) {
    header("Location: login.php");
    exit;
}

$message = "";

// Add user
if (isset($_POST['add_user'])) {
    if ($admin->addUser($_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
        $message = "User added successfully.";
    } else {
        $message = "Error adding user.";
    }
}

// Update user
if (isset($_POST['update_user'])) {
    if ($admin->updateUser($_POST['id'], $_POST['name'], $_POST['email'], $_POST['password'], $_POST['role'])) {
        $message = "User updated successfully.";
    } else {
        $message = "Error updating user.";
    }
}

// Delete user
if (isset($_GET['delete'])) {
    if ($admin->deleteUser((int)$_GET['delete'])) {
        $message = "User deleted successfully.";
    } else {
        $message = "Cannot delete user: they have existing tickets.";
    }
}

$users = $admin->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management | Vienna Nights</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="main-content">
    <h1>User Management</h1>

    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" class="form-box">
        <input type="hidden" name="id" id="user_id">
        <input type="text" name="name" id="user_name" placeholder="Full Name" required>
        <input type="email" name="email" id="user_email" placeholder="Email" required>
        <input type="password" name="password" id="user_password" placeholder="Password">
        <select name="role" id="user_role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select>
        <button type="submit" name="add_user" id="add_btn">Add User</button>
        <button type="submit" name="update_user" id="update_btn">Update User</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $users->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo htmlspecialchars($user['users_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['users_email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="#" class="edit-btn" data-id="<?php echo $user['id']; ?>"
                            data-name="<?php echo htmlspecialchars($user['users_name']); ?>"
                            data-email="<?php echo htmlspecialchars($user['users_email']); ?>"
                            data-role="<?php echo $user['role']; ?>">Edit</a>
                        <a href="manage_users.php?delete=<?php echo $user['id']; ?>" class="delete-btn">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
const editButtons = document.querySelectorAll(".edit-btn");
editButtons.forEach(btn => {
    btn.addEventListener("click", e => {
        e.preventDefault();
        document.getElementById("user_id").value = btn.dataset.id;
        document.getElementById("user_name").value = btn.dataset.name;
        document.getElementById("user_email").value = btn.dataset.email;
        document.getElementById("user_role").value = btn.dataset.role;
    });
});
</script>
</body>
</html>
