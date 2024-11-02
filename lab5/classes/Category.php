<?php
class Category {
    private string $name;
    private array $products;

    public function __construct(string $name) {
        $this->name = $name;
        $this->products = [];
    }

    public function addProduct(Product $product): void {
        $this->products[] = $product;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getProducts(): array {
        return $this->products;
    }

    public function displayProducts(): string {
        $output = "Категорія: {$this->name}\n";
        $output .= "Список товарів:\n";

        foreach ($this->products as $index => $product) {
            $output .= "\n" . ($index + 1) . ". " . $product->getInfo() . "\n";
        }

        return $output;
    }
}