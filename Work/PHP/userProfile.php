<?php
require 'DB_Connection.php';
require 'db_table.php';

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to login page or display an error message
    header("Location: login.php");
    exit;
}

// Get the current user's details from the database
$userID = $_SESSION['id'];
$sql = "SELECT * FROM login WHERE id = :id";
$stmt = $connection->prepare($sql);
$stmt->bindParam(':id', $userID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form data
    $errors = [];

    if (!preg_match('/^\w{4,20}$/', $newUsername)) {
        $errors['username'] = 'Username must be between 4 and 20 characters and can only contain letters, numbers, and underscores.';
    }

    if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email address.';
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W])[a-zA-Z\d\W]{8,}$/', $newPassword)) {
        $errors['password'] = 'Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, one number, and one special character.';
    }

    if ($newPassword !== $confirmPassword) {
        $errors['confirm_password'] = 'Password confirmation does not match.';
    }

    // If there are no errors, update user data in the database
    if (empty($errors)) {
        $updateSql = "UPDATE login SET username = :username, email = :email, password = :password WHERE id = :id";
        $updateStmt = $connection->prepare($updateSql);
        $updateStmt->bindParam(':username', $newUsername);
        $updateStmt->bindParam(':email', $newEmail);

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt->bindParam(':password', $hashedPassword);

        $updateStmt->bindParam(':id', $userID);
        $updateStmt->execute();

        $_SESSION['username'] = $newUsername;
        $_SESSION['email'] = $newEmail;

        header("Location: Home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>User Profile</h1>

        <h2>Welcome, <?php echo $user['username']; ?></h2>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" value="<?php echo $user['username']; ?>">
                <?php if (isset($errors['username'])): ?>
                    <div class="error-message"><?php echo $errors['username']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $user['email']; ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="error-message"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control">
                <?php if (isset($errors['password'])): ?>
                    <div class="error-message"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                <?php if (isset($errors['confirm_password'])): ?>
                    <div class="error-message"><?php echo $errors['confirm_password']; ?></div>
                <?php endif; ?>
            </div>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>

    <script src="validate_input_live.js"></script>
</body>
</html>
