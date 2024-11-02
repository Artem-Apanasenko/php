<?php

interface AccountInterface {
    public function deposit(float $amount): void;
    public function withdraw(float $amount): void;
    public function getBalance(): float;
}

class BankAccount implements AccountInterface {
    const MIN_BALANCE = 0;

    protected float $balance;
    protected string $currency;

    public function __construct(float $balance = 0, string $currency = "UAH") {
        $this->balance = max($balance, self::MIN_BALANCE);
        $this->currency = $currency;
    }

    public function deposit(float $amount): void {
        if ($amount <= 0) {
            throw new Exception("Сума для поповнення має бути більшою за нуль.");
        }
        $this->balance += $amount;
    }

    public function withdraw(float $amount): void {
        if ($amount <= 0) {
            throw new Exception("Сума для зняття має бути більшою за нуль.");
        }
        if ($this->balance - $amount < self::MIN_BALANCE) {
            throw new Exception("Недостатньо коштів на рахунку.");
        }
        $this->balance -= $amount;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function getCurrency(): string {
        return $this->currency;
    }
}

class SavingsAccount extends BankAccount {
    public static float $interestRate = 0.05;

    public function applyInterest(): void {
        $this->balance += $this->balance * self::$interestRate;
    }
}

// Тестування функціоналу класів
try {
    $account = new BankAccount(100, "UAH");
    echo "Поточний баланс рахунку: " . $account->getBalance() . " " . $account->getCurrency() . "<br>";

    $account->deposit(50);
    echo "Баланс після поповнення: " . $account->getBalance() . " " . $account->getCurrency() . "<br>";

    $account->withdraw(30);
    echo "Баланс після зняття: " . $account->getBalance() . " " . $account->getCurrency() . "<br>";

    $account->withdraw(200); // Викличе виняток
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "<br>";
}

echo "<br>";

try {
    $savingsAccount = new SavingsAccount(200, "UAH");
    echo "Баланс накопичувального рахунку: " . $savingsAccount->getBalance() . " " . $savingsAccount->getCurrency() . "<br>";

    $savingsAccount->applyInterest();
    echo "Баланс після нарахування відсотків: " . $savingsAccount->getBalance() . " " . $savingsAccount->getCurrency() . "<br>";

    $savingsAccount->withdraw(50);
    echo "Баланс після зняття з накопичувального рахунку: " . $savingsAccount->getBalance() . " " . $savingsAccount->getCurrency() . "<br>";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "<br>";
}
