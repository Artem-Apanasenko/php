<?php
class Product {
    public string $name;
    public string $description;
    protected float $price;

    public function __construct(string $name, float $price, string $description) {
        $this->name = $name;
        $this->setPrice($price);
        $this->description = $description;
    }

    protected function setPrice(float $price): void {
        if ($price < 0) {
            throw new InvalidArgumentException("Ціна не може бути від'ємною");
        }
        $this->price = $price;
    }

    public function getPrice(): float {
        return $this->price;
    }

    public function getInfo(): string {
        return sprintf(
            "Назва: %s\nЦіна: %.2f грн\nОпис: %s",
            $this->name,
            $this->price,
            $this->description
        );
    }
}
