<?php
// Перевірка методу запиту
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми
    $first_name = $_POST["first_name"] ?? '';
    $last_name = $_POST["last_name"] ?? '';
    
    // Функція для валідації введених даних
    function validateInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    
    // Валідація отриманих даних
    $first_name = validateInput($first_name);
    $last_name = validateInput($last_name);
    
    // Перевірка на пусті значення
    if (empty($first_name) || empty($last_name)) {
        echo "Помилка: всі поля повинні бути заповнені";
    } 
    // Перевірка, що ім'я та прізвище містять тільки літери
    elseif (!preg_match("/^[a-zA-Zа-яА-ЯіІїЇєЄґҐ']+$/u", $first_name) || 
            !preg_match("/^[a-zA-Zа-яА-ЯіІїЇєЄґҐ']+$/u", $last_name)) {
        echo "Помилка: ім'я та прізвище повинні містити тільки літери";
    }
    else {
        // Виведення привітання
        echo "<h2>Вітаємо!</h2>";
        echo "<p>Привіт, $first_name $last_name! Дякуємо за заповнення форми.</p>";
    }
} else {
    // Якщо сторінка відкрита не через POST запит
    echo "Помилка: неправильний метод запиту";
}
?>
