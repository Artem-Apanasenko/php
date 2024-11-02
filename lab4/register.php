<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Хешування пароля

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$username, $email, $password]);
        header("Location: login.php");
        exit();
    } catch(PDOException $e) {
        $error = "Помилка реєстрації: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Реєстрація</title>
    <meta charset="UTF-8">
</head>
<body>
<h2>Реєстрація</h2>
<?php if (isset($error)) echo "<p style='color: red'>$error</p>"; ?>
<form method="POST">
    <div>
        <label>Ім'я користувача:</label>
        <input type="text" name="username" required>
    </div>
    <div>
        <label>Email:</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Пароль:</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit">Зареєструватися</button>
</form>
<p>Вже маєте акаунт? <a href="login.php">Увійти</a></p>
</body>
</html>
