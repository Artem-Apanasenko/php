<?php
if (isset($_POST['username'])) {
    setcookie('username', $_POST['username'], time() + (7 * 24 * 60 * 60));
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['delete_cookie'])) {
    setcookie('username', '', time() - 3600);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cookie Example</title>
</head>
<body>
<?php if (!isset($_COOKIE['username'])): ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter your name">
        <input type="submit" value="Save">
    </form>
<?php else: ?>
    <h2>Welcome back, <?php echo htmlspecialchars($_COOKIE['username']); ?>!</h2>
    <form method="POST">
        <input type="hidden" name="delete_cookie" value="1">
        <input type="submit" value="Delete Cookie">
    </form>
<?php endif; ?>
</body>
</html>