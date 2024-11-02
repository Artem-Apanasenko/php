<?php
session_start();

$valid_username = "admin";
$valid_password = "password123";

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $valid_username && $_POST['password'] === $valid_password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['last_activity'] = time();
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Check session timeout (5 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 300)) {
    session_destroy();
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['logged_in'])) {
    $_SESSION['last_activity'] = time();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Example</title>
</head>
<body>
<?php if (!isset($_SESSION['logged_in'])): ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Login">
    </form>
<?php else: ?>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
    <p>Last activity: <?php echo date('Y-m-d H:i:s', $_SESSION['last_activity']); ?></p>
    <form method="POST">
        <input type="hidden" name="logout" value="1">
        <input type="submit" value="Logout">
    </form>
<?php endif; ?>
</body>
</html>
