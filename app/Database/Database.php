<?php

namespace App\Database;

use App\Product\Product;
use Carbon\Carbon;
use Exception;
use Ramsey\Uuid\Uuid;

class Database
{
    public static function saveData(string $user, array $data): void
    {
        file_put_contents("data/$user.json", json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function loadData(string $user): array
    {
        try {
            if (file_exists("data/$user.json")) {
                $productData = json_decode(file_get_contents("data/$user.json"), true);
                $data = [];

                foreach ($productData as $product) {
                    if (!self::isUuid($product['id'])) {
                        $product['id'] = Uuid::uuid4()->toString();
                    }
                    $data[$product['id']] = new Product(
                        $product['name'],
                        $product['amount'],
                        $product['price'] ?? null,
                        $product['qualityExpirationDate'] ? Carbon::parse($product['qualityExpirationDate']) : null,
                        Carbon::parse($product['createdAt']),
                        $product['lastUpdatedAt'] ? Carbon::parse($product['lastUpdatedAt']) : null,
                        $product["id"]
                    );
                }

                self::saveData($user, $productData);

                return $data;
            } else {
                throw new Exception("Products not found, add a product first!");
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . PHP_EOL;
        }
        return [];
    }

    private static function isUuid($id): bool
    {
        return Uuid::isValid($id);
    }
}