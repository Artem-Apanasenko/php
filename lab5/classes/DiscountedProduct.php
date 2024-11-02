<?php
class DiscountedProduct extends Product {
private float $discount;

public function __construct(string $name, float $price, string $description, float $discount) {
parent::__construct($name, $price, $description);
$this->discount = $discount;
}

public function getDiscountedPrice(): float {
return $this->price * (1 - $this->discount / 100);
}

public function getInfo(): string {
return sprintf(
"Назва: %s\nПочаткова ціна: %.2f грн\nЗнижка: %.2f%%\nЦіна зі знижкою: %.2f грн\nОпис: %s",
$this->name,
$this->price,
$this->discount,
$this->getDiscountedPrice(),
$this->description
);
}
}
