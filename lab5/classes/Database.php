<?php
class Database {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
                DB_USER,
                DB_PASS,
                [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_LOCAL_INFILE => true
                ]
            );
        } catch (PDOException $e) {
            die("Помилка підключення до бази даних: " . $e->getMessage());
        }
    }

    public function getCategories(): array {
        $categories = [];

        $stmt = $this->pdo->query("SELECT * FROM categories");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $category = new Category($row['name']);

            // Отримуємо товари для категорії
            $products = $this->getProductsByCategory($row['id']);
            foreach ($products as $product) {
                $category->addProduct($product);
            }

            $categories[] = $category;
        }

        return $categories;
    }

    private function getProductsByCategory(int $categoryId): array {
        $products = [];

        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE category_id = ?");
        $stmt->execute([$categoryId]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['discount'] !== null) {
                $products[] = new DiscountedProduct(
                    $row['name'],
                    $row['price'],
                    $row['description'],
                    $row['discount']
                );
            } else {
                $products[] = new Product(
                    $row['name'],
                    $row['price'],
                    $row['description']
                );
            }
        }

        return $products;
    }
}