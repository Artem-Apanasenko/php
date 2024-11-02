<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ласкаво просимо</title>
    <meta charset="UTF-8">
</head>
<body>
<h2>Ласкаво просимо, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
<p>Це захищена сторінка, доступна тільки авторизованим користувачам.</p>
<a href="logout.php">Вийти</a>
</body>
</html>