<?php
require_once 'config.php';
require_once 'classes/Product.php';
require_once 'classes/DiscountedProduct.php';
require_once 'classes/Category.php';
require_once 'classes/Database.php';

// Встановлення кодування
mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=utf-8');

$db = new Database();
$categories = $db->getCategories();
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Інтернет-магазин</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Інтернет-магазин</h1>

    <div class="row mt-4">
        <?php foreach ($categories as $category): ?>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="h5 mb-0"><?php echo htmlspecialchars($category->getName(), ENT_QUOTES, 'UTF-8'); ?></h2>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            <?php foreach ($category->getProducts() as $product): ?>
                                <div class="list-group-item">
                                    <h3 class="h6"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                                    <p class="mb-1"><?php echo nl2br(htmlspecialchars($product->getInfo(), ENT_QUOTES, 'UTF-8')); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>