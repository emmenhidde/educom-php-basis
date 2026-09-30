<?php

class ShoppingCart
{
    private array $items;

    public function __construct(array $items = []){
        $this->items = $items;
    }

    public function addToCart(string $product, float $price, int $amount = 1): void
    {
        if ($amount < 1) {
            return;
        }

        if (isset($this->items[$product])) {
            $this->items[$product]['amount'] += $amount;
        } else {
            $this->items[$product] = [
                'amount' => $amount,
                'price' => $price
            ];
        }
    }

    public function getCart(): array
    {
        return $this->items;
    }
}