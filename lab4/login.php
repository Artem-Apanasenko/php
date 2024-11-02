<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: welcome.php");
        exit();
    } else {
        $error = "Невірне ім'я користувача або пароль";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Вхід</title>
    <meta charset="UTF-8">
</head>
<body>
<h2>Вхід</h2>
<?php if (isset($error)) echo "<p style='color: red'>$error</p>"; ?>
<form method="POST">
    <div>
        <label>Ім'я користувача:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Увійти</button>
</form>
<p>Немає акаунту? <a href="register.php">Зареєструватися</a></p>
</body>
</html>