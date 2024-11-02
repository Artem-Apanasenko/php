<?php
// Створюємо директорію uploads, якщо вона не існує
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}

// Перевіряємо, чи був надісланий файл
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["userfile"])) {
    $file = $_FILES["userfile"];
    $response = array(
        'success' => false,
        'message' => '',
        'file_info' => null
    );

    // Перевірка на помилки завантаження
    if ($file["error"] !== UPLOAD_ERR_OK) {
        $response['message'] = "Помилка при завантаженні файлу. Код помилки: " . $file["error"];
    } else {
        // Перевірка, чи це дійсно завантажений файл
        if (!is_uploaded_file($file["tmp_name"])) {
            $response['message'] = "Помилка: файл не був завантажений через форму.";
        } else {
            // Перевірка типу файлу
            $allowed_types = array('image/jpeg', 'image/png', 'image/jpg');
            $file_info = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $file_info->file($file["tmp_name"]);
            
            if (!in_array($mime_type, $allowed_types)) {
                $response['message'] = "Помилка: дозволені тільки зображення (JPG, JPEG, PNG).";
            }
            // Перевірка розміру файлу (2 МБ = 2 * 1024 * 1024 байт)
            elseif ($file["size"] > 2 * 1024 * 1024) {
                $response['message'] = "Помилка: розмір файлу не повинен перевищувати 2 МБ.";
            } else {
                // Генеруємо унікальне ім'я файлу
                $file_extension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $base_name = pathinfo($file["name"], PATHINFO_FILENAME);
                $new_file_name = $base_name;
                $counter = 1;
                
                while (file_exists("uploads/$new_file_name.$file_extension")) {
                    $new_file_name = $base_name . '_' . $counter;
                    $counter++;
                }
                
                $final_file_name = "$new_file_name.$file_extension";
                $destination = "uploads/" . $final_file_name;
                
                // Переміщуємо файл
                if (move_uploaded_file($file["tmp_name"], $destination)) {
                    $response['success'] = true;
                    $response['message'] = "Файл успішно завантажено!";
                    $response['file_info'] = array(
                        'name' => $final_file_name,
                        'type' => $mime_type,
                        'size' => round($file["size"] / 1024, 2) // розмір у КБ
                    );
                } else {
                    $response['message'] = "Помилка при збереженні файлу.";
                }
            }
        }
    }
    
    // Виводимо результат
    ?>
    <!DOCTYPE html>
    <html lang="uk">
    <head>
        <meta charset="UTF-8">
        <title>Результат завантаження</title>
        <style>
            body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; padding: 20px; }
            .success { color: green; }
            .error { color: red; }
            .file-info { margin-top: 20px; }
            .back-link { margin-top: 20px; }
            a { color: #4CAF50; text-decoration: none; }
            a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <h2>Результат завантаження файлу</h2>
        <div class="<?php echo $response['success'] ? 'success' : 'error'; ?>">
            <?php echo $response['message']; ?>
        </div>
        
        <?php if ($response['success'] && $response['file_info']): ?>
            <div class="file-info">
                <h3>Інформація про файл:</h3>
                <p>Ім'я файлу: <?php echo $response['file_info']['name']; ?></p>
                <p>Тип файлу: <?php echo $response['file_info']['type']; ?></p>
                <p>Розмір: <?php echo $response['file_info']['size']; ?> КБ</p>
                <p><a href="uploads/<?php echo $response['file_info']['name']; ?>" download>Завантажити файл</a></p>
            </div>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="index.html">← Повернутися на головну</a>
        </div>
    </body>
    </html>
    <?php
} else {
    header("Location: index.html");
    exit();
}
?>
