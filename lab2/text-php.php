<?php
$log_file = 'log.txt';

// Функція для запису в лог з датою та часом
function writeToLog($text) {
    global $log_file;
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] $text\n";
    return file_put_contents($log_file, $log_entry, FILE_APPEND);
}

// Обробка POST запиту
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logtext'])) {
    $text = trim($_POST['logtext']);
    if (!empty($text)) {
        $result = writeToLog($text);
        $message = $result !== false ? "Текст успішно додано до логу" : "Помилка при записі в лог";
    } else {
        $message = "Текст не може бути порожнім";
    }
}

// Читаємо вміст лог-файлу
$log_content = file_exists($log_file) ? file_get_contents($log_file) : '';
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Перегляд логу</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success { background-color: #dff0d8; color: #3c763d; }
        .error { background-color: #f2dede; color: #a94442; }
        .log-content {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            white-space: pre-line;
            margin-top: 20px;
        }
        .back-link {
            margin-top: 20px;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Вміст лог-файлу</h2>
    
    <?php if (isset($message)): ?>
        <div class="message <?php echo strpos($message, 'успішно') !== false ? 'success' : 'error'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    
    <div class="log-content">
        <?php echo htmlspecialchars($log_content); ?>
    </div>
    
    <div class="back-link">
        <a href="index.html">← Повернутися на головну</a>
    </div>
</body>
</html>
