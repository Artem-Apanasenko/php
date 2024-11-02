<?php
session_start();

// Initialize shopping cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Handle adding items to cart
if (isset($_POST['add_item'])) {
    $item = $_POST['item'];
    $_SESSION['cart'][] = $item;

    // Save to cookies (previous purchases)
    $previous_purchases = isset($_COOKIE['previous_purchases'])
        ? json_decode($_COOKIE['previous_purchases'], true)
        : array();

    if (!in_array($item, $previous_purchases)) {
        $previous_purchases[] = $item;
        setcookie('previous_purchases', json_encode($previous_purchases), time() + (30 * 24 * 60 * 60));
    }
}

// Clear cart
if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = array();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart</title>
</head>
<body>
<h2>Add Item to Cart</h2>
<form method="POST">
    <select name="item">
        <option value="Book">Book</option>
        <option value="Phone">Phone</option>
        <option value="Laptop">Laptop</option>
    </select>
    <input type="submit" name="add_item" value="Add to Cart">
</form>

<h3>Current Cart:</h3>
<ul>
    <?php foreach ($_SESSION['cart'] as $item): ?>
        <li><?php echo htmlspecialchars($item); ?></li>
    <?php endforeach; ?>
</ul>

<h3>Previous Purchases:</h3>
<ul>
    <?php
    if (isset($_COOKIE['previous_purchases'])) {
        foreach (json_decode($_COOKIE['previous_purchases'], true) as $item) {
            echo "<li>" . htmlspecialchars($item) . "</li>";
        }
    }
    ?>
</ul>

<form method="POST">
    <input type="submit" name="clear_cart" value="Clear Cart">
</form>
</body>
</html>