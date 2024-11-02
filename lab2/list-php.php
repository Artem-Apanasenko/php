<?php
$upload_dir = 'uploads';

// Створюємо директорію, якщо вона не існує
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Отримуємо список файлів
$files = array_diff(scandir($upload_dir), array('.', '..'));

// Сортуємо файли за часом модифікації (найновіші перші)
$files_with_time = array();
foreach ($files as $file) {
    $files_with_time[$file] = filemtime("$upload_dir/$file");
}
arsort($files_with_time);
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Список файлів</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        .files-list {
            margin-top: 20px;
        }
        .file-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .file-item:hover {
            background-color: #f8f9fa;
        }
        .file-info {
            flex-grow: 1;
        }
        .file-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .file-meta {
            font-size: 0.9em;
            color: #666;
        }
        .file-actions {
            display: flex;
            gap: 10px;
        }
        .file-actions a {
            color: #4CAF50;
            text-decoration: none;
        }
        .file-actions a:hover {
            text-decoration: underline;
        }
        .back-link {
            margin-top: 20px;
        }
        .no-files {
            text-align: center;
            padding: 20px;
            color: #666;
        }
        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-right: 15px;
        }
    </style>
</head>
<body>
    <h2>Список завантажених файлів</h2>
    
    <div class="files-list">
        <?php if (empty($files_with_time)): ?>
            <div class="no-files">
                <p>Файли відсутні</p>
            </div>
        <?php else: ?>
            <?php foreach ($files_with_time as $file => $time): ?>
                <?php
                $file_path = "$upload_dir/$file";
                $file_size = round(filesize($file_path) / 1024, 2); // розмір у КБ
                $file_type = mime_content_type($file_path);
                $modified_date = date("d.m.Y H:i:s", $time);
                ?>
                <div class="file-item">
                    <?php if (strpos($file_type, 'image/') === 0): ?>
                        <img src="<?php echo htmlspecialchars($file_path); ?>" alt="Preview" class="preview-image">
                    <?php endif; ?>
                    <div class="file-info">
                        <div class="file-name"><?php echo htmlspecialchars($file); ?></div>
                        <div class="file-meta">
                            Тип: <?php echo htmlspecialchars($file_type); ?><br>
                            Розмір: <?php echo $file_size; ?> КБ<br>
                            Змінено: <?php echo $modified_date; ?>
                        </div>
                    </div>
                    <div class="file-actions">
                        <a href="<?php echo htmlspecialchars($file_path); ?>" download>Завантажити</a>
                        <?php if (strpos($file_type, 'image/') === 0): ?>
                            <a href="<?php echo htmlspecialchars($file_path); ?>" target="_blank">Переглянути</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="back-link">
        <a href="index.html">← Повернутися на головну</a>
    </div>
</body>
</html>
