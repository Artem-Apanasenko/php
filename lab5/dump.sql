-- MySQL dump
CREATE DATABASE IF NOT EXISTS shop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shop_db;

-- Таблиця категорій
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Таблиця товарів
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT,
    category_id INT,
    discount DECIMAL(5, 2) DEFAULT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Додавання тестових даних
INSERT INTO categories (name) VALUES
   ('Electronics'),
   ('Accessories');

INSERT INTO products (name, price, description, category_id, discount) VALUES
   ('Laptop', 25000.00, 'Powerful laptop for work', 1, NULL),
   ('Smartphone', 12000.00, 'Modern smartphone with a good camera', 1, NULL),
   ('Tablet', 15000.00, 'Tablet for entertainment and work', 1, 15.00),
   ('Headphones', 3000.00, 'Wireless headphones', 2, 20.00);






