<?php

namespace App\Product;

use InitPHP\CLITable\Table;

class ProductManager
{
    private array $products = [];

    public function getProduct(string $id): ?Product
    {
        return $this->products[$id] ?? null;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function addProduct(Product $product): bool
    {
        $id = $product->getId();
        if (!isset($this->products[$id])) {
            $this->products[$id] = $product;
            return true;
        }
        return false;
    }


    public function changeAmount(string $id, int $amount): bool
    {
        $product = $this->getProduct($id);
        if ($product !== null) {
            $product->setAmount($amount);
            return true;
        }
        return false;
    }

    public function withdrawAmount(string $id, int $amount): bool
    {
        $product = $this->getProduct($id);
        if ($product !== null) {
            $currentAmount = $product->getAmount();
            $updatedAmount = $currentAmount - $amount;

            if ($updatedAmount < 0) {
                return false;
            }

            $product->setAmount($updatedAmount);
            return true;
        }
        return false;
    }

    public function deleteProduct(string $id): bool
    {
        if (isset($this->products[$id])) {
            unset($this->products[$id]);
            return true;
        }
        return false;
    }

    public function displayProducts(): string
    {
        if (count($this->products) !== 0) {
            $table = new Table();

            foreach ($this->products as $product) {
                $createdAtUTC = $product->getCreatedAt();
                $lastUpdatedAtUTC = $product->getLastUpdatedAt();
                $qualityExpirationDateUTC = $product->getQualityExpirationDate();

                $createdAtLocal = $createdAtUTC->setTimezone('Europe/Riga')->format('d-m-Y H:i:s');
                $lastUpdatedAtLocal = $lastUpdatedAtUTC ? $lastUpdatedAtUTC->setTimezone('Europe/Riga')->format('d-m-Y H:i:s') : '[NULL]';
                $qualityExpirationDateLocal = $qualityExpirationDateUTC ? $qualityExpirationDateUTC->setTimezone('Europe/Riga')->format('d-m-Y H:i:s') : '[NULL]';

                $table->row([
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'amount' => $product->getAmount(),
                    'price' => $product->getPrice(),
                    'quality expiration date' => $qualityExpirationDateLocal,
                    'created at' => $createdAtLocal,
                    'last updated at' => $lastUpdatedAtLocal,
                ]);
            }

            return $table;
        }
        return "No products to display!\n";
    }
}